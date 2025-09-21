<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h3><?= esc($title); ?></h3>
                <p><?= esc($subTitle); ?></p>
            </div>
        </div>

        <?php 
        $languages = ['tamil','kannada','telugu','malayalam','english']; 
        foreach ($languages as $lang): 
            $ids     = $scribd["scribd_{$lang}_unpub_book_id"]          ?? [];
            $titles  = $scribd["scribd_{$lang}_unpub_book_title"]       ?? [];
            $authors = $scribd["scribd_{$lang}_unpub_book_author_name"] ?? [];
            $urls    = $scribd["scribd_{$lang}_unpub_book_epub_url"]    ?? [];
        ?>
            <h4 class="mt-4"><?= ucfirst($lang); ?> Unpublished Books</h4>
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>Book ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($ids)): ?>
                        <?php for ($i = 0, $n = count($ids); $i < $n; $i++): ?>
                            <tr>
                                <td><?= esc($ids[$i]); ?></td>
                                <td><?= esc($titles[$i] ?? ''); ?></td>
                                <td><?= esc($authors[$i] ?? ''); ?></td>
                                <td><?= esc(pathinfo($urls[$i] ?? '', PATHINFO_EXTENSION)); ?></td>
                            </tr>
                        <?php endfor; ?>
                    <?php else: ?>
                        <tr><td colspan="4" class="text-center">No unpublished books in <?= ucfirst($lang); ?></td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php endforeach; ?>
    </div>
</div>

<?= $this->endSection(); ?>
