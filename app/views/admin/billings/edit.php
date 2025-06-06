<?php include APP_ROOT . '/views/inc/dashboard-header.php' ?>

<form action="<?= URL_ROOT ?>/admin/edit-billing/<?= $data['id'] ?>" method="POST">
    
    <input type="hidden" name="id" id="id" value="<?= $data['id'] ?>">
    
    <div>
        <label for="doctors_name">Patient's Name</label>
        <select name="patient_id" id="" required>
            <option value="" disabled selected>Choose a Patient</option>
            <?php foreach ($data['patients'] as $patient) : ?>
                <option value="<?= htmlspecialchars($patient['id']) ?>"
                    <?= ($patient['id'] === $data['patient_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($patient['full_name']) ?>
                </option>
            <?php endforeach ?>
        </select>
        <?php if (!empty($data['patient_id_err'])): ?>
            <p><?= $data['patient_id_err'] ?></p>
        <?php endif ?>
    </div>

    <div>
        <label for="amount">Amount</label>
        <input type="number" name="amount" id="amount" value="<?= htmlspecialchars($data['amount']) ?>" required>
        <?php if (!empty($data['amount_err'])): ?>
            <p><?= $data['amount_err'] ?></p>
        <?php endif ?>
    </div>

    <div>
        <label for="status">Status</label>
        <select name="status" id="status">
            <option value="" disabled selected>Choose the status</option>
            <option value="unpaid" <?= ($data['status'] === 'unpaid') ? 'selected' : '' ?>>Unpaid</option>
            <option value="paid" <?= ($data['status'] === 'paid') ? 'selected' : '' ?>>Paid</option>
        </select>
        <?php if (!empty($data['status_err'])) : ?>
            <p><?= $data['status_err'] ?></p>
        <?php endif ?>
    </div>

    <div>
        <label for="description">Description</label>
        <textarea name="description" id="description" required><?= htmlspecialchars($data['description']) ?></textarea>
        <?php if (!empty($data['description_err'])): ?>
            <p><?= $data['description_err'] ?></p>
        <?php endif ?>
    </div>

    <a href="<?= URL_ROOT ?>/admin/billings" class="btn btn-secondary">Cancel</a>
    <button type="submit">Update billing</button>

</form>

<?php include APP_ROOT . '/views/inc/dashboard-footer.php' ?>