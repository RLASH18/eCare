<?php include APP_ROOT . '/views/inc/dashboard-header.php' ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">Delete medical record Confirmation</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <strong>Warning!</strong> Are you sure you want to delete this medical record? This action cannot be undone.
                    </div>

                    <div class="user-details mb-4">
                        <h5>Medical record details:</h5>
                        <table class="table">
                            <tr>
                                <th>Patient name:</th>
                                <td><?= htmlspecialchars($data['patient_name']) ?></td>
                            </tr>
                            <tr>
                                <th>Diagnosis:</th>
                                <td><?= htmlspecialchars($data['diagnosis']) ?></td>
                            </tr>
                            <tr>
                                <th>Treatment:</th>
                                <td><?= htmlspecialchars($data['treatment']) ?></td>
                            </tr>
                        </table>
                    </div>

                    <form action="<?= URL_ROOT ?>/doctor/delete-record/<?= $data['id'] ?>" method="POST">
                        <div class="d-flex justify-content-between">
                            <a href="<?= URL_ROOT ?>/doctor/medical-records" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-danger">Delete medical record</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include APP_ROOT . '/views/inc/dashboard-footer.php' ?>