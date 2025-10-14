<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="layout-px-spacing">

    <!-- Back Button -->
    <div class="mb-3">
        <a href="<?= base_url('pod/publisherview/'.$book['publisher_id']) ?>" class="btn btn-outline-secondary btn-sm">
            &larr; Back to Publisher Books
        </a>
    </div>

    <div class="row g-3">

        <!-- Book General Info Card -->
        <div class="col-md-6">
            <div class="card p-3 shadow-sm radius-8 bg-gradient-start-1 h-100">
                <div class="card-header fs-5 fw-bold mb-2">
                    Book General Info
                </div>
                <p><strong>Publisher Reference:</strong> <?= esc($book['publisher_reference']) ?></p>
                <p><strong>Custom Publisher Name:</strong> <?= esc($book['custom_publisher_name']) ?></p>
                <p><strong>Total Pages:</strong> <?= esc($book['total_num_pages']) ?></p>
                <p><strong>Copies:</strong> <?= esc($book['num_copies']) ?></p>
                <p><strong>Book Size:</strong> <?= esc($book['book_size']) ?></p>
                <p><strong>Content Paper:</strong> <?= esc($book['content_paper']) ?> (GSM: <?= esc($book['content_gsm']) ?>, Colour: <?= esc($book['content_colour']) ?>)</p>
                <p><strong>Cover Paper:</strong> <?= esc($book['cover_paper']) ?> (GSM: <?= esc($book['cover_gsm']) ?>)</p>
                <p><strong>Lamination Type:</strong> <?= esc($book['lamination_type']) ?></p>
                <p><strong>Binding Type:</strong> <?= esc($book['binding_type']) ?></p>
                <p><strong>Content Location:</strong> <?= esc($book['content_location']) ?></p>
            </div>
        </div>

        <!-- Charges & Remarks Card -->
        <div class="col-md-6">
            <div class="card p-3 shadow-sm radius-8 bg-gradient-start-2 h-100">
                <div class="card-header fs-5 fw-bold mb-2">
                    Charges & Remarks
                </div>
                <dl class="row mb-0">
                    <dt class="col-sm-4">Quote1:</dt>
                    <dd class="col-sm-8"><?= esc($book['num_pages_quote1']) ?> pages @ <?= esc($book['cost_per_page1']) ?></dd>

                    <dt class="col-sm-4">Quote2:</dt>
                    <dd class="col-sm-8"><?= esc($book['num_pages_quote2']) ?> pages @ <?= esc($book['cost_per_page2']) ?></dd>

                    <dt class="col-sm-4">Fixed Charge:</dt>
                    <dd class="col-sm-8"><?= esc($book['fixed_charge_book']) ?></dd>

                    <dt class="col-sm-4">Transport Charges:</dt>
                    <dd class="col-sm-8"><?= esc($book['transport_charges']) ?></dd>

                    <dt class="col-sm-4">Design Charges:</dt>
                    <dd class="col-sm-8"><?= esc($book['design_charges']) ?></dd>

                    <dt class="col-sm-4">Remarks:</dt>
                    <dd class="col-sm-8"><?= esc($book['remarks']) ?></dd>
                </dl>
            </div>
        </div>

        <!-- Process Status Card -->
        <div class="col-md-4">
    <div class="card p-3 shadow-sm radius-8 bg-gradient-end-3 h-100">
        <div class="card-header fs-5 fw-bold mb-2">
            Process Status
        </div>
        <ul>
            <?php 
            $flags = [
                'Start' => 'start_flag',
                'Files Ready' => 'files_ready_flag',
                'Cover' => 'cover_flag',
                'Content' => 'content_flag',
                'Lamination' => 'lamination_flag',
                'Binding' => 'binding_flag',
                'Final Cut' => 'finalcut_flag',
                'QC' => 'qc_flag',
                'Packing' => 'packing_flag',
                'Delivery' => 'delivery_flag'
            ];
            foreach ($flags as $label => $field): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?= $label ?>
                    <?php if($book[$field]): ?>
                        <span class="badge bg-success">Done</span>
                    <?php else: ?>
                        <span class="badge bg-warning text-dark">Pending</span>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

        <!-- Delivery Details Card -->
        <div class="col-md-4">
            <div class="card p-3 shadow-sm radius-8 bg-gradient-end-4 h-100">
                <div class="card-header fs-5 fw-bold mb-2">
                    Delivery Details
                </div>
                <p><strong>Delivery Date:</strong> <?= esc($book['delivery_date']) ?></p>
                <p><strong>Actual Delivery:</strong> <?= esc($book['actual_delivery_date']) ?></p>
                <p><strong>Invoice Number:</strong> <?= esc($book['invoice_number']) ?></p>
                <p><strong>Invoice Date:</strong> <?= esc($book['invoice_date']) ?></p>
                <p><strong>Invoice Flag:</strong> <?= $book['invoice_flag'] ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-warning text-dark">No</span>' ?></p>
            </div>
        </div>

        <!-- Financials Card -->
        <div class="col-md-4">
            <div class="card p-3 shadow-sm radius-8 bg-gradient-end-5 h-100">
                <div class="card-header fs-5 fw-bold mb-2">
                    Financials
                </div>
                <p><strong>Ship Address:</strong> <?= esc($book['ship_address']) ?></p>
                <p><strong>Sub Total:</strong> <?= esc($book['sub_total']) ?></p>
                <p><strong>CGST:</strong> <?= esc($book['cgst']) ?></p>
                <p><strong>SGST:</strong> <?= esc($book['sgst']) ?></p>
                <p><strong>IGST:</strong> <?= esc($book['igst']) ?></p>
                <p><strong>Invoice Value:</strong> <?= esc($book['invoice_value']) ?></p>
                <p><strong>Payment Status:</strong> <?= $book['payment_flag'] ? '<span class="badge bg-success">Paid</span>' : '<span class="badge bg-warning text-dark">Pending</span>' ?></p>
                <p><strong>Payment Date:</strong> <?= esc($book['payment_date']) ?></p>
            </div>
        </div>

    </div> <!-- End row -->

</div>
<?= $this->endSection(); ?>
