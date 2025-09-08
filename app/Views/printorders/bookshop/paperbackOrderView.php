<div id="content" class="main-content">
    <div class="layout-px-spacing">
    <div class="page-header">
        <div class="page-title">
            <h3 class="text-center">POD Bookshop orders</h3>
        </div>
        <div class="col-12 text-right">
            <a target="_blank" href="<?php echo base_url()."pustaka_paperback/bookshop_details"; ?>">
                <button type="button" class="ml-3 mt-3 mb-5 btn btn-outline-secondary btn-lg">Add Bookshop</button>
            </a>
        </div>

    </div>
    <br>
    <form method="post" action="<?php echo base_url(); ?>pustaka_paperback/bookshop_order_books">
        <div class="row">
            <div class="col-6">
                <h5>Books Details</h5>
                <label class="mt-3">Select Bookshop</label>
                <select name="bookshop_id" id="bookshop_id" class="form-control">
                    <?php if (isset($bookshop['bookshoper'])) {
                        for($i=0; $i<count($bookshop['bookshoper']); $i++) { ?>
                            <option value="<?php echo $bookshop['bookshoper'][$i]['bookshop_id'];?>" 
                                data-name="<?php echo $bookshop['bookshoper'][$i]['bookshop_name']; ?>"
                                data-address="<?php echo $bookshop['bookshoper'][$i]['address']; ?>"
                                data-contact-person="<?php echo $bookshop['bookshoper'][$i]['contact_person_name']; ?>"
                                data-contact-mobile="<?php echo $bookshop['bookshoper'][$i]['mobile']; ?>"
                                data-preferred-transport="<?php echo $bookshop['bookshoper'][$i]['preferred_transport']; ?>"
                                data-preferred-transport-name="<?php echo $bookshop['bookshoper'][$i]['preferred_transport_name']; ?>"> 
                                <?php echo $bookshop['bookshoper'][$i]['bookshop_name']; ?>
                            </option>
                        <?php } 
                    } ?>
                    <option value="0" data-name="Other">Other</option>
                </select>
                <br>
                <label for="exampleFormControlTextarea1">Book IDs seperated by comma:</label>
                <textarea class="form-control" id="book_ids" name="book_ids" rows="5" required></textarea>
                <h6 id="book_count" class="form-text text-dark"></h6>
                <label class="mt-3">Default No.of.copies</label>
                <input class="form-control" name="num_copies" id="num_copies" type="number" required/> 
                <label class="mt-3">Default Discount</label>
                <input class="form-control" name="discount" id="discount" type="number" required/>  
               <br>
                <div class="row">
                    <div class="col-5">
                        <label class="mt-3">Shipping Date</label>
                        <input class="form-control" name="ship_date" id="ship_date" type="Date" required/> 
                    </div>
                    <div class="col-3">
                        <label class="mt-3">Payment Type</label>
                        <div class="form-check">
                            <input type="radio" id="account" name="payment_type" class="form-check-input" value="Account" checked required>
                            <label class="form-check-label" for="account">Account</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" id="cash" name="payment_type" class="form-check-input" value="Cash" required>
                            <label class="form-check-label" for="cash">Cash</label>
                        </div>
                    </div>

                    <div class="col-3">
                        <label class="mt-3">Payment Status</label>
                        <div class="form-check">
                            <input type="radio" id="pending" name="payment_status" class="form-check-input" value="Pending" checked required>
                            <label class="form-check-label" for="pending">Pending</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" id="paid" name="payment_status" class="form-check-input" value="Paid" required>
                            <label class="form-check-label" for="paid">Paid</label>
                        </div>
                    </div> 
                </div> 
            </div>
            <div class="col-6">
            <h5>Transport Details</h5>
            <label class="mt-3">Preferred Transport</label>
            <input class="form-control" name="preferred_transport" id="preferred_transport" />
            <label class="mt-3">Preferred Transport Name</label>
            <input class="form-control" name="preferred_transport_name" id="preferred_transport_name" />
            <div class="row">
                <div class="col-5">
                    <label class="mt-3">Transport Payment</label>
                    <div class="radio">
                        <input type="radio" name="transport_payment" id="transport_payment" class="ml-3" value="Paid" checked />
                        <label class="">Paid</label>
                    </div>
                    <div class="radio">
                        <input type="radio" name="transport_payment" id="transport_payment" class="ml-3" value="To Pay" />
                        <label class="">To Pay</label>
                    </div>
                </div>
                 <div class="col-5">
                    <label class="mt-3">Buyer's Order No</label>
                    <input class="form-control" name="vendor_po_order_number" id="vendor_po_order_number" />
                </div>
            </div>
            <label class="mt-3">Billing Address</label>
            <textarea name="billing_address" id="bill_addr" rows="5" class="form-control" readonly style="color: black;"></textarea>

            <label class="mt-3">Shipping Address</label>
            <textarea name="ship_address" id="ship_address" rows="5" class="form-control"></textarea>
        </div>
        <button type="submit" class="ml-3 mt-3 mb-5 btn btn-outline-secondary btn-lg">Next</button>
    </form>
</div>
<script type="text/javascript">
    var base_url = window.location.origin;

    function validateForm() {
        var tmp = document.getElementById('bookshop_id');
        var bookshop_id = tmp.options[tmp.selectedIndex].value;
        var selectedOption = tmp.options[tmp.selectedIndex];
        var selectedAddress = selectedOption.getAttribute('data-address');
        var selectedContact = selectedOption.getAttribute('data-contact-person');
        var selectedMobile = selectedOption.getAttribute('data-contact-mobile');
        var selectedTransport = selectedOption.getAttribute('data-preferred-transport');
        var selectedTransportName = selectedOption.getAttribute('data-preferred-transport-name');

        document.getElementById('bill_addr').value = selectedAddress + '\nContact: ' + selectedContact + '\nMobile: ' + selectedMobile;
        document.getElementById('ship_address').value = selectedAddress + '\nContact: ' + selectedContact + '\nMobile: ' + selectedMobile;

        document.getElementById('preferred_transport').value = selectedTransport
        document.getElementById('preferred_transport_name').value = selectedTransportName

        if (bookshop_id == 0) {
            var customPublisherName = document.getElementById('custom_publisher_name').value;
            if (!customPublisherName) {
                alert("Publisher name required for Custom");
                return false;
            }
        }
    }
    document.getElementById('bookshop_id').addEventListener('change', validateForm);

    document.getElementById('book_ids').addEventListener('keyup', function() {
        var input = this.value;
        var books = input.split(',').filter(function(item) {
            return item.trim() !== '';
        });
        var bookCount = books.length;
        document.getElementById('book_count').innerText = bookCount + ' books';
    });

</script>
