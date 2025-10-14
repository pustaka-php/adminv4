<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="layout-px-spacing">
    <div class="row">
        <div class="col-12 mb-3">
            <a href="<?= base_url('pod/paidinvoices'); ?>" class="btn btn-secondary">
                <i class="fa fa-arrow-left me-2"></i> Back
            </a>
        </div>

        <div class="col-12">
            <div class="card shadow-sm radius-12 border">
                <div class="card-header bg-transparent">
                    <h5>Paid Invoice Details - <?= esc($publisher['publisher_name']); ?></h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-4 zero-config text-center align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Book Title</th>
                                    <th>Copies</th>
                                    <th>Invoice Value (₹)</th>
                                    <th>Invoice Number</th>
                                    <th>Invoice Date</th>
                                    <th>Payment Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($books)): ?>
                                    <?php $i = 1; foreach ($books as $book): ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= esc($book['book_title']); ?></td>
                                        <td><?= esc($book['num_copies']); ?></td>
                                        <td><?= number_format($book['invoice_value'], 2); ?></td>
                                        <td><?= esc($book['invoice_number']); ?></td>
                                        <td><?= esc($book['invoice_date']); ?></td>
                                        <td><?= esc($book['payment_date']); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7">No invoices found for this publisher.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
