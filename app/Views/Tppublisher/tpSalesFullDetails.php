<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid mt-4">

   <?php
$totalAmount   = 0.0;
$totalDiscount = 0.0;
$totalAuthor   = 0.0;
$totalQty      = 0;
$totalMRP      = 0.0;
$titlesSet     = []; // to track unique titles

if (!empty($details)) {
    foreach ($details as $r) {
        $qty = (int)($r['qty'] ?? 0);
        $mrp = (float)($r['price'] ?? 0);

        $totalAmount   += (float)($r['total_amount'] ?? 0);
        $totalDiscount += (float)($r['discount'] ?? 0);
        $totalAuthor   += (float)($r['author_amount'] ?? 0);
        $totalQty      += $qty;
        $totalMRP      += $mrp * $qty;

        // collect unique titles
        if (!empty($r['book_id'])) {
            $titlesSet[$r['book_id']] = true;
        }
    }
}

$noOfTitles = count($titlesSet);
?>

    <!-- Summary Card -->
    <div class="row">
    <!-- Card 1 -->
    <div class="col-md-6">
        <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-1">
            <div class="card-body">
    <p><strong>Sales In:</strong> <?= esc($details[0]['sales_channel'] ?? '-') ?></p>
    <p><strong>Payment Status:</strong> <?= esc($details[0]['paid_status'] ?? '-') ?></p>
    <p><strong>Create Date:</strong> 
        <?= !empty($details[0]['create_date']) ? date('d-m-y', strtotime($details[0]['create_date'])) : '-' ?>
    </p>
    <p><strong>Payment Date:</strong> 
        <?= !empty($details[0]['paid_date']) ? date('d-m-y', strtotime($details[0]['paid_date'])) : '-' ?>
    </p>
</div>

        </div>
    </div>

    <!-- Card 2 -->
    <div class="col-md-6">
        <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-3">
            <div class="card-body">
                
                <p><strong>No of Titles:</strong> <?= $noOfTitles ?></p>
                <p><strong>No of Units:</strong> <?= $totalQty ?></p>
                <p><strong>Total:</strong> <?= indian_format($totalAmount, 2) ?></p>
                <p><strong>Discount:</strong> <?= indian_format($totalDiscount, 2) ?></p>
                <p><strong>To Receiving:</strong> <?= indian_format($totalAuthor, 2) ?></p>
            </div>
        </div>
    </div>
</div><br>

    <!-- Detailed Table -->
    <?php if (!empty($details)): ?>
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Book Title</th>
                        <th>Sales In</th>
                        <th>Units</th>
                        <th>MRP</th>
                        <th>Discount</th>
                        <th>To Pay</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($details as $row): ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        
                        <td><?= esc($row['book_title'] ?? '-') ?></td>
                        <td><?= esc($row['sales_channel'] ?? '-') ?></td>
                        <td><?= esc($row['qty'] ?? 0) ?></td>
                        <td><?= indian_format($row['price'] ?? 0, 2) ?></td>
                        <td><?= indian_format($row['discount'] ?? 0, 2) ?></td>
                        <td><?= indian_format($row['author_amount'] ?? 0, 2) ?></td>
                        <td><?= indian_format($row['total_amount'] ?? 0, 2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th colspan="3" class="text-end">Total:</th>
                        <th><?= $totalQty ?></th>
                        <th><?= indian_format($totalMRP, 2) ?></th>
                        <th><?= indian_format($totalDiscount, 2) ?></th>
                        <th><?= indian_format($totalAmount, 2) ?></th>
                        <th><?= indian_format($totalAuthor, 2) ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <?php else: ?>
    <div class="alert alert-warning">Sales Details Not Found.</div>
    <?php endif; ?>
</div>

<?= $this->endSection(); ?>
