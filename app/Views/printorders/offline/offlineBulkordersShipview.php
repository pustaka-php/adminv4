<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title text-center">
                <h3>Bulk Orders Shipment</h3>
            </div>
        </div>
        <input type="hidden" class="form-control" id="order_id" name="order_id" value="<?= esc($order_id); ?>">

        <div class="col-7">
            <div class="form-group">
                <label for="tracking_id">Tracking ID</label>
                <input type="text" class="form-control" id="tracking_id" name="tracking_id" required>
            </div>
            <div class="form-group">
                <label for="tracking_url">Tracking URL</label>
                <input type="text" class="form-control" id="tracking_url" name="tracking_url" required>
            </div>
        </div>
        <br>
        <table id="order_table" class="zero-config table table-hover mt-4"> 
            <thead>
                <tr>
                    <th>S.NO</th>
                    <th>Book ID</th>
                    <th>Title</th>
                    <th>Author Name</th>
                    <th>Quantity</th>
                    <th>Stock In Hand</th>
                    <th>Qty Details</th>
                    <th>Stock State</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody style="font-weight: 1000;">
                <?php $i=1; foreach ($bulk_order as $orders) { ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= esc($orders['book_id']); ?></td>
                        <td><?= esc($orders['book_title']); ?></td>
                        <td><?= esc($orders['author_name']); ?></td>
                        <td><?= esc($orders['quantity']); ?></td>
                        <td><?= esc($orders['stock_in_hand']); ?> </td>
                        <td>
                            Ledger: <?= esc($orders['qty']); ?><br>
                            Fair / Store: <?= esc($orders['bookfair']+$orders['bookfair2']+$orders['bookfair3']+$orders['bookfair4']+$orders['bookfair5']); ?><br>
                            <?php if ($orders['lost_qty'] < 0) { ?>
                                <span style="color:#008000;">Excess: <?= abs($orders['lost_qty']); ?></span><br>
                            <?php } elseif ($orders['lost_qty'] > 0) { ?>
                                <span style="color:#ff0000;">Lost: <?= esc($orders['lost_qty']); ?><br></span>
                            <?php } ?>
                        </td>
                        <?php
                        $stockStatus = $orders['quantity'] <= ($orders['stock_in_hand']+$orders['lost_qty']) ? 'IN STOCK' : 'OUT OF STOCK';
                        $recommendationStatus = "";
                        
                        if ($orders['quantity'] <= ($orders['stock_in_hand']+$orders['lost_qty']))
                        {
                            $stockStatus = "IN STOCK";
                            if ($orders['quantity'] <= $orders['stock_in_hand']) {
                                $recommendationStatus ="";
                            } else {
                                $recommendationStatus = "Print using </span><span style='color:#ff0000;'>LOST</span><span style='color:#0000ff;'> Qty! No Initiate to Print";
                            }
                        } else {
                            $stockStatus = "OUT OF STOCK";
                            if ($orders['quantity'] <= $orders['stock_in_hand']) {
                                $recommendationStatus = "Print using </span><span style='color:#008000;'>EXCESS</span><span style='color:#0000ff;'> Qty! Initiate Print Also";
                            }
                        }
                        ?>
                        <td>
                            <?= $stockStatus ?>
                            <br><span style="color:#0000ff;">
                            <?php 
                                if (($stockStatus == 'OUT OF STOCK') && ($recommendationStatus == '')) {
                                    // nothing
                                } else {
                                    echo $recommendationStatus;
                                } 
                            ?></span>
                        </td>
                        <td><?= esc($orders['total_amount']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php
            $disableShipment = false;
            foreach ($bulk_order as $orders) {
                if ($orders['quantity'] <= ($orders['stock_in_hand']+$orders['lost_qty'])) {
                    if ($orders['quantity'] > $orders['stock_in_hand']) {
                        $disableShipment = true;
                        break;
                    }
                } else {
                    $disableShipment = true;
                    break;
                }
            }
        ?>

        <!-- Fixed Shipment Button -->
        <button type="button" onclick="fetchOrderDetails()" 
            class="btn btn-primary btn-lg mb-2 mr-2" 
            <?php if ($disableShipment) echo 'disabled'; ?>>Shipment</button>

    </div>
</div>

<script>
function fetchOrderDetails() {
    var order_id = document.getElementById('order_id').value;
    var tracking_id = document.getElementById('tracking_id').value;
    var tracking_url = document.getElementById('tracking_url').value;
    var book_ids = [];
    var base_url = "<?= base_url(); ?>";


    document.querySelectorAll('#order_table tbody tr').forEach(function(row) {
        var book_id = row.cells[1].innerText.trim();
        book_ids.push(book_id);
    });

    $.ajax({
        url: base_url + "/paperback/bulkordershipmentcompleted",
        type: 'POST',
        dataType: 'json',
        data: {
            "order_id": order_id,
            "book_ids": JSON.stringify(book_ids),
            "tracking_id": tracking_id,
            "tracking_url": tracking_url
        },
        success: function(response) {
            if (response.status == 1) {
                alert("Order ID shipped");
                window.location.href = base_url + "/paperback/offlineorderbooksstatus";
            } else {
                alert("Order ID not found or an error occurred!");
            }
        },
        error: function(xhr, status, error) {
            console.log('Error:', status, error);
            alert("Something went wrong! Please try again.");
        }
    });
}
</script>
<?= $this->endSection(); ?> 
