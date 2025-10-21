<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">

            <!-- Publisher Details Card -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="text-primary mb-3"><i class="fas fa-building me-2"></i>Publisher Details</h5>
                    <p class="mb-2"><i class="fas fa-user me-2 text-secondary"></i><strong>Publisher Name:</strong> <?= esc($book['publisher_name']) ?></p>
                    <p class="mb-2"><i class="fas fa-user-tie me-2 text-secondary"></i><strong>Contact Person:</strong> <?= esc($book['publisher_contact']) ?></p>
                    <p class="mb-2"><i class="fas fa-phone me-2 text-secondary"></i><strong>Mobile:</strong> <?= esc($book['publisher_mobile']) ?></p>
                </div>
            </div>

            <!-- Book Details Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="text-success mb-3"><i class="fas fa-book me-2"></i>Book Details <span class="badge bg-info"><?= esc($book['pod_book_id']) ?></span></h5>

                    <div class="mb-3">
                        <h6 class="text-muted"><i class="fas fa-info-circle me-1"></i>Basic Info</h6>
                        <p class="mb-1"><strong>Title:</strong> <?= esc($book['book_title']) ?></p>
                        <p class="mb-1"><strong>Language:</strong> <?= esc($book['language_name']) ?></p>
                    </div>

                    <div>
                        <h6 class="text-muted"><i class="fas fa-file-alt me-1"></i>Book Description</h6>
                        <p class="mb-1"><strong>Cost Per Page:</strong> <?= esc($book['cost_per_page']) ?></p>
                        <p class="mb-1"><strong>Layout:</strong> <?= esc($book['layout_dec']) ?></p>
                        <p class="mb-1"><strong>Color:</strong> <?= esc($book['color_dec']) ?></p>
                        <p class="mb-1"><strong>Cover:</strong> <?= esc($book['cover_dec']) ?></p>
                    </div>
                </div>

                <div class="card-footer bg-white text-end border-0">
                    <a href="javascript:history.back()" class="btn btn-outline-success">
    <i class="fas fa-arrow-left me-1"></i>Back
</a>

                </div>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>
