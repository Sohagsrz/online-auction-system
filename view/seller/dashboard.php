<?php require_once 'view/layout/header.php'; ?>

<div class="dashboard-container">
    <h2>Seller Dashboard</h2>
    <p>Welcome to your seller dashboard. Manage your listings and track your sales.</p>
    
    <?php if(!$is_verified): ?>
        <div style="background:#f8d7da; color:#721c24; padding:15px; border-radius:8px; border:1px solid #f5c6cb; margin-bottom:20px;">
            <strong>Warning:</strong> Your seller account is not verified yet. You cannot create live listings until an Admin approves your verification request.
            <?php if (!empty($verification_request)): ?>
                <div style="margin-top:10px; font-size:0.95rem;">
                    Latest request status: <strong><?= htmlspecialchars(ucfirst($verification_request['status'])) ?></strong>
                </div>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div style="background:#d4edda; color:#155724; padding:15px; border-radius:8px; border:1px solid #c3e6cb; margin-bottom:20px;">
            <strong>Verified:</strong> Your seller account is verified! You can create listings.
        </div>
    <?php endif; ?>

    <ul class="dashboard-grid">
        <li><a href="index.php?page=seller_listings" class="dashboard-card">My Listings</a></li>
        <li><a href="index.php?page=seller_create" class="dashboard-card">Create Listing</a></li>
        <li><a href="index.php?page=seller_analytics" class="dashboard-card">Analytics</a></li>
        <?php if (!$is_verified): ?>
            <li><a href="index.php?page=seller_verification" class="dashboard-card">Seller Verification</a></li>
        <?php endif; ?>
    </ul>
</div>

<?php require_once 'view/layout/footer.php'; ?>
