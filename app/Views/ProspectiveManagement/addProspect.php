<?= $this->extend('layout/layout1'); ?>

<?= $this->section('script'); ?>
<script>
$(document).ready(function () {
    // Validation
    $(".form-control").on("blur", function () {
        $(this).toggleClass("is-invalid", $(this).val().trim() === "");
    });

    // Toggle Date Inputs based on Radio
    $("input[name='email_sent_flag']").change(function() {
        if ($(this).val() == "1") {
            $("#emailSentDate").removeClass("d-none");
            $("#email_sent_date").val(new Date().toISOString().split('T')[0]);
        } else {
            $("#emailSentDate").addClass("d-none");
            $("#email_sent_date").val("");
        }
    });

    $("input[name='initial_call_flag']").change(function() {
        if ($(this).val() == "1") {
            $("#initialCallDate").removeClass("d-none");
            $("#initial_call_date").val(new Date().toISOString().split('T')[0]);
        } else {
            $("#initialCallDate").addClass("d-none");
            $("#initial_call_date").val("");
        }
    });

    // Submit form
    $("#prospectForm").on("submit", function (e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.ajax({
            url: "<?= base_url('prospectivemanagement/saveprospect'); ?>",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function (response) {
                $("#alertBox").remove();
                const alertType = response.success ? "success" : "danger";
                const message = `
                    <div id="alertBox" class="alert alert-${alertType} alert-dismissible fade show mt-3" role="alert">
                        <strong>${response.message}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>`;
                $(".container").prepend(message);
                if (response.success) setTimeout(() => location.reload(), 2000);
            },
            error: function (xhr) {
                $("#alertBox").remove();
                $(".container").prepend(`
                    <div id="alertBox" class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        <strong>Server Error:</strong> ${xhr.statusText} (${xhr.status})
                        <br><small>${xhr.responseText}</small>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>`);
            }
        });
    });
});
</script>
<?= $this->endSection(); ?>


<?= $this->section('content'); ?>
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary mb-0">
            <i class="fa fa-user-plus me-2"></i> Add New Prospect
        </h4>
        <a href="<?= base_url('prospectivemanagement/dashboard'); ?>" class="btn btn-outline-secondary btn-sm">
            <i class="fa fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <form id="prospectForm">
        <?= csrf_field() ?>

        <!-- Basic Information -->
        <div class="card mb-3">
            <div class="card-header bg-light fw-semibold py-2">Prospect Basic Information</div>
            <div class="card-body py-3">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Full name">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Phone <span class="text-danger">*</span></label>
                        <input type="text" name="phone" class="form-control" placeholder="Phone number">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Email ID">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Source of Reference</label>
                        <input type="text" name="source_of_reference" class="form-control" placeholder="Friend, Ad, etc.">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Author Status</label>
                        <input type="text" name="author_status" class="form-control" placeholder="New or Existing">
                    </div>
                </div>
            </div>
        </div>

        <!-- Communication & Recommended Plan -->
        <div class="card mb-3">
            <div class="card-header bg-light fw-semibold py-2">Communication & Recommended Plan</div>
            <div class="card-body py-3">
                <div class="row g-3 align-items-center">
                    <div class="col-md-4">
                        <label class="form-label d-block mb-1">Email Sent</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="email_sent_flag" value="1">
                            <label class="form-check-label">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="email_sent_flag" value="0" checked>
                            <label class="form-check-label">No</label>
                        </div>
                        <div id="emailSentDate" class="mt-2 d-none">
                            <input type="date" name="email_sent_date" id="email_sent_date" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label d-block mb-1">Initial Call</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="initial_call_flag" value="1">
                            <label class="form-check-label">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="initial_call_flag" value="0" checked>
                            <label class="form-check-label">No</label>
                        </div>
                        <div id="initialCallDate" class="mt-2 d-none">
                            <input type="date" name="initial_call_date" id="initial_call_date" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Recommended Plan</label>
                        <select name="recommended_plan" class="form-select">
                            <option value="">-- Select Plan --</option>
                            <?php 
                            $plans = ['Silver', 'Gold', 'Platinum', 'Rhodium', 'Silver++', 'Pearl', 'Sapphire'];
                            foreach ($plans as $plan): ?>
                                <option value="<?= $plan; ?>"><?= $plan; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Remarks</label>
                        <textarea name="remarks" class="form-control" rows="2" placeholder="Enter remarks (if any)"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Titles & Payment Information -->
        <div class="card mb-3">
            <div class="card-header bg-light fw-semibold py-2">Titles & Payment Information</div>
            <div class="card-body py-3">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">No. of Titles</label>
                        <input type="number" name="no_of_title" class="form-control" placeholder="0">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="titles" class="form-control" placeholder="Title name">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Payment Status</label>
                        <select name="payment_status" class="form-select">
                            <option value="">-- Select --</option>
                            <?php foreach (['paid', 'partial'] as $status): ?>
                                <option value="<?= $status; ?>"><?= ucfirst($status); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Payment Amount (₹)</label>
                        <input type="number" name="payment_amount" class="form-control" placeholder="0.00">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Payment Date</label>
                        <input type="date" name="payment_date" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Payment Description</label>
                        <textarea name="payment_description" class="form-control" rows="2" placeholder="Short note about payment"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="text-end">
            <button type="submit" class="btn btn-primary px-4">
                <i class="fa fa-save me-2"></i>Save Prospect
            </button>
        </div>
    </form>
</div>
<?= $this->endSection(); ?>
