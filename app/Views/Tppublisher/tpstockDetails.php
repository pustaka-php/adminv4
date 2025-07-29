<?= $this->extend('layout/layout1'); ?>

<?= $this->section('script'); ?>
    <script>
        let table = new DataTable("#dataTable");
    </script>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?> 

<div class="card basic-data-table">
    <div class="d-flex justify-content-end mb-2">
        <a href="<?= base_url('tppublisher/tpbookaddstock') ?>"
           class="btn rounded-pill btn-info-600 radius-8 px-20 py-11 text-sm">
           ADD STOCK
        </a>
    </div>
    <div class="card-body">
        <?php if (!empty($stock_details)): ?>
            <!-- <table class="table bordered-table mb-0 text-sm" id="dataTable" data-page-length='10'> -->
            <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10"> 
              
                <thead>
                    <tr>
                        <th scope="col" class="text-sm">S.No</th>
                        <th scope="col" class="text-sm">Publisher</th>
                        <th scope="col" class="text-sm">Author</th>
                        <th scope="col" class="text-sm">Book</th>
                        <th scope="col" class="text-end text-sm">Stock In</th>
                        <th scope="col" class="text-end text-sm">Stock Out</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stock_details as $index => $row): ?>
                        <tr>
                            <td class="text-sm"><?= $index + 1; ?></td>
                            <td class="text-sm"><?= esc($row->publisher_name); ?></td>
                            <td class="text-sm"><?= esc($row->author_name); ?></td>
                            <td class="text-sm"><?= esc($row->book_title); ?></td>
                            <td class="text-end text-sm"><?= esc($row->total_stock_in ?? 0); ?></td>
                            <td class="text-end text-sm"><?= esc($row->total_stock_out ?? 0); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-muted text-sm">No stock data found.</p>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection(); ?>