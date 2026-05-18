<?php
session_start();
require_once 'database/db.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

switch($page) {
    // Auth & Profile Routes
    case 'home':
    case 'login':
    case 'register':
    case 'logout':
    case 'profile':
        require_once 'controller/AuthController.php';
        auth_handle_request($page);
        break;

    // Buyer Routes
    case 'buyer_dashboard':
    case 'buyer_browse':
    case 'buyer_watchlist':
    case 'buyer_bids':
        require_once 'controller/BuyerController.php';
        buyer_handle_request($page);
        break;

    // Seller Routes
    case 'seller_dashboard':
    case 'seller_listings':
    case 'seller_create':
    case 'seller_analytics':
    case 'seller_verification':
        require_once 'controller/SellerController.php';
        seller_handle_request($page);
        break;

    // Moderator Routes
    case 'moderator_dashboard':
    case 'mod_listings':
    case 'mod_reports':
    case 'mod_categories':
        require_once 'controller/ModeratorController.php';
        mod_handle_request($page);
        break;

    // Admin Routes
    case 'admin_dashboard':
    case 'admin_users':
    case 'admin_sellers':
    case 'admin_reports':
        require_once 'controller/AdminController.php';
        admin_handle_request($page);
        break;

    default:
        http_response_code(404);
        echo "404 - Page Not Found";
        break;
}
?>
