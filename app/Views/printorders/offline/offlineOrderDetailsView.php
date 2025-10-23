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

        <!-- Icon + Titles -->
        <div class="d-flex align-items-center gap-3 mb-16">
            <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-lilac-600 text-white radius-12">
                <iconify-icon icon="mdi:package-variant-closed" width="32" height="32"></iconify-icon>
            </div>

            <div>
                <h6 class="mb-1">Order ID: <?= esc($order_id) ?></h6>
                <h6 class="mb-0">Customer Details</h6>
            </div>
        </div>

        <!-- Customer Information -->
        <p class="card-text mb-8 text-secondary-light">
            <strong>Name:</strong> <?= esc($orderbooks['details']['customer_name']) ?><br>
            <strong>Mobile No:</strong> <?= esc($orderbooks['details']['mobile_no']) ?><br>
            <strong>Address:</strong><br><?= esc($orderbooks['details']['address']) ?><br>
            <strong>City:</strong> <?= esc($orderbooks['details']['city']) ?>
        </p>

        <!-- Courier and Dates -->
        <p class="card-text mb-8">
            <span style="font-weight:bold;">Courier Charges: 
                <?= number_format($orderbooks['details']['courier_charges'], 2) ?>
            </span><br>
            Order Date:
            <?php
                if ($orderbooks['details']['order_date']) {
                    echo date('d-m-Y', strtotime($orderbooks['details']['order_date']));
                }
            ?><br>
            Ship Date: <?= $orderbooks['details']['ship_date'] ? date('d-m-Y', strtotime($orderbooks['details']['ship_date'])) : '' ?>
        </p>

        <!-- Tracking Link -->
        <a href="<?= esc($orderbooks['details']['tracking_url']) ?>" target="_blank" 
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
            <?= esc($orderbooks['details']['tracking_id']) ?>
        </a>

    </div>
</div>

<br>

<div class="container mt-5 text-center">
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
                <div class="label-container"style="width:160mm; min-height:110mm; padding:10mm; background:#fff; border:2px solid #000; box-sizing:border-box; font-size:14px;">
                    <div class="row">
                        <div class="col">
                            <div class="label-header">
                                <img src="<?= base_url('assets/images/pustaka-logo-90x90.jpeg') ?>" alt="Logo" height="25" width="140">
                            </div>
                        </div>
                        <div class="col text-end">
                            <canvas id="barcodeCanvas" style="border: 1px solid #000; height: 55px; width: 125px"></canvas>
                        </div>
                    </div>

                    <h6><strong id="orderNumber" style="display:none;"><b><?= esc($order_id) ?></b></strong></h6>

                    <p><b>Shipping Address:</b></p>
                    <table class="table table-bordered border-dark" style="width: 100%; text-align: left;">
                        <tr>
                            <td style="padding: 8px;">
                                <b>
                                    <?= esc($orderbooks['details']['customer_name']) ?><br>
                                    <?= esc($orderbooks['details']['address']) ?><br>
                                    <?= esc($orderbooks['details']['city']) ?><br>
                                    Phone: <?= esc($orderbooks['details']['mobile_no']) ?>
                                </b>
                            </td>
                        </tr>
                    </table>

                    <table class="table table-bordered border-dark" style="width: 100%; text-align: left;">
                        <tr>
                            <td><b>Titles: <?= $numberOfTitles ?></b></td>
                            <td><b>Books: <?= $totalBooks ?></b></td>
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

<br><br>

<!-- Book List Table -->
<table class="zero-config table table-hover table-bordered border-dark mt-4"> 
    <thead>
        <h6 class="text-center">List of Books</h6><br>
        <tr>
            <th>S.No</th> 
            <th>Book ID</th>  
            <th>Title</th>
            <th>PaperBack ISBN</th>
            <th>Author</th>
            <th>Quantity</th>
            <th>Book Price</th>
            <th>Discount %</th>
            <th>Final Amount</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody style="font-weight: normal;">
        <?php
        $totalValue = 0;
        $i = 1;
        foreach ($orderbooks['list'] as $books_details):
            $totalValue += $books_details['total_amount'];
            $formatted_isbn = str_replace('-', '', $books_details['paper_back_isbn']);
        ?>
        <tr>
            <td><?= $i++ ?></td>
            <td><?= esc($books_details['book_id']) ?></td>
            <td><?= esc($books_details['book_title']) ?></td>
            <td><?= esc($formatted_isbn) ?></td>
            <td><?= esc($books_details['author_name']) ?></td>
            <td><?= esc($books_details['quantity']) ?></td>
            <td><?= esc($books_details['paper_back_inr']) ?></td>
            <td><?= esc($books_details['discount']) ?></td>
            <td><?= esc($books_details['total_amount']) ?></td>
            <td>
                <?php
                switch ($books_details['ship_status']) {
                    case 0: echo "In Progress"; break;
                    case 1: echo "Shipped"; break;
                    case 2: echo "Cancelled"; break;
                    case 3: echo "Return"; break;
                    default: echo "";
                }
                ?>
            </td>
        </tr>
        <?php endforeach; ?>

        <tr>
            <td colspan="8" style="text-align: right;font-weight: bold;">Books Total</td>
            <td colspan="2" style="font-weight: bold;"><?= number_format($totalValue, 2) ?></td>
        </tr>
        <tr>
            <td colspan="8" style="color: blue;">
                Total amount <br> 
                <span>( Books amount +  Shipping charge )</span>
            </td>
            <td colspan="2" style="color:blue;">
                <?= number_format($totalValue, 2) . " + " . number_format($orderbooks['details']['courier_charges'], 2) . " = " . number_format($totalValue + $orderbooks['details']['courier_charges'], 2) ?>
            </td>
        </tr>
    </tbody>
</table>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // Generate Barcode when modal is opened
    $('#shippingLabelModal').on('shown.bs.modal', function () {
        const orderNumber = document.getElementById('orderNumber').innerText.trim();
        JsBarcode("#barcodeCanvas", orderNumber, {
            format: "CODE128",
            lineColor: "#000",
            width: 2,
            height: 50,
            displayValue: true
        });
    });

    // Download PDF
    document.getElementById('downloadPdfBtn').addEventListener('click', () => {
        const element = document.querySelector('.label-container');
        const orderNumber = document.getElementById('orderNumber').innerText.trim();

        const options = {
            margin: 0,
            filename: (orderNumber ? orderNumber : 'shipping_label') + '.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: {
                unit: 'mm',
                format: [200, 180],
                orientation: 'portrait'
            }
        };

        html2pdf().set(options).from(element).save();
    });
});
</script>
<?= $this->endSection(); ?>
