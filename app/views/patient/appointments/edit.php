<?php include APP_ROOT . '/views/inc/dashboard-header.php' ?>

<form action="<?= URL_ROOT ?>/patient/edit-appointment/<?= $data['id'] ?>" method="POST">

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
    </div>

    <div>
        <label for="date">Date</label>
        <input type="date" name="scheduled_date" id="date" value="<?= htmlspecialchars(date('Y-m-d', strtotime($data['scheduled_date']))) ?>" required>
    </div>

    <div>
        <label for="reason">Reason</label>
        <textarea name="reason" id="reason" required><?= htmlspecialchars($data['reason']) ?></textarea>
    </div>
    
    <a href="<?= URL_ROOT ?>/patient/appointments" class="btn btn-secondary">Cancel</a>
    <button type="submit">Update appointment</button>

</form>

<?php include APP_ROOT . '/views/inc/dashboard-footer.php' ?>