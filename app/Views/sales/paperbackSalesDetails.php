<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>

<?php
function formatIndianCurrency($number) {
    $number = number_format((float)$number, 2, '.', '');
    $explrestunits = "" ;
    if(strlen($number) > 3) {
        $lastthree = substr($number, strlen($number) - 6, 6);
        $restunits = substr($number, 0, strlen($number) - 6);
        $restunits = (strlen($restunits) % 2 == 1) ? "0".$restunits : $restunits;
        $expunit = str_split($restunits, 2);
        for ($i = 0; $i < sizeof($expunit); $i++) {
            $explrestunits .= ($i == 0 ? (int)$expunit[$i] : $expunit[$i]) . ",";
        }
        $thecash = $explrestunits . $lastthree;
    } else {
        $thecash = $number;
    }
    return $thecash;
}
?>

<!-- Paperback Sales Table -->
<div class="container my-4">
    <div class="card radius-12 p-4 shadow-sm">
        <div class="card-header text-white text-center py-3">
            <h6 class="mb-0">Paperback Sales (FY-Wise)</h6>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Financial Year</th>
                            <th class="text-end">Revenue (₹)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $grand_total = 0;
                        if (!empty($pustaka['pustaka_paperback'])):
                            foreach ($pustaka['pustaka_paperback'] as $row):
                                $fy = $row['financial_year'] ?? '';
                                $revenue = (float)($row['paperback_revenue'] ?? 0);
                                $grand_total += $revenue;
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($fy) ?></td>
                                <td class="text-end">₹<?= formatIndianCurrency($revenue) ?></td>
                            </tr>
                        <?php
                            endforeach;
                        else:
                        ?>
                            <tr>
                                <td colspan="2" class="text-center text-muted">No sales data available.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                    <?php if (!empty($pustaka['pustaka_paperback'])): ?>
                    <tfoot class="table-light fw-semibold">
                        <tr>
                            <td>Total</td>
                            <td class="text-end">₹<?= formatIndianCurrency($grand_total) ?></td>
                        </tr>
                    </tfoot>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>
</div>
<br><br>
<!-- Paperback Sales Chart -->
<div class="container my-4">
    <div class="card radius-12 p-4 shadow-sm">
        <div class="card-header text-white text-center py-3">
            <h6 class="mb-0">Paperback Sales Chart</h6>
        </div>
        <div class="card-body p-3">
            <div class="chart-container" style="width: 100%; max-width: 900px; margin: auto;">
                <canvas id="salesChart"></canvas>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                const labels = [];
                const revenues = [];
                <?php foreach($pustaka['pustaka_paperback'] as $row):
                    $fy = $row['financial_year'] ?? '';
                    $revenue = $row['paperback_revenue'] ?? 0;
                ?>
                    labels.push(<?= json_encode($fy) ?>);
                    revenues.push(<?= json_encode($revenue) ?>);
                <?php endforeach; ?>

                const ctx = document.getElementById('salesChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Revenue (₹)',
                            data: revenues,
                            backgroundColor: 'rgba(50, 181, 21, 0.3)',
                            borderColor: 'rgba(136, 240, 45, 1)',
                            borderWidth: 2,
                            tension: 0.4,
                            fill: false,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Paperback Sales (Yearly Revenue)',
                                font: { size: 18 }
                            },
                            legend: { display: true }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Revenue (₹)'
                                },
                                ticks: {
                                    callback: value => '₹' + value.toLocaleString()
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Financial Year'
                                }
                            }
                        }
                    }
                });
            </script>
        </div>
    </div>
</div>
<br><br>
<!-- Channel-Wise Sales Table -->
<div class="container my-4">
    <div class="card radius-12 p-4 shadow-sm">
        <div class="card-header text-white text-center py-3">
            <h6 class="mb-0">Channel-Wise Sales</h6>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle mb-0 text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Flipkart</th>
                            <th>Amazon</th>
                            <th>Bookshop</th>
                            <th>Pustaka</th>
                            <th>Offline</th>
                            <th>Bookfair</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="fw-semibold">
                            <td>₹<?= formatIndianCurrency($pustaka['flipkart']['flipkart_order']) ?></td>
                            <td>₹<?= formatIndianCurrency($pustaka['amazon']['amazon_order']) ?></td>
                            <td>₹<?= formatIndianCurrency($pustaka['bookshop']['bookshop_order']) ?></td>
                            <td>₹<?= formatIndianCurrency($pustaka['pustaka']['pustaka_order']) ?></td>
                            <td>₹<?= formatIndianCurrency($pustaka['online']['offline_order']) ?></td>
                            <td>₹<?= formatIndianCurrency($pustaka['bookfair']['book_fair']) ?></td>
                            <td>
                                <?php
                                    $total = $pustaka['flipkart']['flipkart_order']
                                        + $pustaka['amazon']['amazon_order']
                                        + $pustaka['bookshop']['bookshop_order']
                                        + $pustaka['pustaka']['pustaka_order']
                                        + $pustaka['online']['offline_order']
                                        + $pustaka['bookfair']['book_fair'];
                                    echo '₹' . formatIndianCurrency($total);
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
