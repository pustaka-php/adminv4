<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 
<div class="container my-4">
    <div class="card radius-12 p-4">
        <div class="card-header bg-base py-16 px-24 border-bottom">
            <h5 class="text-lg fw-semibold text-center">Overall Sales (FY-Wise)</h5>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                    <tr style="background-color: #f2f2f2;">
                        <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Financial Year</th>
                        <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">E-Book</th>
                        <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Audiobook</th>
                        <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Paperback</th>
                        <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalEbook = 0;
                    $totalAudio = 0;
                    $totalPaperback = 0;
                    $totalRevenue = 0;
                    ?>

                    <?php if (!empty($over_all['overall_sales'])): ?>
                        <?php foreach ($over_all['overall_sales'] as $row): ?>
                            <?php
                            $ebook = (float)$row['ebook_revenue'];
                            $audio = (float)$row['audiobook_revenue'];
                            $paperback = (float)$row['paperback_revenue'];
                            $total = $ebook + $audio + $paperback;
                            $totalEbook += $ebook;
                            $totalAudio += $audio;
                            $totalPaperback += $paperback;
                            $totalRevenue += $total;
                            ?>
                            <tr>
                                <td style="padding: 8px; border: 1px solid #ddd;"><?= htmlspecialchars($row['fy']) ?></td>
                                <td style="padding: 8px; border: 1px solid #ddd;">₹<?= number_format($ebook, 2) ?></td>
                                <td style="padding: 8px; border: 1px solid #ddd;">₹<?= number_format($audio, 2) ?></td>
                                <td style="padding: 8px; border: 1px solid #ddd;">₹<?= number_format($paperback, 2) ?></td>
                                <td style="padding: 8px; border: 1px solid #ddd;">₹<?= number_format($total, 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr style="background-color: #e9f0ff; font-weight: bold;">
                            <td style="padding: 8px; border: 1px solid #ddd;">Total</td>
                            <td style="padding: 8px; border: 1px solid #ddd;">₹<?= number_format($totalEbook, 2) ?></td>
                            <td style="padding: 8px; border: 1px solid #ddd;">₹<?= number_format($totalAudio, 2) ?></td>
                            <td style="padding: 8px; border: 1px solid #ddd;">₹<?= number_format($totalPaperback, 2) ?></td>
                            <td style="padding: 8px; border: 1px solid #ddd;">₹<?= number_format($totalRevenue, 2) ?></td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align:center; padding: 10px; border: 1px solid #ddd;">No data available</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<br><br>
<h6 style="text-align:center;">Overall Month-wise Sales</h6>
<br>
<div style="margin: auto;">
    <canvas id="salesChart" style="width: 100%;"></canvas>
</div>

<!-- Load Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('salesChart').getContext('2d');
    const labels = <?php
        $labels = array_map(function($row) {
            return $row['month'] . '-' . $row['year'];
        }, $over_all['month_wise_sales']);
        echo json_encode(array_reverse($labels));
    ?>;

    const ebookRevenue = <?php
        $ebook = array_map(function($row) {
            return $row['ebook_revenue'];
        }, $over_all['month_wise_sales']);
        echo json_encode(array_reverse($ebook));
    ?>;

    const audiobookRevenue = <?php
        $audio = array_map(function($row) {
            return $row['audiobook_revenue'];
        }, $over_all['month_wise_sales']);
        echo json_encode(array_reverse($audio));
    ?>;

    const paperbackRevenue = <?php
        $paperback = array_map(function($row) {
            return $row['paperback_revenue'];
        }, $over_all['month_wise_sales']);
        echo json_encode(array_reverse($paperback));
    ?>;

    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'E-Book Revenue',
                    data: ebookRevenue,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: false,
                    tension: 0.4
                },
                {
                    label: 'Audiobook Revenue',
                    data: audiobookRevenue,
                    borderColor: 'rgba(153, 102, 255, 1)',
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    fill: false,
                    tension: 0.4
                },
                {
                    label: 'Paperback Revenue',
                    data: paperbackRevenue,
                    borderColor: 'rgb(243, 180, 231)',
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    fill: false,
                    tension: 0.5
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            let label = context.dataset.label || '';
                            if (label) label += ': ';
                            label += '₹' + context.parsed.y.toLocaleString();
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    ticks: {
                        callback: function (value) {
                            return '₹' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
});
</script>
<div class="container">
    <br><br>
    <ul class="nav nav-pills mb-3 mt-3" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="ebook-tab" data-toggle="pill" href="#ebook" role="tab" aria-controls="ebook" aria-selected="true" style="display: flex; align-items: center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book-open" style="margin-right: 5px;">
                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                </svg>
                E-Books
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="audiobook-tab" data-toggle="pill" href="#audiobook" role="tab" aria-controls="audiobook" aria-selected="false" style="display: flex; align-items: center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-headphones" style="margin-right: 5px;">
                    <path d="M3 18v-6a9 9 0 0 1 18 0v6"></path>
                    <path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"></path>
                </svg>
                Audio Books
            </a>
        </li>
    </ul>
    <div class="tab-content mt-4" id="salesTabsContent">
        <div class="tab-pane fade show active" id="ebook" role="tabpanel" aria-labelledby="ebook-tab"><br>
            <h6><center>E-Book Revenue</center></h6><br>
            <?php
            $ebook_channels = ['pustaka','amazon', 'overdrive', 'scribd', 'storytel', 'google', 'pratilipi', 'kobo'];
            $fy_data = [];

            foreach ($ebook_channels as $channel) {
                $channel_yearwise_key = $channel . '_yearwise';
                $yearwise = $channelwise[$channel_yearwise_key] ?? [];
                foreach ($yearwise as $row) {
                    $fy = $row['fy'];
                    $revenue = $row['revenue'] ?? 0;
                    $fy_data[$fy][$channel] = $revenue;
                }
            }
            krsort($fy_data);
            ?>
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>FY</th>
                        <?php foreach ($ebook_channels as $channel): ?>
                            <th><?= ucfirst($channel) ?></th>
                        <?php endforeach; ?>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $grand_total_ebook = 0;
                    foreach ($fy_data as $fy => $channels): 
                        $row_total = 0;
                    ?>
                        <tr>
                            <td><?= $fy ?></td>
                            <?php foreach ($ebook_channels as $channel): 
                                $value = $channels[$channel] ?? 0;
                                $row_total += $value;
                            ?>
                                <td><?= number_format($value, 2) ?></td>
                            <?php endforeach; ?>
                            <td><strong><?= number_format($row_total, 2) ?></strong></td>
                        </tr>
                        <?php $grand_total_ebook += $row_total; ?>
                    <?php endforeach; ?>
                    <tr style="font-weight: bold; background-color:rgb(201, 212, 239);">
                        <td>Total</td>
                        <?php 
                        $column_total = 0;
                        foreach ($ebook_channels as $channel): 
                            $sum = 0;
                            foreach ($fy_data as $channels) {
                                $sum += $channels[$channel] ?? 0;
                            }
                            $column_total += $sum;
                        ?>
                            <td><?= number_format($sum, 2) ?></td>
                        <?php endforeach; ?>
                        <td><?= number_format($column_total, 2) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade" id="audiobook" role="tabpanel" aria-labelledby="audiobook-tab"><br>
            <h6><center>Audio-Book Revenue</center></h6><br>
            <?php
            $channelwise = $channelwise ?? $data['channelwise'] ?? [];
            $audiobook_channels = ['pustaka_aud','audible', 'overdrive_aud', 'google_aud', 'storytel_aud', 'youtube_aud', 'kukufm_aud'];

            $fy_data_aud = [];
            foreach ($audiobook_channels as $channel) {
                $channel_yearwise_key = $channel . '_yearwise';
                $yearwise = $channelwise[$channel_yearwise_key] ?? [];

                foreach ($yearwise as $row) {
                    $fy = $row['fy'];
                    $revenue = $row['revenue'] ?? 0;
                    $fy_data_aud[$fy][$channel] = $revenue;
                }
            }
            krsort($fy_data_aud);
            ?>

            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>FY</th>
                        <?php foreach ($audiobook_channels as $channel): ?>
                            <th><?= ucfirst(str_replace('_aud', '', $channel)) ?></th>
                        <?php endforeach; ?>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($fy_data_aud)): 
                        $grand_total_aud = 0;
                        foreach ($fy_data_aud as $fy => $channels): 
                            $row_total = 0;
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($fy) ?></td>
                            <?php foreach ($audiobook_channels as $channel): 
                                $value = $channels[$channel] ?? 0;
                                $row_total += $value;
                            ?>
                                <td><?= number_format($value, 2) ?></td>
                            <?php endforeach; ?>
                            <td><strong><?= number_format($row_total, 2) ?></strong></td>
                        </tr>
                        <?php $grand_total_aud += $row_total; ?>
                    <?php endforeach; ?>
                    <tr style="font-weight: bold; background-color:rgb(201, 212, 239);">
                        <td>Total</td>
                        <?php 
                        $column_total = 0;
                        foreach ($audiobook_channels as $channel): 
                            $sum = 0;
                            foreach ($fy_data_aud as $channels) {
                                $sum += $channels[$channel] ?? 0;
                            }
                            $column_total += $sum;
                        ?>
                            <td><?= number_format($sum, 2) ?></td>
                        <?php endforeach; ?>
                        <td><?= number_format($column_total, 2) ?></td>
                    </tr>
                    <?php else: ?>
                        <tr>
                            <td colspan="<?= count($audiobook_channels) + 2 ?>" class="text-center">
                                No data available
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<br><br>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        </head>
        <body>
        <div class="container">
            <h6 style="text-align:center;">Channel-Wise Month-wise Sales</h6>
            <div class="tab-content" id="mainTabContent"><br>
                <div class="tab-pane fade show active" id="ebook" role="tabpanel">
                    <ul class="nav nav-pills mt-3" id="ebookChannelTabs" role="tablist">
                        <?php
                        $ebook_channels = ['pustaka','amazon', 'overdrive', 'google', 'scribd', 'storytel', 'pratilipi', 'kobo'];
                        foreach ($ebook_channels as $index => $channel) {
                            echo '<li class="nav-item">
                                    <a class="nav-link '.($index == 0 ? 'active' : '').'" id="'.$channel.'-tab" data-toggle="pill" href="#'.$channel.'" role="tab">'.ucfirst($channel).'</a>
                                </li>';
                        }
                        ?>
                    </ul>
                    <div class="tab-content mt-3">
                        <?php
                        foreach ($ebook_channels as $index => $channel) {
                            $month_data = $channelwise[$channel.'_monthwise'];
                            $labels = [];
                            $values = [];
                            foreach ($month_data as $row) {
                                $labels[] = $row['month'].'-'.$row['year'];
                                $values[] = $row['revenue'];
                            }
                            $canvas_id = $channel.'_ebook_chart';
                        ?>
                        <div class="tab-pane fade <?php echo $index == 0 ? 'show active' : ''; ?>" id="<?php echo $channel ?>" role="tabpanel">
                            <h5><?php echo ucfirst($channel); ?> eBook Sales</h5>
                            <canvas id="<?php echo $canvas_id ?>"></canvas>
                            <script>
                                var ctx = document.getElementById('<?php echo $canvas_id ?>').getContext('2d');
                                new Chart(ctx, {
                                    type: 'line',
                                    data: {
                                        labels: <?php echo json_encode($labels); ?>,
                                        datasets: [{
                                            label: 'Revenue',
                                            data: <?php echo json_encode($values); ?>,
                                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                            borderColor: 'rgba(54, 162, 235, 1)',
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        scales: {
                                            y: {
                                                beginAtZero: true
                                            }
                                        }
                                    }
                                });
                            </script>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="tab-pane fade" id="audiobook" role="tabpanel">
                    <ul class="nav nav-pills mt-3" id="audiobookChannelTabs" role="tablist">
                        <?php
                        $audiobook_channels = ['pustaka','audible', 'overdrive', 'storytel', 'google', 'youtube', 'kukufm'];
                        foreach ($audiobook_channels as $index => $channel) {
                            echo '<li class="nav-item">
                                    <a class="nav-link '.($index == 0 ? 'active' : '').'" id="'.$channel.'_aud-tab" data-toggle="pill" href="#'.$channel.'_aud" role="tab">'.ucfirst($channel).'</a>
                                </li>';
                        }
                        ?>
                    </ul>
                    <div class="tab-content mt-3">
                        <?php
                        foreach ($audiobook_channels as $index => $channel) {
                            $key = $channel.'_aud_monthwise';
                            $month_data = isset($channelwise[$key]) ? $channelwise[$key] : [];

                            $labels = [];
                            $values = [];
                            foreach ($month_data as $row) {
                                $labels[] = $row['month'].'-'.$row['year'];
                                $values[] = $row['revenue'];
                            }
                            $canvas_id = $channel.'_aud_chart';
                        ?>
                        <div class="tab-pane fade <?php echo $index == 0 ? 'show active' : ''; ?>" id="<?php echo $channel.'_aud' ?>" role="tabpanel">
                            <h5><?php echo ucfirst($channel); ?> Audiobook Sales</h5>
                            <canvas id="<?php echo $canvas_id ?>"></canvas>
                            <script>
                                var ctx = document.getElementById('<?php echo $canvas_id ?>').getContext('2d');
                                new Chart(ctx, {
                                    type: 'line',
                                    data: {
                                        labels: <?php echo json_encode($labels); ?>,
                                        datasets: [{
                                            label: 'Revenue',
                                            data: <?php echo json_encode($values); ?>,
                                            backgroundColor: 'rgba(255, 99, 132, 0.6)',
                                            borderColor: 'rgba(255, 99, 132, 1)',
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        scales: {
                                            y: {
                                                beginAtZero: true
                                            }
                                        }
                                    }
                                });
                            </script>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
        <script>
    $(document).ready(function () {
        $('#ebook-tab').on('click', function (e) {
            e.preventDefault();
            $('#ebook-tab').tab('show'); 
            $('#mainTabContent .tab-pane').removeClass('show active');
            $('#mainTabContent #ebook').addClass('show active');            
            $('html, body').animate({
                scrollTop: $('#mainTabContent #ebook').offset().top - 100
            }, 600);
        });

        $('#audiobook-tab').on('click', function (e) {
            e.preventDefault();
            $('#audiobook-tab').tab('show'); 
            $('#mainTabContent .tab-pane').removeClass('show active');
            $('#mainTabContent #audiobook').addClass('show active');
            $('html, body').animate({
                scrollTop: $('#mainTabContent #audiobook').offset().top - 100
            }, 600);
        });
    });
</script>
<?= $this->endSection(); ?>
