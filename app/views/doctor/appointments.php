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
                        <?php if ($appointment['status'] === 'pending') : ?>
                            <form action="<?= URL_ROOT ?>/doctor/update-status" method="POST">
                                <input type="hidden" name="appointment_id" value="<?= $appointment['id'] ?>">
                                <button type="submit" name="status" value="approved_by_doctor">Approve</button>
                                <button type="submit" name="status" value="rejected">Reject</button>
                            </form>
                        <?php else: ?>
                            <span>No action</span>
                        <?php endif ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>



<?php include APP_ROOT . '/views/inc/dashboard-footer.php' ?>