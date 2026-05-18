<?php require_once 'view/layout/header.php'; ?>
<div class="container">
    <h2>My Watchlist</h2>
    <a href="index.php?page=buyer_dashboard">Back to Dashboard</a>
    <br><br>
    
    <table border="1" cellpadding="10" cellspacing="0" style="width:100%; text-align:left;">
        <thead>
            <tr>
                <th>Title</th>
                <th>Current Bid</th>
                <th>Condition</th>
                <th>Ends At</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($watchlist_items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['title']) ?></td>
                    <td>$<?= number_format($item['current_bid'], 2) ?></td>
                    <td><?= htmlspecialchars($item['item_condition']) ?></td>
                    <td><?= htmlspecialchars($item['end_datetime']) ?></td>
                    <td><?= htmlspecialchars($item['status']) ?></td>
                    <td><a href="index.php?page=buyer_browse" class="btn">Go Bid</a></td>
                </tr>
            <?php endforeach; ?>
            <?php if(empty($watchlist_items)): ?>
                <tr><td colspan="6">No items in your watchlist.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php require_once 'view/layout/footer.php'; ?>
