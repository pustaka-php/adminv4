<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content') ?>
<a href="<?= base_url('tppublisher') ?>" 
           class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a>
<div class="d-flex justify-content-end mb-4">
        <a href="<?= base_url('tppublisher/tpbookaddstock/') ?>"
           class="btn rounded-pill btn-info-600 radius-8 px-20 py-11">
           Add Stock
        </a>
        <a href="<?= base_url('tppublisher/getshippedorders/') ?>"
           class="btn rounded-pill btn-info-600 radius-8 px-20 py-11">
           Shipped And Pending Orders
        </a>
        
    </div>

<table class="zero-config table table-hover mt-4">
    <thead>
        <tr>
            <th>S.No</th>
            <th>Book ID</th>
            <th>SKU No</th>
            <th>Book Title</th>
            <th>Publisher</th>
            <th>Stock In Hand</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php $i=1; foreach($books as $row): ?>
        <tr>
            <td><?= $i++ ?></td>
            <td><?= $row['book_id'] ?></td>
            <td><?= $row['sku_no'] ?></td>
            <td><?= $row['book_title'] ?></td>
            <td><?= $row['publisher_name'] ?></td>
            <td><?= $row['stock_in_hand'] ?></td>
            <td><a href="<?= base_url('tppublisher/tpstockledgerview/'.$row['book_id']) ?>" class="btn btn-primary btn-sm">View</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>
