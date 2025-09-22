<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container py-3">
    <div class="mb-3 text-end">
        <a href="<?= base_url('tppublisherdashboard/tppublishercreateorder') ?>" 
           class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-plus-lg"></i> Add New Order
        </a>
    </div>

    <span class="mb-3 fw-bold fs-4">In Progress Orders</span>
     <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10"> 
        <thead>
            <tr>
                <th>Sl No</th>
                <th>Order ID</th>
                <th>Order Date</th>
                
                <th>No of Qty</th>
                <th>No of Titles</th>
                <th>Plan Ship Date</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($orders)) : ?>
                <?php foreach ($orders as $i => $o): ?>
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
                <tr><td colspan="7" class="text-center">No Pending Orders</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <span class="mb-3 fw-bold fs-4">Shipped Orders</span>
     <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10"> 
        <thead>
            <tr>
                <th>Sl No</th>
                <th>Order ID</th>
                <th>Order Date</th>
                
               <th>No of Qty</th>
                <th>No of Titles</th>
                <th>Ship Date</th>
                 <th>Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($groupedOrders['shipped'])): ?>
            <?php foreach ($groupedOrders['shipped'] as $i => $o): ?>
                <tr>
                    <td><?= esc($i + 1) ?></td>
                    <td><?= esc($o['order_id']) ?></td>
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
            <tr><td colspan="8" class="text-center">No Shipped Orders</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <span class="mb-3 fw-bold fs-4">Returned Orders</span>
     <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10"> 
        <thead>
            <tr>
                <th>Sl No</th>
                <th>Order ID</th>
                <th>Order Date</th>
                <th>Author</th>
               <th>No of Qty</th>
                <th>No of Titles</th>
                <th>Ship Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($groupedOrders['returned'])): ?>
            <?php foreach ($groupedOrders['returned'] as $i => $o): ?>
                <tr>
                    <td><?= esc($i + 1) ?></td>
                    <td><?= esc($o['order_id']) ?></td>
                    <td><?= !empty($o['order_date']) ? date('d-M-Y', strtotime($o['order_date'])) : '-' ?></td>
                    <td><?= esc($o['author_name']) ?></td>
                    <td><?= esc($o['total_qty'] ?? 0) ?></td>
                        <td><?= esc($o['total_books'] ?? '-') ?></td>
                        <td><?= !empty($o['ship_date']) ? date('d-M-Y', strtotime($o['ship_date'])) : '-' ?></td>
                        <td>
                            <a href="<?= base_url('tppublisherdashboard/tporderfulldetails/' . $o['order_id']) ?>" 
                            class="btn btn-sm btn-success-600 rounded-pill">
                                View
                            </a>
                        </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="8" class="text-center">No Returned Orders</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <span class="mb-3 fw-bold fs-4">Cancelled Orders</span>
     <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10"> 
        <thead>
            <tr>
                <th>Sl No</th>
                <th>Order ID</th>
                <th>Order Date</th>
                <th>Author</th>
               <th>No of Qty</th>
                <th>No of Titles</th>
                <th>Ship Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($groupedOrders['cancelled'])): ?>
            <?php foreach ($groupedOrders['cancelled'] as $i => $o): ?>
                <tr>
                    <td><?= esc($i + 1) ?></td>
                    <td><?= esc($o['order_id']) ?></td>
                   <td><?= !empty($o['order_date']) ? date('d-M-Y', strtotime($o['order_date'])) : '-' ?></td>
                    <td><?= esc($o['author_name']) ?></td>
                    <td><?= esc($o['total_books'] ?? '-') ?></td>
                   <td><?= esc($o['total_qty'] ?? 0) ?></td>
                        <td><?= !empty($o['ship_date']) ? date('d-M-Y', strtotime($o['ship_date'])) : '-' ?></td>
                        <td>
                            <a href="<?= base_url('tppublisherdashboard/tporderfulldetails/' . $o['order_id']) ?>" 
                            class="btn btn-sm btn-success-600 rounded-pill">
                                View
                            </a>
                        </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="8" class="text-center">No Cancelled Orders</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection(); ?>
