<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header mb-4">
            <div class="page-title d-flex justify-content-between align-items-center">
                <h6>Edit Narrator - <?= esc($narrator_data['narrator_name']) ?></h6>
                
            </div>
        </div>

        <div class="row g-4">
            <!-- Left Column -->
            <div class="col-md-6">
                <label>Narrator Name</label>
                <input type="text" value="<?= esc($narrator_data['narrator_name']) ?>" oninput="fill_url_name()" class="form-control mb-3" id="narrator_name" placeholder="Name">

                <label>URL Name</label>
                <input type="text" value="<?= esc($narrator_data['narrator_url']) ?>" class="form-control mb-3" id="narrator_url_name" placeholder="URL Name">

                <label>Mobile No.</label>
                <input type="text" value="<?= esc($narrator_data['mobile']) ?>" class="form-control mb-3" id="narrator_mobile" placeholder="Mobile Number">

                <label>Email</label>
                <input type="text" value="<?= esc($narrator_data['email']) ?>" class="form-control mb-3" id="narrator_email" placeholder="E-Mail">

                <label>Narrator Image</label>
                <input type="text" value="<?= esc($narrator_data['narrator_image']) ?>" class="form-control mb-3" id="narrator_image" placeholder="Narrator Image">
            </div>

            <!-- Right Column -->
            <div class="col-md-6">
                <label>Description</label>
                <textarea class="form-control mb-3" id="description" rows="13"><?= esc($narrator_data['description']) ?></textarea>

                <label>User ID</label>
                <input type="text" value="<?= esc($narrator_data['user_id']) ?>" class="form-control mb-3" id="narrator_user_id" placeholder="User Id">

                <div class="d-flex gap-2 mt-3">
                    <button onclick="edit_narrator()" class="btn btn-primary">Modify</button>
                    <?php if (isset($narrator_books_list)) : ?>
                        <button onclick="add_book()" class="btn btn-secondary">Add Book</button>
                    <?php endif; ?>
                    <a href="<?= base_url('narrator/narratordashboard') ?>" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>

        <!-- Narrator Books Table -->
        <?php if (isset($narrator_books_list)) : ?>
            <div class="mt-5">
                <h5>Narrator's Books</h5>
                <table class="table table-hover table-light zero-config">
                    <thead>
                        <tr>
                            <th>Book ID</th>
                            <th>Book Title</th>
                            <th>Author</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($narrator_books_list as $book) : ?>
                            <tr>
                                <td><?= esc($book['book_id']) ?></td>
                                <td><?= esc($book['book_title']) ?></td>
                                <td><?= esc($book['author_name']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
var base_url = window.location.origin;

function fill_url_name() {
    let name = document.getElementById('narrator_name').value;
    let formatted_name = name.replace(/[^a-z\d\s]+/gi, "").split(' ').join('-').toLowerCase();
    document.getElementById('narrator_url_name').value = formatted_name;
}

function edit_narrator() {
    $.ajax({
        url: base_url + '/narrator/editnarratorpost',
        type: 'POST',
        data: {
            narrator_name: $('#narrator_name').val(),
            narrator_url_name: $('#narrator_url_name').val(),
            mobile: $('#narrator_mobile').val(),
            email: $('#narrator_email').val(),
            description: $('#description').val(),
            user_id: $('#narrator_user_id').val(),
            narrator_image: $('#narrator_image').val(),
            narrator_id: <?= esc($narrator_data['narrator_id']) ?>,
            <?= csrf_token() ?>: '<?= csrf_hash() ?>'  // include CSRF token
        },
        dataType: 'json',
        success: function(response) {
            if(response == 1) {
                alert("Narrator Edited Successfully");
                location.reload(); // optional: refresh page after edit
            } else {
                alert("Something went wrong!");
            }
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
            alert("AJAX Error: " + error);
        }
    });
}


function add_book() {
    var user_id = prompt("Enter Narrator User Id:");
    var book_id = prompt("Enter Book Id:");

    $.post(base_url + '/narrator/addbook', {  // <-- Added missing slash
        book_id: book_id,
        user_id: user_id
    }, function(data) {
        if (data == 1) {
            alert("Book added to narrator library!");
            location.reload(); 
        } else if (data == 2) {
            alert("Book ID or User ID cannot be zero!");
        } else {
            alert("Something went wrong!");
        }
    });
}

</script>

<?= $this->endSection(); ?>
