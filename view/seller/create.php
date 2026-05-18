<?php require_once 'view/layout/header.php'; ?>
<div class="container">
    <h2>Create New Listing</h2>
    <a href="index.php?page=seller_dashboard">Back to Dashboard</a>
    <br><br>
    
    <?php if(isset($error)): ?>
        <div style="color: red; margin-bottom: 1rem;"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?page=seller_create" enctype="multipart/form-data" style="max-width: 600px; background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" required>
        </div>
        
        <div class="form-group">
            <label>Listing Images (up to 5)</label>
            <input type="file" name="images[]" multiple accept="image/*">
        </div>
        
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="4" style="width:100%; padding:0.5rem; border:1px solid #ccc; border-radius:3px;" required></textarea>
        </div>

        <div class="form-group">
            <label>Category</label>
            <select name="category_id" style="width:100%; padding:0.5rem;" required>
                <option value="">Select Category</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Item Condition</label>
            <select name="item_condition" style="width:100%; padding:0.5rem;" required>
                <option value="new">New</option>
                <option value="like_new">Like New</option>
                <option value="good">Good</option>
                <option value="fair">Fair</option>
                <option value="poor">Poor</option>
            </select>
        </div>

        <div style="display:flex; gap:10px;">
            <div class="form-group" style="flex:1;">
                <label>Starting Price ($)</label>
                <input type="number" name="starting_price" step="0.01" required>
            </div>
            
            <div class="form-group" style="flex:1;">
                <label>Reserve Price ($) Optional</label>
                <input type="number" name="reserve_price" step="0.01">
            </div>
        </div>

        <div class="form-group">
            <label>End Date & Time</label>
            <input type="datetime-local" name="end_datetime" required>
        </div>

        <button type="submit" class="btn" style="width:100%; font-size:1.1rem; padding:0.75rem;">Create Listing</button>
    </form>
</div>
<?php require_once 'view/layout/footer.php'; ?>
