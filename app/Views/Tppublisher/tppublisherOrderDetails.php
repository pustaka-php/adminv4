<?= $this->extend('layout/layout1'); ?>

<?= $this->section('script'); ?>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS & CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(function () {
        // Disable default DataTables error handling
        $.fn.dataTable.ext.errMode = 'none';

        // Initialize all tables
        $('#pendingTable, #shippedTable, #returnedTable, #cancelledTable').DataTable({
            pageLength: 10
        });
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
</script>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<?php
$shippedOrders = [];
$returnedOrders = [];
$processedOrders = [];
$cancelledOrders = [];

foreach ($orders as $o) {
    if ($o['ship_status'] == 1) $shippedOrders[] = $o;
    elseif ($o['ship_status'] == 2) $cancelledOrders[] = $o;
    elseif ($o['ship_status'] == 3) $returnedOrders[] = $o;
    else $processedOrders[] = $o;
}

function renderOrdersTable($title, $orders, $tableId) {
    if (empty($orders)) return;
    ?>
    <div class="card basic-data-table mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0"><?= esc($title) ?></h5>
        </div>
        <div class="card-body">
            <table id="<?= esc($tableId) ?>" class="table bordered-table mb-0" style="font-size:13px; table-layout: fixed; width: 100%;">
                <thead>
                    <tr>
                        <th>S.L</th>
                        <th>Order ID</th>
                        <th>Book Title</th>
                        <th>Publisher Book ID</th>
                        <th>Author</th>
                        <th>Qty</th>
                        <th>Book Status</th>
                        <th>Ship Date</th>
                        <th>Status / Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $i => $o): ?>
                        <tr>
                            <td><?= esc($i + 1) ?></td>
                            <td><?= esc($o['order_id']) ?></td>
                            <td><?= esc($o['book_title']) ?></td>
                            <td><?= esc($o['sku_no']) ?></td>
                            <td><?= esc($o['author_name']) ?></td>
                            <td><?= esc($o['quantity']) ?></td>
                            <td><?= esc($o['book_status']) ?></td>
                            <td><?= $o['ship_date'] ? date('d-M-Y', strtotime($o['ship_date'])) : '-' ?></td>
                            <td>
                                <?php if ($o['ship_status'] == 1): ?>
                                    <span class="badge bg-success">Shipped</span>
                                    <button onclick="mark_return('<?= esc($o['order_id']) ?>','<?= esc($o['book_id']) ?>')" class="btn btn-warning btn-sm">Return</button>
                                <?php elseif ($o['ship_status'] == 2): ?>
                                    <span class="badge bg-danger">Cancelled</span>
                                <?php elseif ($o['ship_status'] == 3): ?>
                                    <span class="badge bg-warning">Returned</span>
                                <?php else: ?>
                                    <button onclick="mark_ship('<?= esc($o['order_id']) ?>','<?= esc($o['book_id']) ?>')" class="btn btn-success btn-sm mb-1">Ship</button>
                                    <button onclick="mark_cancel('<?= esc($o['order_id']) ?>','<?= esc($o['book_id']) ?>')" class="btn btn-danger btn-sm mb-1">Cancel</button>
                                    <?php if (!empty($o['show_print_button'])): ?>
                                        <button onclick="printBook('<?= esc($o['order_id']) ?>','<?= esc($o['book_id']) ?>')" class="btn btn-primary btn-sm d-block w-100">Print</button>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php } ?>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">Publisher Orders - <?= esc($orders[0]['publisher_name'] ?? '') ?></h5>
    </div>
</div>

<?php
renderOrdersTable('Processing Orders', $processedOrders, 'pendingTable');
renderOrdersTable('Shipped Orders', $shippedOrders, 'shippedTable');
renderOrdersTable('Returned Orders', $returnedOrders, 'returnedTable');
renderOrdersTable('Cancelled Orders', $cancelledOrders, 'cancelledTable');
?>

<?= $this->endSection(); ?>
