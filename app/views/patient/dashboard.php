<?php $title = 'Patient - Dashboard' ?>
<?php include APP_ROOT . '/views/inc/dashboard-header.php' ?>

<div class="card">
    <h3>Total Appointment</h3>
    <h5><?= htmlspecialchars($data['totalAppointments']) ?></h5>
</div>

<div class="card">
    <h3>Total Billing
        <h5><?= htmlspecialchars($data['totalBilling']) ?></h5>
    </h3>
</div>

<a href="<?= URL_ROOT ?>/user/logout">
    Logout
</a>

<?php include APP_ROOT . '/views/inc/dashboard-footer.php' ?>
