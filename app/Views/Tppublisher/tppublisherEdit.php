<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?> 

<div class="row gy-4">
    <div class="col-md-6">
        <!-- Publisher Info Card -->
        <div class="card h-100">
            <div class="card-header bg-base py-3 px-4 border-bottom">
                <h6 class="card-title mb-0 fw-semibold">Edit Publisher Details</h6>
            </div>
            <div class="card-body">
                <input type="hidden" id="publisher_id" value="<?= esc($publishers_data['publisher_id']) ?>">
                
                <div class="row gy-3">
                    <div class="col-12">
                        <label class="form-label fw-medium text-primary-light">Publisher Name</label>
                        <input type="text" class="form-control radius-8" id="publisher_name" 
                               value="<?= esc($publishers_data['publisher_name']) ?>">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-medium text-primary-light">Contact Person</label>
                        <input type="text" class="form-control radius-8" id="contact_person" 
                               value="<?= esc($publishers_data['contact_person']) ?>">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-medium text-primary-light">Address</label>
                        <textarea class="form-control radius-8" id="address" rows="3"><?= esc($publishers_data['address']) ?></textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-medium text-primary-light">Mobile</label>
                        <input type="tel" class="form-control radius-8" id="mobile" 
                               value="<?= esc($publishers_data['mobile']) ?>" 
                               minlength="10" maxlength="10" pattern="[0-9]{10}">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-medium text-primary-light">Email</label>
                        <input type="email" class="form-control radius-8" id="email_id" 
                               value="<?= esc($publishers_data['email_id']) ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bank Info Card -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-base py-3 px-4 border-bottom">
                <h6 class="card-title mb-0 fw-semibold">Bank Details</h6>
            </div>
            <div class="card-body">
                <div class="row gy-3">
                    <div class="col-12">
                        <label class="form-label fw-medium text-primary-light">Account Number</label>
                        <input type="text" class="form-control radius-8" id="bank_acc_no" 
                               value="<?= esc($publishers_data['bank_acc_no']) ?>">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-medium text-primary-light">Account Holder Name</label>
                        <input type="text" class="form-control radius-8" id="bank_acc_name" 
                               value="<?= esc($publishers_data['bank_acc_name']) ?>">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-medium text-primary-light">IFSC Code</label>
                        <input type="text" class="form-control radius-8" id="bank_acc_ifsc" 
                               value="<?= esc($publishers_data['bank_acc_ifsc']) ?>">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-medium text-primary-light">Account Type</label>
                        <input type="text" class="form-control radius-8" id="bank_acc_type" 
                               value="<?= esc($publishers_data['bank_acc_type']) ?>">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-medium text-primary-light">Publisher Logo</label>
                        <input type="text" class="form-control radius-8" id="publisher_logo" 
                               value="<?= esc($publishers_data['publisher_logo']) ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="col-12">
        <div class="d-flex gap-3 justify-content-end">
            <button onclick="history.back()" class="btn btn-danger-600 radius-8 px-20 py-11">
                Back
            </button>
            <button onclick="publishers_update()" class="btn btn-info-600 radius-8 px-20 py-11">
                Update Publisher
            </button>
        </div>
    </div>
</div>

<?= $this->section('script'); ?>
<script>
    const base_url = "<?= base_url() ?>";

    function publishers_update() {
        const data = {
            publisher_id: $('#publisher_id').val(),
            publisher_name: $('#publisher_name').val(),
            contact_person: $('#contact_person').val(),
            address: $('#address').val(),
            mobile: $('#mobile').val(),
            email_id: $('#email_id').val(),
            bank_acc_no: $('#bank_acc_no').val(),
            bank_acc_name: $('#bank_acc_name').val(),
            bank_acc_ifsc: $('#bank_acc_ifsc').val(),
            bank_acc_type: $('#bank_acc_type').val(),
            publisher_logo: $('#publisher_logo').val()
        };

        $.ajax({
            url: base_url + "tppublisher/editpublisherpost",
            type: "POST",
            data: data,
            success: function(response) {
                if (response.status === 1) {
                    alert("Publisher updated successfully!");
                    location.reload();
                } else {
                    alert("Publisher not updated. Please check the input.");
                }
            },
            error: function(xhr) {
                alert("An error occurred while updating. See console for details.");
                console.error(xhr.responseText);
            }
        });
    }
    
</script>
<?= $this->endSection(); ?>

<?= $this->endSection(); ?>