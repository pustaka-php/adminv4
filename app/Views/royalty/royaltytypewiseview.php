<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title text-center">
                <h6 class="mb-4">Publisher Pending Royalty (<?= ucfirst($channel) ?>)</h6>
            </div>
        </div>

        <table class="zero-config table table-hover mt-4">
            <thead>
                <tr>
                    <th style="width: 180px;">#</th>
                    <th style="width: 180px;">Copyright Owner</th>
                    <th style="width: 150px;">Publisher Name</th>
                    <th style="width: 150px;">Outstanding (₹)</th>
                    <th style="width: 150px;">Bank Status</th>
                    <th style="width: 150px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($quarterly_report)): ?>
                    <?php foreach ($quarterly_report as $row): ?>
                        <?php
                            // Determine which field to show based on $channel
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
                        ?>
                        <?php if ($amount > 0): // show only if that channel has amount ?>
                            <tr>
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
                                    <a href="<?= base_url('publisher/details/' . $row['copyright_owner']); ?>" 
                                       class="btn btn-sm btn-outline-primary">
                                       <span class="iconify" data-icon="mdi:eye"></span> View
                                    </a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted">No pending <?= ucfirst($channel) ?> data found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection(); ?>
