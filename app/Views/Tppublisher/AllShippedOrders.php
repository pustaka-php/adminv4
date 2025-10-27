<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container mt-4">

    <h6 class="fw-bold mb-3 text-primary"> All Shipped Orders (Paid / Pending)</h6>
    <a href="<?= base_url('tppublisher/getshippedorders/') ?>" class="btn btn-secondary mb-3">⬅ Back</a>

    <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10"> 
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Order Date</th>
                <th>Book ID</th>
                <th>SKU No</th>
                <th>Book Title</th>
                <th>Publisher Name</th>
                <th>Shipped Date</th>
                <th>Payment Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($allOrders as $row): ?>
            <tr>
                <td><?= esc($row['order_id']) ?></td>
                <td><?= esc($row['order_date']) ?></td>
                <td><?= esc($row['book_id']) ?></td>
                <td><?= esc($row['sku_no']) ?></td>
                <td><?= esc($row['book_title']) ?></td>
                <td><?= esc($row['publisher_name']) ?></td>
                <td><?= esc($row['ship_date']) ?></td>
                <td>
                    <?php if ($row['payment_status'] == 'pending'): ?>
                        <button class="btn btn-sm btn-outline-success markPaidBtn" 
                                data-order-id="<?= esc($row['order_id']) ?>">
                            Paid
                        </button>
                    <?php else: ?>
                        <span class="badge bg-success">Paid</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<script>
document.querySelectorAll('.markPaidBtn').forEach(btn => {
    btn.addEventListener('click', function() {
        const orderId = this.getAttribute('data-order-id');

        if (confirm('Mark this order as Paid?')) {
            fetch("<?= base_url('tppublisher/markaspaid') ?>", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ order_id: orderId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Payment status updated to Paid!');
                    location.reload();
                } else {
                    alert('Failed to update payment status.');
                }
            })
            .catch(() => alert('Error occurred while updating.'));
        }
    });
});
</script>

<?= $this->endSection(); ?>
