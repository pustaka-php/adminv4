<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center mb-3">
    <iconify-icon icon="mdi:cash-multiple" class="me-2 text-primary fs-4"></iconify-icon>
    <h5 class="fw-bold text-primary mb-0">Payment Summary</h5>
</div>

        <a href="<?= base_url('prospectivemanagement/dashboard'); ?>" class="btn btn-outline-secondary btn-sm">
            Back
        </a>
    </div>

    <!-- Table -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
            <table class="zero-config table table-hover mt-4">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Payment Status</th>
                        <th>Total Amount (₹)</th>
                        <th>Last Payment Date</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($payments)): $i = 1; foreach ($payments as $row): ?>
                        <?php
                            $status = ucfirst($row['payment_status']);
                            $badgeClass = match($row['payment_status']) {
                                'paid' => 'bg-success',
                                'pending' => 'bg-warning text-dark',
                                'partial' => 'bg-info text-dark',
                                default => 'bg-secondary'
                            };
                        ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><span class="badge <?= $badgeClass ?> px-3 py-2"><?= $status ?></span></td>
                            <td><?= indian_format($row['total_amount'] ?? 0, 2); ?></td>
                            <td>
                                <?= !empty($row['last_date']) 
                                    ? date('d-m-y', strtotime($row['last_date'])) 
                                    : '-'; ?>
                            </td>
                            <td class="text-center">
                                <a href="<?= base_url('prospectivemanagement/paymentdetails/' . strtolower($row['payment_status'])); ?>" 
                                   class="btn btn-sm btn-outline-primary rounded-pill">
                                   View Details
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No payment summary data found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
