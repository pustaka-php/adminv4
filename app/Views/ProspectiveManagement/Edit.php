<?= $this->extend('layout/layout1'); ?>

<?= $this->section('script'); ?>
<script>
$(document).ready(function () {
    // Validation
    $(".form-control").on("blur", function () {
        $(this).toggleClass("is-invalid", $(this).val().trim() === "");
    });

    // Toggle Date Inputs based on Radio
    function toggleDateFields() {
        if ($("input[name='email_sent_flag']:checked").val() == "1") {
            $("#emailSentDate").removeClass("d-none");
        } else {
            $("#emailSentDate").addClass("d-none");
            $("#email_sent_date").val("");
        }

        if ($("input[name='initial_call_flag']:checked").val() == "1") {
            $("#initialCallDate").removeClass("d-none");
        } else {
            $("#initialCallDate").addClass("d-none");
            $("#initial_call_date").val("");
        }
    }

    $("input[name='email_sent_flag'], input[name='initial_call_flag']").change(toggleDateFields);
    toggleDateFields(); // On load

    // Submit form
    $("#prospectForm").on("submit", function (e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.ajax({
            url: "<?= base_url('prospectivemanagement/updateprospect/' . $prospect['id']); ?>",
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
            <i class="fa fa-user-edit me-2"></i> Edit Prospect
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
                        <input type="text" name="name" class="form-control" value="<?= esc($prospect['name']); ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Phone <span class="text-danger">*</span></label>
                        <input type="text" name="phone" class="form-control" value="<?= esc($prospect['phone']); ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= esc($prospect['email']); ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Source of Reference</label>
                        <input type="text" name="source_of_reference" class="form-control" value="<?= esc($prospect['source_of_reference']); ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Author Status</label>
                        <input type="text" name="author_status" class="form-control" value="<?= esc($prospect['author_status']); ?>">
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
                            <input class="form-check-input" type="radio" name="email_sent_flag" value="1" <?= $prospect['email_sent_flag'] == 1 ? 'checked' : ''; ?>>
                            <label class="form-check-label">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="email_sent_flag" value="0" <?= $prospect['email_sent_flag'] == 0 ? 'checked' : ''; ?>>
                            <label class="form-check-label">No</label>
                        </div>
                        <div id="emailSentDate" class="mt-2 <?= $prospect['email_sent_flag'] == 1 ? '' : 'd-none'; ?>">
                            <input 
                                type="date" 
                                name="email_sent_date" 
                                id="email_sent_date" 
                                class="form-control"
                                value="<?= !empty($prospect['email_sent_date']) ? date('Y-m-d', strtotime($prospect['email_sent_date'])) : ''; ?>"
                            >
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label d-block mb-1">Initial Call</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="initial_call_flag" value="1" <?= $prospect['initial_call_flag'] == 1 ? 'checked' : ''; ?>>
                            <label class="form-check-label">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="initial_call_flag" value="0" <?= $prospect['initial_call_flag'] == 0 ? 'checked' : ''; ?>>
                            <label class="form-check-label">No</label>
                        </div>
                       <div id="initialCallDate" class="mt-2 <?= $prospect['initial_call_flag'] == 1 ? '' : 'd-none'; ?>">
                        <input 
                            type="date" 
                            name="initial_call_date" 
                            id="initial_call_date" 
                            class="form-control"
                            value="<?= !empty($prospect['initial_call_date']) ? date('Y-m-d', strtotime($prospect['initial_call_date'])) : ''; ?>">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Recommended Plan</label>
                        <select name="recommended_plan" class="form-select">
                            <option value="">-- Select Plan --</option>
                            <?php 
                            $plans = ['Silver', 'Gold', 'Platinum', 'Rhodium', 'Silver++', 'Pearl', 'Sapphire'];
                            foreach ($plans as $plan): ?>
                                <option value="<?= $plan; ?>" <?= ($prospect['recommended_plan'] == $plan) ? 'selected' : ''; ?>><?= $plan; ?></option>
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

        <!-- Submit Button -->
        <div class="text-end">
            <button type="submit" class="btn btn-success px-4">
                <i class="fa fa-save me-2"></i> Update Prospect
            </button>
        </div>
    </form>
</div>
<?= $this->endSection(); ?>
