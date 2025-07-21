<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Add Publisher Book Details</h5>
    </div>
    <div class="card-body">
        <div class="row gy-4">
            <!-- Publisher -->
            <div class="col-md-6">
                <label class="form-label">Publisher</label>
                <select id="publisher_id" class="form-select">
                    <option value="">Select Publisher</option>
                    <?php foreach ($publisher_details as $pub): ?>
                        <option value="<?= $pub->publisher_id ?>"><?= esc($pub->publisher_name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Author -->
            <div class="col-md-6">
                <label class="form-label">Author</label>
                <select id="author_id" class="form-select">
                    <option value="">Select Author</option>
                </select>
            </div>

            <!-- Publisher Book ID -->
            <div class="col-md-6">
                <label class="form-label">Publisher Book Id</label>
                <input id="sku_no" type="text" class="form-control">
            </div>

            <!-- Book Title -->
            <div class="col-md-6">
                <label class="form-label">Book Title</label>
                <input id="book_title" type="text" class="form-control" oninput="fill_url_title()">
            </div>

            <!-- Regional Title -->
            <div class="col-md-6">
                <label class="form-label">Regional Title</label>
                <input id="book_regional_title" type="text" class="form-control">
            </div>

            <!-- Book URL -->
            <div class="col-md-6">
                <label class="form-label">Book URL</label>
                <input id="book_url" type="text" class="form-control" readonly>
            </div>

            <!-- Genre -->
            <div class="col-md-6">
                <label class="form-label">Genre</label>
                <select id="book_genre" class="form-select">
                    <?php foreach ($genre_details as $g): ?>
                        <option value="<?= $g->genre_id ?>"><?= htmlspecialchars($g->genre_name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Book Type -->
            <div class="col-md-6">
                <label class="form-label">Book Type</label>
                <select id="type_name" class="form-select">
                    <?php foreach ($type_details as $t): ?>
                        <option value="<?= $t->book_type_id ?>"><?= htmlspecialchars($t->type_name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Language -->
            <div class="col-md-6">
                <label class="form-label">Language</label>
                <select id="language" class="form-select">
                    <?php foreach ($language_details as $l): ?>
                        <option value="<?= $l->language_id ?>"><?= htmlspecialchars($l->language_name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Page Count -->
            <div class="col-md-6">
                <label class="form-label">Page Count</label>
                <input id="no_of_pages" type="number" class="form-control">
            </div>

            <!-- MRP -->
            <div class="col-md-6">
                <label class="form-label">MRP (₹)</label>
                <div class="input-group">
                    <span class="input-group-text">₹</span>
                    <input id="mrp" type="number" step="0.01" class="form-control">
                </div>
            </div>

            <!-- Pustaka Price -->
            <div class="col-md-6">
                <label class="form-label">Pustaka Price (₹)</label>
                <div class="input-group">
                    <span class="input-group-text">₹</span>
                    <input id="pustaka_price" type="number" step="0.01" class="form-control">
                </div>
            </div>

            <!-- ISBN -->
            <div class="col-md-6">
                <label class="form-label">ISBN</label>
                <input id="isbn" type="text" class="form-control">
            </div>

            <!-- Discount -->
            <div class="col-md-6">
                <label class="form-label">Discount (%)</label>
                <div class="input-group">
                    <input id="discount" type="number" min="0" max="100" class="form-control">
                    <span class="input-group-text">%</span>
                </div>
            </div>

            <!-- Checkbox -->
            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="initiate_to_print">
                    <label class="form-check-label" for="initiate_to_print">Initiate to Print</label>
                </div>
            </div>

            <!-- Description -->
            <div class="col-12">
                <label class="form-label">Book Description</label>
                <textarea id="book_description" rows="5" class="form-control"></textarea>
            </div>

            <!-- Buttons -->
            <div class="col-12 mt-4">
                <div class="d-flex gap-3 justify-content-center">
                    <button onclick="window.history.back()" class="btn btn-danger-600 radius-8 px-20 py-11">
                        Back
                    </button>
                    <button onclick="book_add()" class="btn btn-success-600 radius-8 px-20 py-11">
                         Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $('#publisher_id').change(function () {
    var publisherId = $(this).val();

    console.log('Selected publisher:', publisherId);

    if (publisherId !== '') {
      $.ajax({
        url: "<?= base_url('tppublisher/getAuthorsByPublisher') ?>", 
        type: "POST",
        data: { publisher_id: publisherId },
        success: function (response) {
          console.log('AJAX response:', response);
          $('#author_id').html(response);
        },
        error: function (xhr) {
          console.log('AJAX error:', xhr.responseText);
          alert('Something went wrong while fetching authors!');
        }
      });
    } else {
      $('#author_id').html('<option value="">Select Author</option>');
    }
  });

  // Auto-generate URL from title
  function fill_url_title() {
    var title = $('#book_title').val().trim().toLowerCase();
    var url = title.replace(/[^a-z\d\s]+/g,'').replace(/\s+/g,'-');
    $('#book_url').val(url);
  }

  // Submit book data
  function book_add() {
    // Validate required fields
    if (!$('#publisher_id').val() || !$('#book_title').val()) {
      alert('Please fill in all required fields');
      return;
    }

    var data = {
      publisher_id: $('#publisher_id').val(),
      author_id: $('#author_id').val(),
      sku_no: $('#sku_no').val(),
      book_title: $('#book_title').val(),
      book_regional_title: $('#book_regional_title').val(),
      book_url: $('#book_url').val(),
      book_genre: $('#book_genre').val(),
      type_name: $('#type_name').val(),
      language: $('#language').val(),
      book_description: $('#book_description').val(),
      no_of_pages: $('#no_of_pages').val(),
      mrp: $('#mrp').val(),
      pustaka_price: $('#pustaka_price').val(),
      isbn: $('#isbn').val(),
      discount: $('#discount').val(),
      initiate_to_print: $('#initiate_to_print').is(':checked') ? 1 : 0
    };

    $.post('<?= base_url('tppublisher/tpBookPost') ?>', data, function(response) {
      if (response.success) {
        alert(response.message || 'Book details successfully added!');
        location.reload();
      } else {
        alert(response.message || 'Book not added! Please try again.');
      }
    }, 'json').fail(function() {
      alert('Server error occurred. Please try again later.');
    });
  }
</script>

<?= $this->endSection(); ?>