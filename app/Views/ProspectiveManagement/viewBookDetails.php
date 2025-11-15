<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container mt-4">
    <h5 class="fw-bold mb-3">
        <?= esc($plans[0]['title'] ?? '-') ?> 
        (<?= count($plans) ?> entries)
    </h5>

    <?php if (!empty($plans)): ?>
        <table class="zero-config table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Prospector</th>
                    <th>Plan Name</th>
                    <th>Payment Status</th>
                    <th>Amount</th>
                    <th>Payment Date</th>
                    <th>Remarks / Payment Description</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($plans as $p): ?>
                    <tr>
                        <td><?= esc($p['prospect_name'] ?? '-') ?></td>
                        <td><?= esc($p['plan_name'] ?? '-') ?></td>
                        <td><?= esc($p['payment_status_text'] ?? '-') ?></td>
                        <td><?= isset($p['payment_amount']) ? '₹' . number_format($p['payment_amount'], 2) : '-' ?></td>
                        <td><?= !empty($p['payment_date']) ? date('d-m-Y', strtotime($p['payment_date'])) : '-' ?></td>
                        <td>
                            <?php if (!empty($p['remarks'])): ?>
                                <?php foreach ($p['remarks'] as $r): ?>
                                    <div class="mb-2 p-2 border rounded">
                                        <div><strong>Payment Description:</strong> <?= esc($r['payment_description'] ?? '-') ?></div>
                                        <div><strong>Remarks:</strong> <?= esc($r['remarks'] ?? '-') ?></div>
                                        <div class="text-muted small">
                                            Created by <?= esc($r['created_by'] ?? '-') ?> 
                                            on <?= !empty($r['create_date']) ? date('d-m-Y H:i', strtotime($r['create_date'])) : '-' ?>
                                            <?php if(!empty($r['des_date'])): ?>
                                                (Des Date: <?= date('d-m-Y', strtotime($r['des_date'])) ?>)
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning">
            No paid or partial plans found for this book.
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection(); ?>
