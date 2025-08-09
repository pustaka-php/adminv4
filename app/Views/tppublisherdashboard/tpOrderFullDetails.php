<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container py-4">

    <!-- Top Info Boxes -->
    <div class="row g-4 mb-4">
        <!-- Order Summary Box -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 bg-light bg-gradient-start-3">
                <div class="card-header py-2">
                   <span class="fw-bold fs-5">Order Summary</span>
                </div>
                <div class="card-body">
                    <p><strong>Order ID:</strong> <?= esc($order['order_id'] ?? '-') ?></p>
                    <p><strong>Author:</strong> <?= esc($order['author_name'] ?? '-') ?></p>
                    <p><strong>Total:</strong> ₹<?= number_format($order['sub_total'] ?? 0, 2) ?></p>
                    <p><strong>Handiling Charges:</strong> ₹<?= number_format($order['royalty'] ?? 0, 2) ?></p>
                    <p><strong>Courier Charges:</strong> ₹<?= number_format($order['courier_charges'] ?? 0, 2) ?></p>
                    <hr>
                    <p><strong>Total:</strong> ₹<?= number_format(($order['sub_total'] ?? 0) + ($order['courier_charges'] ?? 0), 2) ?></p>
                </div>
            </div>
        </div>

        <!-- Customer Info Box -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 bg-light bg-gradient-start-2">
                <div class="card-header py-2">
                    <span class="fw-bold fs-5">Shipping Address</span>
                </div>
                <div class="card-body">
                    <p><strong>Address:</strong> <?= esc($order['address'] ?? '-') ?></p>
                    <p><strong>Mobile:</strong> <?= esc($order['mobile'] ?? '-') ?></p>
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
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Order ID</th>
                            <th>Ship Date</th>
                            <th>SKU No</th>
                            <th>Book Title</th>
                            <th>MRP</th>
                            <th>Quantity</th>
                            <th>Total</th>
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
                $qty = $b['quantity'] ?? 0;
                $mrp = $b['mrp'] ?? 0;
                $courier = $b['courier_charges'] ?? 0;
                $lineTotal = ($qty * $mrp) + $courier;
                $totalQty += $qty;
                $totalAmount += $lineTotal;
            ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= esc($b['order_id']) ?></td>
                <td><?= !empty($b['ship_date']) ? date('d-M-Y', strtotime($b['ship_date'])) : '-' ?></td>
                <td><?= esc($b['sku_no'] ?? '-') ?></td>
                <td><?= esc($b['book_title'] ?? '-') ?></td>
                <td>₹<?= number_format($mrp, 2) ?></td>
                <td><?= esc($qty) ?></td>
                <td>₹<?= number_format($lineTotal, 2) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="9" class="text-center">No books found for this order.</td>
        </tr>
    <?php endif; ?>
</tbody>

<tfoot>
    <tr class="fw-bold">
        <td colspan="6" class="text-end">Total</td>
        <td><?= $totalQty ?></td>
        <td>₹<?= number_format($totalAmount, 2) ?></td>
    </tr>
</tfoot>

                </table>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection(); ?>
