<?= $this->extend('layout/layout1'); ?>

<?= $this->section('script'); ?>
<script>
document.addEventListener("DOMContentLoaded", function () {
    $.fn.dataTable.ext.errMode = 'none';
    // Activate first tab on page load
    var triggerTabList = [].slice.call(document.querySelectorAll('#myTab button'))
    triggerTabList.forEach(function (triggerEl) {
        var tabTrigger = new bootstrap.Tab(triggerEl)
    })
});
</script>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<div class="card basic-data-table">
    <div class="card-header">
        <h5 class="card-title mb-0" style="font-size:16px;">
            <?= esc($title) ?>
        </h5>
    </div>
</div>

<!-- Tabs -->
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button" role="tab">Orders</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="sales-tab" data-bs-toggle="tab" data-bs-target="#sales" type="button" role="tab">Sales</button>
  </li>
</ul>

<div class="tab-content mt-3" id="myTabContent">
    <!-- Orders Tab -->
    <div class="tab-pane fade show active" id="orders" role="tabpanel">
        <h6>Pending Orders</h6>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Publisher</th>
                    <th>Order Date</th>
                    <th>Ship Date</th>
                    <th>Total</th>
                    <th>Handling Charges</th>
                    <th>Courier Charges</th>
                    <th>Payment Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $pendingFound = false; foreach ($orders as $order): ?>
                    <?php $status = strtolower(trim((string)$order['payment_status'])); ?>
                    <?php if ($status === 'pending' || is_null($order['payment_status']) || $status === ''): ?>
                        <?php $pendingFound = true; ?>
                        <tr>
                            <td><?= esc($order['order_id']) ?></td>
                            <td><?= esc($order['publisher_name']) ?></td>
                            <td><?= date('Y-m-d', strtotime($order['order_date'])) ?></td>
                            <td><?= date('Y-m-d', strtotime($order['ship_date'])) ?></td>
                            <td>₹<?= number_format($order['sub_total'], 2) ?></td>
                            <td>₹<?= number_format($order['royalty'], 2) ?></td>
                            <td>₹<?= number_format($order['courier_charges'], 2) ?></td>
                            <td><?= esc($order['payment_status']) ?></td>
                            <td>
                               <a href="<?= site_url('tppublisher/tporderfulldetails/' . $order['order_id']) ?>" 
                                class="btn btn-info btn-sm">
                                    View
                                </a>
                                <form action="<?= base_url('tppublisher/markAsPaid') ?>" method="post" style="display:inline;" onsubmit="return confirm('Mark this as Paid?');">
                                    <input type="hidden" name="order_id" value="<?= esc($order['order_id']) ?>">
                                    <button type="submit" class="btn btn-success btn-sm">Paid</button>
                                </form>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php if (!$pendingFound): ?>
                    <tr><td colspan="8" class="text-center text-muted">No pending payment records found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <h5>Paid Orders</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Publisher</th>
                    <th>Order Date</th>
                    <th>Ship Date</th>
                    <th>Subtotal</th>
                    <th>Courier Charges</th>
                    <th>Royalty</th>
                    <th>Order Value</th>
                    <th>Payment Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $paidFound = false; foreach ($orders as $order): ?>
                    <?php $status = strtolower(trim((string)$order['payment_status'])); ?>
                    <?php if ($status === 'paid' || $status === '1'): ?>
                        <?php $paidFound = true; ?>
                        <?php $royalty_courier_total = $order['royalty'] + $order['courier_charges']; ?>
                        <tr>
                            <td><?= esc($order['order_id']) ?></td>
                            <td><?= esc($order['publisher_name']) ?></td>
                            <td><?= date('Y-m-d', strtotime($order['order_date'])) ?></td>
                            <td><?= date('Y-m-d', strtotime($order['ship_date'])) ?></td>
                            <td>₹<?= number_format($order['sub_total'], 2) ?></td>
                            <td>₹<?= number_format($order['courier_charges'], 2) ?></td>
                            <td>₹<?= number_format($order['royalty'], 2) ?></td>
                            <td>₹<?= number_format($royalty_courier_total, 2) ?></td>
                            <td><span class="text-success fw-bold">Paid</span></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php if (!$paidFound): ?>
                    <tr><td colspan="9" class="text-center text-muted">No paid payment records found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Sales Tab -->
    <div class="tab-pane fade" id="sales" role="tabpanel">
        <h5>Unpaid Sales</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Create Date</th>
                    <th>Sales Channel</th>
                    <th>Qty</th>
                    <th>Total Amount</th>
                    <th>Discount</th>
                    <th>To Pay</th>
                    <th>Paid Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sales as $row): ?>
                    <?php if ($row['paid_status'] != 'paid'): ?>
                    <tr>
                        <td><?= $row['create_date']; ?></td>
                        <td><?= $row['sales_channel']; ?></td>
                        <td><?= $row['total_qty']; ?></td>
                        <td><?= $row['total_amount']; ?></td>
                        <td><?= $row['total_discount']; ?></td>
                        <td><?= $row['total_author_amount']; ?></td>
                        <td><?= $row['paid_status']; ?></td>
                        <td>
                            <a class="btn btn-info btn-sm"
                               href="<?= site_url('tppublisher/tpsalesfull/' . rawurlencode($row['create_date']) . '/' . rawurlencode($row['sales_channel'])) ?>">
                                Details
                            </a>
                            <form action="<?= base_url('tppublisher/tpsalespaid') ?>" method="post" style="display:inline;" onsubmit="return confirm('Mark this as Paid?');">
                                <?= csrf_field() ?>
                                <input type="hidden" name="create_date" value="<?= esc($row['create_date']) ?>">
                                <input type="hidden" name="sales_channel" value="<?= esc($row['sales_channel']) ?>">
                                <button type="submit" class="btn btn-success btn-sm">Paid</button>
                            </form>
                        </td>
                    </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h5>Paid Sales</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Create Date</th>
                    <th>Sales Channel</th>
                    <th>Qty</th>
                    <th>Total Amount</th>
                    <th>Discount</th>
                    <th>To Pay</th>
                    <th>Paid Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sales as $row): ?>
                    <?php if ($row['paid_status'] == 'paid'): ?>
                    <tr>
                        <td><?= $row['create_date']; ?></td>
                        <td><?= $row['sales_channel']; ?></td>
                        <td><?= $row['total_qty']; ?></td>
                        <td><?= $row['total_amount']; ?></td>
                        <td><?= $row['total_discount']; ?></td>
                        <td><?= $row['total_author_amount']; ?></td>
                        <td><?= $row['paid_status']; ?></td>
                        <td>
                            <a class="btn btn-info btn-sm"
                               href="<?= site_url('tppublisher/tpsalesfull/' . rawurlencode($row['create_date']) . '/' . rawurlencode($row['sales_channel'])) ?>">
                               Details
                            </a>
                        </td>
                    </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection(); ?>
