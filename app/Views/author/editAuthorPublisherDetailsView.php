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
                    Edit Author Details (Publisher Table) - 
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

                    <div class="col-md-6">
                        <label class="form-label mt-2">Mobile</label>
                        <input type="text" id="mobile" value="<?= $publisher_details['mobile'] ?>" class="form-control" name="mobile" required>
                        <div class="invalid-feedback">Please provide a valid mobile number.</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label mt-2">Email ID</label>
                        <input type="email" id="email_id" value="<?= $publisher_details['email_id'] ?>" class="form-control" name="email_id" required>
                        <div class="invalid-feedback">Please provide a valid email address.</div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label mt-2">Address</label>
                        <textarea class="form-control" id="address" rows="5" required><?= $publisher_details['address']; ?></textarea>
                        <div class="invalid-feedback">Please provide address details.</div>
                        <small class="text-muted d-block mt-1">Characters: <span id="num_chars">0</span></small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label mt-2">Copyright Owner</label>
                        <input type="text" id="copyright_owner" value="<?= $publisher_details['copyright_owner'] ?>" class="form-control" disabled name="copyright_owner">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label mt-2">Publisher URL Name <small class="text-muted">(Use only for publishers like Manimegalai, Dhwanidhare, etc.)</small></label>
                        <input type="text" id="publisher_url_name" value="<?= $publisher_details['publisher_url_name'] ?>" class="form-control" name="publisher_url_name">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label mt-2">Publisher Image <small class="text-muted">(Use only for a publisher like Manimegalai, Dhwanidhare, etc. as logo)</small></label>
                        <input type="text" id="publisher_image" value="<?= $publisher_details['publisher_image'] ?>" class="form-control" name="publisher_image">
                    </div>

                    <div class="col-12">
                        <button type="button" onclick="edit_author_publisher_details()" class="btn btn-primary-600 mt-3">
                            Modify
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
const requestUrl = "<?= site_url('author/editauthorpublisherdetailspost') ?>";

function edit_author_publisher_details() {
    var copyright_owner = document.getElementById('copyright_owner').value;
    var mobile = document.getElementById('mobile').value;
    var email_id = document.getElementById('email_id').value;
    var address = document.getElementById('address').value;
    var publisher_url_name = document.getElementById('publisher_url_name').value;
    var publisher_image = document.getElementById('publisher_image').value;

    $.ajax({
        url: requestUrl,
        type: 'POST',
        dataType: 'JSON',
        data: {
            "copyright_owner": copyright_owner,
            "mobile": mobile,
            "email_id": email_id,
            "address": address,
            "publisher_url_name": publisher_url_name,
            "publisher_image": publisher_image
        },
        success: function(response) {
            if (response.status == 1) {
                alert("Edited Author Details Successfully!!!");
                window.location.href = "<?= site_url('author/editauthor/') ?>/<?= $author_details['author_id']; ?>";
            } else {
                alert("Error Occurred!!");
            }
        }
    });
}

// live character counter
document.getElementById('address').addEventListener('input', function() {
    document.getElementById('num_chars').textContent = this.value.length;
});
</script>

<?= $this->endSection(); ?>
