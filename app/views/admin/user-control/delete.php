<?php $title = 'Admin - Delete-Users' ?>
<?php include APP_ROOT . '/views/inc/dashboard-header.php' ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">Delete User Confirmation</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <strong>Warning!</strong> Are you sure you want to delete this user? This action cannot be undone.
                    </div>

                    <div class="user-details mb-4">
                        <h5>User Details:</h5>
                        <table class="table">
                            <tr>
                                <th>Username:</th>
                                <td><?= htmlspecialchars($data['user']['username']) ?></td>
                            </tr>
                            <tr>
                                <th>Full Name:</th>
                                <td><?= htmlspecialchars($data['user']['full_name']) ?></td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td><?= htmlspecialchars($data['user']['email']) ?></td>
                            </tr>
                            <tr>
                                <th>Phone:</th>
                                <td><?= htmlspecialchars($data['user']['phone']) ?></td>
                            </tr>
                            <tr>
                                <th>Role:</th>
                                <td><?= ucfirst(htmlspecialchars($data['user']['role'])) ?></td>
                            </tr>
                        </table>
                    </div>

                    <form action="<?= URL_ROOT ?>/admin/delete-user/<?= $data['user']['id'] ?>" method="POST">
                        <div class="d-flex justify-content-between">
                            <a href="<?= URL_ROOT ?>/admin/user-management" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-danger">Delete User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include APP_ROOT . '/views/inc/dashboard-footer.php' ?>