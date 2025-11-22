<?= $this->extend('layout/layout1'); ?>

<?= $this->section('script'); ?>
<script>
$(document).ready(function () {

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
});
</script>
<?= $this->endSection(); ?>


<?= $this->section('content'); ?>
<div class="container py-4">

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

        <!-- BASIC INFO -->
        <div class="card mb-3">
            <div class="card-header bg-light fw-semibold py-2">Prospect Basic Information</div>
            <div class="card-body py-3">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" value="<?= esc($prospect['name']); ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Phone</label>
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
                        <input type="text" name="author_status" class="form-control"
                            value="<?= esc($prospect['author_status'] ?? '') ?>">
                    </div>
                </div>
            </div>
        </div>

        <!-- COMMUNICATION -->
        <div class="card mb-3">
            <div class="card-header bg-light fw-semibold py-2">Communication & Recommended Plan</div>
            <div class="card-body py-3">
                <div class="row g-3 align-items-center">

                    <!-- EMAIL SENT -->
                    <div class="col-md-4">
                        <label class="form-label d-block mb-1">Email Sent</label>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="email_sent_flag" value="1"
                                <?= $prospect['email_sent_flag'] == 1 ? 'checked' : ''; ?>>
                            <label class="form-check-label">Yes</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="email_sent_flag" value="0"
                                <?= $prospect['email_sent_flag'] == 0 ? 'checked' : ''; ?>>
                            <label class="form-check-label">No</label>
                        </div>

                        <div id="emailSentDate" class="mt-2 <?= $prospect['email_sent_flag'] == 1 ? '' : 'd-none'; ?>">

                            <!-- SHOW DATE INSIDE THE BOX -->
                            <?php 
                                $emailDate = !empty($prospect['email_sent_date']) 
                                              ? date('Y-m-d', strtotime($prospect['email_sent_date']))
                                              : '';
                            ?>

                            <input type="date" 
                                name="email_sent_date" 
                                id="email_sent_date" 
                                class="form-control"
                                value="<?= $emailDate ?>">
                        </div>

                    </div>

                    <!-- INITIAL CALL -->
                    <div class="col-md-4">
                        <label class="form-label d-block mb-1">Initial Call</label>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="initial_call_flag" value="1"
                                <?= $prospect['initial_call_flag'] == 1 ? 'checked' : ''; ?>>
                            <label class="form-check-label">Yes</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="initial_call_flag" value="0"
                                <?= $prospect['initial_call_flag'] == 0 ? 'checked' : ''; ?>>
                            <label class="form-check-label">No</label>
                        </div>

                        <div id="initialCallDate" class="mt-2 <?= $prospect['initial_call_flag'] == 1 ? '' : 'd-none'; ?>">

                            <?php 
                                $callDate = !empty($prospect['initial_call_date']) 
                                            ? date('Y-m-d', strtotime($prospect['initial_call_date'])) 
                                            : '';
                            ?>

                            <input type="date"
                                name="initial_call_date"
                                id="initial_call_date"
                                class="form-control"
                                value="<?= $callDate ?>">
                        </div>

                    </div>

                    <!-- PLAN -->
                    <div class="col-md-4">
                        <label class="form-label">Recommended Plan</label>
                        <select name="recommended_plan" class="form-select">
                            <option value="">-- Select Plan --</option>
                            <?php 
                                $plans = ['Silver','Gold','Platinum','Rhodium','Silver++','Pearl','Sapphire'];
                                foreach ($plans as $p):
                            ?>
                                <option value="<?= $p ?>" <?= $prospect['recommended_plan'] == $p ? 'selected' : ''; ?>>
                                    <?= $p ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- REMARK INPUT -->
                    <div class="col-md-12">
                        <label class="form-label">Add New Remark</label>
                        <textarea name="remarks" class="form-control" rows="2" placeholder="Enter remarks"></textarea>
                    </div>

                    <!-- LATEST REMARK -->
                    <div class="col-md-12 mt-3">
                        <label class="form-label">Latest Remark</label>

                        <?php if (!empty($latestRemark)): ?>
                            <textarea class="form-control" rows="2" readonly>
<?= esc($latestRemark['remarks']); ?> (<?= date('d-m-Y h:i A', strtotime($latestRemark['create_date'])); ?>)
                            </textarea>
                        <?php else: ?>
                            <textarea class="form-control" rows="2" readonly>No previous remark found.</textarea>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>

        <!-- BUTTON -->
        <div class="text-end">
            <button type="submit" class="btn btn-success px-4">
                <i class="fa fa-save me-2"></i> Update Prospect
            </button>
        </div>

    </form>
</div>

<?= $this->endSection(); ?>
