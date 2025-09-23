<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container py-4">

    <!-- Top Info Boxes -->
    <div class="row g-4 mb-4">
    <!-- Order Summary Box -->
    <div class="col-md-4">
        <div class="card shadow-sm border-0 bg-light bg-gradient-start-3">
            <div class="card-header py-2">
                <span class="fw-bold fs-5">Order Summary</span>
            </div>
            <div class="card-body">
                <p><strong>Order ID:</strong> <?= esc($order['order_id'] ?? '-') ?></p>
                <p><strong>Order Date:</strong> 
                    <?= !empty($order['order_date']) ? date('d-M-Y', strtotime($order['order_date'])) : '-' ?>
                </p>
                <p><strong>Plan Ship Date:</strong> 
                    <?= !empty($order['ship_date']) ? date('d-M-Y', strtotime($order['ship_date'])) : '-' ?>
                </p>
                <p><strong>Author:</strong> <?= esc($order['author_name'] ?? '-') ?></p>
            </div>
        </div>
    </div>

    <!-- Payment Summary Box -->
    <div class="col-md-4">
        <div class="card shadow-sm border-0 bg-light bg-gradient-start-1">
            <div class="card-header py-2">
                <span class="fw-bold fs-5">Payment Summary</span>
            </div>
            <div class="card-body">
                <p><strong>Order Value:</strong> ₹<?= number_format($order['sub_total'] ?? 0, 2) ?></p>
                <p><strong>Handling Charges:</strong> ₹<?= number_format($order['royalty'] ?? 0, 2) ?></p>
                <p><strong>Courier Charges:</strong> ₹<?= number_format($order['courier_charges'] ?? 0, 2) ?></p>
                <p><strong>To Receive :</strong> 
                    ₹<?= number_format(
                        ($order['royalty'] ?? 0) + ($order['courier_charges'] ?? 0), 
                        2
                    ) ?><small>(Handling + Courier)</small>
                </p>
                <hr>
                <p><strong>Total Value:</strong> 
                    ₹<?= number_format(
                        ($order['sub_total'] ?? 0) + ($order['royalty'] ?? 0) + ($order['courier_charges'] ?? 0),
                        2
                    ) ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Shipping Address Box -->
    <div class="col-md-4">
        <div class="card shadow-sm border-0 bg-light bg-gradient-start-2">
            <div class="card-header py-2">
                <span class="fw-bold fs-5">Shipping Address</span>
            </div>
            <div class="card-body">
                <p><strong>Address:</strong> <?= esc($order['address'] ?? '-') ?></p>
                <p><strong>Mobile:</strong> <?= esc($order['mobile'] ?? '-') ?></p>
            </div>
        </div><br>
    
    
        <div class="card shadow-sm border-0 bg-light bg-gradient-start-3">
            <div class="card-header py-2">
                <span class="fw-bold fs-5">Transport Details</span>
            </div>
            <div class="card-body">
                <p><strong>Transport:</strong> <?= esc($order['transport'] ?? '-') ?></p>
            </div>
        </div>
    </div>
</div>


   <!-- Books Table -->
<div class="card shadow-sm border-0 bg-light bg-gradient">
    <div class="card-header py-2">
        <span class="fw-bold fs-5">Ordered Books</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>SKU No</th>
                        <th>Book Title</th>
                        <th>ISBN</th>
                        <th>No of Pages</th>
                        <th>MRP</th>
                        <th>Quantity</th>
                        <th>Order Value</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($books)): ?>
                        <?php 
                            $totalQty = 0;
                            $totalAmount = 0;
                        ?>
                        <?php foreach ($books as $i => $b): ?>
                            <?php
                                $qty = (int) ($b['quantity'] ?? 0);
                                $mrp = (float) ($b['mrp'] ?? 0);
                                $courier = (float) ($b['courier_charges'] ?? 0);
                                $lineTotal = ($qty * $mrp) + $courier;

                                $totalQty += $qty;
                                $totalAmount += $lineTotal;
                            ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= esc($b['sku_no'] ?? '-') ?></td>
                                <td><?= esc($b['book_title'] ?? '-') ?></td>
                                <td><?= esc($b['isbn'] ?? '-') ?></td>
                                <td><?= esc($b['no_of_pages'] ?? '-') ?></td>
                                <td>₹<?= number_format($mrp, 2) ?></td>
                                <td class="text-center"><?= esc($qty) ?></td>
                                <td>₹<?= number_format($lineTotal, 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">No books found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr class="fw-bold">
                        <td colspan="6" class="text-end">Total</td>
                        <td class="text-center"><?= $totalQty ?></td>
                        <td class="text-center">₹<?= number_format($totalAmount, 2) ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>