<?php require_once 'view/layout/header.php'; ?>

<div class="container">
    <h2>Seller Verification</h2>
    <a href="index.php?page=seller_dashboard">Back to Dashboard</a>
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

    <?php if ($is_verified): ?>
        <div style="padding:20px; background:#d4edda; color:#155724; border:1px solid #c3e6cb; border-radius:8px;">
            Your seller account is already verified.
        </div>
    <?php else: ?>
        <?php if (!empty($verification_request)): ?>
            <div style="padding:20px; background:#fff3cd; color:#856404; border:1px solid #ffeeba; border-radius:8px; margin-bottom:20px;">
                <strong>Latest request status:</strong> <?= htmlspecialchars(ucfirst($verification_request['status'])) ?><br>
                Submitted at: <?= htmlspecialchars($verification_request['submitted_at']) ?><br>
                <?php if (!empty($verification_request['id_document_path'])): ?>
                    Document: <a href="<?= htmlspecialchars($verification_request['id_document_path']) ?>" target="_blank">View file</a><br>
                <?php endif; ?>
                <?php if ($verification_request['status'] === 'rejected'): ?>
                    You may resubmit a new verification request.
                <?php elseif ($verification_request['status'] === 'pending'): ?>
                    Your request is currently pending review.
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="index.php?page=seller_verification" enctype="multipart/form-data" style="max-width:600px; background:#fff; padding:20px; border-radius:8px; border:1px solid #ddd;">
            <div style="margin-bottom:15px;">
                <label for="motivation">Why should your seller account be verified?</label><br>
                <textarea id="motivation" name="motivation" rows="4" style="width:100%; padding:0.75rem; border:1px solid #ccc; border-radius:4px;" required><?= htmlspecialchars($_POST['motivation'] ?? '') ?></textarea>
            </div>
            <div style="margin-bottom:15px;">
                <label for="id_document">Upload verification document</label><br>
                <input id="id_document" name="id_document" type="file" accept="image/*,application/pdf" required>
            </div>
            <button type="submit" style="padding:10px 18px; background:#007bff; color:#fff; border:none; border-radius:4px; cursor:pointer;">Submit Verification Request</button>
        </form>
    <?php endif; ?>
</div>

<?php require_once 'view/layout/footer.php'; ?>