<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container py-3">

    <div class="row g-4 mb-4">

        <!-- Orders Overview Card -->
        <div class="col-md-6">
            <div class="card p-3 shadow-2 radius-8 h-100 bg-gradient-end-2">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <span class="w-48 h-48 bg-info-100 rounded-circle d-flex justify-content-center align-items-center">
                        <iconify-icon icon="mdi:shopping" width="24" height="24" style="color:blue;"></iconify-icon>
                    </span>
                    <div>
                        <h6 class="fw-semibold mb-1"><?= number_format($orderStats['total_orders'] ?? 0); ?></h6>
                        <span class="fw-medium text-secondary-light text-sm">Total Orders</span>
                    </div>
                </div>
                <div class="d-flex gap-3 flex-wrap text-secondary-light fw-medium text-sm">
                    <div class="d-grid" style="grid-template-columns: repeat(2, 1fr); gap: 8px;">
                        <div style="border-right: 1px solid #ccc; padding-right: 4px;">
                            <span><?= $orderStats['shipped_orders'] ?? 0 ?> Shipped</span>
                        </div>
                        <div style="padding-left: 4px;">
                            <span><?= $orderStats['pending_orders'] ?? 0 ?> Pending</span>
                        </div>
                        <div style="border-right: 1px solid #ccc; padding-right: 4px;">
                            <span><?= $orderStats['cancelled_orders'] ?? 0 ?> Cancelled</span>
                        </div>
                        <div style="padding-left: 4px;">
                            <span><?= $orderStats['returned_orders'] ?? 0 ?> Returned</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Financial Overview Card -->
        <div class="col-md-6">
            <div class="card p-3 shadow-2 radius-8 h-100 bg-gradient-end-3">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <span class="w-48 h-48 bg-info-100 rounded-circle d-flex justify-content-center align-items-center">
                        <iconify-icon icon="mdi:currency-inr" width="24" height="24" style="color:blue;"></iconify-icon>
                    </span>
                    <div>
                        <h6 class="fw-semibold mb-1">₹<?= number_format($orderStats['total_net'] ?? 0, 2); ?></h6>
                        <span class="fw-medium text-secondary-light text-sm">Total Amount</span>
                    </div>
                </div>
                <div class="text-sm text-secondary-light d-flex flex-wrap gap-2 mb-1">
                    <span>Handling Charges: ₹<?= number_format($orderStats['total_royalty'] ?? 0, 2); ?></span>
                    <span>|</span>
                    <span>Courier: ₹<?= number_format($orderStats['total_courier'] ?? 0, 2); ?></span>
                </div>
                <div class="text-sm text-secondary-light d-flex flex-wrap gap-2">
                    <span>Paid: ₹<?= number_format($orderStats['total_order_value'] ?? 0, 2); ?></span>
                </div>
            </div>
        </div>

    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs" id="orderTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button" role="tab" aria-controls="orders" aria-selected="true">Orders</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="payments-tab" data-bs-toggle="tab" data-bs-target="#payments" type="button" role="tab" aria-controls="payments" aria-selected="false">Payments</button>
        </li>
    </ul>

    <div class="tab-content mt-3" id="orderTabsContent">

        <!-- Orders Tab -->
        <div class="tab-pane fade show active" id="orders" role="tabpanel" aria-labelledby="orders-tab">

            <!-- In Progress Orders -->
            <span class="mb-3 fw-bold fs-4">In Progress Orders</span>
            <table class="zero-config table table-hover mt-2" data-page-length="10">
    <thead>
        <tr>
            <th>Sl No</th>
            <th>Order ID</th>
            <th>Order Date</th>
            <th>Author</th>
            <th>Quantity</th>
            <th>No Of Titles</th>
            <th>Plan Ship Date</th>
            <th>Address</th>
            <th style="text-align:center">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($orders)) : ?>
            <?php foreach ($orders as $i => $o): ?>
                <tr>
                    <td><?= esc($i + 1) ?></td>
                    <td>
                        <a href="<?= base_url('tppublisherdashboard/tporderfulldetails/' . $o['order_id']) ?>" class="d-flex align-items-center text-decoration-none text-dark" title="View Details">
                            <span><?= esc($o['order_id'] ?? '-') ?></span>
                            <iconify-icon icon="mdi:eye-outline" width="18" height="18" class="ms-2"></iconify-icon>
                        </a>
                    </td>

                    <td><?= !empty($o['order_date']) ? date('d-M-Y', strtotime($o['order_date'])) : '-' ?></td>
                    <td><?= esc($o['author_name'] ?? '-') ?></td>
                    <td><?= esc($o['total_qty'] ?? 0) ?></td>
                    <td><?= esc($o['total_books'] ?? '-') ?></td>
                    <td><?= !empty($o['ship_date']) ? date('d-M-Y', strtotime($o['ship_date'])) : '-' ?></td>
                    <td><?= esc($o['address'] ?? '-') ?></td>
                    <td class="d-flex gap-2 flex-wrap">
                        <button onclick="mark_ship('<?= esc($o['order_id']) ?>','<?= esc($o['book_id']) ?>')" class="btn btn-success btn-sm radius-8 px-14 py-6 text-sm">Ship</button>
                        <button onclick="mark_cancel('<?= esc($o['order_id']) ?>','<?= esc($o['book_id']) ?>')" class="btn btn-danger btn-sm radius-8 px-14 py-6 text-sm">Cancel</button>
                        <?php if (!empty($o['show_print_button'])): ?>
                            <button onclick="printBook('<?= esc($o['order_id']) ?>','<?= esc($o['book_id']) ?>')" class="btn btn-primary btn-sm radius-8 px-14 py-6 text-sm">Print</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="9" class="text-center">No in-progress orders found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>


            <!-- Shipped Orders -->
            <span class="mb-3 fw-bold fs-4">Shipped Orders</span>
            <table class="zero-config table table-hover mt-2" data-page-length="10">
                <thead>
                    <tr>
                        <th>Sl No</th>
                        <th>Order ID</th>
                        <th>Order Date</th>
                        <th>Author</th>
                        <th>Quantity</th>
                        <th>No Of Titles</th>
                        <th>Ship Date</th>
                        <th>Address</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($groupedOrders['shipped'])): ?>
                        <?php foreach ($groupedOrders['shipped'] as $i => $o): ?>
                            <tr>
                                <td><?= esc($i + 1) ?></td>
                                <td>
                                    <a href="<?= base_url('tppublisherdashboard/tporderfulldetails/' . $o['order_id']) ?>" class="d-flex align-items-center text-decoration-none text-dark" title="View Details">
                                        <span><?= esc($o['order_id'] ?? '-') ?></span>
                                        <iconify-icon icon="mdi:eye-outline" width="18" height="18" class="ms-2"></iconify-icon>
                                    </a>
                                </td>
                                <td><?= !empty($o['order_date']) ? date('d-M-Y', strtotime($o['order_date'])) : '-' ?></td>
                                <td><?= esc($o['author_name']) ?></td>
                                <td><?= esc($o['total_qty'] ?? 0) ?></td>
                                <td><?= esc($o['total_books'] ?? '-') ?></td>
                                <td><?= !empty($o['ship_date']) ? date('d-M-Y', strtotime($o['ship_date'])) : '-' ?></td>
                                <td><?= esc($o['address'] ?? '-') ?></td>
                                <td>
                                    <span class="badge bg-success">Shipped</span>
                                    <button onclick="mark_return('<?= esc($o['order_id']) ?>','<?= esc($o['book_id']) ?>')" class="btn btn-warning radius-8 px-14 py-6 text-sm">Return</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No shipped orders found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Returned Orders -->
            <span class="mb-3 fw-bold fs-4">Returned Orders</span>
            <table class="zero-config table table-hover mt-2" data-page-length="10">
                <thead>
                    <tr>
                        <th>Sl No</th>
                        <th>Order ID</th>
                        <th>Order Date</th>
                        <th>Author</th>
                        <th>Quantity</th>
                        <th>No Of Titles</th>
                        <th>Ship Date</th>
                        <th>Address</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($groupedOrders['returned'])): ?>
                        <?php foreach ($groupedOrders['returned'] as $i => $o): ?>
                            <tr>
                                <td><?= esc($i + 1) ?></td>
                                <td>
                        <a href="<?= base_url('tppublisherdashboard/tporderfulldetails/' . $o['order_id']) ?>" class="d-flex align-items-center text-decoration-none text-dark" title="View Details">
                            <span><?= esc($o['order_id'] ?? '-') ?></span>
                            <iconify-icon icon="mdi:eye-outline" width="18" height="18" class="ms-2"></iconify-icon>
                        </a>
                    </td>
                                <td><?= !empty($o['order_date']) ? date('d-M-Y', strtotime($o['order_date'])) : '-' ?></td>
                                <td><?= esc($o['author_name']) ?></td>
                                <td><?= esc($o['total_qty'] ?? 0) ?></td>
                                <td><?= esc($o['total_books'] ?? '-') ?></td>
                                <td><?= !empty($o['ship_date']) ? date('d-M-Y', strtotime($o['ship_date'])) : '-' ?></td>
                                <td><?= esc($o['address'] ?? '-') ?></td>
                                <td>
                                    <span class="badge bg-warning">Returned</span>
                                    <a href="<?= base_url('tppublisherdashboard/tporderfulldetails/' . $o['order_id']) ?>" class="btn btn-info radius-8 px-14 py-6 text-sm">Details</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No returned orders found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Cancelled Orders -->
            <span class="mb-3 fw-bold fs-4">Cancelled Orders</span>
            <table class="zero-config table table-hover mt-2" data-page-length="10">
                <thead>
                    <tr>
                        <th>Sl No</th>
                        <th>Order ID</th>
                        <th>Order Date</th>
                        <th>Author</th>
                        <th>Quantity</th>
                        <th>No Of Titles</th>
                        <th>Ship Date</th>
                        <th>Address</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($groupedOrders['cancelled'])): ?>
                        <?php foreach ($groupedOrders['cancelled'] as $i => $o): ?>
                            <tr>
                                <td><?= esc($i + 1) ?></td>
                               <td>
                        <a href="<?= base_url('tppublisherdashboard/tporderfulldetails/' . $o['order_id']) ?>" class="d-flex align-items-center text-decoration-none text-dark" title="View Details">
                            <span><?= esc($o['order_id'] ?? '-') ?></span>
                            <iconify-icon icon="mdi:eye-outline" width="18" height="18" class="ms-2"></iconify-icon>
                        </a>
                    </td>
                                <td><?= !empty($o['order_date']) ? date('d-M-Y', strtotime($o['order_date'])) : '-' ?></td>
                                <td><?= esc($o['author_name']) ?></td>
                                <td><?= esc($o['total_qty'] ?? 0) ?></td>
                                <td><?= esc($o['total_books'] ?? '-') ?></td>
                                <td><?= !empty($o['ship_date']) ? date('d-M-Y', strtotime($o['ship_date'])) : '-' ?></td>
                                <td><?= esc($o['address'] ?? '-') ?></td>
                                <td>
                                    <span class="badge bg-danger">Cancelled</span>
                                    <a href="<?= base_url('tppublisherdashboard/tporderfulldetails/' . $o['order_id']) ?>" class="btn btn-info radius-8 px-14 py-6 text-sm">Details</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No cancelled orders found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

        </div>

        <!-- Payments Tab -->
        <div class="tab-pane fade" id="payments" role="tabpanel" aria-labelledby="payments-tab">
            <span class="mb-3 fw-bold fs-4">Payments</span>
            <table class="zero-config table table-hover mt-2" data-page-length="10">
                <thead>
                    <tr>
                        <th>Sl No</th>
                        <th>Order ID</th>
                        <th>Payment Date</th>
                        <th>Author</th>
                        <th>Amount</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($payments)) : ?>
                        <?php foreach ($payments as $i => $p) : ?>
                            <tr>
                                <td><?= esc($i + 1) ?></td>
                                <td><?= esc($p['order_id'] ?? '-') ?></td>
                                <td><?= !empty($p['payment_date']) ? date('d-M-Y', strtotime($p['payment_date'])) : '-' ?></td>
                                <td><?= esc($p['author_name'] ?? '-') ?></td>
                                <td>₹<?= number_format($p['amount'] ?? 0, 2) ?></td>
                                <td><?= esc($p['method'] ?? '-') ?></td>
                                <td>
                                    <span class="badge <?= $p['status'] == 'Paid' ? 'bg-success' : 'bg-warning' ?>"><?= esc($p['status']) ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No payments found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    $(function () {
        $.fn.dataTable.ext.errMode = 'none';
    });

    const csrfName = '<?= csrf_token() ?>';
    const csrfHash = '<?= csrf_hash() ?>';

    function mark_ship(order_id, book_id) {
        if (!confirm("Mark this order as shipped?")) return;

        let courier_charges = 0;
        if (confirm("Do you want to add a courier charge?")) {
            let input = prompt("Enter courier charge:");
            if (input === null) return;
            courier_charges = parseFloat(input);
            if (isNaN(courier_charges)) {
                alert("Invalid courier charge.");
                return;
            }
        }

        $.post("<?= base_url('tppublisher/markShipped') ?>", {
            order_id,
            book_id,
            courier_charges,
            [csrfName]: csrfHash
        }, function (response) {
            alert(response.message || "Action completed.");
            if (response.status === 'success') location.reload();
        }, 'json').fail(function (xhr) {
            alert("AJAX error: " + xhr.statusText);
        });
    }

    function mark_cancel(order_id, book_id) {
        if (!confirm("Cancel this order?")) return;

        $.post("<?= base_url('tppublisher/markCancel') ?>", {
            order_id,
            book_id,
            [csrfName]: csrfHash
        }, function (response) {
            alert(response.message);
            if (response.status === 'success') location.reload();
        }, 'json').fail(function (xhr) {
            alert("Cancel failed: " + xhr.statusText);
        });
    }

    function mark_return(order_id, book_id) {
        if (!confirm("Return this book?")) return;

        $.post("<?= base_url('tppublisher/markReturn') ?>", {
            order_id,
            book_id,
            [csrfName]: csrfHash
        }, function (response) {
            alert(response.message);
            if (response.status === 'success') location.reload();
        }, 'json').fail(function (xhr) {
            alert("Return failed: " + xhr.statusText);
        });
    }

    function printBook(order_id, book_id) {
        if (!confirm("Initiate printing for this book?")) return;

        $.post("<?= base_url('tppublisher/initiatePrint') ?>", {
            order_id,
            book_id,
            [csrfName]: csrfHash
        }, function (response) {
            alert(response.message);
            if (response.status === 'success') location.reload();
        }, 'json').fail(function (xhr) {
            alert("Print failed: " + xhr.statusText);
        });
    }
    function markAsPaid(order_id, sub_total, royalty, ) {
    if (!confirm('Mark this order as Paid?')) return;

    let courier_charges = 0;
    if (confirm("Do you want to add courier charge?")) {
        let input = prompt("Enter courier charge:");
        if (input === null) return;
        courier_charges = parseFloat(input);
        if (isNaN(courier_charges)) {
            alert("Invalid courier charge.");
            return;
        }
    }

    // Ensure numeric
    sub_total = parseFloat(sub_total) || 0;
    royalty = parseFloat(royalty) || 0;

    // Calculate net_total = sub_total + royalty + courier_charges
    let net_total = sub_total + royalty + courier_charges;

    console.log({order_id, courier_charges, net_total, [csrfName]: csrfHash}); // Debug

    $.post("<?= base_url('tppublisher/markAsPaid') ?>", {
        order_id: order_id,
        courier_charges: courier_charges,
        net_total: net_total,
        [csrfName]: csrfHash
    }, function(response) {
        if (response.status === 'success') {
            alert(response.message || 'Paid Successfully.');
            location.reload();
        } else {
            alert(response.message || 'Failed to mark as Paid.');
        }
    }, 'json').fail(function(xhr) {
        alert('AJAX error: ' + xhr.statusText);
    });
}




</script>
<?= $this->endSection(); ?>
