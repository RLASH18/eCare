<?php include APP_ROOT . '/views/inc/dashboard-header.php' ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">Delete Billing Confirmation</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <strong>Warning!</strong> Are you sure you want to delete this bill? This action cannot be undone.
                    </div>

                    <div class="billing-details mb-4">
                        <h5>Billing Details:</h5>
                        <table class="table">
                            <tr>
                                <th>Patient Name:</th>
                                <td><?= htmlspecialchars($data['patient_name']) ?></td>
                            </tr>
                            <tr>
                                <th>Amount:</th>
                                <td><?= htmlspecialchars(number_format($data['amount'], 2)) ?></td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td><?= htmlspecialchars($data['status']) ?></td>
                            </tr>
                            <tr>
                                <th>Description:</th>
                                <td><?= htmlspecialchars($data['description']) ?></td>
                            </tr>
                        </table>
                    </div>

                    <form action="<?= URL_ROOT ?>/admin/delete-billing/<?= $data['id'] ?>" method="POST">
                        <div class="d-flex justify-content-between">
                            <a href="<?= URL_ROOT ?>/admin/billings" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-danger">Delete Billing</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include APP_ROOT . '/views/inc/dashboard-footer.php' ?>