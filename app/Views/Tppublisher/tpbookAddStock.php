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
                        <div class="col-12">
                            <label class="form-label">Publisher-Author</label>
                            <select name="author_id" id="author_id" class="form-control">
                                <option value="" selected>Select publisher-Author</option>
                                <?php if (!empty($publisher_author_details)) {
                                    foreach ($publisher_author_details as $authors) { ?>
                                        <option value="<?= $authors->author_id; ?>">
                                            <?= $authors->author_name . ' (' . $authors->publisher_name . ')'; ?>
                                        </option>
                                <?php }} ?>
                            </select>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label">Book</label>
                            <select name="book_id" id="book-select" class="form-control">
                                <option value="" selected>Select Book</option>
                            </select>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label">Book Quantity</label>
                            <input type="text" class="form-control" name="book_quantity" id="book_quantity" placeholder="Enter quantity">
                        </div>
                        
                        <div class="col-12 d-flex gap-3">
                            <button type="button" onclick="stock_add()" class="btn btn-primary-600 flex-grow-1">
                                Submit
                            </button>
                            <button type="button" onclick="history.back()" class="btn btn-secondary flex-grow-1">
                                Back
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#author_id').change(function () {
            var author_id = $(this).val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url('tppublisher/getAuthorTpBook'); ?>',
                data: { author_id: author_id },
                success: function (data) {
                    $('#book-select').html(data || '<option value="">No books available</option>');
                }
            });
        });
    });

    function stock_add() {
        var author_id = $('#author_id').val();
        var book_id = $('#book-select').val();
        var book_quantity = $('#book_quantity').val();

        if (!author_id || !book_id || !book_quantity) {
            alert('Please fill in all fields');
            return false;
        }

        $.ajax({
            url: '<?= base_url('tppublisher/tpbookaddstock'); ?>',
            type: 'POST',
            data: {
                author_id: author_id,
                book_id: book_id,
                book_quantity: book_quantity
            },
            success: function (response) {
                if (response == 0) {
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