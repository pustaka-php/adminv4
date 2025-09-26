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

        <br><br><br>
        <div class="container mt-5">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#shippingLabelModal">
                <b>Generate Shipping Label</b>
            </button>
        </div>
        <br>

        <!-- Modal Structure -->
        <div class="modal fade" id="shippingLabelModal" tabindex="-1" aria-labelledby="shippingLabelModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="shippingLabelModalLabel"><b>Shipping Label</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="label-container" style="width:100mm; height:160mm; padding:5mm; background:#fff; font-family: Arial, sans-serif;">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:5mm;">
                                <img src="<?= base_url().'assets/images/pustaka-logo-90x90.jpeg' ?>" alt="Logo" style="height:25px; width:140px;">
                                <canvas id="barcodeCanvas" style="border:1px solid #000; height:55px; width:125px;"></canvas>
                            </div>

                            <h6 style="display:none;" id="orderNumber"><?= $order_id ?></h6>

                            <div style="margin-bottom:3mm;">
                                <strong>Shipping Address:</strong><br>
                                <?= htmlspecialchars($orderbooks['order']['ship_name']); ?><br>
                                <?= htmlspecialchars($orderbooks['order']['ship_address']); ?><br>
                                Phone: <?= htmlspecialchars($orderbooks['order']['ship_mobile']); ?>
                            </div>

                            <table style="width:100%; border-collapse:collapse; margin-bottom:3mm;">
                                <tr>
                                    <td style="border:1px solid black; text-align:center;"><b>Titles: <?= $numberOfTitles ?></b></td>
                                    <td style="border:1px solid black; text-align:center;"><b>Books: <?= $totalBooks ?></b></td>
                                    <td style="border:1px solid black; text-align:center;"><b>Type: AUH</b></td>
                                </tr>
                            </table>

                            <div>
                                <strong>From:</strong> Pustaka Digital Media Pvt. Ltd.,<br>
                                “Sri Illam”, 35, Roja 2nd Street, PWDO Colony<br>
                                Seelapadi, Dindigul - 624 005<br>
                                TamilNadu, Mobile: +91 99803 87852
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

        <br>
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

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    function generateBarcode() {
        return new Promise((resolve) => {
            const orderNumber = document.getElementById('orderNumber').innerText.trim();
            JsBarcode("#barcodeCanvas", orderNumber, {
                format: "CODE128",
                lineColor: "#000",
                width: 2,
                height: 50,
                displayValue: true
            });
            setTimeout(resolve, 100); // slight delay to ensure barcode renders
        });
    }

    // Generate barcode when modal opens
    const shippingModal = document.getElementById('shippingLabelModal');
    shippingModal.addEventListener('shown.bs.modal', generateBarcode);

    // Download PDF
    document.getElementById('downloadPdfBtn').addEventListener('click', async () => {
        await generateBarcode(); // ensure barcode is rendered before PDF
        const element = document.querySelector('.label-container');
        const orderNumber = document.getElementById('orderNumber').innerText.trim();
        const options = {
            margin: 0,
            filename: `${orderNumber || 'shipping_label'}.pdf`,
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2, useCORS: true },
            jsPDF: { unit: 'mm', format: [100, 160], orientation: 'portrait' }
        };
        html2pdf().set(options).from(element).save();
    });
});
</script>

<?= $this->endSection(); ?>
