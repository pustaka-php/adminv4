<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="col-7">
            <form>
                <div class="form-group">
                    <?php 
                        $completed = $completed ?? []; // ensure it's an array
                        $book_id_val = isset($completed['book_id']) ? $completed['book_id'].' - '.$completed['book_title'] : '';
                        $pages_val = $completed['paper_back_pages'] ?? '';
                        $price_val = $completed['paper_back_inr'] ?? '';
                        $isbn_val = $completed['paper_back_isbn'] ?? '';
                        $royalty_val = $completed['paper_back_royalty'] ?? '';
                        $copyright_val = $completed['paper_back_copyright_owner'] ?? '';
                    ?>
                    <label for="book_id">Book Id & Title</label>
                    <input type="text" class="form-control" id="book_id" name="book_id" value="<?= esc($book_id_val) ?>" readonly style="color: black;">
                    <br>

                    <label for="pages">No. of Pages</label>
                    <input type="text" class="form-control" id="pages" name="pages" value="<?= esc($pages_val) ?>" required>
                    <br>

                    <label for="price">Book Price</label>
                    <input type="text" class="form-control" id="price" name="price" value="<?= esc($price_val) ?>" required>
                    <br>

                    <label for="isbn">ISBN Number</label>
                    <input type="text" class="form-control" id="isbn" name="isbn" value="<?= esc($isbn_val) ?>" required>
                    <br>

                    <label for="royalty">Royalty Value (%)</label>
                    <input type="text" class="form-control" id="royalty" name="royalty" value="<?= esc($royalty_val) ?>" required>
                    <br>

                    <label for="copyright_owner">Copyright Owner</label>
                    <input type="text" class="form-control" id="copyright_owner" name="copyright_owner" value="<?= esc($copyright_val) ?>" required>
                </div>
            </form>
        </div>

        <center>
            <div class="field-wrapper">
                <a href="javascript:void(0)" onclick="mark_completed()" class="btn btn-success">Submit</a>
                <a href="<?= base_url('pod_paperback/pod_books_dashboard') ?>" class="btn btn-danger">Close</a>
            </div>
        </center>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script type="text/javascript">
    var base_url = window.location.origin;

    function mark_completed() {
        var book_id = document.getElementById('book_id').value;
        var pages = document.getElementById('pages').value;
        var price = document.getElementById('price').value;
        var isbn = document.getElementById('isbn').value;
        var royalty = document.getElementById('royalty').value;
        var copyright_owner = document.getElementById('copyright_owner').value;

        if (!book_id || !pages || !price || !isbn || !royalty || !copyright_owner) {
            alert("Please fill in all fields before marking as completed.");
            return;
        }

        $.ajax({
            url: base_url + '/book/markreworkcompleted',
            type: 'POST',
            data: {
                "book_id": book_id,
                "pages": pages,
                "price": price,
                "isbn": isbn,
                "royalty": royalty,
                "copyright_owner": copyright_owner,
            },
            success: function (data) {
                if (data == 1) {
                    alert("Successfully added!!");
                    window.close();
                } else if (data == 0) {
                    alert("Unknown error!! Check again!");
                } else {
                    alert("The book details have already been submitted");
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
                alert("Something went wrong! Check console.");
            }
        });
    }
</script>
<?= $this->endSection(); ?>
