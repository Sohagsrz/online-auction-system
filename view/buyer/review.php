<?php require_once 'view/layout/header.php'; ?>
<div class="container">
    <h2>Submit Review</h2>
    <a href="index.php?page=buyer_dashboard" class="btn">Back to Dashboard</a>
    <br><br>
    
    <?php if(isset($success)): ?>
        <div style="background:#d4edda; color:#155724; padding:15px; border-radius:8px; margin-bottom:20px;">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php else: ?>
        <form method="POST" action="index.php?page=buyer_review" style="max-width: 500px; background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
            <input type="hidden" name="listing_id" value="<?= htmlspecialchars($listing_id) ?>">
            <input type="hidden" name="seller_id" value="<?= htmlspecialchars($seller_id) ?>">
            
            <div class="form-group">
                <label>Rating (1 to 5 Stars)</label>
                <select name="rating" style="width:100%; padding:0.5rem;" required>
                    <option value="5">5 - Excellent</option>
                    <option value="4">4 - Good</option>
                    <option value="3">3 - Average</option>
                    <option value="2">2 - Poor</option>
                    <option value="1">1 - Terrible</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Review Comment</label>
                <textarea name="review_text" rows="4" style="width:100%; padding:0.5rem; border:1px solid #ccc; border-radius:3px;" required placeholder="Describe your experience..."></textarea>
            </div>

            <button type="submit" class="btn" style="width:100%; background:#28a745;">Submit Review</button>
        </form>
    <?php endif; ?>
</div>
<?php require_once 'view/layout/footer.php'; ?>
