<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">

                    <?php
                        $totalAmount   = 0.0;
                        $totalDiscount = 0.0;
                        $totalAuthor   = 0.0;
                        $totalQty      = 0;

                        if (!empty($details) && is_array($details)) {
                            foreach ($details as $r) {
                                $totalAmount   += (float)($r['total_amount'] ?? 0);
                                $totalDiscount += (float)($r['discount'] ?? 0);
                                $totalAuthor   += (float)($r['author_amount'] ?? 0);
                                $totalQty      += (int)($r['qty'] ?? 0);
                            }
                        }
                    ?>

                    <p><strong>Sales Channel:</strong> <?= esc($details[0]['sales_channel'] ?? '-') ?></p>
                    <p><strong>Payment Status:</strong> <?= esc($details[0]['paid_status'] ?? '-') ?></p>
                    <p><strong>Payment Date:</strong> 
                        <?= !empty($details[0]['paid_date']) ? date('d-M-Y H:i', strtotime($details[0]['paid_date'])) : '-' ?>
                    </p>
                    <hr>
                    <p><strong>Total Qty:</strong> <?= $totalQty ?></p>
                    <p><strong>Total Amount:</strong> ₹<?= number_format($totalAmount, 2) ?></p>
                    <p><strong>Total Discount:</strong> ₹<?= number_format($totalDiscount, 2) ?></p>
                    <p><strong>Total To Pay:</strong> ₹<?= number_format($totalAuthor, 2) ?></p>

                </div>
            </div>
        </div>
    </div>

    <?php if (!empty($details) && is_array($details)): ?>
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                
                    <h5 class="mb-0">Order Details</h5>
               
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Order ID</th>
                                <th>Book Title</th>
                                <th>Qty</th>
                                <th>MRP</th>
                                <th>Discount</th>
                                <th>Total Amount</th>
                                <th>Author Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach ($details as $row): ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= esc($row['order_id'] ?? '-') ?></td>
                                <td><?= esc($row['book_title'] ?? '-') ?></td>
                                <td><?= esc($row['qty'] ?? 0) ?></td>
                                <td>₹<?= number_format($row['mrp'] ?? 0, 2) ?></td>
                                <td>₹<?= number_format($row['discount'] ?? 0, 2) ?></td>
                                <td>₹<?= number_format($row['total_amount'] ?? 0, 2) ?></td>
                                <td>₹<?= number_format($row['author_amount'] ?? 0, 2) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="3" class="text-end">Totals:</th>
                                <th><?= $totalQty ?></th>
                                <th></th>
                                <th>₹<?= number_format($totalDiscount, 2) ?></th>
                                <th>₹<?= number_format($totalAmount, 2) ?></th>
                                <th>₹<?= number_format($totalAuthor, 2) ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="row mt-4">
        <div class="col-12">
            <div class="alert alert-warning">No sales details found.</div>
        </div>
    </div>
    <?php endif; ?>
</div>
<?= $this->endSection(); ?>
