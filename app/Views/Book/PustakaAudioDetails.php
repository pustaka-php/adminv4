<?php
$pus_page_cnt = json_encode($pustaka['pus_page_cnt']);
$pus_page_month = json_encode($pustaka['pus_page_month']);
$pus_lang_name = json_encode($pustaka['pus_lang_name']);
$pus_lang_book_cnt = json_encode($pustaka['pus_lang_book_cnt']);

// Sort authors by book count descending
$authors = [];
for ($i = 0; $i < count($pustaka['pus_author_name']); $i++) {
    $authors[] = [
        'name'  => $pustaka['pus_author_name'][$i],
        'count' => $pustaka['pus_author_cnt'][$i]
    ];
}
usort($authors, fn($a, $b) => $b['count'] - $a['count']);
?>

<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid py-4">
     <div class="row mb-4">
        <div class="col-12 text-center mb-3">
            <div class="p-3 gradient-deep-2 fw-bold"
            style="font-size: 18px; border-radius: 8px;">
            Total Pages in Library: <?= $dashboard_data['ebook_pages']; ?>
            </div>
        </div>


    <!-- Books by Genre Table -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header h-100 radius-12 bg-gradient-danger text-center">
                    <h6 class="mb-0">Books by Genre</h6>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-light zero-config">
                        <thead>
                            <tr>
                                <th>Genre Name</th>
                                <th class="text-center">Number of Books</th>
                                <th class="text-center">Number of Pages</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $total_pages = 0;
                            for ($i = 0; $i < count($pustaka['pus_genre_id']); $i++): 
                                $total_pages += (int)$pustaka['pus_genre_page_cnt'][$i];
                            ?>
                            <tr>
                                <td><?= $pustaka['pus_genre_name'][$i]; ?></td>
                                <td class="text-center"><?= $pustaka['pus_genre_cnt'][$i]; ?></td>
                                <td class="text-center"><?= $pustaka['pus_genre_page_cnt'][$i]; ?></td>
                            </tr>
                            <?php endfor; ?>
                        </tbody>
                        
                    </table>
                </div>

            </div>
        </div>
    </div>
    <br>

    <!-- Charts and Top Authors -->
    <div class="row g-4">
    <!-- Top Authors Table -->
    <div class="col-lg-6 col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header h-100 radius-12 bg-gradient-primary text-center">
                <h6 class="mb-0">Top Authors</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Author Name</th>
                            <th>Number of Books</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($authors as $author): ?>
                        <tr>
                            <td><?= $author['name']; ?></td>
                            <td><?= $author['count']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Books by Language Chart -->
    <div class="col-lg-6 col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header h-100 radius-12 bg-gradient-purple text-center">
                <h6 class="mb-0">Books by Language</h6>
            </div>
            <div class="card-body">
                <div id="pus_lang_book_chart" style="height: 300px;"></div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<!-- Chart Scripts -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Language Pie Chart
    var optionsPie = {
        chart: { type: 'pie', height: 300 },
        labels: <?= $pus_lang_name; ?>,
        series: <?= $pus_lang_book_cnt; ?>,
        responsive: [{
            breakpoint: 480,
            options: { chart: { width: 200 }, legend: { position: 'bottom' } }
        }]
    };
    new ApexCharts(document.querySelector("#pus_lang_book_chart"), optionsPie).render();
});
</script>

<?= $this->endSection(); ?>
