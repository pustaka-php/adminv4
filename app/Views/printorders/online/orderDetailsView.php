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
        <div class="d-flex justify-content-center">
            <div class="card h-100 radius-2 bg-gradient-success mb-4" style="width: 50%;">
                <div class="card-body p-24 text-start">
                    <ul class="list-group-item">
                        <li class="list-group-item">
                            <h5 class="text-center">Order ID:
                                <?= htmlspecialchars($orderbooks['details']['order_id']) ?>
                            </h5>
                        </li>
                        <li class="list-group-item">
                            <h6 class="text-center">Online Customer Details</h6>
                        </li><br>

                        <?php if (!empty($orderbooks['details'])): ?>
                            <li class="list-group-item">
                                <div class="mb-12 text-start"><strong>User Id:
                                        <?= htmlspecialchars($orderbooks['details']['user_id']) ?></div>
                                <div class="mb-12 text-start"><strong>User Name:
                                        <?= htmlspecialchars($orderbooks['details']['username']) ?></div>
                                <div class="mb-12 text-start"><strong>Courier Charges:
                                        <?= number_format($orderbooks['details']['shipping_charges'], 2) ?> </div>
                                <div class="mb-12 text-start"><strong>Order Date:
                                        <?= date('d-m-Y', strtotime($orderbooks['details']['order_date'])) ?></div>
                                <div class="mb-12 text-start"><strong>Shipped Date:
                                        <?= $orderbooks['details']['ship_date'] ? date('d-m-Y', strtotime($orderbooks['details']['ship_date'])) : '' ?>
                                </div>
                                <div class="mb-12 text-start"><strong>
                                        <a href="<?= htmlspecialchars($orderbooks['details']['tracking_url']) ?>"
                                            target="_blank">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-truck">
                                                <rect x="1" y="3" width="15" height="13"></rect>
                                                <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                                <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                                <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                            </svg> <?= htmlspecialchars($orderbooks['details']['tracking_id']) ?>
                                        </a>
                                </div>
                            </li>
                        <?php else: ?>
                            <li class="list-group-item text-center text-danger">
                                <h6>No order details found for Order ID: <?= htmlspecialchars($order_id) ?></h6>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>


        <!-- Trigger Modal -->
        <?php if (!empty($orderbooks['details'])): ?>
            <div class="container mt-5">
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
                                <!-- <div class="row">
                                    <div class="label-header">
                                        <img src="<?= base_url('assets/images/pustaka-logo-90x90.jpeg') ?>" alt="Logo"
                                            height="25" width="120">
                                    </div>
                                    <div class="col text-end">
                                        <canvas id="barcodeCanvas"
                                            style="border: 1px solid #000; height: 55px; width: 125px"></canvas>
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
                    <div class="card h-100 radius-12 bg-gradient-purple" style="padding: 10px;">
                        <div class="card-body p-2">
                            <h6 class="text-center">Shipping Address</h6>
                            <p><strong>Name:</strong> <?= htmlspecialchars($orderbooks['details']['shipping_name']); ?></p>
                            <p><strong>Address:</strong>
                                <?= htmlspecialchars($orderbooks['details']['shipping_address1']); ?></p>
                            <p><?= htmlspecialchars($orderbooks['details']['shipping_address2']); ?></p>
                            <p><?= htmlspecialchars($orderbooks['details']['shipping_area_name']); ?></p>
                            <p><strong>City:</strong> <?= htmlspecialchars($orderbooks['details']['shipping_city']); ?></p>
                            <p><strong>Landmark:</strong>
                                <?= htmlspecialchars($orderbooks['details']['shipping_landmark']); ?></p>
                            <p><strong>State:</strong> <?= htmlspecialchars($orderbooks['details']['shipping_state']); ?>
                            </p>
                            <p><strong>Pincode:</strong>
                                <?= htmlspecialchars($orderbooks['details']['shipping_pincode']); ?></p>
                            <p><strong>Phone:</strong>
                                <?= htmlspecialchars($orderbooks['details']['shipping_mobile_no']); ?></p>
                            <p><strong>Alt Phone:</strong>
                                <?= htmlspecialchars($orderbooks['details']['shipping_alternate_no']); ?></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="card h-100 radius-12 bg-gradient-primary" style="padding: 10px;">
                        <div class="card-body p-2">
                            <h6 class="text-center">Billing Address</h6>
                            <p>Name: <?= htmlspecialchars($orderbooks['details']['billing_name']); ?></p>
                            <p>Address: <?= htmlspecialchars($orderbooks['details']['billing_address1']); ?></p>
                            <p><?= htmlspecialchars($orderbooks['details']['billing_address2']); ?></p>
                            <p><?= htmlspecialchars($orderbooks['details']['billing_area_name']); ?></p>
                            <p>City: <?= htmlspecialchars($orderbooks['details']['billing_city']); ?></p>
                            <p>Landmark: <?= htmlspecialchars($orderbooks['details']['billing_landmark']); ?></p>
                            <p>State: <?= htmlspecialchars($orderbooks['details']['billing_state']); ?></p>
                            <p>Pincode: <?= htmlspecialchars($orderbooks['details']['billing_pincode']); ?></p>
                            <p>Phone: <?= htmlspecialchars($orderbooks['details']['billing_mobile_no']); ?></p>
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