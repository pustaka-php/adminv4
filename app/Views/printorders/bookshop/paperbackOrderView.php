<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h6 class="text-center">POD Bookshop Orders</h6>
            </div>
            <div class="col-12" style="text-align: right;">
                <a target="_blank" href="<?php echo base_url()."paperback/bookshopdetails"; ?>">
                    <button type="button" class="btn btn-lilac-600 radius-8 px-20 py-11">Add Bookshop</button>
                </a>
            </div>
        </div>
        <br>

        <!-- Form Wizard Start -->
        <div class="card">
            <div class="card-body">
                <div class="form-wizard">
                    <form method="post" action="<?php echo base_url(); ?>paperback/bookshoporderbooks">
                        <div class="form-wizard-header overflow-x-auto scroll-sm pb-8 my-32">
                            <ul class="list-unstyled form-wizard-list style-two">
                                <li class="form-wizard-list__item active">
                                    <div class="form-wizard-list__line"><span class="count">1</span></div>
                                    <span class="text text-xs fw-semibold">Order Details</span>
                                </li>
                                <li class="form-wizard-list__item">
                                    <div class="form-wizard-list__line"><span class="count">2</span></div>
                                    <span class="text text-xs fw-semibold">Shipping & Payment</span>
                                </li>
                                <li class="form-wizard-list__item">
                                    <div class="form-wizard-list__line"><span class="count">3</span></div>
                                    <span class="text text-xs fw-semibold">Transport & Address</span>
                                </li>
                                <li class="form-wizard-list__item">
                                    <div class="form-wizard-list__line"><span class="count">4</span></div>
                                    <span class="text text-xs fw-semibold">Confirm</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Step 1 -->
                        <fieldset class="wizard-fieldset show">
                            <h6 class="text-md text-neutral-500">Order Details</h6>
                            <div class="row">
                                <div class="col-12">
                                    <label>Select Bookshop</label>
                                    <select name="bookshop_id" id="bookshop_id" class="form-control wizard-required">
                                        <?php if (isset($bookshop['bookshoper'])) {
                                            foreach ($bookshop['bookshoper'] as $row) { ?>
                                                <option value="<?= $row['bookshop_id'];?>"
                                                    data-address="<?= $row['address'];?>"
                                                    data-contact-person="<?= $row['contact_person_name'];?>"
                                                    data-contact-mobile="<?= $row['mobile'];?>"
                                                    data-preferred-transport="<?= $row['preferred_transport'];?>"
                                                    data-preferred-transport-name="<?= $row['preferred_transport_name'];?>">
                                                    <?= $row['bookshop_name'];?>
                                                </option>
                                        <?php } } ?>
                                        <option value="0" data-name="Other">Other</option>
                                    </select>
                                </div>
                                <div class="col-12 mt-3">
                                    <label>Book IDs (comma separated)</label>
                                    <textarea class="form-control wizard-required" id="book_ids" name="book_ids" rows="5"></textarea>
                                    <h6 id="book_count" class="form-text text-dark"></h6>
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <label>Default No. of Copies</label>
                                    <input class="form-control wizard-required" name="num_copies" id="num_copies" type="number"/> 
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <label>Default Discount</label>
                                    <input class="form-control wizard-required" name="discount" id="discount" type="number"/>  
                                </div>
                                <div class="form-group text-end mt-3">
                                    <button type="button" class="form-wizard-next-btn btn btn-primary-600 px-32">Next</button>
                                </div>
                            </div>
                        </fieldset>

                        <!-- Step 2 -->
                        <fieldset class="wizard-fieldset">
                            <h6 class="text-md text-neutral-500">Shipping & Payment</h6>
                            <div class="row">
                                <div class="col-sm-6 mt-3">
                                    <label>Shipping Date</label>
                                    <input class="form-control wizard-required" name="ship_date" id="ship_date" type="date"/> 
                                </div>
                                <div class="col-sm-3 mt-3">
                                    <label>Payment Type</label>
                                    <div class="form-check">
                                        <input type="radio" id="account" name="payment_type" class="form-check-input" value="Account" checked>
                                        <label class="form-check-label" for="account">Account</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" id="cash" name="payment_type" class="form-check-input" value="Cash">
                                        <label class="form-check-label" for="cash">Cash</label>
                                    </div>
                                </div>
                                <div class="col-sm-3 mt-3">
                                    <label>Payment Status</label>
                                    <div class="form-check">
                                        <input type="radio" id="pending" name="payment_status" class="form-check-input" value="Pending" checked>
                                        <label class="form-check-label" for="pending">Pending</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" id="paid" name="payment_status" class="form-check-input" value="Paid">
                                        <label class="form-check-label" for="paid">Paid</label>
                                    </div>
                                </div>
                                <div class="form-group d-flex align-items-center justify-content-end gap-8 mt-3">
                                    <button type="button" class="form-wizard-previous-btn btn btn-neutral-500 border-neutral-100 px-32">Back</button>
                                    <button type="button" class="form-wizard-next-btn btn btn-primary-600 px-32">Next</button>
                                </div>
                            </div>
                        </fieldset>

                        <!-- Step 3 -->
                        <fieldset class="wizard-fieldset">
                            <h6 class="text-md text-neutral-500">Transport & Address</h6>
                            <div class="row">
                                <div class="col-sm-6 mt-3">
                                    <label>Preferred Transport</label>
                                    <input class="form-control" name="preferred_transport" id="preferred_transport"/>
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <label>Preferred Transport Name</label>
                                    <input class="form-control" name="preferred_transport_name" id="preferred_transport_name"/>
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <label class="form-label d-block">Transport Payment <span class="text-danger">*</span></label>
                                    <div class="form-check">
                                        <input type="radio" name="transport_payment" id="paid" class="form-check-input wizard-required" value="Paid" checked>
                                        <label for="paid" class="form-check-label">Paid</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" name="transport_payment" id="to_pay" class="form-check-input wizard-required" value="To Pay">
                                        <label for="to_pay" class="form-check-label">To Pay</label>
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <label>Buyer's Order No</label>
                                    <input class="form-control" name="vendor_po_order_number" id="vendor_po_order_number"/>
                                </div>
                                <div class="col-12 mt-3">
                                    <label>Billing Address</label>
                                    <textarea name="billing_address" id="bill_addr" rows="4" class="form-control" readonly style="color:black;"></textarea>
                                </div>
                                <div class="col-12 mt-3">
                                    <label>Shipping Address</label>
                                    <textarea name="ship_address" id="ship_address" rows="4" class="form-control"></textarea>
                                </div>
                                <div class="form-group d-flex align-items-center justify-content-end gap-8 mt-3">
                                    <button type="button" class="form-wizard-previous-btn btn btn-neutral-500 border-neutral-100 px-32">Back</button>
                                    <button type="button" class="form-wizard-next-btn btn btn-primary-600 px-32">Next</button>
                                </div>
                            </div>
                        </fieldset>

                        <!-- Step 4 -->
                        <fieldset class="wizard-fieldset">
                            <div class="text-center mb-40">
                                <img src="<?= base_url('assets/images/gif/success-img3.gif') ?>" alt="" class="gif-image mb-24">
                                <h6 class="text-md text-neutral-600">Review & Confirm</h6>
                                <p class="text-neutral-400 text-sm mb-0">Check your details and submit the order.</p>
                            </div>
                            <div class="form-group d-flex align-items-center justify-content-end gap-8">
                                <button type="button" class="form-wizard-previous-btn btn btn-neutral-500 border-neutral-100 px-32">Back</button>
                                <button type="submit" class="form-wizard-submit btn btn-primary-600 px-32">Submit Order</button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <!-- Form Wizard End -->
    </div>
</div>

<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script type="text/javascript">
    // =============================== Bookshop Select Validation + Book Count ================================
    function validateForm() {
        var tmp = document.getElementById('bookshop_id');
        var selectedOption = tmp.options[tmp.selectedIndex];

        var selectedAddress = selectedOption.dataset.address || '';
        var selectedContact = selectedOption.dataset.contactPerson || '';
        var selectedMobile = selectedOption.dataset.contactMobile || '';
        var selectedTransport = selectedOption.dataset.preferredTransport || '';
        var selectedTransportName = selectedOption.dataset.preferredTransportName || '';

        document.getElementById('bill_addr').value = selectedAddress + '\nContact: ' + selectedContact + '\nMobile: ' + selectedMobile;
        document.getElementById('ship_address').value = selectedAddress + '\nContact: ' + selectedContact + '\nMobile: ' + selectedMobile;
        document.getElementById('preferred_transport').value = selectedTransport;
        document.getElementById('preferred_transport_name').value = selectedTransportName;
    }
    document.getElementById('bookshop_id').addEventListener('change', validateForm);
    window.addEventListener('DOMContentLoaded', validateForm);

    document.getElementById('book_ids').addEventListener('keyup', function() {
        var input = this.value;
        var books = input.split(',').filter(function(item) {
            return item.trim() !== '';
        });
        document.getElementById('book_count').innerText = books.length + ' books';
    });

    // =============================== Wizard Step Js Start ================================
    $(document).ready(function() {
        $(".form-wizard-next-btn").on("click", function() {
            var parentFieldset = $(this).parents(".wizard-fieldset");
            var currentActiveStep = $(this).parents(".form-wizard").find(".form-wizard-list .active");
            var next = $(this);
            var nextWizardStep = true;

            parentFieldset.find(".wizard-required").each(function(){
                var thisValue = $(this).val();
                if(thisValue == "") {
                    $(this).siblings(".wizard-form-error").show();
                    nextWizardStep = false;
                } else {
                    $(this).siblings(".wizard-form-error").hide();
                }
            });

            if(nextWizardStep) {
                next.parents(".wizard-fieldset").removeClass("show","400");
                currentActiveStep.removeClass("active").addClass("activated").next().addClass("active","400");
                next.parents(".wizard-fieldset").next(".wizard-fieldset").addClass("show","400");
            }
        });

        $(".form-wizard-previous-btn").on("click",function() {
            var prev = $(this);
            var currentActiveStep = $(this).parents(".form-wizard").find(".form-wizard-list .active");
            prev.parents(".wizard-fieldset").removeClass("show","400");
            prev.parents(".wizard-fieldset").prev(".wizard-fieldset").addClass("show","400");
            currentActiveStep.removeClass("active").prev().removeClass("activated").addClass("active","400");
        });

        $(document).on("click",".form-wizard .form-wizard-submit", function(){
            var parentFieldset = $(this).parents(".wizard-fieldset");
            parentFieldset.find(".wizard-required").each(function() {
                var thisValue = $(this).val();
                if(thisValue == "" ) {
                    $(this).siblings(".wizard-form-error").show();
                } else {
                    $(this).siblings(".wizard-form-error").hide();
                }
            });
        });
    });
    // =============================== Wizard Step Js End ================================
</script>
<?= $this->endSection(); ?>
