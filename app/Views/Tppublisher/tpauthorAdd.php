<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?> 

<div class="row gy-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="fas fa-user-edit"></i> New Author Add</h5>
            </div>
            <div class="card-body">
                <div class="row gy-3">
                    <div class="col-12">
                        <label class="form-label"><strong><i class="fas fa-building"></i> Publisher</strong></label>
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
                    
                    <div class="col-12">
                        <label class="form-label"><strong><i class="fas fa-user"></i> Author Name</strong></label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="f7:person"></iconify-icon>
                            </span>
                            <input type="text" name="author_name" id="author_name" class="form-control" placeholder="Enter Author Name">
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <label class="form-label"><strong><i class="fas fa-phone"></i> Mobile</strong></label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="solar:phone-calling-linear"></iconify-icon>
                            </span>
                            <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Enter Mobile Number">
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <label class="form-label"><strong><i class="fas fa-envelope"></i> Email</strong></label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="mage:email"></iconify-icon>
                            </span>
                            <input type="email" name="email_id" id="email_id" class="form-control" placeholder="Enter Email Address">
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <label class="form-label"><strong><i class="fas fa-align-left"></i> Author Description</strong></label>
                        <textarea name="author_discription" id="author_discription" rows="5" class="form-control" placeholder="Author Description"></textarea>
                    </div>
                    
                    <div class="col-12">
                        <label class="form-label"><strong><i class="fas fa-image"></i> Author Image</strong></label>
                        <input type="file" name="author_image" id="author_image" class="form-control">
                    </div>
                    
                    <div class="col-12 mt-4 text-center">
                        <button onclick="tpAuthorsAdd()" class="btn btn-success-600 radius-8 px-20 py-11">
                            <i class="fas fa-save"></i> Submit
                        </button>

                        <a href="javascript:void(0)" onclick="history.back()" class="btn btn-info-600 radius-8 px-20 py-11">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
<script type="text/javascript">
    var base_url = "<?= base_url(); ?>";
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