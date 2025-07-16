<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="row gy-4">
    <h2 style="font-weight: bold; color: #4b2c5e;">
        <i class="fas fa-user-edit"></i> New Author Add
      </h2>
    </div>

    <div>
      <label><strong><i class="fas fa-building"></i> Publisher</strong></label>
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

    <div>
      <label class="mt-3"><strong><i class="fas fa-user"></i> Author Name</strong></label>
      <input class="form-control" name="author_name" id="author_name" />

      <label class="mt-3"><strong><i class="fas fa-phone"></i> Mobile</strong></label>
      <input class="form-control" name="mobile" id="mobile" />

      <label class="mt-3"><strong><i class="fas fa-envelope"></i> Email</strong></label>
      <input class="form-control" name="email_id" id="email_id" />

      <label class="mt-3"><strong><i class="fas fa-align-left"></i> Author Description</strong></label>
      <textarea name="author_discription" id="author_discription" rows="5" class="form-control" placeholder="Author Description"></textarea>

      <label class="mt-3"><strong><i class="fas fa-image"></i> Author Image</strong></label>
      <input class="form-control" name="author_image" id="author_image" />
    </div>

    <div class="mt-4 text-center">
      <button onclick="tpAuthorsAdd()" class="btn btn-lg text-white"
              style="background: linear-gradient(to right, #43e97b 0%, #38f9d7 100%);
                     border: none; padding: 10px 25px; border-radius: 8px;">
        <i class="fas fa-save"></i> Submit
      </button>

      <a href="javascript:void(0)" onclick="history.back()" class="btn btn-outline-secondary btn-lg ml-3">
        <i class="fas fa-arrow-left"></i> Back
      </a>
    </div>
  </div>

</div>

<script type="text/javascript">
    var base_url = window.location.origin;
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