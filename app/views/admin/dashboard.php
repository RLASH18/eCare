<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Dashboard</title>
</head>

<body>

    <div class="dashboard-stats">
        <div class="stats-card">
            <h3>Total Users</h3>
            <h5><?= $data['totalUsers']; ?></h5>
        </div>
    </div>

    <div class="dashboard-stats">
        <div class="stats-card">
            <h3>Total Doctors</h3>
            <h5><?= $data['totalDoctors']; ?></h5>
        </div>
    </div>

    <div class="dashboard-stats">
        <div class="stats-card">
            <h3>Total Patients</h3>
            <h5><?= $data['totalPatients']; ?></h5>
        </div>
    </div>

    <div class="dashboard-stats">
        <div class="stats-card">
            <h3>Total Revenue</h3>
            <h5><?= $data['totalRevenue']; ?></h5>
        </div>
    </div>

    <div class="div">
        <h3>Recent Registrations</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Full name</th>
                    <th>Role</th>
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

    <a href="<?= URL_ROOT; ?>/user/logout"
        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-sm font-medium">
        Logout
    </a>
</body>

</html>