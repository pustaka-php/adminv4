<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h6 class="text-center">POD Author Order - Quantity, Billing, Shipping</h6><br>
            </div>
        </div>

        <div class="form-container outer">
            <div class="form-form">
                <div class="form-form-wrap">
                    <div class="form-container">
                        <div class="form-content">

                            <form class="text-left" action="<?= base_url('paperback/authororderbookssubmit') ?>" method="POST">
                                <div class="form">

                                    <div class="col-xxl-4 col-sm-5" style="margin-left: 400px;">
                                        <div class="card h-100 radius-12 bg-gradient-purple">
                                            <div class="card-body p-24">
                                                <div class="text-start">
                                                    <p><strong>Author ID:</strong> <?= $author_id; ?></p>
                                                    <p><strong>Number of books:</strong> <?= count($pod_selected_books_data); ?></p>
                                                    <p><strong>Selected Books:</strong> <?= $pod_selected_book_id; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Hidden field to pass total number of books -->
                                    <input type="hidden" name="num_of_books" value="<?= count($pod_selected_books_data); ?>">
                                    <input type="hidden" name="author_id" value="<?= $author_id; ?>">

                                    <table class="mt-4 table table-hover zero-config">
                                        <thead>
                                            <tr>
                                                <th>S.no</th>
                                                <th>Book ID</th>
                                                <th>Title</th>
                                                <th>Regional Title</th>
                                                <th>Author</th>
                                                <th>Cost</th>
                                                <th>Paper Back Pages</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-center">Discount</th>
                                                <th>Final Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $j = 1;
                                            $cnt = count($pod_selected_books_data);
                                            for ($i = 0; $i < $cnt; $i++): ?>
                                                <tr>
                                                    <td><?= $j++; ?></td>
                                                    <td>
                                                        <input type="text" class="form-control" 
                                                            value="<?= $pod_selected_books_data[$i]['book_id'] ?>" 
                                                            name="bk_id<?= $i; ?>" readonly style="color: black;">
                                                    </td>
                                                    <td>
                                                        <a href="<?= config('App')->pustaka_url . '/home/ebook/' . $pod_selected_books_data[$i]['language_name'] . '/' . $pod_selected_books_data[$i]['url_name'] ?>">
                                                            <?= $pod_selected_books_data[$i]['book_title'] ?>
                                                        </a>
                                                    </td>
                                                    <td><?= $pod_selected_books_data[$i]['regional_book_title'] ?></td>
                                                    <td><?= $pod_selected_books_data[$i]['author_name'] ?></td>
                                                    <td>
                                                        <input type="text" class="form-control" 
                                                            value="<?= $pod_selected_books_data[$i]['paper_back_inr'] ?>" 
                                                            name="bk_inr<?= $i; ?>" id="bk_inr<?= $i; ?>" readonly 
                                                            onInput="calculateTotalAmount(<?= $cnt; ?>)">
                                                    </td>
                                                    <td><?= $pod_selected_books_data[$i]['paper_back_pages'] ?></td>
                                                    <td class="text-center">
                                                        <input type="text" class="form-control" placeholder="0" 
                                                            id="bk_qty<?= $i; ?>" name="bk_qty<?= $i; ?>" 
                                                            onInput="calculateTotalAmount(<?= $cnt; ?>)" required>
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="text" class="form-control" placeholder="0" 
                                                            id="bk_discount<?= $i; ?>" name="bk_discount<?= $i; ?>" 
                                                            value="50" onInput="calculateTotalAmount(<?= $cnt; ?>)">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" placeholder="0" 
                                                            id="tot_amt<?= $i; ?>" name="tot_amt<?= $i; ?>" readonly>
                                                    </td>
                                                </tr>
                                            <?php endfor; ?>
                                        </tbody>
                                    </table>

                                    <div class="row mt-4">
                                        <div class="col-7"></div>
                                        <div class="col-2 text-end">
                                            <h6>Total amount:</h6>
                                        </div>
                                        <div class="col-3">
                                            <input type="text" id="sub_total" name="sub_total" class="form-control" readonly style="color: black;">
                                        </div>
                                    </div>

                                    <br><br>

                                    <div class="row">
                                        <div class="col-6">
                                            <label for="ship_date">Shipping Date</label>
                                            <input type="date" id="ship_date" name="ship_date" class="form-control" required>
                                        </div>
                                        <div class="col-3">
                                            <label>Payment Status</label>
                                            <div class="form-check">
                                                <input type="radio" id="pending" name="payment_status" class="form-check-input" value="Pending" checked required>
                                                <label class="form-check-label" for="pending">Pending</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" id="paid" name="payment_status" class="form-check-input" value="Paid" required>
                                                <label class="form-check-label" for="paid">Paid</label>
                                            </div>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="row">
                                        <!-- Billing Address -->
                                        <div class="col-6">
                                            <h6 class="mt-3">Billing Address</h6>
                                            <br>
                                            <label class="mt-3">User ID</label>
                                            <input type="text" class="form-control" name="user_id" id="user_id" value="<?= $pod_author_addr_details[0]['copyright_owner'] ?>"/>

                                            <label class="mt-3">Name</label>
                                            <input type="text" class="form-control" name="bill_name" id="bill_name" value="<?= $pod_author_addr_details[0]['author_name'] ?>"/>

                                            <label class="mt-3">Address</label>
                                            <textarea class="form-control" name="bill_addr" id="bill_addr" rows="4"><?= $pod_author_addr_details[0]['address'] ?></textarea>

                                            <label class="mt-3">Mobile</label>
                                            <input class="form-control" name="bill_mobile" id="bill_mobile" value="<?= $pod_author_addr_details[0]['mobile'] ?>"/>

                                            <label class="mt-3">Email</label>
                                            <input type="email" class="form-control" name="bill_email" id="bill_email" value="<?= $pod_author_addr_details[0]['email'] ?>"/>
                                        </div>

                                        <!-- Shipping Address -->
                                        <div class="col-6">
                                            <h6 class="mt-3">Shipping Address</h6>
                                            <br>
                                            <button type="button" id="same_billing" name="same_billing" 
                                                class="btn rounded-pill btn-lilac-100 text-lilac-600 radius-8 px-20 py-11" 
                                                onclick="copyBillingAddress()">
                                                Same as billing address
                                            </button>

                                            <label class="mt-3">Name</label>
                                            <input type="text" class="form-control" name="ship_name" id="ship_name"/>

                                            <label class="mt-3">Address</label>
                                            <textarea class="form-control" name="ship_addr" id="ship_addr" rows="4"></textarea>

                                            <label class="mt-3">Mobile</label>
                                            <input class="form-control" name="ship_mobile" id="ship_mobile"/>

                                            <label class="mt-3">Email</label>
                                            <input type="email" class="form-control" name="ship_email" id="ship_email"/>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="d-sm-flex justify-content-between">
                                        <div class="field-wrapper">
                                            <button style="background-color: #77B748 !important; border-color: #77B748 !important;" 
                                                    type="submit" class="btn btn-primary">
                                                Next
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>                    
                    </div>
                </div>
            </div>

            <div class="page-title">
                <br>
                <a href="<?= base_url('orders/ordersdashboard') ?>" class="btn btn-danger">Cancel</a>
                <br><br>
            </div>
        </div>
    </div>
    <br><br>
</div>

<script type="text/javascript">
function calculateTotalAmount(cnt) {
    let totalSum = 0;
    for (let i = 0; i < cnt; i++) {
        const bk_inr = parseFloat(document.getElementById('bk_inr' + i).value) || 0;
        const bk_qty = parseFloat(document.getElementById('bk_qty' + i).value) || 0;
        const bk_discount = parseFloat(document.getElementById('bk_discount' + i).value) || 0;

        const tmp_tot = bk_inr * bk_qty;
        const tmp_dis = tmp_tot * bk_discount / 100;
        const final_amt = tmp_tot - tmp_dis;

        document.getElementById('tot_amt' + i).value = final_amt.toFixed(2);
        totalSum += final_amt;
    }
    document.getElementById('sub_total').value = totalSum.toFixed(2);
}

function copyBillingAddress() {
    document.getElementById('ship_name').value   = document.getElementById('bill_name').value;
    document.getElementById('ship_addr').value   = document.getElementById('bill_addr').value;
    document.getElementById('ship_mobile').value = document.getElementById('bill_mobile').value;
    document.getElementById('ship_email').value  = document.getElementById('bill_email').value;
}
</script>

<?= $this->endSection(); ?>
