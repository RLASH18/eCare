<?php include APP_ROOT . '/views/inc/dashboard-header.php' ?>

<div class="table">
    <table class="table">
        <thead>
            <tr>
                <th>Amount</th>
                <th>Status</th>
                <th>Description</th>
                <th>Issued Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['billings'] as $billing) : ?>
                <tr>
                    <td><?= htmlspecialchars($billing['amount']) ?></td>
                    <td><?= htmlspecialchars($billing['status']) ?></td>
                    <td><?= htmlspecialchars($billing['description']) ?></td>
                    <td><?= htmlspecialchars(date('M d, Y', strtotime($billing['issued_date']))) ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?php include APP_ROOT . '/views/inc/dashboard-footer.php' ?>