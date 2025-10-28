<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <!-- eBooks Section -->
        <h6 class="mt-4 text-center">eBooks</h6>
        <div class="table-responsive mb-4 mt-3">
            <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10">
                <thead>
                    <tr>
                        <th>Book ID</th>
                        <th>Name</th>
                        <th>Author</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($amazon['amz_tml_book_id'])): ?>
                        <?php foreach ($amazon['amz_tml_book_id'] as $i => $id): ?>
                            <tr>
                                <td><?= esc($id) ?></td>
                                <td><?= esc($amazon['amz_tml_book_title'][$i] ?? '-') ?></td>
                                <td><?= esc($amazon['amz_tml_book_author_name'][$i] ?? '-') ?></td>
                                <td>
                                    <?php 
                                        $url = $amazon['amz_tml_book_epub_url'][$i] ?? '';
                                        echo $url ? pathinfo($url, PATHINFO_EXTENSION) : '-';
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4" class="text-center">No eBooks found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Short Stories Section -->
        <h6 class="mt-4 text-center">Short Stories</h6>
        <div class="table-responsive mb-4 mt-3">
            <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10">
                <thead>
                    <tr>
                        <th>Story ID</th>
                        <th>Name</th>
                        <th>Author</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($amazon['amz_short_stories_id'])): ?>
                        <?php foreach ($amazon['amz_short_stories_id'] as $i => $id): ?>
                            <tr>
                                <td><?= esc($id) ?></td>
                                <td><?= esc($amazon['amz_short_stories_title'][$i] ?? '-') ?></td>
                                <td><?= esc($amazon['amz_short_stories_author_name'][$i] ?? '-') ?></td>
                                <td>
                                    <?php 
                                        $url = $amazon['amz_short_stories_epub_url'][$i] ?? '';
                                        echo $url ? pathinfo($url, PATHINFO_EXTENSION) : '-';
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4" class="text-center">No short stories found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    $(document).ready(function () {
        $("#tblEbooks").DataTable();
        $("#tblShortStories").DataTable();
    });
</script>
<?= $this->endSection(); ?>
