<?php require_once APPROOT . '/views/inc/admin/adminheader.php'; ?>
<?php require_once APPROOT . '/views/inc/admin/adminsidebar.php'; ?>

<div class="main-content">
    <h1>Edit Fabric</h1>
    <form action="<?php echo URLROOT; ?>/admin/editFabric/<?php echo $data['fabric']->fabric_id; ?>" method="POST">
        <label for="fabric_name">Fabric Name:</label>
        <input type="text" name="fabric_name" value="<?php echo $data['fabric']->fabric_name; ?>" required>

        <label for="price_per_meter">Price per Meter:</label>
        <input type="number" step="0.01" name="price_per_meter" value="<?php echo $data['fabric']->price_per_meter; ?>" required>

        <label for="stock">Stock:</label>
        <input type="number" step="0.01" name="stock" value="<?php echo $data['fabric']->stock; ?>" required>

        <label for="colors">Colors:</label>
        <select name="colors[]" multiple>
            <?php foreach ($data['colors'] as $color): ?>
                <option value="<?php echo $color->color_id; ?>" <?php echo in_array($color->color_id, explode(', ', $data['fabric']->colors)) ? 'selected' : ''; ?>>
                    <?php echo $color->color_name; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>