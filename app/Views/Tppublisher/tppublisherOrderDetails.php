<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container py-3">

    <span class="mb-3 fw-bold fs-4">In Progress Orders</span>
     <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10"> 
        <thead>
            <tr>
                <th>Sl No</th>
                <th>Order ID</th>
                <th>Author</th>
                <th>Total Qty</th>
                <th>No Of Title</th>
                <th>Ship Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($orders)) : ?>
                <?php foreach ($orders as $i => $o): ?>
                    <tr>
                        <td><?= esc($i + 1) ?></td>
                        <td><?= esc($o['order_id'] ?? '-') ?></td>
                        <td><?= esc($o['author_name'] ?? '-') ?></td>
                        <td><?= esc($o['total_qty'] ?? 0) ?></td>
                        <td><?= esc($o['total_books'] ?? '-') ?></td>
                        <td><?= !empty($o['ship_date']) ? date('d-M-Y', strtotime($o['ship_date'])) : '-' ?></td>
                        <td>
                           
                                    <button onclick="mark_ship('<?= esc($o['order_id']) ?>','<?= esc($o['book_id']) ?>')" class="btn btn-success btn-sm mb-1">Ship</button>
                                    <button onclick="mark_cancel('<?= esc($o['order_id']) ?>','<?= esc($o['book_id']) ?>')" class="btn btn-danger btn-sm mb-1">Cancel</button>
                                    <?php if (!empty($o['show_print_button'])): ?>
                                        <button onclick="printBook('<?= esc($o['order_id']) ?>','<?= esc($o['book_id']) ?>')" class="btn btn-primary btn-sm d-block w-100">Print</button>
                                    <?php endif; ?>
                                     <a href="<?= base_url('tppublisherdashboard/tporderfulldetails/' . $o['order_id']) ?>" 
                            class="btn btn-info btn-sm mb-1">
                                Details
                            </a>
                        </td>

                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="7" class="text-center">No in-progress orders found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <span class="mb-3 fw-bold fs-4">Shipped Orders</span>
     <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10"> 
        <thead>
            <tr>
                <th>#</th>
                <th>Order ID</th>
                <th>Author</th>
                <th>Total Qty</th>
                <th>No Of Title</th>
                <th>Ship Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($groupedOrders['shipped'])): ?>
            <?php foreach ($groupedOrders['shipped'] as $i => $o): ?>
                <tr>
                    <td><?= esc($i + 1) ?></td>
                    <td><?= esc($o['order_id']) ?></td>
                    <td><?= esc($o['author_name']) ?></td>
                    <td><?= esc($o['total_qty'] ?? 0) ?></td>
                    <td><?= esc($o['total_books'] ?? '-') ?></td>
                     <td><?= !empty($o['ship_date']) ? date('d-M-Y', strtotime($o['ship_date'])) : '-' ?></td>
                    <td>
                    <span class="badge bg-success">Shipped</span>
                                    <button onclick="mark_return('<?= esc($o['order_id']) ?>','<?= esc($o['book_id']) ?>')" class="btn btn-warning btn-sm">Return</button>
                                <a href="<?= base_url('tppublisherdashboard/tporderfulldetails/' . $o['order_id']) ?>" 
                            class="btn btn-info btn-sm mb-1">
                                Details
                            </a></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5" class="text-center">No shipped orders found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <span class="mb-3 fw-bold fs-4">Returned Orders</span>
     <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10"> 
        <thead>
            <tr>
                <th>Sl No</th>
                <th>Order ID</th>
                <th>Author</th>
                 <th>Total Qty</th>
                <th>No Of Title</th>
                <th>Ship Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($groupedOrders['returned'])): ?>
            <?php foreach ($groupedOrders['returned'] as $i => $o): ?>
                <tr>
                    <td><?= esc($i + 1) ?></td>
                    <td><?= esc($o['order_id']) ?></td>
                    <td><?= esc($o['author_name']) ?></td>
                    <td><?= esc($o['total_qty'] ?? 0) ?></td>
                    <td><?= esc($o['total_books'] ?? '-') ?></td>
                     <td><?= !empty($o['ship_date']) ? date('d-M-Y', strtotime($o['ship_date'])) : '-' ?></td>
                    <td> <span class="badge bg-warning">Returned</span>
                        <a href="<?= base_url('tppublisherdashboard/tporderfulldetails/' . $o['order_id']) ?>" 
                            class="btn btn-info btn-sm mb-1">
                                Details
                            </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5" class="text-center">No returned orders found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <span class="mb-3 fw-bold fs-4">Cancelled Orders</span>
     <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10"> 
        <thead>
            <tr>
                <th>Sl No</th>
                <th>Order ID</th>
                <th>Author</th>
                 <th>Total Qty</th>
                <th>No Of Title</th>
                <th>Ship Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($groupedOrders['cancelled'])): ?>
            <?php foreach ($groupedOrders['cancelled'] as $i => $o): ?>
                <tr>
                    <td><?= esc($i + 1) ?></td>
                    <td><?= esc($o['order_id']) ?></td>
                    <td><?= esc($o['author_name']) ?></td>
                    <td><?= esc($o['total_qty'] ?? 0) ?></td>
                    <td><?= esc($o['total_books'] ?? '-') ?></td>
                     <td><?= !empty($o['ship_date']) ? date('d-M-Y', strtotime($o['ship_date'])) : '-' ?></td>
                    <td><span class="badge bg-danger">Cancelled</span>
                         <a href="<?= base_url('tppublisherdashboard/tporderfulldetails/' . $o['order_id']) ?>" 
                            class="btn btn-info btn-xs mb-1">
                                Details
                            </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5" class="text-center">No cancelled orders found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>

<script>
       $(function () {
        $.fn.dataTable.ext.errMode = 'none';
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