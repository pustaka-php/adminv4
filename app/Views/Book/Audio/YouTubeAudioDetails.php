<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <?php
        // Languages
        $languages = [
            'tamil'     => 'Tamil',
            'kannada'   => 'Kannada',
            'telugu'    => 'Telugu',
            'malayalam' => 'Malayalam',
            'english'   => 'English'
        ];

        // Background color classes
        $bgColors = [
            'tamil'     => 'bg-gradient-start-1',
            'kannada'   => 'bg-gradient-start-2',
            'telugu'    => 'bg-gradient-start-3',
            'malayalam' => 'bg-gradient-start-4',
            'english'   => 'bg-gradient-start-5'
        ];

        // Key map for model array indices
        $keyMap = [
            'tamil'     => 'tam',
            'kannada'   => 'kan',
            'telugu'    => 'tel',
            'malayalam' => 'mal',
            'english'   => 'eng'
        ];

        // Links for unpublished books
        $links = [
            'tamil'     => 'book/youtubeunpublished/1',
            'kannada'   => 'book/youtubeunpublished/2',
            'telugu'    => 'book/youtubeunpublished/3',
            'malayalam' => 'book/youtubeunpublished/4',
            'english'   => 'book/youtubeunpublished/5'
        ];
        ?>

        <!-- Language Cards -->
        <div class="row gx-4 gy-4 mb-4">
            <?php foreach ($languages as $key => $label): 
                $mapKey = $keyMap[$key];
                $published   = $youtube['you_' . $mapKey . '_cnt'] ?? 0;
                $unpublished = $youtube['you_' . $mapKey . '_unpub_cnt'] ?? 0;
            ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                <div class="card shadow-none border <?= $bgColors[$key] ?> h-100">
                    <div class="card-body p-20 d-flex flex-column justify-content-between text-center">
                        <p class="fw-bold mb-3 fs-5"><?= $label ?></p>
                        <p class="mb-1 fw-bold">Published: <?= $published ?></p>
                        <p class="mb-0 fw-bold">
                            Unpublished: 
                            <a href="<?= base_url($links[$key]) ?>" target="_blank" 
                               class="text-danger text-decoration-underline">
                               <?= $unpublished ?>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Download Excel -->
        <div class="row gx-4 gy-4">
            <div class="col-12">
                <div class="card shadow-none border bg-info-light h-100">
                    <div class="card-body p-20">
                        <p class="fw-medium text-primary-light mb-2">Download YouTube Audio Book IDs</p>
                        <form action="<?= base_url('youtube/youtube_audio_excel/'); ?>" 
                              method="post" 
                              class="d-flex flex-column gap-2">
                            <textarea class="form-control" id="book_ids" 
                                      name="book_ids" rows="3" 
                                      placeholder="Enter audio book IDs separated by comma"></textarea>
                            <br>
                            <input type="submit" 
                                   class="btn btn-primary-600 radius-8 px-20 py-11" 
                                   value="Download Excel">
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection(); ?>
