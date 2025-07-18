<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="card">
    <div class="card-header">
        <h5 class="card-title">Book Details</h5>
        <h5 class="card-title"><?= esc($subTitle); ?></h5>

    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>Book ID</th>
                <td><?= esc($book_details['book_id']) ?></td>
            </tr>
            <tr>
                <th>Title</th>
                <td><?= esc($book_details['book_title']) ?></td>
            </tr>
            <tr>
                <th>Author</th>
                <td><?= esc($book_details['author_name']) ?></td>
            </tr>
            <tr>
                <th>INR Price</th>
                <td><?= esc($book_details['paper_back_inr']) ?></td>
            </tr>
            <tr>
                <th>Pages</th>
                <td><?= esc($book_details['number_of_page']) ?></td>
            </tr>
            <tr>
                <th>Quantity (Uncompleted)</th>
                <td><?= esc($book_details['Qty']) ?></td>
            </tr>
        </table>
        <a href="<?= base_url('stock/stockdashboard'); ?>" class="btn btn-secondary">Back</a>
    </div>
</div>

<?= $this->endSection(); ?>
