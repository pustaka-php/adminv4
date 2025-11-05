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
                    <div class="col-md-6">
                        <label class="form-label">Amazon Link</label>
                        <input type="text" value="<?= $author_link_data['link_data']['amazon_link'] ?>" class="form-control" placeholder="Amazon Link" id="amazon_link" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Scribd Link</label>
                        <input type="text" value="<?= $author_link_data['link_data']['scribd_link'] ?>" class="form-control" placeholder="Scribd Link" id="scribd_link" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Google Books Link</label>
                        <input type="text" value="<?= $author_link_data['link_data']['googlebooks_link'] ?>" class="form-control" placeholder="Google Books Link" id="google_link" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Overdrive Link</label>
                        <input type="text" value="<?= $author_link_data['link_data']['overdrive_link'] ?>" class="form-control" placeholder="Overdrive Link" id="overdrive_link" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Storytel Link</label>
                        <input type="text" value="<?= $author_link_data['link_data']['storytel_link'] ?>" class="form-control" placeholder="Storytel Link" id="storytel_link" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Pratilipi Link</label>
                        <input type="text" value="<?= $author_link_data['link_data']['pratilipi_link'] ?>" class="form-control" placeholder="Pratilipi Link" id="pratilipi_link" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Audible Link</label>
                        <input type="text" value="<?= $author_link_data['link_data']['audible_link'] ?>" class="form-control" placeholder="Audible Link" id="audible_link" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Odilo Link</label>
                        <input type="text" value="<?= $author_link_data['link_data']['odilo_link'] ?>" class="form-control" placeholder="Odilo Link" id="odilo_link" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Pinterest Link</label>
                        <input type="text" value="<?= $author_link_data['link_data']['pinterest_link'] ?>" class="form-control" placeholder="Pinterest Link" id="pinterest_link" required>
                    </div>
					<br><br>
                    <div class="col-4 mt-2">
                        <a href="#" onclick="edit_author_links()" class="btn btn-success btn-lg w-100">Finish</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
const requestUrl = "<?= site_url('author/editauthorlinkpost') ?>";

function edit_author_links() {
    var amazon_link = document.getElementById('amazon_link').value;
    var scribd_link = document.getElementById('scribd_link').value;
    var google_link = document.getElementById('google_link').value;
    var storytel_link = document.getElementById('storytel_link').value;
    var overdrive_link = document.getElementById('overdrive_link').value;
    var pratilipi_link = document.getElementById('pratilipi_link').value;
    var audible_link = document.getElementById('audible_link').value;
    var odilo_link = document.getElementById('odilo_link').value;
    var pinterest_link = document.getElementById('pinterest_link').value;

    $.ajax({
        url: requestUrl,
        type: 'POST',
        dataType: 'JSON',
        data: {
            "amazon_link": amazon_link,
            "scribd_link": scribd_link,
            "storytel_link": storytel_link,
            "google_link": google_link,
            "overdrive_link": overdrive_link,
            "pratilipi_link": pratilipi_link,
            "audible_link": audible_link,
            "odilo_link": odilo_link,
            "pinterest_link": pinterest_link,
            "author_id": author_id,
        },
        success: function(data) {
            if (data == 1) {
                alert("Added Links to author Successfully");
            }
        }
    });
}
</script>

<?= $this->endSection(); ?>
