<?php include APP_ROOT . '/views/inc/dashboard-header.php' ?>

<div class="table">
    <table class="table">
        <thead>
            <tr>
                <th>Doctor's Name</th>
                <th>Medicine Name</th>
                <th>Dosage</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['prescriptions'] as $prescription) : ?>
                <tr>
                    <td><?= htmlspecialchars($prescription['doctor_name']) ?></td>
                    <td><?= htmlspecialchars($prescription['medicine_name']) ?></td>
                    <td><?= htmlspecialchars($prescription['dosage']) ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?php include APP_ROOT . '/views/inc/dashboard-footer.php' ?>
