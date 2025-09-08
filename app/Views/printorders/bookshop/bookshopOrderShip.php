<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <center><h3>Shipping and tracking ID & tracking URL</h3></center>
            </div>
        </div>
        <br>
        <?php $order_id = $this->uri->segment(3); ?>
        <center>
            <h5>Order ID: <?php echo $order_id ?> </h5>
            <h6>No.Of.Title: <?php echo $ship['details']['tot_book'] ?> </h6>
        </center>
        <br>
        <div class="row">
            <div class="col-2">
            </div>
            <div class="col-8">
                <div class="table-responsive">
                    <table class="table table-bordered mb-4">
                        <thead>
                            <tr>
                                <th class="">Book Id</th>
                                <th class="">Book Name</th>
                                <th class="">Copies</th>
                                <th class="">Stock In Hand</th>
                                <th class="">Qty Details</th>
                                <th class="">Stock State</th>
                            </tr>
                        </thead>
                        <tbody id="bookList">
                            <?php foreach ($ship['list'] as $details) { ?>
                                <tr>
                                    <td>
                                        <p class="mb-0"><?php echo $details['book_id']; ?></p>
                                    </td>
                                    <td>
                                        <p class="mb-0"><?php echo $details['book_title']; ?></p>
                                    </td>
                                    <td>
                                        <p class="mb-0"><?php echo $details['quantity']; ?></p>
                                    </td>
                                    <td>
                                        <p class="mb-0"><?php echo $details['stock_in_hand']; ?></p>
                                    </td>
									<td  class="table-warning" style="border: 1px solid grey">
										Ledger: <?php echo $details['qty'] ?><br>
										Fair / Store: <?php echo ($details['bookfair']+$details['bookfair2']+$details['bookfair3']+$details['bookfair4']+$details['bookfair5']) ?><br>
										<?php if ($details['lost_qty'] < 0) { ?>
											<span style="color:#008000;">Excess: <?php echo abs($details['lost_qty']) ?></span><br>
										<?php } elseif ($details['lost_qty'] > 0) { ?>
											<span style="color:#ff0000;">Lost: <?php echo $details['lost_qty'] ?><br></span>
										<?php } ?>
									</td>
                                    <?php 
										// $stock_status = $details['qty'] >= $details['quantity'] ? "In stock" : "Out of stock"; 
																			
										$stockStatus = $details['quantity'] <= ($details['stock_in_hand']+$details['lost_qty']) ? 'IN STOCK' : 'OUT OF STOCK';
										$recommendationStatus = "";
										
										if ($details['quantity'] <= ($details['stock_in_hand']+$details['lost_qty']))
										{
											$stockStatus = "IN STOCK";
											// Stock is available; check whether it is from lost qty
											if ($details['quantity'] <= $details['stock_in_hand']) {
												$stockStatus = "IN STOCK";
												$recommendationStatus ="";
											} else {
												$stockStatus = "IN STOCK";
												$recommendationStatus = "Print using </span><span style='color:#ff0000;'>LOST</span><span style='color:#0000ff;'> Qty! No Initiate to Print";
											}
										} else {
											$stockStatus = "OUT OF STOCK";
											// Stock not available; Check whether it is from excess qty
											if ($details['quantity'] <= $details['stock_in_hand']) {
												$stockStatus = "OUT OF STOCK";
												$recommendationStatus = "Print using </span><span style='color:#008000;'>EXCESS</span><span style='color:#0000ff;'> Qty! Initiate Print Also";
											} else {
												$stockStatus = "OUT OF STOCK";
												$recommendationStatus ="";
											}
										}
									?>
                                    <td class="stock-status">
										<?php echo $stockStatus; ?><br>
										<?php echo $recommendationStatus; ?>
									</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Shipping Address</h5>
                    </div>
                    <div class="card-body">
                    <p><strong>Bookshop:</strong> <?php echo $orderbooks['details']['bookshop_name']; ?> </p>
                    <p><strong>Contact Person:</strong> <?php echo $orderbooks['details']['contact_person_name']; ?> </p>
                    <p><strong>Mobile No:</strong> <?php echo $orderbooks['details']['mobile']; ?> </p>
                    <p><strong>Transport Details: </strong><?php echo $orderbooks['details']['preferred_transport']."-".$orderbooks['details']['preferred_transport_name']; ?> </p>
                    <p><strong>Address:</strong> <?php echo $orderbooks['details']['ship_address']; ?> </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                    <form>
                        <br>
                        <input type="hidden" class="form-control" id="order_id" name="order_id" value="<?php echo $order_id; ?>">
                        <div class="form-group">
                            <label for="bookId">Tracking ID</label>
                            <input type="text-dark" class="form-control" id="tracking_id" name="tracking_id"
                                value="<?php echo $ship['details']['tracking_id']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="bookTitle">Tracking URL</label>
                            <input type="text" class="form-control" id="tracking_url" name="tracking_url"
                                value="<?php echo $ship['details']['tracking_url']; ?>" required>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
        <br>
		<?php
			$disableShipment = false; // Flag to indicate whether to disable the Shipment button
			foreach ($ship['list'] as $orders) {
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
        <center>
            <div class="field-wrapper">
                <a href="" onclick="mark_ship()" class="btn btn-success" <?php if ($disableShipment) echo 'disabled'; ?>>Ship</a>
                <a href="<?php echo base_url() . "pustaka_paperback/bookshop_orderbooks_status" ?>" class="btn btn-danger">Close</a>
            </div>
        </center>
    </div>
</div>

<script type="text/javascript">
    var base_url = window.location.origin;

    function mark_ship() {
        var order_id = document.getElementById('order_id').value;
        var tracking_id = document.getElementById('tracking_id').value;
        var tracking_url = document.getElementById('tracking_url').value;

        // Check if any item is out of stock
        var allInStock = true;
        var stockStatusCells = document.querySelectorAll('.stock-status');

        stockStatusCells.forEach(function(cell) {
            if (cell.textContent.trim() !== 'IN STOCK') {
                allInStock = false;
            }
        });

        if (!allInStock) {
            alert("Cannot mark as shipped,Check Stock State!!!");
            return;
        }

        $.ajax({
            url: base_url + '/pustaka_paperback/bookshop_mark_shipped',
            type: 'POST',
            data: {
                "order_id": order_id,
                "tracking_id": tracking_id,
                "tracking_url": tracking_url
            },
            success: function(data) {
                if (data == 1) {
                    alert("Marked as shipped successfully!");
                } else {
                    alert("Unknown error occurred. Please try again.");
                }
            },
            error: function() {
                alert("Error occurred while processing the request.");
            }
        });
    }

</script>
