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
                <h5 class="card-title mb-0 text-center">Edit Author Social Media Links</h5>
            </div>
            <div class="card-body">
                <form class="row gy-3 needs-validation" novalidate>

                    <!-- Facebook URL -->
                    <div class="col-md-6">
                        <label class="form-label">Facebook URL</label>
                        <input type="text"
                               value="<?= esc($author_link_data['link_data']['fb_url'] ?? '') ?>"
                               class="form-control"
                               placeholder="Facebook URL"
                               id="fb_url"
                               required>
                    </div>

                    <!-- Twitter URL -->
                    <div class="col-md-6">
                        <label class="form-label">Twitter URL</label>
                        <input type="text"
                               value="<?= esc($author_link_data['link_data']['twitter_url'] ?? '') ?>"
                               class="form-control"
                               placeholder="Twitter URL"
                               id="twitter_url"
                               required>
                    </div>

                    <!-- Blog URL -->
                    <div class="col-md-6">
                        <label class="form-label">Blog URL</label>
                        <input type="text"
                               value="<?= esc($author_link_data['link_data']['blog_url'] ?? '') ?>"
                               class="form-control"
                               placeholder="Blog URL"
                               id="blog_url"
                               required>
                    </div>

                    <div class="col-12 text-center mt-5 mb-3 d-flex justify-content-center gap-3">
                        <a href="<?= base_url('author/editauthor/' . $author_id); ?>"
                           class="btn btn-outline-lilac-600 radius-8 px-20 py-11">
                            Back
                        </a>
                        <a href="#"
                           onclick="edit_author_social_links()"
                           class="btn btn-outline-success-600 radius-8 px-20 py-11">
                            Save
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
const author_id = "<?= $author_id ?>";
const requestUrl = "<?= site_url('author/editauthorsociallinkpost') ?>";

function edit_author_social_links() {
    const fb_url = document.getElementById('fb_url').value;
    const twitter_url = document.getElementById('twitter_url').value;
    const blog_url = document.getElementById('blog_url').value;

    $.ajax({
        url: requestUrl,
        type: 'POST',
        dataType: 'JSON',
        data: {
            fb_url,
            twitter_url,
            blog_url,
            author_id
        },
        success: function (data) {
            if (data.status == 1) {
                alert("Author social media links updated successfully!");
            } else {
                alert("Failed to update social media links!");
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
