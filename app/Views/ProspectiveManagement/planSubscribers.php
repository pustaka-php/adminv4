<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container py-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
    <h6 class="fw-bold mb-0">
        Subscribers of Plan: 
        <span class="text-primary"><?= esc($planName); ?></span>
    </h6>
    <a href="<?= base_url('prospectivemanagement/planssummary'); ?>" class="btn btn-outline-secondary">
        <i class="fa fa-arrow-left me-1"></i> Back
    </a>
</div><br>


    <table class="zero-config table table-hover mt-4">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Plan</th>
                <th>Reference</th>
                <th>Payment Status</th>
                <th>Amount (₹)</th>
                <th>Payment Date</th>
                <th>Created</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($prospects)): $i=1; foreach ($prospects as $row): ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td>
                <a href="<?= base_url('prospectivemanagement/view/' . $row['id']); ?>" class="text-primary fw-bold">
                    <?= esc($row['id']); ?> <i class="fa fa-eye ms-1"></i>
                </a>
            </td>

        <td><?= esc($row['name']); ?></td>
        <td><?= esc($row['phone']); ?></td>
        <td><?= esc($row['recommended_plan']); ?></td>
        <td><?= esc($row['source_of_reference']); ?></td>
        <td>
            <?php if (strtolower($row['payment_status']) == 'paid'): ?>
                <span class="badge bg-success">Paid</span>
            <?php elseif (strtolower($row['payment_status']) == 'partial'): ?>
                <span class="badge bg-warning text-dark">Partial</span>
            <?php else: ?>
                <span class="badge bg-danger">Pending</span>
            <?php endif; ?>
        </td>
        <td>₹<?= number_format($row['payment_amount'] ?? 0, 2); ?></td>
        <td><?= !empty($row['payment_date']) ? date('d-m-y', strtotime($row['payment_date'])) : '-'; ?></td>
        <td><?= !empty($row['created_at']) ? date('d-m-y', strtotime($row['created_at'])) : '-'; ?></td>
        <td>
            <?php 
                $status = $row['prospectors_status'];
                if ($status == 1) echo '<span class="badge bg-success">Closed</span>';
                elseif ($status == 2) echo '<span class="badge bg-danger">Denied</span>';
                else echo '<span class="badge bg-info">In Progress</span>';
            ?>
        </td>
    </tr>
<?php endforeach; else: ?>
    <tr>
        <td colspan="10" class="text-center py-5">
            <iconify-icon icon="mdi:account-off-outline" class="fs-1 text-muted d-block mb-2"></iconify-icon>
            <span class="text-muted fw-semibold">No Subscribers Found for this Plan</span>
        </td>
    </tr>
<?php endif; ?>
</tbody>
    </table>
</div>

<?= $this->endSection(); ?>
