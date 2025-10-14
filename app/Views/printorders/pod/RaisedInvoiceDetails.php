<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="layout-px-spacing">
    <div class="row">
        <div class="col-12">
            <a href="<?= base_url('pod/raisedinvoices'); ?>" class="btn btn-secondary mb-3">
                <i class="fa fa-arrow-left me-2"></i> Back
            </a>

            <div class="card shadow-sm radius-12 border">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">Raised Invoice Details - <?= esc($publisher['publisher_name']); ?></h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-4 zero-config text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Book Title</th>
                                    <th>Copies</th>
                                    <th>Invoice Value (₹)</th>
                                    <th>Invoice Number</th>
                                    <th>Invoice Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; foreach($books as $book): ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= esc($book['book_title']); ?></td>
                                    <td><?= esc($book['num_copies']); ?></td>
                                    <td><?= number_format($book['invoice_value'],2); ?></td>
                                    <td><?= esc($book['invoice_number']); ?></td>
                                    <td><?= esc($book['invoice_date']); ?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if(empty($books)): ?>
                                <tr>
                                    <td colspan="6">No raised invoices found for this publisher.</td>
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
