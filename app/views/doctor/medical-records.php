<?php include APP_ROOT . '/views/inc/dashboard-header.php' ?>

<a href="<?= URL_ROOT ?>/doctor/add-record">
    Add record
</a>

<div class="table">
    <table class="table">
        <thead>
            <tr>
                <th>Patients Name</th>
                <th>Diagnosis</th>
                <th>Treatment</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['records'] as $record): ?>
                <tr>
                    <td><?= htmlspecialchars($record['patient_name']) ?></td>
                    <td><?= htmlspecialchars($record['diagnosis']) ?></td>
                    <td><?= htmlspecialchars($record['treatment']) ?></td>
                    <td><?= htmlspecialchars(date('M d, Y', strtotime($record['created_at']))) ?></td>
                    <td>
                        <a href="<?= URL_ROOT ?>/doctor/edit-record/<?= $record['id'] ?>">Edit</a>
                        <a href="<?= URL_ROOT ?>/doctor/delete-record/<?= $record['id'] ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>


<?php include APP_ROOT . '/views/inc/dashboard-footer.php' ?>