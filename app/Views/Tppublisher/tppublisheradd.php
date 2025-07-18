<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="row gy-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">Add Author Details</h6>
            </div>
            <div class="card-body">
                <div class="row gy-3">
                    <!-- Left Column -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Publisher</label>
                            <select name="publisher_id" id="publisher_id" class="form-control">
                                <option value="">-- Select Publisher --</option>
                                <?php if (!empty($publisher_details)) {
                                    foreach ($publisher_details as $publisher) { ?>
                                        <option value="<?= esc($publisher['publisher_id']) ?>">
                                            <?= esc($publisher['publisher_name']) ?>
                                        </option>
                                <?php }} ?>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Author Name</label>
                            <input type="text" class="form-control" name="author_name" id="author_name">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Mobile</label>
                            <input type="tel" class="form-control" name="mobile" id="mobile" minlength="10" maxlength="10" pattern="[0-9]{10}">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email_id" id="email_id">
                        </div>
                    </div>
                    
                    <!-- Right Column -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Author Description</label>
                            <textarea name="author_discription" id="author_discription" rows="4" class="form-control" placeholder="Author Description"></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Author Image</label>
                            <input type="file" class="form-control" name="author_image" id="author_image">
                        </div>
                    </div>
                </div>
                
                <!-- Buttons -->
                <div class="mt-4">
                    <button type="button" onclick="tpAuthorsAdd()" class="btn btn-primary">
                        <i class="fas fa-save"></i> Submit
                    </button>
                    <button type="button" onclick="history.back()" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var base_url = window.location.origin;

    function tpAuthorsAdd() {
        const data = {
            publisher_id: $('#publisher_id').val(),
            author_name: $('#author_name').val(),
            mobile: $('#mobile').val(),
            email_id: $('#email_id').val(),
            author_discription: $('#author_discription').val(),
            author_image: $('#author_image').val(),
        };

        $.ajax({
            url: base_url + '/tpauthor/tpauthorsadd',  // adjust this to your actual endpoint
            type: 'POST',
            data: data,
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    location.reload();
                } else if (response.error && response.messages) {
                    let errors = '';
                    for (const key in response.messages) {
                        errors += `${key}: ${response.messages[key]}\n`;
                    }
                    alert("Validation Errors:\n" + errors);
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert("Something went wrong on the server.");
            }
        });
    }
</script>

<?= $this->endSection(); ?>