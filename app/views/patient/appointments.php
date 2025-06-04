<?php include APP_ROOT . '/views/inc/dashboard-header.php' ?>

<h1>List of Appointments</h1>

<a href="<?= URL_ROOT ?>/patient/add-appointment">
    Add Appointment
</a>

<div class="table">
    <table class="table">
        <thead>
            <tr>
                <th>Doctor's Name</th>
                <th>Date</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['appointments'] as $appointment) : ?>
                <tr>
                    <td><?= htmlspecialchars($appointment['doctor_name']) ?></td>
                    <td><?= htmlspecialchars(date('F d, Y', strtotime($appointment['scheduled_date']))) ?></td>
                    <td><?= htmlspecialchars($appointment['reason']) ?></td>
                    <td>
                        <?php if ($appointment['status'] === 'pending'): ?>
                            <span class="status-pending">Pending</span>
                        <?php elseif ($appointment['status'] === 'approved_by_admin'): ?>
                            <span class="status-approved">Approved by Admin</span>
                        <?php elseif ($appointment['status'] === 'approved_by_doctor'): ?>
                            <span class="status-approved">Approved by Doctor</span>
                        <?php elseif ($appointment['status'] === 'rejected'): ?>
                            <span class="status-cancelled">Rejected</span>
                        <?php endif ?>
                    </td>
                    <td>
                        <?php if ($appointment['status'] === 'pending'): ?>
                            <a href="<?= URL_ROOT ?>/patient/edit-appointment/<?= $appointment['id'] ?>">Edit</a>
                            <a href="<?= URL_ROOT ?>/patient/delete-appointment/<?= $appointment['id'] ?>">Delete</a>
                        <?php else : ?>
                            <span class="no-action">No action available</span>
                        <?php endif ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?php include APP_ROOT . '/views/inc/dashboard-footer.php' ?>