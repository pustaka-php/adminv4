<div class="container" style="margin: 2; padding: 5; margin-top: -670px; margin-left: 100px;">
        <div class="row">
            <div class="col-md-6">
            <h3>User Details</h3>
            </div>
        </div>

    <div class="row mb-4 mt-5">
    <div class="col-sm-9 col-12 order-sm-0 order-1">
        <div class="tab-content" id="v-right-pills-tabContent">

            <!-- DETAILS -->
            <div class="tab-pane fade show active" id="v-right-pills-details" role="tabpanel" aria-labelledby="v-right-pills-details-tab">
                <blockquote class="blockquote">

                    <!-- User Info -->
                    <div style="width: 100%; max-width: 600px; margin: 2rem auto; font-family: 'Segoe UI', sans-serif;">
                        <!-- Profile Card -->
                        <div style="background: linear-gradient(135deg, #f6f9fc, #e9eff5); border-radius: 20px; padding: 2rem; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); margin-bottom: 2rem;">

                            <div style="display: flex; gap: 1.5rem;">
                                <div style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, #667eea, #764ba2); display: flex; align-items: center; justify-content: center; color: white; font-size: 2.5rem; font-weight: bold;">
                                    <?= strtoupper(substr($display['user_name'], 0, 1)); ?>
                                </div>
                                <div>
                                    <h3 style="margin: 0; font-weight: 700; color: #333;"><?= $display['user_name']; ?></h3>
                                    <p style="margin: 0; color: #666; font-size: 0.95rem;">
                                        👤 <?= ($display['user_type'] == 1) ? 'Public User' : (($display['user_type'] == 2) ? 'Author' : 'Unknown'); ?>
                                    </p>
                                </div>
                            </div>

                            <hr style="margin: 1.5rem 0; border-top: 1px solid #ccc;">

                            <div style="font-size: 0.95rem; color: #444; line-height: 1.6;">
                                <p><strong>📧 Email:</strong> <?= $display['user_email']; ?></p>
                                <p><strong>🆔 User ID:</strong> <?= $display['user_id']; ?></p>
                                <p><strong>📅 Joined:</strong> <?= $display['user_join_date']; ?></p>
                                <p><strong>🔐 Login:</strong> <?= $display['channel']; ?></p>
                                <p><strong>📱 Mobile:</strong> <?= $display['phone']; ?></p>
                            </div>
                        </div>

                        <?php
                        $totalNetAmount = 0;
                        $ebookCount = 0;
                        $audiobookCount = 0;
                        $ebookTotalAmount = 0;
                        $audiobookTotalAmount = 0;
                        $totalBooks = 0;
                        $totalQuantity = 0;
                        $totalAmount = 0;
                        $totalPaperbackAmount = 0;

                        $subscriptions = $display['subscriptions'] ?? [];
                        $purchased_paperbacks = $display['purchased_paperbacks'] ?? [];

                        foreach ($subscriptions as $sub) {
                            $totalNetAmount += floatval($sub['net_total']);
                            if ($sub['plan_type'] == 1) {
                                $ebookCount++;
                                $ebookTotalAmount += $sub['net_total'];
                            } elseif ($sub['plan_type'] == 2) {
                                $audiobookCount++;
                                $audiobookTotalAmount += $sub['net_total'];
                            }
                        }

                        foreach ($purchased_paperbacks as $pb) {
                            $bookTotal = $pb['price'] * $pb['quantity'];
                            $totalPaperbackAmount += $bookTotal;
                            $totalBooks++;
                            $totalQuantity += $pb['quantity'];
                            $totalAmount += $bookTotal;
                        }

                        $totalAmount += $totalNetAmount;

                        $devices = 0;
                        if (!empty($display['device_id1'])) $devices++;
                        if (!empty($display['device_id2'])) $devices++;
                        if (!empty($display['device_id3'])) $devices++;
                        ?>

                        <!-- Summary Table -->
                        <div style="background: linear-gradient(120deg, #fdfbfb, #ebedee); border-radius: 16px; padding: 2rem; box-shadow: 0 4px 16px rgba(0,0,0,0.1); margin-bottom: 2rem;">
                            <h4 style="text-align: center; font-weight: 700; color: #495057;">📊 Activity Summary</h4>
                            <table style="width: 100%; border-collapse: collapse; margin-top: 1rem; text-align: center;">
                                <thead style="background: linear-gradient(to right, #4e54c8, #8f94fb); color: white;">
                                    <tr>
                                        <th style="padding: 0.75rem;">Subscriptions</th>
                                        <th>Purchased</th>
                                        <th>Paperback</th>
                                        <th>Free Books</th>
                                        <th>Gifted</th>
                                        <th>Devices</th>
                                    </tr>
                                </thead>
                                <tbody style="background: white; font-weight: bold; color: #333;">
                                    <tr>
                                        <td style="padding: 0.75rem;"><?= count($subscriptions) ?></td>
                                        <td><?= isset($display['purchased_books']) ? count($display['purchased_books']) : 0 ?></td>
                                        <td><?= count($purchased_paperbacks) ?></td>
                                        <td><?= isset($display['free_books']) ? count($display['free_books']) : 0 ?></td>
                                        <td><?= isset($display['author_books']) ? count($display['author_books']) : 0 ?></td>
                                        <td><?= $devices ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Breakdown Cards -->
                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem;">
                        <div style="background: linear-gradient(135deg, #667eea, #764ba2); color: #e0e7ff; padding: 1.5rem; border-radius: 16px; box-shadow: 0 6px 12px rgba(0,0,0,0.1); text-align: center;">
                            <h5 style="color:rgb(247, 247, 248);">📘 <br> Ebook </h5>
                            <p style="color:rgb(250, 251, 253);"><?= $ebookCount ?> plans</p>
                            <strong style="color:rgb(250, 250, 251);">💰 ₹<?= number_format($ebookTotalAmount, 2) ?></strong>
                        </div>
                        <div style="background: linear-gradient(135deg, #f7971e, #ffd200); color: #4a4000; padding: 1.5rem; border-radius: 16px; box-shadow: 0 6px 12px rgba(0,0,0,0.1); text-align: center;">
                            <h5 style="color:rgb(253, 252, 250);">🎧 Audiobooks</h5>
                            <p style="color:rgb(252, 252, 251);"><?= $audiobookCount ?> plans</p>
                            <strong style="color:rgb(252, 252, 250);">💰 ₹<?= number_format($audiobookTotalAmount, 2) ?></strong>
                        </div>
                        <div style="background: linear-gradient(135deg, #11998e, #38ef7d); color: #d0fff7; padding: 1.5rem; border-radius: 16px; box-shadow: 0 6px 12px rgba(0,0,0,0.1); text-align: center;">
                            <h5 style="color:rgb(250, 251, 251);">📚 Paperbacks</h5>
                            <p style="color:rgb(245, 248, 247);"><?= $totalQuantity ?> items</p>
                            <strong style="color:rgb(254, 255, 255);">💰 ₹<?= number_format($totalPaperbackAmount, 2) ?></strong>
                        </div>
                    </div>

                    <!-- Grand Total -->
                        <div style="margin-top: 2rem; text-align: center; background: linear-gradient(to right, #00b09b, #96c93d); color: white; padding: 2rem; font-size: 1.5rem; font-weight: bold; border-radius: 50px; box-shadow: 0 8px 16px rgba(0,0,0,0.2);">
                            🧾 Total Spent: ₹<?= number_format($totalAmount, 2) ?>
                        </div>
                    </div>
                </blockquote>
            </div>

    <div class="tab-pane fade" id="v-right-pills-subscriptions" role="tabpanel" aria-labelledby="v-right-pills-subscriptions-tab">
    <blockquote class="blockquote">
        <?php if (count($display['subscriptions']) == 0): ?>
            <div class="card mx-auto" style="max-width: 300px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); border-radius: 12px;">
                <div>
                    <h5 class="p-3 text-center" style="color: #764ba2;">No Subscriptions</h5>
                </div>
            </div>
        <?php else: ?>
            <div class="widget-content widget-content-area" style="background: #fff; border-radius: 12px; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1); padding: 1rem;">
                <div style="max-height: 400px; overflow-y: auto; border-radius: 12px; box-shadow: inset 0 0 8px rgba(0,0,0,0.1); margin-bottom: 1rem;">
                    <table class="table table-bordered table-hover mb-0" style="width: 100%; font-weight: 600; border-spacing: 0 8px;">
                        <thead style="background: linear-gradient(135deg, #00c9ff, #92fe9d, #a1c4fd); color: #fff; position: sticky; top: 0; z-index: 10;">
                            <tr>
                                <th scope="col" style="padding: 12px;">Order ID</th>
                                <th scope="col" style="padding: 12px;">Start Date</th>
                                <th scope="col" style="padding: 12px;">End Date</th>
                                <th scope="col" style="padding: 12px;">Plan</th>
                                <th scope="col" style="padding: 12px;">Total Books</th>
                                <th scope="col" style="padding: 12px;">Books Taken</th>
                                <th scope="col" style="padding: 12px;">Subscription Amount</th>
                                <th scope="col" style="padding: 12px;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $totalNetAmount = 0;
                                $ebookCount = 0;
                                $audiobookCount = 0;
                                $ebookTotalAmount = 0;
                                $audiobookTotalAmount = 0;

                                foreach ($display['subscriptions'] as $subscription):
                                    $totalNetAmount += $subscription['net_total'];

                                    if ($subscription['plan_type'] == 1) {
                                        $planTypeLabel = "Ebook";
                                        $ebookCount++;
                                        $ebookTotalAmount += $subscription['net_total'];
                                    } elseif ($subscription['plan_type'] == 2) {
                                        $planTypeLabel = "Audiobook";
                                        $audiobookCount++;
                                        $audiobookTotalAmount += $subscription['net_total'];
                                    } else {
                                        $planTypeLabel = "Unknown";
                                    }

                                    $endSubscribedDate = new DateTime($subscription['end_subscribed']);
                                    $currentDate = new DateTime();
                                    $status = ($endSubscribedDate >= $currentDate) ? "Active" : "Inactive";
                            ?>
                                <tr style="background: #f5f7ff; box-shadow: 0 2px 5px rgba(102, 126, 234, 0.2); border-radius: 12px;">
                                    <th scope="row" style="padding: 12px;"><?= $subscription['order_id'] ?></th>
                                    <td style="padding: 12px;"><?= $subscription['date_subscribed'] ?></td>
                                    <td style="padding: 12px;"><?= $subscription['end_subscribed'] ?></td>
                                    <td style="padding: 12px;"><?= $subscription['plan_name'] . ' (' . $planTypeLabel . ')' ?></td>
                                    <td style="padding: 12px;"><?= $subscription['total_books'] ?></td>
                                    <td style="padding: 12px;"><?= count($subscription['books']) ?></td>
                                    <td style="padding: 12px;">₹<?= number_format($subscription['net_total'], 2) ?></td>
                                    <td style="padding: 12px;">
                                        <?php if ($status === "Active"): ?>
                                            <span style="background-color: #38ef7d; color: #fff; font-weight: 700; padding: 5px 10px; border-radius: 20px; display: inline-block; box-shadow: 0 2px 8px rgba(56, 239, 125, 0.4);"><?= $status ?></span>
                                        <?php else: ?>
                                            <span style="background-color: #f44336; color: #fff; font-weight: 700; padding: 5px 10px; border-radius: 20px; display: inline-block; box-shadow: 0 2px 8px rgba(244, 67, 54, 0.4);"><?= $status ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Totals Summary -->
                <div style="background: linear-gradient(135deg, #a1ffce, #faffd1, #c1dfc4); color: #333333; border-radius: 12px; padding: 1rem 1.5rem; box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4); font-weight: 700; font-size: 1.1rem;">
                    <div class="row text-center">
                        <div class="col-md-4 mb-2" style="border-right: 1px solid rgba(255, 255, 255, 0.3);">
                            📘 <strong>Ebook <br>Subscriptions:</strong> <?= $ebookCount ?><br>
                            💰 <strong>Total:</strong> ₹<?= number_format($ebookTotalAmount, 2) ?>
                        </div>
                        <div class="col-md-4 mb-2" style="border-right: 1px solid rgba(255, 255, 255, 0.3);">
                            🎧 <strong>Audiobook Subscriptions:</strong> <?= $audiobookCount ?><br>
                            💰 <strong>Total:</strong> ₹<?= number_format($audiobookTotalAmount, 2) ?>
                        </div>
                        <div class="col-md-4 mb-2">
                            🧾 <strong>Overall Total:</strong><br>
                           <h5 style="margin-top: 0.5rem;">₹<?= number_format($totalNetAmount, 2) ?></h5>
                        </div>
                    </div>
                </div>
        <?php endif; ?>
        <br><br>



      <h5><strong>Subscription Book Details</strong></h5>
    <div id="toggleAccordion" style="height: 400px; overflow-y: auto;">
        <?php foreach ($display['subscriptions'] as $i => $subscription): ?>
            <div class="card">
                <div class="card-header" id="heading<?= $i ?>">
                    <h5 class="mb-0">
                        <button class="btn btn-link d-flex justify-content-between align-items-center w-100" data-toggle="collapse" data-target="#collapse<?= $i ?>" aria-expanded="false" aria-controls="collapse<?= $i ?>">
                            <div>
                                <strong>Order ID:</strong> <?= $subscription['order_id'] ?> |
                                <strong>Plan:</strong> <?= $subscription['plan_name'] ?>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                    </h5>
                </div>

                <div id="collapse<?= $i ?>" class="collapse" aria-labelledby="heading<?= $i ?>" data-parent="#toggleAccordion">
                    <div class="card-body">
                        <?php if (count($subscription['books']) == 0): ?>
                            <p class="text-muted text-center">No books taken in this subscription.</p>
                        <?php else: ?>
                            <!-- Show the first 3 books initially -->
                            <table class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Book ID</th>
                                        <th>Book Name</th>
                                        <th>Author</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody style="font-weight: 600;">
                                    <?php foreach (array_slice($subscription['books'], 0, 3) as $book): ?>
                                        <tr>
                                            <td><?= $book['book_id'] ?></td>
                                            <td><?= $book['book_name'] ?></td>
                                            <td><?= $book['author_name'] ?></td>
                                            <td><?= $book['order_date'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                            <?php if (count($subscription['books']) > 3): ?>
                                <!-- Show More Button -->
                                <button class="btn btn-link" data-toggle="collapse" data-target="#fullBooks<?= $i ?>" aria-expanded="false" aria-controls="fullBooks<?= $i ?>" id="toggleButton<?= $i; ?>">
                                    Show More
                                </button>

                                <div id="fullBooks<?= $i ?>" class="collapse">
                                    <table class="table table-bordered table-hover">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Book ID</th>
                                                <th>Book Name</th>
                                                <th>Author</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-weight: 600;">
                                            <?php foreach (array_slice($subscription['books'], 3) as $book): ?>
                                                <tr>
                                                    <td><?= $book['book_id'] ?></td>
                                                    <td><?= $book['book_name'] ?></td>
                                                    <td><?= $book['author_name'] ?></td>
                                                    <td><?= $book['order_date'] ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Show Less Button -->
                                <button class="btn btn-link" data-toggle="collapse" data-target="#fullBooks<?= $i ?>" aria-expanded="false" aria-controls="fullBooks<?= $i ?>" id="toggleButton<? $i; ?>">
                                    Show Less
                                </button>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
     </div>
        </blockquote>
    </div>

<!-- PURCHASED BOOKS -->
    <div class="tab-pane fade" id="v-right-pills-purchased-books" role="tabpanel" aria-labelledby="v-right-pills-purchased-books-tab">
        <blockquote class="blockquote">
            <?php if (count($display['purchased_books']) == 0): ?>
                <div class="card mx-auto">
                    <div>
                        <h5 class="p-2 text-center"> No Purchased Books </h5>
                    </div>
                </div>
            <?php else: ?>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Sl no.</th>
                            <th scope="col">Book Name</th>
                            <th scope="col">Date</th>
                        </tr>
                    </thead>
                    <tbody style="font-weight: 800;">
                        <?php foreach ($display['purchased_books'] as $index => $purchased_book): ?>
                            <tr>
                                <th scope="row"><?= $index + 1 ?></th>
                                <td><?= $purchased_book['purchased_book_title'] ?></td>
                                <td><?= $purchased_book['date_purchased'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </blockquote>
    </div>


                <!-- PURCHASED PAPERBACK -->
    <div class="tab-pane fade" id="v-right-pills-purchased-paperback" role="tabpanel" aria-labelledby="v-right-pills-purchased-paperback-tab">
    <blockquote class="blockquote">
        <?php if (count($display['purchased_paperbacks']) == 0): ?>
            <div class="card mx-auto border-danger" style="background-color: #fff5f5;">
                <div class="card-body">
                    <h5 class="p-2 text-center text-danger">No Purchased Paperback</h5>
                </div>
            </div>
        <?php else: ?>
            <div class="table-responsive" style="max-height: 400px; overflow-x: auto; overflow-y: auto;">
    <table class="table table-bordered table-hover table-sm mb-0" style="min-width: 1200px; background-color: #ffffff;">
                    <thead style="position: sticky; top: 0; z-index: 2; background: linear-gradient(135deg, #f6d365, #fda085, #fbc2eb); color: #ffffff; height: 60px;">
                        <tr style="height: 60px; vertical-align: middle;">
                            <th scope="col" style="text-align:center;">Sl No.</th>
                            <th scope="col" style="text-align:center;">Order Date</th>
                            <th scope="col" style="text-align:center;">Order ID</th>
                            <th scope="col" style="text-align:center;">Book Name</th>
                            <th scope="col" style="text-align:center;">Book Price (₹)</th>
                            <th scope="col" style="text-align:center;">Quantity</th>
                            <th scope="col" style="text-align:center;">Tracking ID</th>
                            <th scope="col" style="text-align:center;">Tracking URL</th>
                        </tr>
                    </thead>
                    <tbody style="font-weight: 600;">
                        <?php 
                            $totalBooks = 0;
                            $totalQuantity = 0;
                            $totalAmount = 0;

                            foreach ($display['purchased_paperbacks'] as $index => $purchased_paperback):
                                $totalBooks++;
                                $totalQuantity += $purchased_paperback['quantity'];
                                $totalAmount += $purchased_paperback['price'] * $purchased_paperback['quantity'];
                        ?>
                            <tr style="background-color: <?= $index % 2 == 0 ? '#f8faff' : '#eef6ff' ?>;">
                                <th scope="row"><?= $index + 1 ?></th>
                                <td><?= $purchased_paperback['purchased_date'] ?></td>
                                <td><?= $purchased_paperback['order_id'] ?></td>
                                <td><?= $purchased_paperback['purchased_paperback_title'] ?></td>
                                <td>₹<?= number_format($purchased_paperback['price'], 2) ?></td>
                                <td><?= $purchased_paperback['quantity'] ?></td>
                                <td><?= $purchased_paperback['tracking_id'] ?></td>
                                <td>
                                    <?php if (!empty($purchased_paperback['tracking_url'])): ?>
                                        <a href="<?= $purchased_paperback['tracking_url'] ?>" target="_blank" class="text-primary">Track</a>
                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Totals Table -->
            <table class="table table-bordered mt-2 w-100">
                <tfoot style="background: linear-gradient(135deg, #f093fb, #f5576c, #ff6a00); color: #333; font-size: 1.1em; font-weight: bold;">
                    <tr class="text-center">
                        <td colspan="3" class="text-right" style="color:rgb(7, 7, 7);">Total Books:</td>
                        <td style="color:rgb(6, 6, 6);"><?= $totalBooks ?></td>

                        <td class="text-right" style="color:rgb(10, 10, 10);">Total Quantity:</td>
                        <td style="color:rgb(4, 4, 4);"><?= $totalQuantity ?></td>

                        <td class="text-right" colspan="1" style="color:rgb(4, 4, 4);">Total Amount:</td>
                        <td style="color:rgb(5, 5, 5);">₹<?= number_format($totalAmount, 2) ?></td>
                    </tr>
                </tfoot>
            </table>
        <?php endif; ?>
    </blockquote>
</div>


<!-- FREE BOOKS -->
<div class="tab-pane fade" id="v-right-pills-free-books" role="tabpanel" aria-labelledby="v-right-pills-free-books-tab">
    <blockquote class="blockquote">
        <?php if (count($display['free_books']) == 0): ?>
            <div class="card mx-auto" style="background-color: #f9f9f9;">
                <div>
                    <h5 class="p-2 text-center text-secondary">No Free Books</h5>
                </div>
            </div>
        <?php else: ?>
            <table class="table" style="background-color: #ffffff;">
                <thead style="background: linear-gradient(135deg, #89f7fe, #66a6ff); color: white;">
                    <tr>
                        <th scope="col">Sl no.</th>
                        <th scope="col">Book Name</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody style="font-weight: 800;">
                    <?php foreach ($display['free_books'] as $i => $free_book): ?>
                        <tr style="background-color: <?= $i % 2 == 0 ? '#e3f2fd' : '#f0f4c3' ?>;">
                            <th scope="row"><?= $i + 1 ?></th>
                            <td><?= $free_book['free_book_title'] ?></td>
                            <td><?= $free_book['date'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </blockquote>
</div>


                <!-- AUTHOR GIFT BOOKS -->
    <div class="tab-pane fade" id="v-right-pills-author-gift-books" role="tabpanel" aria-labelledby="v-right-pills-author-gift-books-tab">
    <blockquote class="blockquote" style="background: linear-gradient(135deg, #f5f7fa, #c3cfe2); border-radius: 12px; padding: 1.25rem 1rem; box-shadow: 0 8px 20px rgba(0,0,0,0.1);">
        <?php if (count($display['author_books']) == 0): ?>
            <div class="mx-auto" style="max-width: 400px; background: #ffe6e6; border-radius: 10px; padding: 1rem;">
                <h5 class="p-2 text-center" style="color: #d9534f; font-weight: 700;">No Gifted Books</h5>
            </div>
        <?php else: ?>
            <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                <table class="table" style="min-width: 700px; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1); background: white;">
                    <thead style="background: linear-gradient(135deg, #1e3c72, #2a5298); color: white; font-size: 1.2rem; text-transform: uppercase;">
                        <tr>
                            <th scope="col" style="padding: 14px 20px; border-right: 1px solid rgba(255,255,255,0.3);">Sl no.</th>
                            <th scope="col" style="padding: 14px 20px; border-right: 1px solid rgba(255,255,255,0.3);">Author Name</th>
                            <th scope="col" style="padding: 14px 20px; border-right: 1px solid rgba(255,255,255,0.3);">Book Name</th>
                            <th scope="col" style="padding: 14px 20px;">Date</th>
                        </tr>
                    </thead>
                    <tbody style="font-weight: 600; font-size: 1rem; color: #444;">
                        <?php foreach ($display['author_books'] as $i => $author_book): ?>
                            <tr style="background-color: <?= $i % 2 === 0 ? '#f0f4ff' : '#e3e9ff' ?>; transition: background-color 0.3s ease;">
                                <th scope="row" style="padding: 12px 20px; border-right: 1px solid #d1d9ff; border-radius: 0;"><?= $i + 1 ?></th>
                                <td style="padding: 12px 20px; color: #5a4fcf; border-right: 1px solid #d1d9ff;"><?= htmlspecialchars($author_book['author_name']) ?></td>
                                <td style="padding: 12px 20px; color: #3b3b98; border-right: 1px solid #d1d9ff;"><?= htmlspecialchars($author_book['book_title']) ?></td>
                                <td style="padding: 12px 20px; color: #7a7aab;"><?= htmlspecialchars($author_book['gift_date']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </blockquote>
</div>




                <!-- DEVICES -->
    <div class="tab-pane fade" id="v-right-pills-devices" role="tabpanel" aria-labelledby="v-right-pills-devices-tab">
  <blockquote class="blockquote" style="background: #f9fafb; padding: 1.5rem; border-radius: 12px; box-shadow: 0 6px 18px rgba(0,0,0,0.07);">

    <div class="row mx-3 mb-3 fw-bold text-white" style="font-size: 1rem;">
      <div class="col-1 text-center">
        <div class="p-2 rounded-circle" style="background: linear-gradient(135deg, #667eea, #764ba2); width: 40px; height: 40px; line-height: 36px;">
          SN
        </div>
      </div>
      <div class="col-4">
        <div class="p-2 rounded" style="background: linear-gradient(135deg, #43cea2, #185a9d);">
          <i class="bi bi-hash"></i> Device ID
        </div>
      </div>
      <div class="col-7">
        <div class="p-2 rounded" style="background: linear-gradient(135deg, #f7971e, #ffd200); color: #2e2e2e;">
          <i class="bi bi-phone"></i> Device Name
        </div>
      </div>
    </div>

    <?php
    $devices = [
        ['id' => $display['device_id1'] ?? '', 'info' => $display['device_info1'] ?? ''],
        ['id' => $display['device_id2'] ?? '', 'info' => $display['device_info2'] ?? ''],
        ['id' => $display['device_id3'] ?? '', 'info' => $display['device_info3'] ?? '']
    ];
    foreach ($devices as $index => $device):
      $bg = $index % 2 === 0 ? '#f0f4ff' : '#e6f7ff';
    ?>
      <div class="row mx-3 mb-2 fw-semibold" style="font-size: 1rem;">
        <div class="col-1 text-center">
          <div class="p-2 rounded-circle shadow-sm" style="background: <?= $bg ?>; width: 40px; height: 40px; line-height: 36px; color: #333;">
            <?= $index + 1 ?>
          </div>
        </div>
        <div class="col-4">
          <div class="p-2 rounded shadow-sm" style="background: <?= $bg ?>; color: #005662;">
            <?= htmlspecialchars($device['id']) ?>
          </div>
        </div>
        <div class="col-7">
          <div class="p-2 rounded shadow-sm" style="background: <?= $bg ?>; color: #7f4f24; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
            <?= htmlspecialchars($device['info']) ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>

    <div class="row mx-3 mt-4">
      <a href="#" onclick="clear_user_devices(<?= $display['user_id'] ?>)" class="btn btn-danger rounded-pill px-4 py-2 shadow">
        Clear
      </a>
    </div>
  </blockquote>
</div>


    <div class="tab-pane fade" id="v-right-pills-addplan" role="tabpanel" aria-labelledby="v-right-pills-addplan-tab">
  <blockquote class="blockquote p-4 rounded shadow-sm" style="background: linear-gradient(135deg, #89f7fe 0%, #66a6ff 100%);">
    <h4 class="text-center text-white mb-4" style="font-weight: 700; letter-spacing: 1px;">Add Plan</h4>
    <div class="row g-3 justify-content-center align-items-center">
      <div class="col-10 col-md-8">
        <select id="add_plan" class="form-select form-select-lg shadow-sm" style="border-radius: 50px; padding: 0.5rem 1rem; font-weight: 600;">
          <?php foreach ($plans as $plan): ?>
            <option value="<?= $plan['plan_id'] ?>"><?= htmlspecialchars($plan['plan_name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-10 col-md-2">
        <button 
          type="button" 
          class="btn btn-gradient w-100 fw-bold shadow"
          onclick="add_plan(<?= $display['user_id'] ?>)"
          style="border-radius: 50px; background: linear-gradient(135deg, #ff416c, #ff4b2b); border: none; color: white; font-size: 1.1rem; padding: 0.55rem 0;">
          Add Plan
        </button>
      </div>
    </div>
  </blockquote>
</div>



                <!-- Wallet Details -->
   <div class="tab-pane fade" id="v-right-pills-wallet" role="tabpanel" aria-labelledby="v-right-pills-wallet-tab">
  <blockquote class="blockquote p-4 rounded" style="background: linear-gradient(135deg, #f0f4f8, #d9e2ec); box-shadow: 0 6px 15px rgba(0,0,0,0.1);">
    <?php if (empty($display['wallet_detail'])): ?>
      <div class="card mx-auto my-5" style="max-width: 400px; background: #ffe6e6; border-radius: 12px; box-shadow: 0 4px 12px rgba(217, 83, 79, 0.3);">
        <div class="card-body text-center">
          <h5 class="text-danger fw-bold m-0">No Wallet Amount</h5>
        </div>
      </div>
    <?php else: ?>
      <div class="row g-4 justify-content-center mb-5">
        <div class="col-12 col-md-5">
          <div class="card text-white" style="border-radius: 16px; background: linear-gradient(135deg, #f6d365, #fda085); box-shadow: 0 8px 20px rgba(253, 160, 133, 0.5);">
            <div class="card-header text-center fs-5 fw-semibold" style="background: transparent; border-bottom: none;">INR</div>
            <div class="card-body text-center">
              <h3 class="card-title fw-bold">₹ <?= number_format($display['wallet_detail'][0]['balance_inr'], 2) ?></h3>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-5">
          <div class="card text-white" style="border-radius: 16px; background: linear-gradient(135deg, #43cea2, #185a9d); box-shadow: 0 8px 20px rgba(24, 90, 157, 0.5);">
            <div class="card-header text-center fs-5 fw-semibold" style="background: transparent; border-bottom: none;">USD</div>
            <div class="card-body text-center">
              <h3 class="card-title fw-bold">$ <?= number_format($display['wallet_detail'][0]['balance_usd'], 2) ?></h3>
            </div>
          </div>
        </div>
      </div>

      <div class="table-responsive shadow-sm rounded" style="background: white;">
        <table class="table table-hover align-middle mb-0">
          <thead style="background: linear-gradient(135deg, #667eea, #764ba2); color: white;">
            <tr>
              <th scope="col" class="text-center">Sl no.</th>
              <th scope="col" class="text-center">Currency</th>
              <th scope="col" class="text-center">Amount</th>
              <th scope="col" class="text-center">Transaction Type</th>
              <th scope="col" class="text-center">Date</th>
            </tr>
          </thead>
          <tbody style="font-weight: 600; color: #444;">
            <?php foreach ($display['transaction_detail'] as $index => $wallet): ?>
              <tr style="<?= $index % 2 === 0 ? 'background-color: #f9faff;' : '' ?>">
                <th scope="row" class="text-center"><?= $index + 1 ?></th>
                <td class="text-center text-primary"><?= htmlspecialchars($wallet['currency']) ?></td>
                <td class="text-center text-success"> 
                  <?= htmlspecialchars($wallet['currency']) === 'INR' ? '₹' : '$' ?><?= number_format($wallet['amount'], 2) ?>
                </td>
                <td class="text-center text-info"><?= htmlspecialchars($wallet['transaction_value']) ?></td>
                <td class="text-center text-muted"><?= htmlspecialchars($wallet['date']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </blockquote>
</div>
    </div>
</div>

    <div class="col-sm-3 col-12">
  <div class="nav flex-column nav-pills mb-sm-0 mb-3" id="v-right-pills-tab" role="tablist" aria-orientation="vertical" style="font-weight: 700; gap: 0.6rem;">
    <a class="nav-link mb-2 active" id="v-right-pills-details-tab" data-toggle="pill" href="#v-right-pills-details" role="tab" aria-controls="v-right-pills-details" aria-selected="true"
       style="border-radius: 30px; padding: 12px 20px; background: #9c88ff; color: white; box-shadow: 0 4px 14px rgba(156, 136, 255, 0.7); transition: all 0.3s ease;">
      Details
    </a>
    <a class="nav-link mb-2" id="v-right-pills-subscriptions-tab" data-toggle="pill" href="#v-right-pills-subscriptions" role="tab" aria-controls="v-right-pills-subscriptions" aria-selected="false"
       style="border-radius: 30px; padding: 12px 20px; background: #f5f5fa; color: #6c63ff; transition: background 0.3s ease, color 0.3s ease;">
      Subscriptions
    </a>
    <a class="nav-link mb-2" id="v-right-pills-purchased-books-tab" data-toggle="pill" href="#v-right-pills-purchased-books" role="tab" aria-controls="v-right-pills-purchased-books" aria-selected="false"
       style="border-radius: 30px; padding: 12px 20px; background: #f5f5fa; color: #6c63ff; transition: background 0.3s ease, color 0.3s ease;">
      Purchased Books
    </a>
    <a class="nav-link mb-2" id="v-right-pills-purchased-paperback-tab" data-toggle="pill" href="#v-right-pills-purchased-paperback" role="tab" aria-controls="v-right-pills-purchased-paperback" aria-selected="false"
       style="border-radius: 30px; padding: 12px 20px; background: #f5f5fa; color: #6c63ff; transition: background 0.3s ease, color 0.3s ease;">
      Purchased Paperback
    </a>
    <a class="nav-link mb-2" id="v-right-pills-free-books-tab" data-toggle="pill" href="#v-right-pills-free-books" role="tab" aria-controls="v-right-pills-free-books" aria-selected="false"
       style="border-radius: 30px; padding: 12px 20px; background: #f5f5fa; color: #6c63ff; transition: background 0.3s ease, color 0.3s ease;">
      Free Books
    </a>
    <a class="nav-link mb-2" id="v-right-pills-author-gift-books-tab" data-toggle="pill" href="#v-right-pills-author-gift-books" role="tab" aria-controls="v-right-pills-author-gift-books" aria-selected="false"
       style="border-radius: 30px; padding: 12px 20px; background: #f5f5fa; color: #6c63ff; transition: background 0.3s ease, color 0.3s ease;">
      Author Gift Books
    </a>
    <a class="nav-link" id="v-right-pills-devices-tab" data-toggle="pill" href="#v-right-pills-devices" role="tab" aria-controls="v-right-pills-devices" aria-selected="false"
       style="border-radius: 30px; padding: 12px 20px; background: #f5f5fa; color: #6c63ff; transition: background 0.3s ease, color 0.3s ease;">
      Devices
    </a>
    <a class="nav-link" id="v-right-pills-addplan-tab" data-toggle="pill" href="#v-right-pills-addplan" role="tab" aria-controls="v-right-pills-addplan" aria-selected="false"
       style="border-radius: 30px; padding: 12px 20px; background: #f5f5fa; color: #6c63ff; transition: background 0.3s ease, color 0.3s ease;">
      Add Plan
    </a>
    <a class="nav-link" id="v-right-pills-wallet-tab" data-toggle="pill" href="#v-right-pills-wallet" role="tab" aria-controls="v-right-pills-wallet" aria-selected="false"
       style="border-radius: 30px; padding: 12px 20px; background: #f5f5fa; color: #6c63ff; transition: background 0.3s ease, color 0.3s ease;">
      Wallet
    </a>
  </div>
</div>

<style>
  .nav-link:hover:not(.active) {
    background: #9c88ff !important;
    color: white !important;
    box-shadow: 0 4px 15px rgba(156, 136, 255, 0.8);
  }
  .nav-link.active {
    box-shadow: 0 6px 22px rgba(156, 136, 255, 0.9);
  }
</style>

    </div>
  </div>
</div>
<script>
    var base_url = "<?php echo base_url() ?>";
    function clear_user_devices(user_id) {
        $.ajax({
            url: base_url + "user/clear_user_devices",
            type: "POST",
            data: {
                "user_id": user_id
            },
            success: function(data) {
                if (data == 1) {
                    location.reload();
                }
                else {
                    alert("Error occured, please try again");
                }
            }
        })
    }

    function add_plan(user_id) {
        var plan_id = document.getElementById("add_plan").value;
        $.ajax({
            url: base_url + "user/add_plan_for_user",
            type: "POST",
            data: {
                "user_id": user_id,
                "plan_id": plan_id
            },
            success: function(data) {
                if (data == 1) {
                    alert("Successfully added plan");
                }
                else {
                    alert("Error occured, try again");
                }
            }
        })
    }
</script>
