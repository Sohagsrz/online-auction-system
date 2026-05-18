<?php require_once 'view/layout/header.php'; ?>

<div class="dashboard-container">
    <h2>Buyer Dashboard</h2>
    <p>Welcome to your buyer dashboard. From here you can browse auctions, manage your watchlist, and track your bids.</p>
    
    <?php if(!empty($notifications)): ?>
        <div style="background:#fff3cd; color:#856404; padding:15px; border-radius:8px; border:1px solid #ffeeba; margin-bottom:20px;">
            <h4 style="margin:0 0 10px 0;">Alerts & Notifications</h4>
            <ul style="margin:0; padding-left:20px;">
                <?php foreach($notifications as $note): ?>
                    <li><strong><?= htmlspecialchars($note) ?></strong></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <ul class="dashboard-grid">
        <li><a href="index.php?page=buyer_browse" class="dashboard-card">Browse Auctions</a></li>
        <li><a href="index.php?page=buyer_watchlist" class="dashboard-card">My Watchlist</a></li>
        <li><a href="index.php?page=buyer_bids" class="dashboard-card">My Bids</a></li>
    </ul>
</div>

<?php require_once 'view/layout/footer.php'; ?>
