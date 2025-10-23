<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div id="content" class="main-content">
  <div class="layout-px-spacing">

    <!-- Language Cards Row -->
    <div class="row gx-4 gy-4 mb-4">
        <?php
        $logos = ['Tamil', 'Kannada', 'Telugu', 'Malayalam', 'English'];
        $bgColors = [
            'Tamil'     => 'bg-gradient-start-1',
            'Kannada'   => 'bg-gradient-start-2',
            'Telugu'    => 'bg-gradient-start-3',
            'Malayalam' => 'bg-gradient-start-4',
            'English'   => 'bg-gradient-start-5'
        ];
        $links = [
            'Tamil'     => 'book/pratilipiunpublishedtamil',
            'Kannada'   => 'book/pratilipiunpublishedkannada',
            'Telugu'    => 'book/pratilipiunpublishedtelugu',
            'Malayalam' => 'book/pratilipiunpublishedmalayalam',
            'English'   => 'book/pratilipiunpublishedenglish'
        ];

        foreach ($logos as $lang):
            $published   = $pratilipi['published_counts'][$lang]   ?? 0;
            $unpublished = $pratilipi['unpublished_counts'][$lang] ?? 0;
        ?>
        <div class="col">
            <div class="card shadow-none border <?= $bgColors[$lang] ?> h-100">
                <div class="card-body p-20 d-flex flex-column justify-content-between text-center">
                    <!-- Language Name -->
                    <p class="fw-bold mb-3" style="font-size:1.3rem;"><?= $lang ?></p>
                    
                    <!-- Published and Unpublished counts -->
                    <p class="mb-1 fw-bold">Published: <?= $published ?></p>
                    <p class="mb-0 fw-bold">
                        Unpublished: 
                        <a href="<?= base_url($links[$lang]) ?>" target="_blank" class="text-danger text-decoration-underline">
                            <?= $unpublished ?>
                        </a>
                    </p>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Download Excel Card Row -->
    <div class="row gx-4 gy-4">
        <div class="col-12">
            <div class="card shadow-none border bg-info-light h-100">
                <div class="card-body p-20">
                    <p class="fw-medium text-primary-light mb-2">Download Book IDs</p>
                    <form action="<?= base_url('book/pratilipi_excel'); ?>" method="post" class="d-flex flex-column gap-2">
                        <textarea class="form-control" id="book_ids" name="book_ids" rows="3" placeholder="Enter book IDs separated by comma"></textarea>
                        <br>
                        <input type="submit" class="btn btn-primary-600 radius-8 px-20 py-11" value="Download Excel">
                    </form>
                </div>
            </div>
        </div>
    </div>

  </div>
</div>

<?= $this->endSection(); ?>
