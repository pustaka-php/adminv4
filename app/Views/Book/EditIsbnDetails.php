<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="layout-px-spacing">
  <!-- Page Header -->
  <div class="page-header mb-4">
    <div class="page-title">
      <h6 class="fw-bold">
        Edit Book ISBN Details - <?= esc($book_details['book_title']) ?> (ID: <?= esc($book_details['book_id']) ?>)
      </h6>
      <?php $status = ($book_details['status'] == 0) ? "Inactive" : "Active"; ?>
      <h6 class="mt-2">
        Current State: 
        <?= esc($status) ?>
        </span>
      </h6>
    </div>
  </div>

  <!-- Edit Form Card -->
  <div class="row">
    <div class="col-lg-6">
      <div class="card shadow-sm border-0 radius-12">
        <div class="card-body">
          <!-- ISBN -->
          <div class="mb-3">
            <label for="epub_isbn" class="form-label fw-semibold">EPUB ISBN Number</label>
            <input type="text" id="epub_isbn"
                   value="<?= esc($book_details['isbn_number']) ?>"
                   class="form-control" name="epub_isbn"
                   placeholder="Enter ISBN Number">
          </div>

          <!-- Agreement -->
          <div class="mb-3">
            <label class="form-label fw-semibold">Exists in Agreement?</label>
            <div>
             <div class="form-check form-check-inline me-5">
  <input class="form-check-input" type="radio"
         name="agreement_flag" id="agreement_yes" value="1"
         <?= ($book_details['agreement_flag'] == 1) ? 'checked' : '' ?>>
  <label class="form-check-label ms-2" for="agreement_yes">Yes</label>
</div>

<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio"
         name="agreement_flag" id="agreement_no" value="0"
         <?= ($book_details['agreement_flag'] == 0) ? 'checked' : '' ?>>
  <label class="form-check-label ms-2" for="agreement_no">No</label>
</div>

            </div>
          </div>

          <!-- Royalty -->
          <div class="mb-3">
            <label for="royalty" class="form-label fw-semibold">ePUB Royalty</label>
            <input type="text" id="royalty"
                   value="<?= esc($book_details['royalty']) ?>"
                   class="form-control" name="royalty"
                   placeholder="Enter Royalty Percentage or Value">
          </div>

          <!-- Action Button -->
          <div class="text-end">
            <button onclick="edit_isbn_details()" class="btn btn-primary px-4">
              <i class="bi bi-pencil-square me-1"></i> Modify
            </button>
            <a href="javascript:history.back()" class="btn btn-light ms-2">
            Cancel
          </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  var base_url = "<?= base_url() ?>";

  function edit_isbn_details() {
    var isbn_number = document.getElementById('epub_isbn').value.trim();
    var royalty = document.getElementById('royalty').value.trim();
    var agreement_flag = document.querySelector('input[name="agreement_flag"]:checked').value;

    var payload = {
      book_id: <?= (int)$book_details['book_id'] ?>,
      isbn_number: isbn_number,
      royalty: royalty,
      agreement_flag: agreement_flag
    };

    $.ajax({
      url: base_url + '/book/editbookisbndetailspost',
      type: 'POST',
      data: payload,
      success: function(data) {
        try {
          var res = (typeof data === 'object') ? data : JSON.parse(data);
        } catch (e) {
          res = null;
        }

        if (res && res.status === 'success') {
          alert(res.message);
          location.reload();
        } else if (data == 1 || data === '1') {
          alert("Edited Book Details Successfully!!!");
          location.reload();
        } else {
          alert((res && res.message) ? res.message : "Error Occurred!!");
        }
      },
      error: function(xhr) {
        alert("Error: " + (xhr.responseText || "Unexpected error"));
      }
    });
  }
</script>

<?= $this->endSection(); ?>
