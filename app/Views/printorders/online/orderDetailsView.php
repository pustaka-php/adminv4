<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<?php
$numberOfTitles = isset($orderbooks['list']) ? count($orderbooks['list']) : 0;
$totalBooks = 0;

if (!empty($orderbooks['list'])) {
    foreach ($orderbooks['list'] as $books_details) {
        $totalBooks += $books_details['quantity'];
    }
}
?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="d-flex justify-content-end mb-3">
            <a href="<?= base_url('paperback/onlineorderbooksstatus'); ?>" class="btn btn-outline-secondary btn-sm">
                ← Back
            </a>
        </div>
        <!-- Order Info Card -->
        <div class="col-md-6 mx-auto">
            <div class="card h-100 radius-12 bg-gradient-purple text-center">
                <div class="card-body p-24">
                    <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-lilac-600 text-white mb-16 radius-12">
                        <iconify-icon icon="mdi:truck" class="h5 mb-0"></iconify-icon>
                    </div>
                    <h6 class="mb-16">Online Customer Details</h6>
                    <div class="text-start">
                        <p class="mb-2"><strong>Order ID:</strong> 
                            <?= htmlspecialchars($orderbooks['details']['order_id']) ?>
                        </p>
                        <?php if (!empty($orderbooks['details'])): ?>
                            <p class="mb-2"><strong>User ID:</strong> 
                                <?= htmlspecialchars($orderbooks['details']['user_id']) ?>
                            </p>
                            <p class="mb-2"><strong>User Name:</strong> 
                                <?= htmlspecialchars($orderbooks['details']['username']) ?>
                            </p>
                            <p class="mb-2"><strong>Courier Charges:</strong> 
                                <?= number_format($orderbooks['details']['shipping_charges'], 2) ?>
                            </p>
                            <p class="mb-2"><strong>Order Date:</strong> 
                                <?= date('d-m-Y', strtotime($orderbooks['details']['order_date'])) ?>
                            </p>
                            <p class="mb-2"><strong>Shipped Date:</strong> 
                                <?= $orderbooks['details']['ship_date'] 
                                    ? date('d-m-Y', strtotime($orderbooks['details']['ship_date'])) 
                                    : '' ?>
                            </p>
                            <p class="mb-0"><strong>Tracking:</strong>
                                <a href="<?= htmlspecialchars($orderbooks['details']['tracking_url']) ?>" target="_blank" class="ms-2">
                                    <!-- Tracking SVG -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" 
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                        class="feather feather-truck me-1">
                                        <rect x="1" y="3" width="15" height="13"></rect>
                                        <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                        <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                        <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                    </svg>

                                    <?= htmlspecialchars($orderbooks['details']['tracking_id']) ?>
                                </a>
                            </p>
                        <?php else: ?>
                            <p class="text-danger mb-0">
                                No order details found for Order ID: <?= htmlspecialchars($order_id) ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <br><br>


        <!-- Trigger Modal -->
        <?php if (!empty($orderbooks['details'])): ?>
            <div class="container mt-5 text-center">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#shippingLabelModal">
                    <b>Generate Shipping Label</b>
                </button>
            </div>

            <!-- Modal Structure -->
            <div class="modal fade" id="shippingLabelModal" tabindex="-1" aria-labelledby="shippingLabelModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="shippingLabelModalLabel"><b>Shipping Label</b></h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="label-container p-3"
                                style="width: 200mm; min-height: 180mm; padding: 10mm; background: #fff; border: 2px solid #000; box-sizing: border-box; font-size: 22px;">

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

                                <div style="margin-bottom: 15px;">
                                    <div style="font-weight: bold; margin-bottom: 8px;">Shipping Address:</div>
                                    <div style="border: 2px solid #000; padding: 10px;">
                                        <div style="font-weight: bold;">
                                            <?= htmlspecialchars($orderbooks['details']['shipping_name']) ?><br>
                                            <?= htmlspecialchars($orderbooks['details']['shipping_address1']) ?>,
                                            <?= htmlspecialchars($orderbooks['details']['shipping_address2']) ?>,
                                            <?= htmlspecialchars($orderbooks['details']['shipping_area_name']) ?><br>
                                            Landmark:
                                            <?= htmlspecialchars($orderbooks['details']['shipping_landmark']) ?><br>
                                            <?= htmlspecialchars($orderbooks['details']['shipping_city']) ?> -
                                            <?= htmlspecialchars($orderbooks['details']['shipping_pincode']) ?><br>
                                            Phone: <?= htmlspecialchars($orderbooks['details']['shipping_mobile_no']) ?>
                                            </td>
                                            </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>


                                <table
                                    style="width: 100%; border-collapse: collapse; border: 1px solid #000; font-weight: bold;">
                                    <tr>
                                        <td style="border: 1px solid #000; padding: 10px; text-align: center;"><b>Titles:
                                                <?= $numberOfTitles ?></b></td>
                                        <td style="border: 1px solid #000; padding: 10px; text-align: center;"><b>Books:
                                                <?= $totalBooks ?></b></td>
                                        <td style="border: 1px solid #000; padding: 10px; text-align: center;"><b>ONL</b>
                                        </td>
                                    </tr>
                                </table>

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
        <?php endif; ?>

        <br><br>

        <?php if (!empty($orderbooks['details'])): ?>
            <!-- Shipping and Billing Address -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="card h-100 radius-12 bg-gradient-success text-center">
                        <div class="card-body p-24">
                            <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-success-600 text-white mb-16 radius-12">
                                <iconify-icon icon="ri:map-pin-user-fill" class="h5 mb-0"></iconify-icon>
                            </div>
                            <h6 class="text-center">Shipping Address</h6>
                            <div class="text-start">    
                                <p class="mb-2"><strong>Name:</strong> <?= htmlspecialchars($orderbooks['details']['shipping_name']); ?></p>
                                <p class="mb-2"><strong>Address:</strong> <?= htmlspecialchars($orderbooks['details']['shipping_address1']); ?></p>
                                <p class="mb-2"><?= htmlspecialchars($orderbooks['details']['shipping_address2']); ?></p>
                                <p class="mb-2"><?= htmlspecialchars($orderbooks['details']['shipping_area_name']); ?></p>
                                <p class="mb-2"><strong>City:</strong> <?= htmlspecialchars($orderbooks['details']['shipping_city']); ?></p>
                                <p class="mb-2"><strong>Landmark:</strong> <?= htmlspecialchars($orderbooks['details']['shipping_landmark']); ?></p>
                                <p class="mb-2"><strong>State:</strong> <?= htmlspecialchars($orderbooks['details']['shipping_state']); ?></p>
                                <p class="mb-2"><strong>Pincode:</strong> <?= htmlspecialchars($orderbooks['details']['shipping_pincode']); ?></p>
                                <p class="mb-2"><strong>Phone:</strong> <?= htmlspecialchars($orderbooks['details']['shipping_mobile_no']); ?></p>
                                <p class="mb-2"><strong>Alt Phone:</strong> <?= htmlspecialchars($orderbooks['details']['shipping_alternate_no']); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="card h-100 radius-12 bg-gradient-primary text-center">
                        <div class="card-body p-24">
                            <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-primary-600 text-white mb-16 radius-12">
                                <iconify-icon icon="mdi:truck-delivery" class="h5 mb-0"></iconify-icon>
                            </div>
                            <h6 class="text-center">Billing Address</h6>
                            <div class="text-start">
                                <p class="mb-2">Name: <?= htmlspecialchars($orderbooks['details']['billing_name']); ?></p>
                                <p class="mb-2">Address: <?= htmlspecialchars($orderbooks['details']['billing_address1']); ?></p>
                                <p class="mb-2"><?= htmlspecialchars($orderbooks['details']['billing_address2']); ?></p>
                                <p class="mb-2"><?= htmlspecialchars($orderbooks['details']['billing_area_name']); ?></p>
                                <p class="mb-2">City: <?= htmlspecialchars($orderbooks['details']['billing_city']); ?></p>
                                <p class="mb-2">Landmark: <?= htmlspecialchars($orderbooks['details']['billing_landmark']); ?></p>
                                <p class="mb-2">State: <?= htmlspecialchars($orderbooks['details']['billing_state']); ?></p>
                                <p class="mb-2">Pincode: <?= htmlspecialchars($orderbooks['details']['billing_pincode']); ?></p>
                                <p class="mb-2">Phone: <?= htmlspecialchars($orderbooks['details']['billing_mobile_no']); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <br><br><br>
        <?php if (!empty($orderbooks['list'])): ?>
            <table class="zero-config table table-hover mt-4">
                <thead>
                    <h6 class="text-center">List of Books</h6><br>
                    <tr>
                        <th>S.No</th>
                        <th>BookId</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Quantity</th>
                        <th>Book Price</th>
                        <th>Discount %</th>
                        <th>Price</th>
                        <th>Stock State</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody style="font-weight: normal;">
                    <?php
                    $totalValue = 0;
                    $i = 1;
                    foreach ($orderbooks['list'] as $books_details):
                        $price = $books_details['price'] * $books_details['quantity'];
                        $totalValue += $price;
                        $stockStatus = $books_details['quantity'] <= $books_details['total_quantity'] ? 'IN STOCK' : 'OUT OF STOCK';
                        ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= htmlspecialchars($books_details['book_id']) ?></td>
                            <td><?= htmlspecialchars($books_details['book_title']) ?></td>
                            <td><?= htmlspecialchars($books_details['author_name']) ?></td>
                            <td><?= htmlspecialchars($books_details['quantity']) ?></td>
                            <td><?= htmlspecialchars($books_details['paper_back_inr']) ?></td>
                            <td><?= htmlspecialchars($books_details['discount']) ?></td>
                            <td><?= number_format($price, 2) ?></td>
                            <td><?= $stockStatus ?></td>
                            <td>
                                <?php
                                if ($books_details['status'] == 0)
                                    echo "In Progress";
                                else if ($books_details['status'] == 1)
                                    echo "Shipped";
                                else if ($books_details['status'] == 2)
                                    echo "Cancelled";
                                else
                                    echo "";
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="7" style="text-align:right; font-weight:bold;">Books Total</td>
                        <td colspan="1" style="font-weight:bold;"><?= number_format($totalValue, 2) ?></td>
                    </tr>
                    <tr>
                        <td colspan="7" style="text-align:right; font-weight:bold; color:blue;">
                            Total amount <br>
                            <span>(Books amount + Shipping charge)</span>
                        </td>
                        <td colspan="1" style="font-weight:bold; color:blue;">
                            <?= $totalValue . " + " . $orderbooks['details']['shipping_charges'] . " = " . number_format($totalValue + $orderbooks['details']['shipping_charges'], 2) ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
            <h6 class="text-center text-danger">No books found for this order.</h6>
        <?php endif; ?>
    </div>
</div>

<!-- Libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        <?php if (!empty($order_id)): ?>
            JsBarcode("#barcodeCanvas", "<?= $order_id ?>", {
                format: "CODE128",
                displayValue: true,
                height: 50,
                width: 2
            });

            document.getElementById("downloadPdfBtn")?.addEventListener("click", function () {
                const { jsPDF } = window.jspdf;
                const container = document.querySelector(".label-container");

                html2canvas(container, {
                    scale: 3,
                    useCORS: true,
                    allowTaint: true,
                    logging: false
                }).then(canvas => {
                    const imgData = canvas.toDataURL("image/png");
                    const pdf = new jsPDF("p", "mm", [100, 160]);
                    // const pdfWidth = pdf.internal.pageSize.getWidth();
                    // const pdfHeight = pdf.internal.pageSize.getHeight();

                    // const imgWidth = canvas.width;
                    // const imgHeight = canvas.height;
                    // const ratio = Math.min(pdfWidth / imgWidth, pdfHeight / imgHeight);
                    // const x = (pdfWidth - imgWidth * ratio) / 2;
                    // const y = 10;

                    // pdf.addImage(imgData, "PNG", x, y, imgWidth * ratio, imgHeight * ratio);
                    pdf.addImage(imgData, "PNG", 0, 0, 100, 160);
                    pdf.save("shipping-label-<?= $order_id ?>-online.pdf");
                });
            });
        <?php endif; ?>
    });
</script>

<?= $this->endSection(); ?>