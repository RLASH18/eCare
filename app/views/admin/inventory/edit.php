<?php include APP_ROOT . '/views/inc/dashboard-header.php' ?>

<form action="<?= URL_ROOT ?>/admin/edit-inventory/<?= $data['id'] ?>" method="POST">

    <input type="hidden" name="id" id="id" value="<?= $data['id'] ?>">

    <div>
        <label for="item_name">Item Name</label>
        <input type="text" name="item_name" id="item_name" value="<?= htmlspecialchars($data['item_name']) ?>" required>
        <?php if (!empty($data['item_name_err'])) : ?>
            <p><?= $data['item_name_err'] ?></p>
        <?php endif ?>
    </div>

    <div>
        <label for="quantity">Quantity</label>
        <input type="number" name="quantity" id="quantity" value="<?= htmlspecialchars($data['quantity']) ?>" required>
        <?php if (!empty($data['quantity_err'])) : ?>
            <p><?= $data['quantity_err'] ?></p>
        <?php endif ?>
    </div>

    <div>
        <label for="description">Description</label>
        <input type="text" name="description" id="description" value="<?= htmlspecialchars($data['description']) ?>" required>
        <?php if (!empty($data['description_err'])) : ?>
            <p><?= $data['description_err'] ?></p>
        <?php endif ?>
    </div>
    
    <a href="<?= URL_ROOT ?>/admin/inventory" class="btn btn-secondary">Cancel</a>
    <button type="submit">Update Inventory Item</button>

</form>


<?php include APP_ROOT . '/views/inc/dashboard-footer.php' ?>