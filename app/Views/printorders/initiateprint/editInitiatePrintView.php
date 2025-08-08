<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>
<div id="content" class="main-content">
	<div class="layout-px-spacing">
		<div class="page-header">
			<div class="page-title">
				<h6 class="text-center">Paparback Book details</h6>
                <br>
			</div>
		</div>
        <div class="col-7">
        <form>
          <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $initiate_print['id']; ?>" readonly style="color: black;" >
              <div class="form-group">
                    <label for="bookId">Book Id</label>
                    <input type="text-dark" class="form-control" id="book_id" name="book_id" value="<?php echo $initiate_print['book_id']; ?>" readonly style="color: black;" >
                </div>

                <div class="form-group">
                    <label for="bookTitle">Book Title</label>
                    <input type="text" class="form-control" id="book_title" name="book_title" value="<?php echo $initiate_print['book_title']; ?>" readonly style="color: black;">
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="text" class="form-control" id="quantity" name="quantity" required value="<?php echo $initiate_print['quantity']; ?>">
                </div>
        </form>
        </div>

       <center> <div class="field-wrapper">
        <a href="" onclick="edit_quantity()" class="btn btn-success">Submit</a>
		<a href="<?php echo base_url()."paperback/paperbackprintstatus"  ?>" class="btn btn-danger">close</a>
		</div></center>
    </div>
</div>
<script type="text/javascript">
    var base_url = window.location.origin;

    function edit_quantity() {

        var id = document.getElementById('id').value;
        var quantity = document.getElementById('quantity').value;

        $.ajax({
            url: base_url + 'paperback/editquantity',
            type: 'POST',
            data: {
                "id": id,
                "quantity": quantity,
            },
            success: function (data) {
                if (data == 1) {
                    alert("Successfully quantity changed!!");
                    window.close();
                } else {
                    alert("Unknown error!! Check again!");
                }
            }
        });
    }
</script>
<?= $this->endSection(); ?>