<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="layout-px-spacing">
    <div class="row justify-content-center mt-4">
        <div class="col-xl-8 col-lg-9 col-md-11 col-sm-12">
            
            <div class="card shadow-lg  rounded-4">
                <div class="card-header bg-primary py-3 rounded-top-4">
                    <h5 class="mb-0">
                        <i class="fa fa-file-invoice me-2"></i> POD Publisher Invoice
                    </h5>
                </div>

                <div class="card-body">

                    <?php 
                        $book_cost1 = $pod_publisher_book['num_pages_quote1'] * $pod_publisher_book['cost_per_page1']; 
                        $book_cost2 = $pod_publisher_book['num_pages_quote2'] * $pod_publisher_book['cost_per_page2'];
                        $book_cost  = $book_cost1 + $book_cost2 + $pod_publisher_book['fixed_charge_book'];
                        $gst        = $pod_publisher_book['sgst'] + $pod_publisher_book['cgst'] + $pod_publisher_book['igst'];
                    ?>

                    <input type="hidden" id="book_id" value="<?= esc($pod_publisher_book['book_id']); ?>">

                    <!-- Publisher Details -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-1">To:</h6>
                        <p class="fs-6 mb-2"><?= esc($pod_publisher['publisher_name']); ?></p>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="p-3 rounded-3 shadow-sm">
                                    <h6 class="fw-semibold text-primary mb-2">Billing Address</h6>
                                    <p class="small mb-0"><?= nl2br(esc($pod_publisher['address'])); ?><br>
                                    <?= esc($pod_publisher['city']); ?><br>
                                    <?= esc($pod_publisher['contact_person']); ?><br>
                                    <?= esc($pod_publisher['contact_mobile']); ?></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="p-3 rounded-3 shadow-sm">
                                    <h6 class="fw-semibold text-primary mb-2">Shipping Address</h6>
                                    <p class="small mb-0"><?= nl2br(esc($pod_publisher_book['ship_address'])); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Invoice Summary -->
                    <div class="p-3 rounded-3 shadow-sm mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold text-primary mb-0">Invoice Value</h6>
                            <h4 class="text-success fw-bold mb-0">₹ <?= number_format($pod_publisher_book['invoice_value'], 2); ?></h4>
                        </div>
                    </div>

                    <!-- Book Details -->
                    <div class="p-3 rounded-3 shadow-sm mb-4">
    <h6 class="fw-semibold mb-3">Book Details</h6>

    <p class="mb-1"><strong>Title:</strong> <?= esc($pod_publisher_book['book_title']); ?></p>
    <p class="mb-1">
        <strong>Copies:</strong> <?= esc($pod_publisher_book['num_copies']); ?> 
        | <strong>Pages:</strong> <?= esc($pod_publisher_book['total_num_pages']); ?>
    </p>

    <span class="mt-3 mb-2 fw-semibold text-decoration-underline">Cost per Page Details</span>

    <!-- Cost per page 1 -->
    <p class="mb-1">
        <strong>Quote 1:</strong> <?= esc($pod_publisher_book['num_pages_quote1']); ?> pages × ₹<?= number_format($pod_publisher_book['cost_per_page1'], 2); ?>
        = ₹<?= number_format($book_cost1, 2); ?>
    </p>

    <!-- Cost per page 2 (only if available) -->
    <?php if ($pod_publisher_book['num_pages_quote2'] != 0): ?>
        <p class="mb-1">
            <strong>Quote 2:</strong> <?= esc($pod_publisher_book['num_pages_quote2']); ?> pages × ₹<?= number_format($pod_publisher_book['cost_per_page2'], 2); ?>
            = ₹<?= number_format($book_cost2, 2); ?>
        </p>
    <?php endif; ?>

    <!-- Fixed charge (optional) -->
    <?php if ($pod_publisher_book['fixed_charge_book'] != 0): ?>
        <p class="mb-1">
            <strong>Fixed charge per book:</strong> ₹<?= number_format($pod_publisher_book['fixed_charge_book'], 2); ?>
        </p>
    <?php endif; ?>

    <hr class="my-2">

    <!-- Show total cost calculation clearly -->
    <p class="mb-1 fw-semibold">
        <strong>Total Printing Cost:</strong> ₹<?= number_format($book_cost1, 2); ?>
        <?php if ($pod_publisher_book['num_pages_quote2'] != 0): ?>
            + ₹<?= number_format($book_cost2, 2); ?>
        <?php endif; ?>
        <?php if ($pod_publisher_book['fixed_charge_book'] != 0): ?>
            + ₹<?= number_format($pod_publisher_book['fixed_charge_book'], 2); ?>
        <?php endif; ?>
    </p>

    <p class="fw-bold fs-6 mt-2 mb-0 text-success">
        Cost per Book: ₹<?= number_format($book_cost, 2); ?>
    </p>
</div>


                    <!-- Taxes -->
                    <div class="p-3 rounded-3 shadow-sm mb-4">
                        <h6 class="fw-semibold mb-2">Taxes</h6>
                        <!-- <p class="mb-1"><strong>Total GST:</strong> ₹ <?= number_format($gst, 2); ?></p> -->

                        <?php if ($pod_publisher['igst_flag'] == 1): ?>
                            <p class="mb-0"><strong>IGST:</strong> ₹ <?= number_format($pod_publisher_book['igst'], 2); ?></p>
                        <?php else: ?>
                            <p class="mb-0">
                                <strong>SGST:</strong> ₹ <?= number_format($pod_publisher_book['sgst'], 2); ?>, 
                                <strong>CGST:</strong> ₹ <?= number_format($pod_publisher_book['cgst'], 2); ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <!-- Additional Charges -->
                    <?php if ($pod_publisher_book['design_charges'] || $pod_publisher_book['transport_charges']): ?>
                        <div class="p-3 rounded-3 shadow-sm mb-4">
                            <h6 class="fw-semibold mb-2">Additional Charges</h6>
                            <?php if ($pod_publisher_book['design_charges'] != 0): ?>
                                <p class="mb-1">Design Charges: ₹ <?= number_format($pod_publisher_book['design_charges'], 2); ?></p>
                            <?php endif; ?>
                            <?php if ($pod_publisher_book['transport_charges'] != 0): ?>
                                <p class="mb-0">Transport Charges: ₹ <?= number_format($pod_publisher_book['transport_charges'], 2); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Remarks & Invoice Number -->
                    <div class="p-3 rounded-3 shadow-sm mb-4">
                        <div class="mb-3">
                            <label for="remarks" class="form-label fw-semibold">Remarks</label>
                            <textarea id="remarks" rows="4" class="form-control" readonly><?= esc($pod_publisher_book['remarks']); ?></textarea>
                        </div>

                        <div>
                            <label for="invoice_number" class="form-label fw-semibold">Invoice Number</label>
                            <input type="text" class="form-control" id="invoice_number" placeholder="Enter Invoice Number" required>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="text-end">
                        <?php if ($pod_publisher_book['invoice_flag'] == 0): ?>
                            <button onclick="create_invoice()" class="btn btn-success px-4">
                                <i class="fa fa-check-circle me-2"></i> Generate Invoice
                            </button>
                        <?php else: ?>
                            <button class="btn btn-secondary px-4" onclick="history.back()">
                                <i class="fa fa-arrow-left me-2"></i> Back
                            </button>
                        <?php endif; ?>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- Script -->
<script>
function create_invoice() {
    const invoice_number = document.getElementById('invoice_number').value.trim();
    const book_id = document.getElementById('book_id').value;

    if (!invoice_number) {
        alert("Please enter the invoice number before generating.");
        return;
    }

    $.ajax({
        url: '<?= base_url('/pod/createinvoice'); ?>',
        type: 'POST',
        data: { book_id, invoice_number },
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                alert("✅ Invoice generated successfully!");
                location.reload();
            } else if (response.status === 'fail') {
                alert("❌ Failed to create invoice. Please check and try again.");
            } else {
                alert("⚠️ Unexpected response received.");
                console.log(response);
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", xhr.responseText);
            alert("⚠️ Something went wrong. Try again later.");
        }
    });
}
</script>


<?= $this->endSection(); ?>
