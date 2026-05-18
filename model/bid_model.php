<?php
// model/bid_model.php

function place_bid($conn, $listing_id, $buyer_id, $amount, $is_auto_bid = false) {
    // Basic logic without transaction for simplicity, normally would use transactions
    $stmt = $conn->prepare("INSERT INTO bids (listing_id, buyer_id, amount, is_auto_bid) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iidi", $listing_id, $buyer_id, $amount, $is_auto_bid);
    if ($stmt->execute()) {
        $bid_id = $stmt->insert_id;
        // Update current bid on listing
        $stmt2 = $conn->prepare("UPDATE listings SET current_bid = ?, winner_bid_id = ? WHERE id = ?");
        $stmt2->bind_param("dii", $amount, $bid_id, $listing_id);
        $stmt2->execute();
        return true;
    }
    return false;
}

function get_bids_by_listing($conn, $listing_id) {
    $stmt = $conn->prepare("SELECT * FROM bids WHERE listing_id = ? ORDER BY amount DESC");
    $stmt->bind_param("i", $listing_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $bids = [];
    while ($row = $result->fetch_assoc()) {
        $bids[] = $row;
    }
    return $bids;
}

function get_bids_by_buyer($conn, $buyer_id) {
    $stmt = $conn->prepare("SELECT * FROM bids WHERE buyer_id = ? ORDER BY created_at DESC");
    $stmt->bind_param("i", $buyer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $bids = [];
    while ($row = $result->fetch_assoc()) {
        $bids[] = $row;
    }
    return $bids;
}
?>
