<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<?php
function calculateTrend($data) {
    $count = count($data);
    if ($count < 2) return null;
    $last = $data[$count - 1];
    $prev = $data[$count - 2];
    if ($prev == 0) return null;
    return round((($last - $prev) / $prev) * 100, 1);
}

$charts = [
    'pustaka' => [
        'count'     => $e_books['pus_publish_monthly_cnt'],
        'month'     => $e_books['pus_month'],
        'title'     => 'Pustaka',
        'monthly'   => $e_books['pus_monthly'],
        'link'      => base_url('book/pustakadetails'),
        'element_id'=> 'pus_e_book_monthly',
        'gradient'  => 'linear-gradient(90deg, #6a11cb 0%, #2575fc 100%)',
        'trend'     => calculateTrend($e_books['pus_publish_monthly_cnt'])
    ],
    'amazon' => [
        'count'     => $e_books['amz_publish_monthly_cnt'],
        'month'     => $e_books['amz_month'],
        'title'     => 'Amazon',
        'monthly'   => $e_books['amz_monthly'],
        'link'      => base_url('book/amazondetails'),
        'element_id'=> 'amz_e_book_monthly',
        'gradient'  => 'linear-gradient(90deg, #f12711 0%, #f5af19 100%)',
        'trend'     => calculateTrend($e_books['amz_publish_monthly_cnt'])
    ],
    'scribd' => [
        'count'     => $e_books['scr_publish_monthly_cnt'],
        'month'     => $e_books['scr_month'],
        'title'     => 'Scribd',
        'monthly'   => $e_books['scr_monthly'],
        'link'      => base_url('adminv3/scribd_details'),
        'element_id'=> 'scr_e_book_monthly',
        'gradient'  => 'linear-gradient(90deg, #11998e 0%, #38ef7d 100%)',
        'trend'     => calculateTrend($e_books['scr_publish_monthly_cnt'])
    ],
    'storytel' => [
        'count'     => $e_books['storytel_publish_monthly_cnt'],
        'month'     => $e_books['storytel_month'],
        'title'     => 'Storytel',
        'monthly'   => $e_books['storytel_monthly'],
        'link'      => base_url('adminv3/storytel_details'),
        'element_id'=> 'storytel_e_book_monthly',
        'gradient'  => 'linear-gradient(90deg, #833ab4 0%, #fd1d1d 50%, #fcb045 100%)',
        'trend'     => calculateTrend($e_books['storytel_publish_monthly_cnt'])
    ],
    'google' => [
        'count'     => $e_books['goog_publish_monthly_cnt'],
        'month'     => $e_books['goog_month'],
        'title'     => 'GoogleBooks',
        'monthly'   => $e_books['goog_monthly'],
        'link'      => base_url('adminv3/google_details'),
        'element_id'=> 'goog_e_book_monthly',
        'gradient'  => 'linear-gradient(90deg, #00c6ff 0%, #0072ff 100%)',
        'trend'     => calculateTrend($e_books['goog_publish_monthly_cnt'])
    ],
    'overdrive' => [
        'count'     => $e_books['over_publish_monthly_cnt'],
        'month'     => $e_books['over_month'],
        'title'     => 'Overdrive',
        'monthly'   => $e_books['over_monthly'],
        'link'      => base_url('adminv3/overdrive_details'),
        'element_id'=> 'over_e_book_monthly',
        'gradient'  => 'linear-gradient(90deg, #8e2de2 0%, #4a00e0 100%)',
        'trend'     => calculateTrend($e_books['over_publish_monthly_cnt'])
    ]
];

$colors = ["#FF9F29", "#487FFF", "#45B369", "#9935FE", "#FF6384", "#36A2EB", "#FFCE56", "#9C27B0", "#00BCD4"];
?>

<div class="row mt-4">
    <!-- Genre Bar Chart -->
    <div class="col-md-7">
        <h6>Genre Wise Books</h6>
        <div id="genreBar" style="height: 350px;"></div>
    </div>

    <!-- Category Bar Chart -->
    <div class="col-md-5">
        <h6>Category Wise Books</h6>
        <div id="categoryBar" style="height: 350px;"></div>
    </div>
</div>

<div class="row mt-4">
    <!-- Language Donut Chart -->
    <div class="col-md-6">
        <div class="card h-100 radius-8 border-0">
            <div class="card-body p-22">
                <h6 class="mb-2 fw-bold text-lg">Language Wise Books</h6><br>
                <div id="languageDonutChart" style="height: 250px;"></div>
                <ul class="d-flex flex-wrap align-items-center justify-content-between mt-4 gap-4">
                    <?php if(!empty($languageData)): ?>
                        <?php foreach ($languageData as $index => $lang): ?>
                            <li class="d-flex align-items-center gap-2">
                                <span class="w-10-px h-10-px radius-2" style="background-color: <?= esc($colors[$index % count($colors)]) ?>;"></span>
                                <span class="text-secondary-light text-sm fw-normal">
                                    <?= esc($lang['language_name']) ?>: 
                                    <span class="text-primary-light fw-semibold"><?= esc($lang['total_books']) ?></span>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center text-muted p-4">No language data available</div>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>

    <!-- Author Table -->
    <div class="col-md-6">
        <h6>Author Wise Books</h6>
        <table class="table table-hover table-light zero-config">
            <thead>
                <tr>
                    <th>Author Name</th>
                    <th>Total Books</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($authorData as $row): ?>
                <tr>
                    <td><?= esc($row['author_name']) ?></td>
                    <td><?= esc($row['total']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<!-- Platform Tabs -->
<ul class="nav nav-tabs mb-3" id="chartTabs" role="tablist">
    <?php $first = true; foreach ($charts as $key => $chart): ?>
        <li class="nav-item" role="presentation">
            <button class="nav-link <?= $first ? 'active' : '' ?>" id="<?= $key ?>-tab"
                data-bs-toggle="tab" data-bs-target="#<?= $key ?>-content" type="button"
                role="tab" aria-controls="<?= $key ?>-content"
                aria-selected="<?= $first ? 'true' : 'false' ?>">
                <?= esc($chart['title']) ?>
            </button>
        </li>
    <?php $first = false; endforeach; ?>
</ul>

<div class="tab-content" id="chartTabsContent">
    <?php $first = true; foreach ($charts as $key => $chart): ?>
        <div class="tab-pane fade <?= $first ? 'show active' : '' ?>" id="<?= $key ?>-content"
            role="tabpanel" aria-labelledby="<?= $key ?>-tab">
            <div class="card mb-4 shadow-sm" style="border-radius: 1rem;">
                <div class="card-header text-white" style="background: <?= esc($chart['gradient']) ?>; border-radius: 1rem 1rem 0 0;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0" style="color: white;">
                            <?= esc($chart['title']) ?>: <?= number_format($chart['monthly']) ?>
                            <?php if (!is_null($chart['trend'])): ?>
                                <span class="badge bg-<?= $chart['trend'] >= 0 ? 'success' : 'danger' ?> ms-2">
                                    <?= $chart['trend'] >= 0 ? '↑' : '↓' ?> <?= abs($chart['trend']) ?>%
                                </span>
                            <?php endif; ?>
                        </h6>
                        <a href="<?= esc($chart['link']) ?>" class="btn btn-light radius-8 px-20 py-11">View More</a>
                    </div>
                </div>
                <div class="card-body">
                    <div id="<?= esc($chart['element_id']) ?>" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    <?php $first = false; endforeach; ?>
</div>


<script src="<?= base_url('assets/js/lib/apexcharts.min.js') ?>"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    // Language Donut
    <?php if(!empty($languageData)): ?>
        const languageSeries = <?= json_encode(array_map('intval', array_column($languageData, 'total_books'))) ?>;
        const languageLabels = <?= json_encode(array_column($languageData, 'language_name')) ?>;
        const languageColors = <?= json_encode($colors) ?>;

        new ApexCharts(document.querySelector("#languageDonutChart"), {
            chart: { type: 'donut', height: 250 },
            series: languageSeries,
            labels: languageLabels,
            colors: languageColors,
            legend: { show: false },
            dataLabels: { enabled: true },
            tooltip: { enabled: true }
        }).render();
    <?php endif; ?>

    // Genre & Category Bars
    <?php if(!empty($genreData)): ?>
        new ApexCharts(document.querySelector("#genreBar"), {
            chart: { type: 'bar', height: 350 },
            series: [{ name: 'Books', data: <?= json_encode(array_map('intval', array_column($genreData, 'total_books'))) ?> }],
            xaxis: { categories: <?= json_encode(array_column($genreData, 'genre_name')) ?>, labels: { rotate: -45, style: { fontSize: '12px', colors: '#6c757d' } } },
            plotOptions: { bar: { borderRadius: 4, horizontal: false } },
            dataLabels: { enabled: false },
            tooltip: { y: { formatter: val => val + ' books' } },
            grid: { strokeDashArray: 3 }
        }).render();
    <?php else: ?>
        document.querySelector("#genreBar").innerHTML = '<div class="text-center py-5 text-muted">No genre data available</div>';
    <?php endif; ?>

    <?php if(!empty($categoryData)): ?>
        new ApexCharts(document.querySelector("#categoryBar"), {
            chart: { type: 'bar', height: 350 },
            series: [{ name: 'Books', data: <?= json_encode(array_map('intval', array_column($categoryData, 'total_books'))) ?> }],
            xaxis: { categories: <?= json_encode(array_column($categoryData, 'book_category')) ?>, labels: { rotate: -45, style: { fontSize: '12px', colors: '#6c757d' } } },
            plotOptions: { bar: { borderRadius: 4, horizontal: false } },
            dataLabels: { enabled: false },
            tooltip: { y: { formatter: val => val + ' books' } },
            grid: { strokeDashArray: 3 }
        }).render();
    <?php else: ?>
        document.querySelector("#categoryBar").innerHTML = '<div class="text-center py-5 text-muted">No category data available</div>';
    <?php endif; ?>

    // Platform Monthly Area Charts
    const chartData = <?= json_encode($charts) ?>;

    function extractGradientColors(gradientStr) {
        const matches = gradientStr.match(/#(?:[0-9a-fA-F]{3,6})/g);
        return matches || ['#6a11cb', '#2575fc'];
    }

    Object.values(chartData).forEach(({ count, month, element_id, gradient }) => {
        const container = document.querySelector(`#${element_id}`);
        if (!container) return;

        const gradientColors = extractGradientColors(gradient);

        new ApexCharts(container, {
            chart: { type: 'area', height: 300, toolbar: { show: false } },
            series: [{ name: 'Books Published', data: count }],
            colors: [gradientColors[0]],
            stroke: { curve: 'smooth', width: 2 },
            fill: { type: 'gradient', gradient: { shadeIntensity: 1, gradientToColors: [gradientColors[1] || gradientColors[0]], opacityFrom: 0.6, opacityTo: 0.1, stops: [0, 100] } },
            xaxis: { categories: month, labels: { style: { fontSize: '12px', colors: '#6c757d' } } },
            yaxis: { min: 0, labels: { formatter: val => val.toFixed(0), style: { fontSize: '12px', colors: '#6c757d' } } },
            dataLabels: { enabled: false },
            tooltip: { y: { formatter: val => val + ' books' } },
            grid: { strokeDashArray: 3 }
        }).render();
    });
});
</script>

<?= $this->endSection(); ?>
