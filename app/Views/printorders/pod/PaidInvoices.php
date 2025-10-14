<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="layout-px-spacing">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm radius-12 border">
                <div class="card-header">
                    <h5>Paid Invoices</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered mb-4 zero-config text-center align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Publisher Name</th>
                                <th>Total Books</th>
                                <th>Total Invoice Value (₹)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($paid_invoices)): ?>
                                <?php $i=1; foreach($paid_invoices as $invoice): ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= esc($invoice['publisher_name']); ?></td>
                                        <td><?= $invoice['total_books']; ?></td>
                                        <td><?= number_format($invoice['total_invoice_value'],2); ?></td>
                                        <td>
                                            <a href="<?= base_url('pod/paidinvoicedetails/'.$invoice['publisher_id']); ?>" class="btn btn-primary btn-sm">
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">No paid invoices found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
