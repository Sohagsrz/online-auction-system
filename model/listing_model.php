<?php
// model/listing_model.php

function create_listing($conn, $seller_id, $category_id, $title, $description, $condition, $starting_price, $reserve_price, $end_datetime) {
    $stmt = $conn->prepare("INSERT INTO listings (seller_id, category_id, title, description, item_condition, starting_price, reserve_price, current_bid, end_datetime) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $current_bid = $starting_price;
    $stmt->bind_param("iisssddds", $seller_id, $category_id, $title, $description, $condition, $starting_price, $reserve_price, $current_bid, $end_datetime);
    return $stmt->execute();
}

function get_listing_by_id($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM listings WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function get_active_listings($conn) {
    $result = $conn->query("SELECT * FROM listings WHERE status = 'active' AND end_datetime > NOW()");
    $listings = [];
    while ($row = $result->fetch_assoc()) {
        $listings[] = $row;
    }
    return $listings;
}

function get_seller_listings($conn, $seller_id) {
    $stmt = $conn->prepare("SELECT * FROM listings WHERE seller_id = ?");
    $stmt->bind_param("i", $seller_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $listings = [];
    while ($row = $result->fetch_assoc()) {
        $listings[] = $row;
    }
    return $listings;
}

function get_pending_listings($conn) {
    $result = $conn->query("SELECT * FROM listings WHERE status = 'pending_review'");
    $listings = [];
    while ($row = $result->fetch_assoc()) {
        $listings[] = $row;
    }
    return $listings;
}

function update_listing_status($conn, $id, $status) {
    $stmt = $conn->prepare("UPDATE listings SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    return $stmt->execute();
}
?>
