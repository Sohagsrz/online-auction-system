<?php
require_once 'model/listing_model.php';

function buyer_check_auth() {
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'buyer') {
        header("Location: index.php?page=login");
        exit();
    }
}

function buyer_handle_request($page) {
    buyer_check_auth();
    switch($page) {
        case 'buyer_browse':
            buyer_browse();
            break;
        case 'buyer_watchlist':
            buyer_watchlist();
            break;
        case 'buyer_bids':
            buyer_bids();
            break;
        case 'buyer_report':
            buyer_report();
            break;
        case 'buyer_review':
            buyer_review();
            break;
        case 'buyer_dashboard':
        default:
            buyer_dashboard();
            break;
    }
}

function buyer_dashboard() {
    global $conn;
    $buyer_id = $_SESSION['user_id'];
    $notifications = [];

    // Auctions won
    $res = $conn->query("SELECT title FROM listings WHERE winner_bid_id IN (SELECT id FROM bids WHERE buyer_id = $buyer_id) AND status = 'ended'");
    while($row = $res->fetch_assoc()) {
        $notifications[] = "You won the auction for '{$row['title']}'!";
    }

    // Outbid alerts (where the buyer bid, but is not the current highest bid)
    $res = $conn->query("SELECT l.title FROM listings l JOIN bids b ON l.id = b.listing_id WHERE b.buyer_id = $buyer_id AND l.current_bid > b.amount AND l.status = 'active' GROUP BY l.id");
    while($row = $res->fetch_assoc()) {
        $notifications[] = "You have been outbid on '{$row['title']}'!";
    }

    // Ending soon (active listings this buyer bid on or watches, ending in less than 24 hours just for demo purposes since 1 hour is tight)
    $res = $conn->query("SELECT l.title FROM listings l JOIN watchlist w ON l.id = w.listing_id WHERE w.buyer_id = $buyer_id AND l.status = 'active' AND l.end_datetime BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 24 HOUR)");
    while($row = $res->fetch_assoc()) {
        $notifications[] = "Watchlist item '{$row['title']}' is ending soon!";
    }

    require 'view/buyer/dashboard.php';
}

function buyer_browse() {
    global $conn;

    // AJAX Handler for Bidding
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'bid') {
        require_once 'model/bid_model.php';
        $listing_id = $_POST['listing_id'];
        $amount = $_POST['amount'];
        
        // Basic validation
        $listing = get_listing_by_id($conn, $listing_id);
        if ($amount > $listing['current_bid']) {
            place_bid($conn, $listing_id, $_SESSION['user_id'], $amount);
            echo json_encode(['success' => true, 'new_bid' => $amount]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Bid must be higher than current bid.']);
        }
        exit();
    }

    // Fetch all listings and their first image
    $res = $conn->query("
        SELECT l.*, 
        (SELECT image_path FROM listing_images WHERE listing_id = l.id ORDER BY display_order ASC LIMIT 1) as main_image 
        FROM listings l WHERE status = 'active'
    ");
    $listings = [];
    if ($res) {
        while ($row = $res->fetch_assoc()) $listings[] = $row;
    }
    
    require 'view/buyer/browse.php';
}

function buyer_watchlist() {
    global $conn;
    $buyer_id = $_SESSION['user_id'];
    
    // Fetch watchlist listings
    $stmt = $conn->prepare("SELECT l.* FROM watchlist w JOIN listings l ON w.listing_id = l.id WHERE w.buyer_id = ?");
    $stmt->bind_param("i", $buyer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $watchlist_items = [];
    while ($row = $result->fetch_assoc()) {
        $watchlist_items[] = $row;
    }
    
    require 'view/buyer/watchlist.php';
}

function buyer_bids() {
    global $conn;
    $buyer_id = $_SESSION['user_id'];
    
    // Fetch bids history for this buyer
    $stmt = $conn->prepare("SELECT b.*, l.title, l.status as listing_status, l.winner_bid_id FROM bids b JOIN listings l ON b.listing_id = l.id WHERE b.buyer_id = ? ORDER BY b.created_at DESC");
    $stmt->bind_param("i", $buyer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $bids = [];
    while ($row = $result->fetch_assoc()) {
        $bids[] = $row;
    }

    require 'view/buyer/bids.php';
}

function buyer_report() {
    global $conn;
    $buyer_id = $_SESSION['user_id'];
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $listing_id = $_POST['listing_id'];
        $reason = $_POST['reason'];
        $description = $_POST['description'];
        
        $stmt = $conn->prepare("INSERT INTO listing_reports (listing_id, reporter_id, reason, description, status) VALUES (?, ?, ?, ?, 'pending')");
        $stmt->bind_param("iiss", $listing_id, $buyer_id, $reason, $description);
        
        if ($stmt->execute()) {
            $success = "Report submitted successfully. A moderator will review it.";
        }
    }
    
    $listing_id = $_GET['listing_id'] ?? 0;
    require 'view/buyer/report.php';
}

function buyer_review() {
    global $conn;
    $buyer_id = $_SESSION['user_id'];
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $listing_id = $_POST['listing_id'];
        $seller_id = $_POST['seller_id'];
        $rating = $_POST['rating'];
        $review_text = $_POST['review_text'];
        
        $stmt = $conn->prepare("INSERT INTO reviews (listing_id, reviewer_id, reviewee_id, rating, review_text) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiis", $listing_id, $buyer_id, $seller_id, $rating, $review_text);
        
        if ($stmt->execute()) {
            $success = "Review submitted successfully!";
        }
    }
    
    $listing_id = $_GET['listing_id'] ?? 0;
    $seller_id = $_GET['seller_id'] ?? 0;
    require 'view/buyer/review.php';
}
?>
