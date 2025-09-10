<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>

<div id="content" class="main-content">
	<div class="layout-px-spacing">
		<div class="page-header">
			<div class="page-title">
				<center><h3>Selected Books List</h3></center>
                <br>
			</div>
		</div>
        <form id="ajaxForm" class="text-left" method="POST">
			<div class="form">
                    <input type="hidden" value="<?php echo count($selected_books_data); ?>" name="num_of_books">
                    <input type="hidden" value="<?php echo $selected_book_id; ?>" name="selected_book_list">

                    <table class="table table-hover mt-4">
                        <thead class="thead-dark">
                        <th>S.No</th>
                        <th>Book ID</th>
                        <th>Title</th>
                        <th>Regional Title</th>
                        <th>Author</th>
                        <th>PaperBack Pages</th>
                        </thead>
                        <tbody>
                        <?php
                            $i=1;
                            $j=1;
                        
                            foreach($selected_books_data as $selected_books)  {?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td>
                                    <input type="text" class="form-control" value="<?php echo $selected_books['book_id'] ?>" name="book_id<?php echo $j; ?>" readonly style="color: black;">
                                    </td>
                                    <td><?php echo $selected_books['book_title'] ?></td>
                                    <td><?php echo $selected_books['regional_book_title'] ?></td>
                                    <input type="hidden" class="form-control" value="<?php echo $selected_books['author_id'] ?>" name="author_id<?php echo $j++; ?>" readonly>
                                    <td><?php echo $selected_books['author_name'] ?></td>
                                    <td><?php echo $selected_books['number_of_page']?></td>
                                </tr>
                            <?php } ?>
                            
                        </tbody>
                    </table>
                    <br>
                    <div class="d-sm-flex right-content-between">
                        <div class="field-wrapper">
                            <button style="background-color: #77B748 !important; border-color: #77B748 !important;" type="submit" class="btn btn-primary" value="">Submit</button>
                             <a href="<?php echo base_url()."book/podbooksdashboard"  ?>" class="btn btn-danger">Cancel</a>
                          </div>
                    </div>
            </div>
		</form>             
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script type="text/javascript">
$(document).ready(function() {
    $("#ajaxForm").submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            type: "POST",
            url: "<?= base_url('book/reworkbooksubmit') ?>",
            data: formData,
            success: function(data) {
    console.log("Response:", data);
    if (data.trim() == "1") {
        alert("Added Successfully!!");
        window.location.href = "<?= base_url('book/podbooksdashboard') ?>";
    } else {
        alert("Error: " + data);
    }
},
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
                alert("Something went wrong!");
            }
        });
    });
});
</script>

<?= $this->endSection(); ?>