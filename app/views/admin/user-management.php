<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <title>Admin - User-Management</title>
</head>

<body>
    

    <h1>List of Users</h1>
    <a href="<?= URL_ROOT ?>/admin/add-user" class="inline-flex items-center">
        <i class="fas fa-plus mr-2"></i> Add Student
    </a>

    <div class="table">
        <table class="table">
            <thead>
                <tr>
                    <th>id</th>
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
                        <td><?= $user['id'] ?></td>
                        <td><?= $user['full_name'] ?></td>
                        <td><?= $user['username'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td><?= $user['phone'] ?></td>
                        <td><?= $user['role'] ?></td>
                        <td>
                            <a href="">Edit</a>
                            <a href="">Delete</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</body>

</html>