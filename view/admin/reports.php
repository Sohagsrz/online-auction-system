<?php require_once 'view/layout/header.php'; ?>

<div class="container">
    <h2>Financial Reports</h2>
    <a href="index.php?page=admin_dashboard">Back to Dashboard</a>
    <br><br>
    
    <table border="1" cellpadding="10" cellspacing="0" style="width:100%; text-align:left;">
        <thead>
            <tr>
                <th>Fee ID</th>
                <th>Listing ID</th>
                <th>Seller ID</th>
                <th>Final Price</th>
                <th>Commission Rate</th>
                <th>Commission Amount</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($fees as $fee): ?>
                <tr>
                    <td><?= htmlspecialchars($fee['id']) ?></td>
                    <td><?= htmlspecialchars($fee['listing_id']) ?></td>
                    <td><?= htmlspecialchars($fee['seller_id']) ?></td>
                    <td>$<?= number_format($fee['final_price'], 2) ?></td>
                    <td><?= ($fee['commission_rate'] * 100) ?>%</td>
                    <td>$<?= number_format($fee['commission_amount'], 2) ?></td>
                    <td><?= htmlspecialchars($fee['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once 'view/layout/footer.php'; ?>
