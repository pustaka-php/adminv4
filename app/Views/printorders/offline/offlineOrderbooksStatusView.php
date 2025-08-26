<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title row">
                <div class="col">
                <h6>Offline Paperback Status Dashboard</h6> 
                </div>
                <div class="col-3">
                    <a href="offlineorderbooksdashboard" class="btn btn-info mb-2 mr-2">Create New Offline Orders</a>
                </div>
            </div>
        </div>
        <br>
       

        <br>
        <h6 class="text-center"><u>Offline: In progress Orders</u></h6>
        <div class="row">
            <div class="col-8">
                <!-- Content for the first column (8 columns wide) -->
            </div>
            <div class="col">
                <input type="text" class="form-control text-dark" id="bulk_order_id" name="bulk_order_id" placeholder="Enter Order ID">
            </div>
            <div class="col-2">
                <a href="#" onclick="bulk_orders(event)" class="btn btn-primary btn-lg mb-2 mr-2">For Bulk Orders</a>
            </div>
        </div>

           <br>
            <table class="zero-config table table-hover mt-4">
                <thead>
                        <tr>
                            <th style="border: 1px solid grey">S.NO</th>
                            <th style="border: 1px solid grey">Order id</th>
                            <th style="border: 1px solid grey">Book ID</th>
                            <th style="border: 1px solid grey">Title</th>
                            <th style="border: 1px solid grey">Copies</th>
                            <th style="border: 1px solid grey">Author name</th>
                            <th style="border: 1px solid grey">Ship Date</th>
                            <th style="border: 1px solid grey">Stock In Hand</th>
                            <th style="border: 1px solid grey">Qty Details</th>
                            <th style="border: 1px solid grey">Stock state</th>
                            <th style="border: 1px solid grey">Payment Details</th>
                            <th style="border: 1px solid grey">Action </th>
                        </tr>
                    </thead>
                    <tbody style="font-weight: normal;">
                        <?php $i=1;
                            foreach ($offline_orderbooks['in_progress'] as $order_books){?>
                                <tr>
                                    <td style="border: 1px solid grey"><?php echo $i++; ?></td>
                                    <td style="border: 1px solid grey">
                                        <a href="<?= base_url('paperback/offlineorderdetails/' . $order_books['offline_order_id']) ?>" target="_blank">
                                          <?php echo $order_books['offline_order_id']; ?>
                                        </a> <br>
                                        <?php echo '(' . $order_books['customer_name'] . ')'; ?>
                                        <br> <?php echo $order_books['city']; ?>
                                    </td>
                                    <td style="border: 1px solid grey"><a href="<?= base_url('paperback/paperbackledgerbooksdetails/' .$order_books['book_id']) ?>" target="_blank"><?php echo $order_books['book_id'] ?></a></td>
                                   <td style="border: 1px solid grey"><?php echo $order_books['book_title'] ?></td>
                                    <td style="border: 1px solid grey"><?php echo $order_books['quantity'] ?> </td>
                                    <td style="border: 1px solid grey"><?php echo $order_books['author_name'] ?></td>
                                    <td style="border: 1px solid grey"><?php echo date('d-m-Y',strtotime($order_books['ship_date']))?> </td>
                                    <td style="border: 1px solid grey"><?php echo $order_books['stock_in_hand'] ?> </td>
                                    <td style="border: 1px solid grey">
										Ledger: <?php echo $order_books['qty'] ?><br>
										Fair / Store: <?php echo ($order_books['bookfair']+$order_books['bookfair2']+$order_books['bookfair3']+$order_books['bookfair4']+$order_books['bookfair5']) ?><br>
										<?php if ($order_books['lost_qty'] < 0) { ?>
											<span style="color:#008000;">Excess: <?php echo abs($order_books['lost_qty']) ?></span><br>
										<?php } elseif ($order_books['lost_qty'] > 0) { ?>
											<span style="color:#ff0000;">Lost: <?php echo $order_books['lost_qty'] ?><br></span>
										<?php } ?>
									</td>
                                    <?php
                                    // $stockStatus = $order_books['quantity'] <= $order_books['total_quantity'] ? 'IN STOCK' : 'OUT OF STOCK';
																		
									$stockStatus = $order_books['quantity'] <= ($order_books['stock_in_hand']+$order_books['lost_qty']) ? 'IN STOCK' : 'OUT OF STOCK';
									$recommendationStatus = "";
									
									if ($order_books['quantity'] <= ($order_books['stock_in_hand']+$order_books['lost_qty']))
									{
										$stockStatus = "IN STOCK";
										// Stock is available; check whether it is from lost qty
										if ($order_books['quantity'] <= $order_books['stock_in_hand']) {
											$stockStatus = "IN STOCK";
											$recommendationStatus ="";
										} else {
											$stockStatus = "IN STOCK";
											$recommendationStatus = "Print using </span><span style='color:#ff0000;'>LOST</span><span style='color:#0000ff;'> Qty! No Initiate to Print";
										}
									} else {
										$stockStatus = "OUT OF STOCK";
										// Stock not available; Check whether it is from excess qty
										if ($order_books['quantity'] <= $order_books['stock_in_hand']) {
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
                                    <td style="border: 1px solid grey"> <?php echo $order_books['payment_type'].'-'.$order_books['payment_status'] ?></td>
                                    <td style="border: 1px solid grey; text-align: center;">
                                        <?php if (($stockStatus == 'OUT OF STOCK') && ($recommendationStatus == '')) { ?>
                                            <a href="<?php echo base_url() . "paperback/paperbackprintstatus" ?>" 
                                            class="btn btn-default" target="_blank" 
                                            style="background-color: purple; color: white; padding: 4px 10px; font-size: 12px;">
                                            Status
                                            </a>
                                            <br><br>
                                            <a href="<?php echo base_url() . "paperback/initiateprintdashboard/" . $order_books['book_id'] ?>" 
                                            class="btn btn-warning" target="_blank" 
                                            style="padding: 4px 10px; font-size: 12px;">
                                            Print
                                            </a>
                                        <?php } else { ?>
                                            <a href="<?= base_url('paperback/offlineordership/' . $order_books['offline_order_id'] . '/' . $order_books['book_id']); ?>" 
                                            class="btn btn-success mb-2 mr-2" target="_blank" 
                                            style="padding: 4px 10px; font-size: 12px;">
                                            Ship
                                            </a>
                                            <br><br>
                                            <a href="" onclick="mark_cancel('<?php echo $order_books['offline_order_id'] ?>','<?php echo $order_books['book_id'] ?>')" 
                                            class="btn btn-danger mb-2 mr-2" 
                                            style="padding: 4px 10px; font-size: 12px;">
                                            Cancel
                                            </a>
                                        <?php } ?>
                                    </td>

                                </tr>
                        <?php }?>
                    </tbody>
                </table>
                <br>
               <br>
               <br>
               <center><h6 class="text-center"><u>Offline: Completed Orders & Pending Payment</u>
               <a href="<?php echo base_url(); ?>paperback/totalofflineordercompleted" class="bs-tooltip " title="<?php echo 'View all Completed Books'?>"target=_blank>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="blue" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-external-link">
                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                        <polyline points="15 3 21 3 21 9"></polyline>
                        <line x1="10" y1="14" x2="21" y2="3"></line>
                    </svg>
                </a></h6>
                <h6 class="text-center">( Shows for 30 days from date of shipment )</h6></center>
               <table class="zero-config table table-hover mt-4">
                <thead>
                        <tr>
                            <th style="border: 1px solid grey">S.NO</th>
                            <th style="border: 1px solid grey">Order id</th>
                            <th style="border: 1px solid grey">Order Date</th>
                            <th style="border: 1px solid grey">Book ID</th>
                            <th style="border: 1px solid grey">Title</th>
                            <th style="border: 1px solid grey">Author name</th>
                            <th style="border: 1px solid grey">Shipped Date</th>
                            <th style="border: 1px solid grey">Payment Details</th>
                            <th style="border: 1px solid grey">Action</th>
                        </tr>
                    </thead>
                    <tbody style="font-weight: normal;">
                        <?php $i=1;
                            foreach ($offline_orderbooks['completed'] as $order_books){?>
                            <tr>
                                <td style="border: 1px solid grey"><?php echo $i++; ?></td>
                                <td style="border: 1px solid grey">
                                        <a href="<?= base_url('paperback/offlineorderdetails/' . $order_books['offline_order_id']) ?>" target="_blank">
                                          <?php echo $order_books['offline_order_id']; ?>
                                        </a>
                                        <br>
                                        <?php echo '(' . $order_books['customer_name'] . ')'; ?> 
                                        <?php echo $order_books['city']; ?>
                                        <br><br>
                                        <a href="<?php echo $order_books['url']; ?>" target="_blank">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck">
                                                <rect x="1" y="3" width="15" height="13"></rect>
                                                <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                                <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                                <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                            </svg>
                                        </a>
                                </td>
                                <td style="border: 1px solid grey"> <?php
                                if ($order_books['order_date']== NULL) {
                                    echo '';
                                } else {
                                    echo date('d-m-Y', strtotime($order_books['order_date'])); 
                                }?></td>
                                <td style="border: 1px solid grey"><a href="<?= base_url('paperback/paperbackledgerbooksdetails/' .$order_books['book_id']) ?>" target="_blank"><?php echo $order_books['book_id'] ?></a></td>
                                <td style="border: 1px solid grey"><?php echo $order_books['book_title'] ?></td>
                                <td style="border: 1px solid grey"><?php echo $order_books['author_name'] ?></td>
                                <td style="border: 1px solid grey"><?php echo date('d-m-Y',strtotime($order_books['shipped_date']))?> </td>
                                <td style="border: 1px solid grey"><?php echo $order_books['payment_type'].'-'.$order_books['payment_status'] ?>
                                <?php $payment_status=$order_books['payment_status'];?>
                                <br>
                                <?php if ($payment_status =='Pending') { ?>
                                    <a href="" onclick="mark_pay('<?php echo $order_books['offline_order_id'] ?>')" class="btn-sm btn-primary mb-2 mr-2">Mark Paid</a>
                                <?php } ?>
                                </td>
                                <td style="border: 1px solid grey; text-align: center;">
                                 <a href="" onclick="mark_return('<?php echo $order_books['offline_order_id'] ?>','<?php echo $order_books['book_id'] ?>')" class="btn btn-primary mb-2 mr-2">Return</a>
                                </td>
                            </tr>
                        <?php }?>
                    </tbody>
                </table>
                <br>
                <br>
                <h6 class="text-center"><u>Offline: Cancel Orders</u></h6>
                <table class="zero-config table table-hover mt-4">
                <thead>
                            <tr>
                            <th style="border: 1px solid grey">S.NO</th>
                            <th style="border: 1px solid grey">Order id</th>
                            <th style="border: 1px solid grey">Order Date</th>
                            <th style="border: 1px solid grey">Book ID</th>
                            <th style="border: 1px solid grey">title</th>
                            <th style="border: 1px solid grey">Author name</th>
                            <th style="border: 1px solid grey">Cancel Date</th>
                            </tr>
                       </thead>
                      <tbody style="font-weight: normal;">
                       <?php $i=1;
                        foreach ($offline_orderbooks['cancel'] as $order_books){?>
                            <tr>
                                <td style="border: 1px solid grey"><?php echo $i++; ?></td>
                                <td style="border: 1px solid grey">
                                        <a href="<?= base_url('paperback/offlineorderdetails/' . $order_books['offline_order_id']) ?>" target="_blank">
                                          <?php echo $order_books['offline_order_id']; ?>
                                        </a> <br>
                                        <?php echo '(' . $order_books['customer_name'] . ')'; ?> 
                                        <?php echo $order_books['city']; ?>   
                                </td>
                                <td style="border: 1px solid grey"> <?php
                                if ($order_books['order_date']== NULL) {
                                    echo '';
                                } else {
                                    echo date('d-m-Y', strtotime($order_books['order_date'])); 
                                }?></td>
                                <td style="border: 1px solid grey"><a href="<?= base_url('paperback/paperbackledgerbooksdetails/' .$order_books['book_id']) ?>" target="_blank"><?php echo $order_books['book_id'] ?></a></td>
                                <td style="border: 1px solid grey"><?php echo $order_books['book_title'] ?></td>
                                <td style="border: 1px solid grey"><?php echo $order_books['author_name'] ?></td> 
                                <td style="border: 1px solid grey"> <?php
                                if ($order_books['date']== NULL) {
                                    echo '';
                                } else {
                                    echo date('d-m-Y', strtotime($order_books['date'])); 
                                }?></td>
                            </tr>
                    <?php }?>
                    </tbody>
                </table>
                <br>
                <h6 class="text-center"><u>Offline: Return Orders</u></h6>
                <table class="zero-config table table-hover mt-4">
                    <thead>
                        <tr>
                        <th style="border: 1px solid grey">S.NO</th>
                        <th style="border: 1px solid grey">Order id</th>
                        <th style="border: 1px solid grey">Order Date</th>
                        <th style="border: 1px solid grey">Book ID</th>
                        <th style="border: 1px solid grey">title</th>
                        <th style="border: 1px solid grey">Author name</th>
                        <th style="border: 1px solid grey">Return Date</th>
                        </tr>
                    </thead>
                    <tbody style="font-weight: normal;">
                        <?php $i=1;
                            foreach ($offline_orderbooks['return'] as $order_books){?>
                                <tr>
                                    <td style="border: 1px solid grey"><?php echo $i++; ?></td>
                                    <td style="border: 1px solid grey">
                                            <a href="<?= base_url('paperback/offlineorderdetails/' . $order_books['offline_order_id']) ?>" target="_blank">
                                                <?php echo $order_books['offline_order_id']; ?>
                                            </a> <br>
                                            <?php echo '(' . $order_books['customer_name'] . ')'; ?> 
                                            <?php echo $order_books['city']; ?>   
                                    </td>
                                    <td style="border: 1px solid grey"> <?php
                                    if ($order_books['order_date']== NULL) {
                                        echo '';
                                    } else {
                                        echo date('d-m-Y', strtotime($order_books['order_date'])); 
                                    }?></td>
                                    <td style="border: 1px solid grey"><a href="<?= base_url('paperback/paperbackledgerbooksdetails/' .$order_books['book_id']) ?>" target="_blank"><?php echo $order_books['book_id'] ?></a></td>
                                    <td style="border: 1px solid grey"><?php echo $order_books['book_title'] ?></td>
                                    <td style="border: 1px solid grey"><?php echo $order_books['author_name'] ?></td> 
                                    <td style="border: 1px solid grey"> <?php
                                    if ($order_books['date']== NULL) {
                                        echo '';
                                    } else {
                                        echo date('d-m-Y', strtotime($order_books['date'])); 
                                    }?></td>
                                </tr>
                        <?php }?>
                    </tbody>
                </table>
     <div> 
</div>

<script type="text/javascript">
    var base_url = window.location.origin;
    
    function mark_cancel(offline_order_id,book_id){
        $.ajax({
                url: base_url + 'paperback/offlinemarkcancel',
                type: 'POST',
                data: {
                    "offline_order_id":offline_order_id,
                    "book_id":book_id,
                },
                success: function(data) {
               //alert(data);
                    if (data == 1) {
                        alert("Shipping Cancel!!");
                    
                    }
                    else {
                        alert("Unknown error!! Check again!")
                    }
                }
            });
    }

    function mark_pay(offline_order_id){
        $.ajax({
                url: base_url + 'paperback/offlinemarkpay',
                type: 'POST',
                data: {
                    "offline_order_id":offline_order_id,
                },
                success: function(data) {
                    if (data == 1) {
                        alert("Payment Received!");
                    }
                    else {
                        alert("Unknown error!! Check again!")
                    }
            }
         });
    }

    function mark_return(offline_order_id,book_id){
        $.ajax({
                url: base_url + 'paperback/offlinemarkreturn',
                type: 'POST',
                data: {
                    "offline_order_id":offline_order_id,
                    "book_id":book_id,
                },
                success: function(data) {
                    if (data == 1) {
                        alert("Restore Successfully!!");
                    }
                    else {
                        alert("Unknown error!! Check again!")
                    }
            }
         });
    } 
        
    function bulk_orders(event) {
        event.preventDefault(); // Prevent the default anchor action
        var bulkOrderId = document.getElementById('bulk_order_id').value;
        // console.log("Bulk Order ID:", bulkOrderId); // Log the ID to check the value
        if (bulkOrderId) { // Check if bulkOrderId is not empty
            var url = 'offlinebulkordersship/' + encodeURIComponent(bulkOrderId);
            window.location.href = url;
        } else {
            alert("Please enter a Bulk Order ID."); // Notify the user if the input is empty
        }
    }


</script>
<?= $this->endSection(); ?>