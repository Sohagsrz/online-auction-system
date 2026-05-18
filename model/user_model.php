<?php
// model/user_model.php

function get_user_by_email($conn, $email) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND is_active = 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function get_user_by_id($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function create_user($conn, $name, $email, $password, $role = 'buyer') {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $hash, $role);
    return $stmt->execute();
}

function get_all_users($conn) {
    $result = $conn->query("SELECT * FROM users");
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    return $users;
}

function update_user_status($conn, $id, $is_active) {
    $stmt = $conn->prepare("UPDATE users SET is_active = ? WHERE id = ?");
    $stmt->bind_param("ii", $is_active, $id);
    return $stmt->execute();
}

function set_seller_verified($conn, $id, $is_verified) {
    $stmt = $conn->prepare("UPDATE users SET seller_verified = ? WHERE id = ?");
    $stmt->bind_param("ii", $is_verified, $id);
    return $stmt->execute();
}

function update_seller_verification_request($conn, $id, $status, $reviewed_by) {
    $stmt = $conn->prepare("UPDATE seller_verification_requests SET status = ?, reviewed_by = ? WHERE id = ?");
    $stmt->bind_param("sii", $status, $reviewed_by, $id);
    return $stmt->execute();
}
?>
