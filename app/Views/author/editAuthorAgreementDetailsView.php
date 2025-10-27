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
                    Edit Author Agreement Details (Author Table) - 
                    <?= $author_details['author_name']; ?> 
                    (<?= $author_details['author_name']; ?>)
                </h5>
                <?php 
                    $status = ($author_details['status'] == 0) ? "InActive" : "Active"; 
                ?>
                <h7>Current State - <?= $status; ?></h6>
            </div>

            <div class="card-body">
                <form class="row gy-3 needs-validation" novalidate>

                    <div class="col-md-12">
                        <label class="form-label">Agreement Details</label>
                        <textarea class="form-control" id="agreement_details" rows="7" required><?= $author_details['agreement_details']; ?></textarea>
                        <div class="invalid-feedback">Please enter agreement details.</div>
                        <p class="text-muted mt-1">
                            Note: Enter the agreement id and date. Eg. PUS/TAM/180/2022 dated 28th June 2022. 
                            The addendum should also be entered in this field in the same format.
                        </p>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Ebook Count (As per Agreement)</label>
                        <input type="text" id="agreement_ebook_count" 
                               value="<?= $author_details['agreement_ebook_count'] ?>" 
                               class="form-control" required>
                        <div class="invalid-feedback">Please provide ebook count.</div>
                        <p class="text-muted mt-1">Update this field whenever an addendum is created for the author.</p>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Audiobook Count (As per Agreement)</label>
                        <input type="text" id="agreement_audiobook_count" 
                               value="<?= $author_details['agreement_audiobook_count'] ?>" 
                               class="form-control" required>
                        <div class="invalid-feedback">Please provide audiobook count.</div>
                        <p class="text-muted mt-1">Update this field whenever an addendum is created for the author.</p>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Paperback Count (As per Agreement)</label>
                        <input type="text" id="agreement_paperback_count" 
                               value="<?= $author_details['agreement_paperback_count'] ?>" 
                               class="form-control" required>
                        <div class="invalid-feedback">Please provide paperback count.</div>
                        <p class="text-muted mt-1">Update this field whenever an addendum is created for the author.</p>
                    </div>

                    <div class="col-12">
                        <button type="button" onclick="edit_author_agreement_details()" class="btn btn-primary-600 mt-3">
                            Modify
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
const requestUrl = "<?= site_url('author/editauthoragreementdetailspost') ?>";
function edit_author_agreement_details() {
    var agreement_details = document.getElementById('agreement_details').value;
    var agreement_ebook_count = document.getElementById('agreement_ebook_count').value;
    var agreement_audiobook_count = document.getElementById('agreement_audiobook_count').value;
    var agreement_paperback_count = document.getElementById('agreement_paperback_count').value;

    $.ajax({
        url: requestUrl,
        type: 'POST',
        dataType: 'JSON',
        data: {
            "author_id": "<?= $author_details['author_id']; ?>",
            "agreement_details": agreement_details,
            "agreement_ebook_count": agreement_ebook_count,
            "agreement_audiobook_count": agreement_audiobook_count,
            "agreement_paperback_count": agreement_paperback_count
        },
        success: function(data) {
            if (data == 1) {
                alert("Edited Author Details Successfully!!!");
            } else {
                alert("Error Occurred!!");
            }
        }
    });
}
</script>

<?= $this->endSection(); ?>
