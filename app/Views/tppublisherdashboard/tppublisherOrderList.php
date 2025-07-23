<?= $this->extend('layout/layout1'); ?>

<?= $this->section('script'); ?>
    <script>
        let table = new DataTable("#dataTable");
    </script>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?> 

<div class="card basic-data-table">
            <div class="card-body">
        <h5 class="card-title mb-0"><i class="fas fa-book-open-reader me-2"></i>Publisher Selected Books List</h5>
    </div>
    <div class="card-body">
        <form action="<?= base_url().'tppublisherdashboard/tppublisherorderstock' ?>" method="POST">
            <input type="hidden" name="num_of_books" value="<?= count($tppublisher_selected_books_data); ?>">
            <input type="hidden" name="selected_book_list" value="<?= $tppublisher_selected_book_id; ?>">

            <!-- Book Table -->
           <div class="card-body p-4">
                 <table id="dataTable" class="table bordered-table mb-0" data-page-length='10' style="font-size:14px; table-layout: fixed; width: 100%;">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Book ID</th>
                            <th>Title</th>
                            <th>Regional Title</th>
                            <th>Author</th>
                            <th>Price</th>
                            <th>Pages</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; $j = 1; foreach ($tppublisher_selected_books_data as $book): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $book['book_id'] ?></td>
                                <td><?= $book['book_title'] ?></td>
                                <td><?= $book['regional_book_title'] ?></td>
                                <td><?= $book['author_name'] ?></td>
                                <td>
                                    <?= $book['price'] ?>
                                    <input type="hidden" name="price<?= $j ?>" value="<?= $book['price'] ?>">
                                </td>
                                <td><?= $book['number_of_page'] ?></td>
                                <td>
                                    <input type="number" name="bk_qty<?= $j ?>" placeholder="0" required class="form-control form-control-sm" style="width: 80px;">
                                </td>
                            </tr>
                        <?php $j++; endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Address -->
            <div class="mb-3">
                <label class="form-label"><i class="fas fa-map-marker-alt me-2"></i>Shipping Address</label>
                <textarea name="address" placeholder="Enter full shipping address" rows="3" required class="form-control"></textarea>
            </div>

            <!-- Mobile -->
            <div class="mb-3">
                <label class="form-label"><i class="fas fa-phone me-2"></i>Mobile Number</label>
                <input type="tel" name="mobile" placeholder="Enter mobile number" pattern="[0-9]{10}" required class="form-control">
            </div>

            <!-- Date -->
            <div class="mb-4">
                <label class="form-label"><i class="fas fa-calendar-alt me-2"></i>Shipping Date</label>
                <input type="date" name="ship_date" required class="form-control">
            </div>

            <!-- Buttons -->
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success me-2">
                    <i class="fas fa-arrow-right me-2"></i>Next
                </button>
                <a href="<?= base_url().'tppublisherdashboard/tppublisherdashboard' ?>" class="btn btn-danger">
                    <i class="fas fa-times me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    function AddToBookList(book_id) {
        var existing_book_list = document.getElementById('selected_book_list').value;
        if (existing_book_list)
            document.getElementById('selected_book_list').value = book_id + ',' + existing_book_list;
        else
            document.getElementById('selected_book_list').value = book_id;
    }
</script>

<?= $this->endSection(); ?>