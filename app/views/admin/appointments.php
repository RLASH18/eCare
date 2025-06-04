<?php include APP_ROOT . '/views/inc/dashboard-header.php' ?>

<div class="table">
    <table class="table">
        <thead>
            <tr>
                <th>Patient name</th>
                <th>Doctor name</th>
                <th>Schedule</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['appointments'] as $appointment): ?>
                <tr>
                    <td><?= htmlspecialchars($appointment['patient_name']) ?></td>
                    <td><?= htmlspecialchars($appointment['doctor_name']) ?></td>
                    <td><?= htmlspecialchars(date('F d, Y', strtotime($appointment['scheduled_date']))) ?></td>
                    <td>
                        <?php if ($appointment['status'] === 'pending'): ?>
                            <span class="status-pending">Pending</span>
                        <?php elseif ($appointment['status'] === 'approved_by_admin'): ?>
                            <span class="status-approved">Approved by Admin</span>
                        <?php elseif ($appointment['status'] === 'approved_by_doctor'): ?>
                            <span class="status-approved">Approved by Doctor</span>
                        <?php elseif ($appointment['status'] === 'rejected'): ?>
                            <span class="status-rejected">Rejected</span>
                        <?php endif ?>
                    </td>
                    <td>    
                        <?php if ($appointment['status'] === 'pending'): ?>
                            <a href="<?= URL_ROOT ?>/admin/edit-appointment/<?= $appointment['id'] ?>">Edit</a>
                            <form action="<?= URL_ROOT ?>/admin/update-status" method="POST">
                                <input type="hidden" name="appointment_id" value="<?= $appointment['id'] ?>">
                                <button type="submit" name="status" value="approved_by_admin">Approve</button>
                                <button type="submit" name="status" value="rejected">Cancel</button>
                            </form>
                        <?php else : ?>
                            <span>No action available</span>
                        <?php endif ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>


<?php include APP_ROOT . '/views/inc/dashboard-footer.php' ?>