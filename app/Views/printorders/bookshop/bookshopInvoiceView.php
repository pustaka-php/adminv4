<?= $this->extend('layout/layout1'); ?>

<?= $this->section('script'); ?>
<script>
    function printInvoice() {
        var printContents = document.getElementById("invoice").innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }

    function create_invoice() {
        var order_id = document.getElementById('order_id').value;
        var invoice_number = document.getElementById('invoice_number').value;

        if (invoice_number === '') {
            alert("Please fill in invoice field before marking Invoice");
            return;
        }

        $.ajax({
            url: "<?= base_url('paperback/createbookshopinvoice') ?>",
            type: "POST",
            data: {
                order_id: order_id,
                invoice_number: invoice_number,
                "<?= csrf_token() ?>": "<?= csrf_hash() ?>",
            },
            success: function (res) {
                if (res.status) {
                    alert(res.message);
                    window.location.href = "<?= base_url('paperback/bookshoporderbooksstatus') ?>";
                } else {
                    alert(res.message);
                }
            },
            error: function (xhr) {
                alert("Error: " + xhr.status + " " + xhr.statusText);
            }
        });
    }
</script>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?> 

<div class="card">
    <div class="card-header">
        <div class="d-flex flex-wrap align-items-center justify-content-end gap-2">
            <?php if ($bookshop['invoice']['invoice_no'] == NULL) { ?>
                <button type="button" onclick="create_invoice()" class="btn btn-sm btn-danger radius-8 d-inline-flex align-items-center gap-1">
                    <iconify-icon icon="mdi:file-document-edit-outline" class="text-xl"></iconify-icon>
                    Generate Invoice
                </button>
            <?php } else { ?>
                <a href="<?= base_url('paperback/bookshoporderbooksstatus') ?>" class="btn btn-sm btn-primary radius-8 d-inline-flex align-items-center gap-1">
                    <iconify-icon icon="mdi:arrow-left" class="text-xl"></iconify-icon>
                    Back
                </a>
                <button type="button" class="btn btn-sm btn-danger radius-8 d-inline-flex align-items-center gap-1" onclick="printInvoice()">
                    <iconify-icon icon="basil:printer-outline" class="text-xl"></iconify-icon>
                    Print
                </button>
            <?php } ?>
        </div>
    </div>

    <div class="card-body py-40">
        <div class="row justify-content-center" id="invoice">
            <div class="col-lg-8">
                <div class="shadow-4 border radius-8">
                    <div class="p-20 d-flex flex-wrap justify-content-between gap-3 border-bottom">
                        <div>
                            <h3 class="text-xl">Invoice Details</h3>
                            <p class="mb-1 text-sm">Order ID: <?= $bookshop['invoice']['order_id']; ?></p>
                            <p class="mb-0 text-sm">Invoice No: <?= $bookshop['invoice']['invoice_no']; ?></p>
                        </div>
                        <div class="text-end">
                            <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo" class="mb-8" style="max-width: 120px; height: auto;">
                            <p class="mb-1 text-sm">Bookshop Invoice System</p>
                            <p class="mb-0 text-sm"><?= date('d M Y'); ?></p>
                        </div>
                    </div>

                    <div class="py-28 px-20">
                        <div class="d-flex flex-wrap justify-content-between gap-3">
                            <div>
                                <h6 class="text-md mb-3">Invoice Information</h6>
                                <div class="mb-2">
                                    <label class="text-sm fw-semibold">Order ID:</label>
                                    <input class="form-control form-control-sm" id="order_id" name="order_id" value="<?= $bookshop['invoice']['order_id']; ?>" readonly>
                                </div>
                                <div class="mb-2">
                                    <label class="text-sm fw-semibold">Invoice Number:</label>
                                    <input class="form-control form-control-sm" id="invoice_number" name="invoice_number" value="<?= $bookshop['invoice']['invoice_no']; ?>" required>
                                </div>
                            </div>
                            <div>
                                <h6 class="text-md mb-3">Total Summary</h6>
                                <div class="mb-2">
                                    <label class="text-sm fw-semibold">Total Invoice:</label>
                                    <input type="text" id="net_total" name="net_total" class="form-control form-control-sm" 
                                           value="<?= $bookshop['invoice']['net_total']; ?>" readonly style="color: black;">
                                </div>
                            </div>
                        </div>

                        <div class="mt-40 text-center">
                            <?php if ($bookshop['invoice']['invoice_no'] == NULL) { ?>
                                <button type="button" onclick="create_invoice()" class="btn btn-danger radius-8">
                                    Generate Invoice
                                </button>
                            <?php } else { ?>
                                <a href="<?= base_url('paperback/bookshoporderbooksstatus') ?>" class="btn btn-secondary radius-8">
                                    Back
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
