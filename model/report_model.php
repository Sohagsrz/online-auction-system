<?php
// model/report_model.php

function create_listing_report($conn, $listing_id, $reporter_id, $reason, $description) {
    $stmt = $conn->prepare("INSERT INTO listing_reports (listing_id, reporter_id, reason, description) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $listing_id, $reporter_id, $reason, $description);
    return $stmt->execute();
}

function get_all_listing_reports($conn) {
    $result = $conn->query("SELECT * FROM listing_reports ORDER BY created_at DESC");
    $reports = [];
    while ($row = $result->fetch_assoc()) {
        $reports[] = $row;
    }
    return $reports;
}

function update_listing_report_status($conn, $id, $status, $moderator_note) {
    $stmt = $conn->prepare("UPDATE listing_reports SET status = ?, moderator_note = ? WHERE id = ?");
    $stmt->bind_param("ssi", $status, $moderator_note, $id);
    return $stmt->execute();
}

function create_user_report($conn, $reporter_id, $reported_user_id, $reason, $description) {
    $stmt = $conn->prepare("INSERT INTO user_reports (reporter_id, reported_user_id, reason, description) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $reporter_id, $reported_user_id, $reason, $description);
    return $stmt->execute();
}

function get_all_user_reports($conn) {
    $result = $conn->query("SELECT * FROM user_reports ORDER BY created_at DESC");
    $reports = [];
    while ($row = $result->fetch_assoc()) {
        $reports[] = $row;
    }
    return $reports;
}
?>
