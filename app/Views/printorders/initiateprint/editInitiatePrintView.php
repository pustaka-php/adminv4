<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h6 class="text-center">Paperback Book Details</h6>
                <br>
            </div>
        </div>

        <div class="col-7">
            <form id="editQuantityForm">
                <input type="hidden" class="form-control" id="id" name="id" 
                       value="<?= $initiate_print['id']; ?>" readonly style="color: black;">

                <div class="form-group">
                    <label for="bookId">Book Id</label>
                    <input type="text" class="form-control" id="book_id" name="book_id" 
                           value="<?= $initiate_print['book_id']; ?>" readonly style="color: black;">
                </div>

                <div class="form-group">
                    <label for="bookTitle">Book Title</label>
                    <input type="text" class="form-control" id="book_title" name="book_title" 
                           value="<?= $initiate_print['book_title']; ?>" readonly style="color: black;">
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="text" class="form-control" id="quantity" name="quantity" required
                           value="<?= $initiate_print['quantity']; ?>">
                </div>
            </form>
        </div>
        <br><br>
        <center>
            <div class="field-wrapper">
                <button type="button" onclick="edit_quantity()" class="btn btn-success">Submit</button>
                <a href="<?= base_url('paperback/paperbackprintstatus'); ?>" class="btn btn-danger">Close</a>
            </div>
        </center>
    </div>
</div>

<script type="text/javascript">
    function edit_quantity() {
        var base_url = "<?= base_url() ?>";  

        var id = document.getElementById('id').value;
        var quantity = document.getElementById('quantity').value;

        $.ajax({
            url: base_url + 'paperback/editquantity',  
            type: 'POST',
            data: { id: id, quantity: quantity },
            dataType: 'json',  
            success: function (data) {
                if (data.status == 1) {
                    alert("Successfully quantity changed!!");
                    window.close();
                } else {
                    alert("Unknown error!! Check again!");
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
                alert("AJAX request failed!");
            }
        });
    }
</script>

<?= $this->endSection(); ?>
