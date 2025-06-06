<?php include APP_ROOT . '/views/inc/dashboard-header.php' ?>

<a href="<?= URL_ROOT ?>/doctor/add-prescriptions">
    add prescription
</a>

<div class="table">
    <table class="table">
        <thead>
            <tr>
                <th>Patient Name</th>
                <th>Diagnosis</th>
                <th>Medicine Name</th>
                <th>Dosage</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['prescriptions'] as $prescription): ?>
                <tr>
                    <td><?= htmlspecialchars($prescription['patient_name']) ?></td>
                    <td><?= htmlspecialchars($prescription['diagnosis']) ?></td>
                    <td><?= htmlspecialchars($prescription['medicine_name']) ?></td>
                    <td><?= htmlspecialchars($prescription['dosage']) ?></td>
                    <td>
                        <a href="<?= URL_ROOT ?>/doctor/edit-prescriptions/<?= $prescription['id'] ?>">Edit</a>
                        <a href="<?= URL_ROOT ?>/doctor/delete-prescriptions/<?= $prescription['id'] ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?php include APP_ROOT . '/views/inc/dashboard-footer.php' ?>