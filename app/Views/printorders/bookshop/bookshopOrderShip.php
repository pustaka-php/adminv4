<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h6 class="text-center">Shipping and tracking ID & tracking URL</h6>
            </div>
        </div>
        <br>
        <h6 class="text-center">Order ID: <?= esc($order_id) ?></h6>
        <h6 class="text-center">No.Of.Title: <?= esc($ship['details']['tot_book'] ?? 0) ?></h6>
        <br>

        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
                <div class="table-responsive">
                    <table class="table table-bordered mb-4 zero-config">
                        <thead>
                            <tr>
                                <th>Book Id</th>
                                <th>Book Name</th>
                                <th>Copies</th>
                                <th>Stock In Hand</th>
                                <th>Qty Details</th>
                                <th>Stock State</th>
                            </tr>
                        </thead>
                        <tbody id="bookList">
                            <?php if (!empty($ship['list'])): ?>
                                <?php foreach ($ship['list'] as $details): ?>
                                    <tr>
                                        <td><?= esc($details['book_id']) ?></td>
                                        <td><?= esc($details['book_title']) ?></td>
                                        <td><?= esc($details['quantity']) ?></td>
                                        <td><?= esc($details['stock_in_hand']) ?></td>
                                        <td class="table-warning">
                                            Ledger: <?= esc($details['qty']) ?><br>
                                            Fair / Store: <?= esc(($details['bookfair'] + $details['bookfair2'] + $details['bookfair3'] + $details['bookfair4'] + $details['bookfair5'])) ?><br>
                                            <?php if ($details['lost_qty'] < 0): ?>
                                                <span style="color:#008000;">Excess: <?= abs($details['lost_qty']) ?></span><br>
                                            <?php elseif ($details['lost_qty'] > 0): ?>
                                                <span style="color:#ff0000;">Lost: <?= $details['lost_qty'] ?><br></span>
                                            <?php endif; ?>
                                        </td>

                                        <?php
                                            $stockStatus = "OUT OF STOCK";
                                            $recommendationStatus = "";
                                            if ($details['quantity'] <= ($details['stock_in_hand'] + $details['lost_qty'])) {
                                                $stockStatus = "IN STOCK";
                                                if ($details['quantity'] > $details['stock_in_hand']) {
                                                    $recommendationStatus = "Print using <span style='color:#ff0000;'>LOST</span> Qty! No Initiate to Print";
                                                }
                                            } elseif ($details['quantity'] <= ($details['stock_in_hand'] + abs($details['lost_qty']))) {
                                                $recommendationStatus = "Print using <span style='color:#008000;'>EXCESS</span> Qty! Initiate Print Also";
                                            }
                                        ?>
                                        <td class="stock-status">
                                            <?= $stockStatus ?><br>
                                            <?= $recommendationStatus ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card h-100 radius-12 bg-gradient-purple">
                    <div class="card-body p-24">
                        <h6 class="mb-8">Shipping Address</h6>
                        <p><strong>Bookshop:</strong> <?= esc($orderbooks['details']['bookshop_name'] ?? '') ?></p>
                        <p><strong>Contact Person:</strong> <?= esc($orderbooks['details']['contact_person_name'] ?? '') ?></p>
                        <p><strong>Mobile No:</strong> <?= esc($orderbooks['details']['mobile'] ?? '') ?></p>
                        <p><strong>Transport Details:</strong> <?= esc(($orderbooks['details']['preferred_transport'] ?? '') . ' - ' . ($orderbooks['details']['preferred_transport_name'] ?? '')) ?></p>
                        <p><strong>Address:</strong> <?= esc($orderbooks['details']['ship_address'] ?? '') ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100 radius-12 bg-gradient-purple">
                    <div class="card-body p-24">
                        <h6 class="mb-8">Tracking Details</h6>
                        <form>
                            <input type="hidden" id="order_id" value="<?= esc($order_id) ?>">
                            <div class="form-group mb-16">
                                <label><strong>Tracking ID</strong></label>
                                <input type="text" id="tracking_id" class="form-control" value="<?= esc($ship['details']['tracking_id'] ?? '') ?>" required>
                            </div>
                            <div class="form-group">
                                <label><strong>Tracking URL</strong></label>
                                <input type="text" id="tracking_url" class="form-control" value="<?= esc($ship['details']['tracking_url'] ?? '') ?>" required>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php
        $disableShipment = false;
        foreach ($ship['list'] ?? [] as $orders) {
            if ($orders['quantity'] > ($orders['stock_in_hand'] + $orders['lost_qty'])) {
                $disableShipment = true;
                break;
            }
        }
        ?>
        <center>
            <div class="field-wrapper mt-3">
                <a href="#" onclick="mark_ship()" class="btn btn-success" <?= $disableShipment ? 'disabled' : '' ?>>Ship</a>
                <a href="<?= base_url('paperback/bookshoporderbooksstatus') ?>" class="btn btn-danger">Close</a>
            </div>
        </center>
    </div>
</div>

<script>
function mark_ship() {
    const order_id = document.getElementById('order_id').value;
    const tracking_id = document.getElementById('tracking_id').value.trim();
    const tracking_url = document.getElementById('tracking_url').value.trim();

    if (!tracking_id || !tracking_url) {
        alert("Please enter Tracking ID and URL.");
        return;
    }

    const allInStock = [...document.querySelectorAll('.stock-status')]
        .every(cell => cell.textContent.trim().includes('IN STOCK'));

    if (!allInStock) {
        alert("Cannot mark as shipped, Check Stock State!!!");
        return;
    }

    $.ajax({
        url: "<?= base_url('paperback/bookshopmarkshipped') ?>",
        type: "POST",
        data: { order_id, tracking_id, tracking_url },
        dataType: "json",
        success: function(response) {
            if (response.status == 1) { 
                alert("Marked as shipped successfully!");
                location.reload();
            } else {
                alert("Unknown error occurred. Please try again.");
            }
        },
        error: function(xhr) {
            alert("Error occurred while processing the request.");
            console.error(xhr.responseText);
        }
    });
}
</script>

<?= $this->endSection(); ?>
