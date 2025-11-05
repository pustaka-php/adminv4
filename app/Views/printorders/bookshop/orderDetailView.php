<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row" style="margin: 0 auto;">
            <!-- Card 1: Bookshop Details -->
            <div class="col-xxl-6 col-sm-12 mb-3">
                <div class="card h-100 radius-12 bg-gradient-purple">
                    <div class="card-body p-24">
                        <h6 class="text-center">Bookshop Details</h6><br>
                        <?php if (!empty($orderbooks['details'])): ?>
                            <h6>Bookshop: <?= esc($orderbooks['details']['bookshop_name']) ?> </h6>
                            <h6>Contact Person: <?= esc($orderbooks['details']['contact_person_name']) ?> </h6>
                            <h6>Mobile No: <?= esc($orderbooks['details']['mobile']) ?> </h6>
                            <h6>Transport Details: <?= esc($orderbooks['details']['preferred_transport']) . " - " . esc($orderbooks['details']['preferred_transport_name']) ?> </h6>
                            <h6>Address: <br> <?= esc($orderbooks['details']['ship_address']) ?> </h6>
                        <?php else: ?>
                            <h6 style="color:red;">⚠ No bookshop details found for this order.</h6>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <!-- Card 2: Order & Shipping Details -->
            <div class="col-xxl-6 col-sm-12 mb-3">
                <div class="card h-100 radius-12 bg-gradient-success">
                    <div class="card-body p-24">
                        <h6 class="text-center mb-16">Order & Shipping Details</h6><br>

                        <?php if (!empty($orderbooks['details'])): ?>
                            <h6>Buyer's Order No: <?= esc($orderbooks['details']['vendor_po_order_number']) ?> </h6>
                            <h6>Transport Payment: <?= esc($orderbooks['details']['transport_payment']) ?> </h6>
                            <h6>Order Date:
                                <?php
                                    if (!empty($orderbooks['details']['order_date'])) {
                                        echo date('d-m-Y', strtotime($orderbooks['details']['order_date']));
                                    }
                                ?>
                            </h6>
                            <h6>Ship Date:
                                <?php
                                    if (!empty($orderbooks['details']['ship_date'])) {
                                        echo date('d-m-Y', strtotime($orderbooks['details']['ship_date']));
                                    }
                                ?>
                            </h6>
                            <?php if (!empty($orderbooks['details']['tracking_url'])): ?>
                                <h6>
                                    <a href="<?= esc($orderbooks['details']['tracking_url']) ?>" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" 
                                            stroke-linecap="round" stroke-linejoin="round" 
                                            class="feather feather-truck">
                                            <rect x="1" y="3" width="15" height="13"></rect>
                                            <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                            <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                            <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                        </svg>  
                                        <?= esc($orderbooks['details']['tracking_id']) ?>
                                    </a>
                                </h6>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <br><br>
        <table class="table table-bordered mb-4">
            <thead>
                <h6 class="text-center">List of Books</h6>
                <tr>
                    <th>S.No</th> 
                    <th>BookId</th>  
                    <th>Title</th>
                    <th>PaperBack ISBN</th>
                    <th>Author</th>
                    <th>Quantity</th>
                    <th>Stock In Hand</th>
                    <th>Qty Details</th>
                    <th>Book Price</th>
                    <th>Discount %</th>
                    <th>Final amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody style="font-weight: normal;">
                <?php if (!empty($orderbooks['list'])): ?>
                    <?php
                        $totalValue = 0;
                        $i = 1;
                        foreach ($orderbooks['list'] as $books_details):
                            $totalValue += $books_details['total_amount'];
                            $formatted_isbn = str_replace('-', '', $books_details['paper_back_isbn']);
                    ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= esc($books_details['book_id']) ?></td>
                            <td>
                                <?= esc($books_details['book_title']) ?><br>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" 
                                    stroke-linecap="round" stroke-linejoin="round" 
                                    class="feather feather-copy" 
                                    onclick="copyToClipboard(this, '<?= addslashes($books_details['book_title']) ?>')">
                                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                </svg>
                            </td>
                            <td>
                                <?= esc($formatted_isbn) ?><br>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" 
                                    stroke-linecap="round" stroke-linejoin="round" 
                                    class="feather feather-copy" style="color:#000;" 
                                    onclick="copyToClipboard(this, '<?= $formatted_isbn ?>')">
                                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                </svg>
                            </td>
                            <td><?= esc($books_details['author_name']) ?></td>
                            <td><?= esc($books_details['quantity']) ?></td>
                            <td class="table-success"><?= esc($books_details['stock_in_hand']) ?></td>
                            <td class="table-warning">
                                Ledger: <?= esc($books_details['qty']) ?><br>
                                Fair / Store: <?= ($books_details['bookfair']+$books_details['bookfair2']+$books_details['bookfair3']+$books_details['bookfair4']+$books_details['bookfair5']) ?><br>
                                <?php if ($books_details['lost_qty'] < 0): ?>
                                    <span style="color:green;">Excess: <?= abs($books_details['lost_qty']) ?></span>
                                <?php elseif ($books_details['lost_qty'] > 0): ?>
                                    <span style="color:red;">Lost: <?= $books_details['lost_qty'] ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?= esc($books_details['book_price']) ?></td>
                            <td><?= esc($books_details['discount']) ?></td>
                            <td><?= esc($books_details['total_amount']) ?></td>
                            <td>
                                <?php 
                                    if ($books_details['ship_status'] == 0) echo "In Progress";
                                    elseif ($books_details['ship_status'] == 1) echo "Shipped";
                                    elseif ($books_details['ship_status'] == 2) echo "Cancelled";
                                    elseif ($books_details['ship_status'] == 3) echo "Return";
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="10" style="text-align:right; font-weight:bold; color:blue;">Total amount</td>
                        <td style="font-weight:bold; color:blue;"><?= number_format($totalValue, 2) ?></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="12" class="text-center text-danger">⚠ No books found for this order.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function copyToClipboard(icon, text) {
        navigator.clipboard.writeText(text);
        icon.style.color = "blue";
        setTimeout(function() {
            icon.style.color = "#000";
        }, 1000);
    }
</script>

<?= $this->endSection(); ?>
