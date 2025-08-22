<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 
<?php
$numberOfTitles = count($orderbooks['books']); 
$totalBooks = 0;

$order_id = $orderbooks['order']['order_id'];
foreach ($orderbooks['books'] as $books_details) {
    $totalBooks += $books_details['quantity'];
}
?>

<div id="content" class="main-content">
	<div class="layout-px-spacing">
        <br>
        <div class="card h-100 radius-12 bg-gradient-danger text-center" style="width: 30rem; margin: 0 auto;">
            <div class="card-body p-24">
                <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-danger-600 text-white mb-16 radius-12">
                    <iconify-icon icon="ri:book-2-fill" class="h5 mb-0"></iconify-icon>
                </div>

                <h6 class="mb-16">Author Order Details</h6>

                <!-- Order Info Cards -->
                <div class="mb-12 text-start">
                    <strong>Order Id:</strong> <?php echo $orderbooks['order']['order_id']; ?>
                </div>
                <div class="mb-12 text-start">
                    <strong>Author Name:</strong> <?php echo $orderbooks['order']['author_name']; ?>
                </div>
                <div class="mb-12 text-start">
                    <strong>Invoice Number:</strong> <?php echo $orderbooks['order']['invoice_number']; ?>
                </div>
                <div class="mb-12 text-start">
                    <strong>Sub Total:</strong> ₹<?php echo $orderbooks['order']['sub_total']; ?>
                </div>
                <div class="mb-12 text-start">
                    <strong>Shipping Charge:</strong> ₹<?php echo $orderbooks['order']['shipping_charges']; ?>
                </div>
                <div class="mb-12 text-start">
                    <strong>Final Invoice:</strong> ₹<?php echo $orderbooks['order']['net_total']; ?>
                </div>
                <div class="mb-12 text-start">
                    <strong>Tracking:</strong> 
                    <?php echo $orderbooks['order']['tracking_url']; ?><br>
                    <span class="text-secondary">ID: <?php echo $orderbooks['order']['tracking_id']; ?></span>
                </div>
            </div>
        </div>

        <br><br>
		<br>
        <div class="container mt-5">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#shippingLabelModal">
                <b>Generate Shipping Label</b>
            </button>
        </div>
        <br>
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
											<?php echo trim(htmlspecialchars($orderbooks['order']['ship_name'])); ?><br>
											<?php echo trim(htmlspecialchars($orderbooks['order']['ship_address'])); ?><br>
											Phone: <?php echo trim(htmlspecialchars($orderbooks['order']['ship_mobile'])); ?></b>
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
                                            <td style="border: 1px solid black; padding: 8px;"><b>Type: AUH</b></td>
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

        <br>
        <div class="container">

        <!-- Address Cards Row -->
        <div class="row g-4">

            <!-- Shipping Address Card -->
            <div class="col-md-6">
                <div class="card h-100 radius-12 bg-gradient-success text-center">
                    <div class="card-body p-24">
                        <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-primary-600 text-white mb-16 radius-12">
                            <iconify-icon icon="ri:map-pin-user-fill" class="h5 mb-0"></iconify-icon>
                        </div>
                        <h6 class="mb-16">Shipping Address</h6>
                        
                        <div class="text-start d-inline-block">
                            <p class="mb-2"><strong>Name:</strong> <?php echo $orderbooks['order']['ship_name']; ?></p>
                            <p class="mb-2"><strong>Address:</strong> <?php echo $orderbooks['order']['ship_address']; ?></p>
                            <p class="mb-2"><strong>Phone:</strong> <?php echo $orderbooks['order']['ship_mobile']; ?></p>
                            <p class="mb-0"><strong>Email:</strong> <?php echo $orderbooks['order']['ship_email']; ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Billing Address Card -->
            <div class="col-md-6">
                <div class="card h-100 radius-12 bg-gradient-purple text-center">
                    <div class="card-body p-24">
                        <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-primary-600 text-white mb-16 radius-12">
                            <iconify-icon icon="ri:bank-card-fill" class="h5 mb-0"></iconify-icon>
                        </div>
                        <h6 class="mb-16">Billing Address</h6>
                        
                        <div class="text-start d-inline-block">
                            <p class="mb-2"><strong>Name:</strong> <?php echo $orderbooks['order']['billing_name']; ?></p>
                            <p class="mb-2"><strong>Address:</strong> <?php echo $orderbooks['order']['billing_address']; ?></p>
                            <p class="mb-2"><strong>Phone:</strong> <?php echo $orderbooks['order']['bill_mobile']; ?></p>
                            <p class="mb-0"><strong>Email:</strong> <?php echo $orderbooks['order']['bill_email']; ?></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <br>

        <!-- Books Table -->
        <table class="zero-config table table-hover mt-4">
            <thead>
                <tr>
                    <th style="border: 1px solid grey">S.NO</th>
                    <th style="border: 1px solid grey">Delivery Date</th>
                    <th style="border: 1px solid grey">Book ID</th>
                    <th style="border: 1px solid grey">Title</th>
                    <th style="border: 1px solid grey">Book Cost</th>
                    <th style="border: 1px solid grey">Copies</th>
                    <th style="border: 1px solid grey">Discount</th>
                    <th style="border: 1px solid grey">Final Price</th>
                </tr>
            </thead>
            <tbody style="font-weight: normal;">
                <?php 
                    $i=1;
                    foreach($orderbooks['books'] as $book){
                ?>
                <tr>
                    <td style="border: 1px solid grey"><?php echo $i++; ?></td>
                    <td style="border: 1px solid grey"><?php echo date('d-m-Y',strtotime($book['ship_date'])) ?></td>
                    <td style="border: 1px solid grey"><?php echo $book['book_id']; ?></td>
                    <td style="border: 1px solid grey"><?php echo $book['book_title']; ?></td>
                    <td style="border: 1px solid grey"><?php echo $book['paper_back_inr']; ?></td>
                    <td style="border: 1px solid grey"><?php echo $book['quantity']; ?></td>
                    <td style="border: 1px solid grey"><?php echo $book['dis'].'%'; ?></td>
                    <td style="border: 1px solid grey"><?php echo '₹'.$book['price']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <br><br>
    </div>

</div>
<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            // alert('Copied to clipboard: ' + text);
        }, function(err) {
            // alert('Failed to copy: ', err);
        });
    }
    function copyToClipboard(icon, text) {
        navigator.clipboard.writeText(text);
        var copyText = icon.nextElementSibling;
        icon.style.color = "Blue"; // Change icon color to green
        setTimeout(function() {
            icon.style.color = "#000"; // Reset icon color
        }, 50000); // Reset text after 1 second
    }

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
            format: [100, 160],
            orientation: 'portrait'
        }
    };
    html2pdf().set(options).from(element).save();
});


</script>
<?= $this->endSection(); ?>