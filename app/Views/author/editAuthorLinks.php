<?= $this->extend('layout/layout1'); ?>

<?= $this->section('script'); ?>
<script>
(() => {
    "use strict";

    const forms = document.querySelectorAll(".needs-validation");

    Array.from(forms).forEach(form => {
        form.addEventListener("submit", event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add("was-validated");
        }, false);
    });
})();
</script>
<?= $this->endSection(); ?>


<?= $this->section('content'); ?>

<div class="row gy-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0 text-center">Edit Author Links</h5>
            </div>
            <div class="card-body">
                <form class="row gy-3 needs-validation" novalidate>
                    
                    <!-- Amazon Link -->
                    <div class="col-md-6">
                        <label class="form-label">Amazon Link</label>
                        <input type="text" 
                               value="<?= $author_link_data['link_data']['amazon_link'] ?>" 
                               class="form-control" 
                               placeholder="Amazon Link" 
                               id="amazon_link" 
                               required>
                    </div>

                    <!-- Scribd Link -->
                    <div class="col-md-6">
                        <label class="form-label">Scribd Link</label>
                        <input type="text" 
                               value="<?= $author_link_data['link_data']['scribd_link'] ?>" 
                               class="form-control" 
                               placeholder="Scribd Link" 
                               id="scribd_link" 
                               required>
                    </div>

                    <!-- Google Books Link -->
                    <div class="col-md-6">
                        <label class="form-label">Google Books Link</label>
                        <input type="text" 
                               value="<?= $author_link_data['link_data']['googlebooks_link'] ?>" 
                               class="form-control" 
                               placeholder="Google Books Link" 
                               id="google_link" 
                               required>
                    </div>

                    <!-- Overdrive Link -->
                    <div class="col-md-6">
                        <label class="form-label">Overdrive Link</label>
                        <input type="text" 
                               value="<?= $author_link_data['link_data']['overdrive_link'] ?>" 
                               class="form-control" 
                               placeholder="Overdrive Link" 
                               id="overdrive_link" 
                               required>
                    </div>

                    <!-- Storytel Link -->
                    <div class="col-md-6">
                        <label class="form-label">Storytel Link</label>
                        <input type="text" 
                               value="<?= $author_link_data['link_data']['storytel_link'] ?>" 
                               class="form-control" 
                               placeholder="Storytel Link" 
                               id="storytel_link" 
                               required>
                    </div>

                    <!-- Pratilipi Link -->
                    <div class="col-md-6">
                        <label class="form-label">Pratilipi Link</label>
                        <input type="text" 
                               value="<?= $author_link_data['link_data']['pratilipi_link'] ?>" 
                               class="form-control" 
                               placeholder="Pratilipi Link" 
                               id="pratilipi_link" 
                               required>
                    </div>

                    <!-- Audible Link -->
                    <div class="col-md-6">
                        <label class="form-label">Audible Link</label>
                        <input type="text" 
                               value="<?= $author_link_data['link_data']['audible_link'] ?>" 
                               class="form-control" 
                               placeholder="Audible Link" 
                               id="audible_link" 
                               required>
                    </div>

                    <!-- Odilo Link -->
                    <div class="col-md-6">
                        <label class="form-label">Odilo Link</label>
                        <input type="text" 
                               value="<?= $author_link_data['link_data']['odilo_link'] ?>" 
                               class="form-control" 
                               placeholder="Odilo Link" 
                               id="odilo_link" 
                               required>
                    </div>

                    <!-- Pinterest Link -->
                    <div class="col-md-6">
                        <label class="form-label">Pinterest Link</label>
                        <input type="text" 
                               value="<?= $author_link_data['link_data']['pinterest_link'] ?>" 
                               class="form-control" 
                               placeholder="Pinterest Link" 
                               id="pinterest_link" 
                               required>
                    </div>
                    <div class="col-12 text-center mt-5 mb-3 d-flex justify-content-center gap-3">
                        <a href="<?= base_url('author/editauthor/' . $author_id); ?>" 
                        class="btn btn-outline-lilac-600 radius-8 px-20 py-11">
                            Back
                        </a>
                        <a href="#" 
                        onclick="edit_author_links()" 
                        class="btn btn-outline-success-600 radius-8 px-20 py-11">
                            Finish
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
const author_id = "<?= $author_id ?>";
const requestUrl = "<?= site_url('author/editauthorlinkpost') ?>";

function edit_author_links() {
    const amazon_link     = document.getElementById('amazon_link').value;
    const scribd_link     = document.getElementById('scribd_link').value;
    const google_link     = document.getElementById('google_link').value;
    const storytel_link   = document.getElementById('storytel_link').value;
    const overdrive_link  = document.getElementById('overdrive_link').value;
    const pratilipi_link  = document.getElementById('pratilipi_link').value;
    const audible_link    = document.getElementById('audible_link').value;
    const odilo_link      = document.getElementById('odilo_link').value;
    const pinterest_link  = document.getElementById('pinterest_link').value;

    $.ajax({
        url: requestUrl,
        type: 'POST',
        dataType: 'JSON',
        data: {
            amazon_link,
            scribd_link,
            google_link,
            storytel_link,
            overdrive_link,
            pratilipi_link,
            audible_link,
            odilo_link,
            pinterest_link,
            author_id
        },
        success: function (data) {
            if (data.status == 1) {
                alert("Added links to author successfully");
            } else {
                alert("Failed to update author links!");
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
            alert("AJAX error: " + error);
        }
    });
}
</script>

<?= $this->endSection(); ?>
