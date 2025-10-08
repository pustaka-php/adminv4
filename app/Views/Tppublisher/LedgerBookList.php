<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content') ?>

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
