<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-account-invoice-one">
                <div class="widget-heading">
                    <h6 class="text-center">Invoice Details</h6>
                </div>
                <div class="widget-content">
                            <label class="mt-3">Order Id:</label>
                            <input class="form-control" name="order_id" id="order_id" value="<?php echo $author['invoice']['order_id']; ?>" readonly/>
                            <label class="mt-3">Invoice Number:</label>
                            <input class="form-control" name="invoice_number" id="invoice_number" value="<?php echo $author['invoice']['invoice_number']; ?>" required/>
                    <br><br>
                    <h6 class="text-center">Invoice Amount</h6>
                    <div class="row">
                        <div class="col">
                        <label class="mt-3">Sub Total</label>
                        <input class="form-control" name="sub_total" id="sub_total" value="<?php echo $author['invoice']['sub_total']; ?>" onInput="calculateTotalAmount()"/>
                        </div>
                        <div class="col">
                        <label class="mt-3">Shipping Charges</label>
                        <input class="form-control" name="shipping_charges" id="shipping_charges" value="<?php echo $author['invoice']['shipping_charges']; ?>" onInput="calculateTotalAmount()" />
                        </div>	
                        <div class="col">
                        <label class="mt-3">Total Invoice</label>
                        <input type="text" id="net_total" name="net_total" class="form-control" readonly value="<?php echo $author['invoice']['net_total']; ?>" style="color: black;">
                        </div>		
					</div>
                    <br>
                    <div class="inv-action">
                            <?php if ($author['invoice']['invoice_flag'] == 0) { ?>
                                <a href="javascript:void(0)" onclick="create_invoice()" class="btn btn-danger">Generate Invoice</a>
                            <?php } else {?>
                                <a href="<?php echo base_url()."paperback/authororderbooksstatus"?>" class="btn btn-danger">Back</a>
                            <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var base_url = window.location.origin;

    function calculateTotalAmount() {
        var net_total = 0;

        var sub_total = parseFloat(document.getElementById('sub_total').value)|| 0 ;
        var shipping_charges = parseFloat(document.getElementById('shipping_charges').value)|| 0 ;
        
        net_total = sub_total + shipping_charges;

        document.getElementById('net_total').value = net_total.toFixed(2);
        // alert(net_total);
    }

    function create_invoice() {
        var order_id = document.getElementById('order_id').value;
        var invoice_number = document.getElementById('invoice_number').value;
        var sub_total = document.getElementById('sub_total').value;
        var shipping_charges = document.getElementById('shipping_charges').value;
        var net_total = document.getElementById('net_total').value;


        if (invoice_number === '' || sub_total === '' || shipping_charges === '') {
        alert("Please fill in all fields before marking Invoice");
        return;
        }
        
        $.ajax({
            url: base_url + 'paperback/createinvoice',
            type: 'POST',
            data: {
                "order_id": order_id,
                "invoice_number": invoice_number,
                "sub_total":sub_total,
                "shipping_charges":shipping_charges,
                "net_total":net_total
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
<?= $this->endSection(); ?>



