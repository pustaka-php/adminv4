<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>

<div class="card basic-data-table">
    <div class="card-header">
        <h5 class="card-title mb-0">Selected Books Details</h5>
    </div>

    <div class="card-body">
        <form id="ajaxForm" method="POST">
            <input type="hidden" name="selected_book_list" value="<?= esc($selected_book_id); ?>">

            <div class="table-responsive">
                <table class="table colored-row-table mb-0">
                    <thead>
                        <tr>
                            <th class="bg-primary-light">#</th>
                            <th class="bg-primary-light">Book ID</th>
                            <th class="bg-primary-light">Title</th>
                            <th class="bg-primary-light">Author</th>
                            <th class="bg-primary-light text-center">Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach ($selected_books_data as $selected_books): ?>
                            <?php
                                // Only show one row — first book only
                                if ($i > 1) break;

                                $qty = (int)($selected_books['Qty'] ?? 0);
                                if ($qty >= 20) {
                                    $row_class = 'bg-success-focus';
                                } elseif ($qty >= 10) {
                                    $row_class = 'bg-info-focus';
                                } elseif ($qty > 0) {
                                    $row_class = 'bg-warning-focus';
                                } else {
                                    $row_class = 'bg-success-focus';
                                }
                            ?>
                            <tr>
                                <td class="<?= $row_class; ?>"><?= $i++; ?></td>
                                <td class="<?= $row_class; ?>">
                                    <input type="number" name="book_id" value="<?= esc($selected_books['book_id']); ?>" readonly>
                                </td>
                                <td class="<?= $row_class; ?>"><?= esc($selected_books['book_title']); ?></td>
                                <td class="<?= $row_class; ?>"><?= esc($selected_books['author_name']); ?></td>
                                <td class="<?= $row_class; ?> text-center">
                                    <input type="number" class="form-control" name="quantity" placeholder="0" min="1" required>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-4 gap-2">
                <button type="submit" class="btn btn-primary" style="background-color: #77B748; border-color: #77B748;">
                    Submit
                </button>
                <a href="<?= base_url('stock/stockdashboard'); ?>" class="btn btn-danger">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script>
    var base_url = "<?= base_url(); ?>";

    $(document).ready(function () {
        $('#ajaxForm').on('keypress', function (e) {
            if (e.keyCode === 13) {
                e.preventDefault(); 
            }
        });

        $("#ajaxForm").submit(function (e) {
            e.preventDefault();   
            var book_id = $('input[name="book_id"]').val();
            console.log("book_id:", book_id); 
            
            var formData = $(this).serialize();
           
            // alert("Submitting form.." + formData);
            $.ajax({
                type: "POST",
                url: base_url + 'stock/submitdetails',
                data: formData,
                success: function (data) {
                    console.log("Response Data:", data);
                    if (data == 1 || data === "1") {
                        alert("Added Successfully!!");
                        window.location.href = base_url + 'stock/stockentrydetails?book_id=' + book_id;
                    } else {
                        alert("Unknown error!! Check again!");
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    alert("AJAX Error: " + error);
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>
