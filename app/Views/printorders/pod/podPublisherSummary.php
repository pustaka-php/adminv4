<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>
<div class="layout-px-spacing">
    <!-- Summary Cards -->
    <div class="row mb-4">
        <!-- Total Orders / Units -->
        <div class="row mb-4">
    <!-- Total Orders / Units -->
    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
        <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-1">
            <div class="card-body p-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                    <div class="d-flex align-items-center">
                        <div class="w-64-px h-64-px radius-16 bg-base-50 d-flex justify-content-center align-items-center me-20">
                            <span class="mb-0 w-40-px h-40-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center radius-8 h6 mb-0">
                                <i class="feather feather-shopping-bag"></i>
                            </span>
                        </div>
                        <div>
                            <span class="mb-2 fw-medium text-secondary-light text-md">Total Orders / Units</span>
                            <h6 class="fw-semibold my-1"><?= $completed_books['total_order_count'] ?>/<?= $completed_books['total_copies_count'] ?></h6>
                            <p class="text-sm mb-0">Overall planned orders till date</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Completed Orders / Units -->
    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
        <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-3">
            <div class="card-body p-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                    <div class="d-flex align-items-center">
                        <div class="w-64-px h-64-px radius-16 bg-base-50 d-flex justify-content-center align-items-center me-20">
                            <span class="mb-0 w-40-px h-40-px bg-success-main flex-shrink-0 text-white d-flex justify-content-center align-items-center radius-8 h6 mb-0">
                                <i class="feather feather-check-circle"></i>
                            </span>
                        </div>
                        <div>
                            <span class="mb-2 fw-medium text-secondary-light text-md">Completed Orders / Units</span>
                            <h6 class="fw-semibold my-1"><?= $completed_books['completed_order_count'] ?>/<?= $completed_books['completed_copies_count'] ?></h6>
                            <p class="text-sm mb-0">
                                <span class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm">
                                    +<?= $completed_books['completed_order_percentage'] ?>%
                                </span> completion rate
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Orders / Units -->
    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
        <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-2">
            <div class="card-body p-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                    <div class="d-flex align-items-center">
                        <div class="w-64-px h-64-px radius-16 bg-base-50 d-flex justify-content-center align-items-center me-20">
                            <span class="mb-0 w-40-px h-40-px bg-warning-main flex-shrink-0 text-white d-flex justify-content-center align-items-center radius-8 h6 mb-0">
                                <i class="feather feather-clock"></i>
                            </span>
                        </div>
                        <div>
                            <span class="mb-2 fw-medium text-secondary-light text-md">Pending Orders / Units</span>
                            <h6 class="fw-semibold my-1"><?= $completed_books['pending_order_count'] ?>/<?= $completed_books['pending_copies_count'] ?></h6>
                            <p class="text-sm mb-0">
                                <span class="bg-warning-focus px-1 rounded-2 fw-medium text-warning-main text-sm">
                                    <?= number_format($completed_books['pending_order_percentage'], 2) ?>%
                                </span> pending rate
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    </div>

    <!-- Delivery Performance -->
    <div class="row mb-4">
        <!-- Monthly Delivery -->
        <div class="col-xl-8 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-semibold">Monthly Delivery Performance</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-4 zero-config text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0">Month</th>
                                    <th class="border-0 text-center">Planned</th>
                                    <th class="border-0 text-center">Actual</th>
                                    <th class="border-0 text-center">Variance</th>
                                    <th class="border-0 text-center">Pages</th>
                                    <th class="border-0 text-center">Avg Size</th>
                                    <th class="border-0 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($completed_books['monthly_delivery'] as $monthly_data): 
                                    $avg_book_size = $monthly_data['monthly_planned_delivery_books'] > 0 
                                        ? $monthly_data['monthly_planned_delivery_pages'] / $monthly_data['monthly_planned_delivery_books'] 
                                        : 0;
                                    $variance = $monthly_data['monthly_actual_delivery_books'] - $monthly_data['monthly_planned_delivery_books'];
                                ?>
                                <tr>
                                    <td class="fw-semibold"><?= $monthly_data['month_name']; ?></td>
                                    <td class="text-center"><?= $monthly_data['monthly_planned_delivery_books']; ?></td>
                                    <td class="text-center">
                                        <span class="<?= $variance >= 0 ? 'text-success' : 'text-danger' ?> fw-semibold">
                                            <?= $monthly_data['monthly_actual_delivery_books']; ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge <?= $variance >= 0 ? 'bg-success' : 'bg-danger' ?>">
                                            <?= $variance >= 0 ? '+' : '' ?><?= $variance ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <small class="text-muted"><?= number_format($monthly_data['monthly_actual_delivery_pages'],0); ?></small>
                                    </td>
                                    <td class="text-center"><?= number_format($avg_book_size,0); ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('pod/monthDetailsPage/' . urlencode($monthly_data['month_name'])) ?>" class="btn btn-outline-primary btn-sm">
                                            View
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daily Delivery & Account Info -->
        <div class="col-xl-4 mb-4">
            <div class="row h-100">
                <!-- Daily Delivery -->
                <div class="col-12 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-transparent border-0 py-3">
                            <h6 class="mb-0 fw-semibold">Daily Delivery (Current Month)</h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-4 zero-config text-center align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="border-0 ps-3">Date</th>
                                            <th class="border-0 text-center">Units</th>
                                            <th class="border-0 text-center">Pages</th>
                                            <th class="border-0 text-center pe-3">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($completed_books['daily_delivery'] as $daily_data):
                                            $avg_book_size = $daily_data['daily_actual_delivery_books'] > 0
                                                ? $daily_data['daily_actual_delivery_pages'] / $daily_data['daily_actual_delivery_books']
                                                : 0;
                                        ?>
                                        <tr>
                                            <td class="ps-3 fw-medium"><?= $daily_data['daily_name']; ?></td>
                                            <td class="text-center">
                                                <span class="fw-semibold"><?= $daily_data['daily_actual_delivery_books']; ?></span>
                                            </td>
                                            <td class="text-center">
                                                <small class="text-muted"><?= number_format($daily_data['daily_actual_delivery_pages'],0); ?></small>
                                            </td>
                                            <td class="pe-3 text-center">
                                                <a href="<?= base_url('pod/dailyDetailsPage/' . urlencode($daily_data['daily_name'])) ?>" class="btn btn-outline-primary btn-xs">
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account Info -->
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-transparent border-0 py-3">
                            <h6 class="mb-0 fw-semibold">Account Overview</h6>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <span class="text-success fw-bold">$470.00</span>
                                <p class="text-muted small mb-0">Current Balance</p>
                            </div>
                            <div class="border-top pt-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Monthly Plan</span>
                                    <span class="fw-medium">$199.00</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Taxes</span>
                                    <span class="fw-medium">$17.82</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted">Extras</span>
                                    <span class="text-danger fw-medium">-$0.68</span>
                                </div>
                                <div class="d-grid gap-2">
                                    <a href="#" class="btn btn-outline-dark btn-sm">Summary</a>
                                    <a href="#" class="btn btn-danger btn-sm">Transfer Funds</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Publisher & Content Analysis -->
    <div class="row mb-4">
        <!-- Publisher-wise Orders -->
        <div class="col-xl-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-semibold">Publisher Performance</h6>
                        <span class="badge bg-primary"><?= count($completed_books['pod_publisher_orders']) ?> Publishers</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-4 zero-config text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0">Publisher</th>
                                    <th class="border-0 text-center">Total</th>
                                    <th class="border-0 text-center">Completed</th>
                                    <th class="border-0 text-center">Pending</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($completed_books['pod_publisher_orders'] as $pod_publisher_order): ?>
                                <tr>
                                    <td class="fw-medium"><?= $pod_publisher_order['publisher_name']; ?></td>
                                    <td class="text-center">
                                        <?= $pod_publisher_order['num_orders_total']; ?>/<?= $pod_publisher_order['num_copies_total']; ?>
                                    </td>
                                    <td class="text-center">
                                        <?= ($pod_publisher_order['num_orders_total'] - $pod_publisher_order['num_orders_pending']); ?>/
                                        <?= ($pod_publisher_order['num_copies_total'] - $pod_publisher_order['num_copies_pending']); ?>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge <?= $pod_publisher_order['num_orders_pending'] > 0 ? 'bg-warning' : 'bg-success' ?>">
                                            <?= $pod_publisher_order['num_orders_pending']; ?>/<?= $pod_publisher_order['num_copies_pending']; ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Pages Status -->
        <div class="col-xl-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-semibold">Content Pages Analysis</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="delivered-pages">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-4 zero-config text-center align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="border-0">Book Size</th>
                                            <th class="border-0">Paper Type</th>
                                            <th class="border-0 text-center">Pages</th>
                                            <th class="border-0 text-center">A3 Sheets</th>
                                            <th class="border-0 text-center">Bundles</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($completed_books['pod_pages_delivered'] as $pod_pages_data): 
                                            $a3_papers = ceil($pod_pages_data['total_pages']/8);
                                            $num_bundles = ceil($a3_papers/500);
                                        ?>
                                        <tr>
                                            <td class="fw-medium"><?= $pod_pages_data['book_size']; ?></td>
                                            <td><?= $pod_pages_data['content_paper']; ?></td>
                                            <td class="text-center fw-semibold"><?= number_format($pod_pages_data['total_pages'],0); ?></td>
                                            <td class="text-center"><?= number_format($a3_papers,0); ?></td>
                                            <td class="text-center"><?= number_format($num_bundles,0); ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="inprogress-pages">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="border-0">Book Size</th>
                                            <th class="border-0">Paper Type</th>
                                            <th class="border-0 text-center">Pages</th>
                                            <th class="border-0 text-center">A3 Sheets</th>
                                            <th class="border-0 text-center">Bundles</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($completed_books['pod_pages_pending'] as $pod_pages_data): 
                                            $a3_papers = ceil($pod_pages_data['total_pages']/8);
                                            $num_bundles = ceil($a3_papers/500);
                                        ?>
                                        <tr>
                                            <td class="fw-medium"><?= $pod_pages_data['book_size']; ?></td>
                                            <td><?= $pod_pages_data['content_paper']; ?></td>
                                            <td class="text-center fw-semibold"><?= number_format($pod_pages_data['total_pages'],0); ?></td>
                                            <td class="text-center"><?= number_format($a3_papers,0); ?></td>
                                            <td class="text-center"><?= number_format($num_bundles,0); ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Orders -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-semibold">Upcoming Orders & Status</h6>
                        <span class="badge bg-primary"><?= count($completed_books['future_orders']) ?> Orders</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-4 zero-config text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0">Publisher</th>
                                    <th class="border-0">Book Title</th>
                                    <th class="border-0">Specifications</th>
                                    <th class="border-0 text-center">Delivery Date</th>
                                    <th class="border-0 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($completed_books['future_orders'] as $future_order): 
                                    $details = $future_order['total_num_pages'] . "pgs / " . $future_order['num_copies'] . "cps";
                                    $details1 = $future_order['book_size'] . " / " . $future_order['content_paper'] . " / " . $future_order['content_gsm'];
                                    $date = date_create($future_order['delivery_date']);
                                    
                                    if ($future_order['start_flag'] == 0)
                                        $status = "Not started";
                                    elseif ($future_order['files_ready_flag'] == 0)
                                        $status = "Files Not Ready";
                                    elseif ($future_order['cover_flag'] == 0)
                                        $status = "Cover not printed";
                                    elseif ($future_order['lamination_flag'] == 0)
                                        $status = "Lamination not done";
                                    else
                                        $status = "Unknown";
                                        
                                    $status_class = "bg-light text-dark";
                                    if ($status == "Not started") $status_class = "bg-secondary text-white";
                                    if ($status == "Files Not Ready") $status_class = "bg-warning text-dark";
                                    if ($status == "Cover not printed") $status_class = "bg-info text-dark";
                                    if ($status == "Lamination not done") $status_class = "bg-primary text-white";
                                ?>
                                <tr>
                                    <td class="fw-medium"><?= $future_order['publisher_name']; ?></td>
                                    <td>
                                        <div class="fw-semibold"><?= $future_order['book_title']; ?></div>
                                    </td>
                                    <td>
                                        <div class="fw-medium text-primary"><?= $details; ?></div>
                                        <div class="text-muted small"><?= $details1; ?></div>
                                    </td>
                                    <td class="text-center fw-semibold"><?= date_format($date, 'd M y'); ?></td>
                                    <td class="text-center">
                                        <span class="badge <?= $status_class ?>"><?= $status; ?></span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection(); ?>