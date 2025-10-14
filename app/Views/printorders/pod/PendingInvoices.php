<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 

<div class="layout-px-spacing">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm radius-12 border">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Pending Invoices</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-4 zero-config text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Publisher Name</th>
                                    <th>Total Books</th>
                                    <th>Invoice Value (₹)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; foreach($pending_invoices as $invoice): ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= esc($invoice['publisher_name']); ?></td>
                                    <td><?= esc($invoice['total_books']); ?></td>
                                    <td><?= number_format($invoice['total_invoice_value'],2); ?></td>
                                    <td>
                                        <a href="<?= base_url('pod/pendinginvoicedetails/' . $invoice['publisher_id']); ?>" class="btn btn-sm btn-primary">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if(empty($pending_invoices)): ?>
                                <tr>
                                    <td colspan="5">No pending invoices found.</td>
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
