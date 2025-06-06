<?php include APP_ROOT . '/views/inc/dashboard-header.php' ?>

<main class="main-content grid grid-cols-4 grid-rows-2 gap-4 p-4">

    <div class="card text-blue-600 font-bold">
        <img src="<?= URL_ROOT ?>/assets/img/users.png" alt="">
        <div>
            <h3>Total Users</h3>
            <h5><?= htmlspecialchars($data['totalUsers']) ?></h5>
        </div>
    </div>

    <div class="card text-blue-600 font-bold">
        <img src="<?= URL_ROOT ?>/assets/img/doctor.png" alt="">
        <div>
            <h3>Total Doctors</h3>
            <h5><?= htmlspecialchars($data['totalDoctors']) ?></h5>
        </div>
    </div>

    <div class="card text-blue-600 font-bold">
        <img src="<?= URL_ROOT ?>/assets/img/hospitalisation.png" alt="">
        <div>
            <h3>Total Patients</h3>
            <h5><?= htmlspecialchars($data['totalPatients']) ?></h5>
        </div>
    </div>

    <div class="card text-blue-600 font-bold">
        <img src="<?= URL_ROOT ?>/assets/img/revenue.png" alt="">
        <div>
            <h3>Total Revenue</h3>
            <h5>₱ <?= htmlspecialchars(number_format($data['totalRevenue'], 2)) ?></h5>
        </div>
    </div>


    <div class="table-container row-start-2 col-span-4">
        <h3 class="text-center mb-5 font-bold text-2xl">Recent Registrations</h3>
        <table class="table-auto w-full border border-gray-300">
            <thead>
                <tr class="text-zinc-50">
                    <th class="border border-gray-300 px-4 py-2">Username</th>
                    <th class="border border-gray-300 px-4 py-2">Full name</th>
                    <th class="border border-gray-300 px-4 py-2">Role</th>
                    <th class="border border-gray-300 px-4 py-2">Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['recentRegistrations'] as $user): ?>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 text-center"><?= htmlspecialchars($user['username']) ?></td>
                        <td class="border border-gray-300 px-4 py-2 text-center"><?= htmlspecialchars($user['full_name']) ?></td>
                        <td class="border border-gray-300 px-4 py-2 text-center"><?= htmlspecialchars(ucfirst($user['role'])) ?></td>
                        <td class="border border-gray-300 px-4 py-2 text-center"><?= htmlspecialchars(date('M d, Y', strtotime($user['created_at']))) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>


</main>

<?php include APP_ROOT . '/views/inc/dashboard-footer.php' ?>