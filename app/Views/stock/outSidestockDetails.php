<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>

<div class="card basic-data-table">
    <div class="card-header">
        <h5 class="card-title mb-0">Lost Stock Details</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table bordered-table mb-0" id="dataTable" data-page-length='7'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Author ID</th>
                        <th>Author Name</th>
                        <th>Book ID</th>
                        <th style="width:120px;">Book Title</th>
                        <th>Stock In Hand</th>
                        <th>Lost Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($outsidestock_details['outside_stock'])) : ?>
                        <?php $i = 1; foreach ($outsidestock_details['outside_stock'] as $row): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= esc($row['author_id']) ?></td>
                                <td><?= esc($row['author_name']) ?></td>
                                <td><?= esc($row['book_id']) ?></td>
                                <td style="width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?= esc($row['book_title']) ?></td>
                                <td><?= esc($row['stock_in_hand']) ?></td>
                                <td><?= esc($row['lost_qty']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="7" class="text-center">No stock details found.</td>
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
