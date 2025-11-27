<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 

<div class="row gy-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Add Publisher Book Stock</h5>
            </div>
            <div class="card-body">
                <form id="book_stock_form">
                    <div class="row gy-3">

                        <!-- Publisher - Author Dropdown -->
                        <div class="col-12">
                            <label class="form-label">Publisher-Author</label>
                            <select name="author_id" id="author_id" class="form-control">
                                <option value="">Select Publisher-Author</option>
                                <?php if (!empty($publisher_author_details)) : ?>
                                    <?php foreach ($publisher_author_details as $authors) : ?>
                                        <option value="<?= $authors->author_id; ?>">
                                            <?= esc($authors->author_name) . ' (' . esc($authors->publisher_name) . ')'; ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <!-- Book Dropdown -->
                        <div class="col-12">
                            <label class="form-label">Book</label>
                            <select name="book_id" id="book_id" class="form-control">
                                <option value="">Select Book</option>
                            </select>
                        </div>

                        <!-- Quantity Input -->
                        <div class="col-12">
                            <label class="form-label">Book Quantity</label>
                            <input type="number" min="1" class="form-control" name="book_quantity" id="book_quantity" placeholder="Enter quantity">
                        </div>

                        <!-- Description Input -->
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <input type="text" class="form-control" id="description" name="description"
                                   value="Stock added to Inventory">
                        </div>

                        <!-- Buttons -->
                        <div class="col-12 d-flex gap-3">
                            <button type="button" onclick="stock_add()" class="btn btn-primary flex-grow-1">Submit</button>
                            <button type="button" onclick="history.back()" class="btn btn-secondary flex-grow-1">Back</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {
    $('#author_id').change(function () {
        var author_id = $(this).val();
        $.ajax({
            type: 'POST',
            url: "<?= base_url('tppublisher/getAuthorTpBook') ?>",
            data: { author_id: author_id },
            success: function (data) {
                $('#book_id').html(data || '<option value="">No books available</option>');
            },
            error: function () {
                alert('Failed to load books.');
            }
        });
    });
});


function stock_add() {
    var author_id = $('#author_id').val();
    var book_id = $('#book_id').val();
    var book_quantity = $('#book_quantity').val();
    var description = $('#description').val();

    if (!author_id || !book_id || !book_quantity) {
        alert('Please fill in all fields.');
        return false;
    }

    $.ajax({
        url: '<?= base_url('tppublisher/addTpBookStock'); ?>',
        type: 'POST',
        data: {
            author_id: author_id,
            book_id: book_id,
            book_quantity: book_quantity,
            description: description
        },
        success: function (response) {
            if (response.status == 1) {
                alert("Book stock successfully added!");
                location.reload();
            } else {
                alert("Book stock not added. Please try again.");
            }
        },
        error: function () {
            alert("An error occurred while adding stock.");
        }
    });

    return false;
}
</script>

<?= $this->endSection(); ?>
