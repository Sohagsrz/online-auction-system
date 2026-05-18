<?php require_once 'view/layout/header.php'; ?>
<div class="container">
    <h2>Category Management</h2>
    <a href="index.php?page=moderator_dashboard">Back to Dashboard</a>
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

    <div style="display:flex; gap:20px; flex-wrap:wrap; margin-bottom:30px;">
        <div style="flex:1; min-width:320px; padding:20px; background:#fff; border:1px solid #ddd; border-radius:8px;">
            <h3><?= $edit_category ? 'Edit Category' : 'Create Category' ?></h3>
            <form method="post" action="index.php?page=mod_categories<?= $edit_category ? '&edit_id=' . intval($edit_category['id']) : '' ?>">
                <input type="hidden" name="action" value="<?= $edit_category ? 'update_category' : 'create_category' ?>">
                <?php if ($edit_category): ?>
                    <input type="hidden" name="category_id" value="<?= intval($edit_category['id']) ?>">
                <?php endif; ?>
                <div style="margin-bottom:15px;">
                    <label for="name">Name</label><br>
                    <input id="name" name="name" type="text" value="<?= htmlspecialchars($edit_category['name'] ?? '') ?>" style="width:100%; padding:0.5rem;" required>
                </div>
                <div style="margin-bottom:15px;">
                    <label for="description">Description</label><br>
                    <textarea id="description" name="description" style="width:100%; padding:0.5rem;" rows="4"><?= htmlspecialchars($edit_category['description'] ?? '') ?></textarea>
                </div>
                <div style="margin-bottom:15px;">
                    <label for="parent_id">Parent Category</label><br>
                    <select id="parent_id" name="parent_id" style="width:100%; padding:0.5rem;">
                        <option value="">No parent</option>
                        <?php foreach ($categories as $cat_option): ?>
                            <?php if ($edit_category && $cat_option['id'] == $edit_category['id']) continue; ?>
                            <option value="<?= intval($cat_option['id']) ?>" <?= isset($edit_category['parent_id']) && $edit_category['parent_id'] == $cat_option['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat_option['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" style="padding:10px 18px; background:#007bff; color:#fff; border:none; border-radius:4px; cursor:pointer;">
                    <?= $edit_category ? 'Save Changes' : 'Create Category' ?>
                </button>
                <?php if ($edit_category): ?>
                    <a href="index.php?page=mod_categories" style="margin-left:12px; color:#333;">Cancel</a>
                <?php endif; ?>
            </form>
        </div>

        <div style="flex:2; min-width:320px;">
            <table border="1" cellpadding="10" cellspacing="0" style="width:100%; text-align:left; border-collapse:collapse;">
                <thead>
                    <tr style="background:#f1f1f1;">
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Parent</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $category_names = [];
                        foreach ($categories as $cat_lookup) {
                            $category_names[$cat_lookup['id']] = $cat_lookup['name'];
                        }
                    ?>
                    <?php foreach ($categories as $cat): ?>
                        <tr>
                            <td><?= intval($cat['id']) ?></td>
                            <td><?= htmlspecialchars($cat['name']) ?></td>
                            <td><?= nl2br(htmlspecialchars($cat['description'])) ?></td>
                            <td><?= $cat['parent_id'] ? htmlspecialchars($category_names[$cat['parent_id']] ?? 'Unknown') : 'None' ?></td>
                            <td>
                                <a href="index.php?page=mod_categories&edit_id=<?= intval($cat['id']) ?>" style="margin-right:10px;">Edit</a>
                                <form method="post" action="index.php?page=mod_categories" style="display:inline;" onsubmit="return confirm('Delete this category?');">
                                    <input type="hidden" name="action" value="delete_category">
                                    <input type="hidden" name="category_id" value="<?= intval($cat['id']) ?>">
                                    <button type="submit" style="background:none;border:none;color:#d9534f;cursor:pointer;padding:0;">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once 'view/layout/footer.php'; ?>
