<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<h4 class="text-center mb-4"><?= $title ?></h4>

<div class="table-responsive">
    <table class="table table-bordered zero-config">
        <thead>
        <tr>
            <th>Book ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Qty</th>
            <th>Stock In Hand</th>
            <th>Lost</th>
            <th>Excess</th>
        </tr>
        </thead>

        <tbody>
        <?php if (!empty($filtered)): ?>
            <?php foreach ($filtered as $row): ?>
                <tr>
                    <td><?= $row['book_id'] ?></td>
                    <td><?= $row['book_title'] ?></td>
                    <td><?= $row['author_name'] ?></td>
                    <td><?= $row['quantity'] ?></td>
                    <td><?= $row['stock_in_hand'] ?></td>
                    <td><?= $row['lost_qty'] ?></td>
                    <td><?= $row['excess_qty'] ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="7" class="text-center">No Data Found</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<a href="<?= base_url('stock/getstockdetails') ?>" class="btn btn-dark mt-3">⬅ Back</a>
<?= $this->endSection(); ?>
