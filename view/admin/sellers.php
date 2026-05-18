<?php require_once 'view/layout/header.php'; ?>

<div class="container">
    <h2>Seller Verifications</h2>
    <a href="index.php?page=admin_dashboard">Back to Dashboard</a>
    <br><br>
    
    <table border="1" cellpadding="10" cellspacing="0" style="width:100%; text-align:left;">
        <thead>
            <tr>
                <th>ID</th>
                <th>User Name</th>
                <th>Motivation</th>
                <th>Document</th>
                <th>Status</th>
                <th>Submitted At</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($requests as $req): ?>
                <tr>
                    <td><?= htmlspecialchars($req['id']) ?></td>
                    <td><?= htmlspecialchars($req['user_name']) ?> (<?= htmlspecialchars($req['email']) ?>)</td>
                    <td><?= htmlspecialchars($req['motivation']) ?></td>
                    <td><a href="<?= htmlspecialchars($req['id_document_path']) ?>" target="_blank">View Doc</a></td>
                    <td><?= htmlspecialchars(ucfirst($req['status'])) ?></td>
                    <td><?= htmlspecialchars($req['submitted_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once 'view/layout/footer.php'; ?>
