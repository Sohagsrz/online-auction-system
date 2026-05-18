<?php require_once 'view/layout/header.php'; ?>

<div class="auth-container">
    <h2>Login</h2>
    <?php if (isset($error)): ?>
        <p class="error" style="color: red; margin-bottom: 1rem;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <?php if (isset($_GET['registered']) && $_GET['registered'] === 'true'): ?>
        <p class="success" style="color: green; margin-bottom: 1rem;">Registration successful! Please login.</p>
    <?php endif; ?>
    <form action="index.php?page=login" method="POST">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn">Login</button>
    </form>
</div>

<?php require_once 'view/layout/footer.php'; ?>
