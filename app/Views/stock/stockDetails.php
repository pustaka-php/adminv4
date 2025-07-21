<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>

<div class="card basic-data-table">
    <div class="card-header">
        <h5 class="card-title mb-0">Stock In Hand Details</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table bordered-table mb-0" id="dataTable" style="table-layout: fixed; width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 3%; text-align: left; padding-left: 8px; padding-right: 4px;">ID</th>
                        <th style="width: 8%; text-align: left; padding-left: 8px;">Book ID</th>
                        <th style="width: 30%;">Book Title</th>
                        <th style="width: 25%;">Author</th>
                        <th style="width: 17%;">Stock In Hand</th>
                        <th style="width: 17%;">Lost Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($stock_details)) : ?>
                        <?php $i = 1; foreach ($stock_details as $row): ?>
                            <tr>
                                <td style="text-align: left; padding-left: 8px; padding-right: 4px;"><?= $i++ ?></td>
                                <td style="text-align: left; padding-left: 8px; padding-right: 4px;"><?= esc($row->book_id) ?></td>
                                <td title="<?= esc($row->book_title) ?>" style="word-wrap: break-word; word-break: break-word;"><?= esc($row->book_title) ?></td>
                                <td><?= esc($row->author_name) ?> - <?= esc($row->author_id) ?></td>
                                <td><?= esc($row->stock_in_hand) ?></td>
                                <td><?= esc($row->lost_qty) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6" class="text-center">No stock details found.</td>
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
        new DataTable('#dataTable', {
            paging: true,
            pageLength: 7,
            searching: true,
            ordering: true,
            info: false,
            scrollX: false,  
        });
    });
</script>
<?= $this->endSection(); ?>
