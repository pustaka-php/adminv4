<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title text-center">
                <h6>Bulk Orders Shipment</h6>
            </div>
        </div>
        <input type="hidden" class="form-control" id="order_id" name="order_id" value="<?= $order_id ?>">
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
        <table class="zero-config table table-hover mt-4">
            <thead>
                <tr>
                    <th style="border: 1px solid grey">S.NO</th>
                    <th style="border: 1px solid grey">Book ID</th>
                    <th style="border: 1px solid grey">Title</th>
                    <th style="border: 1px solid grey">Author Name</th>
                    <th style="border: 1px solid grey">Quantity</th>
                    <th style="border: 1px solid grey">Stock In Hand</th>
                     <th style="border: 1px solid grey">Qty Details</th>
                      <th style="border: 1px solid grey">Stock State</th>
                    <th style="border: 1px solid grey">Total Amount</th>
                </tr>
            </thead>
            <tbody style="font-weight: 1000;">
                <?php $i=1; foreach ($bulk_order as $orders) { ?>
                    <tr>
                        <td style="border: 1px solid grey"><?php echo $i++; ?></td>
                        <td style="border: 1px solid grey"><?php echo $orders['book_id']; ?></td>
                        <td style="border: 1px solid grey"><?php echo $orders['book_title']; ?></td>
                        <td style="border: 1px solid grey"><?php echo $orders['author_name']; ?></td>
                        <td style="border: 1px solid grey"><?php echo $orders['quantity']; ?></td>
                        <td style="border: 1px solid grey"><?php echo $orders['stock_in_hand'] ?> </td>
                        <td style="border: 1px solid grey">
							Ledger: <?php echo $orders['qty'] ?><br>
							Fair / Store: <?php echo ($orders['bookfair']+$orders['bookfair2']+$orders['bookfair3']+$orders['bookfair4']+$orders['bookfair5']) ?><br>
							<?php if ($orders['lost_qty'] < 0) { ?>
								<span style="color:#008000;">Excess: <?php echo abs($orders['lost_qty']) ?></span><br>
							<?php } elseif ($orders['lost_qty'] > 0) { ?>
								<span style="color:#ff0000;">Lost: <?php echo $orders['lost_qty'] ?><br></span>
							<?php } ?>
						</td>
                        <?php
                        // $stockStatus = $orders['quantity'] <= $orders['stock_in_hand'] ? 'IN STOCK' : 'OUT OF STOCK';
											
						$stockStatus = $orders['quantity'] <= ($orders['stock_in_hand']+$orders['lost_qty']) ? 'IN STOCK' : 'OUT OF STOCK';
						$recommendationStatus = "";
						
						if ($orders['quantity'] <= ($orders['stock_in_hand']+$orders['lost_qty']))
						{
							$stockStatus = "IN STOCK";
							// Stock is available; check whether it is from lost qty
							if ($orders['quantity'] <= $orders['stock_in_hand']) {
								$stockStatus = "IN STOCK";
								$recommendationStatus ="";
							} else {
								$stockStatus = "IN STOCK";
								$recommendationStatus = "Print using </span><span style='color:#ff0000;'>LOST</span><span style='color:#0000ff;'> Qty! No Initiate to Print";
							}
						} else {
							$stockStatus = "OUT OF STOCK";
							// Stock not available; Check whether it is from excess qty
							if ($orders['quantity'] <= $orders['stock_in_hand']) {
								$stockStatus = "OUT OF STOCK";
								$recommendationStatus = "Print using </span><span style='color:#008000;'>EXCESS</span><span style='color:#0000ff;'> Qty! Initiate Print Also";
							} else {
								$stockStatus = "OUT OF STOCK";
								$recommendationStatus ="";
							}
						}
                        ?>
                        <td style="border: 1px solid grey">
							<?php echo $stockStatus ?>
							<br><span style="color:#0000ff;">
							<?php 
								if (($stockStatus == 'OUT OF STOCK') && ($recommendationStatus == '')) {
									// Nothing to be displayed 
								} else {
									echo $recommendationStatus;
								} 
							?></span>
						</td>
                        <td style="border: 1px solid grey"><?php echo $orders['price']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
		<?php
			$disableShipment = false; // Flag to indicate whether to disable the Shipment button
			foreach ($bulk_order as $orders) {
				if ($orders['quantity'] <= ($orders['stock_in_hand']+$orders['lost_qty']))
				{
					// Stock is available; check whether it is from lost qty
					if ($orders['quantity'] <= $orders['stock_in_hand']) {
						// Good to ship
					} else {
						$disableShipment = true; // If any book is out of stock, set the flag to true
						break;
					}
				} else {
					// This is from excess stock; fix the stock qty process
					$disableShipment = true; // If any book is out of stock, set the flag to true
					break;
				}
				
				
			}
		?>

<a href="#" onclick="fetchOrderDetails()" class="btn btn-primary btn-lg mb-2 mr-2" <?php if ($disableShipment) echo 'disabled'; ?>>Shipment</a>

    </div>
</div>

<script>
    var base_url = window.location.origin;

function fetchOrderDetails() {
    var order_id = document.getElementById('order_id').value;
    var tracking_id = document.getElementById('tracking_id').value;
    var tracking_url = document.getElementById('tracking_url').value;
    var book_ids = [];

    document.querySelectorAll('#order_table tbody tr').forEach(function(row) {
        var book_id = row.cells[1].innerText;
        book_ids.push(book_id);
    });

    // console.log({
    //     "order_id": order_id,
    //     "book_ids": book_ids,
    //     "tracking_id": tracking_id,
    //     "tracking_url": tracking_url
    // });

    $.ajax({
        url: base_url + 'paperback/bulkordershipmentcompleted',
        type: 'POST',
        dataType: 'json', // Expecting JSON response
        data: {
            "order_id": order_id,
            "book_ids": JSON.stringify(book_ids), // Convert array to JSON string
            "tracking_id": tracking_id,
            "tracking_url": tracking_url
        },
        success: function(data) {
            if (data == 1) {
                alert("Order ID shipped");
            } else {
                alert("Order ID not found or an error occurred!");
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('Error:', textStatus, errorThrown);
        }
    });
}

</script>
<?= $this->endSection(); ?>
