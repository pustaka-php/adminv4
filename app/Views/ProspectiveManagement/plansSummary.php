<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container py-3">
    <h6 class="fw-bold mb-4">Plan Summary</h6>

    <table class="zero-config table table-hover mt-4 align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Plan Name</th>
                <th>Total Titles</th>
                <th>Total Amount (₹)</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($plans)): $i=1; foreach ($plans as $row): ?>
            <tr>
                <td><?= $i++; ?></td>
                <td><?= esc($row['plan_name']); ?></td>
                <td><span class="badge bg-info"><?= esc($row['total_titles']); ?></span></td>
                <td><?= indian_format($row['total_amount'] ?? 0, 2); ?></td>
                <td>
                    <a href="<?= base_url('prospectivemanagement/viewplan/' . urlencode($row['plan_name'])); ?>" 
                        class="btn btn-sm btn-outline-primary">
                        View Details
                    </a>
                </td>
            </tr>
        <?php endforeach; else: ?>
            <tr>
                <td colspan="5" class="text-center text-muted py-3">No Plans Found</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection(); ?>
