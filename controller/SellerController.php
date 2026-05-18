<?php
require_once 'model/listing_model.php';
require_once 'model/user_model.php';

function seller_check_auth() {
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
        header("Location: index.php?page=login");
        exit();
    }
}

function seller_handle_request($page) {
    seller_check_auth();
    switch($page) {
        case 'seller_listings':
            seller_listings();
            break;
        case 'seller_create':
            seller_create();
            break;
        case 'seller_analytics':
            seller_analytics();
            break;
        case 'seller_verification':
            seller_verification();
            break;
        case 'seller_dashboard':
        default:
            seller_dashboard();
            break;
    }
}

function seller_dashboard() {
    global $conn;
    $seller_id = $_SESSION['user_id'];
    
    $res = $conn->prepare("SELECT seller_verified FROM users WHERE id = ?");
    $res->bind_param("i", $seller_id);
    $res->execute();
    $is_verified = $res->get_result()->fetch_assoc()['seller_verified'] ?? 0;

    $stmt = $conn->prepare("SELECT * FROM seller_verification_requests WHERE user_id = ? ORDER BY submitted_at DESC LIMIT 1");
    $stmt->bind_param("i", $seller_id);
    $stmt->execute();
    $verification_request = $stmt->get_result()->fetch_assoc();

    require 'view/seller/dashboard.php';
}

function seller_verification() {
    global $conn;
    $seller_id = $_SESSION['user_id'];
    $message = '';
    $error = '';

    $stmt = $conn->prepare("SELECT seller_verified FROM users WHERE id = ?");
    $stmt->bind_param("i", $seller_id);
    $stmt->execute();
    $is_verified = $stmt->get_result()->fetch_assoc()['seller_verified'] ?? 0;

    $stmt = $conn->prepare("SELECT * FROM seller_verification_requests WHERE user_id = ? ORDER BY submitted_at DESC LIMIT 1");
    $stmt->bind_param("i", $seller_id);
    $stmt->execute();
    $verification_request = $stmt->get_result()->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($is_verified) {
            $error = 'Your seller account is already verified.';
        } elseif (!empty($verification_request) && $verification_request['status'] === 'pending') {
            $error = 'You already have a pending verification request. Please wait for admin review.';
        } else {
            $motivation = trim($_POST['motivation'] ?? '');
            if (empty($motivation)) {
                $error = 'Please provide a motivation for verification.';
            } elseif (empty($_FILES['id_document']['name']) || $_FILES['id_document']['error'] !== UPLOAD_ERR_OK) {
                $error = 'Please upload a valid verification document.';
            } else {
                if (!is_dir('assets/uploads/verification_docs')) {
                    mkdir('assets/uploads/verification_docs', 0777, true);
                }
                $ext = pathinfo($_FILES['id_document']['name'], PATHINFO_EXTENSION);
                $filename = 'assets/uploads/verification_docs/seller_' . $seller_id . '_' . time() . '.' . $ext;
                if (move_uploaded_file($_FILES['id_document']['tmp_name'], $filename)) {
                    if (create_seller_verification_request($conn, $seller_id, $motivation, $filename)) {
                        $message = 'Verification request submitted successfully. Please wait for admin approval.';
                        $verification_request = get_latest_seller_verification_request($conn, $seller_id);
                    } else {
                        $error = 'Failed to save verification request. Please try again.';
                    }
                } else {
                    $error = 'Failed to upload document. Please try again.';
                }
            }
        }
    }

    require 'view/seller/verification.php';
}

function seller_listings() {
    global $conn;

    // AJAX Handler for Live Bids
    if (isset($_GET['ajax']) && $_GET['ajax'] === 'live_bids' && isset($_GET['listing_id'])) {
        require_once 'model/bid_model.php';
        $listing_id = $_GET['listing_id'];
        
        // Join bids with users to get bidder names
        $stmt = $conn->prepare("SELECT b.amount, b.created_at, u.name as bidder_name FROM bids b JOIN users u ON b.buyer_id = u.id WHERE b.listing_id = ? ORDER BY b.amount DESC");
        $stmt->bind_param("i", $listing_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $bids = [];
        while ($row = $result->fetch_assoc()) {
            $bids[] = $row;
        }
        
        echo json_encode(['success' => true, 'bids' => $bids]);
        exit();
    }

    $listings = get_seller_listings($conn, $_SESSION['user_id']);
    require 'view/seller/listings.php';
}

function seller_create() {
    global $conn;
    $seller_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT seller_verified FROM users WHERE id = ?");
    $stmt->bind_param("i", $seller_id);
    $stmt->execute();
    $is_verified = $stmt->get_result()->fetch_assoc()['seller_verified'] ?? 0;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!$is_verified) {
            $error = 'You must complete seller verification before creating a listing.';
        } else {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $category_id = $_POST['category_id'];
            $item_condition = $_POST['item_condition'];
            $starting_price = $_POST['starting_price'];
            $reserve_price = $_POST['reserve_price'] ?: null;
            $end_datetime = $_POST['end_datetime'];
            
            $stmt = $conn->prepare("INSERT INTO listings (seller_id, category_id, title, description, item_condition, starting_price, reserve_price, current_bid, end_datetime, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending_review')");
            $stmt->bind_param("iisssddds", $seller_id, $category_id, $title, $description, $item_condition, $starting_price, $reserve_price, $starting_price, $end_datetime);
            
            if ($stmt->execute()) {
                $listing_id = $conn->insert_id;
                
                // Handle image uploads
                if (!empty($_FILES['images']['name'][0])) {
                    if (!is_dir('assets/uploads')) mkdir('assets/uploads', 0777, true);
                    
                    $uploaded_count = 0;
                    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                        if ($uploaded_count >= 5) break; // Max 5 images
                        if ($_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {
                            $ext = pathinfo($_FILES['images']['name'][$key], PATHINFO_EXTENSION);
                            $filename = 'assets/uploads/listing_' . $listing_id . '_' . $key . '_' . time() . '.' . $ext;
                            if (move_uploaded_file($tmp_name, $filename)) {
                                $img_stmt = $conn->prepare("INSERT INTO listing_images (listing_id, image_path, display_order) VALUES (?, ?, ?)");
                                $img_stmt->bind_param("isi", $listing_id, $filename, $key);
                                $img_stmt->execute();
                                $uploaded_count++;
                            }
                        }
                    }
                }
                
                header("Location: index.php?page=seller_listings");
                exit();
            } else {
                $error = "Failed to create listing.";
            }
        }
    }
    
    // Fetch categories for dropdown
    $res = $conn->query("SELECT id, name FROM categories");
    $categories = [];
    if ($res) {
        while ($row = $res->fetch_assoc()) $categories[] = $row;
    }
    
    require 'view/seller/create.php';
}

function seller_analytics() {
    global $conn;
    $seller_id = $_SESSION['user_id'];
    
    // Total auctions created
    $res = $conn->query("SELECT COUNT(*) as total FROM listings WHERE seller_id = $seller_id");
    $total_auctions = $res->fetch_assoc()['total'];
    
    // Total auctions won (ended with a winner)
    $res = $conn->query("SELECT COUNT(*) as won FROM listings WHERE seller_id = $seller_id AND status = 'ended' AND winner_bid_id IS NOT NULL");
    $total_won = $res->fetch_assoc()['won'];
    
    // Total revenue & Average sale price
    $res = $conn->query("SELECT SUM(current_bid) as revenue, AVG(current_bid) as avg_price FROM listings WHERE seller_id = $seller_id AND status = 'ended' AND winner_bid_id IS NOT NULL");
    $row = $res->fetch_assoc();
    $total_revenue = $row['revenue'] ?? 0;
    $avg_price = $row['avg_price'] ?? 0;
    
    // Most popular category
    $res = $conn->query("SELECT c.name, COUNT(l.id) as count FROM listings l JOIN categories c ON l.category_id = c.id WHERE l.seller_id = $seller_id GROUP BY c.id ORDER BY count DESC LIMIT 1");
    $pop = $res->fetch_assoc();
    $popular_category = $pop ? $pop['name'] : 'N/A';

    require 'view/seller/analytics.php';
}
?>
