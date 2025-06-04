<?php include APP_ROOT . '/views/inc/dashboard-header.php' ?>


<div class="card">
    <h3>Total Patients</h3>
    <h5><?= htmlspecialchars($data['totalPatients']) ?></h5>
</div>

<div class="card">
    <h3>Total Patients</h3>
    <h5><?= htmlspecialchars($data['totalAppointments']) ?></h5>
</div>


<a href="<?= URL_ROOT ?>/user/logout">
    Logout
</a>

<?php include APP_ROOT . '/views/inc/dashboard-footer.php' ?>
