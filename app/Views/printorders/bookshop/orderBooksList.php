<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h6 class="text-center">Selected Books List</h6>
                <br>
            </div>
        </div>

        <?php 
            $num_copies = $_POST['num_copies'] ?? 1;
            $discount = $_POST['discount'] ?? 0;
            $bookshop_id = $_POST['bookshop_id'] ?? '';
            $ship_date = $_POST['ship_date'] ?? '';
            $preferred_transport = $_POST['preferred_transport'] ?? '';
            $preferred_transport_name = $_POST['preferred_transport_name'] ?? '';
            $transport_payment = $_POST['transport_payment'] ?? '';
            $ship_address = $_POST['ship_address'] ?? '';
            $payment_type = $_POST['payment_type'] ?? '';
            $payment_status = $_POST['payment_status'] ?? '';
            $vendor_po_order_number = $_POST['vendor_po_order_number'] ?? '';
        ?>

        <form id="ajaxForm" class="text-left" method="POST">
            <div class="form">
                <input type="hidden" value="<?= $bookshop_id ?>" name="bookshop_id">
                <input type="hidden" value="<?= count($selected_books_data) ?>" name="num_of_books">
                <input type="hidden" value="<?= $ship_date ?>" name="ship_date">
                <input type="hidden" value="<?= $preferred_transport ?>" name="preferred_transport">
                <input type="hidden" value="<?= $preferred_transport_name ?>" name="preferred_transport_name">
                <input type="hidden" value="<?= $transport_payment ?>" name="transport_payment">
                <input type="hidden" value="<?= $ship_address ?>" name="ship_address">
                <input type="hidden" value="<?= $payment_type ?>" name="payment_type">
                <input type="hidden" value="<?= $payment_status ?>" name="payment_status">
                <input type="hidden" value="<?= $vendor_po_order_number ?>" name="vendor_po_order_number">

                <table class="table table-hover mt-4">
                    <thead class="thead-dark">
                        <th>S.No</th>
                        <th>Book ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>No. of Copies</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>Final Price</th>
                    </thead>
                    <tbody>
                        <?php $i = 1; $j = 1; ?>
                        <?php foreach ($selected_books_data as $selected_books): ?>
                            <?php $total_inr = ($num_copies * $selected_books['paper_back_inr']) * (1 - $discount / 100); ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td>
                                    <input type="text" class="form-control" value="<?= $selected_books['bookID'] ?>" name="book_id<?= $j ?>" readonly style="height:40px; width:100px; color:black;">
                                </td>
                                <td><?= $selected_books['book_title'] ?></td>
                                <td><?= $selected_books['author_name'] ?></td>
                                <td>
                                    <input type="text" class="form-control" value="<?= $num_copies ?>" id="bk_qty<?= $j ?>" name="bk_qty<?= $j ?>" style="height:40px; width:100px;" onInput="calculateTotalAmount(<?= $j ?>)">
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="<?= $selected_books['paper_back_inr'] ?>" id="bk_inr<?= $j ?>" name="bk_inr<?= $j ?>" style="height:40px; width:100px;" onInput="calculateTotalAmount(<?= $j ?>)">
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="<?= $discount ?>" id="bk_dis<?= $j ?>" name="bk_dis<?= $j ?>" style="height:40px; width:100px;" onInput="calculateTotalAmount(<?= $j ?>)">
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="<?= $total_inr ?>" placeholder="0" id="tot_amt<?= $j ?>" name="tot_amt<?= $j ?>" style="color:black;" readonly required>
                                </td>
                            </tr>
                            <?php $j++; ?>
                        <?php endforeach; ?>  
                    </tbody>
                </table>
                <br>
                <div class="d-sm-flex right-content-between">
                    <div class="field-wrapper">
                        <button id="submitBtn" style="background-color: #77B748 !important; border-color: #77B748 !important;" type="submit" class="btn btn-primary">Submit</button>
                        <a href="<?= base_url('orders/ordersdashboard') ?>" class="btn btn-danger">Close</a>
                    </div>
                </div>
            </div>
        </form>             
    </div>
</div>

<script type="text/javascript">
    function calculateTotalAmount(i) {
        var bk_inr = parseFloat(document.getElementById("bk_inr" + i).value) || 0;
        var bk_qty = parseInt(document.getElementById("bk_qty" + i).value) || 0;
        var bk_dis = parseFloat(document.getElementById("bk_dis" + i).value) || 0;

        var tmp_tot = bk_inr * bk_qty;
        var tmp_dis = tmp_tot * bk_dis / 100;
        var tmp = tmp_tot - tmp_dis;
        document.getElementById("tot_amt" + i).value = tmp.toFixed(2);
    }

    $(document).ready(function() {
        $('#ajaxForm').on('keypress', function(e) {
            if (e.keyCode === 13) e.preventDefault();
        });

        $("#ajaxForm").submit(function(e) {
            e.preventDefault();

            var $btn = $('#submitBtn');
            $btn.prop('disabled', true).text('Submitting...');

            var formData = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "<?= base_url('paperback/submitbookshoporders') ?>",
                data: formData,
                dataType: "json",
                success: function(data) {
                    if(data.status == 1) {
                        alert("Added Successfully!!");
                        window.location.href = "<?= base_url('paperback/bookshoporderbooksstatus') ?>";
                    } else {
                        alert("Unknown error!! Check again!");
                        $btn.prop('disabled', false).text('Submit');
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    alert("AJAX error! Check console.");
                    $btn.prop('disabled', false).text('Submit');
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>
