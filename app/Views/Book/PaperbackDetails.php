<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<?php
$pb_month = json_encode($paperback['pb_month']);
$pb_monthly_pages = json_encode($paperback['pb_monthly_pages']);
$pb_lang_name = json_encode($paperback['pb_lang_name']);
$pb_lang_book_cnt = json_encode($paperback['pb_lang_book_cnt']);

$authors = [];
for ($i = 0; $i < count($paperback['pb_author_name']); $i++) {
    $authors[] = [
        'name' => $paperback['pb_author_name'][$i],
        'count' => $paperback['pb_author_cnt'][$i]
    ];
}
usort($authors, fn($a, $b) => $b['count'] - $a['count']);
?>

<div class="container-fluid py-4">

    <div class="col-12 text-center mb-3">
            <div class="p-3 gradient-deep-2 fw-bold"
            style="font-size: 18px; border-radius: 8px;">
            Total Pages in Library: <?= $dashboard_data['paperback_pages']; ?>
            </div>
        </div>

    <!-- Genre Table -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-gradient-danger text-center">
                    <h6 class="mb-0">Paperback by Genre</h6>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-light zero-config">
                        <thead>
                            <tr>
                                <th>Genre Name</th>
                                <th class="text-center">Books</th>
                                <th class="text-center">Total Pages</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 0; $i < count($paperback['pb_genre_id']); $i++): ?>
                            <tr>
                                <td><?= $paperback['pb_genre_name'][$i]; ?></td>
                                <td class="text-center"><?= $paperback['pb_genre_cnt'][$i]; ?></td>
                                <td class="text-center"><?= $paperback['pb_genre_page_cnt'][$i]; ?></td>
                            </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Authors + Language Chart -->
    <div class="row g-4">

        <!-- Top Authors -->
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-gradient-primary text-center">
                    <h6 class="mb-0">Top Paperback Authors</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Author</th>
                                <th>Books</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($authors as $a): ?>
                            <tr>
                                <td><?= $a['name']; ?></td>
                                <td><?= $a['count']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Language Chart -->
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-gradient-purple text-center">
                    <h6 class="mb-0">Books by Language</h6>
                </div>
                <div class="card-body">
                    <div id="pb_lang_chart" style="height: 300px;"></div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    new ApexCharts(document.querySelector("#pb_lang_chart"), {
        chart: { type: "pie", height: 300 },
        labels: <?= $pb_lang_name ?>,
        series: <?= $pb_lang_book_cnt ?>
    }).render();

});
</script>

<?= $this->endSection(); ?>
