<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="layout-px-spacing">
    <div class="row">
        <!-- Left Column -->
        <div class="col-md-6">
            <input type="hidden" id="publisher_id" value="<?= esc($publisher['id']) ?>">

            <label class="mt-3">Publisher Name <span class="text-danger">*</span></label>
            <input class="form-control" name="publisher_name" id="publisher_name" 
                   value="<?= esc($publisher['publisher_name']) ?>" />

            <label class="mt-3">Publisher Address <span class="text-danger">*</span></label>
            <textarea id="address" rows="5" class="form-control"><?= esc($publisher['address']) ?></textarea>

            <label class="mt-3">City <span class="text-danger">*</span></label>
            <input class="form-control" name="publisher_city" id="publisher_city" 
                   value="<?= esc($publisher['city']) ?>" />

            <label class="mt-3">Contact Person <span class="text-danger">*</span></label>
            <input class="form-control" name="publisher_contact" id="publisher_contact" 
                   value="<?= esc($publisher['contact_person']) ?>" />

            <label class="mt-3">Contact Mobile <span class="text-danger">*</span></label>
            <input class="form-control" name="publisher_mobile" id="publisher_mobile" 
                   value="<?= esc($publisher['contact_mobile']) ?>" />

            <label class="mt-3">Preferred Transport</label>
            <input class="form-control" name="preferred_transport" id="preferred_transport" 
                   value="<?= esc($publisher['preferred_transport']) ?>" />
        </div>

        <!-- Right Column -->
        <div class="col-md-6">
            <h6 class="mt-3">Generic Instructions</h6>

            <label class="mt-3">Cover</label>
            <textarea id="cover_reqs" rows="5" class="form-control"><?= esc($publisher['cover_reqs']) ?></textarea>

            <label class="mt-3">Content</label>
            <textarea id="content_reqs" rows="5" class="form-control"><?= esc($publisher['content_reqs']) ?></textarea>

            <label class="mt-3">Other Requirements</label>
            <textarea id="other_reqs" rows="5" class="form-control"><?= esc($publisher['other_reqs']) ?></textarea>

            <label class="mt-3">Rejection Remarks</label>
            <textarea id="rejection_remarks" rows="5" class="form-control"><?= esc($publisher['rejection_remarks']) ?></textarea>
        </div>
    </div>    

    <div class="mt-4 d-flex gap-3">
        <a href="javascript:void(0)" onclick="update_publisher()" 
           class="btn btn-outline-info btn-lg">
            Update
        </a>

        <a href="javascript:void(0)" onclick="clear_form()" class="btn btn-outline-danger btn-lg">Clear</a>
    </div>
</div>

<script type="text/javascript">
var base_url = "<?= base_url(); ?>";

function validateForm() {
    var requiredFields = ['publisher_name', 'address', 'publisher_city', 'publisher_contact', 'publisher_mobile'];
    for (var i = 0; i < requiredFields.length; i++) {
        if ($('#' + requiredFields[i]).val().trim() === '') {
            alert("Please fill all required fields.");
            return false;
        }
    }
    var mobileRegex = /^[0-9]{10}$/;
    if (!mobileRegex.test($('#publisher_mobile').val().trim())) {
        alert("Please enter a valid 10-digit mobile number.");
        return false;
    }
    return true;
}

function update_publisher() {
    if (!validateForm()) return;

    var data = {
        id: $('#publisher_id').val(),
        publisher_name: $('#publisher_name').val().trim(),
        address: $('#address').val().trim(),
        publisher_city: $('#publisher_city').val().trim(),
        publisher_contact: $('#publisher_contact').val().trim(),
        publisher_mobile: $('#publisher_mobile').val().trim(),
        preferred_transport: $('#preferred_transport').val().trim(),
        cover_reqs: $('#cover_reqs').val().trim(),
        content_reqs: $('#content_reqs').val().trim(),
        other_reqs: $('#other_reqs').val().trim(),
        rejection_remarks: $('#rejection_remarks').val().trim()
    };

    $.ajax({
        url: base_url + 'pod/updatepublisher',
        type: 'POST',
        dataType: 'json',
        data: data,
        success: function(response) {
            if (response.status === 'success') {
                alert("Publisher updated successfully!");
                window.location.href = base_url + 'pod/publisherdashboard';
            } else {
                alert("Publisher not updated. Please try again.");
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
