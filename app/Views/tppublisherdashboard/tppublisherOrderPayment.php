<?= $this->extend('layout/layout1'); ?>

<?= $this->section('script'); ?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        $.fn.dataTable.ext.errMode = 'none';
    });
</script>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<!-- Pending Payments Table -->
<div class="card basic-data-table mb-5">
    <div class="card-body p-4">
        <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10"> 
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Publisher</th>
                    <th>Order Date</th>
                    <th>Ship Date</th>
                    <th>Subtotal</th>
                    <th>Courier Charges</th>
                    <th>Royalty</th>
                    <th>Payment Status</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $pendingFound = false;
                foreach ($orders as $order):
                    $status = strtolower(trim((string)$order['payment_status']));
                    if ($status === 'pending' || is_null($order['payment_status']) || $status === ''):
                        $pendingFound = true;
                ?>
                <tr>
                    <td><?= esc($order['order_id']) ?></td>
                    <td><?= esc($order['publisher_name']) ?></td>
                    <td><?= date('d-m-y', strtotime($order['order_date'])) ?></td>
                    <td><?= date('d-m-y', strtotime($order['ship_date'])) ?></td>
                    <td><?= indian_format($order['sub_total'], 2) ?></td>
                    <td><?= indian_format($order['courier_charges'], 2) ?></td>
                    <td><?= indian_format($order['royalty'], 2) ?></td>
                    <td><span class="text-warning fw-bold">Pending</span></td>
                </tr>
                <?php endif; endforeach; ?>
                <?php if (!$pendingFound): ?>
                <tr>
                    <td colspan="8" class="text-center text-muted">No pending payment records found.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Paid Payments Table -->
<div class="card basic-data-table">
    <div class="card-header">
        <h6 class="card-title mb-0" style="font-size:15px;">Paid Payments</h6>
    </div>
    <div class="card-body">
        <!-- <table class="table bordered-table mb-0" id="paidTable" data-page-length='10'> -->
             <table class="zero-config table table-hover mt-4"  data-page-length="10"> 
              
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Publisher</th>
                    <th>Order Date</th>
                    <th>Ship Date</th>
                    <th>Subtotal</th>
                    <th>Courier Charges</th>
                    <th>Royalty</th>
                    <th>Payment Status</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $paidFound = false;
                foreach ($orders as $order):
                    $status = strtolower(trim((string)$order['payment_status']));
                    if ($status === 'paid' || $status === '1'):
                        $paidFound = true;
                ?>
                <tr>
                    <td><?= esc($order['order_id']) ?></td>
                    <td><?= esc($order['publisher_name']) ?></td>
                    <td><?= date('d-m-y', strtotime($order['order_date'])) ?></td>
                    <td><?= date('d-m-y', strtotime($order['ship_date'])) ?></td>
                    <td><?= indian_format($order['sub_total'], 2) ?></td>
                    <td><?= indian_format($order['courier_charges'], 2) ?></td>
                    <td><?= indian_format($order['royalty'], 2) ?></td>
                    <td><span class="text-success fw-bold">Paid</span></td>
                </tr>
                <?php endif; endforeach; ?>
                <?php if (!$paidFound): ?>
                <tr>
                    <td colspan="8" class="text-center text-muted">Paid Payment Records Not Found.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection(); ?>
