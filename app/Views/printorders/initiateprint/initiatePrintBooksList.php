<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>
<div id="content" class="main-content">
	<div class="layout-px-spacing">
		<div class="page-header">
			<div class="page-title">
				<h6 class="text-center">Selected Books List</h6>
                <br>
			</div>
		</div>

        <form id="ajaxForm" class="text-left" method="POST">
			<div class="form">
                <input type="hidden" value="Initiate_print" name="type">
                <input type="hidden" value="<?php echo count($selected_books_data); ?>" name="num_of_books">
                <input type="hidden" value="<?php echo $selected_book_id; ?>" name="selected_book_list">

                <table class="zero-config table table-hover mt-4">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Book ID</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>In progress</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i=1;
                            $j=1;
                            foreach($selected_books_data as $selected_books)  {?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td>
                                        <input type="text" class="form-control" value="<?php echo $selected_books['book_id'] ?>" name="book_id<?php echo $j; ?>" readonly>
                                    </td>
                                    <td><?php echo $selected_books['book_title'] ?></td>
                                    <td><?php echo $selected_books['author_name'] ?></td>
                                    <td><?php echo $selected_books['Qty'] ?></td>
                                    <td class="text-center">
                                        <input type="text" class="form-control" placeholder="0" name="bk_qty<?php echo $j++; ?>" required>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                </table>
                <br>
                <div class="d-sm-flex right-content-between">
                    <div class="field-wrapper">
                        <button style="background-color: #77B748 !important; border-color: #77B748 !important;" type="submit" class="btn btn-primary" value="">Submit</button>
                        <a href="<?php echo base_url()."orders/ordersdashboard"  ?>" class="btn btn-danger">Cancel</a>
                    </div>
                </div>
            </div>
		</form>             
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    var base_url = "<?= base_url(); ?>"; 

    $(function () {
       
        $('#ajaxForm').on('keypress', function (e) {
            if (e.keyCode === 13) {
                e.preventDefault();
            }
        });
        $('#ajaxForm').on('submit', function (e) {
            e.preventDefault(); 

            var formData = $(this).serialize();

            $.ajax({
                type: "POST",
                url: base_url + "paperback/uploadquantitylist",
                data: formData,
                dataType: "json",
                success: function (response) {
                    console.log("Server Response:", response);
                    if (response.status == 1) {
                        alert("Added Successfully!!");
                        window.location.href = base_url + "orders/ordersdashboard";
                    } else {
                        alert("Unknown error!! Check again!");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", xhr.responseText);
                    alert("Something went wrong with the request!");
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>
