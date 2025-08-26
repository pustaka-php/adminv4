<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title row">
                <div class="col">
                </div>
                <div class="col-3">
                    <a href="paperbackamazonorder" class="btn btn-info mb-2 mr-2">Create New Amazon Orders</a>
                </div>
            </div>
        </div>
        <br>
        <br>
        <h6 class="text-center"><u>Amazon: In progress Orders</u></h6>
        <table class="table zero-config">
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
                    <th style="border: 1px solid grey">Action</th>
                </tr>
            </thead>
            <tbody style="font-weight: normal;">
            <?php
            $i = 1;
            foreach ($amazon_orderbooks['in_progress'] as $order_books) {
                ?>
                <tr>
                    <td style="border: 1px solid grey"><?php echo $i++; ?></td>
                    <td style="border: 1px solid grey">
                    <a href="<?= base_url('paperback/amazonorderdetails/'.$order_books['amazon_order_id']) ?>" target="_blank">
                    <?php echo $order_books['amazon_order_id'] ?></a></td>
                    <td style="border: 1px solid grey"><?php echo $order_books['book_id'] ?> </td>
                    <td style="border: 1px solid grey"><?php echo $order_books['book_title'] ?></td>
                    <td style="border: 1px solid grey"><?php echo $order_books['quantity'] ?> </td>
                    <td style="border: 1px solid grey"><?php echo $order_books['author_name'] ?></td>
                    <td style="border: 1px solid grey"><?php echo date('d-m-Y', strtotime($order_books['ship_date'])) ?> </td>
                    <td style="border: 1px solid grey"><?php echo $order_books['stock_in_hand'] ?></td>
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

                    <td style="border: 1px solid grey; text-align: center;">
                        <?php if (($stockStatus == 'OUT OF STOCK') && ($recommendationStatus == '')) { ?>
                            <a href="<?php echo base_url() . "paperback/paperbackprintstatus" ?>" 
                            style="background-color: purple; color: white; border: none; padding: 3px 8px; font-size: 12px; text-decoration: none; display: inline-block;" 
                            target="_blank">Status</a>
                            <br><br>
                            <a href="<?php echo base_url() . "paperback/initiateprintdashboard/" . $order_books['book_id'] ?>" 
                            style="background-color: #ffc107; color: black; border: none; padding: 3px 8px; font-size: 12px; text-decoration: none; display: inline-block;" 
                            target="_blank">Print</a>
                        <?php } else { ?>
                            <a href="" onclick="mark_ship('<?php echo $order_books['amazon_order_id'] ?>','<?php echo $order_books['book_id'] ?>')" 
                            style="background-color: #28a745; color: white; border: none; padding: 3px 8px; font-size: 12px; text-decoration: none; display: inline-block;">Ship</a>
                            <br><br>
                            <a href="" onclick="mark_cancel('<?php echo $order_books['amazon_order_id'] ?>','<?php echo $order_books['book_id'] ?>')" 
                            style="background-color: #dc3545; color: white; border: none; padding: 3px 8px; font-size: 12px; text-decoration: none; display: inline-block;">Cancel</a>
                        <?php } ?>
                    </td>

                </tr>
            <?php } ?>

            </tbody>
        </table>
        <br>
        <br>
       <h6 class="text-center"><u>Amazon: Completed Orders</u>
        <a href="<?php echo base_url(); ?>paperback/totalamazonordercompleted" class="bs-tooltip " title="<?php echo 'View all Completed Books'?>"target=_blank>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="blue" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-external-link">
                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                <polyline points="15 3 21 3 21 9"></polyline>
                <line x1="10" y1="14" x2="21" y2="3"></line>
            </svg>
        </a></h6>
        <h6 class="text-center">( Shows for 30 days from date of shipment )</h6>
        <table class="table table-hover table-success mb-4 zero-config">
                <thead>
                    <tr>
                    <th style="border: 1px solid grey">S.NO</th>
                    <th style="border: 1px solid grey">Order id</th>
                    <th style="border: 1px solid grey">Book ID</th>
                    <th style="border: 1px solid grey">title</th>
                    <th style="border: 1px solid grey">Author name</th>
                    <th style="border: 1px solid grey">Shipped Date</th>
                    <th style="border: 1px solid grey">Action</th>
                    </tr>
                </thead>
                <tbody style="font-weight: normal;">
                <?php $i=1;
                foreach ($amazon_orderbooks['completed'] as $order_books){?>
                    <tr>
                        <td style="border: 1px solid grey"><?php echo $i++; ?></td>
                        <td style="border: 1px solid grey">
                        <a href="<?= base_url('paperback/amazonorderdetails/'.$order_books['amazon_order_id']) ?>" target="_blank">
                        <?php echo $order_books['amazon_order_id'] ?></a></td>
                        <td style="border: 1px solid grey"><?php echo $order_books['book_id']?> </td>
                        <td style="border: 1px solid grey"><?php echo $order_books['book_title'] ?></td>
                        <td style="border: 1px solid grey"><?php echo $order_books['author_name'] ?></td>
                        <td style="border: 1px solid grey"><?php echo date('d-m-Y',strtotime($order_books['ship_date']))?> </td>
                        <td style="border: 1px solid grey; text-align: center;">
                        <a href="" onclick="mark_return('<?php echo $order_books['amazon_order_id'] ?>','<?php echo $order_books['book_id'] ?>')" class="btn btn-primary mb-2 mr-2">Return</a>
                        </td>
                    </tr>
            <?php }?>
            </tbody>
        </table>
        <br>
        <br>
        <table class="table table-hover table-danger mb-4 zero-config">
                    <thead>
                    <h6 class="text-center"><u>Amazon: Cancel Orders</u></h6>
                    <tr>
                    <th style="border: 1px solid grey">S.NO</th>
                    <th style="border: 1px solid grey">Order id</th>
                    <th style="border: 1px solid grey">Book ID</th>
                    <th style="border: 1px solid grey">title</th>
                    <th style="border: 1px solid grey">Author name</th>  
                    <th style="border: 1px solid grey">Cancel Date</th>  
                    </tr>
                </thead>
                <tbody style="font-weight: normal;">
                <?php $i=1;
                foreach ($amazon_orderbooks['cancel'] as $order_books){?>
                    <tr>
                        <td style="border: 1px solid grey"><?php echo $i++; ?></td>
                        <td style="border: 1px solid grey">
                        <a href="<?= base_url('paperback/amazonorderdetails/'.$order_books['amazon_order_id']) ?>" target="_blank">
                        <?php echo $order_books['amazon_order_id'] ?></a></td>
                        <td style="border: 1px solid grey"><?php echo $order_books['book_id']?> </td>
                        <td style="border: 1px solid grey"><?php echo $order_books['book_title'] ?></td>
                        <td style="border: 1px solid grey"><?php echo $order_books['author_name'] ?></td>
                        <td style="border: 1px solid grey"><?php 
                        if($order_books['date']== NUll){
                            echo "";
                        }
                        else{
                            echo date('d-m-Y',strtotime($order_books['date']));
                        }?>
                        </td>
                    </tr>
            <?php }?>
            </tbody>
        </table>
        <br>
        <br>
        <table class="table table-hover table-info mb-4 zero-config">
                <thead>
                    <h6 class="text-center"><u>Amazon: Return Orders</u></h6>
                    <tr>
                        <th style="border: 1px solid grey">S.NO</th>
                        <th style="border: 1px solid grey">Order id</th>
                        <th style="border: 1px solid grey">Book ID</th>
                        <th style="border: 1px solid grey">title</th>
                        <th style="border: 1px solid grey">Author name</th>
                        <th style="border: 1px solid grey">Return Date</th>
                    
                    </tr>
                </thead>
                <tbody style="font-weight: normal;">
                <?php $i=1;
                foreach ($amazon_orderbooks['return'] as $order_books){?>
                    <tr>
                        <td style="border: 1px solid grey"><?php echo $i++; ?></td>
                        <td style="border: 1px solid grey">
                        <a href="<?= base_url('paperback/amazonorderdetails/'.$order_books['amazon_order_id']) ?>" target="_blank">
                        <?php echo $order_books['amazon_order_id'] ?></a></td>
                        <td style="border: 1px solid grey"><?php echo $order_books['book_id']?> </td>
                        <td style="border: 1px solid grey"><?php echo $order_books['book_title'] ?></td>
                        <td style="border: 1px solid grey"><?php echo $order_books['author_name'] ?></td>
                        <td style="border: 1px solid grey"><?php 
                        if($order_books['date']== NUll){
                            echo "";
                        }
                        else{
                            echo date('d-m-Y',strtotime($order_books['date']));
                        }?>
                        </td>
                        
                    </tr>
            <?php }?>
            </tbody>
        </table>
    <div> 
</div>

<script type="text/javascript">


var base_url = window.location.origin;

    function mark_ship(amazon_order_id,book_id){
      $.ajax({
            url: base_url + 'paperback/markShipped',
            type: 'POST',
            data: {
                "amazon_order_id":amazon_order_id,
                "book_id":book_id,
            },
            success: function(data) {
                //alert(data);
                if (data == 1) {
                    alert("completed Successfully!!");
                }
                else {
                    alert("Unknown error!! Check again!")
                }
            }
        });
    }

    function mark_cancel(amazon_order_id,book_id){
     $.ajax({
            url: base_url + 'paperback/markCancel',
            type: 'POST',
            data: {
                "amazon_order_id":amazon_order_id,
                "book_id":book_id,
            },
            success: function(data) {
               // alert(data);
                if (data == 1) {
                    alert("Shipping Cancel!!");
                   
                }
                else {
                    alert("Unknown error!! Check again!")
                }
            }
        });
    }

   function mark_return(amazon_order_id,book_id){
    $.ajax({
            url: base_url + 'paperback/markReturn',
            type: 'POST',
            data: {
                "amazon_order_id":amazon_order_id,
                "book_id":book_id,
            },
            success: function(data) {
                //alert(data);
                if (data == 1) {
                    alert("Restore Successfully!!");
                }
                else {
                    alert("Unknown error!! Check again!")
                }
            }
        });
    }
</script>
<?= $this->endSection(); ?>