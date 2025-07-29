<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>
<div class="row gy-4">
    <div class="col-12">
        <!-- Overall Sales Card -->
        <div class="trail-bg h-10 text-center d-flex flex-column justify-content-between align-items-center p-16 radius-8">
            <div class="card-body">
                <h6 class="mb-3">Overall Sales</h6>
                <a href="salesreports" class="btn btn-primary rounded-pill" target="_blank">
                    View Reports
                </a>
            </div>
        </div>
        <?php 
            $total_row = null;
            foreach ($total['total'] as $row) {
                if ($row['fy'] === 'Total') {
                    $total_row = $row;
                    break;
                }
            }
        ?>
        <!-- Revenue Summary Cards -->
        <div class="row g-4">
            <div class="row g-4">
                <!-- Ebook Revenue -->
                <div class="col-md-3">
                    <div class="radius-8 h-100 text-center p-20 bg-purple-light shadow-sm">
                        <span class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-xl mb-12 bg-lilac-200 border border-lilac-400 text-lilac-600">
                            <i class="ri-book-2-fill"></i>
                        </span>
                        <span class="text-neutral-700 d-block">Ebook Revenue</span>
                        <h6 class="mb-0 mt-4">₹<?= number_format($total_row['ebook_revenue'] ?? 0, 2); ?></h6>
                        <a href="ebookSalesDetails" class="btn py-8 rounded-pill w-100 bg-gradient-blue-warning text-sm mt-3" target="_blank">
                            View Details
                        </a>
                    </div>
                </div>

                <!-- Audiobook Revenue -->
                <div class="col-md-3">
                    <div class="radius-8 h-100 text-center p-20 bg-success-100 shadow-sm">
                        <span class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-xl mb-12 bg-success-200 border border-success-400 text-success-600">
                            <i class="ri-headphone-fill"></i>
                        </span>
                        <span class="text-neutral-700 d-block">Audiobook Revenue</span>
                        <h6 class="mb-0 mt-4">₹<?= number_format($total_row['audiobook_revenue'] ?? 0, 2); ?></h6>
                        <a href="audiobookSalesDetails" class="btn py-8 rounded-pill w-100 bg-gradient-blue-warning text-sm mt-3" target="_blank">
                            View Details
                        </a>
                    </div>
                </div>

                <!-- Paperback Revenue -->
                <div class="col-md-3">
                    <div class="radius-8 h-100 text-center p-20 bg-danger-100">
                        <span class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-xl mb-12 bg-warning-200 border border-warning-400 text-warning-700">
                            <i class="ri-file-paper-2-fill"></i>
                        </span>
                        <span class="text-neutral-700 d-block">Paperback Revenue</span>
                        <h6 class="mb-0 mt-4">₹<?= number_format($total_row['paperback_revenue'] ?? 0, 2); ?></h6>
                        <a href="paperbackSalesDetails" class="btn py-8 rounded-pill w-100 bg-gradient-blue-warning text-sm mt-3" target="_blank">
                            View Details
                        </a>
                    </div>
                </div>

                <!-- POD -->
                <div class="col-md-3">
                    <div class="radius-8 h-100 text-center p-20 bg-info-focus">
                        <span class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-xl mb-12 bg-success-200 border border-success-400 text-success-600">
                            <i class="ri-printer-fill"></i>
                        </span>
                        <span class="text-neutral-700 d-block">POD</span>
                        <h6 class="mb-0 mt-4">₹<?= number_format($pod['pod_overall']['pod_total'] ?? 0, 2); ?></h6>
                        <a href="/pod/pod_publisher_dashboard" class="btn py-8 rounded-pill w-100 bg-gradient-blue-warning text-sm mt-3" target="_blank">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
            <!-- Ebook Revenue Summary Table -->
            <?php
                $channelwise = $channelwise ?? $data['channelwise'] ?? [];
                $ebook_channels = ['pustaka', 'amazon', 'overdrive', 'scribd', 'storytel', 'google', 'pratilipi', 'kobo'];
                $ebook_totals = [];
                foreach ($ebook_channels as $channel) {
                    $sum = 0;
                    $yearwise = $channelwise[$channel . '_yearwise'] ?? [];
                    foreach ($yearwise as $row) {
                        $sum += $row['revenue'] ?? 0;
                    }
                    $ebook_totals[$channel] = $sum;
                }
                $grand_total_ebook = array_sum($ebook_totals);
            ?>

            <div class="mt-5">
                <h6 class="text-center mb-3">E-Book Revenue Summary</h6>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <?php foreach ($ebook_channels as $channel): ?>
                                    <th><?= ucfirst($channel) ?></th>
                                <?php endforeach; ?>
                                <th>Grand Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php foreach ($ebook_totals as $total): ?>
                                    <td><?= number_format($total, 2) ?></td>
                                <?php endforeach; ?>
                                <td><strong><?= number_format($grand_total_ebook, 2) ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Audiobook Revenue Summary Table -->
            <?php
                $audiobook_channels = ['pustaka_aud', 'audible', 'overdrive_aud', 'google_aud', 'storytel_aud', 'youtube_aud', 'kukufm_aud'];
                $audiobook_totals = [];
                foreach ($audiobook_channels as $channel) {
                    $sum = 0;
                    $yearwise = $channelwise[$channel . '_yearwise'] ?? [];
                    foreach ($yearwise as $row) {
                        $sum += $row['revenue'] ?? 0;
                    }
                    $audiobook_totals[$channel] = $sum;
                }
                $grand_total_audiobook = array_sum($audiobook_totals);
            ?>

            <div class="mt-5">
                <h6 class="text-center mb-3">Audiobook Revenue Summary</h6>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <?php foreach ($audiobook_channels as $channel): ?>
                                    <th><?= ucfirst(str_replace('_aud', '', $channel)) ?></th>
                                <?php endforeach; ?>
                                <th>Grand Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php foreach ($audiobook_totals as $total): ?>
                                    <td><?= number_format($total, 2) ?></td>
                                <?php endforeach; ?>
                                <td><strong><?= number_format($grand_total_audiobook, 2) ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Paperback Revenue Summary Table -->
            <?php
                $flipkart = $pustaka['flipkart']['flipkart_order'] ?? 0.0;
                $amazon = $pustaka['amazon']['amazon_order'] ?? 0.0;
                $bookshop = $pustaka['bookshop']['bookshop_order'] ?? 0.0;
                $pustakaOrder = $pustaka['pustaka']['pustaka_order'] ?? 0.0;
                $offline = $pustaka['online']['offline_order'] ?? 0.0;
                $bookfair = $pustaka['bookfair']['book_fair'] ?? 0.0;

                $total = $flipkart + $amazon + $bookshop + $pustakaOrder + $offline + $bookfair;
            ?>

        <div class="mt-5">
            <h6 class="text-center mb-3">Paperback Revenue Summary</h6>
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center">
                    <thead class="table-primary">
                        <tr>
                            <th>Flipkart</th>
                            <th>Amazon</th>
                            <th>Bookshop</th>
                            <th>Pustaka</th>
                            <th>Offline</th>
                            <th>Book Fair</th>
                            <th>Grand Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= number_format($flipkart, 2) ?></td>
                            <td><?= number_format($amazon, 2) ?></td>
                            <td><?= number_format($bookshop, 2) ?></td>
                            <td><?= number_format($pustakaOrder, 2) ?></td>
                            <td><?= number_format($offline, 2) ?></td>
                            <td><?= number_format($bookfair, 2) ?></td>
                            <td><strong><?= number_format($total, 2) ?></strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection(); ?>
