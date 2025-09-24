<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container py-4">
    <div class="row g-3">
        <!-- Card 1: Basic Info -->
        <div class="col-md-4">
            <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-1">
                <h5 class="mb-3"></h5>
                <p><b>Book ID:</b> <?= esc($book['book_id']) ?></p>
                <p><b>SKU No:</b> <?= esc($book['sku_no']) ?></p>
                <p><b>Title:</b> <?= esc($book['book_title']) ?></p>
                <p><b>Regional Title:</b> <?= esc($book['book_regional_title']) ?></p>
                 <p><b>Author:</b> <?= esc($book['author_name']) ?></p>
            </div>
        </div>

        <!-- Card 2: Content Info -->
        <div class="col-md-4">
            <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-2">
                <h5 class="mb-3"></h5>
                <p><b>Genre:</b> <?= esc($book['book_genre']) ?></p>
                <p><b>Language:</b> <?= esc($book['language']) ?></p>
                
                <p><b>Description:</b> <?= esc($book['book_description']) ?></p>
            </div>
        </div>

        <!-- Card 3: Commercial Info -->
        <div class="col-md-4">
            <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-3">
                <h5 class="mb-3"></h5>
                <p><b>No of Pages:</b> <?= esc($book['no_of_pages']) ?></p>
                <p><b>MRP:</b> ₹<?= esc($book['mrp']) ?></p>
                <p><b>ISBN:</b> <?= esc($book['isbn']) ?></p>
                
               
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
