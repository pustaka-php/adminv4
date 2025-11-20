<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="row gy-4">
    <div class="col-lg-12">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    Edit Author Basic Details - <?= $author_details['author_name']; ?> 
                    (<?= $author_details['author_id']; ?>)
                </h5>
                <small>
                    Current Status: 
                    <strong><?= ($author_details['status'] == 0) ? 'Inactive' : 'Active'; ?></strong>
                </small>
            </div>

            <div class="card-body">
                <form class="row gy-3 needs-validation" novalidate>
                    
                    <!-- Author Name -->
                    <div class="col-md-6">
                        <label class="form-label">Author Name / Pen Name (English)</label>
                        <input type="text" id="author_name" class="form-control" 
                               value="<?= $author_details['author_name'] ?>" required>
                        <div class="invalid-feedback">Please provide the author name.</div>
                    </div>

                    <!-- URL Name -->
                    <div class="col-md-6">
                        <label class="form-label">Author URL Name</label>
                        <input type="text" id="url_name" class="form-control" 
                               value="<?= $author_details['url_name'] ?>" required>
                        <div class="invalid-feedback">Please provide the author URL name.</div>
                    </div>

                    <!-- Author Image -->
                    <div class="col-md-6">
                        <label class="form-label">Author Image</label>
                        <input type="text" id="author_image" class="form-control" 
                               value="<?= $author_details['author_image'] ?>">
                    </div>

                    <!-- Description -->
                    <div class="col-md-12">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" id="desc_text" rows="5" 
                                  oninput="count_chars()"><?= $author_details['description']; ?></textarea>
                        <small class="text-muted">Characters: <span id="num_chars">0</span></small>
                        <div class="invalid-feedback">Please enter a description.</div>
                    </div>

                    <!-- Gender -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Gender</label>
                        <div class="d-flex align-items-center flex-wrap gap-4 mt-2">
                            <div class="form-check d-flex align-items-center m-0">
                                <input class="form-check-input me-2" type="checkbox" name="author_gender" id="gender_m" value="M"
                                       <?= ($author_details['gender'] == 'M') ? 'checked' : ''; ?>>
                                <label class="form-check-label mb-0" for="gender_m">Male</label>
                            </div>
                            <div class="form-check d-flex align-items-center m-0">
                                <input class="form-check-input me-2" type="checkbox" name="author_gender" id="gender_f" value="F"
                                       <?= ($author_details['gender'] == 'F') ? 'checked' : ''; ?>>
                                <label class="form-check-label mb-0" for="gender_f">Female</label>
                            </div>
                        </div>
                    </div>

                    <!-- Author Type -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Author Type</label>
                        <div class="d-flex align-items-center flex-wrap gap-4 mt-2">
                            <div class="form-check d-flex align-items-center m-0">
                                <input class="form-check-input me-2" type="checkbox" name="author_type" id="type_royalty" value="1"
                                       <?= ($author_details['author_type'] == 1) ? 'checked' : ''; ?>>
                                <label class="form-check-label mb-0" for="type_royalty">Royalty</label>
                            </div>
                            <div class="form-check d-flex align-items-center m-0">
                                <input class="form-check-input me-2" type="checkbox" name="author_type" id="type_free" value="2"
                                       <?= ($author_details['author_type'] == 2) ? 'checked' : ''; ?>>
                                <label class="form-check-label mb-0" for="type_free">Free/Nationalised</label>
                            </div>
                            <div class="form-check d-flex align-items-center m-0">
                                <input class="form-check-input me-2" type="checkbox" name="author_type" id="type_publisher" value="3"
                                       <?= ($author_details['author_type'] == 3) ? 'checked' : ''; ?>>
                                <label class="form-check-label mb-0" for="type_publisher">Through Publisher</label>
                            </div>
                        </div>
                    </div>

                    <!-- Copyright Owner Name -->
                    <div class="col-md-6">
                        <label class="form-label">Copyright Owner Name</label>
                        <input type="text" id="copy_right_owner_name" class="form-control" 
                               value="<?= $author_details['copy_right_owner_name'] ?>">
                    </div>

                    <!-- Relationship -->
                    <div class="col-md-6">
                        <label class="form-label">Relationship</label>
                        <input type="text" id="relationship" class="form-control" 
                               value="<?= $author_details['relationship'] ?>">
                    </div>

                    <!-- Copyright Owner -->
                    <div class="col-md-6">
                        <label class="form-label">Copyright Owner</label>
                        <input type="text" id="copyright_owner" class="form-control" 
                               value="<?= $author_details['copyright_owner'] ?>">
                    </div>

                    <!-- Address -->
                    <div class="col-md-12">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" id="address" rows="3"><?= $author_details['address']; ?></textarea>
                    </div>

                    <!-- User ID -->
                    <div class="col-md-6">
                        <label class="form-label">User ID</label>
                        <input type="text" id="user_id" class="form-control" 
                               value="<?= $author_details['user_id'] ?>" required>
                        <div class="invalid-feedback">Please provide a user ID.</div>
                    </div>

                    <!-- Submit -->
                    <div class="col-12">
                        <button class="btn btn-primary-600 mt-3" type="submit">
                            Modify
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
<?= $this->section('script'); ?>

<script>
document.addEventListener("DOMContentLoaded", function () {
    "use strict";

    // Enable Bootstrap form validation
    const forms = document.querySelectorAll(".needs-validation");
    Array.from(forms).forEach(form => {
        form.addEventListener("submit", event => {
            event.preventDefault(); // Prevent form reload
            event.stopPropagation();

            if (form.checkValidity()) {
                edit_basic_details(); // Call AJAX only when valid
            }
            form.classList.add("was-validated");
        }, false);
    });

    count_chars(); // Initialize character count
});

function count_chars() {
    const textArea = document.getElementById('desc_text');
    document.getElementById('num_chars').textContent = textArea.value.length;
}

function edit_basic_details() {
    const requestUrl = "<?= site_url('author/editauthorbasicdetailspost') ?>";

    const author_name = document.getElementById('author_name').value;
    const url_name = document.getElementById('url_name').value;
    const author_image = document.getElementById('author_image').value;
    const description = document.getElementById('desc_text').value;

    const genders = document.querySelectorAll('input[name="author_gender"]:checked');
    const author_gender = Array.from(genders).map(g => g.value).join(',');

    const types = document.querySelectorAll('input[name="author_type"]:checked');
    const author_type = Array.from(types).map(t => t.value).join(',');

    const copy_right_owner_name = document.getElementById('copy_right_owner_name').value;
    const relationship = document.getElementById('relationship').value;
    const copyright_owner = document.getElementById('copyright_owner').value;
    const address = document.getElementById('address').value;
    const user_id = document.getElementById('user_id').value;

    $.ajax({
        url: requestUrl,
        type: 'POST',
        dataType: 'JSON', // Expect JSON from server
        data: {
            "author_id": "<?= $author_details['author_id']; ?>",
            "author_name": author_name,
            "url_name": url_name,
            "author_image": author_image,
            "description": description,
            "author_gender": author_gender,
            "author_type": author_type,
            "copy_right_owner_name": copy_right_owner_name,
            "relationship": relationship,
            "copyright_owner": copyright_owner,
            "address": address,
            "user_id": user_id
        },
        success: function (response) {
            console.log("Server Response:", response);
            // Expect JSON like {status:1} from PHP
            if (response.status == 1) {
                alert("Edited Author Details Successfully!");
                window.location.href = "<?= site_url('author/editauthor/') ?>/<?= $author_details['author_id']; ?>";
            } else {
                alert("Error Occurred While Editing!");
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.error("Response Text:", xhr.responseText);
            alert("Failed to update details. Check console for more info.");
        }
    });
}
</script>

<?= $this->endSection(); ?>
