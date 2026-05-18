<?php require_once 'view/layout/header.php'; ?>
<div class="container">
    <h2>Seller Analytics</h2>
    <a href="index.php?page=seller_dashboard">Back to Dashboard</a>
    <br><br>
    
    <div style="display:flex; gap:20px; flex-wrap:wrap;">
        <div style="padding:20px; border:1px solid #ddd; background:#fff; border-radius:8px; width:200px;">
            <h3>Total Listings</h3>
            <p style="font-size:24px; font-weight:bold; color:#333;"><?= $total_auctions ?></p>
        </div>
        <div style="padding:20px; border:1px solid #ddd; background:#fff; border-radius:8px; width:200px;">
            <h3>Auctions Won</h3>
            <p style="font-size:24px; font-weight:bold; color:#28a745;"><?= $total_won ?></p>
        </div>
        <div style="padding:20px; border:1px solid #ddd; background:#fff; border-radius:8px; width:200px;">
            <h3>Total Revenue</h3>
            <p style="font-size:24px; font-weight:bold; color:#007bff;">$<?= number_format($total_revenue, 2) ?></p>
        </div>
        <div style="padding:20px; border:1px solid #ddd; background:#fff; border-radius:8px; width:200px;">
            <h3>Avg Sale Price</h3>
            <p style="font-size:24px; font-weight:bold; color:#17a2b8;">$<?= number_format($avg_price, 2) ?></p>
        </div>
        <div style="padding:20px; border:1px solid #ddd; background:#fff; border-radius:8px; width:200px;">
            <h3>Top Category</h3>
            <p style="font-size:24px; font-weight:bold; color:#ffc107;"><?= htmlspecialchars($popular_category) ?></p>
        </div>
    </div>
</div>
<?php require_once 'view/layout/footer.php'; ?>
