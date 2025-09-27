<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="layout-px-spacing">
  <!-- Page Header -->
  <div class="page-header mb-4">
    <div class="page-title">
      <h6 class="fw-bold">
        Edit Book URL Details - <?= esc($book_details['book_title']) ?>
        <small class="text-muted">(ID: <?= esc($book_details['book_id']) ?>)</small>
      </h6>
      <?php $status = (isset($book_details['status']) && $book_details['status'] == 0) ? 'Inactive' : 'Active'; ?>
      <h6 class="mt-2">Current Status:
        
          <?= esc($status) ?>
        </span>
      </h6>
    </div>
  </div>

  <!-- Form Section -->
  <div class="card shadow-sm radius-10 p-4">
    <div class="row">
      <div class="col-md-8">
        <div class="mb-3">
          <label for="cover_url" class="form-label fw-semibold">Cover URL</label>
          <input type="text" id="cover_url" name="cover_url"
                 class="form-control"
                 value="<?= esc($book_details['cover_image']) ?>"
                 placeholder="Enter Cover Image URL">
        </div>

        <div class="mb-3">
          <label for="epub_url" class="form-label fw-semibold">ePUB URL</label>
          <input type="text" id="epub_url" name="epub_url"
                 class="form-control"
                 value="<?= esc($book_details['epub_url']) ?>"
                 placeholder="Enter ePUB File URL">
        </div>

        <div class="mt-4">
          <button type="button" class="btn btn-primary px-4" onclick="edit_url_details()">
            <i class="fa fa-save me-2"></i> Save Changes
          </button>
          <a href="javascript:history.back()" class="btn btn-light ms-2">
            Cancel
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Ajax Script -->
<script type="text/javascript">
  var base_url = "<?= base_url() ?>";

  function edit_url_details() {
    var cover_url = document.getElementById('cover_url').value.trim();
    var epub_url  = document.getElementById('epub_url').value.trim();

    var payload = {
      book_id: <?= (int)$book_details['book_id'] ?>,
      cover_image: cover_url,
      epub_url: epub_url
    };

    $.ajax({
      url: base_url + '/book/editurldetailspost',
      type: 'POST',
      data: payload,
      success: function(data) {
        let res = null;
        try {
          res = (typeof data === 'object') ? data : JSON.parse(data);
        } catch (e) {}

        if (res && res.status === 'success') {
          alert(res.message);
          location.reload();
        } else if (data == 1 || data === '1') {
          alert("Edited Book Details Successfully!!!");
          location.reload();
        } else {
          let msg = (res && res.message) ? res.message : "Error Occurred!!";
          alert(msg);
        }
      },
      error: function(xhr) {
        let msg = "Unexpected error";
        try {
          let j = JSON.parse(xhr.responseText);
          msg = j.message || xhr.responseText;
        } catch (e) {
          msg = xhr.responseText || msg;
        }
        alert("Error: " + msg);
      }
    });
  }
</script>

<?= $this->endSection(); ?>
