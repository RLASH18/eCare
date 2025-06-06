<?php include APP_ROOT . '/views/inc/dashboard-header.php' ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">Delete Inventory Item Confirmation</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <strong>Warning!</strong> Are you sure you want to delete this inventory item? This action cannot be undone.
                    </div>
                    <div class="inventory-details mb-4">
                        <h5>Inventory Details:</h5>
                        <table class="table">
                            <tr>
                                <th>Item Name:</th>
                                <td><?= htmlspecialchars($data['item_name']) ?></td>
                            </tr>
                            <tr>
                                <th>Quantity:</th>
                                <td><?= htmlspecialchars($data['quantity']) ?></td>
                            </tr>
                            <tr>
                                <th>Description:</th>
                                <td><?= htmlspecialchars($data['description']) ?></td>
                            </tr>
                        </table>
                    </div>
                    <form action="<?= URL_ROOT ?>/admin/delete-inventory/<?= $data['id'] ?>" method="POST">
                        <div class="d-flex justify-content-between">
                            <a href="<?= URL_ROOT ?>/admin/inventory" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-danger">Delete Inventory Item</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include APP_ROOT . '/views/inc/dashboard-footer.php' ?>