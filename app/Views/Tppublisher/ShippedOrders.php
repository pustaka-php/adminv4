<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container mt-4">

    <h6 class="fw-bold mb-3 text-primary">Shipped Orders (Last 30 Days)</h6>
    <a href="<?= base_url('tppublisher/tpstockledgerdetails') ?>" class="btn btn-secondary mb-3"> Back</a>
    <button class="btn btn-success mb-3" id="loadAllBtn">Load All Shipped Orders</button>

    <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10"> 
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Order Date</th>
                <th>Publisher</th>
                <th>Shipped Date</th>
                <th>Payment Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recentOrders as $row): ?>
            <tr>
                <td><?= esc($row['order_id']) ?></td>
                <td><?= date('d-m-y', strtotime($row['order_date'])) ?></td>
                <td><?= esc($row['publisher_name']) ?></td>
                <td><?= date('d-m-y', strtotime($row['ship_date'])) ?></td>
                <td>
                    <?php if ($row['payment_status'] == 'pending'): ?>
                        <span class="badge bg-warning text-dark me-2">Pending</span>
                        <button type="button" 
                                class="btn btn-success btn-sm radius-8 px-12 py-4 text-sm mb-1"
                                onclick="markAsPaid('<?= esc($row['order_id']) ?>')">
                            Paid
                        </button>
                    <?php else: ?>
                        <span class="badge bg-success">Paid</span>
                    <?php endif; ?>
                </td>
                <td class="d-flex align-items-center gap-2">
                    <a href="<?= base_url('tppublisherdashboard/tporderfulldetails/' . $row['order_id']) ?>" 
                       class="btn btn-outline-primary btn-sm" 
                       title="View Full Order Details">
                        Details
                    </a>
                    <button class="btn btn-outline-danger btn-sm markReturnBtn"
                            data-order-id="<?= esc($row['order_id']) ?>">
                        Return
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <hr class="my-5">

    <h6 class="fw-bold mb-3 text-danger">Pending Payments (More than 30 Days)</h6>
    <table class="zero-config table table-hover mt-4" id="dataTable2" data-page-length="10"> 
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Order Date</th>
                <th>Publisher Name</th>
                <th>Shipped Date</th>
                <th>Payment Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($oldPendingOrders as $row): ?>
            <tr>
                <td><?= esc($row['order_id']) ?></td>
                <td><?= date('d-m-y', strtotime($row['order_date'])) ?></td>
                <td><?= esc($row['publisher_name']) ?></td>
                <td><?= date('d-m-y', strtotime($row['ship_date'])) ?></td>
                <td>
                    <span class="badge bg-warning text-dark me-2">Pending</span>
                    <button class="btn btn-success btn-sm radius-8 px-12 py-4 text-sm mb-1" 
                            onclick="markAsPaid('<?= esc($row['order_id']) ?>')">
                        Paid
                    </button>
                </td>
                <td class="d-flex align-items-center gap-2">
                    <a href="<?= base_url('tppublisherdashboard/tporderfulldetails/' . $row['order_id']) ?>" 
                       class="btn btn-outline-primary btn-sm" 
                       title="View Full Order Details">
                        Details
                    </a>
                    <button class="btn btn-outline-danger btn-sm markReturnBtn"
                            data-order-id="<?= esc($row['order_id']) ?>">
                        Return
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<script>
var csrfName = '<?= csrf_token() ?>';
var csrfHash = '<?= csrf_hash() ?>';

// ✅ Load all shipped orders
document.getElementById('loadAllBtn').addEventListener('click', function() {
    window.location.href = "<?= base_url('tppublisher/getallshippedorders') ?>";
});

// ✅ Mark as Paid
function markAsPaid(order_id) {
    if (!confirm('Mark this order as Paid?')) return;

    $.post("<?= base_url('tppublisher/markAsPaid') ?>", {
        order_id: order_id,
        [csrfName]: csrfHash
    }, function(response) {
        console.log(response); // ✅ Debug output
        if (response.status === 'success') {
            alert(response.message || 'Marked as Paid.');
            location.reload();
        } else {
            alert(response.message || 'Failed to mark as Paid.');
        }
    }, 'json').fail(function(xhr) {
        alert('AJAX error: ' + xhr.statusText);
        console.log(xhr.responseText); // ✅ See actual error
    });
}

// ✅ Mark as Return
document.querySelectorAll('.markReturnBtn').forEach(btn => {
    btn.addEventListener('click', function() {
        const orderId = this.dataset.orderId;
        if(confirm(`Are you sure you want to mark Order #${orderId} as Returned?`)) {
            fetch("<?= base_url('tppublisher/markasreturn') ?>", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: JSON.stringify({ order_id: orderId })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Order marked as Returned');
                    location.reload();
                } else {
                    alert('Failed to update return status!');
                }
            });
        }
    });
});
</script>

<?= $this->endSection(); ?>
