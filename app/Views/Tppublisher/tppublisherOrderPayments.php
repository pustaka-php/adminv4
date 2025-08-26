<?= $this->extend('layout/layout1'); ?>

<?= $this->section('script'); ?>
<script>
   document.addEventListener("DOMContentLoaded", function () {
        $.fn.dataTable.ext.errMode = 'none';
    });

  function toggleDetails(index) {
    const detailDiv = document.getElementById("detailRow" + index);
    detailDiv.style.display = (detailDiv.style.display === "none" || detailDiv.style.display === "") ? "block" : "none";
  }
</script>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<!-- Page Title -->
<div class="card basic-data-table">
  <div class="card-header">
    <h5 class="card-title mb-0" style="font-size:16px;">
      <?= esc($title) ?>
    </h5>
  </div>
</div>

<!-- Pending Payments Table -->
<div class="card basic-data-table">
  <div class="card-body">
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
          
          <th>Order Value</th> <!-- New column -->
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
              $royalty_courier_total = $order['royalty'] + $order['courier_charges'];
        ?>
        <tr>
          <td><?= esc($order['order_id']) ?></td>
          <td><?= esc($order['publisher_name']) ?></td>
          <td><?= date('Y-m-d', strtotime($order['order_date'])) ?></td>
          <td><?= date('Y-m-d', strtotime($order['ship_date'])) ?></td>
          <td>₹<?= number_format($order['sub_total'], 2) ?></td>
          <td>₹<?= number_format($order['royalty'], 2) ?></td>
          <td>₹<?= number_format($order['courier_charges'], 2) ?></td>
          
          <td>₹<?= number_format($royalty_courier_total, 2) ?></td> <!-- New value -->
          <td>
            <span class="text-warning fw-bold">Pending</span> /
            <form action="<?= base_url('tppublisher/markAsPaid') ?>" method="post" style="display:inline;" onsubmit="return confirm('Mark this as Paid?');">
              <input type="hidden" name="order_id" value="<?= esc($order['order_id']) ?>">
              <button type="submit" class="btn btn-success-600 radius-4 px-10 py-4">Paid</button>
            </form>
          </td>
        </tr>
        <?php endif; endforeach; ?>
        <?php if (!$pendingFound): ?>
          <tr>
            <td colspan="9" class="text-center text-muted">No pending payment records found.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Paid Payments Table -->
<div class="card basic-data-table mb-5">
  <div class="card-header">
     <div class="card-header py-3 px-4">Paid Payments</div>
  </div>
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
          <th>Order Value</th> <!-- New column -->
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
              $royalty_courier_total = $order['royalty'] + $order['courier_charges'];
        ?>
        <tr>
          <td><?= esc($order['order_id']) ?></td>
          <td><?= esc($order['publisher_name']) ?></td>
          <td><?= date('Y-m-d', strtotime($order['order_date'])) ?></td>
          <td><?= date('Y-m-d', strtotime($order['ship_date'])) ?></td>
          <td>₹<?= number_format($order['sub_total'], 2) ?></td>
          <td>₹<?= number_format($order['courier_charges'], 2) ?></td>
          <td>₹<?= number_format($order['royalty'], 2) ?></td>
          <td>₹<?= number_format($royalty_courier_total, 2) ?></td> <!-- New value -->
          <td><span class="text-success fw-bold">Paid</span></td>
        </tr>
        <?php endif; endforeach; ?>
        <?php if (!$paidFound): ?>
          <tr>
            <td colspan="9" class="text-center text-muted">No paid payment records found.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

<?= $this->endSection(); ?>
