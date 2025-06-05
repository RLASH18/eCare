<?php include APP_ROOT . '/views/inc/dashboard-header.php' ?>

<h1>List of Users</h1>
<a href="<?= URL_ROOT ?>/admin/add-user" class="inline-flex items-center">
    <i class="fas fa-plus mr-2"></i> Add Student
</a>

<div class="table">
    <table class="table">
        <thead>
            <tr>
                <th>Full name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['users'] as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= htmlspecialchars($user['full_name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['phone']) ?></td>
                    <td><?= htmlspecialchars($user['role']) ?></td>
                    <td>
                        <?php if ($user['role'] === 'admin') : ?>
                            <span>No action</span>
                        <?php else : ?>
                            <a href="<?= URL_ROOT ?>/admin/edit-user/<?= $user['id'] ?>">Edit</a>
                            <a href="<?= URL_ROOT ?>/admin/delete-user/<?= $user['id'] ?>">Delete</a>
                        <?php endif ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?php include APP_ROOT . '/views/inc/dashboard-footer.php' ?>