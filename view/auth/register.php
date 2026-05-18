<?php require_once 'view/layout/header.php'; ?>

<div class="auth-container">
    <h2>Register</h2>
    <form action="index.php?page=register" method="POST">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn">Register</button>
    </form>
</div>

<?php require_once 'view/layout/footer.php'; ?>
