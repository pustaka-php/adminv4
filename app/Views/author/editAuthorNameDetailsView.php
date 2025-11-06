<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 

<div id="content" class="main-content">
  <div class="layout-px-spacing">

      <div class="d-flex justify-content-between align-items-center mb-3">
          <h6 class="text-center mb-0">Author Language Table</h6><br><br>
          <a href="#" class="btn btn-outline-lilac-600 radius-8 px-20 py-11" onclick="showAddAuthorForm()">Add Author Language Name</a>
      </div>
      
      <table class="table table-bordered mb-4">
        <thead>
          <tr>
            <th>Author Id</th>
            <th>Language</th>
            <th>Display Name 1</th>
            <th>Display Name 2</th>
            <th>Regional Author Name</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody style="font-weight: normal;">
          <?php foreach ($author_language_details as $author_language_detail) { ?>
          <tr data-language-id="<?= $author_language_detail['language_id'] ?>">
              <td><?= $author_language_detail['author_id']; ?></td>
              <td>
                  <select name="language_id" class="form-select" disabled>
                      <?php foreach ($languages as $lang): ?>
                          <option value="<?= $lang['language_id']; ?>" 
                              <?= ($author_language_detail['language_id'] == $lang['language_id']) ? 'selected' : '' ?>>
                              <?= $lang['language_name']; ?>
                          </option>
                      <?php endforeach; ?>
                  </select>
              </td>
              <td>
                  <input type="text" name="display_name1" class="form-control" 
                         value="<?= $author_language_detail['display_name1']; ?>" readonly>
              </td>
              <td>
                  <input type="text" name="display_name2" class="form-control" 
                         value="<?= $author_language_detail['display_name2']; ?>" readonly>
              </td>
              <td>
                  <input type="text" name="regional_author_name" class="form-control" 
                         value="<?= $author_language_detail['regional_author_name']; ?>" readonly>
              </td>
              <td>
                  <button type="button" class="btn btn-outline-warning-600 radius-8 px-20 py-11" 
                          onclick="enableEdit(this)">Edit</button>
                  <button type="button" class="btn btn-outline-lilac-600 radius-8 px-20 py-11" 
                          onclick="updateAuthorLanguageRow(this)" style="display:none;">Update Table</button>
              </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>  
      <br><br>

      <div id="addAuthorForm" class="card" style="display:none; margin-top:20px;">
          <div class="card-header">
              <h5 class="card-title mb-0">Add New Author Language</h5>
          </div>
          <div class="card-body">
              <div class="row g-2">
                  <div class="col-lg-2">
                      <input type="text" id="author_id" class="form-control" 
                             value="<?= isset($author_id) ? $author_id : '' ?>" 
                             placeholder="Author Id" readonly>
                  </div>
                  <div class="col-lg-2">
                      <select id="language_id" class="form-select">
                          <option value="">Select Language</option>
                          <?php foreach ($languages as $lang): ?>
                              <option value="<?= $lang['language_id']; ?>"><?= $lang['language_name']; ?></option>
                          <?php endforeach; ?>
                      </select>
                  </div>
                  <div class="col-lg-2">
                      <input type="text" id="display_name1" class="form-control" placeholder="Display Name 1">
                  </div>
                  <div class="col-lg-2">
                      <input type="text" id="display_name2" class="form-control" placeholder="Display Name 2">
                  </div>
                  <div class="col-lg-3">
                      <input type="text" id="regional_author_name" class="form-control" placeholder="Regional Author Name">
                  </div>
                  <div class="col-lg-1 d-flex align-items-end">
                      <button type="button" class="btn btn-success w-100" onclick="addAuthorLanguage()">Save</button>
                  </div>
              </div>
          </div>
      </div>      
  </div>
</div>

<script type="text/javascript">
// Enable edit mode (make inputs & selects editable)
function enableEdit(button) {
    var row = button.closest('tr');
    row.querySelectorAll('input, select').forEach(el => {
        el.removeAttribute('readonly');
        el.removeAttribute('disabled');
    });
    button.style.display = 'none';
    row.querySelector('button.btn-outline-lilac-600').style.display = 'inline-block';
}

// Update author-language row via AJAX
function updateAuthorLanguageRow(button) {
    var row = button.closest('tr');
    var language_id = row.getAttribute('data-language-id');

    var data = {
        language_id: language_id,
        new_language_id: row.querySelector('select[name="language_id"]').value,
        display_name1: row.querySelector('input[name="display_name1"]').value,
        display_name2: row.querySelector('input[name="display_name2"]').value,
        regional_author_name: row.querySelector('input[name="regional_author_name"]').value
    };

    $.ajax({
        url: "<?= site_url('author/editauthornamedetailspost') ?>",
        type: 'POST',
        dataType: 'json',
        data: { author_language_details: [data] },
        success: function(response) {
            if (response.status == true || response.status == 1) {
                alert("Author language details updated successfully!");
                location.reload();
            } else {
                alert("Error updating details!");
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert("AJAX request failed: " + error);
        }
    });
}

// Add a new author-language entry
function addAuthorLanguage() {
    var data = {
        author_id: $('#author_id').val(),
        language_id: $('#language_id').val(),
        display_name1: $('#display_name1').val(),
        display_name2: $('#display_name2').val(),
        regional_author_name: $('#regional_author_name').val()
    };

    $.ajax({
        url: "<?= site_url('author/addauthornamelanguagepost') ?>",
        type: 'POST',
        dataType: 'json',
        data: data,
        success: function(response) {
            if (response.status) {
                alert("Successfully added!");
                $('#language_id').val('');
                $('#display_name1').val('');
                $('#display_name2').val('');
                $('#regional_author_name').val('');
                $('#addAuthorForm').hide();
                location.reload();
            } else {
                alert("Failed to add: " + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert("AJAX request failed: " + error);
        }
    });
}

// Show "Add Author Language" form
function showAddAuthorForm() {
    document.getElementById('addAuthorForm').style.display = 'block';
}
</script>

<?= $this->endSection(); ?>
