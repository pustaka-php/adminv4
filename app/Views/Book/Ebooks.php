<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<?php
function calculateTrend($data) {
    $count = count($data);
    if ($count < 2) return null;
    $last = $data[$count - 1];
    $prev = $data[$count - 2];
    if ($prev == 0) return null;
    $diff = $last - $prev;
    $percentage = ($diff / $prev) * 100;
    return round($percentage, 1);
}

$charts = [
    'pustaka' => [
        'count' => $e_books['pus_publish_monthly_cnt'],
        'month' => $e_books['pus_month'],
        'title' => 'Pustaka',
        'monthly' => $e_books['pus_monthly'],
        'link' => base_url('adminv3/pustaka_details'),
        'element_id' => 'pus_e_book_monthly',
        'color' => '#6a11cb',
        'gradient' => 'linear-gradient(90deg, #6a11cb 0%, #2575fc 100%)',
        'trend' => calculateTrend($e_books['pus_publish_monthly_cnt'])
    ],
    'amazon' => [
        'count' => $e_books['amz_publish_monthly_cnt'],
        'month' => $e_books['amz_month'],
        'title' => 'Amazon',
        'monthly' => $e_books['amz_monthly'],
        'link' => base_url('adminv3/amazon_details'),
        'element_id' => 'amz_e_book_monthly',
        'color' => '#f12711',
        'gradient' => 'linear-gradient(90deg, #f12711 0%, #f5af19 100%)',
        'trend' => calculateTrend($e_books['amz_publish_monthly_cnt'])
    ],
    'scribd' => [
        'count' => $e_books['scr_publish_monthly_cnt'],
        'month' => $e_books['scr_month'],
        'title' => 'Scribd',
        'monthly' => $e_books['scr_monthly'],
        'link' => base_url('adminv3/scribd_details'),
        'element_id' => 'scr_e_book_monthly',
        'color' => '#11998e',
        'gradient' => 'linear-gradient(90deg, #11998e 0%, #38ef7d 100%)',
        'trend' => calculateTrend($e_books['scr_publish_monthly_cnt'])
    ],
    'storytel' => [
        'count' => $e_books['storytel_publish_monthly_cnt'],
        'month' => $e_books['storytel_month'],
        'title' => 'Storytel',
        'monthly' => $e_books['storytel_monthly'],
        'link' => base_url('adminv3/storytel_details'),
        'element_id' => 'storytel_e_book_monthly',
        'color' => '#833ab4',
        'gradient' => 'linear-gradient(90deg, #833ab4 0%, #fd1d1d 50%, #fcb045 100%)',
        'trend' => calculateTrend($e_books['storytel_publish_monthly_cnt'])
    ],
    'google' => [
        'count' => $e_books['goog_publish_monthly_cnt'],
        'month' => $e_books['goog_month'],
        'title' => 'GoogleBooks',
        'monthly' => $e_books['goog_monthly'],
        'link' => base_url('adminv3/google_details'),
        'element_id' => 'goog_e_book_monthly',
        'color' => '#00c6ff',
        'gradient' => 'linear-gradient(90deg, #00c6ff 0%, #0072ff 100%)',
        'trend' => calculateTrend($e_books['goog_publish_monthly_cnt'])
    ],
    'overdrive' => [
        'count' => $e_books['over_publish_monthly_cnt'],
        'month' => $e_books['over_month'],
        'title' => 'Overdrive',
        'monthly' => $e_books['over_monthly'],
        'link' => base_url('adminv3/overdrive_details'),
        'element_id' => 'over_e_book_monthly',
        'color' => '#8e2de2',
        'gradient' => 'linear-gradient(90deg, #8e2de2 0%, #4a00e0 100%)',
        'trend' => calculateTrend($e_books['over_publish_monthly_cnt'])
    ]
];
?>

<div class="row">
    <?php foreach ($charts as $chart): ?>
        <div class="col-12 mb-4">
            <section aria-labelledby="<?= esc($chart['element_id']) ?>_title">
                <div class="card mb-4 shadow-sm" style="border-radius: 1rem;">
                    <div class="card-header text-white" style="border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                        <div class="d-flex justify-content-between align-items-center">
                           <h6 style="background: <?= esc($chart['gradient']) ?>; color: white; padding: 0.25rem 0.75rem; border-radius: 0.5rem; font-weight: 600; display: inline-block;">
                                <?= esc($chart['title']) ?>: <?= number_format($chart['monthly']) ?>
                            </h6>
                            <a href="<?= esc($chart['link']) ?>" class="btn btn-success-600 radius-8 px-20 py-11">View More</a>
                        </div>
                    </div>
                    <div class="card-body" style="background: transparent;">
                        <div id="<?= esc($chart['element_id']) ?>" style="height: 300px;">
                            <div class="text-center py-5 text-muted">Loading chart...</div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    <?php endforeach; ?>
</div>


<!-- ✅ Use Local ApexCharts -->
<script src="<?= base_url('assets/js/lib/apexcharts.min.js') ?>"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const chartData = <?= json_encode($charts) ?>;

    function extractGradientColors(gradientStr) {
        const matches = gradientStr.match(/#(?:[0-9a-fA-F]{3,6})/g);
        return matches || ['#6a11cb', '#2575fc'];
    }

    Object.values(chartData).forEach(({ count, month, element_id, gradient }) => {
        const container = document.querySelector(`#${element_id}`);
        if (!container) return;
        container.innerHTML = '';

        const gradientColors = extractGradientColors(gradient);

        const options = {
            chart: {
                type: 'area',
                height: 300,
                toolbar: { show: false },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800
                }
            },
            colors: [gradientColors[0]],
            series: [{
                name: 'Books Published',
                data: count
            }],
            dataLabels: { enabled: false },
            xaxis: {
                categories: month,
                labels: {
                    style: {
                        fontSize: '12px',
                        colors: '#6c757d'
                    }
                }
            },
            yaxis: {
                labels: {
                    formatter: val => val.toFixed(0),
                    style: {
                        fontSize: '12px',
                        colors: '#6c757d'
                    }
                },
                min: 0
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    gradientToColors: [gradientColors[1] || gradientColors[0]],
                    opacityFrom: 0.6,
                    opacityTo: 0.1,
                    stops: [0, 100]
                }
            },
            tooltip: {
                y: {
                    formatter: val => `${val} books`
                }
            },
            grid: {
                strokeDashArray: 3
            }
        };

        try {
            const chart = new ApexCharts(container, options);
            chart.render();
        } catch (error) {
            console.error(`Error rendering chart ${element_id}:`, error);
            container.innerHTML = '<div class="text-center py-5 text-danger">Error loading chart</div>';
        }
    });
});
</script>

<?= $this->endSection(); ?>
