<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="row gy-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Edit Publisher Book</h5>
            </div>
            <div class="card-body">
                <div class="row gy-3">
                    <div class="col-md-6">
                        <label class="form-label"><strong>Publisher</strong></label>
                        <select name="publisher_id" id="publisher_id" class="form-control">
                            <?php foreach ($publisher_details as $publisher): ?>
                                <option value="<?= esc($publisher->publisher_id) ?>"
                                    <?= ($publisher->publisher_id == $books_data['publisher_id']) ? 'selected' : '' ?>>
                                    <?= esc($publisher->publisher_name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><strong>Author</strong></label>
                        <select name="author_id" id="author_id" class="form-control">
                            <?php foreach ($author_details as $author): ?>
                                <option value="<?= esc($author->author_id) ?>"
                                    <?= ($author->author_id == $books_data['author_id']) ? 'selected' : '' ?>>
                                    <?= esc($author->author_name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><strong>Book ID</strong></label>
                        <input class="form-control" name="book_id" id="book_id" value="<?= esc($books_data['book_id']) ?>" readonly />
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><strong>Publisher Book ID</strong></label>
                        <input class="form-control" name="sku_no" id="sku_no" value="<?= esc($books_data['sku_no']) ?>" readonly />
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><strong>Book Title</strong></label>
                        <input class="form-control" name="book_title" id="book_title" value="<?= esc($books_data['book_title']) ?>" />
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><strong>Regional Title</strong></label>
                        <input class="form-control" name="book_regional_title" id="book_regional_title" value="<?= esc($books_data['book_regional_title']) ?>" />
                    </div>

                    <div class="col-12">
                        <label class="form-label"><strong>Book URL</strong></label>
                        <input class="form-control" name="book_url" id="book_url" value="<?= esc($books_data['book_url']) ?>" />
                    </div>

                    <div class="col-12">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="initiate_to_print" name="initiate_to_print"
                                <?= $books_data['initiate_to_print'] == 1 ? 'checked' : '' ?> />
                            <label class="form-check-label" for="initiate_to_print">Initiate to Print</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label"><strong>Genre</strong></label>
                        <select class="form-control" name="book_genre" id="book_genre">
                            <?php foreach ($genre_details as $genre): ?>
                                <option value="<?= esc($genre->genre_id) ?>"
                                    <?= ($genre->genre_id == $books_data['book_genre']) ? 'selected' : '' ?>>
                                    <?= esc($genre->genre_name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label"><strong>Type</strong></label>
                        <select class="form-control" name="type_name" id="type_name">
                            <?php foreach ($type_details as $type): ?>
                                <option value="<?= esc($type->book_type_id) ?>"
                                    <?= ($type->book_type_id == $books_data['type_name']) ? 'selected' : '' ?>>
                                    <?= esc($type->type_name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label"><strong>Language</strong></label>
                        <select class="form-control" name="language" id="language">
                            <?php foreach ($language_details as $language): ?>
                                <option value="<?= esc($language->language_id) ?>"
                                    <?= ($language->language_id == $books_data['language']) ? 'selected' : '' ?>>
                                    <?= esc($language->language_name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label"><strong>Book Description</strong></label>
                        <textarea class="form-control" name="book_description" id="book_description" rows="3"><?= esc($books_data['book_description']) ?></textarea>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label"><strong>Pages</strong></label>
                        <input class="form-control" name="no_of_pages" id="no_of_pages" value="<?= esc($books_data['no_of_pages']) ?>" />
                    </div>

                    <div class="col-md-4">
                        <label class="form-label"><strong>MRP</strong></label>
                        <input class="form-control" name="mrp" id="mrp" value="<?= esc($books_data['mrp']) ?>" />
                    </div>

                    <div class="col-md-4">
                        <label class="form-label"><strong>Pustaka Price</strong></label>
                        <input class="form-control" name="pustaka_price" id="pustaka_price" value="<?= esc($books_data['pustaka_price']) ?>" />
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><strong>ISBN</strong></label>
                        <input class="form-control" name="isbn" id="isbn" value="<?= esc($books_data['isbn']) ?>" />
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><strong>Discount</strong></label>
                        <input class="form-control" name="discount" id="discount" value="<?= esc($books_data['discount']) ?>" />
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><strong>Amazon Link</strong></label>
                        <input class="form-control" name="amazon_link" id="amazon_link" value="<?= esc($books_data['amazon_link']) ?>" />
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><strong>Amazon ASIN</strong></label>
                        <input class="form-control" name="amazon_asin" id="amazon_asin" value="<?= esc($books_data['amazon_asin']) ?>" />
                    </div>

                    <div class="col-12 mt-4 text-center">
                        <button type="button" onclick="books_update(event)" class="btn btn-success-600 radius-8 px-20 py-11">
                            Update Book
                        </button>
                        <a href="javascript:void(0)" onclick="history.back()" class="btn btn-info-600 radius-8 px-20 py-11">
                            Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var base_url = "<?= base_url() ?>";

    function books_update(event) {
        event.preventDefault();

        var data = {
            publisher_id: $('#publisher_id').val(),
            author_id: $('#author_id').val(),
            book_id: $('#book_id').val(),
            book_title: $('#book_title').val(),
            book_regional_title: $('#book_regional_title').val(),
            book_url: $('#book_url').val(),
            initiate_to_print: $('#initiate_to_print').is(':checked') ? 1 : 0,
            book_genre: $('#book_genre').val(),
            type_name: $('#type_name').val(),
            language: $('#language').val(),
            book_description: $('#book_description').val(),
            no_of_pages: $('#no_of_pages').val(),
            mrp: $('#mrp').val(),
            pustaka_price: $('#pustaka_price').val(),
            isbn: $('#isbn').val(),
            discount: $('#discount').val(),
            amazon_link: $('#amazon_link').val(),
            amazon_asin: $('#amazon_asin').val()
        };

        $.ajax({
            url: base_url + '/tppublisher/edittpbookpost',
            type: 'POST',
            data: data,
            success: function(response) {
                if (response == 1) {
                    alert("Book details successfully updated!");
                    location.reload();
                } else {
                    alert("Book not updated! Please try again.");
                }
            },
            error: function() {
                alert("An error occurred while updating the book details.");
            }
        });
    }
</script>

<?= $this->endSection(); ?>