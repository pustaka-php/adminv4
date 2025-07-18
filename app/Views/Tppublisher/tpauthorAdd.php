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

<script>
function tpAuthorsAdd() {
  const publisher_id         = $('#publisher_id').val();
  const author_name          = $('#author_name').val();
  const mobile               = $('#mobile').val();
  const email_id             = $('#email_id').val();
  const author_discription   = $('#author_discription').val();
  const author_image         = $('#author_image').val();

  if (!publisher_id || !author_name) {
    alert('Publisher and Author Name are required.');
    return;
  }

  $.ajax({
    url: "<?= base_url('tppublisher/tpAuthoradd') ?>",
    type: 'POST',
    data: {
      publisher_id,
      author_name,
      mobile,
      email_id,
      author_discription,
      author_image
    },
    dataType: 'json',
    success: function(response) {
      console.log(response);
      if (response.status === 'success') {
        alert("Author added successfully!");
        location.reload();
      } else {
        alert(response.message || "Failed to add author.");
      }
    },
    error: function(xhr) {
      alert("AJAX error: " + xhr.status + " - " + xhr.statusText);
    }
  });
}
</script>

<?= $this->endSection(); ?>