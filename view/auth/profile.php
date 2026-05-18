<?php require_once 'view/layout/header.php'; ?>
<div class="container">
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <h2>My Profile</h2>
        <a href="index.php?page=<?= $_SESSION['role'] ?>_dashboard" class="btn">Back to Dashboard</a>
    </div>
    
    <div style="display:flex; gap:30px; margin-top:20px; flex-wrap:wrap;">
        <!-- Edit Profile Form -->
        <div style="flex:1; min-width:300px; background:#fff; padding:20px; border-radius:8px; box-shadow:0 0 10px rgba(0,0,0,0.1);">
            <h3>Edit Information</h3>
            <?php if(isset($success)): ?>
                <div style="color:green; margin-bottom:15px;"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
            <?php if(isset($error)): ?>
                <div style="color:red; margin-bottom:15px;"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            
            <form method="POST" action="index.php?page=profile" enctype="multipart/form-data">
                <div class="form-group" style="text-align:center; margin-bottom:20px;">
                    <?php if(!empty($user['profile_pic'])): ?>
                        <img src="<?= htmlspecialchars($user['profile_pic']) ?>" style="width:120px; height:120px; border-radius:50%; object-fit:cover; border:2px solid #ddd; margin-bottom:10px;">
                    <?php else: ?>
                        <div style="width:120px; height:120px; border-radius:50%; background:#eee; display:flex; align-items:center; justify-content:center; margin:0 auto 10px auto; color:#999; border:2px solid #ddd;">No Pic</div>
                    <?php endif; ?>
                    <label>Profile Picture</label>
                    <input type="file" name="profile_pic" accept="image/*" style="width:100%; border:none;">
                </div>
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" value="<?= htmlspecialchars($user['email']) ?>" disabled style="background:#e9ecef;">
                    <small>Email cannot be changed.</small>
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>">
                </div>
                <div class="form-group">
                    <label>Bio</label>
                    <textarea name="bio" rows="4" style="width:100%; padding:0.5rem; border:1px solid #ccc; border-radius:3px;"><?= htmlspecialchars($user['bio']) ?></textarea>
                </div>
                <button type="submit" class="btn" style="width:100%;">Save Changes</button>
            </form>
        </div>

        <!-- Reputation & Reviews -->
        <div style="flex:1; min-width:300px;">
            <div style="background:#fff; padding:20px; border-radius:8px; box-shadow:0 0 10px rgba(0,0,0,0.1); margin-bottom:20px; text-align:center;">
                <h3>Reputation Score</h3>
                <div style="font-size:48px; font-weight:bold; color:#007bff;">
                    <?= number_format($user['reputation_score'], 1) ?> <span style="font-size:24px; color:#6c757d;">/ 5.0</span>
                </div>
            </div>

            <div style="background:#fff; padding:20px; border-radius:8px; box-shadow:0 0 10px rgba(0,0,0,0.1);">
                <h3>My Reviews (<?= count($reviews) ?>)</h3>
                <?php if(empty($reviews)): ?>
                    <p>You have not received any reviews yet.</p>
                <?php else: ?>
                    <ul style="list-style:none; padding:0; margin:0;">
                        <?php foreach($reviews as $review): ?>
                            <li style="border-bottom:1px solid #eee; padding:10px 0;">
                                <div style="display:flex; justify-content:space-between;">
                                    <strong><?= htmlspecialchars($review['reviewer_name']) ?></strong>
                                    <span style="color:#ffc107;">★ <?= $review['rating'] ?>/5</span>
                                </div>
                                <p style="margin:5px 0 0 0; color:#555;"><?= htmlspecialchars($review['review_text']) ?></p>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php require_once 'view/layout/footer.php'; ?>
