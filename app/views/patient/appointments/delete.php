<?php $title = 'Admin - Delete-Users' ?>
<?php include APP_ROOT . '/views/inc/dashboard-header.php' ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">Delete appointment Confirmation</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <strong>Warning!</strong> Are you sure you want to delete this user? This action cannot be undone.
                    </div>

                    <div class="user-details mb-4">
                        <h5>Appointment Details:</h5>
                        <table class="table">
                            <tr>
                                <th>Doctor name:</th>
                                <td><?= htmlspecialchars($data['appointment']['doctor_name']) ?></td>
                            </tr>
                            <tr>
                                <th>Scheduled date:</th>
                                <td><?= htmlspecialchars($data['appointment']['scheduled_date']) ?></td>
                            </tr>
                            <tr>
                                <th>Reason:</th>
                                <td><?= htmlspecialchars($data['appointment']['reason']) ?></td>
                            </tr>
                        </table>
                    </div>

                    <form action="<?= URL_ROOT ?>/patient/delete-appointment/<?= $data['appointment']['id'] ?>" method="POST">
                        <div class="d-flex justify-content-between">
                            <a href="<?= URL_ROOT ?>/patient/appointments" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-danger">Delete appointment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include APP_ROOT . '/views/inc/dashboard-footer.php' ?>