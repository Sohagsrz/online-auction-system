<?php
// model/category_model.php

function get_all_categories($conn) {
    $result = $conn->query("SELECT * FROM categories ORDER BY name ASC");
    $categories = [];
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
    return $categories;
}

function get_category_by_id($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function create_category($conn, $name, $description, $parent_id = null) {
    $stmt = $conn->prepare("INSERT INTO categories (name, description, parent_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $name, $description, $parent_id);
    return $stmt->execute();
}

function update_category($conn, $id, $name, $description, $parent_id = null) {
    $stmt = $conn->prepare("UPDATE categories SET name = ?, description = ?, parent_id = ? WHERE id = ?");
    $stmt->bind_param("ssii", $name, $description, $parent_id, $id);
    return $stmt->execute();
}

function delete_category($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}
?>
