<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>

<div class="card basic-data-table">
    <div class="card-header">
        <h5 class="card-title mb-0">Available Paperback Books</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table bordered-table mb-0" id="dataTable" data-page-length="7" style="table-layout: fixed; width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 40px; text-align: center;">S.No</th>
                        <th style="width: 60px; text-align: center;">Book ID</th>
                        <th style="width: 20%;">Title</th>
                        <th style="width: 20%;">Regional Title</th>
                        <th style="width: 15%;">Author</th>
                        <th style="width: 10%;">Cost (INR)</th>
                        <th style="width: 10%;">Pages</th>
                        <th style="width: 80px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($paperback_books['details'] as $book): ?>
                        <tr>
                            <td style="text-align: center;"><?= $i++; ?></td>
                            <td style="text-align: center;"><?= esc($book['book_id']); ?></td>
                            <td style="word-wrap: break-word; white-space: normal;"><?= esc($book['book_title']); ?></td>
                            <td style="word-wrap: break-word; white-space: normal;"><?= esc($book['regional_book_title']); ?></td>
                            <td><?= esc($book['author_name']); ?></td>
                            <td style="text-align: center;"><?= esc($book['paper_back_inr']); ?></td>
                            <td style="text-align: center;"><?= esc($book['number_of_page']); ?></td>
                            <td style="text-align: center;">
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
