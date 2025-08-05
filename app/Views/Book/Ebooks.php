<?php
// Prepare chart data for each platform
$charts = [
    'pustaka' => [
        'count' => json_encode($e_books['pus_publish_monthly_cnt']),
        'month' => json_encode($e_books['pus_month']),
        'title' => 'Pustaka',
        'monthly' => $e_books['pus_monthly'],
        'link' => base_url('adminv3/pustaka_details'),
        'element_id' => 'pus_e_book_monthly',
        'color' => '#6a11cb',
        'gradient' => 'linear-gradient(90deg, #6a11cb 0%, #2575fc 100%)'
    ],
    'amazon' => [
        'count' => json_encode($e_books['amz_publish_monthly_cnt']),
        'month' => json_encode($e_books['amz_month']),
        'title' => 'Amazon',
        'monthly' => $e_books['amz_monthly'],
        'link' => base_url('adminv3/amazon_details'),
        'element_id' => 'amz_e_book_monthly',
        'color' => '#f12711',
        'gradient' => 'linear-gradient(90deg, #f12711 0%, #f5af19 100%)'
    ],
    'scribd' => [
        'count' => json_encode($e_books['scr_publish_monthly_cnt']),
        'month' => json_encode($e_books['scr_month']),
        'title' => 'Scribd',
        'monthly' => $e_books['scr_monthly'],
        'link' => base_url('adminv3/scribd_details'),
        'element_id' => 'scr_e_book_monthly',
        'color' => '#11998e',
        'gradient' => 'linear-gradient(90deg, #11998e 0%, #38ef7d 100%)'
    ],
    'storytel' => [
        'count' => json_encode($e_books['storytel_publish_monthly_cnt']),
        'month' => json_encode($e_books['storytel_month']),
        'title' => 'Storytel',
        'monthly' => $e_books['storytel_monthly'],
        'link' => base_url('adminv3/storytel_details'),
        'element_id' => 'storytel_e_book_monthly',
        'color' => '#833ab4',
        'gradient' => 'linear-gradient(90deg, #833ab4 0%, #fd1d1d 50%, #fcb045 100%)'
    ],
    'google' => [
        'count' => json_encode($e_books['goog_publish_monthly_cnt']),
        'month' => json_encode($e_books['goog_month']),
        'title' => 'GoogleBooks',
        'monthly' => $e_books['goog_monthly'],
        'link' => base_url('adminv3/google_details'),
        'element_id' => 'goog_e_book_monthly',
        'color' => '#00c6ff',
        'gradient' => 'linear-gradient(90deg, #00c6ff 0%, #0072ff 100%)'
    ],
    'overdrive' => [
        'count' => json_encode($e_books['over_publish_monthly_cnt']),
        'month' => json_encode($e_books['over_month']),
        'title' => 'Overdrive',
        'monthly' => $e_books['over_monthly'],
        'link' => base_url('adminv3/overdrive_details'),
        'element_id' => 'over_e_book_monthly',
        'color' => '#8e2de2',
        'gradient' => 'linear-gradient(90deg, #8e2de2 0%, #4a00e0 100%)'
    ]
];
?>

<!-- Bootstrap 5 container -->
<div class="container" style="margin: 5; padding: 5; margin-top: -650px;">
    <div class="text-center mb-5">
        <h2 class="fw-bold">e-Books Dashboard</h2>
        <p class="text-muted">Monthly Publishing Overview</p>
    </div>

    <!-- Loop all charts -->
    <?php foreach ($charts as $chart): ?>
        <div class="card mb-5 shadow-sm" style="border-radius: 1rem;">
            <div class="card-header text-white" style="background: <?= esc($chart['gradient']) ?>; border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="m-0"><?= esc($chart['title']) ?>: <?= esc($chart['monthly']) ?></h5>
                    <a href="<?= esc($chart['link']) ?>" class="btn btn-light btn-sm text-dark">View More</a>
                </div>
            </div>
            <div class="card-body bg-light">
                <div id="<?= esc($chart['element_id']) ?>" style="height: 300px;"></div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- ApexCharts Script -->
<script>
    const chartData = <?= json_encode($charts) ?>;

    Object.values(chartData).forEach(({ count, month, element_id, color }) => {
        const options = {
            chart: {
                type: 'area',
                stacked: true,
                height: 300,
                toolbar: { tools: { download: false } }
            },
            colors: [color],
            dataLabels: { enabled: false },
            series: [{ name: 'Number', data: JSON.parse(count) }],
            xaxis: { categories: JSON.parse(month) },
            stroke: { curve: 'smooth' },
            fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.6, opacityTo: 0.1 } }
        };
        const chart = new ApexCharts(document.querySelector(`#${element_id}`), options);
        chart.render();
    });
</script>

<!-- Optional: Bootstrap & ApexCharts CDN (add in your <head> section if not already loaded) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
