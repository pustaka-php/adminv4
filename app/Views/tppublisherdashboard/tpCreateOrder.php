<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>
<h5 class="card-title mb-4">Selected Books</h5>
<h6 class="card-title mb-4">Selected Titles</h6>

<div class="card-body">
    <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10"> 
        <thead>
            <tr>
                <th>S.No</th>
                <!-- <th>Book ID</th> -->
                <th>Sku No</th>
                <th>Book Title</th>
                <th>Rate</th>
                <th>Stock in Hand</th>
                <th>Add to Cart</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($details)): ?>
                <?php $i = 1; ?>
                <?php foreach ($details as $row): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <!-- <td><?= esc($row['book_id']) ?></td> -->
                        <td><?= esc($row['sku_no']) ?></td>
                        <td><?= esc($row['book_title']) ?></td>
                        <td><?= esc($row['mrp']) ?></td>
                        <td><?= $row['stock_in_hand'] == 0 ? '-' : esc($row['stock_in_hand']) ?></td>
                        <td class="text-center">
                            <button 
                                onclick="AddToBookList('<?= esc($row['sku_no']) ?>')" 
                                class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center"
                                title="Add to Cart">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M7 18c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm10 0c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm-12.83-2l1.716-8h13.114l1.716 8h-16.546zm-1.17-10h18v2h-18v-2z"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center text-muted">No records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Selected Book List Form -->
    <div class="mt-4">
        <form class="text-left" action="<?= base_url('tppublisherdashboard/tppublisherorder') ?>" method="POST">
            <div class="form-group">
                <label for="selected_book_list">Selected Books:</label>
                <input type="text" id="selected_book_list" name="selected_book_list" 
                       class="form-control" placeholder="Selected Book Lists" required>
            </div>
            
            <div class="d-flex justify-content-center gap-3 mt-3">
                <button type="submit" class="btn rounded-pill btn-outline-success-600 radius-8 px-20 py-11">
                    Next
                </button>

                <a href="<?= base_url('tppublisherdashboard/tppublisherdashboard') ?>" 
                   class="btn rounded-pill btn-outline-danger-600 radius-8 px-20 py-11">
                   Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        $.fn.dataTable.ext.errMode = 'none'; 
        let table = new DataTable("#dataTable");
    });

    function AddToBookList(sku_no) {
        const inputField = document.getElementById('selected_book_list');
        let bookList = inputField.value.split(',').map(id => id.trim()).filter(id => id !== '');

        if (!bookList.includes(String(sku_no))) {
            bookList.unshift(sku_no);
            inputField.value = bookList.join(',');
        } else {
            alert("Book already added!");
        }
    }
</script>
<?= $this->endSection(); ?>
