<?php require_once 'view/layout/header.php'; ?>
<div class="container">
    <h2>Pending Listings Review</h2>
    <a href="index.php?page=moderator_dashboard">Back to Dashboard</a>
    <br><br>
    <table border="1" cellpadding="10" cellspacing="0" style="width:100%; text-align:left;">
        <thead>
            <tr>
                <th>Title</th>
                <th>Seller ID</th>
                <th>Condition</th>
                <th>Starting Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pending_listings as $listing): ?>
                <tr>
                    <td><?= htmlspecialchars($listing['title']) ?></td>
                    <td><?= htmlspecialchars($listing['seller_id']) ?></td>
                    <td><?= htmlspecialchars($listing['item_condition']) ?></td>
                    <td>$<?= number_format($listing['starting_price'], 2) ?></td>
                    <td id="action-td-<?= $listing['id'] ?>">
                        <button onclick="updateListing(<?= $listing['id'] ?>, 'approve')" class="btn" style="background:green">Approve</button>
                        <button onclick="updateListing(<?= $listing['id'] ?>, 'reject')" class="btn" style="background:red">Reject</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if(empty($pending_listings)): ?>
                <tr><td colspan="5">No pending listings.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
// AJAX function for Member 3 Moderator
function updateListing(listingId, action) {
    if (!confirm('Are you sure you want to ' + action + ' this listing?')) return;
    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'index.php?page=mod_listings', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                try {
                    var data = JSON.parse(xhr.responseText);
                    if (data.success) {
                        document.getElementById('action-td-' + listingId).innerHTML = '<span>Resolved</span>';
                    } else {
                        alert('Failed to update listing.');
                    }
                } catch (e) {
                    alert('Error parsing JSON.');
                }
            } else {
                alert('An error occurred.');
            }
        }
    };
    xhr.send('action=' + action + '&listing_id=' + listingId);
}
</script>

<?php require_once 'view/layout/footer.php'; ?>
