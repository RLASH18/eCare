<?php include APP_ROOT . '/views/inc/dashboard-header.php' ?>

<form action="<?= URL_ROOT ?>/doctor/edit-record/<?= $data['id'] ?>" method="POST">

    <input type="hidden" name="id" id="id" value="<?= $data['id'] ?>">
    <div>
        <label for="patient_name">Patients's Name</label>
        <select name="patient_id" id="patient_name" required>
            <option value="" disabled selected>Choose your patient</option>
            <?php foreach ($data['patients'] as $patient) : ?>
                <option value="<?= htmlspecialchars($patient['id']) ?>"
                    <?= ($patient['id'] == $data['patient_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($patient['full_name']) ?>
                </option>
            <?php endforeach ?>
        </select>
    </div>

    <div>
        <label for="diagnosis">Diagnosis</label>
        <textarea name="diagnosis" id="diagnosis"><?= htmlspecialchars($data['diagnosis']) ?></textarea>
    </div>

    <div>
        <label for="treatment">Treatment</label>
        <textarea name="treatment" id="treatment" required><?= htmlspecialchars($data['treatment']) ?></textarea>
    </div>

    <button type="submit">Update medical record</button>
</form>

<?php include APP_ROOT . '/views/inc/dashboard-footer.php' ?>