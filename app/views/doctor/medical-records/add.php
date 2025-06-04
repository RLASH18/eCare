<?php include APP_ROOT . '/views/inc/dashboard-header.php' ?>

<form action="<?= URL_ROOT ?>/doctor/add-record" method="POST">
    <div>
        <label for="patient_name">Patient's Name</label>
        <select name="patient_id" id="patient_name" required>
            <option value="" disabled selected>Choose your patient</option>
            <?php foreach($data['patients'] as $patient) : ?>
                <option value="<?= htmlspecialchars($patient['id']) ?>">
                    <?= htmlspecialchars($patient['full_name']) ?>
                </option>
            <?php endforeach ?>
        </select>
    </div>

    <div>
        <label for="diagnosis">Diagnosis</label>
        <textarea name="diagnosis" id="diagnosis"></textarea>
    </div>

    <div>
        <label for="treatment">Treatment</label>
        <textarea name="treatment" id="treatment" required></textarea>
    </div>

    <button type="submit">Add medical record</button>
</form>


<?php include APP_ROOT . '/views/inc/dashboard-footer.php' ?>