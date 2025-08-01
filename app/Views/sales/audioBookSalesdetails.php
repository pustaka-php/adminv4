<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>


<?php
function formatIndianCurrency($number) {
    $number = number_format((float)$number, 2, '.', '');
    $explrestunits = "";
    if (strlen($number) > 3) {
        $lastthree = substr($number, strlen($number) - 6, 6);
        $restunits = substr($number, 0, strlen($number) - 6);
        $restunits = (strlen($restunits) % 2 == 1) ? "0".$restunits : $restunits;
        $expunit = str_split($restunits, 2);
        foreach ($expunit as $i => $unit) {
            $explrestunits .= ($i == 0 ? (int)$unit : $unit) . ",";
        }
        $thecash = $explrestunits . $lastthree;
    } else {
        $thecash = $number;
    }
    return $thecash;
}
?>

<!-- FY-Wise Audiobook Revenue -->
<div class="container my-4">
    <div class="card radius-12 p-4">
        <div class="card-header bg-base py-16 px-24 border-bottom">
            <h5 class="text-lg fw-semibold text-center">Overall Audiobook Sales (FY-Wise)</h5>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>Financial Year</th>
                            <th>Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $totalAudio = 0; ?>
                        <?php if (!empty($audiobook['audiobook_total'])): ?>
                            <?php foreach ($audiobook['audiobook_total'] as $row): 
                                $audio = (float)$row['audiobook_revenue'];
                                $totalAudio += $audio;
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($row['fy']) ?></td>    
                                <td>₹<?= formatIndianCurrency($audio) ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <tr class="fw-bold bg-light">
                                <td>Total</td>
                                <td>₹<?= formatIndianCurrency($totalAudio) ?></td>
                            </tr>
                        <?php else: ?>
                            <tr><td colspan="2" class="text-center">No data available</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Channel-Wise Audiobook Revenue -->
<div class="container my-4">
    <div class="card radius-12 p-4">
        <div class="card-header bg-base py-16 px-24 border-bottom">
            <h5 class="text-lg fw-semibold text-center">Channel-Wise Revenue</h5>
        </div>
        <div class="card-body p-3">
            <?php
            $audiobook_channels = ['pustaka_aud','audible','overdrive_aud','google_aud','storytel_aud','youtube_aud','kukufm_aud'];
            $fy_data_aud = [];
            foreach ($audiobook_channels as $channel) {
                foreach ($audiobook[$channel . '_yearwise'] ?? [] as $row) {
                    $fy = $row['fy'];
                    $revenue = $row['revenue'] ?? 0;
                    $fy_data_aud[$fy][$channel] = $revenue;
                }
            }
            krsort($fy_data_aud);
            ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>FY</th>
                            <?php foreach ($audiobook_channels as $channel): ?>
                                <th><?= ucfirst(str_replace('_aud', '', $channel)) ?></th>
                            <?php endforeach; ?>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $grand_total = 0; ?>
                        <?php foreach ($fy_data_aud as $fy => $channels): 
                            $row_total = 0;
                        ?>
                        <tr>
                            <td><?= $fy ?></td>
                            <?php foreach ($audiobook_channels as $channel): 
                                $value = $channels[$channel] ?? 0;
                                $row_total += $value;
                            ?>
                                <td>₹<?= formatIndianCurrency($value) ?></td>
                            <?php endforeach; ?>
                            <td class="fw-bold">₹<?= formatIndianCurrency($row_total) ?></td>
                        </tr>
                        <?php $grand_total += $row_total; endforeach; ?>
                        <tr class="fw-bold bg-light">
                            <td>Total</td>
                            <?php foreach ($audiobook_channels as $channel): 
                                $sum = array_sum(array_column($fy_data_aud, $channel));
                            ?>
                                <td>₹<?= formatIndianCurrency($sum) ?></td>
                            <?php endforeach; ?>
                            <td>₹<?= formatIndianCurrency($grand_total) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Month-Wise Revenue Chart Tabs -->
<div class="container my-5">
    <div class="card radius-12">
        <div class="card-header bg-base border-bottom">
            <h5 class="text-lg text-center py-3 mb-0">Month-Wise Audiobook Revenue</h5>
        </div>
        <div class="card-body p-4 pt-3">
            <?php 
            $channels = ['pustaka','audible','overdrive','storytel','google','youtube','kukufm']; 
            ?>
            <ul class="nav nav-pills button-tab mb-4" id="audiobookTabs" role="tablist">
                <?php foreach ($channels as $index => $channel): ?>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?= $index === 0 ? 'active' : '' ?> fw-semibold text-primary-light"
                            id="<?= $channel ?>-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#<?= $channel ?>-chart"
                            type="button"
                            role="tab"
                            aria-controls="<?= $channel ?>-chart"
                            aria-selected="<?= $index === 0 ? 'true' : 'false' ?>">
                            <?= ucfirst($channel) ?>
                        </button>
                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="tab-content" id="audiobookTabsContent">
                <?php foreach ($channels as $index => $channel): 
                    $month_data = $audiobook[$channel.'_aud_monthwise'] ?? [];
                    $labels = array_map(fn($row) => $row['month'].'-'.$row['year'], $month_data);
                    $values = array_column($month_data, 'revenue');
                    $canvas_id = $channel.'_aud_chart';
                ?>
                <div class="tab-pane fade <?= $index === 0 ? 'show active' : '' ?>" id="<?= $channel ?>-chart" role="tabpanel">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h6 class="mb-3"><?= ucfirst($channel) ?> Audiobook Revenue</h6>
                            <canvas id="<?= $canvas_id ?>"></canvas>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
<?php foreach ($channels as $index => $channel): 
    $month_data = $audiobook[$channel.'_aud_monthwise'] ?? [];
    $labels = array_map(fn($row) => $row['month'].'-'.$row['year'], $month_data);
    $values = array_column($month_data, 'revenue');
    $canvas_id = $channel.'_aud_chart';
?>
    const ctx<?= $index ?> = document.getElementById('<?= $canvas_id ?>').getContext('2d');
    new Chart(ctx<?= $index ?>, {
        type: 'line',
        data: {
            labels: <?= json_encode($labels); ?>,
            datasets: [{
                label: 'Revenue',
                data: <?= json_encode($values); ?>,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(174, 39, 236, 1)',
                fill: false,
                tension: 0.3,
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
<?php endforeach; ?>
</script>
<?= $this->endSection(); ?>
