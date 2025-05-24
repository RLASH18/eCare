<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Dashboard</title>
</head>

<body>


    <div class="card">
        <h3>Total Users</h3>
        <h5><?= $data['totalUsers'] ?></h5>
    </div>

    <div class="card">
        <h3>Total Doctors</h3>
        <h5><?= $data['totalDoctors'] ?></h5>
    </div>

    <div class="card">
        <h3>Total Patients</h3>
        <h5><?= $data['totalPatients'] ?></h5>
    </div>

    <div class="card">
        <h3>Total Revenue</h3>
        <h5>₱ <?= number_format($data['totalRevenue'], 2)?></h5>
    </div>


    <div class="div">
        <h3>Recent Registrations</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Full name</th>
                    <th>Role</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['recentRegistrations'] as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['full_name']) ?></td>
                        <td><?= ucfirst($user['role']) ?></td>
                        <td><?= date('M d, Y', strtotime($user['created_at'])) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

    <a href="<?= URL_ROOT ?>/user/logout">
        Logout
    </a>
</body>

</html>