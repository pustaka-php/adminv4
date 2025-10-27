<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title text-center">
                <h6 class="mb-4">
                    Publisher Pending Royalty (<?= ucfirst($channel) ?> - <?= ucfirst($type) ?>)
                </h6>
            </div>
        </div>

        <table class="zero-config table table-hover mt-4">
            <thead>
                <tr>
                    <th style="width: 60px;">#</th>
                    <th style="width: 180px;">Copyright Owner</th>
                    <th style="width: 150px;">Publisher Name</th>
                    <th style="width: 150px;">Outstanding (₹)</th>
                    <th style="width: 150px;">Bank Status</th>
                    <th style="width: 150px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($royalty_report)): ?>
                    <?php $i = 1; ?>
                    <?php foreach ($royalty_report as $row): ?>
                        <?php
                            // Determine which outstanding amount to display based on channel
                            switch ($channel) {
                                case 'ebook':
                                    $amount = $row['ebooks_outstanding'];
                                    break;
                                case 'audiobook':
                                    $amount = $row['audiobooks_outstanding'];
                                    break;
                                case 'paperback':
                                    $amount = $row['paperbacks_outstanding'];
                                    break;
                                default:
                                    $amount = $row['total_outstanding'];
                            }

                            // Set condition based on type
                            $condition = ($type === 'quarterly') ? ($amount > 500) : ($amount > 0);
                        ?>

                        <?php if ($condition): ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= esc($row['copyright_owner']); ?></td>
                                <td><?= esc($row['publisher_name']); ?></td>
                                <td><?= number_format($amount, 2); ?></td>
                                <td>
                                    <?php if ($row['bank_status'] === 'Yes'): ?>
                                        <span class="badge bg-success">Yes</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">No</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('royalty/getroyaltybreakup/' . esc($row['copyright_owner'])); ?>" 
                                       class="btn btn-sm btn-outline-primary">
                                       <span class="iconify" data-icon="mdi:eye"></span> View
                                    </a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <?php if ($i === 1): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                No pending <?= ucfirst($channel) ?> data found 
                                (<?= $type === 'quarterly' ? 'above ₹500' : 'above ₹0' ?>).
                            </td>
                        </tr>
                    <?php endif; ?>

                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            No pending <?= ucfirst($channel) ?> data found.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection(); ?>
