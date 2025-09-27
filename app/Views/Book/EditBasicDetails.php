<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="layout-px-spacing">
  <div class="page-header mb-4">
    <h3 class="mb-1">Edit Book Basic Details</h3>
    <p class="text-muted">
      <?= esc($book_details['book_title']) ?> (ID: <?= esc($book_details['book_id']) ?>) |
      Current State: <?= ($book_details['status'] == 0) ? 'Inactive' : 'Active' ?>
    </p>
  </div>

  <div class="card shadow-sm mb-4">
    <div class="card-body">
      <form id="editBookForm">
        <div class="row">
          <!-- Left Column -->
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Book Title</label>
              <input type="text" class="form-control" id="book_title" name="book_title" value="<?= esc($book_details['book_title']) ?>">
            </div>

            <div class="mb-3">
              <label class="form-label">Regional Book Title</label>
              <input type="text" class="form-control" id="regional_book_title" name="regional_book_title" value="<?= esc($book_details['regional_book_title']) ?>">
            </div>

            <div class="mb-3">
              <label class="form-label">URL Name</label>
              <input type="text" class="form-control" id="url_name" name="url_name" value="<?= esc($book_details['url_name']) ?>">
            </div>

            <div class="mb-3">
              <label class="form-label">Author Name</label>
              <select class="form-control" id="author_id" name="author_id">
                <?php foreach ($author_list as $author) : ?>
                  <option value="<?= esc($author->author_id) ?>" <?= ($author_details['author_id'] == $author->author_id) ? 'selected' : '' ?>>
                    <?= esc($author->author_name) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Language</label>
              <select class="form-control" id="language_id" name="language_id">
                <?php foreach ($language_list as $lang) : ?>
                  <option value="<?= esc($lang->language_id) ?>" <?= ($book_details['language'] == $lang->language_id) ? 'selected' : '' ?>>
                    <?= esc($lang->language_name) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <!-- Right Column -->
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Genre</label>
              <select class="form-control" id="genre_id" name="genre_id">
                <?php foreach ($genre_list as $genre) : ?>
                  <option value="<?= esc($genre->genre_id) ?>" <?= ($book_details['genre_id'] == $genre->genre_id) ? 'selected' : '' ?>>
                    <?= esc($genre->genre_name) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Category</label>
              <select class="form-control" id="type_name" name="type_name">
                <?php foreach ($type_list as $type) : ?>
                  <option value="<?= esc($type->type_name) ?>" <?= ($book_details['book_category'] == $type->type_name) ? 'selected' : '' ?>>
                    <?= esc($type->type_name) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Number of Pages</label>
              <input type="number" class="form-control" id="num_pages" name="num_pages" value="<?= esc($book_details['number_of_page']) ?>" oninput="populate_cost()">
            </div>

            <div class="mb-3">
              <label class="form-label">Book ID Mapping</label>
              <input type="text" class="form-control" id="book_id_mapping" name="book_id_mapping" value="<?= esc($book_details['book_id_mapping']) ?>">
            </div>

            <div class="mb-3">
              <label class="form-label">Description</label>
              <textarea class="form-control" id="desc_text" rows="4" oninput="count_chars()"><?= esc($book_details['description']) ?></textarea>
            </div>

            <div class="mb-3">
              <label class="form-label">Remarks</label>
              <textarea class="form-control" id="ebook_remarks" rows="3" oninput="count_chars()"><?= esc($book_details['ebook_remarks']) ?></textarea>
              <div class="form-text">Characters: <span id="num_chars">0</span></div>
            </div>

            <div class="row">
              <div class="col-6">
                <label class="form-label">Cost (INR)</label>
                <input type="text" class="form-control" id="cost_inr" value="<?= esc($book_details['cost']) ?>" name="cost_inr">
              </div>
              <div class="col-6">
                <label class="form-label">Cost (USD)</label>
                <input type="text" class="form-control" id="cost_usd" value="<?= esc($book_details['book_cost_international']) ?>" name="cost_usd">
              </div>
            </div>
          </div>
        </div>

        <div class="mt-4">
          <button type="button" class="btn btn-primary btn-lg" onclick="edit_basic_details()">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
var base_url = window.location.origin;

function edit_basic_details() {
  var formData = {
    book_id: <?= esc($book_details['book_id']) ?>,
    book_title: document.getElementById('book_title').value,
    regional_book_title: document.getElementById('regional_book_title').value,
    url_name: document.getElementById('url_name').value,
    author_id: document.getElementById('author_id').value,
    language_id: document.getElementById('language_id').value,
    genre_id: document.getElementById('genre_id').value,
    category_name: document.getElementById('type_name').value,
    description: document.getElementById('desc_text').value,
    ebook_remarks: document.getElementById('ebook_remarks').value,
    book_id_mapping: document.getElementById('book_id_mapping').value,
    num_pages: document.getElementById('num_pages').value,
    cost_inr: document.getElementById('cost_inr').value,
    cost_usd: document.getElementById('cost_usd').value
  };

  $.ajax({
    url: base_url + '/book/editbookbasicdetailspost',
    type: 'POST',
    data: formData,
    dataType: 'json',
    success: function(data) {
        if (data.status === 'success') {
            alert(data.message);
            // Refresh the page to show updated view
            location.reload();
        } else {
            alert(data.message);
        }
    },
    error: function(xhr, status, error) {
        alert('An unexpected error occurred: ' + xhr.responseText);
    }
});
}

function populate_cost() {
  var num_pages = document.getElementById("num_pages").value;
  // add your cost logic here...
}

function count_chars() {
  document.getElementById('num_chars').textContent = document.getElementById('desc_text').value.length;
}
</script>

<?= $this->endSection(); ?>
