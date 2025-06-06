<?php include APP_ROOT . '/views/inc/dashboard-header.php' ?>

<div class="table">
    <table class="table">
        <thead>
            <tr>
                <th>Patients Name</th>
                <th>Diagnosis</th>
                <th>Treatment</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['records'] as $record): ?>
                <tr>
                    <td><?= htmlspecialchars($record['doctor_name']) ?></td>
                    <td><?= htmlspecialchars($record['diagnosis']) ?></td>
                    <td><?= htmlspecialchars($record['treatment']) ?></td>
                    <td><?= htmlspecialchars(date('M d, Y', strtotime($record['created_at']))) ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?php include APP_ROOT . '/views/inc/dashboard-footer.php' ?>