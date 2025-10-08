<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 
<?php
$numberOfTitles = count($orderbooks['list']);
$totalBooks = 0;
foreach ($orderbooks['list'] as $books_details) {
    $totalBooks += $books_details['quantity'];
}
?>

<div class="card h-100 radius-12 bg-gradient-purple" style="max-width: 600px; margin: 0 auto;">
    <div class="card-body p-24">

        <!-- Icon + Titles in one row -->
        <div class="d-flex align-items-center gap-3 mb-16">
            <!-- Icon -->
            <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-lilac-600 text-white radius-12">
                <iconify-icon icon="mdi:package-variant-closed" width="32" height="32"></iconify-icon>
            </div>

            <!-- Titles -->
            <div>
                <h6 class="mb-1">Order ID: <?php echo $order_id ?></h6>
                <h6 class="mb-0">Customer Details</h6>
            </div>
        </div>
        <!-- Customer Information -->
        <p class="card-text mb-8 text-secondary-light">
            <strong>Name:</strong> <?php echo $orderbooks['details']['customer_name']; ?><br>
            <strong>Mobile No:</strong> <?php echo $orderbooks['details']['mobile_no']; ?><br>
            <strong>Address:</strong><br><?php echo $orderbooks['details']['address']; ?><br>
            <strong>City:</strong> <?php echo $orderbooks['details']['city']; ?>
        </p>

        <!-- Courier and Dates -->
        <p class="card-text mb-8">
            <span style="font-weight:bold;">Courier Charges: 
                <?php echo number_format($orderbooks['details']['courier_charges'], 2); ?>
            </span><br>
            Order Date:
            <?php
                if ($orderbooks['details']['order_date'] == NULL) {
                    echo '';
                } else {
                    echo date('d-m-Y', strtotime($orderbooks['details']['order_date']));
                }
            ?><br>
            Ship Date: <?php echo date('d-m-Y', strtotime($orderbooks['details']['ship_date'])); ?>
        </p>

        <!-- Tracking Link -->
        <a href="<?php echo $orderbooks['details']['tracking_url']; ?>" target="_blank" 
           class="btn text-lilac-600 hover-text-lilac px-0 py-0 mt-16 d-inline-flex align-items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                 viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                 class="feather feather-truck">
                <rect x="1" y="3" width="15" height="13"></rect>
                <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                <circle cx="5.5" cy="18.5" r="2.5"></circle>
                <circle cx="18.5" cy="18.5" r="2.5"></circle>
            </svg> 
            <?php echo $orderbooks['details']['tracking_id']; ?>
        </a>

    </div>
</div>
<br>
<div class="container mt-5">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#shippingLabelModal">
        <b>Generate Shipping Label</b>
    </button>
</div>

<!-- Modal Structure -->
<div class="modal fade" id="shippingLabelModal" tabindex="-1" aria-labelledby="shippingLabelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="shippingLabelModalLabel"><b>Shipping Label</b></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="label-container" style="width:160mm; min-height:110mm; padding:5mm; background:#fff; font-family: Arial, sans-serif; border:2px solid #000; box-sizing:border-box;">
                    <div class="row">
                        <div class="col">
                            <div class="label-header">
                                <img src="<?php echo base_url().'assets/images/pustaka-logo-90x90.jpeg' ?>" alt="Logo" height="25" width="140">
                            </div>
                        </div>
                        <div class="col">
                            <div class="barcode">
                                <canvas id="barcodeCanvas" style="border: 1px solid #000; height: 55px; width: 125px"></canvas>
                            </div>
                        </div>
                    </div>
                    <h6><strong id="orderNumber" style="display: none;"><b><?php echo $order_id ?></b></strong></h6>
                    <p><b>Shipping Address:</b></p>
                    <table class="table table-bordered border-dark" style="width: 100%; text-align: left;">
                        <tr>
                            <td style="padding: 8px;">
                                <b>
                                    <?php echo trim(htmlspecialchars($orderbooks['details']['customer_name'])); ?><br>
                                    <?php echo trim(htmlspecialchars($orderbooks['details']['address'])); ?><br>
                                    <?php echo trim(htmlspecialchars($orderbooks['details']['city'])); ?><br>
                                    Phone: <?php echo trim(htmlspecialchars($orderbooks['details']['mobile_no'])); ?>
                                </b>
                            </td>
                        </tr>
                    </table>
                    <table class="table table-bordered border-dark" style="width: 100%; text-align: left;">
                        <tr>
                            <td><b>Titles: <?php echo $numberOfTitles ?></b></td>
                            <td><b>Books: <?php echo $totalBooks ?></b></td>
                            <td><b>Type: OFL</b></td>
                        </tr>
                    </table>
                    <p>
                        <b>
                            From: Pustaka Digital Media Pvt. Ltd.,<br>
                            “Sri Illam”, 35, Roja 2nd Street, PWDO Colony<br>
                            Seelapadi, Dindigul - 624 005<br>
                            TamilNadu, Mobile: +91 99803 87852
                        </b>
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal"><b>Close</b></button>
                <button type="button" class="btn btn-danger" id="downloadPdfBtn"><b>Download PDF</b></button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts for Bootstrap 5 and Libraries -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>

<br><br>
<table class="zero-config table table-hover table-bordered border-dark mt-4"> 
    <thead>
    <h6 class="text-center">List of Books</h6><br>
    <tr>
        <th>S.No</th> 
        <th>BookId</th>  
        <th>Title</th>
        <th>PaperBack ISBN</th>
        <th>Author</th>
        <th>quantity</th>
        <th>Book Price</th>
        <th>Discount %</th>
        <th>Final amount</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody style="font-weight: normal;">
        <?php
            $totalValue = 0;
            $i = 1;
            foreach ($orderbooks['list'] as $books_details) {
                $totalValue += $books_details['total_amount'];

                $original_isbn = $books_details['paper_back_isbn'];
                $formatted_isbn = str_replace('-', '', $original_isbn);

        ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $books_details['book_id'] ?></td>
                <td>
                        <?php echo $books_details['book_title'] ?><br>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-copy" onclick="copyToClipboard(this, '<?php echo addslashes($books_details['book_title']); ?>')">
                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                        </svg>
                </td>
                <td>
                    <?php echo $formatted_isbn ?><br>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-copy" style="color: #000;" onclick="copyToClipboard(this, '<?php echo $formatted_isbn; ?>')">
                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                    </svg>
                </td>

                <td><?php echo $books_details['author_name'] ?></td>
                <td><?php echo $books_details['quantity'] ?></td>
                <td><?php echo $books_details['paper_back_inr'] ?></td>
                <td><?php echo $books_details['discount']?></td>
                <td><?php echo $books_details['total_amount'] ?></td>
                <td><?php if($books_details['ship_status']==0){
                        echo "In Progress";
                    }else if($books_details['ship_status']==1){
                        echo "Shipped";
                    }else if($books_details['ship_status']==2){
                    echo "Cancle";
                    }else if($books_details['ship_status']==3){
                    echo "Return";
                    }else{
                    echo "";
                    } ?>
                </td>
                </tr>
            <?php
            }?>
            <tr>
            <td colspan="8" style="text-align: right;font-weight: bold;">Books Total</td>
            <td colspan="2" style="font-weight: bold;"><?php echo number_format($totalValue, 2) ?></td>
        </tr>
        <tr>
            <td colspan="8" style="color: blue;">
                Total amount <br> 
                <span>( Books amount +  Shipping charge  )</span>
            </td>
            <td colspan="2" style="color:blue;"><?php echo  $totalValue  ." + ". $orderbooks['details']['courier_charges'] ." = ". number_format($totalValue + $orderbooks['details']['courier_charges']  , 2) ?></td>
        </tr>
    </tbody>
</table>
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
