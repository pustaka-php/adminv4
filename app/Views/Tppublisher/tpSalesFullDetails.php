<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container py-4">

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col">
            <h4 class="fw-bold text-primary">Sales Details</h4>
            <p class="text-muted mb-0">Complete details of book sales with payment status</p>
        </div>
    </div>

    <!-- Sales Info Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Summary -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 bg-light">
                <div class="card-header py-2">
                    <span class="fw-bold fs-5">Sales Summary</span>
                </div>
                <div class="card-body">
                    <p><strong>Sales Channel:</strong> <?= esc($details[0]['sales_channel'] ?? '-') ?></p>
                    <p><strong>Payment Status:</strong> <?= esc($details[0]['paid_status'] ?? '-') ?></p>
                    <p><strong>Payment Date:</strong> 
                        <?= !empty($details[0]['paid_date']) ? date('d-M-Y H:i', strtotime($details[0]['paid_date'])) : '-' ?>
                    </p>
                    <hr>
                    <p><strong>Total Amount:</strong> ₹<?= number_format(array_sum(array_column($details, 'total_amount')), 2) ?></p>
                    <p><strong>Total Discount:</strong> ₹<?= number_format(array_sum(array_column($details, 'discount')), 2) ?></p>
                    <p><strong>Total Author Amount:</strong> ₹<?= number_format(array_sum(array_column($details, 'author_amount')), 2) ?></p>
                </div>
            </div>
        </div>

        <!-- Publisher Info -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 bg-light">
                <div class="card-header py-2">
                    <span class="fw-bold fs-5">Publisher Info</span>
                </div>
                <div class="card-body">
                    <p><strong>Publisher ID:</strong> <?= esc($details[0]['publisher_id'] ?? '-') ?></p>
                    <p><strong>Author Name:</strong> <?= esc($details[0]['author_name'] ?? '-') ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Books Table -->
    <div class="card shadow-sm border-0 bg-light">
        <div class="card-header py-2">
            <span class="fw-bold fs-5">Books Sold</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Book Title</th>
                            <th>SKU No</th>
                            <th>Total Amount</th>
                            <th>Discount</th>
                            <th>Author Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($details)): ?>
                            <?php foreach ($details as $i => $d): ?>
                                <tr>
                                    <td><?= $i + 1; ?></td>
                                    <td><?= esc($d['book_title']); ?></td>
                                    <td><?= esc($d['sku_no']); ?></td>
                                    <td>₹<?= number_format($d['total_amount'], 2); ?></td>
                                    <td>₹<?= number_format($d['discount'], 2); ?></td>
                                    <td>₹<?= number_format($d['author_amount'], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">No sales details found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection(); ?>
