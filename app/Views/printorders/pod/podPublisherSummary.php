<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="row">
    <!-- Sidebar Menu -->
    <div class="col-md-3">
        <div class="list-group sticky-top" id="menuList" role="tablist">
            <button class="list-group-item list-group-item-action active" data-bs-toggle="list" data-bs-target="#summary">Summary</button>
            <button class="list-group-item list-group-item-action" data-bs-toggle="list" data-bs-target="#monthly">Monthly Delivery</button>
            <button class="list-group-item list-group-item-action" data-bs-toggle="list" data-bs-target="#daily">Daily Delivery</button>
            <button class="list-group-item list-group-item-action" data-bs-toggle="list" data-bs-target="#publisher">Publisher Performance</button>
            <button class="list-group-item list-group-item-action" data-bs-toggle="list" data-bs-target="#content">Content Analysis</button>
            <button class="list-group-item list-group-item-action" data-bs-toggle="list" data-bs-target="#future">Upcoming Orders</button>
            <button class="list-group-item list-group-item-action" data-bs-toggle="list" data-bs-target="#account">Account Overview</button>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="col-md-9">
        <div class="tab-content">

            <!-- Summary -->
            <div class="tab-pane fade show active" id="summary">
                <div class="row mb-4">
                    <div class="col-lg-4 mb-3">
                        <div class="card p-3 border shadow-none bg-gradient-start-1 h-100">
                            <h6>Total Orders / Units</h6>
                            <p class="fw-bold"><?= $completed_books['total_order_count'] ?>/<?= $completed_books['total_copies_count'] ?></p>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-3">
                        <div class="card p-3 border shadow-none bg-gradient-start-2 h-100">
                            <h6>Completed Orders / Units</h6>
                            <p class="fw-bold"><?= $completed_books['completed_order_count'] ?>/<?= $completed_books['completed_copies_count'] ?></p>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-3">
                        <div class="card p-3 border shadow-none bg-gradient-start-3 h-100">
                            <h6>Pending Orders / Units</h6>
                            <p class="fw-bold"><?= $completed_books['pending_order_count'] ?>/<?= $completed_books['pending_copies_count'] ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Monthly Delivery -->
            <div class="tab-pane fade" id="monthly">
                <div class="table-responsive">
                    <table class="table zero-config">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Planned Units</th>
                                <th>Actual Units</th>
                                <th>Planned Pages</th>
                                <th>Actual Pages</th>
                                <th>Average Book Size</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($completed_books['monthly_delivery'] as $monthly_data):
                                $avg_book_size = $monthly_data['monthly_planned_delivery_books'] > 0
                                    ? $monthly_data['monthly_planned_delivery_pages'] / $monthly_data['monthly_planned_delivery_books']
                                    : 0;
                            ?>
                            <tr>
                                <td><?= $monthly_data['month_name']; ?></td>
                                <td><?= $monthly_data['monthly_planned_delivery_books']; ?></td>
                                <td><?= $monthly_data['monthly_actual_delivery_books']; ?></td>
                                <td><?= number_format($monthly_data['monthly_planned_delivery_pages'],0); ?></td>
                                <td><?= number_format($monthly_data['monthly_actual_delivery_pages'],0); ?></td>
                                <td><?= number_format($avg_book_size,0); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Daily Delivery -->
            <div class="tab-pane fade" id="daily">
                <div class="table-responsive">
                    <table class="table zero-config">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Units</th>
                                <th>Pages</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($completed_books['daily_delivery'] as $daily_data):
                                $avg_book_size = $daily_data['daily_actual_delivery_books'] > 0
                                    ? $daily_data['daily_actual_delivery_pages'] / $daily_data['daily_actual_delivery_books']
                                    : 0;
                            ?>
                            <tr>
                                <td><?= $daily_data['daily_name']; ?></td>
                                <td><?= $daily_data['daily_actual_delivery_books']; ?></td>
                                <td><?= number_format($daily_data['daily_actual_delivery_pages'],0); ?></td>
                                <td>
                                    <a href="<?= base_url('pod/dailyDetailsPage/' . urlencode($daily_data['daily_name'])) ?>" class="btn btn-outline-primary btn-xs">View</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Publisher Performance -->
            <div class="tab-pane fade" id="publisher">
                <div class="table-responsive">
                    <table class="table zero-config">
                        <thead>
                            <tr>
                                <th>Publisher</th>
                                <th>Total</th>
                                <th>Completed</th>
                                <th>Pending</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($completed_books['pod_publisher_orders'] as $pod_publisher_order): ?>
                            <tr>
                                <td><?= $pod_publisher_order['publisher_name']; ?></td>
                                <td><?= $pod_publisher_order['num_orders_total']; ?>/<?= $pod_publisher_order['num_copies_total']; ?></td>
                                <td><?= ($pod_publisher_order['num_orders_total'] - $pod_publisher_order['num_orders_pending']); ?>/<?= ($pod_publisher_order['num_copies_total'] - $pod_publisher_order['num_copies_pending']); ?></td>
                                <td><?= $pod_publisher_order['num_orders_pending']; ?>/<?= $pod_publisher_order['num_copies_pending']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Content Analysis -->
            <div class="tab-pane fade" id="content">
                <ul class="nav nav-tabs mb-3" id="contentPagesTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="delivered-tab" data-bs-toggle="tab" data-bs-target="#delivered" type="button" role="tab">Delivered</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="inprogress-tab" data-bs-toggle="tab" data-bs-target="#inprogress" type="button" role="tab">In-Progress</button>
                    </li>
                </ul>

                <div class="tab-content" id="contentPagesTabContent">
                    <!-- Delivered -->
                    <div class="tab-pane fade show active" id="delivered" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table zero-config">
                                <thead>
                                    <tr>
                                        <th>Book Size</th>
                                        <th>Paper Type</th>
                                        <th># of Pages</th>
                                        <th># of A3 Sheets</th>
                                        <th># of Paper Bundles</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($completed_books['pod_pages_delivered'] as $data):
                                        $a3_sheets = ceil($data['total_pages']/8);
                                        $bundles = ceil($a3_sheets/500);
                                    ?>
                                    <tr>
                                        <td><?= esc($data['book_size']); ?></td>
                                        <td><?= esc($data['content_paper']); ?></td>
                                        <td><?= number_format($data['total_pages'],0); ?></td>
                                        <td><?= number_format($a3_sheets,0); ?></td>
                                        <td><?= number_format($bundles,0); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- In-Progress -->
                    <div class="tab-pane fade" id="inprogress" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table zero-config">
                                <thead>
                                    <tr>
                                        <th>Book Size</th>
                                        <th>Paper Type</th>
                                        <th># of Pages</th>
                                        <th># of A3 Sheets</th>
                                        <th># of Paper Bundles</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($completed_books['pod_pages_pending'] as $data):
                                        $a3_sheets = ceil($data['total_pages']/8);
                                        $bundles = ceil($a3_sheets/500);
                                    ?>
                                    <tr>
                                        <td><?= esc($data['book_size']); ?></td>
                                        <td><?= esc($data['content_paper']); ?></td>
                                        <td><?= number_format($data['total_pages'],0); ?></td>
                                        <td><?= number_format($a3_sheets,0); ?></td>
                                        <td><?= number_format($bundles,0); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upcoming Orders -->
            <div class="tab-pane fade" id="future">
                <div class="table-responsive">
                    <table class="table zero-config">
                        <thead>
                            <tr>
                                <th>Publisher</th>
                                <th>Book Title</th>
                                <th>Specifications</th>
                                <th>Delivery Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($completed_books['future_orders'] as $future_order):
                                $details = $future_order['total_num_pages'] . "pgs / " . $future_order['num_copies'] . "cps";
                                $details1 = $future_order['book_size'] . " / " . $future_order['content_paper'] . " / " . $future_order['content_gsm'];
                                $date = date_create($future_order['delivery_date']);
                                
                                if ($future_order['start_flag'] == 0) $status = "Not started";
                                elseif ($future_order['files_ready_flag'] == 0) $status = "Files Not Ready";
                                elseif ($future_order['cover_flag'] == 0) $status = "Cover not printed";
                                elseif ($future_order['lamination_flag'] == 0) $status = "Lamination not done";
                                else $status = "Unknown";

                                $status_class = match($status){
                                    "Not started" => "bg-secondary text-white",
                                    "Files Not Ready" => "bg-warning text-dark",
                                    "Cover not printed" => "bg-info text-dark",
                                    "Lamination not done" => "bg-primary text-white",
                                    default => "bg-light text-dark"
                                };
                            ?>
                            <tr>
                                <td><?= $future_order['publisher_name']; ?></td>
                                <td><?= $future_order['book_title']; ?></td>
                                <td>
                                    <div><?= $details; ?></div>
                                    <div class="text-muted small"><?= $details1; ?></div>
                                </td>
                                <td><?= date_format($date, 'd M y'); ?></td>
                                <td><span class="badge <?= $status_class ?>"><?= $status; ?></span></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Account Overview -->
            <div class="tab-pane fade" id="account">
                <div class="card p-3 border shadow-sm">
                    <div class="text-center mb-3">
                        <h6 class="text-muted">Balance</h6>
                        <h4 class="fw-bold">$470</h4>
                    </div>
                    <div class="mb-2 d-flex justify-content-between">
                        <span>Monthly Plan</span>
                        <span class="fw-medium">$199.00</span>
                    </div>
                    <div class="mb-2 d-flex justify-content-between">
                        <span>Taxes</span>
                        <span class="fw-medium">$17.82</span>
                    </div>
                    <div class="mb-2">
                        <span class="text-muted">Extras this month</span>
                        <div class="d-flex justify-content-between"><span>Netflix Yearly Subscription</span><span>$0</span></div>
                        <div class="d-flex justify-content-between"><span>Others</span><span>$-0.68</span></div>
                    </div>
                </div>
            </div>

        </div> <!-- end tab-content -->
    </div> <!-- end col-md-9 -->
</div> <!-- end row -->

<?= $this->endSection(); ?>
