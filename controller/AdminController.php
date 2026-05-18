<?php
require_once 'model/user_model.php';

function admin_check_auth() {
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header("Location: index.php?page=login");
        exit();
    }
}

function admin_handle_request($page) {
    admin_check_auth();
    switch($page) {
        case 'admin_users':
            admin_users();
            break;
        case 'admin_sellers':
            admin_sellers();
            break;
        case 'admin_reports':
            admin_reports();
            break;
        case 'admin_dashboard':
        default:
            admin_dashboard();
            break;
    }
}

function admin_dashboard() {
    global $conn;
    
    // Total users by role
    $roles_res = $conn->query("SELECT role, COUNT(*) as count FROM users GROUP BY role");
    $user_counts = [];
    while($row = $roles_res->fetch_assoc()) $user_counts[$row['role']] = $row['count'];
    
    // Active listings
    $active_listings = $conn->query("SELECT COUNT(*) FROM listings WHERE status = 'active'")->fetch_row()[0];
    
    // Bids today
    $bids_today = $conn->query("SELECT COUNT(*) FROM bids WHERE DATE(created_at) = CURDATE()")->fetch_row()[0];
    
    // Commission this month
    $commission = $conn->query("SELECT SUM(commission_amount) FROM platform_fees WHERE MONTH(created_at) = MONTH(CURDATE())")->fetch_row()[0] ?? 0;
    
    // Pending verifications
    $pending_verifs = $conn->query("SELECT COUNT(*) FROM seller_verification_requests WHERE status = 'pending'")->fetch_row()[0];

    require 'view/admin/dashboard.php';
}

function admin_users() {
    global $conn; 
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'toggle_status') {
        $user_id = $_POST['user_id'];
        $new_status = $_POST['status'];
        update_user_status($conn, $user_id, $new_status);
        echo json_encode(['success' => true]);
        exit();
    }

    $users = get_all_users($conn);
    require 'view/admin/users.php';
}

function admin_sellers() {
    global $conn;
    // Fetch seller requests
    $result = $conn->query("SELECT svr.*, u.name as user_name, u.email FROM seller_verification_requests svr JOIN users u ON svr.user_id = u.id");
    $requests = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) $requests[] = $row;
    }
    require 'view/admin/sellers.php';
}

function admin_reports() {
    global $conn;
    // Fetch platform fees for reporting
    $result = $conn->query("SELECT * FROM platform_fees");
    $fees = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) $fees[] = $row;
    }
    require 'view/admin/reports.php';
}
?>
