<?php

function auth_handle_request($page) {
    switch($page) {
        case 'login':
            auth_login();
            break;
        case 'register':
            auth_register();
            break;
        case 'logout':
            auth_logout();
            break;
        case 'profile':
            auth_profile();
            break;
        case 'home':
        default:
            require 'view/auth/login.php';
            break;
    }
}

function auth_login() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        global $conn; // using the one from db.php included in index.php
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT id, name, role, password_hash FROM users WHERE email = ? AND is_active = 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            if (password_verify($password, $user['password_hash'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['name'] = $user['name'];

                // Redirect based on role
                header("Location: index.php?page=" . $user['role'] . "_dashboard");
                exit();
            } else {
                $error = "Invalid credentials";
            }
        } else {
            $error = "Invalid credentials";
        }
    }
    require 'view/auth/login.php';
}

function auth_register() {
    // Basic Registration logic
    require 'view/auth/register.php';
}

function auth_logout() {
    session_destroy();
    header("Location: index.php?page=login");
    exit();
}

function auth_profile() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php?page=login");
        exit();
    }
    
    global $conn;
    $user_id = $_SESSION['user_id'];
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $bio = $_POST['bio'];
        
        $profile_pic = null;
        if (!empty($_FILES['profile_pic']['name']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
            if (!is_dir('assets/uploads')) mkdir('assets/uploads', 0777, true);
            $ext = pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION);
            $filename = 'assets/uploads/user_' . $user_id . '_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $filename)) {
                $profile_pic = $filename;
            }
        }
        
        if ($profile_pic) {
            $stmt = $conn->prepare("UPDATE users SET name = ?, phone = ?, bio = ?, profile_pic = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $name, $phone, $bio, $profile_pic, $user_id);
        } else {
            $stmt = $conn->prepare("UPDATE users SET name = ?, phone = ?, bio = ? WHERE id = ?");
            $stmt->bind_param("sssi", $name, $phone, $bio, $user_id);
        }
        
        if ($stmt->execute()) {
            $_SESSION['name'] = $name;
            $success = "Profile updated successfully!";
        } else {
            $error = "Failed to update profile.";
        }
    }
    
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    
    // Fetch reviews received
    $stmt = $conn->prepare("SELECT r.*, u.name as reviewer_name FROM reviews r JOIN users u ON r.reviewer_id = u.id WHERE r.reviewee_id = ? ORDER BY r.created_at DESC");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $reviews = [];
    while ($row = $result->fetch_assoc()) $reviews[] = $row;
    
    require 'view/auth/profile.php';
}
?>
