<?= $this->extend('layout/layout1'); ?>

<?= $this->section('script'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    
    new DataTable("#pendingTable");
    new DataTable("#shippedTable");
    new DataTable("#returnedTable");
    new DataTable("#cancelledTable");

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

    $.ajax({
        url: "<?= base_url('tppublisher/markShipped') ?>",
        method: "POST",
        data: {
            order_id: order_id,
            book_id: book_id,
            courier_charges: courier_charges,
            <?= csrf_token() ?>: "<?= csrf_hash() ?>"
        },
        success: function (response) {
            console.log(response);
            if (response.status === 'success') {
                alert("Book marked as shipped.");
                location.reload();
            } else {
                alert("Failed to mark as shipped.");
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
            alert("AJAX error: " + error);
        }
    });
}


    const csrfToken = $('meta[name="csrf-token"]').attr('content');
const csrfName = '<?= csrf_token() ?>';

function mark_cancel(order_id, book_id) {
    if (!confirm("Cancel this order?")) return;

    $.ajax({
        type: 'POST',
        url: '<?= base_url("tppublisher/markCancel") ?>', 
        data: {
            order_id: order_id,
            book_id: book_id,
            [csrfName]: csrfToken
        },
        dataType: 'json',
        success: function(response) {
            alert(response.message);
            if (response.status === 'success') location.reload();
        },
        error: function(xhr) {
            alert("Cancel failed: " + xhr.statusText);
        }
    });
}


function mark_return(order_id, book_id) {
    if (!confirm("Return this book?")) return;

    $.ajax({
        type: 'POST',
        url: '<?= base_url("tppublisher/markReturn") ?>',
        data: {
            order_id: order_id,
            book_id: book_id,
            [csrfName]: csrfToken
        },
        dataType: 'json',
        success: function(response) {
            alert(response.message);
            if (response.status === 'success') location.reload();
        },
        error: function(xhr) {
            alert("Return failed: " + xhr.statusText);
        }
    });
}


function printBook(order_id, book_id) {
    if (!confirm("Initiate printing for this book?")) return;

    $.ajax({
        type: 'POST',
        url: '<?= base_url("tppublisher/initiatePrint") ?>', 
        data: {
            order_id: order_id,
            book_id: book_id,
            [csrfName]: csrfToken
        },
        dataType: 'json',
        success: function(response) {
            alert(response.message);
            if (response.status === 'success') location.reload();
        },
        error: function(xhr) {
            alert("Print failed: " + xhr.statusText);
        }
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
    <div class="card basic-data-table">
        <div class="card-header">
            <h5 class="card-title mb-0" style="font-size:16px;"><?= esc($title) ?></h5>
        </div>
        <div class="card-body">
            <table id="<?= esc($tableId) ?>" class="table bordered-table mb-0" data-page-length="10" style="font-size:13px; table-layout: fixed; width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 3%; text-align: left; padding-left: 8px; padding-right: 4px;">S.L</th>
                        <th style="width: 8%; text-align: left; padding-left: 8px;">Order ID</th>
                        <th style="width: 30%;">Book Title</th>
                        <th style="width: 8%; text-align: left; padding-left: 8px;">Publisher Book ID</th>
                        <th style="width: 25%;">Author</th>
                        <th>Qty</th>
                        <th>Book Status</th>
                        <th>Ship Date</th>
                        <th style="width: 90%;">Status / Actions</th>
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
                                    <span class="btn rounded-pill text-success-600 radius-8 px-20 py-11">Shipped</span>
                                    <button onclick="mark_return('<?= esc($o['order_id']) ?>','<?= esc($o['book_id']) ?>')" class="btn btn-warning-600 radius-8 px-20 py-11" style="font-size:12px;">
                                        Return
                                    </button>
                                <?php elseif ($o['ship_status'] == 2): ?>
                                    <span class="btn rounded-pill text-danger-600 radius-8 px-20 py-11">Cancel</span>
                                <?php elseif ($o['ship_status'] == 3): ?>
                                    <span class="btn rounded-pill text-warning-600 radius-8 px-20 py-11">Returned</span>
                                <?php else: ?>
                                    <button onclick="mark_ship('<?= esc($o['order_id']) ?>','<?= esc($o['book_id']) ?>')" class="btn btn-success-600 radius-8 px-20 py-11 mb-2" style="font-size:12px;">
                                        Ship
                                    </button>
                                    <button onclick="mark_cancel('<?= esc($o['order_id']) ?>','<?= esc($o['book_id']) ?>')" class="btn btn-danger-600 radius-8 px-20 py-11 mb-2" style="font-size:12px;">
                                        Cancel
                                    </button>
                                    <?php if (!empty($o['show_print_button'])): ?>
                                        <button onclick="printBook('<?= esc($o['order_id']) ?>','<?= esc($o['book_id']) ?>')" class="btn btn-success btn-sm d-block w-100" style="font-size:12px;">
                                            Print
                                        </button>
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

<div class="card mb-5">
    <div class="card-header">
        <h5 class="card-title mb-0" style="font-size:18px;">Publisher Orders - <?= esc($orders[0]['publisher_name'] ?? '') ?></h5>
    </div>
</div>


<?php
    renderOrdersTable('Processing Orders', $processedOrders, 'pendingTable');
    renderOrdersTable('Shipped Orders', $shippedOrders, 'shippedTable');
    renderOrdersTable('Returned Orders', $returnedOrders, 'returnedTable');
    renderOrdersTable('Cancelled Orders', $cancelledOrders, 'cancelledTable');
?>

<?= $this->endSection(); ?>
