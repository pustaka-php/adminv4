<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?> 
<div class="row gy-4 mb-24">

    <?php
function calculateTrend($data) {
    $count = count($data);
    if ($count < 2) return null;
    $last = $data[$count - 1];
    $prev = $data[$count - 2];
    if ($prev == 0) return null;
    return round((($last - $prev) / $prev) * 100, 1);
}

$colors = ["#FF9F29", "#487FFF", "#45B369", "#9935FE", "#FF6384", "#36A2EB", "#FFCE56", "#9C27B0", "#00BCD4"];
?>
<div class="container">

    <!-- Charts Row -->
    <div class="row mt-4">
        <div class="col-md-7">
            <h6>Genre Wise Books</h6>
            <div id="genreBar" style="height: 350px;"></div>
        </div>
        <div class="col-md-5">
            <h6>Category Wise Books</h6>
            <div id="categoryBar" style="height: 350px;"></div>
        </div>
    </div>

    <!-- Language Chart + Author Table -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card h-100 radius-8 border-0">
                <div class="card-body p-22">
                    <h6 class="mb-2 fw-bold small text-center">Language Wise Books</h6><br> 
                    <div id="languageDonutChart" style="height: 250px;"></div>
                    <?php if (!empty($languageData)): ?>
                        <ul class="list-group list-group-flush mt-2">
                            <?php foreach ($languageData as $index => $lang): ?>
                               <li style="text-align: center;">
                                    <div class="d-flex align-items-center gap-2 small">
                                        <span class="badge rounded-pill" style="background-color: <?= esc($colors[$index % count($colors)]) ?>;">&nbsp;</span>
                                        <?= esc($lang['language_name']) ?>
                                   
                                    <span class="fw-bold small"><?= esc($lang['total_books']) ?></span>
                                     </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <div class="text-center text-muted p-2 small">No language data available</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <h6>Author Wise Books</h6>
            <table class="table table-hover table-light zero-config">
                <thead>
                    <tr><th>Author Name</th><th>Total Books</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($authorData as $row): ?>
                        <tr><td><?= esc($row['author_name']) ?></td><td><?= esc($row['total']) ?></td></tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <br>
    <!-- Scripts -->
<script src="<?= base_url('assets/js/lib/apexcharts.min.js') ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Language Donut
    <?php if (!empty($languageData)): ?>
    new ApexCharts(document.querySelector("#languageDonutChart"), {
        chart: { type: 'donut', height: 250 },
        series: <?= json_encode(array_map('intval', array_column($languageData, 'total_books'))) ?>,
        labels: <?= json_encode(array_column($languageData, 'language_name')) ?>,
        colors: <?= json_encode($colors) ?>,
    }).render();
    <?php endif; ?>

    // Bar Chart - Genre Wise
    <?php if (!empty($genreData)): ?>
        new ApexCharts(document.querySelector("#genreBar"), {
            chart: { type: 'bar', height: 350 },
            series: [{ name: 'Books', data: <?= json_encode(array_map('intval', array_column($genreData, 'total_books'))) ?> }],
            xaxis: { categories: <?= json_encode(array_column($genreData, 'genre_name')) ?>, labels: { rotate: -45 } },
            colors: ['#1E88E5', '#F4511E', '#43A047', '#8E24AA', '#FFB300'],
            plotOptions: { bar: { borderRadius: 4, horizontal: false } },
            dataLabels: { enabled: false },
            tooltip: { y: { formatter: val => val + ' books' } },
            grid: { strokeDashArray: 3 }
        }).render();
    <?php else: ?>
        document.querySelector("#genreBar").innerHTML = '<div class="text-center text-muted p-4">No genre data available</div>';
    <?php endif; ?>

    // Bar Chart - Category Wise
    <?php if (!empty($categoryData)): ?>
        new ApexCharts(document.querySelector("#categoryBar"), {
            chart: { type: 'bar', height: 350 },
            series: [{ name: 'Books', data: <?= json_encode(array_map('intval', array_column($categoryData, 'total_books'))) ?> }],
            xaxis: { categories: <?= json_encode(array_column($categoryData, 'book_category')) ?>, labels: { rotate: -45 } },
            colors: ['#FF7043', '#66BB6A', '#29B6F6', '#AB47BC', '#FFA726'],
            plotOptions: { bar: { borderRadius: 4, horizontal: false } },
            dataLabels: { enabled: false },
            tooltip: { y: { formatter: val => val + ' books' } },
            grid: { strokeDashArray: 3 }
        }).render();
    <?php else: ?>
        document.querySelector("#categoryBar").innerHTML = '<div class="text-center text-muted p-4">No category data available</div>';
    <?php endif; ?>
});
</script>

  <?= $this->endSection(); ?>