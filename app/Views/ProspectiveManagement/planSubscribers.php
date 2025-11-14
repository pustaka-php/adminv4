<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container py-3">
    <h6 class="fw-bold mb-4">
        Subscribers for Plan: <?= esc($planName); ?>
    </h6>

    <table class="zero-config table table-hover mt-3 align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Prospector Name</th>
                <th>Title</th>
                <th>Payment Status</th>
                <th>Amount (₹)</th>
                <th>Updated On</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($prospects)): $i=1; foreach ($prospects as $row): ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td>
                        <?= esc($row['name']); ?><br>
                        <small class="text-muted"><?= esc($row['email']); ?></small>
                    </td>
                    <td><?= esc($row['title']); ?></td>
                    <td>
                        <?php if (strtolower($row['payment_status']) === 'paid'): ?>
                            <span class="badge bg-success">Paid</span>
                        <?php elseif (strtolower($row['payment_status']) === 'partial'): ?>
                            <span class="badge bg-warning text-dark">Partial</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Pending</span>
                        <?php endif; ?>
                    </td>
                    <td><?= indian_format($row['payment_amount'] ?? 0, 2); ?></td>
                    <td><?= date('d-m-Y', strtotime($row['create_date'])); ?></td>
                     <td>
                       <a href="<?= base_url('prospectivemanagement/view/' . $row['prospect_id']); ?>" 
                            class="btn btn-outline-info btn-sm rounded-pill mx-1" 
                            title="View Details">
                            <iconify-icon icon="mdi:eye-outline" class="fs-6"></iconify-icon>
                            </a>

                    </td>
                </tr>
            <?php endforeach; else: ?>
                <tr>
                    <td colspan="6" class="text-center text-muted py-3">
                        No Subscribers Found
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection(); ?>
