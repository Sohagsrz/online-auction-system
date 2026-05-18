<?php require_once 'view/layout/header.php'; ?>

<div class="dashboard-container">
    <h2>Admin Dashboard</h2>
    <p>System overview, user management, and financial reporting.</p>
    
    <div style="display:flex; gap:15px; margin-bottom: 30px; flex-wrap: wrap;">
        <div style="background:#fff; padding:15px; border-radius:8px; border:1px solid #ddd; min-width:150px;">
            <h4 style="margin:0 0 10px 0;">Users (By Role)</h4>
            <?php foreach($user_counts as $role => $count): ?>
                <div style="font-size:14px;"><?= ucfirst($role) ?>s: <strong><?= $count ?></strong></div>
            <?php endforeach; ?>
        </div>
        <div style="background:#fff; padding:15px; border-radius:8px; border:1px solid #ddd; text-align:center; min-width:150px;">
            <h4 style="margin:0 0 10px 0;">Active Listings</h4>
            <div style="font-size:24px; font-weight:bold; color:#007bff;"><?= $active_listings ?></div>
        </div>
        <div style="background:#fff; padding:15px; border-radius:8px; border:1px solid #ddd; text-align:center; min-width:150px;">
            <h4 style="margin:0 0 10px 0;">Bids Today</h4>
            <div style="font-size:24px; font-weight:bold; color:#28a745;"><?= $bids_today ?></div>
        </div>
        <div style="background:#fff; padding:15px; border-radius:8px; border:1px solid #ddd; text-align:center; min-width:150px;">
            <h4 style="margin:0 0 10px 0;">Comm. This Month</h4>
            <div style="font-size:24px; font-weight:bold; color:#ffc107;">$<?= number_format($commission, 2) ?></div>
        </div>
        <div style="background:#fff; padding:15px; border-radius:8px; border:1px solid #ddd; text-align:center; min-width:150px;">
            <h4 style="margin:0 0 10px 0;">Pending Verifs.</h4>
            <div style="font-size:24px; font-weight:bold; color:#dc3545;"><?= $pending_verifs ?></div>
        </div>
    </div>

    <ul class="dashboard-grid">
        <li><a href="index.php?page=admin_users" class="dashboard-card">Manage Users</a></li>
        <li><a href="index.php?page=admin_sellers" class="dashboard-card">Seller Verifications</a></li>
        <li><a href="index.php?page=admin_reports" class="dashboard-card">Financial Reports</a></li>
    </ul>
</div>

<?php require_once 'view/layout/footer.php'; ?>
