<?php require_once 'view/layout/header.php'; ?>
<div class="container">
    <h2>Report Listing</h2>
    <a href="index.php?page=buyer_dashboard" class="btn">Back to Dashboard</a>
    <br><br>
    
    <?php if(isset($success)): ?>
        <div style="background:#d4edda; color:#155724; padding:15px; border-radius:8px; margin-bottom:20px;">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php else: ?>
        <form method="POST" action="index.php?page=buyer_report" style="max-width: 500px; background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
            <input type="hidden" name="listing_id" value="<?= htmlspecialchars($listing_id) ?>">
            
            <div class="form-group">
                <label>Reason for Reporting</label>
                <select name="reason" style="width:100%; padding:0.5rem;" required>
                    <option value="">Select Reason</option>
                    <option value="fake_item">Fake / Counterfeit Item</option>
                    <option value="prohibited">Prohibited Item</option>
                    <option value="scam">Suspected Scam</option>
                    <option value="other">Other</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Detailed Description</label>
                <textarea name="description" rows="4" style="width:100%; padding:0.5rem; border:1px solid #ccc; border-radius:3px;" required placeholder="Please explain why you are reporting this listing..."></textarea>
            </div>

            <button type="submit" class="btn" style="width:100%; background:#dc3545;">Submit Report</button>
        </form>
    <?php endif; ?>
</div>
<?php require_once 'view/layout/footer.php'; ?>
