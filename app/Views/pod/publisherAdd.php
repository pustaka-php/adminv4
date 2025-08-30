<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>
<div class="layout-px-spacing">
    <div class="row">
        <div class="col-6">
            <h6 class="mt-3">Publisher Details</h6>
            <label class="mt-3">Publisher Name</label>
            <input class="form-control" name="publisher_name" id="publisher_name" />
            <label class="mt-3">Publisher Address</label>
            <textarea id="address" rows="5" class="form-control" placeholder="Full Postal Address (without city)"></textarea>
            <label class="mt-3">City</label>
            <input class="form-control" name="publisher_city" id="publisher_city" />
            <label class="mt-3">Contact Person</label>
            <input class="form-control" name="publisher_contact" id="publisher_contact" />
            <label class="mt-3">Contact Mobile</label>
            <input class="form-control" name="publisher_mobile" id="publisher_mobile" />
            <label class="mt-3">Preferred Transport</label>
            <input class="form-control" name="preferred_transport" id="preferred_transport" />
        </div>

        <div class="col-6">
            <h6 class="mt-3">Generic instructions</h6>
            <label class="mt-3">Cover</label>
            <textarea id="cover_reqs" rows="5" class="form-control" placeholder="Any specific comments for covers in general goes here..."></textarea>
            <label class="mt-3">Content</label>
            <textarea id="content_reqs" rows="5" class="form-control" placeholder="Any specific comments for contents in general goes here..."></textarea>
            <label class="mt-3">Other Requirements</label>
            <textarea id="other_reqs" rows="5" class="form-control" placeholder="Any other comments about the publisher requirements goes here..."></textarea>
            <label class="mt-3">Rejection Remarks</label>
            <textarea id="rejection_remarks" rows="5" class="form-control" placeholder="Reasons for rejections. (Should be updated regularly)..."></textarea>
        </div>
    </div>    

    <a href="javascript:void(0)" onclick="add_publisher()" class="ml-3 mt-3 mb-5 btn btn-outline-info btn-lg">Submit</a>
    <a href="javascript:void(0)" onclick="clear_form()" class="ml-3 mt-3 mb-5 btn btn-outline-danger btn-lg">Clear</a>
</div>

<script type="text/javascript">
    var base_url = "<?= base_url(); ?>";

    function add_publisher() {
        // Collect values
        var publisher_name      = $('#publisher_name').val().trim();
        var address             = $('#address').val().trim();
        var publisher_city      = $('#publisher_city').val().trim();
        var publisher_contact   = $('#publisher_contact').val().trim();
        var publisher_mobile    = $('#publisher_mobile').val().trim();
        var preferred_transport = $('#preferred_transport').val().trim();
        var cover_reqs          = $('#cover_reqs').val().trim();
        var content_reqs        = $('#content_reqs').val().trim();
        var other_reqs          = $('#other_reqs').val().trim();
        var rejection_remarks   = $('#rejection_remarks').val().trim();

        // Validation (required fields)
        if (publisher_name === '' || address === '' || publisher_city === '' || publisher_contact === '' || publisher_mobile === '') {
            alert(" Please fill in all required fields:\n\n- Publisher Name\n- Address\n- City\n- Contact Person\n- Contact Mobile");
            return false; // stop here
        }

        // Optional: Validate mobile number
        var mobileRegex = /^[0-9]{10}$/;
        if (!mobileRegex.test(publisher_mobile)) {
            alert("Please enter a valid 10-digit mobile number.");
            return false;
        }

        // Proceed with AJAX
        $.ajax({
            url: base_url + 'pod/publishersubmit',
            type: 'POST',
            dataType: 'json',
            data: {
                publisher_name: publisher_name,
                address: address,
                publisher_city: publisher_city,
                publisher_contact: publisher_contact,
                publisher_mobile: publisher_mobile,
                preferred_transport: preferred_transport,
                cover_reqs: cover_reqs,
                content_reqs: content_reqs,
                other_reqs: other_reqs,
                rejection_remarks: rejection_remarks
            },
            success: function(response) {
                if (response.status === 'success') {
                    alert(" Successfully added publisher");
                    window.location.href = base_url + 'pod/publisherdashboard';
                } else {
                    alert("Publisher not added! Please try again.");
                }
            },
            error: function(xhr, status, error) {
                alert("⚠️ Error: " + error);
            }
        });
    }

    function clear_form() {
        $("input.form-control, textarea.form-control").val('');
    }
</script>



<?= $this->endSection(); ?>
