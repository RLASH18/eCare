<?php $title = 'Admin - Appointments' ?>
<?php include APP_ROOT . '/views/inc/dashboard-header.php' ?>

<div class="table">
    <table class="table">
        <thead>
            <tr>
                <th>Patient name</th>
                <th>Doctor name</th>
                <th>Schedule</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data['appointments'] as $appointment): ?>
                <tr>
                    <td><?= $appointment['patient_id'] ?></td>
                    <td><?= $appointment['doctor_id'] ?></td>
                    <td><?= $appointment['scheduled_date'] ?></td>
                    <td><?= $appointment['status'] ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>



<?php include APP_ROOT . '/views/inc/dashboard-footer.php' ?>