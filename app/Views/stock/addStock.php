<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>

<div class="card basic-data-table">
    <div class="card-header">
        <h5 class="card-title mb-0">Available Paperback Books</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table bordered-table mb-0" id="dataTable" data-page-length="7">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Book ID</th>
                        <th>Title</th>
                        <th>Regional Title</th>
                        <th>Author</th>
                        <th>Cost (INR)</th>
                        <th>Pages</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($paperback_books['details'] as $book): ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= esc($book['book_id']); ?></td>
                            <td><?= esc($book['book_title']); ?></td>
                            <td><?= esc($book['regional_book_title']); ?></td>
                            <td><?= esc($book['author_name']); ?></td>
                            <td><?= esc($book['paper_back_inr']); ?></td>
                            <td><?= esc($book['number_of_page']); ?></td>
                            <td>
                                <a href="<?= base_url('stock/bookslist'); ?>?selected_book_list=<?= esc($book['book_id']); ?>"
                                   target="_blank"
                                   class="badge text-sm fw-semibold bg-success-600 px-20 py-9 radius-4 text-white">
                                   Add
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        new DataTable('#dataTable');
    });
</script>
<?= $this->endSection(); ?>
