<?php $title = 'Doctor - Appointments' ?>
<?php include APP_ROOT . '/views/inc/dashboard-header.php' ?>

<h1>Appointment Request</h1>

<div class="table">
    <table class="table">
        <thead>
            <tr>
                <th>Patient Name</th>
                <th>Scheduled date</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['appointments'] as $appointment): ?>
                <tr>
                    <td><?= htmlspecialchars($appointment['patient_name']) ?></td>
                    <td><?= date('F d, Y', strtotime($appointment['scheduled_date'])) ?></td>
                    <td><?= htmlspecialchars($appointment['reason']) ?></td>
                    <td>
                        <?php if ($appointment['status'] === 'pending'): ?>
                            <span class="status-pending">Pending</span>
                        <?php elseif ($appointment['status'] === 'approved'): ?>
                            <span class="status-approved">Approved</span>
                        <?php elseif ($appointment['status'] === 'cancelled'): ?>
                            <span class="status-cancelled">Cancelled</span>
                        <?php endif ?>
                    </td>
                    <td>
                        <?php if ($appointment['status'] === 'pending') : ?>
                            <form action="<?= URL_ROOT ?>/doctor/update-status" method="POST">
                                <input type="hidden" name="appointment_id" value="<?= $appointment['id'] ?>">
                                <button type="submit" name="status" value="approved">Approve</button>
                                <button type="submit" name="status" value="cancelled">Cancel</button>
                            </form>
                        <?php endif ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>



<?php include APP_ROOT . '/views/inc/dashboard-footer.php' ?>