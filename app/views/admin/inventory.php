<?php include APP_ROOT . '/views/inc/dashboard-header.php' ?>

<a href="<?= URL_ROOT ?>/admin/add-inventory">
    Add Inventory
</a>
<?php include APP_ROOT . '/views/inc/sidebar.php' ?>


<div class="table">
    <table class="table">
        <thead>
            <tr>
                <th>Item name</th>
                <th>Quantity</th>
                <th>Description</th>
                <th>Last updated</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['items'] as $item) : ?>
                <tr>
                    <td><?= htmlspecialchars($item['item_name']) ?></td>
                    <td><?= htmlspecialchars($item['quantity']) ?></td>
                    <td><?= htmlspecialchars($item['description']) ?></td>
                    <td><?= htmlspecialchars(date('M d, Y', strtotime($item['last_updated']))) ?></td>
                    <td>
                        <a href="<?= URL_ROOT ?>/admin/edit-inventory/<?= $item['id'] ?>">Edit</a>
                        <a href="<?= URL_ROOT ?>/admin/delete-inventory/<?= $item['id'] ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>



<?php include APP_ROOT . '/views/inc/dashboard-footer.php' ?>