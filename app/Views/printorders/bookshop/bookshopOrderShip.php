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
            <h6 class="text-center">Order ID: <?php echo $order_id ?> </h6>
            <h6 class="text-center">No.Of.Title: <?php echo $ship['details']['tot_book'] ?> </h6>
        <br>
        <div class="row">
            <div class="col-2">
            </div>
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
									<td  class="table-warning">
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
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card h-100 radius-12 bg-gradient-purple">
                    <div class="card-body p-24">
                        <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-lilac-600 text-white mb-16 radius-12">
                            <iconify-icon icon="solar:map-point-wave-bold" class="h5 mb-0"></iconify-icon>
                        </div>
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
                        <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-lilac-600 text-white mb-16 radius-12">
                            <iconify-icon icon="solar:delivery-bold" class="h5 mb-0"></iconify-icon>
                        </div>
                        <h6 class="mb-8">Tracking Details</h6>
                        <form>
                            <input type="hidden" class="form-control" id="order_id" name="order_id" value="<?= esc($order_id) ?>">
                            <div class="form-group mb-16">
                                <label for="tracking_id"><strong>Tracking ID</strong></label>
                                <input type="text" class="form-control" id="tracking_id" name="tracking_id"
                                       value="<?= esc($ship['details']['tracking_id'] ?? '') ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="tracking_url"><strong>Tracking URL</strong></label>
                                <input type="text" class="form-control" id="tracking_url" name="tracking_url"
                                       value="<?= esc($ship['details']['tracking_url'] ?? '') ?>" required>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Shipment Buttons -->
        <br>
        <?php
        $disableShipment = empty($ship['list']);
        if (!$disableShipment) {
            foreach ($ship['list'] as $orders) {
                if ($orders['quantity'] > ($orders['stock_in_hand'] + $orders['lost_qty'])) {
                    $disableShipment = true;
                    break;
                }
            }
        }
        ?>
        <center>
            <div class="field-wrapper">
                <a href="#" onclick="mark_ship()" class="btn btn-success" <?= $disableShipment ? 'disabled' : '' ?>>Ship</a>
                <a href="<?= base_url('paperback/bookshoporderbooksstatus') ?>" class="btn btn-danger">Close</a>
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
            url: base_url + 'paperback/bookshopmarkshipped',
            type: 'POST',
            data: {
                "order_id": order_id,
                "tracking_id": tracking_id,
                "tracking_url": tracking_url,
                
            },
            dataType: 'json',
            success: function(response) {
                if (response.status == 1) {
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



<?= $this->endSection(); ?>
