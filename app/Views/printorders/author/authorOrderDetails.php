<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 
<?php
$numberOfTitles = count($orderbooks['books']); 
$totalBooks = 0;

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

                <div class="mb-12 text-start"><strong>Order Id:</strong> <?= $orderbooks['order']['order_id']; ?></div>
                <div class="mb-12 text-start"><strong>Author Name:</strong> <?= $orderbooks['order']['author_name']; ?></div>
                <div class="mb-12 text-start"><strong>Invoice Number:</strong> <?= $orderbooks['order']['invoice_number']; ?></div>
                <div class="mb-12 text-start"><strong>Sub Total:</strong> ₹<?= $orderbooks['order']['sub_total']; ?></div>
                <div class="mb-12 text-start"><strong>Shipping Charge:</strong> ₹<?= $orderbooks['order']['shipping_charges']; ?></div>
                <div class="mb-12 text-start"><strong>Final Invoice:</strong> ₹<?= $orderbooks['order']['net_total']; ?></div>
                <div class="mb-12 text-start">
                    <strong>Tracking:</strong> <?= $orderbooks['order']['tracking_url']; ?><br>
                    <span class="text-secondary">ID: <?= $orderbooks['order']['tracking_id']; ?></span>
                </div>
            </div>
        </div>
        <div class="container mt-5 text-center">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#shippingLabelModal">
                <b>Generate Shipping Label</b>
            </button>
        </div>
        <br>

        <!-- Modal -->
        <div class="modal fade" id="shippingLabelModal" tabindex="-1" aria-labelledby="shippingLabelModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="shippingLabelModalLabel"><b>Shipping Label</b></h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <!-- PDF Content -->
                        <div id="pdfContent" style="width: 200mm; min-height: 160mm; padding: 10mm; background: #fff; border: 2px solid #000; box-sizing: border-box; font-size: 25px;">
                            
                            <!-- Header Section -->
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                                <div>
                                    <img src="<?= base_url().'assets/images/pustaka-logo-90x90.jpeg' ?>" alt="Pustaka Logo" style="height:25px; width:140px; display: block;">
                                </div>
                                <div style="text-align: right;">
                                    <canvas id="barcodeCanvas" width="125" height="55" style="border:1px solid #000;"></canvas>
                                </div>
                            </div>

                            <!-- Hidden Order Number -->
                            <div style="display: none;">
                                <strong id="OrderNumber"><?= $orderbooks['order']['order_id']; ?></strong>
                            </div>

                            <!-- Shipping Address -->
                            <div style="margin-bottom: 15px;">
                                <div style="font-weight: bold; margin-bottom: 8px;">Shipping Address:</div>
                                <div style="border: 2px solid #000; padding: 10px;">
                                    <div style="font-weight: bold;">
                                        <?= trim(htmlspecialchars($orderbooks['order']['ship_name'])); ?><br>
                                        <?= trim(htmlspecialchars($orderbooks['order']['ship_address'])); ?><br>
                                        Phone: <?= trim(htmlspecialchars($orderbooks['order']['ship_mobile'])); ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Summary Table -->
                            <div style="margin-bottom: 15px;">
                                <table style="width: 100%; border-collapse: collapse; border: 1px solid #000; font-weight: bold;">
                                    <tr>
                                        <td style="border: 1px solid #000; padding: 10px; text-align: center;">Titles: <?= $numberOfTitles ?></td>
                                        <td style="border: 1px solid #000; padding: 10px; text-align: center;">Books: <?= $totalBooks ?></td>
                                        <td style="border: 1px solid #000; padding: 10px; text-align: center;">Type: AUH</td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Sender Address -->
                            <div style="margin-top: 20px;">
                                <div style="font-weight: bold;">
                                    From: Pustaka Digital Media Pvt. Ltd.,<br>
                                    "Sri Illam", 35, Roja 2nd Street, PWDO Colony<br>
                                    Seelapadi, Dindigul - 624 005<br>
                                    TamilNadu, Mobile: +91 99803 87852
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal"><b>Close</b></button>
                        <button type="button" class="btn btn-danger" id="downloadPdfBtn"><b>Download PDF</b></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Remaining address cards and table -->
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card h-100 radius-12 bg-gradient-success text-center">
                        <div class="card-body p-24">
                            <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-primary-600 text-white mb-16 radius-12">
                                <iconify-icon icon="ri:map-pin-user-fill" class="h5 mb-0"></iconify-icon>
                            </div>
                            <h6 class="mb-16">Shipping Address</h6>
                            <div class="text-start d-inline-block">
                                <p class="mb-2"><strong>Name:</strong> <?= $orderbooks['order']['ship_name']; ?></p>
                                <p class="mb-2"><strong>Address:</strong> <?= $orderbooks['order']['ship_address']; ?></p>
                                <p class="mb-2"><strong>Phone:</strong> <?= $orderbooks['order']['ship_mobile']; ?></p>
                                <p class="mb-0"><strong>Email:</strong> <?= $orderbooks['order']['ship_email']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card h-100 radius-12 bg-gradient-purple text-center">
                        <div class="card-body p-24">
                            <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-primary-600 text-white mb-16 radius-12">
                                <iconify-icon icon="ri:bank-card-fill" class="h5 mb-0"></iconify-icon>
                            </div>
                            <h6 class="mb-16">Billing Address</h6>
                            <div class="text-start d-inline-block">
                                <p class="mb-2"><strong>Name:</strong> <?= $orderbooks['order']['billing_name']; ?></p>
                                <p class="mb-2"><strong>Address:</strong> <?= $orderbooks['order']['billing_address']; ?></p>
                                <p class="mb-2"><strong>Phone:</strong> <?= $orderbooks['order']['bill_mobile']; ?></p>
                                <p class="mb-0"><strong>Email:</strong> <?= $orderbooks['order']['bill_email']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <table class="zero-config table table-hover mt-4">
                <thead>
                    <tr>
                        <th>S.NO</th>
                        <th>Delivery Date</th>
                        <th>Book ID</th>
                        <th>Title</th>
                        <th>Book Cost</th>
                        <th>Copies</th>
                        <th>Discount</th>
                        <th>Final Price</th>
                    </tr>
                </thead>
                <tbody style="font-weight: normal;">
                    <?php $i=1; foreach($orderbooks['books'] as $book){ ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= date('d-m-Y',strtotime($book['ship_date'])) ?></td>
                        <td><?= $book['book_id']; ?></td>
                        <td><?= $book['book_title']; ?></td>
                        <td><?= $book['paper_back_inr']; ?></td>
                        <td><?= $book['quantity']; ?></td>
                        <td><?= $book['dis'].'%'; ?></td>
                        <td><?='₹'.$book['price']; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <br><br>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Generate barcode when modal opens
    const shippingModal = document.getElementById('shippingLabelModal');
    shippingModal.addEventListener('show.bs.modal', function() {
        const orderNumber = document.getElementById('OrderNumber').innerText.trim();
        
        // Clear and generate barcode
        const canvas = document.getElementById('barcodeCanvas');
        const ctx = canvas.getContext('2d');
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        JsBarcode("#barcodeCanvas", orderNumber, {
            format: "CODE128",
            lineColor: "#000000",
            width: 2,
            height: 40,
            displayValue: true,
            fontSize: 14,
            background: "#ffffff",
            margin: 8
        });
    });

    // Download PDF
    document.getElementById('downloadPdfBtn').addEventListener('click', function() {
        const element = document.getElementById('pdfContent');
        const orderNumber = document.getElementById('OrderNumber').innerText.trim();

        // Show loading
        const originalText = this.innerHTML;
        this.innerHTML = '<b>Generating PDF...</b>';
        this.disabled = true;

        const options = {
            margin: [5, 5, 5, 5], // Small margin to ensure borders are visible
            filename: 'shipping_label_' + orderNumber + '.pdf',
            image: { 
                type: 'jpeg', 
                quality: 1.0 
            },
            html2canvas: { 
                scale: 1,
                useCORS: true,
                logging: false,
                backgroundColor: '#FFFFFF',
                scrollX: 0,
                scrollY: 0,
                width: element.scrollWidth,
                height: element.scrollHeight
            },
            jsPDF: { 
                unit: 'mm', 
                format: [280, 240], // Slightly larger to accommodate content
                orientation: 'portrait'
            }
        };

        html2pdf().set(options).from(element).save().then(() => {
            this.innerHTML = originalText;
            this.disabled = false;
        }).catch(error => {
            console.error('PDF generation failed:', error);
            this.innerHTML = originalText;
            this.disabled = false;
        });
    });
});
</script>
<?= $this->endSection(); ?>
