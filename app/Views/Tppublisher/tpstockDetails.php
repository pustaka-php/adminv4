<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?> 
<h6 class="mb-3 fw-bold">Stock Details</h6>

<div class="card basic-data-table">
    <div class="d-flex justify-content-end mb-2">
        <a href="<?= base_url('tppublisher/tpbookaddstock') ?>"
           class="btn rounded-pill btn-info-600 radius-8 px-20 py-11 text-sm">
           ADD STOCK
        </a>
    </div>

    <!-- Stock Table -->
    <div class="card-body">
        <?php if (!empty($stock_details)): ?>
            <table class="table table-hover zero-config" id="dataTable" data-page-length="10"> 
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Publisher</th>
                        <th>Author</th>
                        <th>Sku No</th>
                        <th>Book Id</th>
                        <th>Book</th>
                        <th>Stock In Hand</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stock_details as $index => $row): ?>
                    <tr>
                        <td><?= $index + 1; ?></td>
                        <td><?= esc($row->publisher_name); ?></td>
                        <td><?= esc($row->author_name); ?></td>
                        <td><?= esc($row->sku_no); ?></td>
                        <td><?= esc($row->book_id); ?></td>
                        <td><?= esc($row->book_title); ?></td>
                        <td><?= esc($row->stock_in_hand); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-muted text-sm">No stock data found.</p>
        <?php endif; ?>
    </div>
</div>
</div>

<?= $this->endSection(); ?>
