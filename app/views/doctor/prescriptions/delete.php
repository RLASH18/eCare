<?php include APP_ROOT . '/views/inc/dashboard-header.php' ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">Delete prescription Confirmation</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <strong>Warning!</strong> Are you sure you want to delete this prescription? This action cannot be undone.
                    </div>

                    <div class="prescription-details mb-4">
                        <h5>Prescription details:</h5>
                        <table class="table">
                            <tr>
                                <th>Record info:</th>
                                <td>
                                    <!--name-->
                                    <?= htmlspecialchars($data['patient_name']) ?> -
                                    <!--diagnosis-->
                                    <?= htmlspecialchars($data['diagnosis']) ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Medicine Name:</th>
                                <td><?= htmlspecialchars($data['medicine_name']) ?></td>
                            </tr>
                            <tr>
                                <th>Dosage:</th>
                                <td><?= htmlspecialchars($data['dosage']) ?></td>
                            </tr>
                        </table>
                    </div>

                    <form action="<?= URL_ROOT ?>/doctor/delete-prescriptions/<?= $data['id'] ?>" method="POST">
                        <div class="d-flex justify-content-between">
                            <a href="<?= URL_ROOT ?>/doctor/prescriptions" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-danger">Delete prescription</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include APP_ROOT . '/views/inc/dashboard-footer.php' ?>