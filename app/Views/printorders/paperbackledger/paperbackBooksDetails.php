<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 
<?php 
$Book_id=$this->uri->segment(3);
$totalStockIn = 0;
$totalStockOut = 0;
$totalStock = 0; 
foreach ($details['list'] as $books_details) {
    $totalStockIn += $books_details['stock_in'];
    $totalStockOut += $books_details['stock_out'];
    $totalStock += $books_details['stock_in'] - $books_details['stock_out'];
}
?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="card-deck">
            <div class="card">
                <ul class="list-group list-group-flush ">
                    <li class="list-group-item">
                        <h3 class="text-center">Book Details</h3>
                    </li>
                        <table class="table">

                            <td><h5><strong>Book Id</strong></h5></td>
                            <td><h5>: <?php echo $Book_id?></h5></td>
                        </tr>
                        <tr>
                            <td><h5><strong>Book Title</strong></h5></td>
                            <td><h5>: <?php echo $details['books']['book_title'] ?></h5></td>
                        </tr>
                        <tr>
                            <td><h5><strong>Regional Title</strong></h5></td>
                            <td><h5>: <?php echo $details['books']['regional_book_title'] ?></h5></td>
                        </tr>
                        <tr>
                            <td><h5><strong>Book Price</strong></h5></td>
                            <td><h5>: <?php echo $details['books']['paper_back_inr'] ?></h5></td>
                        </tr>
                        <br>
                        <tr>
                            <td><h5><strong>Author Id</strong></h5></td>
                            <td><h5>: <?php echo $details['books']['author_id'] ?></h5></td>
                        </tr>
                        <tr>
                            <td><h5><strong>Author Name  </strong></h5></td>
                            <td><h5>: <?php echo $details['books']['author_name'] ?></h5></td>
                        </tr>
                        <tr>
                            <td><h5><strong>Copyright Owner</strong></h5></td>
                            <td><h5> : <?php echo $details['books']['paper_back_copyright_owner'] ?></h5></td>
                        </tr>
                        </table>
                        <br>
                        <br>
                    </ul>
            </div>
            <div class="card">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <h3 class="text-center">Stock Details</h3>
                        <h5 style="color: Blue; text-align: center;">(From paperback_stock Table)</center></h5>
                    </li>
                    <table class="table">
                            <tr>
                                <?php if ($details['books']['quantity'] == $details['books']['bookfair'] + $details['books']['stock_in_hand']) { ?>
                                    <td><h6 ><strong>Total Quantity:</strong></h6></td>
                                    <td><b><h4 style="color: green;"><?php echo $details['books']['quantity']; ?></h4></b></td>
                                <?php } else { ?>
                                    <td><h6><strong>Total Quantity:</strong></h6></td>
                                    <td><h6><?php echo $details['books']['quantity']; ?></h6></td>
                                <?php } ?>
                            </tr>
                            <tr>
							    <td><h6><strong>Book Fair / Store:</strong></h6></td>
                                <td><h6><?php echo ($details['books']['bookfair']+$details['books']['bookfair2']+$details['books']['bookfair3']+$details['books']['bookfair4']+$details['books']['bookfair5']) ?></h6></td>
                            </tr>
							 <tr>
							    <td><h6><strong>Lost Qty:</strong></h6></td>
                                <td><h6><?php echo $details['books']['lost_qty'] ?></h6></td>
                            </tr>
							<tr>
                                <td><h6><strong>Current Stock:</strong></h6></td>
                                <td><h6><?php echo $details['books']['stock_in_hand'] ?></h6></td>
                            </tr>     
                            <td><h5 style="color: Blue; text-align: center;">(From pustaka_paperback_stock_ledger Table)</h5></td>
                            <tr>
                                <td><h6><strong>Total Stock In:</strong></h6></td>
                                <td><h6><?php echo $totalStockIn ?></h6></td>
                            </tr>
                            <tr>
                                 <td><h6><strong>Total Stock Out:</strong></h6></td>
                                <td><h6><?php echo $totalStockOut ?></h6></td>
                            </tr>
                            <tr>
                                <td><h6><strong>Available Stock:</strong></h6></td>
                                <td><h6><?php echo $totalStock ?></h6></td>
                            </tr>     
                        </table>
						<?php
							if ($details['books']['quantity'] == $totalStock) {
								echo '<div class="alert alert-success" role="alert">
								<h6 style="color:green; text-align: center;"> <strong>Matched!</strong> Total Quantity is equal to Available Stock.</h6>
									</div>';
							} else if ($details['books']['quantity'] > $totalStock) {
								echo '<div class="alert alert-danger" role="alert">
								<h6 style="color:red; text-align: center;"><strong>Mismatch!</strong> Total Quantity is greater than Available Stock.</h6>
									</div>';
							} else {
								echo '<div class="alert alert-danger" role="alert">
									   <h6 style="color:red; text-align: center;"> <strong>Mismatch!</strong> Total Quantity is less than Available Stock.</h6>
									</div>';
							}
						?>
                </ul>
            </div>
       </div>
	   <br>
		<table class="table">
			<thead class="thead-dark">
            <center><h4>Book Fair / Store Distribution</h4></center>
			<tr>
				<th style="border: 1px solid grey">Book Fair</th>
				<th style="border: 1px solid grey">Book Fair 2</th>
				<th style="border: 1px solid grey">Book Fair 3</th>
				<th style="border: 1px solid grey">Book Fair 4</th>
				<th style="border: 1px solid grey">Book Fair 5</th>
			</tr>
			<tr>
				<td><?php echo $details['books']['bookfair'] ?></td>
				<td><?php echo $details['books']['bookfair2'] ?></td>
				<td><?php echo $details['books']['bookfair3'] ?></td>
				<td><?php echo $details['books']['bookfair4'] ?></td>
				<td><?php echo $details['books']['bookfair5'] ?></td>
			</tr>
		</table>
       <br>
        <table class="table table-bordered mb-4 zero-config">
            <thead class="thead-dark">
            <center><h4>Book stock ledger</h4></center>
            <tr>
                <th style="border: 1px solid grey">S.No</th> 
                <th style="border: 1px solid grey">order id</th>
                <th style="border: 1px solid grey">Copyright Owner</th>
                <th style="border: 1px solid grey">channel type</th>
                <th style="border: 1px solid grey">description</th>
                <th style="border: 1px solid grey">stock in</th>
                <th style="border: 1px solid grey">stock out</th>
                <th style="border: 1px solid grey">transaction date</th>
            </tr>
            </thead>
            <tbody style="font-weight: 800;">
            <?php
                

                $i = 1;
                foreach ($details['list'] as $books_details) {
                    $totalStockIn += $books_details['stock_in'];
                    $totalStockOut += $books_details['stock_out'];
                    ?>
                    <tr>
                        <td style="border: 1px solid grey"><?php echo $i++; ?></td>
                        <td style="border: 1px solid grey"><?php echo $books_details['order_id'] ?></td>
                        <td style="border: 1px solid grey"><?php echo $books_details['copyright_owner'] ?></td>
                        <td style="border: 1px solid grey"><?php echo $books_details['channel_type']?></td>
                        <td style="border: 1px solid grey"><?php echo $books_details['description'] ?></td>
                        <td style="border: 1px solid grey"><?php echo $books_details['stock_in'] ?></td>
                        <td style="border: 1px solid grey"><?php echo $books_details['stock_out'] ?></td>
                        <td style="border: 1px solid grey">
                            <?php echo date('d-m-Y', strtotime($books_details['transaction_date'])); ?>
                        </td>  
                    </tr>
                    <?php
                    $totalStock += $books_details['stock_in'] - $books_details['stock_out'];
                }?>  
            </tbody>
        </table> 
        <br>   
        <table class="table table-bordered mb-4 zero-config">
            <thead class="thead-dark">
            <center><h4>Author Transaction</h4></center>
            <tr>
                <th style="border: 1px solid grey">S.No</th> 
                <th style="border: 1px solid grey">order date</th>
                <th style="border: 1px solid grey">Royalty Value</th>
                <th style="border: 1px solid grey">comments</th>
            </tr>
            </thead>
            <tbody style="font-weight: 800;">
                <?php
                    $i = 1;
                    foreach ($details['author'] as $books_details) {
                ?>
                    <tr>
                        <td style="border: 1px solid grey"><?php echo $i++; ?></td>
                        <td style="border: 1px solid grey"><?php echo date('d-m-Y', strtotime($books_details['order_date']));?></td>
                        <td style="border: 1px solid grey"><?php echo $books_details['book_final_royalty_value_inr'] ?></td>
                        <td style="border: 1px solid grey"><?php echo $books_details['comments']?></td> 
                        </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <br>
        <table class="table table-bordered mb-4 zero-config">
            <thead class="thead-dark">
            <center><h4>Author Transaction(Before sep 30)</h4></center>
            <tr>
                <th style="border: 1px solid grey">S.No</th> 
                <th style="border: 1px solid grey">order date</th>
                <th style="border: 1px solid grey">Channel</th>
                <th style="border: 1px solid grey">Royalty Value</th>
                <th style="border: 1px solid grey">comments</th>
            </tr>
            </thead>
            <tbody style="font-weight: 800;">
                <?php
                    $i = 1;
                    foreach ($details['old_details'] as $books_details) {
                ?>
                    <tr>
                        <td style="border: 1px solid grey"><?php echo $i++; ?></td>
                        <td style="border: 1px solid grey"><?php echo date('d-m-Y', strtotime($books_details['order_date']));?></td>
                        <td style="border: 1px solid grey"><?php echo $books_details['channel'] ?></td>
                        <td style="border: 1px solid grey"><?php echo $books_details['book_final_royalty_value_inr'] ?> </td>
                        <td style="border: 1px solid grey"><?php echo $books_details['comments']?></td> 
                        </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <br>
        <center><h4>Book Fair Details</h4></center>
        <table class="table table-bordered mb-4 zero-config">
            <thead>
            <tr>
                <th style="border: 1px solid grey">S.No</th> 
                <th style="border: 1px solid grey">order date</th>
                <th style="border: 1px solid grey">Price</th>
                <th style="border: 1px solid grey">Quantity</th>
                <th style="border: 1px solid grey">Royalty Value</th>
                <th style="border: 1px solid grey">comments</th>
            </tr>
            </thead>
            <tbody style="font-weight: 800;">
                <?php
                    $i = 1;
                    foreach ($details['book_fair'] as $books_details) {
                ?>
                    <tr>
                        <td style="border: 1px solid grey"><?php echo $i++; ?></td>
                        <td style="border: 1px solid grey"><?php echo date('d-m-Y', strtotime($books_details['order_date']));?></td>
                        <td style="border: 1px solid grey"><?php echo $books_details['price'] ?></td>
                        <td style="border: 1px solid grey"><?php echo $books_details['quantity']?></td> 
                        <td style="border: 1px solid grey"><?php echo $books_details['final_royalty_value'] ?></td>
                        <td style="border: 1px solid grey"><?php echo $books_details['comments']?></td> 
                        </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection(); ?>
