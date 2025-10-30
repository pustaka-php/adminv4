<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container mt-4">

    <h6 class="fw-bold mb-3 text-primary">All Shipped Orders (Paid / Pending)</h6>
    <a href="<?= base_url('tppublisher/getshippedorders/') ?>" class="btn btn-secondary mb-3">⬅ Back</a>

    <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10"> 
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
            <?php foreach ($allOrders as $row): ?>
            <tr>
                <td><?= esc($row['order_id']) ?></td>
                <td><?= date('d-m-y', strtotime($row['order_date'])) ?></td>
                <td><?= esc($row['publisher_name']) ?></td>
                <td><?= date('d-m-y', strtotime($row['ship_date'])) ?></td>
                <td>
                    <?php if ($row['payment_status'] == 'pending'): ?>
                        <button class="btn btn-success btn-sm radius-8 px-12 py-4 text-sm mb-1" 
                            onclick="markAsPaid('<?= esc($row['order_id']) ?>')">
                        Paid
                    </button>
                    <?php else: ?>
                        <span class="badge bg-success">Paid</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?= base_url('tppublisherdashboard/tporderfulldetails/' . $row['order_id']) ?>" 
                       class="btn btn-outline-primary btn-sm" 
                       title="View Full Order Details">
                        Details
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<script>
    var csrfName = '<?= csrf_token() ?>';
var csrfHash = '<?= csrf_hash() ?>';
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
</script>

<?= $this->endSection(); ?>
