<?php require_once 'view/layout/header.php'; ?>

<div class="container">
    <h2>Seller Verifications</h2>
    <a href="index.php?page=admin_dashboard">Back to Dashboard</a>
    <br><br>

    <?php if (!empty($message)): ?>
        <div style="padding:10px; margin-bottom:20px; background:#d4edda; color:#155724; border:1px solid #c3e6cb; border-radius:4px;">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div style="padding:10px; margin-bottom:20px; background:#f8d7da; color:#721c24; border:1px solid #f5c6cb; border-radius:4px;">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <table border="1" cellpadding="10" cellspacing="0" style="width:100%; text-align:left; border-collapse:collapse;">
        <thead>
            <tr style="background:#f1f1f1;">
                <th>ID</th>
                <th>User Name</th>
                <th>Motivation</th>
                <th>Document</th>
                <th>Status</th>
                <th>Submitted At</th>
                <th>Actions</th>
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
                    <td>
                        <?php if ($req['status'] === 'pending'): ?>
                            <form method="post" action="index.php?page=admin_sellers" style="display:inline;margin-right:8px;">
                                <input type="hidden" name="action" value="approve_verification">
                                <input type="hidden" name="request_id" value="<?= intval($req['id']) ?>">
                                <button type="submit" style="padding:6px 12px; background:#28a745; color:#fff; border:none; border-radius:4px; cursor:pointer;">Approve</button>
                            </form>
                            <form method="post" action="index.php?page=admin_sellers" style="display:inline;">
                                <input type="hidden" name="action" value="reject_verification">
                                <input type="hidden" name="request_id" value="<?= intval($req['id']) ?>">
                                <button type="submit" style="padding:6px 12px; background:#dc3545; color:#fff; border:none; border-radius:4px; cursor:pointer;">Reject</button>
                            </form>
                        <?php else: ?>
                            <span style="color:#6c757d;">No actions</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once 'view/layout/footer.php'; ?>
