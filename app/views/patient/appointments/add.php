<?php include APP_ROOT . '/views/inc/dashboard-header.php' ?>

<form action="<?= URL_ROOT ?>/patient/add-appointment" method="POST">
    <div>
        <label for="doctors_name">Doctor's Name</label>
        <select name="doctor_id" id="" required>
            <option value="" disabled selected>Choose your doctor</option>
            <?php foreach($data['doctors'] as $doctor) : ?>
                <option value="<?= htmlspecialchars($doctor['id']) ?>">
                    <?= htmlspecialchars($doctor['full_name']) ?>
                </option>
            <?php endforeach ?>
        </select>
    </div>

    <div>
        <label for="date">Date</label>
        <input type="date" name="scheduled_date" id="date" required>
    </div>

    <div>
        <label for="reason">Reason</label>
        <textarea name="reason" id="reason" required></textarea>
    </div>

    <button type="submit">Add appointment</button>
</form>


<?php include APP_ROOT . '/views/inc/dashboard-footer.php' ?>