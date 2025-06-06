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
                    <td><?= $billing['amount'] ?></td>
                    <td><?= $billing['status'] ?></td>
                    <td><?= $billing['description'] ?></td>
                    <td><?= $billing['issued_date'] ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>



<?php include APP_ROOT . '/views/inc/dashboard-footer.php' ?>