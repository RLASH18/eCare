<?php include APP_ROOT . '/views/inc/dashboard-header.php' ?>

<h1><?= $data['patient_name'] ?></h1>

<form action="<?= URL_ROOT ?>/admin/edit-appointment/<?= $data['id'] ?>" method="POST">

    <input type="hidden" name="id" id="id" value="<?= $data['id'] ?>">

    <div>
        <label for="doctors_name">Doctor's Name</label>
        <select name="doctor_id" id="" required>
            <option value="" disabled selected>Choose your doctor</option>
            <?php foreach ($data['doctors'] as $doctor) : ?>
                <option value="<?= htmlspecialchars($doctor['id']) ?>"
                    <?= ($doctor['id'] == $data['doctor_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($doctor['full_name']) ?>
                </option>
            <?php endforeach ?>
        </select>
        <?php if (!empty($data['doctor_id_err'])): ?>
            <p><?= $data['doctor_id_err'] ?></p>
        <?php endif ?>
    </div>

    <div>
        <label for="date">Date</label>
        <input type="date" name="scheduled_date" id="date" value="<?= htmlspecialchars(date('Y-m-d', strtotime($data['scheduled_date']))) ?>" required>
        <?php if (!empty($data['scheduled_date_err'])): ?>
            <p><?= $data['scheduled_date_err'] ?></p>
        <?php endif ?>
    </div>

    <div>
        <label for="reason">Reason</label>
        <textarea name="reason" id="reason" readonly><?= htmlspecialchars($data['reason']) ?></textarea>
                <?php if (!empty($data['reason_err'])): ?>
            <p><?= $data['reason_err'] ?></p>
        <?php endif ?>
    </div>

    <a href="<?= URL_ROOT ?>/admin/appointments" class="btn btn-secondary">Cancel</a>
    <button type="submit">Update appointment</button>
    
</form>

<?php include APP_ROOT . '/views/inc/dashboard-footer.php' ?>