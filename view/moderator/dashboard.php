<?php require_once 'view/layout/header.php'; ?>

<div class="dashboard-container">
    <h2>Moderator Dashboard</h2>
    <p>Review listings, manage reports, and maintain platform safety.</p>
    
    <div style="display:flex; gap:15px; margin-bottom: 30px; flex-wrap: wrap;">
        <div style="background:#fff; padding:15px; border-radius:8px; border:1px solid #ddd; text-align:center; min-width:150px;">
            <h4 style="margin:0 0 10px 0;">Pending Reviews</h4>
            <div style="font-size:24px; font-weight:bold; color:#007bff;"><?= $pending_listings ?></div>
        </div>
        <div style="background:#fff; padding:15px; border-radius:8px; border:1px solid #ddd; text-align:center; min-width:150px;">
            <h4 style="margin:0 0 10px 0;">Listing Reports</h4>
            <div style="font-size:24px; font-weight:bold; color:#ffc107;"><?= $open_list_reports ?></div>
        </div>
        <div style="background:#fff; padding:15px; border-radius:8px; border:1px solid #ddd; text-align:center; min-width:150px;">
            <h4 style="margin:0 0 10px 0;">User Reports</h4>
            <div style="font-size:24px; font-weight:bold; color:#fd7e14;"><?= $open_user_reports ?></div>
        </div>
        <div style="background:#fff; padding:15px; border-radius:8px; border:1px solid #ddd; text-align:center; min-width:150px;">
            <h4 style="margin:0 0 10px 0;">Warnings (This Week)</h4>
            <div style="font-size:24px; font-weight:bold; color:#dc3545;"><?= $warnings_this_week ?></div>
        </div>
    </div>

    <ul class="dashboard-grid">
        <li><a href="index.php?page=mod_listings" class="dashboard-card">Pending Listings</a></li>
        <li><a href="index.php?page=mod_reports" class="dashboard-card">Reports</a></li>
        <li><a href="index.php?page=mod_categories" class="dashboard-card">Categories</a></li>
    </ul>
</div>

<?php require_once 'view/layout/footer.php'; ?>
