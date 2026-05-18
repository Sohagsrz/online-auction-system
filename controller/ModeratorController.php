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
    $categories = get_all_categories($conn);
    require 'view/moderator/categories.php';
}
?>
