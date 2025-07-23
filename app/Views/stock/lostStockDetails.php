<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>

<div class="card basic-data-table">
    <div class="card-header">
        <h5 class="card-title mb-0">Lost Stock Details</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table bordered-table mb-0" id="dataTable" data-page-length='7' >
                <thead>
                    <tr>
                        <th style="width: 50px;">ID</th>
                        <th style="width: 90px;">Book ID</th>
                        <th style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Book Title</th>
                        <th style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Author</th>
                        <th style="width: 100px;">Lost Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($loststock_details['loststock'])) : ?>
                        <?php $i = 1; foreach ($loststock_details['loststock'] as $row): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= esc($row['book_id']) ?></td>
                                <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?= esc($row['book_title']) ?>">
                                    <?= esc($row['book_title']) ?>
                                </td>
                                <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?= esc($row['author_name']) ?> - <?= esc($row['author_id']) ?>">
                                    <?= esc($row['author_name']) ?> - <?= esc($row['author_id']) ?>
                                </td>
                                <td><?= esc($row['lost_qty']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="text-center">No stock details found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        new DataTable('#dataTable');
    });
</script>
<?= $this->endSection(); ?>
