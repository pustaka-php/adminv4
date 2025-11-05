<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container py-3">
    <h6 class="fw-bold mb-4"> Plan Summary</h6>

    <table class="zero-config table table-hover mt-4">
        <thead>
            <tr>
                <th>#</th>
                <th>Plan Name</th>
                <th>Subscribers</th>
                <th>Total Amount (₹)</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($plans)): $i=1; foreach ($plans as $row): ?>
            <tr>
                <td><?= $i++; ?></td>
                <td><?= esc($row['recommended_plan']); ?></td>
                <td><span class="badge bg-info"><?= esc($row['total_subscribers']); ?></span></td>
                <td>₹<?= number_format($row['total_amount'] ?? 0, 2); ?></td>
                <td>
                    <a href="<?= base_url('prospectivemanagement/viewplan/' . urlencode($row['recommended_plan'])); ?>" 
                class="btn btn-sm btn-outline-primary">
                View Details
                </a>
                </td>
            </tr>
        <?php endforeach; else: ?>
            <tr><td colspan="5" class="text-center text-muted">No Plans Found</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection(); ?>
