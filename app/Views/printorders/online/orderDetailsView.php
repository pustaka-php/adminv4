<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?> 

<?php
$numberOfTitles = count($orderbooks['list']); 
$totalBooks = 0;
foreach ($orderbooks['list'] as $books_details) {
    $totalBooks += $books_details['quantity'];
}
?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
    <!-- Order Info Card -->
        <div class="d-flex justify-content-center">
            <div class="card h-100 radius-2 bg-gradient-success mb-4" style="width: 50%;">
                <div class="card-body p-24 text-start">
                    <ul class="list-group-item">
                        <li class="list-group-item">
                            <h5 class="text-center">Order ID: <?= $order_id ?></h5>
                        </li>
                        <li class="list-group-item">
                            <h5 class="text-center">Online Customer Details</h5>
                        </li><br>
                        <li class="list-group-item">
                            <h6>User Id: <?php echo $orderbooks['details']['user_id']; ?></h6>
                            <h6>User Name: <?php echo $orderbooks['details']['username']; ?></h6>  
                        </li>
                        <li class="list-group-item">
                            <h6 style="font-weight: bold;">
                                Courier Charges: <?php echo number_format($orderbooks['details']['shipping_charges'], 2); ?> 
                            </h6>
                            <h6>Order Date: <?php echo date('d-m-Y', strtotime($orderbooks['details']['order_date'])) ?></h6>
                            <h6>Shipped Date:
                                <?php
                                if ($orderbooks['details']['ship_date'] == NULL) {
                                    echo '';
                                } else {
                                    echo date('d-m-Y', strtotime($orderbooks['details']['ship_date']));
                                }
                                ?> 
                            </h6>      
                            <h6>
                                <a href="<?php echo $orderbooks['details']['tracking_url']; ?>" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck">
                                        <rect x="1" y="3" width="15" height="13"></rect>
                                        <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                        <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                        <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                    </svg> <?php echo $orderbooks['details']['tracking_id']; ?>
                                </a>  
                            </h6>   
                        </li>
                    </ul>
                </div>
            </div>
        </div>
     
        <!-- Trigger Modal -->
        <div class="container mt-5">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#shippingLabelModal">
                <b>Generate Shipping Label</b>
            </button>
        </div>

        <!-- Modal Structure -->
        <div class="modal fade" id="shippingLabelModal" tabindex="-1" role="dialog" aria-labelledby="shippingLabelModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="shippingLabelModalLabel"><b>Shipping Label</b></h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
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
                            <table class="table table-bordered" style="border: 1px solid black; width: 100%; text-align: left; border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        <td style="border: 1px solid black; padding: 8px;"><b>Titles: <?php echo $numberOfTitles ?></b></td>
                                        <td style="border: 1px solid black; padding: 8px;"><b>Books: <?php echo $totalBooks ?></b></td>
                                        <td style="border: 1px solid black; padding: 8px;"><b>ONL</b></td>
                                    </tr>
                                </thead>
                            </table>
                            <font color="black"><b>From: Pustaka Digital Media Pvt. Ltd.,<br>
                                “Sri Illam”, 35, Roja 2nd Street, PWDO Colony<br>
                                Seelapadi, Dindigul - 624 005<br>
                                TamilNadu, Mobile: +91 99803 87852</b></font>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal"><b>Close</b></button>
                        <button type="button" class="btn btn-danger" id="downloadPdfBtn"><b>Download PDF</b></button>
                    </div>
                </div>
            </div>
        </div>
        <br><br>
        <!-- Shipping and Billing Address Side-by-Side -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="card h-100 radius-12 bg-gradient-purple" style="border-radius: 6px; padding: 10px;">
                    <div class="card-body p-2" style="font-size: 0.9rem;">
                        <h6 class="text-center">Shipping Address</h6>
                        <p class="mb-1"><strong>Name:</strong> <?= $orderbooks['details']['shipping_name']; ?></p>
                        <p class="mb-1"><strong>Address:</strong> <?= $orderbooks['details']['shipping_address1']; ?></p>
                        <p class="mb-1"><?= $orderbooks['details']['shipping_address2']; ?></p>
                        <p class="mb-1"><?= $orderbooks['details']['shipping_area_name']; ?></p>
                        <p class="mb-1"><strong>City:</strong> <?= $orderbooks['details']['shipping_city']; ?></p>
                        <p class="mb-1"><strong>Landmark:</strong> <?= $orderbooks['details']['shipping_landmark']; ?></p>
                        <p class="mb-1"><strong>State:</strong> <?= $orderbooks['details']['shipping_state']; ?></p>
                        <p class="mb-1"><strong>Pincode:</strong> <?= $orderbooks['details']['shipping_pincode']; ?></p>
                        <p class="mb-1"><strong>Phone:</strong> <?= $orderbooks['details']['shipping_mobile_no']; ?></p>
                        <p class="mb-0"><strong>Alt Phone:</strong> <?= $orderbooks['details']['shipping_alternate_no']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card h-100 radius-12 bg-gradient-primary" style="border-radius: 6px; padding: 10px;">
                    <div class="card-body p-2" style="font-size: 0.9rem;">
                        <h6 class="text-center">Billing Address</h6>
                        <p class="mb-1"><strong>Name:</strong> <?= $orderbooks['details']['billing_name']; ?></p>
                        <p class="mb-1"><strong>Address:</strong> <?= $orderbooks['details']['billing_address1']; ?></p>
                        <p class="mb-1"><?= $orderbooks['details']['billing_address2']; ?></p>
                        <p class="mb-1"><?= $orderbooks['details']['billing_area_name']; ?></p>
                        <p class="mb-1"><strong>City:</strong> <?= $orderbooks['details']['billing_city']; ?></p>
                        <p class="mb-1"><strong>Landmark:</strong> <?= $orderbooks['details']['billing_landmark']; ?></p>
                        <p class="mb-1"><strong>State:</strong> <?= $orderbooks['details']['billing_state']; ?></p>
                        <p class="mb-1"><strong>Pincode:</strong> <?= $orderbooks['details']['billing_pincode']; ?></p>
                        <p class="mb-1"><strong>Phone:</strong> <?= $orderbooks['details']['billing_mobile_no']; ?></p>
                        <p class="mb-0"><strong>Alt Phone:</strong></p>
                    </div>
                </div>
            </div>
        </div>


        <br><br><br>

        <!-- Book List Table -->
        <table class="zero-config table table-hover mt-4">
            <thead>
                <h6 class="text-center">List of Books</h6><br>
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
                        <span>( Books amount +  Shipping charge )</span>
                    </td>
                    <td colspan="1" style="border: 1px solid grey; font-weight: bold; color:blue;"><?php echo $totalValue  ." + ". $orderbooks['details']['shipping_charges'] ." = ". number_format($totalValue + $orderbooks['details']['shipping_charges']  , 2) ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>              
<!-- Libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
document.getElementById("downloadPdfBtn").addEventListener("click", function () {
    const { jsPDF } = window.jspdf;
    let container = document.querySelector(".label-container");

    html2canvas(container, { scale: 2 }).then(canvas => {
        const imgData = canvas.toDataURL("image/png");
        const pdf = new jsPDF("p", "mm", "a4");

        let pageWidth = pdf.internal.pageSize.getWidth();
        let pageHeight = pdf.internal.pageSize.getHeight();

        // Bigger size — only slight downscale
        let imgWidth = canvas.width * 0.4; // bigger scale factor
        let imgHeight = canvas.height * 0.4;

        // Convert from px to mm (1px = 0.264583mm)
        imgWidth = imgWidth * 0.264583;
        imgHeight = imgHeight * 0.264583;

        // Keep centered
        let x = (pageWidth - imgWidth) / 2;
        let y = (pageHeight - imgHeight) / 2;

        pdf.addImage(imgData, "PNG", x, y, imgWidth, imgHeight);
        pdf.save("shipping-label.pdf");
    });
});
</script>
<?= $this->endSection(); ?>
