<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <!-- Language Cards Row -->
        <div class="row gx-4 gy-4 mb-4">
            <?php
            $bgColors = ['bg-gradient-start-1','bg-gradient-start-2','bg-gradient-start-3','bg-gradient-start-4','bg-gradient-start-5'];
            $i = 0;

            // Only show languages that have books (published + unpublished > 0)
            foreach ($flipkart as $langName => $counts):
                $published   = $counts['published'] ?? 0;
                $unpublished = $counts['unpublished'] ?? 0;

                if (($published + $unpublished) == 0) continue;

                $link = base_url("book/flipkartunpublishedbooks/{$counts['language_id']}");
            ?>
            <div class="col">
                <div class="card shadow-none border <?= $bgColors[$i % count($bgColors)] ?> h-100">
                    <div class="card-body p-20 d-flex flex-column justify-content-between text-center">
                        <p class="fw-bold mb-3" style="font-size:1.3rem;"><?= ucfirst($langName) ?></p>
                        <p class="mb-1 fw-bold">Published: <?= $published ?></p>
                        <p class="mb-0 fw-bold">
                            Pending: 
                            <a href="<?= $link ?>" class="text-danger text-decoration-underline">
                                <?= $unpublished ?>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            <?php $i++; endforeach; ?>
        </div>

        <!-- Download Excel -->
        <div class="row gx-4 gy-4">
            <div class="col-12">
                <div class="card shadow-none border bg-info-light h-100">
                    <div class="card-body p-20">
                        <p class="fw-medium text-primary-light mb-2">Download Book IDs</p>
                        <form action="<?= base_url('flipkart/flipkartpaperback_excel/'); ?>" method="post" class="d-flex flex-column gap-2">
                            <textarea class="form-control" id="book_ids" name="book_ids" rows="3" placeholder="Enter book IDs separated by comma"></textarea>
                            <input type="submit" class="btn btn-primary-600 radius-8 px-20 py-11 mt-2" value="Download Excel">
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection(); ?>
