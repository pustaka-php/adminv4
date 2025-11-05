<?= $this->extend('layout/layout1'); ?>

<?= $this->section('script'); ?>
<script>
(() => {
    "use strict"
    const forms = document.querySelectorAll(".needs-validation")
    Array.from(forms).forEach(form => {
        form.addEventListener("submit", event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add("was-validated")
        }, false)
    })
})()
</script>
<?= $this->endSection(); ?>


<?= $this->section('content'); ?> 

<div class="row gy-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    Edit Author Bank Details (Publisher Table) - 
                    <?= $author_details['author_name']; ?> 
                    (<?= $author_details['author_name']; ?>)
                </h5>
                <?php 
                    $status = ($author_details['status'] == 0) ? "InActive" : "Active"; 
                ?>
                <h7>Current State - <?= $status; ?></h7>
            </div>

            <div class="card-body">
                <form class="row gy-3 needs-validation" novalidate>

                    <input type="hidden" id="copyright_owner" 
                           name="copyright_owner" 
                           value="<?= $publisher_details['copyright_owner'] ?>">

                    <div class="col-md-6">
                        <label class="form-label mt-2">Bank Account No</label>
                        <input type="text" id="bank_acc_no" 
                               value="<?= $publisher_details['bank_acc_no'] ?>" 
                               class="form-control" name="bank_acc_no" required>
                        <div class="invalid-feedback">Please enter a valid bank account number.</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label mt-2">Bank Account Name</label>
                        <input type="text" id="bank_acc_name" 
                               value="<?= $publisher_details['bank_acc_name'] ?>" 
                               class="form-control" name="bank_acc_name" required>
                        <div class="invalid-feedback">Please enter the account holder’s name.</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label mt-2">Bank Account Type</label>
                        <input type="text" id="bank_acc_type" 
                               value="<?= $publisher_details['bank_acc_type'] ?>" 
                               class="form-control" name="bank_acc_type" required>
                        <div class="invalid-feedback">Please specify account type (Savings/Current).</div>
                        <p class="text-muted mt-1">Note: Bank type can only be <b>"Savings"</b> or <b>"Current"</b>.</p>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label mt-2">IFSC Code</label>
                        <input type="text" id="ifsc_code" 
                               value="<?= $publisher_details['ifsc_code'] ?>" 
                               class="form-control" name="ifsc_code" required>
                        <div class="invalid-feedback">Please enter a valid IFSC code.</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label mt-2">PAN Number</label>
                        <input type="text" id="pan_number" 
                               value="<?= $publisher_details['pan_number'] ?>" 
                               class="form-control" name="pan_number" required>
                        <div class="invalid-feedback">Please enter a valid PAN number.</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label mt-2">Bonus Percentage</label>
                        <input type="text" id="bonus_percentage" 
                               value="<?= $publisher_details['bonus_percentage'] ?>" 
                               class="form-control" name="bonus_percentage" required>
                        <div class="invalid-feedback">Please enter bonus percentage.</div>
                        <p class="text-muted mt-1">
                            Note: Do not modify any value for bonus percentage without proper verification.
                        </p>
                    </div>

                    <div class="col-12">
                        <button type="button" onclick="edit_author_bank_details()" class="btn btn-primary-600 mt-3">
                            Modify
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
const requestUrl = "<?= site_url('author/editauthorbankdetailspost') ?>";

function edit_author_bank_details() {
    var copyright_owner = document.getElementById('copyright_owner').value;
    var bank_acc_no = document.getElementById('bank_acc_no').value;
    var bank_acc_name = document.getElementById('bank_acc_name').value;
    var bank_acc_type = document.getElementById('bank_acc_type').value;
    var ifsc_code = document.getElementById('ifsc_code').value;
    var pan_number = document.getElementById('pan_number').value;
    var bonus_percentage = document.getElementById('bonus_percentage').value;

    $.ajax({
        url: requestUrl,
        type: 'POST',
        dataType: 'JSON',
        data: {
            "copyright_owner": copyright_owner,
            "bank_acc_no": bank_acc_no,
            "bank_acc_name": bank_acc_name,
            "bank_acc_type": bank_acc_type,
            "ifsc_code": ifsc_code,
            "pan_number": pan_number,
            "bonus_percentage": bonus_percentage
        },
        success: function(response) {
            if (response.status == 1) {
                alert("Edited Author Details Successfully!!!");
                window.location.href = "<?= site_url('author/editauthor/') ?>/<?= $author_details['author_id']; ?>";
            } else if (response.status == 0) {
                alert("Error Occurred!!");
            }
        }
    });
}
</script>

<?= $this->endSection(); ?>
