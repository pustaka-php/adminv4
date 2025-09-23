<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h6 class="text-center">Paperback Book details</h6>
                <br>
            </div>
        </div>
        <div class="col-7">
            <form id="bookForm">
                <div class="form-group">
                    <label for="bookId">Book Id</label>
                    <input type="text-dark" class="form-control" id="book_id" name="book_id" value="<?= $initiate_print['book_id']; ?>" readonly >
                </div>
                <br>
                <div class="form-group">
                    <label for="bookTitle">Book Title</label>
                    <input type="text" class="form-control" id="book_title" name="book_title" value="<?= $initiate_print['book_title']; ?>" readonly>
                </div>
                <br>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="text" class="form-control" id="quantity" name="quantity" required>
                </div>
            </form>
        </div>
        <br><br>
        <center>
            <div class="field-wrapper">
                <!-- Changed <a> to button -->
                <button type="button" onclick="update_quantity()" class="btn btn-success">Submit</button>
                <a href="<?= base_url('orders/ordersdashboard') ?>" class="btn btn-danger">Close</a>
            </div>
        </center>
    </div>
</div>

<script>
function update_quantity() {
    var book_id = document.getElementById('book_id').value;
    var quantity = document.getElementById('quantity').value;

    $.ajax({
        url: "<?= base_url('paperback/updatequantity') ?>",
        type: 'POST',
        data: {
            book_id: book_id,
            quantity: quantity,
            <?= csrf_token() ?>: '<?= csrf_hash() ?>'
        },
        success: function (data) {
            if (data == 1) {
                alert("Successfully added!!");
                window.close();
            } else {
                alert("Unknown error!! Check again!");
            }
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
            alert("AJAX error: " + error);
        }
    });
}
</script>
<?= $this->endSection(); ?>
