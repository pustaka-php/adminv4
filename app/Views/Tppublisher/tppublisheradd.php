<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 

<div class="row gy-4">
    <div class="col-md-6">
        <!-- Publisher Info Card -->
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0"> Add Publisher Details</h6>
            </div>
            <div class="card-body">
                <div class="row gy-3">
                    <div class="col-12">
                        <label class="form-label"> Publisher Name</label>
                        <input class="form-control" name="publisher_name" id="publisher_name" />
                    </div>

                    <div class="col-12">
                        <label class="form-label"> Contact Person</label>
                        <input class="form-control" name="contact_person" id="contact_person" />
                    </div>

                    <div class="col-12">
                        <label class="form-label"> Address</label>
                        <textarea class="form-control" name="address" id="address" rows="3" placeholder="Full postal address"></textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label"> Mobile</label>
                        <input type="tel" class="form-control" name="mobile" id="mobile" minlength="10" maxlength="10" pattern="[0-9]{10}">
                    </div>

                    <div class="col-12">
                        <label class="form-label"> Email</label>
                        <input class="form-control" name="email_id" id="email_id" type="email" placeholder="example@email.com" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bank Info -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0"> Bank Details</h6>
            </div>
            <div class="card-body">
                <div class="row gy-3">
                    <div class="col-12">
                        <label class="form-label"> Account Number</label>
                        <input class="form-control" name="bank_acc_no" id="bank_acc_no" />
                    </div>

                    <div class="col-12">
                        <label class="form-label"> Account Holder Name</label>
                        <input class="form-control" name="bank_acc_name" id="bank_acc_name" />
                    </div>

                    <div class="col-12">
                        <label class="form-label"> IFSC Code</label>
                        <input class="form-control" name="bank_acc_ifsc" id="bank_acc_ifsc" />
                    </div>

                    <div class="col-12">
                        <label class="form-label"> Account Type</label>
                        <input class="form-control" name="bank_acc_type" id="bank_acc_type" placeholder="e.g., Savings / Current" />
                    </div>

                    <div class="col-12">
                        <label class="form-label"> Publisher Logo (URL or File name)</label>
                        <input class="form-control" name="publisher_logo" id="publisher_logo" placeholder="logo.png" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Submit Buttons -->
    <div class="col-12">
        <div class="d-flex gap-3">
            <a href="javascript:void(0)" onclick="publishers_add()" class="btn btn-success btn-lg">
                 Submit
            </a>
            <a href="javascript:void(0)" onclick="history.back()" class="btn btn-danger btn-lg">
                 Back
            </a>
        </div>
    </div>
</div>

<script type="text/javascript">
    var base_url = "<?= base_url(); ?>";
    function publishers_add() {
        const data = {
            publisher_name: $('#publisher_name').val(),
            contact_person: $('#contact_person').val(),
            address: $('#address').val(),
            mobile: $('#mobile').val(),
            email_id: $('#email_id').val(),
            bank_acc_no: $('#bank_acc_no').val(),
            bank_acc_name: $('#bank_acc_name').val(),
            bank_acc_ifsc: $('#bank_acc_ifsc').val(),
            bank_acc_type: $('#bank_acc_type').val(),
            publisher_logo: $('#publisher_logo').val(),
        };

        $.ajax({
            url: base_url + '/tppublisher/tpPublisherAdd',
            type: 'POST',
            data: data,
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    location.reload();
                } else if (response.error && response.messages) {
                    let errors = '';
                    for (const key in response.messages) {
                        errors += `${key}: ${response.messages[key]}\n`;
                    }
                    alert("Validation Errors:\n" + errors);
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert("Something went wrong on the server.");
            }
        });
    }
</script>

<?= $this->endSection(); ?>
