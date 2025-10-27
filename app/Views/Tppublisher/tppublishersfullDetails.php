<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <?php if (!empty($selected_publisher_id)): ?>
             <div class="mb-3">
       <a href="<?= route_to('tppublisher') ?>" class="btn btn-secondary btn-sm">
    &larr; Back to Dashboard
</a>
    </div>
            <!-- 🔹 Sidebar Tabs -->
            <ul class="nav nav-tabs mb-4">
                <?php
                $sections = [
                    'profile'       => 'Profile',
                    'authors'       => 'Authors',
                    'books'         => 'Books',
                    'stock_ledger'  => 'Stock Ledger',
                    'orders'        => 'Orders',
                    'sales'         => 'Sales',
                    'payments'      => 'Payments'
                ];
                foreach ($sections as $key => $label): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= ($section == $key) ? 'active' : '' ?>"
                            href="<?= base_url('tppublisher/tppublishersdetails/' . $selected_publisher_id . '/' . $key) ?>">
                            <?= $label ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>

            <!-- 🔹 Content Section -->
            <div class="card p-4 radius-12 shadow-sm">

                <?php if ($section == 'profile'): ?>
                    <h6 class="mb-3">Publisher Profile</h6>
                    <?php if (!empty($publisher_info)): ?>
                        <table>
                            <tr><th>Publisher Name</th><td><?= esc($publisher_info['publisher_name']); ?></td></tr>
                            <tr><th>Email</th><td><?= esc($publisher_info['email_id']); ?></td></tr>
                            <tr><th>Phone</th><td><?= esc($publisher_info['mobile']); ?></td></tr>
                            <tr><th>Address</th><td><?= esc($publisher_info['address']); ?></td></tr>
                            <tr><th>Status</th>
                                <td><?= ($publisher_info['status']==1)?'<span class="badge bg-success">Active</span>':'<span class="badge bg-danger">Inactive</span>'; ?></td></tr>
                        </table>
                    <?php else: ?>
                        <p>No profile information found.</p>
                    <?php endif; ?>


                <?php elseif ($section == 'authors'): ?>
                    <h6 class="mb-3">Authors Details</h6>
                    <?php if (!empty($authors)): ?>
                        <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Author Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($authors as $i => $a): ?>
                                    <tr>
                                        <td><?= $i+1; ?></td>
                                        <td><?= esc($a['author_name']); ?></td>
                                        <td><?= esc($a['email_id']); ?></td>
                                        <td><?= ($a['status']==1)?'Active':'Inactive'; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No authors found.</p>
                    <?php endif; ?>


                <?php elseif ($section == 'books'): ?>
                    <h6 class="mb-3">Books Details</h6>
                    <?php if (!empty($books)): ?>
                       <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>ISBN</th>
                                    <th>MRP</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($books as $i => $b): ?>
                                    <tr>
                                        <td><?= $i+1; ?></td>
                                        <td><?= esc($b['book_title']); ?></td>
                                        <td><?= esc($b['isbn']); ?></td>
                                        <td>₹<?= number_format($b['mrp'],2); ?></td>
                                        <td><?= ($b['status']==1)?'Active':'Inactive'; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No books found.</p>
                    <?php endif; ?>


                <!-- Stock Ledger -->
        <?php elseif ($section == 'stock_ledger'): ?>
            <h6>Stock Ledger - <?= esc($publisher_info['publisher_name']); ?></h6>
            <?php if(!empty($stock_books)): ?>
            <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Book ID</th>
                        <th>SKU No</th>
                        <th>Book Title</th>
                        <th>Stock In Hand</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i=1; foreach($stock_books as $row): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= esc($row['book_id']) ?></td>
                        <td><?= esc($row['sku_no']) ?></td>
                        <td><?= esc($row['book_title']) ?></td>
                        <td><?= esc($row['stock_in_hand']) ?></td>
                        <td>
                            <a href="<?= base_url('tppublisher/tpstockledgerview/'.$row['book_id']) ?>" class="btn btn-primary btn-sm">View</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
                <p>No books found for this publisher.</p>
            <?php endif; ?>


             <?php elseif ($section == 'orders'): ?>
<div class="row g-4">

    <!-- 🔹 Orders Overview Card -->
    <div class="col-md-6 mx-auto">
        <div class="card p-3 shadow-2 radius-8 h-100 bg-gradient-end-2">
            <div class="d-flex align-items-center gap-3 mb-2">
                <span class="w-48 h-48 bg-info-100 rounded-circle d-flex justify-content-center align-items-center">
                    <iconify-icon icon="mdi:shopping-outline" width="26" height="26" style="color:#007bff;"></iconify-icon>
                </span>
                <div>
                    <h6 class="fw-bold mb-1"><?= number_format($orderStats['total_orders'] ?? 0); ?></h6>
                    <small>Total Orders</small>
                </div>
            </div>
            <div class="d-flex flex-wrap gap-3 fw-medium mt-2">
                <span>Shipped: <b><?= $orderStats['shipped_orders'] ?? 0 ?></b></span>
                <span>Pending: <b><?= $orderStats['pending_orders'] ?? 0 ?></b></span>
                <span>Cancelled: <b><?= $orderStats['cancelled_orders'] ?? 0 ?></b></span>
                <span>Returned: <b><?= $orderStats['returned_orders'] ?? 0 ?></b></span>
            </div>
        </div>
    </div>

    <?php 
    $statusColors = [
        'in_progress' => ['label' => 'In Progress Orders', 'color' => 'primary', 'bg' => 'bg-primary-50'],
        'shipped'     => ['label' => 'Shipped Orders', 'color' => 'success', 'bg' => 'bg-success-50'],
        'returned'    => ['label' => 'Returned Orders', 'color' => 'warning', 'bg' => 'bg-warning-50'],
        'cancelled'   => ['label' => 'Cancelled Orders', 'color' => 'danger', 'bg' => 'bg-danger-50'],
    ];
    ?>

    <?php foreach ($statusColors as $status => $info): ?>
        <div class="col-md-12">
            <div class="card p-3 shadow-sm radius-8">
                <div class="d-flex align-items-center mb-3">
                    <span class="badge rounded-pill  px-3 py-2 bg-<?= $info['color'] ?>">
                        <?= $info['label'] ?>
                    </span>
                </div>

                <?php if (!empty($groupedOrders[$status])): ?>
                    <div class="table-responsive">
                        <table class="table table-hover text-center mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Author</th>
                                    <th>Qty</th>
                                    <th>Titles</th>
                                    <th><?= $status == 'in_progress' || $status == 'shipped' ? 'Ship Date' : ($status == 'returned' ? 'Return Date' : 'Cancel Date') ?></th>
                                    <th><?= $status == 'returned' || $status == 'cancelled' ? ($status == 'returned' ? 'Reason' : 'Cancel Reason') : 'Address' ?></th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($groupedOrders[$status] as $i => $o): ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><?= esc($o['order_id']) ?></td>
                                        <td><?= !empty($o['order_date']) ? date('d-M-Y', strtotime($o['order_date'])) : '-' ?></td>
                                        <td><?= esc($o['author_name']) ?></td>
                                        <td><?= esc($o['total_qty'] ?? 0) ?></td>
                                        <td><?= esc($o['total_books'] ?? '-') ?></td>
                                        <td>
                                            <?= !empty($o['ship_date']) ? date('d-M-Y', strtotime($o['ship_date'])) : 
                                               (!empty($o['return_date']) ? date('d-M-Y', strtotime($o['return_date'])) : 
                                               (!empty($o['cancel_date']) ? date('d-M-Y', strtotime($o['cancel_date'])) : '-')) ?>
                                        </td>
                                        <td><?= esc($o['address'] ?? $o['return_reason'] ?? $o['cancel_reason'] ?? '-') ?></td>
                                        <td>
                                            <a href="<?= base_url('tppublisher/tporderfulldetails/' . $o['order_id']) ?>" 
                                               class="btn btn-sm btn-outline-<?= $info['color'] ?> rounded-pill px-3">View</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-center text-muted mb-0">No <?= strtolower($info['label']) ?> found.</p>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>

</div>


               <?php elseif ($section == 'sales'): ?>
<div class="col-md-12 mb-4">
    <!-- Total Sales Card -->
    <div class="card shadow-lg radius-12 p-4 bg-gradient-purple  h-100">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
            <div class="d-flex align-items-center gap-3">
                <span class="w-50 h-50 bg-info-100 rounded-circle d-flex justify-content-center align-items-center">
                    <iconify-icon icon="mdi:book-open-page-variant" width="26" height="26" style="color:#007bff;"></iconify-icon>
                </span>
                <div>
    <h6 class="fw-bold mb-1 text-info"><?= number_format($salesStats['total_sales'] ?? 0); ?></h6>
    <small class="text-black">Total Sales</small>
</div>

            </div>

            <div class="d-flex flex-wrap gap-2">
                <span class="badge bg-info">Pustaka: <?= $salesStats['qty_pustaka'] ?? 0 ?></span>
                <span class="badge bg-primary">Amazon: <?= $salesStats['qty_amazon'] ?? 0 ?></span>
                <span class="badge bg-success">Book Fair: <?= $salesStats['qty_bookfair'] ?? 0 ?></span>
                <span class="badge bg-warning text-dark">Others: <?= $salesStats['qty_other'] ?? 0 ?></span>
            </div>
        </div>
    </div>
</div>

<!-- Sales Summary Table -->
<div class="col-md-12">
    <div class="card shadow-sm radius-12 p-3">
        <h6 class="text-primary mb-3">Sales Summary</h6>
        <?php if (!empty($salespay)): ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Sales Channel</th>
                        <th>Units</th>
                        <th>Total (₹)</th>
                        <th>Discount (₹)</th>
                        <th>To Pay (₹)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalQty = $totalAmount = $totalDiscount = $totalAuthor = 0;
                    foreach ($salespay as $i => $row):
                        $totalQty += (float)($row['total_qty'] ?? 0);
                        $totalAmount += (float)($row['total_amount'] ?? 0);
                        $totalDiscount += (float)($row['total_discount'] ?? 0);
                        $totalAuthor += (float)($row['total_author_amount'] ?? 0);
                    ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td>
                            <span class="badge 
                                <?= $row['sales_channel'] === 'Pustaka' ? 'bg-info' : '' ?>
                                <?= $row['sales_channel'] === 'Amazon' ? 'bg-primary' : '' ?>
                                <?= $row['sales_channel'] === 'Book Fair' ? 'bg-success' : '' ?>
                                <?= $row['sales_channel'] === 'Others' ? 'bg-warning text-dark' : '' ?>
                            ">
                                <?= esc($row['sales_channel']) ?>
                            </span>
                        </td>
                        <td><?= number_format($row['total_qty'], 0) ?></td>
                        <td>₹<?= number_format($row['total_amount'], 2) ?></td>
                        <td>₹<?= number_format($row['total_discount'], 2) ?></td>
                        <td>₹<?= number_format($row['total_author_amount'], 2) ?></td>
                        <td>
                            <a href="<?= site_url('tppublisher/tpsalesfull/' . rawurlencode($row['create_date']) . '/' . rawurlencode($row['sales_channel'])) ?>"
                               class="btn btn-sm btn-info radius-8 px-3 py-1">View</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <tr class="fw-bold bg-light">
                        <td colspan="2" class="text-end">Total</td>
                        <td><?= $totalQty ?></td>
                        <td>₹<?= number_format($totalAmount, 2) ?></td>
                        <td>₹<?= number_format($totalDiscount, 2) ?></td>
                        <td>₹<?= number_format($totalAuthor, 2) ?></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php else: ?>
            <p class="text-muted">No sales found for this publisher.</p>
        <?php endif; ?>
    </div>



        <?php elseif ($section == 'payments'): ?>
    <div class="row">

    <!-- 🔹 Order Payments Card -->
    <div class="col-md-6 mb-4">
        <div class="card p-3 shadow-sm radius-8 h-100 bg-gradient-end-3 ">
            <div class="d-flex align-items-center gap-3 mb-2">
                <span class="w-48 h-48 bg-info-100 rounded-circle d-flex justify-content-center align-items-center">
                    <iconify-icon icon="mdi:currency-inr" width="24" height="24" style="color:blue;"></iconify-icon>
                </span>
                <div>
                    <h5 class="fw-bold mb-1">₹<?= number_format($orderStats['total_net'] ?? 0, 2); ?></h5>
                    <small>Total Amount</small>
                </div>
            </div>
            <div class="d-flex flex-wrap gap-3 text-sm mt-2">
                <span>Handling Charges: ₹<?= number_format($orderStats['total_royalty'] ?? 0, 2); ?></span>
                <span>|</span>
                <span>Courier: ₹<?= number_format($orderStats['total_courier'] ?? 0, 2); ?></span>
                <span>|</span>
                <span>Paid: ₹<?= number_format($orderStats['total_order_value'] ?? 0, 2); ?></span>
            </div>
        </div>
    </div>

    <!-- 🔹 Sales Payments Card -->
    <div class="col-md-6 mb-4">
        <div class="card p-3 shadow-sm radius-8 h-100 bg-gradient-end-4 ">
            <div class="d-flex align-items-center gap-3 mb-2">
                <span class="w-48 h-48 bg-info-100 rounded-circle d-flex justify-content-center align-items-center">
                    <iconify-icon icon="mdi:currency-inr" width="24" height="24" style="color:blue;"></iconify-icon>
                </span>
                <div>
                    <h5 class="fw-bold mb-1">₹<?= number_format($salesSummary['total_amount'] ?? 0, 2); ?></h5>
                    <small>Total Sales Amount</small>
                </div>
            </div>
            <div class="d-flex flex-wrap gap-3 text-sm mt-2">
                <span>To Pay: ₹<?= number_format($salesSummary['total_author_amount'] ?? 0, 2); ?></span>
                <span>|</span>
                <span>Discount: ₹<?= number_format($salesSummary['total_discount'] ?? 0, 2); ?></span>
            </div>
            <div class="d-flex flex-wrap gap-3 text-sm mt-1">
                <span>Paid: ₹<?= number_format($salesSummary['paid_author_amount'] ?? 0, 2); ?></span>
                <span>|</span>
                <span>Pending: ₹<?= number_format($salesSummary['pending_author_amount'] ?? 0, 2); ?></span>
            </div>
        </div>
    </div><br><br>


    <!-- 🔹 Orders Payments -->
    <?php if (!empty($payments)): ?>
        <!-- Pending Orders -->
        <div class="col-12 mb-4">
            <h6 class="text-warning">Orders - Pending</h6>
            <div class="table-responsive">
                <table class="table table-hover table-sm text-center zero-config">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Order ID</th>
                            <th>Publisher</th>
                            <th>Order Date</th>
                            <th>Ship Date</th>
                            <th>Sub Total</th>
                            <th>Courier Charges</th>
                            <th>Royalty</th>
                            <th>To Receive</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $pendingFound = false; ?>
                        <?php foreach ($payments as $i => $p): 
                            $paymentStatus = strtolower(trim((string)($p['payment_status'] ?? '')));
                            if (!in_array($paymentStatus, ['paid', '1'], true)):
                                $pendingFound = true;
                                $sub_total = (float)($p['sub_total'] ?? 0);
                                $royalty   = (float)($p['royalty'] ?? 0);
                                $courier   = (float)($p['courier_charges'] ?? 0);
                                $total     = $royalty + $courier;
                        ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= esc($p['order_id']) ?></td>
                                <td><?= esc($p['publisher_name'] ?? '-') ?></td>
                                <td><?= !empty($p['order_date']) ? date('d-m-Y', strtotime($p['order_date'])) : '-' ?></td>
                                <td><?= !empty($p['ship_date']) ? date('d-m-Y', strtotime($p['ship_date'])) : '-' ?></td>
                                <td>₹<?= number_format($sub_total, 2) ?></td>
                                <td>₹<?= number_format($courier, 2) ?></td>
                                <td>₹<?= number_format($royalty, 2) ?></td>
                                <td>₹<?= number_format($total, 2) ?></td>
                                <td>
                                    <a href="<?= site_url('tppublisher/tporderfulldetails/' . $p['order_id']) ?>" class="btn btn-info btn-sm rounded-pill px-3 py-1">Details</a>
                                </td>
                            </tr>
                        <?php endif; endforeach; ?>
                        <?php if (!$pendingFound): ?>
                            <tr><td colspan="10" class="text-center text-muted">No pending payments found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paid Orders -->
        <div class="col-12 mb-4">
            <h6 class="text-success">Orders - Paid</h6>
            <div class="table-responsive">
                <table class="table table-hover table-sm text-center zero-config">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Order ID</th>
                            <th>Publisher</th>
                            <th>Order Date</th>
                            <th>Ship Date</th>
                            <th>Sub Total</th>
                            <th>Courier Charges</th>
                            <th>Royalty</th>
                            <th>To Receive</th>
                            <th>Payment Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $paidFound = false; ?>
                        <?php foreach ($payments as $i => $p): 
                            $paymentStatus = strtolower(trim((string)($p['payment_status'] ?? '')));
                            if (in_array($paymentStatus, ['paid', '1'], true)):
                                $paidFound = true;
                                $sub_total = (float)($p['sub_total'] ?? 0);
                                $royalty   = (float)($p['royalty'] ?? 0);
                                $courier   = (float)($p['courier_charges'] ?? 0);
                                $total     = $royalty + $courier;
                        ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= esc($p['order_id']) ?></td>
                                <td><?= esc($p['publisher_name'] ?? '-') ?></td>
                                <td><?= !empty($p['order_date']) ? date('d-m-Y', strtotime($p['order_date'])) : '-' ?></td>
                                <td><?= !empty($p['ship_date']) ? date('d-m-Y', strtotime($p['ship_date'])) : '-' ?></td>
                                <td>₹<?= number_format($sub_total, 2) ?></td>
                                <td>₹<?= number_format($courier, 2) ?></td>
                                <td>₹<?= number_format($royalty, 2) ?></td>
                                <td>₹<?= number_format($total, 2) ?></td>
                                <td><?= !empty($p['payment_date']) ? date('d-m-Y', strtotime($p['payment_date'])) : '-' ?></td>
                                <td>
                                    <a href="<?= site_url('tppublisher/tporderfulldetails/' . $p['order_id']) ?>" class="btn btn-info btn-sm rounded-pill px-3 py-1">Details</a>
                                </td>
                            </tr>
                        <?php endif; endforeach; ?>
                        <?php if (!$paidFound): ?>
                            <tr><td colspan="11" class="text-center text-muted">No paid payments found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    <?php else: ?>
        <div class="col-12"><p class="text-center text-muted">No payment records found.</p></div>
    <?php endif; ?>

    <!-- 🔹 Sales Payments -->
    <?php if (!empty($paymentpay)): ?>
        <div class="col-12 mb-4">
            <h6 class="text-warning">Sales - Pending</h6>
            <div class="table-responsive">
                <table class="table table-hover table-sm text-center zero-config">
                    <thead class="table-light">
                        <tr>
                            <th>Create Date</th>
                            <th>Sales Channel</th>
                            <th>Qty</th>
                            <th>Total Value</th>
                            <th>Discount</th>
                            <th>To Pay</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $hasUnpaid = false; ?>
                        <?php foreach ($paymentpay as $row): ?>
                            <?php if (($row['paid_status'] ?? '') === 'pending'): ?>
                                <?php $hasUnpaid = true; ?>
                                <tr>
                                    <td><?= esc($row['create_date']) ?></td>
                                    <td><?= esc($row['sales_channel']) ?></td>
                                    <td><?= number_format($row['total_qty'], 0) ?></td>
                                    <td>₹<?= number_format($row['total_amount'], 2); ?></td>
                                    <td>₹<?= number_format($row['total_discount'], 2); ?></td>
                                    <td>₹<?= number_format($row['total_author_amount'], 2); ?></td>
                                    <td><span class="badge bg-warning text-dark">Pending</span></td>
                                    <td>
                                        <a class="btn btn-info btn-sm rounded-pill px-3 py-1" href="<?= site_url('tppublisher/tpsalesfull/' . rawurlencode($row['create_date']) . '/' . rawurlencode($row['sales_channel'])) ?>">Details</a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <?php if (!$hasUnpaid): ?>
                            <tr><td colspan="8" class="text-center text-muted">No unpaid sales found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-12 mb-4">
            <h6 class="text-success">Sales - Paid</h6>
            <div class="table-responsive">
                <table class="table table-hover table-sm text-center zero-config">
                    <thead class="table-light">
                        <tr>
                            <th>Create Date</th>
                            <th>Sales Channel</th>
                            <th>Qty</th>
                            <th>Total Amount</th>
                            <th>Discount</th>
                            <th>To Pay</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $hasPaid = false; ?>
                        <?php foreach ($paymentpay as $row): ?>
                            <?php if (($row['paid_status'] ?? '') === 'paid'): ?>
                                <?php $hasPaid = true; ?>
                                <tr>
                                    <td><?= esc($row['create_date']) ?></td>
                                    <td><?= esc($row['sales_channel']) ?></td>
                                    <td><?= number_format($row['total_qty'], 0) ?></td>
                                    <td>₹<?= number_format($row['total_amount'], 2); ?></td>
                                    <td>₹<?= number_format($row['total_discount'], 2); ?></td>
                                    <td>₹<?= number_format($row['total_author_amount'], 2); ?></td>
                                    <td><span class="badge bg-success">Paid</span></td>
                                    <td>
                                        <a class="btn btn-info btn-sm rounded-pill px-3 py-1" href="<?= site_url('tppublisher/tpsalesfull/' . rawurlencode($row['create_date']) . '/' . rawurlencode($row['sales_channel'])) ?>">Details</a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <?php if (!$hasPaid): ?>
                            <tr><td colspan="8" class="text-center text-muted">No paid sales found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>

</div>
<?php endif; ?>

</div>
<?php endif; ?>

<?= $this->endSection(); ?>
