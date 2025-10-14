<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="layout-px-spacing">
    <h6 class="mb-4">Month Details - <?= esc($month_name) ?></h6>

    <div class="table-responsive">
        <table class="table table-bordered mb-4 zero-config text-center align-middle">
            <thead>
                <tr>
                    <th>Book Title</th>
                    <th>Units</th>
                    <th>Actual Delivery Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($month_details as $row): ?>
                <tr>
                    <td><?= esc($row['book_title']); ?></td>
                    <td><?= esc($row['num_copies']); ?></td>
                    <td><?= date('d M Y', strtotime($row['actual_delivery_date'])); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection(); ?>
