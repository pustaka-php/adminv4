<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?> 
<?php
function formatIndianCurrency($number) {
    $number = number_format((float)$number, 2, '.', '');
    $explrestunits = "" ;
    if(strlen($number) > 3) {
        $lastthree = substr($number, strlen($number) - 6, 6);  // Includes decimal part
        $restunits = substr($number, 0, strlen($number) - 6);
        $restunits = (strlen($restunits) % 2 == 1) ? "0".$restunits : $restunits;
        $expunit = str_split($restunits, 2);
        for ($i = 0; $i < sizeof($expunit); $i++) {
            if ($i == 0) {
                $explrestunits .= (int)$expunit[$i] . ",";
            } else {
                $explrestunits .= $expunit[$i] . ",";
            }
        }
        $thecash = $explrestunits . $lastthree;
    } else {
        $thecash = $number;
    }
    return $thecash;
}
?>

<div class="container" style="margin: 5; padding: 5; max-width:100%;">
    <div class="layout-px-spacing">
        <div class="container">
            <br>
            <center><h5>Overall E-Book Sales (FY-Wise)</h5></center>
            <br>
            <div style="width: 100%; max-width: 100%; margin: 0 auto;">
                <div style="border: 1px solid #ccc; border-radius: 6px; padding: 20px;">
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: separate; border-spacing: 15px 10px; table-layout: auto; white-space: nowrap;">
                            <thead>
                                <tr style="background-color: #f2f2f2;">
                                    <th style="text-align: left; padding: 12px 15px; border: 1px solid #ddd; min-width: 150px; vertical-align: middle;">Financial Year</th>
                                    <th style="text-align: left; padding: 12px 15px; border: 1px solid #ddd; min-width: 150px; vertical-align: middle;">Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $totalEbook = 0;
                                ?>

                                <?php if (!empty($ebook['ebook_total'])): ?>
                                    <?php foreach ($ebook['ebook_total'] as $row): ?>
                                        <?php
                                        $ebookRevenue = (float)$row['ebook_revenue']; 
                                        $totalEbook += $ebookRevenue;
                                        ?>
                                        <tr>
                                            <td style="padding: 12px 15px; border: 1px solid #ddd; white-space: nowrap; min-width: 150px; vertical-align: middle;"><?= htmlspecialchars($row['fy']) ?></td>    
                                            <td style="padding: 12px 15px; border: 1px solid #ddd; white-space: nowrap; min-width: 150px; vertical-align: middle;">₹<?= formatIndianCurrency($ebookRevenue) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr style="background-color: #e9f0ff; font-weight: bold;">
                                        <td style="padding: 12px 15px; border: 1px solid #ddd; white-space: nowrap; min-width: 150px; vertical-align: middle;">Total</td>
                                        <td style="padding: 12px 15px; border: 1px solid #ddd; white-space: nowrap; min-width: 150px; vertical-align: middle;">₹<?= formatIndianCurrency($totalEbook) ?></td>
                                    </tr>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="2" style="text-align:center; padding: 12px 15px; border: 1px solid #ddd;">No data available</td> 
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<br><br>

<div class="container">
    <div class="layout-px-spacing">
        <div class="container" style="max-width: 1000px; margin-left:-20px;">
            <br>
            <h5><center>Channel-Wise Revenue</center></h5><br>
            <?php
            $ebook_channels = ['pustaka','amazon', 'overdrive', 'scribd', 'storytel', 'google', 'pratilipi', 'kobo'];
            $fy_data = [];

            foreach ($ebook_channels as $channel) {
                $ebook_key = $channel . '_yearwise';
                $yearwise = $ebook[$ebook_key] ?? [];
                foreach ($yearwise as $row) {
                    $fy = $row['fy'];
                    $revenue = $row['revenue'] ?? 0;
                    $fy_data[$fy][$channel] = $revenue;
                }
            }
            krsort($fy_data);
            ?>
            <div style="width: 100%; max-width: 100%; margin: 0 auto;">
                <div style="border: 1px solid #ccc; border-radius: 6px; padding: 20px;">
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: separate; border-spacing: 15px 10px; table-layout: auto; white-space: nowrap;">
                            <thead>
                                <tr style="background-color: #f2f2f2;">
                                    <th style="text-align: left; padding: 12px 15px; border: 1px solid #ddd; min-width: 80px; vertical-align: middle;">FY</th>
                                    <?php foreach ($ebook_channels as $channel): ?>
                                        <th style="text-align: left; padding: 12px 15px; border: 1px solid #ddd; min-width: 90px; vertical-align: middle;"><?= ucfirst($channel) ?></th>
                                    <?php endforeach; ?>
                                    <th style="text-align: left; padding: 12px 15px; border: 1px solid #ddd; min-width: 90px; vertical-align: middle;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $grand_total_ebook = 0;
                                foreach ($fy_data as $fy => $channels): 
                                    $row_total = 0;
                                ?>
                                    <tr>
                                        <td style="padding: 12px 15px; border: 1px solid #ddd; white-space: nowrap; min-width: 80px; vertical-align: middle;"><?= $fy ?></td>
                                        <?php foreach ($ebook_channels as $channel): 
                                            $value = $channels[$channel] ?? 0;
                                            $row_total += $value;
                                        ?>
                                            <td style="padding: 12px 15px; border: 1px solid #ddd; white-space: nowrap; min-width: 90px; vertical-align: middle;">₹<?= formatIndianCurrency($value) ?></td>
                                        <?php endforeach; ?>
                                        <td style="padding: 12px 15px; border: 1px solid #ddd; font-weight: bold; white-space: nowrap; min-width: 90px; vertical-align: middle;">₹<?= formatIndianCurrency($row_total) ?></td>
                                    </tr>
                                    <?php $grand_total_ebook += $row_total; ?>
                                <?php endforeach; ?>
                                <tr style="background-color: #e9f0ff; font-weight: bold;">
                                    <td style="padding: 12px 15px; border: 1px solid #ddd; white-space: nowrap; min-width: 80px; vertical-align: middle;">Total</td>
                                    <?php 
                                    $column_total = 0;
                                    foreach ($ebook_channels as $channel): 
                                        $sum = 0;
                                        foreach ($fy_data as $channels) {
                                            $sum += $channels[$channel] ?? 0;
                                        }
                                        $column_total += $sum;
                                    ?>
                                        <td style="padding: 12px 15px; border: 1px solid #ddd; white-space: nowrap; min-width: 90px; vertical-align: middle;">₹<?= formatIndianCurrency($sum) ?></td>
                                    <?php endforeach; ?>
                                    <td style="padding: 12px 15px; border: 1px solid #ddd; white-space: nowrap; min-width: 90px; vertical-align: middle;">₹<?= formatIndianCurrency($column_total) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<br><br>

<div class="container">
    <div class="layout-px-spacing">
        <div class="container" style="max-width: 1000px; margin-left:-20px;">
            <br>
            <h5><center>Month-Wise Revenue</center></h5>
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
                            $month_data = $ebook[$channel.'_monthwise'] ?? [];
                            $labels = [];
                            $values = [];
                            foreach ($month_data as $row) {
                                $labels[] = $row['month'].'-'.$row['year'];
                                $values[] = $row['revenue'];
                            }
                            $canvas_id = $channel.'_ebook_chart';
                        ?>
                        <div class="tab-pane fade <?php echo $index == 0 ? 'show active' : ''; ?>" id="<?php echo $channel ?>" role="tabpanel">
                            <h6><?php echo ucfirst($channel); ?> E-Book Sales</h6>
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
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?> 
