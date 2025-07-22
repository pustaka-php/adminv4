<?= $this->extend('layout/layout1'); ?>

<?= $this->section('script'); ?>
<script>
    $(function () {
        $.fn.dataTable.ext.errMode = 'none';
        $('#pendingTable, #shippedTable, #returnedTable, #cancelledTable').DataTable({
            pageLength: 10
        });
    });
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
    <div class="card basic-data-table mb-5">
        <div class="card-header py-3 px-4">
            <h5 class="card-title mb-0"><?= esc($title) ?></h5>
        </div>
        <div class="card-body p-4">
            <table id="<?= esc($tableId) ?>" class="table bordered-table mb-0" data-page-length='10' style="font-size:14px; table-layout: fixed; width: 100%;">
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
                        <th>Status</th>
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
                                <?php
                                    if ($o['ship_status'] == 1) echo '<span class="badge bg-success">Shipped</span>';
                                    elseif ($o['ship_status'] == 2) echo '<span class="badge bg-danger">Cancelled</span>';
                                    elseif ($o['ship_status'] == 3) echo '<span class="badge bg-warning">Returned</span>';
                                    else echo '<span class="badge bg-secondary">Processing</span>';
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php } ?>

<div class="card mb-5">
    <div class="card-header py-3 px-4">
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
