<?php include APP_ROOT . '/views/inc/dashboard-header.php' ?>

<a href="<?= URL_ROOT ?>/admin/add-billing">
    Add Billing
</a>

<div class="table">
    <table class="table">
        <thead>
            <tr>
                <th>Patient Name</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Description</th>
                <th>Issued Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['billings'] as $billing) : ?>
                <tr>
                    <td><?= htmlspecialchars($billing['patient_name']) ?></td>
                    <td><?= htmlspecialchars(number_format($billing['amount'], 2)) ?></td>
                    <td><?= htmlspecialchars($billing['status']) ?></td>
                    <td><?= htmlspecialchars($billing['description']) ?></td>
                    <td><?= htmlspecialchars(date('M d, Y', strtotime($billing['issued_date']))) ?></td>
                    <td> 
                        <?php if ($billing['status'] === 'unpaid') : ?>
                            <a href="<?= URL_ROOT ?>/admin/edit-billing/<?= $billing['id'] ?>">Edit</a>
                            <a href="<?= URL_ROOT ?>/admin/delete-billing/<?= $billing['id'] ?>">Delete</a>
                        <?php else : ?>
                            <span>No action available</span>
                        <?php endif ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>



<?php include APP_ROOT . '/views/inc/dashboard-footer.php' ?>