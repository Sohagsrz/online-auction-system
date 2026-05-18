<?php require_once 'view/layout/header.php'; ?>

<div class="auth-container">
    <h2>Register</h2>
    <?php if (isset($error)): ?>
        <p class="error" style="color: red; margin-bottom: 1rem;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
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
        <div class="form-group">
            <label for="role">Register As:</label>
            <select id="role" name="role" required style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 3px;">
                <option value="buyer">Buyer</option>
                <option value="seller">Seller</option>
            </select>
        </div>
        <button type="submit" class="btn">Register</button>
    </form>
</div>

<?php require_once 'view/layout/footer.php'; ?>
