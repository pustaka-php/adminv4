<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-account-invoice-one">
                <div class="widget-heading">
                    <h6 class="text-center">Invoice Details:</h6>
                </div>
                <div class="widget-content">
                    <label class="mt-3">Order Id:</label>
                    <input class="form-control" name="order_id" id="order_id" value="<?= $bookshop['invoice']['order_id']; ?>" readonly/>
                    
                    <label class="mt-3">Invoice Number:</label>
                    <input class="form-control" name="invoice_number" id="invoice_number" value="<?= $bookshop['invoice']['invoice_no']; ?>" required/>
                    
                    <br>
                    <h6 class="text-center">Invoice Amount</h6>
                    <div class="row">
                        <div class="col">
                            <label class="mt-3">Total Invoice</label>
                            <input type="text" id="net_total" name="net_total" class="form-control" readonly 
                                   value="<?= $bookshop['invoice']['net_total']; ?>" style="color: black;">
                        </div>
                    </div>
                    <br>
                    <div class="inv-action">
                        <?php if ($bookshop['invoice']['invoice_no'] == NULL) { ?>
                            <!-- Use button instead of <a> -->
                            <button type="button" onclick="create_invoice()" class="btn btn-danger">Generate Invoice</button>
                        <?php } else { ?>
                            <a href="<?= base_url('paperback/bookshoporderbooksstatus') ?>" class="btn btn-danger">Back</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
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
                "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
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
