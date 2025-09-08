<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-account-invoice-one">
                <div class="widget-heading">
                    <h5 class="">Invoice Details:</h5>
                </div>
                <div class="widget-content">
                            <label class="mt-3">Order Id:</label>
                            <input class="form-control" name="order_id" id="order_id" value="<?php echo $bookshop['invoice']['order_id']; ?>" readonly/>
                            <label class="mt-3">Invoice Number:</label>
                            <input class="form-control" name="invoice_number" id="invoice_number" value="<?php echo $bookshop['invoice']['invoice_no']; ?>" required/>
                    <br>
                    <h5 class="text-center">Invoice Amount</h5>
                    <div class="row">
                        <div class="col">
                        <label class="mt-3">Total Invoice</label>
                        <input type="text" id="net_total" name="net_total" class="form-control" readonly value="<?php echo $bookshop['invoice']['net_total']; ?>" style="color: black;">
                        </div>		
					</div>
                    <br>
                    <div class="inv-action">
                            <?php if ($bookshop['invoice']['invoice_no'] == NULL) { ?>
                                <a href="" onclick="create_invoice()" class="btn btn-danger">Generate Invoice</a>
                            <?php } else {?>
                                <a href="<?php echo base_url()."pustaka_paperback/bookshop_orderbooks_status"?>" class="btn btn-danger">Back</a>
                            <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var base_url = window.location.origin;

    function create_invoice() {
        var order_id = document.getElementById('order_id').value;
        var invoice_number = document.getElementById('invoice_number').value;


        if (invoice_number === '') {
        alert("Please fill in invoice field before marking Invoice");
        return;
        }
        
        $.ajax({
            url: base_url + '/pustaka_paperback/create_bookshop_invoice',
            type: 'POST',
            data: {
                "order_id": order_id,
                "invoice_number": invoice_number,
            },
            success: function(data) {
                if (data == 1) {
                    alert("Successfully created invoice!");
                } else {
                    alert("Invoice not created!! Check again!");
                }
            }
        });
    }
</script>



