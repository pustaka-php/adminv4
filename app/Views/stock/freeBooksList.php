<div id="content" class="main-content">
	<div class="layout-px-spacing">
		<div class="page-header">
			<div class="page-title">
				<h3>Selected Books List</h3>
                <br>
			</div>
		</div>

        <?php 
            $num_copies=$_POST['num_copies'];
            $purpose=$_POST['purpose'];
            $print_type=$_POST['type'];
        ?>
        <form id="ajaxForm" class="text-left" method="POST">
			<div class="form">
                <input type="hidden" value="Free_books" name="type">
                <input type="hidden" value="<?php echo count($selected_books_data); ?>" name="num_of_books">
                <input type="hidden" value="<?php echo $num_copies; ?>" name="quantity">
                <input type="hidden" value="<?php echo $purpose; ?>" name="purpose">
                <input type="hidden" value="<?php echo $print_type; ?>" name="print_type">

                <table class="table table-hover mt-4">
                    <thead class="thead-dark">
                        <tr>
                            <th>S.No</th>
                            <th>Book ID</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Quantity</th>
                            <th>Purpose</th>
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
                                    <td class="text-center">
                                        <input type="text" class="form-control" value="<?php echo $num_copies ?>" placeholder="0" name="bk_qty<?php echo $j; ?>" required>
                                    </td>
                                    <td class="text-center">
                                       <textarea name="bk_purpose<?php echo $j; ?>" rows="3" class="form-control" placeholder="Enter Purpose Here"><?php echo htmlspecialchars($purpose, ENT_QUOTES, 'UTF-8'); ?></textarea>
                                    </td>
                                </tr>
                            <?php
                           $j++;
                        } ?>
                        </tbody>
                </table>
                <br>
                <div class="d-sm-flex right-content-between">
                    <div class="field-wrapper">
                        <button style="background-color: #77B748 !important; border-color: #77B748 !important;" type="submit" class="btn btn-primary" value="">Submit</button>
                        <a href="<?php echo base_url()."pustaka_paperback/dashboard"  ?>" class="btn btn-danger">Cancel</a>
                    </div>
                </div>
            </div>
		</form>             
    </div>
</div>

<script type="text/javascript">
    var base_url = window.location.origin;

    $(document).ready(function() {
        // Prevent form submission on enter key press
        $('#ajaxForm').on('keypress', function(e) {
            if (e.keyCode === 13) {
                e.preventDefault();
            }
        });

        // Intercept the form submission
        $("#ajaxForm").submit(function(e) {
            e.preventDefault();

            var formData = $(this).serialize();
            
            // alert(formData)
            // Send an AJAX request
            $.ajax({
                type: "POST",
                url: base_url + '/pustaka_paperback/upload_quantity_list',
                data: formData,
                success: function(data) {
                    if (data == 1) {
                        alert("Added Successfully!!");
                        window.close();
                    } else {
                        alert("Unknown error!! Check again!")
                    }
                }
            });
        });
    });
</script>
