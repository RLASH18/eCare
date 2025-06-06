<?php include APP_ROOT . '/views/inc/dashboard-header.php' ?>

<form action="<?= URL_ROOT ?>/admin/edit-user/<?= $data['id'] ?>" method="POST">

    <input type="hidden" name="id" id="id" value="<?= $data['id'] ?>">

    <div>
        <label for="username">Username</label>
        <input type="text" name="username" value="<?= htmlspecialchars($data['username']) ?>" required>
        <?php if (!empty($data['username_err'])): ?>
            <p><?= $data['username_err'] ?></p>
        <?php endif ?>
    </div>

    <div>
        <label for="password">Password</label>
        <input type="password" name="password">
        <?php if (!empty($data['password_err'])): ?>
            <p><?= $data['password_err'] ?></p>
        <?php endif ?>

    </div>

    <div>
        <label for="confirm_password">Confirm password</label>
        <input type="password" name="confirm_password">

        <?php if (!empty($data['confirm_password_err'])): ?>
            <p><?= $data['confirm_password_err'] ?></p>
        <?php endif ?>
    </div>

    <div>
        <label for="full_name">full name</label>
        <input type="text" name="full_name" value="<?= htmlspecialchars($data['full_name']) ?>" required>

        <?php if (!empty($data['full_name_err'])): ?>
            <p><?= $data['full_name_err'] ?></p>
        <?php endif ?>
    </div>

    <div>
        <label for="email">Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($data['email']) ?>" required>

        <?php if (!empty($data['email_err'])): ?>
            <p><?= $data['email_err'] ?></p>
        <?php endif ?>
    </div>

    <div>
        <label for="phone">Phone number</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($data['phone']) ?>" required>

        <?php if (!empty($data['phone_err'])): ?>
            <p><?= $data['phone_err'] ?></p>
        <?php endif ?>
    </div>

    <div>
        <label for="role">Role</label>
        <select name="role" id="role" required>
            <option value="" disabled selected>Select Role</option>
            <option value="admin" <?= htmlspecialchars($data['role'] === 'admin' ? 'selected' : '') ?>>Admin</option>
            <option value="doctor" <?= htmlspecialchars($data['role'] === 'doctor' ? 'selected' : '') ?>>Doctor</option>
            <option value="patient" <?= htmlspecialchars($data['role'] === 'patient' ? 'selected' : '') ?>>Patient</option>
        </select>

        <?php if (!empty($data['role_err'])): ?>
            <p><?= $data['role_err'] ?></p>
        <?php endif ?>
    </div>
    
    <a href="<?= URL_ROOT ?>/admin/user-management" class="btn btn-secondary">Cancel</a>
    <button type="submit">Update user</button>
</form>


<?php include APP_ROOT . '/views/inc/dashboard-footer.php' ?>