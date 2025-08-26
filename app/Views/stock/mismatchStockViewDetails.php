
<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>
<div class="table-responsive">
    <table class="zero-config table table-hover mt-4">
        <thead>
            <tr>
                <th style="width: 2%; text-align:center;">ID</th>
                <th style="width: 3%; text-align:center;">Book ID</th>
                <th style="width: 35%;">Book Title</th>
                <th style="width: 30%;">Author</th>
                <th style="text-align:center;">Quantity</th>
                <th style="width: 10%; text-align:center;">Stock In Hand</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($mismatch_details['details'])) : ?>
                <?php $i = 1; foreach ($mismatch_details['details'] as $row): ?>
                    <tr>
                        <td style="text-align:center;"><?= $i++ ?></td>
                        <td style="text-align:center;"><?= esc($row['book_id']) ?></td>
                        <td style="word-break: break-word; white-space: normal;"><?= esc($row['book_title']) ?></td>
                        <td><?= esc($row['author_name']) ?> - <?= esc($row['author_id']) ?></td>
                        <td style="text-align:center;"><?= esc($row['quantity']) ?></td>
                        <td style="text-align:center;"><?= esc($row['stock_in_hand']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="6" class="text-center">No mismatch stock details found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection(); ?>
