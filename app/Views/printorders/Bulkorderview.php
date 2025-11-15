<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>

<div class="container mt-4">
<h5 class="text-center">Order Creation</h5>

<div class="d-flex justify-content-center mt-3">
    <div class="col-12 col-md-6 col-lg-5">
        <div class="card h-100 shadow">
            <div class="card-body p-4">
                
                <h6 class="mb-4 text-warning-main text-center">
                    Summary Details
                </h6>

                <div class="royalty-summary">
                    <table class="table table-borderless text-center">
                        <tbody>
                            <tr>
                                <td class="fw-bold">Total Titles :</td>
                                <td><?= $totalTitles ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Total Quantity :</td>
                                <td><?= $totalQty ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Total Amount :</td>
                                <td><?= indian_format($totalAmount, 2) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<p class="mt-4">Select order type:</p>

<button class="btn btn-primary me-2" id="offlineBtn">Create Offline Order</button>
<button class="btn btn-warning" id="bookshopBtn">Create Bookshop Order</button>

<br><hr>

<form action="<?= base_url('orders/saveOrder'); ?>" method="POST" id="orderForm">

    <input type="hidden" name="order_type" id="orderType">
   <input type="hidden" name="books" value='<?= json_encode($matchedBooks) ?>'>


    <div id="commonFields" style="display:none;">

        <div class="row">

            <!-- Courier Charge -->
            <div class="col-md-4 mb-3" id="courierChargeBox">
                <label>Courier Charge *</label>
                <input type="number" name="courier_charge" class="form-control">
            </div>

            <!-- Bookshop Dropdown -->
                        <div class="col-md-6 mb-3" id="bookshoperId" style="display:none;">
                <label>Select Bookshop</label>
                <select name="bookshop_id" id="bookshop_id" class="form-control">

                    <?php if (!empty($bookshop['bookshoper'])) {
                        foreach ($bookshop['bookshoper'] as $row) { ?>

                            <option 
                                value="<?= $row['bookshop_id'];?>"
                                data-address="<?= $row['address'];?>"
                                data-contact_person_name="<?= $row['contact_person_name'];?>"
                                data-mobile="<?= $row['mobile'];?>"
                                data-preferred_transport="<?= $row['preferred_transport'];?>"
                                data-preferred_transport_name="<?= $row['preferred_transport_name'];?>"
                            >
                                <?= $row['bookshop_name'];?>
                            </option>


                    <?php } } ?>

                    <!-- <option value="0">Other</option> -->
                </select>
            </div>


            <div class="col-md-4 mb-3">
                <label>Shipping Date *</label>
                <input type="date" name="shipping_date" class="form-control">
            </div>

            <div class="col-md-4 mb-3">
                <label>Payment Type *</label>
                <div style="margin-top:5px; display:flex; flex-wrap:wrap; gap:15px;">
                    <div class="form-check d-flex align-items-center gap-2">
                        <input class="form-check-input" type="radio" name="payment_type" value="Account">
                        <label>Account</label>
                    </div>

                    <div class="form-check d-flex align-items-center gap-2">
                        <input class="form-check-input" type="radio" name="payment_type" value="VPP">
                        <label>VPP</label>
                    </div>

                    <div class="form-check d-flex align-items-center gap-2">
                        <input class="form-check-input" type="radio" name="payment_type" value="UPI">
                        <label>UPI</label>
                    </div>

                    <div class="form-check d-flex align-items-center gap-2">
                        <input class="form-check-input" type="radio" name="payment_type" value="Cash">
                        <label>Cash</label>
                    </div>

                </div>
            </div>

            <div class="col-md-4 mb-3">
                <label>Payment Status *</label>
                <div style="margin-top:5px; display:flex; gap:20px;">
                    <div class="form-check d-flex align-items-center gap-2">
                        <input class="form-check-input" type="radio" name="payment_status" value="Paid">
                        <label>Paid </label>
                    </div>

                    <div class="form-check d-flex align-items-center gap-2">
                        <input class="form-check-input" type="radio" name="payment_status" value="Pending">
                        <label>Pending</label>
                    </div>

                </div>
            </div>

            <div class="col-md-8 mb-3">
                <label>Shipping Address *</label>
                <textarea 
                    name="shipping_address" 
                    class="form-control" 
                    rows="5"
                    placeholder="Enter full shipping address..."
                    style="resize:vertical; padding:10px;"></textarea>
            </div>

            <div class="col-md-4 mb-3">
                <label>Customer Name *</label>
                <input type="text" name="customer_name" class="form-control">
            </div>

            <div class="col-md-4 mb-3">
                <label>City *</label>
                <input type="text" name="city" class="form-control">
            </div>

            <div class="col-md-4 mb-3">
                <label>Mobile No *</label>
                <input type="text" name="mobile" class="form-control">
            </div>

            <!-- Transport Payment -->
            <div class="col-md-4 mb-3" id="transportPaymentBox" style="display:none;">
                <label>Transport Payment *</label>
                <div style="margin-top:5px; display:flex; gap:20px;">
                     <div class="form-check d-flex align-items-center gap-2">
                        <input class="form-check-input" type="radio" name="transport_payment" value="Paid">
                        <label>Paid </label>
                    </div>

                    <div class="form-check d-flex align-items-center gap-2">
                        <input class="form-check-input" type="radio" name="transport_payment" value="To Pay">
                        <label>To Pay</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BOOKSHOP ONLY FIELDS -->
    <div id="bookshopFields" style="display:none;">

        <div class="row"> 
            <div class="col-6 mt-3">
                <label>Billing Address</label>
                <textarea name="billing_address" id="bill_addr" rows="5" class="form-control" readonly></textarea>
            </div>

            <div class="col-md-4 mb-3">
                <label>Buyer’s Number *</label>
                <input type="text" name="buyer_number" class="form-control">
            </div>

            <div class="col-md-4 mb-3">
                <label>Preferred Transport</label>
                <input class="form-control" name="preferred_transport" id="preferred_transport"/>
                             
            </div>

            <div class="col-md-4 mb-3">
                <label>Preferred Transport Name</label>
                <input class="form-control" name="preferred_transport_name" id="preferred_transport_name"/>
            </div>

        </div>

    </div>
    <br>
    <div class="d-flex gap-2 mt-3">
    <div id="submitBtnWrapper" style="display:none;">
        <button id="submitBtn" class="btn btn-success">Submit Order</button>
    </div>

    <div id="cancelBtnWrapper" style="display:none;">
        <a href="<?= base_url('orders/uploadForm'); ?>" class="btn btn-danger">Cancel</a>
    </div>
</div>


</form>

</div>

<?= $this->endSection(); ?>


<?= $this->section('script'); ?>
<script>

// Hide submit/cancel initially
document.getElementById("submitBtnWrapper").style.display = "none";
document.getElementById("cancelBtnWrapper").style.display = "none";


// ----------------------------------
// RESET ALL COMMON + BOOKSHOP FIELDS
// ----------------------------------
function resetAllFields() {
    document.querySelector("#orderForm").reset();

    // clear textareas manually
    document.getElementById("bill_addr").value = "";
    document.querySelector("textarea[name='shipping_address']").value = "";
}


// ----------------------------------
// OFFLINE ORDER CLICK
// ----------------------------------
document.getElementById("offlineBtn").onclick = function () {
    // console.log(document.querySelector("input[name='books']").value);

    resetAllFields();

    document.getElementById("submitBtnWrapper").style.display = "block";
    document.getElementById("submitBtn").textContent = "Offline Order Submit";
    document.getElementById("cancelBtnWrapper").style.display = "block";

    document.getElementById("orderForm").action = "<?= base_url('orders/saveOfflineOrder'); ?>";
    document.getElementById("orderType").value = "offline";

    document.getElementById("commonFields").style.display = "block";
    document.getElementById("bookshopFields").style.display = "none";

    document.getElementById("courierChargeBox").style.display = "block";
    document.getElementById("transportPaymentBox").style.display = "none";
    document.getElementById("bookshoperId").style.display = "none";

    document.querySelector("input[name='buyer_number']").required = false;
   document.querySelector("input[name='preferred_transport_name']").required = false;

    addRequiredToCommon(true);
};


// ----------------------------------
// BOOKSHOP ORDER CLICK
// ----------------------------------
document.getElementById("bookshopBtn").onclick = function () {

    // console.log(document.querySelector("input[name='books']").value);

    resetAllFields();

    document.getElementById("submitBtnWrapper").style.display = "block";
    document.getElementById("submitBtn").textContent = "Bookshop Order Submit";
    document.getElementById("cancelBtnWrapper").style.display = "block";

    document.getElementById("orderForm").action = "<?= base_url('orders/saveBookshopOrder'); ?>";
    document.getElementById("orderType").value = "bookshop";

    document.getElementById("commonFields").style.display = "block";
    document.getElementById("bookshopFields").style.display = "block";

    document.getElementById("courierChargeBox").style.display = "none";
    document.getElementById("transportPaymentBox").style.display = "block";
    document.getElementById("bookshoperId").style.display = "block";

    // REQUIRED FIELDS
    document.querySelector("input[name='buyer_number']").required = false;
    document.querySelector("input[name='preferred_transport_name']").required = true;

    addRequiredToCommon(true);
};



// ----------------------------------
// BOOKSHOP SELECT CHANGE
// ----------------------------------
document.getElementById("bookshop_id").addEventListener("change", function () {

    if (this.value == "0") {
        clearBookshopFields();
        return;
    }

    autoFillBookshop(this.options[this.selectedIndex]);
});


// ----------------------------------
// AUTO-FILL FIELDS
// ----------------------------------
function autoFillBookshop(opt) {

    let address  = opt.dataset.address || "";
    let name     = opt.dataset.contact_person_name || "";
    let mobile   = opt.dataset.mobile || "";
    let preferred_transport = opt.dataset.preferred_transport|| "";
    let preferred_transport_name = opt.dataset.preferred_transport_name || "";

    document.querySelector("textarea[name='shipping_address']").value = address;
    document.querySelector("input[name='customer_name']").value = name;
    document.querySelector("input[name='mobile']").value = mobile;
    document.querySelector("input[name='preferred_transport']").value = preferred_transport;
    document.querySelector("input[name='preferred_transport_name']").value = preferred_transport_name;


    document.getElementById("bill_addr").value = address;
}

// Clear bookshop fields
function clearBookshopFields() {
    document.querySelector("textarea[name='shipping_address']").value = "";
    document.querySelector("input[name='customer_name']").value = "";
    document.querySelector("input[name='mobile']").value = "";
    document.querySelector("input[name='transport_name']").value = "";
    document.getElementById("transport").value = "";
    document.getElementById("bill_addr").value = "";
}


// ----------------------------------
// ADD REQUIRED TO COMMON FIELDS
// ----------------------------------
function addRequiredToCommon(status) {
    let fields = [
        "shipping_date", "payment_type",
        "payment_status", "shipping_address", "customer_name",
        "city", "mobile"
    ];
    fields.forEach(f => {
        let el = document.querySelector("[name='" + f + "']");
        if (el) el.required = status;
    });
}

</script>
<?= $this->endSection(); ?>
