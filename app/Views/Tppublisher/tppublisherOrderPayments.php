<?= $this->extend('layout/layout1'); ?>

<?= $this->section('script'); ?>
<script>
document.addEventListener("DOMContentLoaded", function () {
    $.fn.dataTable.ext.errMode = 'none';
    var triggerTabList = [].slice.call(document.querySelectorAll('#myTab button'))
    triggerTabList.forEach(function (triggerEl) {
        new bootstrap.Tab(triggerEl)
    });
});
</script>
<?= $this->endSection(); ?>


<?= $this->section('content'); ?>
<a href="<?= base_url('tppublisher') ?>" 
           class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a><br><br>

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
        <h6>Pending Payments</h6>
        <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Publisher</th>
                    <th>Order Date</th>
                    <th>Ship Date</th>
                    <th>Total</th>
                    <th>Handling Charges</th>
                    <th>Courier Charges</th>
                    <th>To Receive</th>
                    <th>Payment Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $pendingFound = false; ?>
                <?php foreach ($orders as $order): ?>
                    <?php $status = strtolower(trim((string)($order['payment_status'] ?? ''))); ?>
                    <?php if ($status === 'pending' || $status === '' || $status === '0' || is_null($order['payment_status'])): ?>
                        <?php 
                            $pendingFound = true;
                            $sub_total = (float)($order['sub_total'] ?? 0);
                            $royalty   = (float)($order['royalty'] ?? 0);
                            $courier   = (float)($order['courier_charges'] ?? 0);
                            $total     = $royalty + $courier;
                        ?>
                        <tr id="orderRow<?= esc($order['order_id']) ?>">
                            <td><?= esc($order['order_id']) ?></td>
                            <td><?= esc($order['publisher_name']) ?></td>
                            <td><?= $order['order_date'] ? date('d-m-y', strtotime($order['order_date'])) : '-' ?></td>
                            <td><?= $order['ship_date'] ? date('d-m-y', strtotime($order['ship_date'])) : '-' ?></td>
                            <td><?= indian_format($sub_total, 2) ?></td>
                            <td><?= indian_format($royalty, 2) ?></td>
                            <td><?= indian_format($courier, 2) ?></td>
                            <td><?= indian_format($total, 2) ?></td>
                            <td><span class="text-warning">Pending</span></td>
                            <td>
                                <a href="<?= site_url('tppublisher/tporderfulldetails/' . $order['order_id']) ?>" 
                                   class="btn btn-info btn-sm radius-8 px-12 py-4 text-sm mb-1">
                                    Details
                                </a>
                                <button type="button" 
                                        class="btn btn-success btn-sm radius-8 px-12 py-4 text-sm mb-1"
                                        onclick="markAsPaid('<?= esc($order['order_id']) ?>', '<?= indian_format($royalty, 2) ?>')">
                                    Paid
                                </button>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php if (!$pendingFound): ?>
                    <tr><td colspan="10" class="text-center text-muted">No pending payment records found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <h5>Paid Payments</h5>
        <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Publisher</th>
                    <th>Order Date</th>
                    <th>Ship Date</th>
                    <th>Total</th>
                    <th>Handling Charges</th>
                    <th>Courier Charges</th>                    
                    <th>To Receive</th>
                    <th>Payment Status</th>
                    <th>Payment Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $paidFound = false; ?>
                <?php foreach ($orders as $order): ?>
                    <?php $status = strtolower(trim((string)($order['payment_status'] ?? ''))); ?>
                    <?php if (in_array($status, ['paid', '1'], true)): ?>
                        <?php 
                            $paidFound = true;
                            $sub_total = (float)($order['sub_total'] ?? 0);
                            $royalty   = (float)($order['royalty'] ?? 0);
                            $courier   = (float)($order['courier_charges'] ?? 0);
                            $total     = $royalty + $courier;
                        ?>
                        <tr>
                            <td><?= esc($order['order_id']) ?></td>
                            <td><?= esc($order['publisher_name']) ?></td>
                            <td><?= $order['order_date'] ? date('d-m-y', strtotime($order['order_date'])) : '-' ?></td>
                            <td><?= $order['ship_date'] ? date('d-m-y', strtotime($order['ship_date'])) : '-' ?></td>
                            <td><?= str_replace('₹ ', '₹', indian_format($sub_total, 2)) ?></td>
                            <td><?= indian_format($royalty, 2) ?></td>
                            <td><?= indian_format($courier, 2) ?></td>
                            <td><?= indian_format($total, 2) ?></td>
                            <td><span class="text-success fw-bold">Paid</span></td>
                            <td><?= $order['payment_date'] ? date('d-m-y', strtotime($order['payment_date'])) : '-' ?></td>
                            <td>
                                <a href="<?= site_url('tppublisher/tporderfulldetails/' . $order['order_id']) ?>" 
                                   class="btn btn-info btn-sm px-12 py-4 text-sm">
                                    Details
                                </a>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php if (!$paidFound): ?>
                    <tr><td colspan="10" class="text-center text-muted">No paid payment records found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Sales Tab -->
<div class="tab-pane fade" id="sales" role="tabpanel">
    <h6>Pending Payments</h6>
    <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10">
        <thead>
            <tr>
                <th>Create Date</th>
                <th>Sales Channel</th>
                <th>Qty</th>
                <th>Total Amount</th>
                <th>Discount</th>
                <th>To Pay</th>
                <th>Payment Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $pendingSalesFound = false; ?>
            <?php foreach ($sales as $row): ?>
                <?php if (isset($row['paid_status']) && $row['paid_status'] !== 'paid'): ?>
                    <?php $pendingSalesFound = true; ?>
                    <tr id="salesRow<?= esc($row['create_date'] . '_' . $row['sales_channel']) ?>">
                        <td><?= date('d-m-y', strtotime($row['create_date'] ?? '')) ?></td>
                        <td><?= esc($row['sales_channel'] ?? '') ?></td>
                        <td><?= esc($row['total_qty'] ?? 0) ?></td>
                        <td><?= indian_format((float)($row['total_amount'] ?? 0), 2) ?></td>
                        <td><?= indian_format((float)($row['total_discount'] ?? 0), 2) ?></td>
                        <td><?= indian_format((float)($row['total_author_amount'] ?? 0), 2) ?></td>
                        <td><span class="text-warning"><?= esc($row['paid_status'] ?? 'unknown') ?></span></td>
                        <td>
                            <a class="btn btn-info btn-sm radius-8 px-12 py-4 text-sm"
                               href="<?= site_url('tppublisher/tpsalesfull/' . rawurlencode($row['create_date'] ?? '') . '/' . rawurlencode($row['sales_channel'] ?? '')) ?>">
                                Details
                            </a>
                            <button type="button" class="btn btn-success btn-sm radius-8 px-12 py-4 text-sm"
                                onclick="markSalesPaid('<?= esc($row['create_date'] ?? '') ?>','<?= esc($row['sales_channel'] ?? '') ?>')">
                                Paid
                            </button>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php if (!$pendingSalesFound): ?>
                <tr>
                    <td colspan="8" class="text-center text-muted">No pending sales payments found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <h6>Paid Payments</h6>
    <table class="zero-config table table-hover mt-4" id="dataTable2" data-page-length="10">
        <thead>
            <tr>
                <th>Create Date</th>
                <th>Sales Channel</th>
                <th>Qty</th>
                <th>Total Amount</th>
                <th>Discount</th>
                <th>To Pay</th>
                <th>Payment Status</th>
                <th>Payment Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $paidSalesFound = false; ?>
            <?php foreach ($sales as $row): ?>
                <?php if (isset($row['paid_status']) && $row['paid_status'] === 'paid'): ?>
                    <?php $paidSalesFound = true; ?>
                    <tr>
                        <td><?= date('d-m-y', strtotime($row['create_date'] ?? '')) ?></td>
                        <td><?= esc($row['sales_channel'] ?? '') ?></td>
                        <td><?= esc($row['total_qty']) ?></td>
                        <td><?= indian_format((float)($row['total_amount'] ?? 0), 2) ?></td>
                        <td><?= indian_format((float)($row['total_discount'] ?? 0), 2) ?></td>
                        <td><?= indian_format((float)($row['total_author_amount'] ?? 0), 2) ?></td>
                        <td><span class="text-success fw-bold">Paid</span></td>
                        <td><?= $row['payment_date'] ? date('d-m-y', strtotime($row['payment_date'])) : '-' ?></td>
                        <td>
                            <a class="btn btn-info btn-sm radius-8 px-12 py-4 text-sm"
                               href="<?= site_url('tppublisher/tpsalesfull/' . rawurlencode($row['create_date'] ?? '') . '/' . rawurlencode($row['sales_channel'] ?? '')) ?>">
                                Details
                            </a>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php if (!$paidSalesFound): ?>
                <tr>
                    <td colspan="9" class="text-center text-muted">No paid sales records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</div>

<script>
const csrfName = '<?= csrf_token() ?>';
const csrfHash = '<?= csrf_hash() ?>';

function markAsPaid(order_id) {
    if (!confirm('Mark this order as Paid?')) return;

    $.post("<?= base_url('tppublisher/markAsPaid') ?>", {
        order_id: order_id,
        [csrfName]: csrfHash
    }, function(response) {
        if (response.status === 'success') {
            alert(response.message || 'Paid Successfully.');
            // Remove the pending row from the table
            $('#orderRow' + order_id).remove();
        } else {
            alert(response.message || 'Failed to mark as Paid.');
        }
    }, 'json').fail(function(xhr) {
        alert('AJAX error: ' + xhr.statusText);
    });
}


function markSalesPaid(create_date, sales_channel) {
    if (!confirm('Mark this sale as Paid?')) return;

    $.post("<?= base_url('tppublisher/tpsalespaid') ?>", {
        create_date: create_date,
        sales_channel: sales_channel,
        [csrfName]: csrfHash
    }, function(response) {
        if (response.status === 'success') {
            alert(response.message || 'Paid Successfully.');
            location.reload(); // refresh sales tab
        } else {
            alert(response.message || 'Failed to mark as Paid.');
        }
    }, 'json').fail(function(xhr) {
        alert('AJAX error: ' + xhr.statusText);
    });
}
</script>

<?= $this->endSection(); ?>
