<?= $this->extend('layout/layout1'); ?>

<?= $this->section('script'); ?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
         $.fn.dataTable.ext.errMode = 'none'; 
        let table = new DataTable("#dataTable");
    });

    function AddToBookList(book_id) {
        const inputField = document.getElementById('selected_book_list');
        let bookList = inputField.value.split(',').map(id => id.trim()).filter(id => id !== '');

        if (!bookList.includes(String(book_id))) {
            bookList.unshift(book_id);
            inputField.value = bookList.join(',');
            alert("Book added to list!");
        } else {
            alert("Book already added!");
        }
    }
</script>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<div class="card basic-data-table">
            <div class="card-body">
        <!-- <div class="d-flex justify-content-center mb-4">
            <a href="/tppublisherdashboard/tppublisherorderdetails" target="_blank" 
               class="btn btn-primary-600 radius-8 px-20 py-11 me-3">
               Order Details 
            </a>
            
            <a href="/tppublisherdashboard/tppublisherorderpayment" target="_blank"
              class="btn btn-success-600 radius-8 px-20 py-11">
               Payment Details
            </a>
        </div> -->

        <h5 class="card-title mb-4">Books List</h5>

        <div class="card-body">
                  <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10"> 
              
                <thead>
                    <tr>
                    <th>Book ID</th>
                    <th>Publisher</th>
                    <th>Sku No</th>
                    <th>Book Title</th>
                    <th>Rate</th>
                    <th>Total Books</th>
                    <th>Sales</th>
                    <th>Stock in Hand</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($details)): ?>
                    <?php foreach ($details as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['book_id']) ?></td>
                            <td><?= htmlspecialchars($row['publisher_name']) ?></td>
                            <td><?= htmlspecialchars($row['sku_no']) ?></td>
                            <td><?= htmlspecialchars($row['book_title']) ?></td>
                            <td><?= htmlspecialchars($row['mrp']) ?></td>
                            <td><?= $row['book_quantity'] == 0 ? '-' : htmlspecialchars($row['book_quantity']) ?></td>
                            <td><?= $row['stock_out'] == 0 ? '-' : htmlspecialchars($row['stock_out']) ?></td>
                            <td><?= $row['stock_in_hand'] == 0 ? '-' : htmlspecialchars($row['stock_in_hand']) ?></td>
                            <td class="text-center">
                                <button onclick="AddToBookList(<?= $row['book_id'] ?>)"
                                    class="btn btn-sm btn-primary radius-8 px-3 py-1"
                                    title="Add to Cart">
                                    Add
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted">
                            No records found for this publisher.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="mt-4">
            <form class="text-left" action="<?= base_url('tppublisher/tpbookorderdetails') ?>" method="POST">
                <div class="form-group">
                    <label for="selected_book_list">Selected Books:</label>
                    <input type="text" id="selected_book_list" name="selected_book_list" 
                           class="form-control" placeholder="Selected Book Lists" required>
                </div>
                
        <div class="d-flex justify-content-center gap-3 mt-3">
            <button type="submit" class="btn rounded-pill btn-outline-success-600 radius-8 px-20 py-11">
                Next
            </button>

            <a href="<?= base_url('tppublisher/tpsalesadd') ?>" 
            class="btn rounded-pill btn-outline-danger-600 radius-8 px-20 py-11">
            Cancel
            </a>
        </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>