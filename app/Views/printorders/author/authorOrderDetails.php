<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>
<!-- <style>
    #pdfContent,
    #pdfContent * {
        font-family: verdana;
        letter-spacing: 1px;
        font-weight: 1000;
    }
</style> -->

<?php
$numberOfTitles = count($orderbooks['books']);
$totalBooks = 0;

foreach ($orderbooks['books'] as $books_details) {
    $totalBooks += $books_details['quantity'];
}
?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <a href="<?= base_url('paperback/authororderbooksstatus'); ?>" 
            class="btn btn-outline-secondary btn-sm float-end">
            ← Back
        </a>
        <br>
        <div class="card h-100 radius-12 bg-gradient-danger text-center" style="width: 30rem; margin: 0 auto;">
            <div class="card-body p-24">
                <div
                    class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-danger-600 text-white mb-16 radius-12">
                    <iconify-icon icon="ri:book-2-fill" class="h5 mb-0"></iconify-icon>
                </div>

                <h6 class="mb-16">Author Order Details</h6>

                <div class="mb-12 text-start"><strong>Order Id:</strong> <?= $orderbooks['order']['order_id']; ?></div>
                <div class="mb-12 text-start"><strong>Author Name:</strong> <?= $orderbooks['order']['author_name']; ?>
                </div>
                <div class="mb-12 text-start"><strong>Invoice Number:</strong>
                    <?= $orderbooks['order']['invoice_number']; ?></div>
                <div class="mb-12 text-start"><strong>Sub Total:</strong> ₹<?= $orderbooks['order']['sub_total']; ?>
                </div>
                <div class="mb-12 text-start"><strong>Shipping Charge:</strong>
                    ₹<?= $orderbooks['order']['shipping_charges']; ?></div>
                <div class="mb-12 text-start"><strong>Payment Status:
                    </strong><?= $orderbooks['order']['payment_status']; ?></div>
                <div class="mb-12 text-start"><strong>Final Invoice:</strong> ₹<?= $orderbooks['order']['net_total']; ?>
                </div>
                <div class="mb-12 text-start">
                    <strong>Tracking:</strong> <?= $orderbooks['order']['tracking_url']; ?><br>
                    <span class="text-secondary">ID: <?= $orderbooks['order']['tracking_id']; ?></span>
                </div>
            </div>
        </div>
        <br><br>
        <div class="d-flex justify-content-center">
            <div class="col-lg-4 col-sm-6">
                <div
                    class="p-16 bg-warning-50 radius-8 border-start-width-3-px border-warning-main border-top-0 border-end-0 border-bottom-0">
                    <h6 class="text-primary-light text-md mb-8">Remarks</h6>
                    <span class="text-warning-main mb-0"><?= $orderbooks['order']['remarks']; ?></span>
                </div>
            </div>
        </div>
        <br>
        <div class="container mt-5 text-center">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#shippingLabelModal">
                <b>Generate Shipping Label</b>
            </button>
        </div>
        <br>

        <!-- Modal -->
        <div class="modal fade" id="shippingLabelModal" tabindex="-1" aria-labelledby="shippingLabelModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="shippingLabelModalLabel"><b>Shipping Label</b></h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <!-- PDF Content -->
                        <div id="pdfContent"
                            style="width: 200mm; min-height: 180mm; padding: 10mm; background: #fff; border: 2px solid #000; box-sizing: border-box; font-size: 22px;">

                            <!-- Header Section -->
                            <!-- <div>
                                <div>
                                    <img src="<?= base_url() . 'assets/images/pustaka-logo-90x90.jpeg' ?>" alt="Logo"
                                        height="25px" width="140px">
                                </div>
                                <div style="text-align: right;">
                                    <canvas id="barcodeCanvas" style="border:1px solid #000;"></canvas>
                                </div>
                            </div> -->
                            <div class="row">
                                <div class="col-8">
                                    <div class="label-header">
                                        <img src="<?= base_url() . 'assets/images/pustaka-logo-90x90.jpeg' ?>"
                                            alt="Logo" height="40px" width="140px">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="barcode">
                                        <canvas id="barcodeCanvas"
                                            style="border: 1px solid #000; height: 40px; width: 140px"></canvas>
                                    </div>
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
                                <table
                                    style="width: 100%; border-collapse: collapse; border: 1px solid #000; font-weight: bold;">
                                    <tr>
                                        <td style="border: 1px solid #000; padding: 10px; text-align: center;">Titles:
                                            <?= $numberOfTitles ?>
                                        </td>
                                        <td style="border: 1px solid #000; padding: 10px; text-align: center;">Books:
                                            <?= $totalBooks ?>
                                        </td>
                                        <td style="border: 1px solid #000; padding: 10px; text-align: center;">Type: AUH
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Sender Address -->
                            <p class="mb-0 mt-1">
                                <b>
                                    From: Pustaka Digital Media Pvt. Ltd.,<br>
                                    "Sri Illam", 35, Roja 2nd Street, PWDO Colony<br>
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
        <!-- Remaining address cards and table -->
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card h-100 radius-12 bg-gradient-success text-center">
                        <div class="card-body p-24">
                            <div
                                class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-primary-600 text-white mb-16 radius-12">
                                <iconify-icon icon="ri:map-pin-user-fill" class="h5 mb-0"></iconify-icon>
                            </div>
                            <h6 class="mb-16">Shipping Address</h6>
                            <div class="text-start d-inline-block">
                                <p class="mb-2"><strong>Name:</strong> <?= $orderbooks['order']['ship_name']; ?></p>
                                <p class="mb-2"><strong>Address:</strong> <?= $orderbooks['order']['ship_address']; ?>
                                </p>
                                <p class="mb-2"><strong>Phone:</strong> <?= $orderbooks['order']['ship_mobile']; ?></p>
                                <p class="mb-0"><strong>Email:</strong> <?= $orderbooks['order']['ship_email']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card h-100 radius-12 bg-gradient-purple text-center">
                        <div class="card-body p-24">
                            <div
                                class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-primary-600 text-white mb-16 radius-12">
                                <iconify-icon icon="ri:bank-card-fill" class="h5 mb-0"></iconify-icon>
                            </div>
                            <h6 class="mb-16">Billing Address</h6>
                            <div class="text-start d-inline-block">
                                <p class="mb-2"><strong>Name:</strong> <?= $orderbooks['order']['billing_name']; ?></p>
                                <p class="mb-2"><strong>Address:</strong>
                                    <?= $orderbooks['order']['billing_address']; ?></p>
                                <p class="mb-2"><strong>Phone:</strong> <?= $orderbooks['order']['bill_mobile']; ?></p>
                                <p class="mb-0"><strong>Email:</strong> <?= $orderbooks['order']['bill_email']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br><br>
            <table class="table table-hover mt-4">
                <thead>
                    <tr>
                        <th>S.NO</th>
                        <th>Created Date</th>
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
                    <?php $i = 1;
                    foreach ($orderbooks['books'] as $book) { ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= date('d-m-Y', strtotime($book['order_date'])) ?></td>
                            <td><?= date('d-m-Y', strtotime($book['ship_date'])) ?></td>
                            <td><?= $book['book_id']; ?></td>
                            <td><?= $book['book_title']; ?></td>
                            <td><?= $book['paper_back_inr']; ?></td>
                            <td><?= $book['quantity']; ?></td>
                            <td><?= $book['dis'] . '%'; ?></td>
                            <td><?= '₹' . $book['price']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <br><br>
        </div>
    </div>
</div>

<!-- Libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {

        // ORDER ID AVAILABLE?
        const orderId = "<?= $orderbooks['order']['order_id']; ?>";

        // Generate Barcode
        if (orderId) {
            JsBarcode("#barcodeCanvas", orderId, {
                format: "CODE128",
                displayValue: true,
                height: 50,
                width: 2
            });
        }

        // PDF DOWNLOAD
        document.getElementById("downloadPdfBtn").addEventListener("click", function () {

            const { jsPDF } = window.jspdf;
            const container = document.getElementById("pdfContent");

            html2canvas(container, {
                scale: 3,
                useCORS: true,
                logging: false
            }).then(canvas => {

                const imgData = canvas.toDataURL("image/png");
                const pdf = new jsPDF("p", "mm", [100, 160]);

                pdf.addImage(imgData, "PNG", 0, 0, 100, 160);
                pdf.save("shipping_label" + orderId + "-author.pdf");
            });
        });
    }); 
</script>

<?= $this->endSection(); ?>