<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

    <div class="layout-px-spacing">
    <div class="page-header">
        <div class="page-title">
            <h6>Create New PoD Order</h6>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <h6 class="mt-3">Book Details</h6>
            <label class="mt-3">Select Publisher</label>
            <select name="publisher_id" id="publisher_id" class="form-control">
                <?php if (isset($publisher_list['publisher']))
                {
                    for($i=0; $i<count($publisher_list['publisher']); $i++)
                    {
                        ?>
                        <option value="<?php echo $publisher_list['publisher'][$i]['id'];?>" 
                            data-name="<?php echo $publisher_list['publisher'][$i]['publisher_name']; ?>"
                            data-address="<?php echo $publisher_list['publisher'][$i]['address']; ?>"
                            data-city="<?php echo $publisher_list['publisher'][$i]['city']; ?>"
                            data-contact_person="<?php echo $publisher_list['publisher'][$i]['contact_person']; ?>"
                            data-contact_mobile="<?php echo $publisher_list['publisher'][$i]['contact_mobile'];?>"> 
                        
                        <?php echo $publisher_list['publisher'][$i]['publisher_name']; ?></option>
                <?php } } ?>
                <option value="0" data-name="Other">Other</option>
            </select>

            <label class="mt-3">Publisher/Customer Name (Optional - only if Other is selected)</label>
            <input class="form-control" name="custom_publisher_name" id="custom_publisher_name" />
            <label class="mt-3">Publisher Order/Reference No.</label>
            <input class="form-control" name="publisher_reference" id="publisher_reference" />
            <label class="mt-3">Book Title</label>
            <input class="form-control" name="book_title" id="book_title" />
            <label class="mt-3">Number of Pages</label>
            <input class="form-control" name="num_pages" onInput="populate_quotation_data()" id="num_pages" required />
            <label class="mt-3">Number of Copies</label>
            <input class="form-control" name="num_copies" onInput="populate_quotation_data()" id="num_copies" />
            <h6 class="mt-3">Book Specifications</h6>
        
            <div class="row">
                <div class="col-6">
                    <label class="mt-1">Book Size</label>
                    <select name="book_size" id="book_size" class="mt-1 form-control">
                        <option value="Demy" data-name="Demy">Demy</option>
                        <option value="A4" data-name="Demy">A4</option>
                        <option value="A5" data-name="Demy">A5</option>
                        <option value="Custom" data-name="Demy">Custom</option>
                    </select>
                </div>
                <div class="col-6">
                    <label class="mt-1">Custom Size</label>
                    <input class="mt-1 form-control" name="custom_book_size" placeholder="Only for Custom Size" id="custom_book_size" />
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <label class="mt-3">Cover Paper Type</label>
                    <select name="cover_paper" id="cover_paper" class="form-control">
                        <option value="Art" data-name="Demy">Art</option>
                        <option value="Texture" data-name="Texture">Texture</option>
                        <option value="Custom" data-name="Custom">Custom</option>
                    </select>
                </div>
                <div class="col-6">
                    <label class="mt-3">Custom Type</label>
                    <input class="form-control" name="custom_cover_paper" placeholder="Only for Custom Type" id="custom_cover_paper" />
                </div>
            </div>
            <label class="mt-3">Cover GSM</label>
            <select name="cover_gsm" id="cover_gsm" class="form-control">
                <option value="300 GSM" data-name="300gsm">300 GSM</option>
                <option value="250 GSM" data-name="250gsm">250 GSM</option>
                <option value="170 GSM" data-name="170gsm">170 GSM</option>
                <option value="130 GSM" data-name="130gsm">130 GSM</option>
            </select>
            <div class="row">
                <div class="col-6">
                    <label class="mt-3">Content Paper Type</label>
                    <select name="content_paper" id="content_paper" class="form-control">
                        <option value="NS Maplitho" data-name="NS Maplitho">NS Maplitho</option>
                        <option value="Book Print" data-name="Book Print">Book Print</option>
                        <option value="Stora" data-name="Stora">Stora</option>
                        <option value="Index" data-name="Index">Index</option>
                        <option value="Art" data-name="Art">Art</option>
                        <option value="Custom" data-name="Custom">Custom</option>
                    </select>
                </div>
                <div class="col-6">
                    <label class="mt-3">Custom Type</label>
                    <input class="form-control" name="custom_content_paper" placeholder="Only for Custom Type" id="custom_content_paper" />
                </div>
            </div>
            <label class="mt-3">Content GSM</label>
            <select name="content_gsm" id="content_gsm" class="form-control">
                <option value="70 GSM" data-name="70gsm">70 GSM</option>
                <option value="80 GSM" data-name="80gsm">80 GSM</option>
                <option value="65 GSM" data-name="65gsm">65 GSM</option>
                <option value="130 GSM" data-name="130gsm">130 GSM</option>
            </select>

                <label class="mt-3 fw-bold text-secondary">Content in colour?</label>
                <div class="d-flex align-items-center flex-wrap gap-3 mt-2">
                    <div class="form-check checked-primary d-flex align-items-center gap-2">
                        <input class="form-check-input" type="radio" name="content_colour" id="content_colour_no" value="N" checked>
                        <label class="form-check-label fw-medium text-secondary-light" for="content_colour_no">No</label>
                    </div>
                    <div class="form-check checked-success d-flex align-items-center gap-2">
                        <input class="form-check-input" type="radio" name="content_colour" id="content_colour_yes" value="Y">
                        <label class="form-check-label fw-medium text-secondary-light" for="content_colour_yes">Yes</label>
                    </div>
                </div>

                <label class="mt-3 fw-bold text-secondary">Lamination</label>
                <select name="lamination" id="lamination" class="form-control mt-1">
                    <option value="Matt">Matt</option>
                    <option value="Glossy">Glossy</option>
                    <option value="Velvet">Velvet</option>
                </select>

                <label class="mt-3 fw-bold text-secondary">Binding Type</label>
                <div class="d-flex align-items-center flex-wrap gap-3 mt-2">
                    <div class="form-check checked-primary d-flex align-items-center gap-2">
                        <input class="form-check-input" type="radio" name="binding" id="binding_perfect" value="Perfect" checked>
                        <label class="form-check-label fw-medium text-secondary-light" for="binding_perfect">Perfect</label>
                    </div>
                    <div class="form-check checked-warning d-flex align-items-center gap-2">
                        <input class="form-check-input" type="radio" name="binding" id="binding_stapler" value="Stapler">
                        <label class="form-check-label fw-medium text-secondary-light" for="binding_stapler">Stapler</label>
                    </div>
                </div>
                    </div>
    
        <div class="col-6">
        <h6 class="mt-3">Quotation Details</h6>
        <div class="row">
            <div class="col-4">
                <label class="mt-4">#Pages</label>
                <input class="form-control" name="num_pages_quote" onInput="fill_quotation_data()" id="num_pages_quote" />
            </div>
            <div class="col-4">
                <label class="mt-4">Cost/Page</label>
                <input class="form-control" name="cost_per_page" onInput="fill_quotation_data()" id="cost_per_page" />
            </div>
            <div class="col-4">
                <label class="mt-4">#Pages x Cost/Book</label>
                <input class="form-control" name="content_cost" id="content_cost" readonly />
            </div>
        </div>
        <span style="font-size: 15px;">Price: <=50 - 0.55, 50 to 75 - 0.5, 76 to 100 - 0.45, 101 to 150 - 0.41, >150 - 0.38</span>
        <label class="mt-4">Fixed Charge/Book</label>
        <input class="form-control" name="fixed_charge" onInput="fill_quotation_data()" id="fixed_charge" />

        <div class="row">
            <div class="col-4">
                <label class="mt-4">#Pages</label>
                <input class="form-control" name="num_pages_quote1" onInput="fill_quotation_data()" id="num_pages_quote1" />
            </div>
            <div class="col-4">
                <label class="mt-4">Cost/Page</label>
                <input class="form-control" name="cost_per_page1" onInput="fill_quotation_data()" id="cost_per_page1" />
            </div>
            <div class="col-4">
                <label class="mt-4">#Pages x Cost/Book</label>
                <input class="form-control" name="content_cost1" id="content_cost1" readonly />
            </div>
        </div>
        <span style="font-size: 15px;">Use the above if partial content pages has different cost</span>        
        <div class="row">
            <div class="col-4">
                <label class="mt-4">Cost/Book</label>
                <input class="form-control" name="cost_per_book" id="cost_per_book" readonly />
            </div>
            <div class="col-4">
                <label class="mt-4">#Copies</label>
                <input class="form-control" name="num_copies_quote" id="num_copies_quote" readonly />
            </div>
            <div class="col-4">
                <label class="mt-4">Total Book Cost</label>
                <input class="form-control" name="total_book_cost" id="total_book_cost" readonly />
            </div>
        </div>
        <label class="mt-3">Transport Charges (Optional)</label>
        <input class="form-control" name="transport_charges" id="transport_charges" />
        <label class="mt-3">Design Charges (One time)</label>
        <input class="form-control" name="design_charges" id="design_charges" />
        <label class="mt-3">Content Location</label>
        <input class="form-control" name="content_location" id="content_location" />
        <label class="mt-3">Delivery Date</label>
        <input type="date" id="delivery_date" name="delivery_date"><br>
        <label class="mt-3">Remarks</label>
        <textarea name="" id="remarks" rows="5" class="form-control" placeholder="Add any other remarks here..."></textarea>
        <!-- Display this for Billing Address -->
        <label class="mt-3">Billing Address</label>
        <textarea name="" id="bill_addr" rows="5" class="form-control" readonly style="color: black;">
        </textarea>
        <label class="mt-3">Shipping Address</label>
        <textarea name="" id="ship_address" rows="5" class="form-control">
        </textarea>
    </div>
</div>
<div class="d-flex justify-content-between mt-3">
    <a href="javascript:void(0)" onclick="add_publisher_book()" class="btn rounded-pill btn-success-600 radius-6 px-16 py-11">
        Submit
    </a>
    <a href="javascript:history.back()" class="btn rounded-pill btn-secondary radius-6 px-16 py-11">
        Back
    </a>
</div>

<script type="text/javascript">
    var base_url = window.location.origin;

    function validateForm() {
        var tmp = document.getElementById('publisher_id');
        var publisher_id = tmp.options[tmp.selectedIndex].value;
        var selectedOption = document.getElementById('publisher_id').options[document.getElementById('publisher_id').selectedIndex];
        var selectedId = selectedOption.value;
        var selectedAddress = selectedOption.getAttribute('data-address');
        var selectedcity = selectedOption.getAttribute('data-city');
        var selectedcontact = selectedOption.getAttribute('data-contact_person');
        var selectedmobile = selectedOption.getAttribute('data-contact_mobile');
            
        document.getElementById('bill_addr').value = selectedAddress + '\nCity: ' + selectedcity +'\nContact: '+selectedcontact+'\nMobile: '+selectedmobile;
        document.getElementById('ship_address').value = selectedAddress + '\nCity: ' + selectedcity +'\nContact: '+selectedcontact+'\nMobile: '+selectedmobile;
        
        if (publisher_id == 0){
            var custom_publisher_name = document.getElementById('custom_publisher_name').value;
            if (!custom_publisher_name)
                alert("Publisher name required for Custom");
                return false;
        }
    }
    document.getElementById('publisher_id').addEventListener('change', validateForm);

    // Storing all values from form into variables
    function add_publisher_book() {
    var tmp = document.getElementById('publisher_id');
    var publisher_id = tmp.options[tmp.selectedIndex].value;
    var custom_publisher_name = (publisher_id == 0)
        ? document.getElementById('custom_publisher_name').value
        : "None";

    var publisher_reference = document.getElementById('publisher_reference').value;            
    var title = document.getElementById('book_title').value;
    var num_pages = document.getElementById('num_pages').value;
    var num_copies = document.getElementById('num_copies').value;

    var tmp = document.getElementById('book_size');
    var book_size = tmp.options[tmp.selectedIndex].value;
    if (book_size == "Custom")
        book_size = document.getElementById('custom_book_size').value;

    var tmp = document.getElementById('cover_paper');
    var cover_paper = tmp.options[tmp.selectedIndex].value;
    if (cover_paper == "Custom")
        cover_paper = document.getElementById('custom_cover_paper').value;

    var tmp = document.getElementById('cover_gsm');
    var cover_gsm = tmp.options[tmp.selectedIndex].value;

    var tmp = document.getElementById('content_paper');
    var content_paper = tmp.options[tmp.selectedIndex].value;
    if (content_paper == "Custom")
        content_paper = document.getElementById('custom_content_paper').value;

    var tmp = document.getElementById('content_gsm');
    var content_gsm = tmp.options[tmp.selectedIndex].value;

    var content_colour_radios = document.getElementsByName('content_colour');
    var content_colour = '';
    for (var i = 0; i < content_colour_radios.length; i++) {
        if (content_colour_radios[i].checked) {
            content_colour = content_colour_radios[i].value;
            break;
        }
    }
    var lamination = document.getElementById('lamination').value;
    var binding_radios = document.getElementsByName('binding');
    var binding = '';
    for (var i = 0; i < binding_radios.length; i++) {
        if (binding_radios[i].checked) {
            binding = binding_radios[i].value;
            break;
        }
    }

    var num_pages_quote = document.getElementById('num_pages_quote').value;
    var cost_per_page = document.getElementById('cost_per_page').value;
    var num_pages_quote1 = document.getElementById('num_pages_quote1').value || 0;
    var cost_per_page1 = document.getElementById('cost_per_page1').value || 0;
    var fixed_charge = document.getElementById('fixed_charge').value || 0;
    var transport_charges = document.getElementById('transport_charges').value || 0;
    var design_charges = document.getElementById('design_charges').value || 0;
    var content_location = document.getElementById('content_location').value;
    var delivery_date = document.getElementById('delivery_date').value;
    var remarks = document.getElementById('remarks').value;
    var ship_address = document.getElementById('ship_address').value;

    // 🧩 AJAX CALL
    $.ajax({
        url: base_url + '/pod/podbookpost',
        type: 'POST',
        data: {
            "publisher_id": publisher_id,
            "custom_publisher_name": custom_publisher_name,
            "publisher_reference": publisher_reference,
            "book_title": title,
            "total_num_pages": num_pages,
            "num_copies": num_copies,
            "book_size": book_size,
            "cover_paper": cover_paper,
            "cover_gsm": cover_gsm,
            "content_paper": content_paper,
            "content_gsm": content_gsm,
            "content_colour": content_colour,
            "lamination_type": lamination,
            "binding_type": binding,
            "content_location": content_location,
            "num_pages_quote1": num_pages_quote,
            "cost_per_page1": cost_per_page,
            "num_pages_quote2": num_pages_quote1,
            "cost_per_page2": cost_per_page1,
            "fixed_charge_book": fixed_charge,
            "delivery_date": delivery_date,
            "transport_charges": transport_charges,
            "design_charges": design_charges,
            "remarks": remarks,
            "ship_address": ship_address
        },
        success: function(data) {
            if (data == 1) {
                alert("✅ Successfully added book!");
            } else {
                alert("❌ Book not added! Please check your details.");
            }
        },
        error: function() {
            alert("⚠️ Error connecting to the server. Try again later.");
        }
    });
}

    function fill_quotation_data() {
        var num_pages = document.getElementById('num_pages_quote').value;
        var num_copies = document.getElementById('num_copies_quote').value;
        var cost_per_page = document.getElementById('cost_per_page').value;
        var fixed_charge = document.getElementById('fixed_charge').value;
        var num_pages1 = document.getElementById('num_pages_quote1').value;
        var cost_per_page1 = document.getElementById('cost_per_page1').value;

        var tmp = cost_per_page * num_pages;
        document.getElementById('content_cost').value = tmp;
        var tmp1 = cost_per_page1 * num_pages1;
        document.getElementById('content_cost1').value = tmp1;
        var cost_per_book = Number(tmp) + Number(tmp1) + Number(fixed_charge);
        document.getElementById('cost_per_book').value = cost_per_book;
        var total_cost = cost_per_book * num_copies;
        document.getElementById('total_book_cost').value = total_cost;
    }

    function populate_quotation_data() {
        var num_pages = document.getElementById('num_pages').value;
        var num_copies = document.getElementById('num_copies').value;
        document.getElementById('num_pages_quote').value = num_pages;
        document.getElementById('num_copies_quote').value = num_copies;
        if (num_pages >= 50 && num_pages <=75)
            document.getElementById('cost_per_page').value = 0.5;
        if (num_pages >= 76 && num_pages <=100)
            document.getElementById('cost_per_page').value = 0.45;
        if (num_pages >= 101 && num_pages <=150)
            document.getElementById('cost_per_page').value = 0.41;
        if (num_pages >= 101 && num_pages >=151)
            document.getElementById('cost_per_page').value = 0.38;
        var cost_per_page = document.getElementById('cost_per_page').value;            
        var tmp = cost_per_page * num_pages;
        document.getElementById('content_cost').value = tmp;
        var cost_per_book = Number(tmp);
        document.getElementById('cost_per_book').value = cost_per_book;
        var total_cost = cost_per_book * num_copies;
        document.getElementById('total_book_cost').value = total_cost;

    }
</script>
<?= $this->endSection(); ?>