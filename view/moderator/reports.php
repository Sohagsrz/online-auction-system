<?php require_once 'view/layout/header.php'; ?>
<div class="container">
    <h2>Platform Reports</h2>
    <a href="index.php?page=moderator_dashboard">Back to Dashboard</a>
    <br><br>
    
    <h3>Listing Reports</h3>
    <table border="1" cellpadding="10" cellspacing="0" style="width:100%; text-align:left;">
        <thead>
            <tr>
                <th>Reason</th>
                <th>Description</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listing_reports as $report): ?>
                <tr>
                    <td><?= htmlspecialchars($report['reason']) ?></td>
                    <td><?= htmlspecialchars($report['description']) ?></td>
                    <td><?= htmlspecialchars($report['status']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <br>
    <h3>User Reports</h3>
    <table border="1" cellpadding="10" cellspacing="0" style="width:100%; text-align:left;">
        <thead>
            <tr>
                <th>Reason</th>
                <th>Description</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($user_reports as $report): ?>
                <tr>
                    <td><?= htmlspecialchars($report['reason']) ?></td>
                    <td><?= htmlspecialchars($report['description']) ?></td>
                    <td><?= htmlspecialchars($report['status']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once 'view/layout/footer.php'; ?>
