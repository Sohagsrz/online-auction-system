<?php require_once 'view/layout/header.php'; ?>
<div class="container">
    <h2>My Bids History</h2>
    <a href="index.php?page=buyer_dashboard">Back to Dashboard</a>
    <br><br>
    
    <table border="1" cellpadding="10" cellspacing="0" style="width:100%; text-align:left;">
        <thead>
            <tr>
                <th>Listing Title</th>
                <th>My Bid Amount</th>
                <th>Bid Placed At</th>
                <th>Listing Status</th>
                <th>Outcome</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bids as $bid): ?>
                <tr>
                    <td><?= htmlspecialchars($bid['title']) ?></td>
                    <td>$<?= number_format($bid['amount'], 2) ?></td>
                    <td><?= htmlspecialchars($bid['created_at']) ?></td>
                    <td><?= htmlspecialchars(ucfirst($bid['listing_status'])) ?></td>
                    <td>
                        <?php 
                        if ($bid['listing_status'] === 'ended') {
                            echo ($bid['winner_bid_id'] == $bid['id']) ? '<strong style="color:green">Won!</strong>' : '<span style="color:red">Lost</span>';
                        } else {
                            echo 'Pending';
                        }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if(empty($bids)): ?>
                <tr><td colspan="5">You have not placed any bids yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php require_once 'view/layout/footer.php'; ?>
