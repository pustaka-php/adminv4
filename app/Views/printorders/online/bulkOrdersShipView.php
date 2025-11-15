<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-header d-flex justify-content-between align-items-center">
                <div class="page-title text-center flex-grow-1">
                    <h6 class="text-center">Bulk Orders Shipment</h6><br><br>
                </div>
                <a href="<?= base_url('paperback/onlineorderbooksstatus'); ?>" 
                class="btn btn-outline-secondary btn-sm">
                    ← Back
                </a>
            </div>
        </div>
        <div class="card radius-12 bg-gradient-success text-end" style="max-width: 520px; margin: auto;">
            <div class="card-body p-16">
                <div class="w-48-px h-48-px d-inline-flex align-items-center justify-content-center bg-success-600 text-white mb-12 radius-12">
                    <iconify-icon icon="mdi:truck-delivery" class="h6 mb-0"></iconify-icon>
                </div>

                <h6 class="mb-8 text-center">Tracking Info</h6>

                <input type="hidden" class="form-control" id="order_id" name="order_id" value="<?= esc($order_id); ?>">

                <div class="form-group mb-2 text-start">
                    <label for="tracking_id">Tracking ID</label>
                    <input type="text" class="form-control" id="tracking_id" name="tracking_id" required>
                </div>

                <div class="form-group mb-2 text-start">
                    <label for="tracking_url">Tracking URL</label>
                    <input type="text" class="form-control" id="tracking_url" name="tracking_url" required>
                </div>
            </div>
        </div>

        <br>
        <table class="zero-config table table-hover mt-4" id="order_table">
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
            <tbody style="font-weight: normal;">
                <?php $i=1; foreach ($bulk_order as $orders) { ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $orders['book_id']; ?></td>
                        <td><?php echo $orders['book_title']; ?></td>
                        <td><?php echo $orders['author_name']; ?></td>
                        <td><?php echo $orders['quantity']; ?></td>
                        <td><?php echo $orders['stock_in_hand'] ?> </td>
                        <td>
							Ledger: <?php echo $orders['qty'] ?><br>
							Fair / Store: <?php echo ($orders['bookfair']+$orders['bookfair2']+$orders['bookfair3']+$orders['bookfair4']+$orders['bookfair5']) ?><br>
							<?php if ($orders['lost_qty'] < 0) { ?>
								<span style="color:#008000;">Excess: <?php echo abs($orders['lost_qty']) ?></span><br>
							<?php } elseif ($orders['lost_qty'] > 0) { ?>
								<span style="color:#ff0000;">Lost: <?php echo $orders['lost_qty'] ?><br></span>
							<?php } ?>
						</td>
                        <?php					
						$stockStatus = $orders['quantity'] <= ($orders['stock_in_hand']+$orders['lost_qty']) ? 'IN STOCK' : 'OUT OF STOCK';
						$recommendationStatus = "";
						
						if ($orders['quantity'] <= ($orders['stock_in_hand']+$orders['lost_qty']))
						{
							$stockStatus = "IN STOCK";
							if ($orders['quantity'] <= $orders['stock_in_hand']) {
								$stockStatus = "IN STOCK";
								$recommendationStatus ="";
							} else {
								$stockStatus = "IN STOCK";
								$recommendationStatus = "Print using </span><span style='color:#ff0000;'>LOST</span><span style='color:#0000ff;'> Qty! No Initiate to Print";
							}
						} else {
							$stockStatus = "OUT OF STOCK";
							if ($orders['quantity'] <= $orders['stock_in_hand']) {
								$stockStatus = "OUT OF STOCK";
								$recommendationStatus = "Print using </span><span style='color:#008000;'>EXCESS</span><span style='color:#0000ff;'> Qty! Initiate Print Also";
							} else {
								$stockStatus = "OUT OF STOCK";
								$recommendationStatus ="";
							}
						}
                        ?>
                        <td>
							<?php echo $stockStatus ?>
							<br><span style="color:#0000ff;">
							<?php 
								if (($stockStatus == 'OUT OF STOCK') && ($recommendationStatus == '')) {
								} else {
									echo $recommendationStatus;
								} 
							?></span>
						</td>
                        <td><?php echo $orders['price']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
		<?php
			$disableShipment = false; 
			foreach ($bulk_order as $orders) {
				if ($orders['quantity'] <= ($orders['stock_in_hand']+$orders['lost_qty']))
				{
					if ($orders['quantity'] <= $orders['stock_in_hand']) {

					} else {
						$disableShipment = true;
						break;
					}
				} else {
					$disableShipment = true; 
					break;
				}
				
				
			}
		?>
        <br><br>
        <div class="d-flex justify-content-center mt-4 mb-4 gap-3">
            <a href="#" onclick="fetchOrderDetails()" 
            class="btn btn-outline-lilac-600 radius-8 px-20 py-11"
            <?php if ($disableShipment) echo 'disabled'; ?>>
            Shipment
            </a>
            <a href="<?= base_url('paperback/onlineorderbooksstatus'); ?>" 
            class="btn btn-outline-danger-600 radius-8 px-20 py-11">
            Close
            </a>
        </div>
    </div>
</div>
<script>
    var base_url = "<?= base_url() ?>";
    function fetchOrderDetails() {
        var order_id = document.getElementById('order_id').value;
        var tracking_id = document.getElementById('tracking_id').value;
        var tracking_url = document.getElementById('tracking_url').value;
        var book_ids = [];

        document.querySelectorAll('#order_table tbody tr').forEach(function(row) {
            var book_id = row.cells[1].innerText;
            book_ids.push(book_id);
        });

        $.ajax({
        url: base_url + 'paperback/bulkonlineordershipmentcompleted', 
        type: 'POST',
        data: {
            "order_id": order_id,
            "book_ids": JSON.stringify(book_ids), 
            "tracking_id": tracking_id,
            "tracking_url": tracking_url
        },
        dataType: 'JSON', 
        success: function(data) {
            if (data.status == 1) {
                alert("Order shipped successfully!");
                location.reload();
            } else {
                alert("Order not found or error occurred!");
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('Error:', textStatus, errorThrown);
            alert("Something went wrong. Please try again.");
        }
    });

}

</script>
<?= $this->endSection(); ?>
