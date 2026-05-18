<?php require_once 'view/layout/header.php'; ?>

<div class="container">
    <h2>Browse Active Auctions</h2>
    <a href="index.php?page=buyer_dashboard">Back to Dashboard</a>
    <br><br>
    
    <div style="display:flex; flex-wrap:wrap; gap:1rem;">
        <?php foreach ($listings as $listing): ?>
            <div style="border:1px solid #ccc; padding:1rem; width:300px; border-radius:8px; background:#fff; box-shadow:0 2px 5px rgba(0,0,0,0.1);">
                <?php if(!empty($listing['main_image'])): ?>
                    <img src="<?= htmlspecialchars($listing['main_image']) ?>" alt="Listing Image" style="width:100%; height:200px; object-fit:cover; border-radius:4px; margin-bottom:10px;">
                <?php else: ?>
                    <div style="width:100%; height:200px; background:#eee; display:flex; align-items:center; justify-content:center; border-radius:4px; color:#999; margin-bottom:10px;">No Image</div>
                <?php endif; ?>
                <h3 style="margin-top:0;"><?= htmlspecialchars($listing['title']) ?></h3>
                <p><?= htmlspecialchars($listing['description']) ?></p>
                <p><strong>Condition:</strong> <?= htmlspecialchars($listing['item_condition']) ?></p>
                <p><strong>Current Bid:</strong> $<span id="current-bid-<?= $listing['id'] ?>"><?= number_format($listing['current_bid'], 2) ?></span></p>
                <p><strong>Ends:</strong> <?= htmlspecialchars($listing['end_datetime']) ?></p>
                <input type="number" id="bid-amount-<?= $listing['id'] ?>" step="0.01" value="<?= $listing['current_bid'] + 1 ?>" style="width: 80px;">
                <button onclick="placeBid(<?= $listing['id'] ?>)" class="btn">Place Bid</button>
            </div>
        <?php endforeach; ?>
        <?php if(empty($listings)): ?>
            <p>No active listings found.</p>
        <?php endif; ?>
    </div>
</div>

<script>
// AJAX function for Member 1 Buyer
function placeBid(listingId) {
    var amountInput = document.getElementById('bid-amount-' + listingId);
    var amount = amountInput.value;
    
    if (!amount || amount <= 0) {
        alert("Please enter a valid bid amount.");
        return;
    }
    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'index.php?page=buyer_browse', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                try {
                    var data = JSON.parse(xhr.responseText);
                    if (data.success) {
                        document.getElementById('current-bid-' + listingId).innerText = parseFloat(data.new_bid).toFixed(2);
                        amountInput.value = (parseFloat(data.new_bid) + 1).toFixed(2);
                        alert('Bid placed successfully!');
                    } else {
                        alert(data.error || 'Failed to place bid.');
                    }
                } catch (e) {
                    alert('Error parsing JSON.');
                }
            } else {
                alert('An error occurred.');
            }
        }
    };
    xhr.send('action=bid&listing_id=' + listingId + '&amount=' + encodeURIComponent(amount));
}
</script>

<?php require_once 'view/layout/footer.php'; ?>
