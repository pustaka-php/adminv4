<?= $this->extend('layout/layout1'); ?>

<?= $this->section('script'); ?>
<script>
$(document).ready(function () {

    // Toggle date fields based on radio buttons
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
    toggleDateFields();

    // Handle Accept and Denied buttons (normal confirmation)
    $(".actionBtn").click(function () {
        let status = $(this).data("status"); // 1 = Accept, 2 = Denied
        let actionText = status == 1 ? "accept" : "deny";

        // Simple confirmation
        if (!confirm(`Are you sure you want to ${actionText} this prospect?`)) {
            return; // cancel pressed
        }

        let formData = $("#prospectForm").serialize() + "&prospectors_status=" + status;

        $.ajax({
            url: "<?= base_url('prospectivemanagement/updateinprogress/' . $prospect['id']); ?>",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function (response) {
                // Simple message box
                alert(response.message);

                if (response.success) {
                    // redirect after short delay
                    setTimeout(() => {
                        window.location.href = "<?= base_url('prospectivemanagement/dashboard'); ?>";
                    }, 1000);
                }
            },
            error: function (xhr) {
                alert("Server Error: " + xhr.statusText);
            }
        });
    });

    function showAlert(success, message) {
        $("#alertBox").remove();
        const type = success ? "success" : "danger";
        const alertHTML = `
            <div id="alertBox" class="alert alert-${type} alert-dismissible fade show mt-3" role="alert">
                <strong>${message}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>`;
        $(".container").prepend(alertHTML);
    }
});
</script>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary mb-0">
            <i class="fa fa-user-edit me-2"></i> Edit Prospect
        </h4>
        <a href="<?= base_url('prospectivemanagement/dashboard'); ?>" 
           class="btn btn-outline-secondary btn-sm">
            <i class="fa fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <form id="prospectForm">
        <?= csrf_field() ?>

        <!-- Basic Info -->
        <div class="card mb-3">
            <div class="card-header bg-light fw-semibold py-2">Prospect Basic Information</div>
            <div class="card-body py-3">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Name *</label>
                        <input type="text" name="name" class="form-control" value="<?= esc($prospect['name'] ?? '') ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Phone *</label>
                        <input type="text" name="phone" class="form-control" value="<?= esc($prospect['phone'] ?? '') ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= esc($prospect['email'] ?? '') ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Source of Reference</label>
                        <input type="text" name="source_of_reference" class="form-control" value="<?= esc($prospect['source_of_reference'] ?? '') ?>">
                    </div>
                </div>
            </div>
        </div>

        <!-- Communication -->
        <div class="card mb-3">
            <div class="card-header bg-light fw-semibold py-2">Communication & Recommended Plan</div>
            <div class="card-body py-3">
                <div class="row g-3 align-items-center">
                    <div class="col-md-4">
                        <label class="form-label d-block">Email Sent</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="email_sent_flag" id="email_yes" value="1" <?= ($prospect['email_sent_flag'] ?? 0) == 1 ? 'checked' : '' ?>>
                            <label class="form-check-label" for="email_yes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="email_sent_flag" id="email_no" value="0" <?= ($prospect['email_sent_flag'] ?? 0) == 0 ? 'checked' : '' ?>>
                            <label class="form-check-label" for="email_no">No</label>
                        </div>
                        <div id="emailSentDate" class="mt-2 <?= ($prospect['email_sent_flag'] ?? 0) == 1 ? '' : 'd-none' ?>">
                            <input type="date" name="email_sent_date" class="form-control" value="<?= esc($prospect['email_sent_date'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label d-block">Initial Call</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="initial_call_flag" id="call_yes" value="1" <?= ($prospect['initial_call_flag'] ?? 0) == 1 ? 'checked' : '' ?>>
                            <label class="form-check-label" for="call_yes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="initial_call_flag" id="call_no" value="0" <?= ($prospect['initial_call_flag'] ?? 0) == 0 ? 'checked' : '' ?>>
                            <label class="form-check-label" for="call_no">No</label>
                        </div>
                        <div id="initialCallDate" class="mt-2 <?= ($prospect['initial_call_flag'] ?? 0) == 1 ? '' : 'd-none' ?>">
                            <input type="date" name="initial_call_date" class="form-control" value="<?= esc($prospect['initial_call_date'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Recommended Plan</label>
                        <select name="recommended_plan" class="form-select">
                            <option value="">-- Select Plan --</option>
                            <?php foreach (['Silver','Gold','Platinum','Rhodium','Silver++','Pearl','Sapphire'] as $plan): ?>
                                <option value="<?= $plan ?>" <?= ($prospect['recommended_plan'] ?? '') == $plan ? 'selected' : '' ?>><?= $plan ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Remarks</label>
                        <textarea name="remarks" class="form-control" rows="2"><?= esc($prospect['remarks'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <!-- Buttons -->
        <div class="text-center mt-4">
            <button type="button" class="btn btn-success actionBtn px-5 me-3" data-status="1">
                <i class="fa fa-check me-2"></i> Accept & closed
            </button>
            <button type="button" class="btn btn-danger actionBtn px-5" data-status="2">
                <i class="fa fa-times me-2"></i> Reject & Denied 
            </button>
        </div>

    </form>
</div>
<?= $this->endSection(); ?>