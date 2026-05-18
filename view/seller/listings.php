<?php require_once 'view/layout/header.php'; ?>
<div class="container">
    <h2>My Listings</h2>
    <a href="index.php?page=seller_dashboard">Back to Dashboard</a>
    <br><br>
    <table border="1" cellpadding="10" cellspacing="0" style="width:100%; text-align:left;">
        <thead>
            <tr>
                <th>Title</th>
                <th>Condition</th>
                <th>Current Bid</th>
                <th>Ends</th>
                <th>Status</th>
                <th>Live Bids</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listings as $listing): ?>
                <tr>
                    <td><?= htmlspecialchars($listing['title']) ?></td>
                    <td><?= htmlspecialchars($listing['item_condition']) ?></td>
                    <td>$<?= number_format($listing['current_bid'], 2) ?></td>
                    <td><?= htmlspecialchars($listing['end_datetime']) ?></td>
                    <td><?= htmlspecialchars(ucfirst($listing['status'])) ?></td>
                    <td>
                        <button onclick="fetchLiveBids(<?= $listing['id'] ?>)" class="btn">View Live Bids</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div id="live-bids-container" style="margin-top:2rem; display:none; background:#eee; padding:1rem;">
        <h3>Live Bids Viewer</h3>
        <ul id="live-bids-list"></ul>
    </div>
</div>

<script>
// AJAX function for Member 2 Seller
function fetchLiveBids(listingId) {
    document.getElementById('live-bids-container').style.display = 'block';
    document.getElementById('live-bids-list').innerHTML = '<li>Loading...</li>';
    
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'index.php?page=seller_listings&ajax=live_bids&listing_id=' + listingId, true);

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                try {
                    var data = JSON.parse(xhr.responseText);
                    var list = document.getElementById('live-bids-list');
                    list.innerHTML = '';
                    
                    if (data.success && data.bids.length > 0) {
                        data.bids.forEach(function(bid) {
                            var li = document.createElement('li');
                            li.textContent = bid.bidder_name + ' bid $' + parseFloat(bid.amount).toFixed(2) + ' on ' + bid.created_at;
                            list.appendChild(li);
                        });
                    } else {
                        list.innerHTML = '<li>No bids yet.</li>';
                    }
                } catch (e) {
                    alert('Error parsing JSON.');
                }
            } else {
                alert('An error occurred.');
            }
        }
    };
    xhr.send();
}
</script>

<?php require_once 'view/layout/footer.php'; ?>
