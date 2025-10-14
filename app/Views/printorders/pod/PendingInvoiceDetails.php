<?= $this->extend('layout/layout1'); ?>


<?= $this->section('content'); ?> 
<div class="layout-px-spacing">
    <h5>Pending Invoices: <?= $publisher_name; ?></h5>
    <div class="table-responsive mt-3">
        <table class="table table-bordered mb-4 zero-config text-center align-middle">
            <thead>
                <tr>
                    <th>Book ID</th>
                    <th>Book Title</th>
                    <th>Invoice Value</th>
                    <th>Pages</th>
                    <th>Copies</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($invoice_details as $book): ?>
                <tr>
                    <td><?= $book['book_id']; ?></td>
                    <td><?= $book['book_title']; ?></td>
                    <td>₹ <?= number_format($book['invoice_value'],2); ?></td>
                    <td><?= $book['total_num_pages']; ?></td>
                    <td><?= $book['num_copies']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection(); ?>