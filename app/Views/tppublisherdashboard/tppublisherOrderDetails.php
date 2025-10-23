<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container py-3">

    <!-- Create New Order Button -->
    <div class="mb-3 text-end">
        <a href="<?= base_url('tppublisherdashboard/tppublishercreateorder') ?>" 
           class="btn btn-primary rounded-pill px-4">
            Create New Order
        </a>
    </div>

    <?php 
    // Define table types and their labels
    $tables = [
        'orders' => 'In Progress Orders',
        'shipped' => 'Shipped Orders',
        'returned' => 'Returned Orders',
        'cancelled' => 'Cancelled Orders'
    ];

    foreach ($tables as $key => $label):
        // Use $orders for 'orders', $groupedOrders for the rest
        $tableData = $key === 'orders' ? $orders : ($groupedOrders[$key] ?? []);
        $tableId   = $key . 'Table';
    ?>
        <span class="mb-3 fw-bold fs-4"><?= esc($label) ?></span>
        <table class="zero-config table table-hover mt-4" id="<?= esc($tableId) ?>" data-page-length="10">
            <thead>
                <tr>
                    <th>Sl No</th>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>No of Qty</th>
                    <th>No of Titles</th>
                    <th>Plan/Ship Date</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($tableData)): ?>
                    <?php foreach ($tableData as $i => $o): ?>
                        <tr>
                            <td><?= esc($i + 1) ?></td>
                            <td><?= esc($o['order_id'] ?? '-') ?></td>
                            <td><?= !empty($o['order_date']) ? date('d-M-Y', strtotime($o['order_date'])) : '-' ?></td>
                            <td><?= esc($o['total_qty'] ?? 0) ?></td>
                            <td><?= esc($o['total_books'] ?? '-') ?></td>
                            <td><?= !empty($o['ship_date']) ? date('d-M-Y', strtotime($o['ship_date'])) : '-' ?></td>
                            <td><?= esc($o['address'] ?? '-') ?></td>
                            <td>
                                <a href="<?= base_url('tppublisherdashboard/tporderfulldetails/' . $o['order_id']) ?>" 
                                   class="btn btn-sm btn-success-600 rounded-pill">
                                    View
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">
                            No <?= strtolower($label) ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    <?php endforeach; ?>

</div>

<?= $this->endSection(); ?>
