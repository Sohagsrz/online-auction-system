<?php require_once 'view/layout/header.php'; ?>
<div class="container">
    <h2>Category Management</h2>
    <a href="index.php?page=moderator_dashboard">Back to Dashboard</a>
    <br><br>
    
    <table border="1" cellpadding="10" cellspacing="0" style="width:100%; text-align:left;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Parent ID</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $cat): ?>
                <tr>
                    <td><?= htmlspecialchars($cat['id']) ?></td>
                    <td><?= htmlspecialchars($cat['name']) ?></td>
                    <td><?= htmlspecialchars($cat['description']) ?></td>
                    <td><?= htmlspecialchars($cat['parent_id'] ?? 'None') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once 'view/layout/footer.php'; ?>
