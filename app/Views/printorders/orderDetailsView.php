<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?> 

<?php
$numberOfTitles = count($orderbooks['list']); 
$totalBooks = 0;

$order_id =$this->uri->segment(3);
foreach ($orderbooks['list'] as $books_details) {
    $totalBooks += $books_details['quantity'];
}
?>
<div id="content" class="main-content">
         <div class="layout-px-spacing">
           <div class="card bg-info" style="width: 30rem; margin: 0 auto; border-radius: 10px; overflow: hidden;">
					<ul class="list-group-item">
						<li class="list-group-item">
						<h3 class="text-center">Order ID: <?php echo $order_id ?></h3>
					</li>
					<li class="list-group-item">
                        <h3 class="text-center">Online Customer Details</h3>
                    </li>
                    <li class="list-group-item">
                        <h5>User Id:  <?php echo $orderbooks['details']['user_id']; ?> </h5>
                        <h5>User Name: <?php echo $orderbooks['details']['username']; ?> </h5>  
                    </li>
                    <li class="list-group-item">
                    <h5 style=" font-weight: bold; color:blue;">Courier Charges: <?php echo number_format($orderbooks['details']['shipping_charges'],2); ?> </h5>
                        <h5>Order Date: <?php echo date('d-m-Y',strtotime($orderbooks['details']['order_date']))?> </h5>
                        <h5>Shipped Date:
                             <?php
                            if ($orderbooks['details']['ship_date']== NULL) {
                                echo '';
                            } else {
                                echo date('d-m-Y',strtotime($orderbooks['details']['ship_date']));
                            }?> 
                        </h5>      
                        <h5>
                            <a href="<?php echo $orderbooks['details']['tracking_url']; ?>" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck">
                                <rect x="1" y="3" width="15" height="13"></rect>
                                <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                <circle cx="18.5" cy="18.5" r="2.5"></circle>
                            </svg> <?php echo $orderbooks['details']['tracking_id']; ?>
                             </a>  
                        </h5>   
                    </li>
                </ul>
           </div>
            
    <!-- Trigger Modal -->
    <div class="container mt-5">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#shippingLabelModal">
                <b>Generate Shipping Label</b>
            </button>
        </div>
        <!-- Modal Structure -->
        <div class="modal fade" id="shippingLabelModal" tabindex="-1" role="dialog" aria-labelledby="shippingLabelModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="shippingLabelModalLabel"><b>Shipping Label</b></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><b>&times;</b></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="label-container">
                            <div class="row">
                                <div class="col">
                                    <div class="label-header">
										<img src="<?php echo base_url().'assets/img/pustaka-logo-black.jpeg' ?>" alt="Logo" height="25px" width="140px">
                                    </div>
                                </div>
							    <div class="col">
									<div class="barcode">
                                        <canvas id="barcodeCanvas" style="border: 1px solid #000; height: 55px; width: 125px"></canvas>
                                    </div>
                                </div>
                            </div>
                            <h6><strong id="orderNumber" style="display: none;"><b><?php echo $order_id ?></b></strong></h6>
							<font color="black"><b>Shipping Address:</b></font>
                            <table class="table table-bordered" style="border: 2px solid black; width: 100%; text-align: left; border-collapse: collapse;">
								<thead>
									<tr>
										<td style="border: 1px solid black; padding: 8px;"><b>
											<?php echo trim(htmlspecialchars($orderbooks['details']['shipping_name'])); ?><br>
											<?php echo trim(htmlspecialchars($orderbooks['details']['shipping_address1'])); ?>, <?php echo trim(htmlspecialchars($orderbooks['details']['shipping_address2'])); ?>, <?php echo trim(htmlspecialchars($orderbooks['details']['shipping_area_name'])); ?><br>
											Landmark: <?php echo trim(htmlspecialchars($orderbooks['details']['shipping_landmark'])); ?><br>
											<?php echo trim(htmlspecialchars($orderbooks['details']['shipping_city'])); ?> - <?php echo trim(htmlspecialchars($orderbooks['details']['shipping_pincode'])); ?><br>
											Phone: <?php echo trim(htmlspecialchars($orderbooks['details']['shipping_mobile_no'])); ?></b>
										</td>
									</tr>
								</thead>
							</table>
							
                            <!--<div class="details mt-4">-->
                                <table class="table table-bordered" style="border: 1px solid black; width: 100%; text-align: left; border-collapse: collapse;">
                                    <thead>
                                        <tr>
                                            <td style="border: 1px solid black; padding: 8px;"><b>Titles: <?php echo $numberOfTitles ?></b></td>
                                            <td style="border: 1px solid black; padding: 8px;"><b>Books: <?php echo $totalBooks ?></b></td>
                                            <td style="border: 1px solid black; padding: 8px;"><b>ONL</b></td>
                                        </tr>
                                    </thead>
                                </table>
                            <!--</div>-->

                            <font color="black"><b>From: Pustaka Digital Media Pvt. Ltd.,<br>
                                “Sri Illam”, 35, Roja 2nd Street, PWDO Colony<br>
                                Seelapadi, Dindigul - 624 005<br>
                                TamilNadu, Mobile: +91 99803 87852</b></font>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal"><b>Close</b></button>
                        <button type="button" class="btn btn-danger" id="downloadPdfBtn"><b>Download PDF</b></button>
                    </div>
                </div>
            </div>
        </div>


           <br><br>

        <div class="card-deck">
                <div class="card bg-warning" style="width: 18rem;">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <h5>Shipping Address:</h5>
                        </li>
                        <li class="list-group-item">
                            <h5>Name: <?php echo $orderbooks['details']['shipping_name']; ?></h5>
                            <h5>Address: <?php echo $orderbooks['details']['shipping_address1']; ?></h5>
                            <h5><?php echo $orderbooks['details']['shipping_address2']; ?></h5>
                            <h5><?php echo $orderbooks['details']['shipping_area_name']; ?></h5>
                            <h5>City: <?php echo $orderbooks['details']['shipping_city']; ?></h5>
                            <h5>Landmark: <?php  echo $orderbooks['details']['shipping_landmark']; ?></h5>
                            <h5>State: <?php echo $orderbooks['details']['shipping_state']; ?></h5>
                            <h5>Pincode: <?php echo $orderbooks['details']['shipping_pincode']; ?></h5>
                            <h5>Phone: <?php echo $orderbooks['details']['shipping_mobile_no']; ?></h5>
                            <h5>Alt Phone: <?php echo $orderbooks['details']['shipping_alternate_no']; ?></h5>
                        </li>
                    </ul>
                </div>
                <div class="card bg-warning" style="width: 18rem;">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <h5>Billing Address:
                        </li>
                        <li class="list-group-item">
                            <h5>Name: <?php echo $orderbooks['details']['billing_name']; ?></h5>
                            <h5>Address: <?php echo $orderbooks['details']['billing_address1']; ?></h5>
                            <h5><?php echo $orderbooks['details']['billing_address2']; ?></h5>
                            <h5><?php echo $orderbooks['details']['billing_area_name']; ?></h5>
                            <h5>City: <?php echo $orderbooks['details']['billing_city']; ?></h5>
                            <h5>Landmark: <?php echo $orderbooks['details']['billing_landmark']; ?></h5>
                            <h5>State: <?php echo $orderbooks['details']['billing_state']; ?></h5>
                            <h5>Pincode: <?php echo $orderbooks['details']['billing_pincode']; ?></h5>
                            <h5>Phone: <?php echo $orderbooks['details']['billing_mobile_no']; ?></h5>
                            <h5>Alt Phone: </h5>
                        </li>
                    </ul>
                </div>
            </div>
        <br>
        <br>
        <br>
        <table class="zero-config table table-hover mt-4">
            <thead>
                <center><h4>List of Books</h4></center>
                <tr>
                    <th style="border: 1px solid grey">S.No</th> 
                    <th style="border: 1px solid grey">BookId</th>
                    <th style="border: 1px solid grey">Title</th>
                    <th style="border: 1px solid grey">Author</th>
                    <th style="border: 1px solid grey">quantity</th>
                    <th style="border: 1px solid grey">Book Price</th>
                    <th style="border: 1px solid grey">Discount %</th>
                    <th style="border: 1px solid grey">Price </th>
                    <th style="border: 1px solid grey">Stock state</th>
                    <th style="border: 1px solid grey">Status </th>
                </tr>
            </thead>
            <tbody style="font-weight: 800;">
                <?php
                    $totalValue = 0;
                    $i = 1;
                    foreach ($orderbooks['list'] as $books_details) {
                        $price = $books_details['price'] * $books_details['quantity'];
                        $totalValue += $price;
                        ?>
                    <tr>
                        <td style="border: 1px solid grey"><?php echo $i++; ?></td>
                        <td style="border: 1px solid grey"><?php echo $books_details['book_id'] ?></td>
                        <td style="border: 1px solid grey"><?php echo $books_details['book_title'] ?></td>
                        <td style="border: 1px solid grey"><?php echo $books_details['author_name'] ?></td>
                        <td style="border: 1px solid grey"><?php echo $books_details['quantity'] ?></td>
                        <td style="border: 1px solid grey"><?php echo $books_details['paper_back_inr'] ?></td>
                        <td style="border: 1px solid grey"><?php echo $books_details['discount'] ?></td>
                        <td style="border: 1px solid grey"><?php echo  $price ?></td>
                        <?php
                        $stockStatus = $books_details['quantity'] <= $books_details['total_quantity'] ? 'IN STOCK' : 'OUT OF STOCK';
                        ?>
                        <td style="border: 1px solid grey"><?php echo $stockStatus ?></td>
                        <td style="border: 1px solid grey"><?php if($books_details['status']==0){
                                echo "In Progress";
                            }else if($books_details['status']==1){
                                echo "Shipped";
                            }else if($books_details['status']==2){
                            echo "Cancle";
                            }else{
                            echo "";
                            } ?>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="7" style="text-align: right; border: 1px solid grey; font-weight: bold; ">Books Total</td>
                    <td colspan="1" style="border: 1px solid grey; font-weight: bold;"><?php echo number_format($totalValue, 2) ?></td>
                </tr>
                <tr>
                    <td colspan="7" style="text-align: right; border: 1px solid grey; font-weight: bold; color: blue;">
                        Total amount <br> 
                        <span style="color: black;">( Books amount +  Shipping charge )</span>
                    </td>
                    <td colspan="1" style="border: 1px solid grey; font-weight: bold; color:blue;"><?php echo $totalValue  ." + ". $orderbooks['details']['shipping_charges'] ." = ". number_format($totalValue + $orderbooks['details']['shipping_charges']  , 2) ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>              

<script>
 document.addEventListener('DOMContentLoaded', function () {
    $('#shippingLabelModal').on('shown.bs.modal', function () {
    const orderNumber = document.getElementById('orderNumber').innerText;
    JsBarcode("#barcodeCanvas", orderNumber, {
        format: "CODE128", // Barcode format
        lineColor: "#000", // Black lines
        width: 2,         // Line width
        height: 50,       // Barcode height
        displayValue: true // Show the order number below the barcode
    });
    });
    });
    // Download PDF with custom size
    document.getElementById('downloadPdfBtn').addEventListener('click', () => {
    const element = document.querySelector('.label-container');
    const orderNumber = document.getElementById('orderNumber').innerText.trim(); // Get the order number and trim any whitespace
    const options = {
        margin: 0,
        filename: `${orderNumber || 'shipping_label'}.pdf`, // Use the order number as the file name, fallback to 'shipping_label'
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: {
            unit: 'mm',
            format: [90, 140],
            orientation: 'portrait'
        }
    };
    html2pdf().set(options).from(element).save();
});
</script>
<?= $this->endSection(); ?>
