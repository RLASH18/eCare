<?php include APP_ROOT . '/views/inc/dashboard-header.php' ?>

<form action="<?= URL_ROOT ?>/doctor/edit-prescriptions/<?= $data['id'] ?>" method="POST">

    <input type="hidden" name="id" id="id" value="<?= $data['id'] ?>">
    
    <div>
        <label for="record_id">Medical Record</label>
        <select name="record_id" id="record_id" required>
            <option value="" disabled selected>Choose a medical record</option>
            <?php foreach ($data['records'] as $record) : ?>
                <option value="<?= htmlspecialchars($record['id']) ?>"
                    <?= ($record['id'] == $data['record_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($record['patient_name']) ?> -
                    <?= htmlspecialchars($record['diagnosis']) ?>
                </option>
            <?php endforeach ?>
        </select>
        <?php if (!empty($data['record_id_err'])): ?>
            <p><?= $data['record_id_err'] ?></p>
        <?php endif ?>
    </div>

    <div>
        <label for="medicine_name">Medicine name</label>
        <input name="medicine_name" id="medicine_name" value="<?= htmlspecialchars($data['medicine_name']) ?>"></input>
        <?php if (!empty($data['medicine_err'])): ?>
            <p><?= $data['medicine_err'] ?></p>
        <?php endif ?>
    </div>

    <div>
        <label for="dosage">Dosage</label>
        <input name="dosage" id="dosage" value="<?= htmlspecialchars($data['dosage']) ?>"></input>
        <?php if (!empty($data['dosage_err'])) : ?>
            <p><?= $data['dosage_err'] ?></p>
        <?php endif ?>
    </div>

    <a href="<?= URL_ROOT ?>/doctor/prescriptions" class="btn btn-secondary">Cancel</a>
    <button type="submit">Update prescriptions</button>

</form>

<?php include APP_ROOT . '/views/inc/dashboard-footer.php' ?>