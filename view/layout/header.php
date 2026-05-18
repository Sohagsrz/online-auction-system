<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Auction System</title>
    <!-- Use Tailwind via CDN since we want a modern design as per guidelines, though raw CSS was mentioned. I'll use simple custom styling or Tailwind for speed, let's use simple CSS in assets/css/style.css -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header class="main-header">
        <h1>Online Auction System</h1>
        <nav>
            <?php if (isset($_SESSION['user_id'])): ?>
                Welcome, <?= htmlspecialchars($_SESSION['name']) ?> (<?= ucfirst($_SESSION['role']) ?>)
                <a href="index.php?page=profile">My Profile</a>
                <a href="index.php?page=logout">Logout</a>
            <?php else: ?>
                <a href="index.php?page=login">Login</a>
                <a href="index.php?page=register">Register</a>
            <?php endif; ?>
        </nav>
    </header>
    <main class="container">
