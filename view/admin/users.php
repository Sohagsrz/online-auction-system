<?php require_once 'view/layout/header.php'; ?>

<div class="container">
    <h2>Manage Users</h2>
    <a href="index.php?page=admin_dashboard">Back to Dashboard</a>
    <br><br>
    
    <table border="1" cellpadding="10" cellspacing="0" style="width:100%; text-align:left;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Verified Seller</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id']) ?></td>
                    <td><?= htmlspecialchars($user['name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars(ucfirst($user['role'])) ?></td>
                    <td><?= $user['seller_verified'] ? 'Yes' : 'No' ?></td>
                    <td id="status-<?= $user['id'] ?>">
                        <?= $user['is_active'] ? '<span style="color:green">Active</span>' : '<span style="color:red">Inactive</span>' ?>
                    </td>
                    <td>
                        <button onclick="toggleUserStatus(<?= $user['id'] ?>, <?= $user['is_active'] ? 0 : 1 ?>)" class="btn">
                            <?= $user['is_active'] ? 'Deactivate' : 'Activate' ?>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
// AJAX function for Member 4 Admin
function toggleUserStatus(userId, newStatus) {
    if (!confirm('Are you sure you want to change this user\'s status?')) return;
    
    const formData = new URLSearchParams();
    formData.append('action', 'toggle_status');
    formData.append('user_id', userId);
    formData.append('status', newStatus);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'index.php?page=admin_users', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                try {
                    var data = JSON.parse(xhr.responseText);
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert('Failed to update status.');
                    }
                } catch (e) {
                    console.error('Error parsing JSON:', e);
                    alert('An error occurred.');
                }
            } else {
                alert('An error occurred. Status: ' + xhr.status);
            }
        }
    };

    xhr.send(formData.toString());
}
</script>

<?php require_once 'view/layout/footer.php'; ?>
