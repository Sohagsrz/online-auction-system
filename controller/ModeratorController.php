<?php
require_once 'model/listing_model.php';
require_once 'model/category_model.php';
require_once 'model/report_model.php';

function mod_check_auth() {
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'moderator') {
        header("Location: index.php?page=login");
        exit();
    }
}

function mod_handle_request($page) {
    mod_check_auth();
    switch($page) {
        case 'mod_listings':
            mod_listings();
            break;
        case 'mod_reports':
            mod_reports();
            break;
        case 'mod_categories':
            mod_categories();
            break;
        case 'moderator_dashboard':
        default:
            mod_dashboard();
            break;
    }
}

function mod_dashboard() {
    global $conn;

    $pending_listings = $conn->query("SELECT COUNT(*) FROM listings WHERE status = 'pending_review'")->fetch_row()[0];
    $open_list_reports = $conn->query("SELECT COUNT(*) FROM listing_reports WHERE status = 'pending'")->fetch_row()[0];
    $open_user_reports = $conn->query("SELECT COUNT(*) FROM user_reports WHERE status = 'pending'")->fetch_row()[0];
    
    // Warnings issued this week
    $warnings_this_week = $conn->query("SELECT COUNT(*) FROM warnings WHERE YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)")->fetch_row()[0];

    require 'view/moderator/dashboard.php';
}

function mod_listings() {
    global $conn;

    // AJAX Handler for Approve/Reject
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
        $listing_id = $_POST['listing_id'];
        $status = $_POST['action'] === 'approve' ? 'active' : 'cancelled';
        update_listing_status($conn, $listing_id, $status);
        echo json_encode(['success' => true]);
        exit();
    }

    $pending_listings = get_pending_listings($conn);
    require 'view/moderator/listings.php';
}

function mod_reports() {
    global $conn;
    $listing_reports = get_all_listing_reports($conn);
    $user_reports = get_all_user_reports($conn);
    require 'view/moderator/reports.php';
}

function mod_categories() {
    global $conn;

    $message = '';
    $error = '';
    $edit_category = null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
        $action = $_POST['action'];
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $parent_id = isset($_POST['parent_id']) && $_POST['parent_id'] !== '' ? intval($_POST['parent_id']) : null;

        if ($action === 'create_category') {
            if ($name === '') {
                $error = 'Category name is required.';
            } else {
                if (create_category($conn, $name, $description, $parent_id)) {
                    $message = 'Category created successfully.';
                } else {
                    $error = 'Failed to create category: ' . $conn->error;
                }
            }
        } elseif ($action === 'update_category') {
            $category_id = intval($_POST['category_id'] ?? 0);
            if ($category_id <= 0 || $name === '') {
                $error = 'Valid category and name are required.';
            } else {
                if (update_category($conn, $category_id, $name, $description, $parent_id)) {
                    $message = 'Category updated successfully.';
                } else {
                    $error = 'Failed to update category: ' . $conn->error;
                }
            }
        } elseif ($action === 'delete_category') {
            $category_id = intval($_POST['category_id'] ?? 0);
            if ($category_id <= 0) {
                $error = 'Valid category is required.';
            } elseif (category_has_children($conn, $category_id)) {
                $error = 'Cannot delete category because it has child categories.';
            } elseif (category_has_listings($conn, $category_id)) {
                $error = 'Cannot delete category because it is used by one or more listings.';
            } else {
                if (delete_category($conn, $category_id)) {
                    $message = 'Category deleted successfully.';
                } else {
                    $error = 'Failed to delete category: ' . $conn->error;
                }
            }
        }
    }

    if (isset($_GET['edit_id'])) {
        $edit_id = intval($_GET['edit_id']);
        if ($edit_id > 0) {
            $edit_category = get_category_by_id($conn, $edit_id);
        }
    }

    $categories = get_all_categories($conn);
    require 'view/moderator/categories.php';
}
?>
