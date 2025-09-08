<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h3 class="text-center">Selected Books List</h3>
                <br>
            </div>
        </div>
        <?php 
            $num_copies = $_POST['num_copies'];
            $discount = $_POST['discount'];
            $bookshop_id = $_POST['bookshop_id'];
            $ship_date = $_POST['ship_date'];
            $preferred_transport = $_POST['preferred_transport'];
            $preferred_transport_name = $_POST['preferred_transport_name'];
            $transport_payment = $_POST['transport_payment'];
            $ship_address = $_POST['ship_address'];
            $payment_type = $_POST['payment_type'];
            $payment_status = $_POST['payment_status'];
            $vendor_po_order_number = $_POST['vendor_po_order_number'];
        ?>
        <form id="ajaxForm" class="text-left" method="POST">
            <div class="form">
                <input type="hidden" value="<?php echo $bookshop_id; ?>" name="bookshop_id">
                <input type="hidden" value="<?php echo count($selected_books_data); ?>" name="num_of_books">
                <input type="hidden" value="<?php echo $ship_date; ?>" name="ship_date">
                <input type="hidden" value="<?php echo $preferred_transport; ?>" name="preferred_transport">
                <input type="hidden" value="<?php echo $preferred_transport_name; ?>" name="preferred_transport_name">
                <input type="hidden" value="<?php echo $transport_payment; ?>" name="transport_payment">
                <input type="hidden" value="<?php echo $ship_address; ?>" name="ship_address">
                <input type="hidden" value="<?php echo $payment_type; ?>" name="payment_type">
                <input type="hidden" value="<?php echo $payment_status; ?>" name="payment_status">
                <input type="hidden" value="<?php echo $vendor_po_order_number; ?>" name="vendor_po_order_number">

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
                        <?php
                            $i = 1;
                            $j = 1;

                            foreach ($selected_books_data as $selected_books) { ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td>
                                        <input type="text" class="form-control" value="<?php echo $selected_books['bookID'] ?>" name="book_id<?php echo $j; ?>" readonly style="height:40px; width: 100px; color: black;">
                                    </td>
                                    <td><?php echo $selected_books['book_title'] ?></td>
                                    <td><?php echo $selected_books['author_name'] ?></td>
                                    <td>
                                        <input type="text" class="form-control" value="<?php echo $num_copies ?>" id="bk_qty<?php echo $j; ?>" name="bk_qty<?php echo $j; ?>" style="height:40px; width: 100px;" onInput="calculateTotalAmount(<?php echo $j; ?>)">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" value="<?php echo $selected_books['paper_back_inr'] ?>" id="bk_inr<?php echo $j; ?>" name="bk_inr<?php echo $j; ?>" style="height:40px; width: 100px;" onInput="calculateTotalAmount(<?php echo $j; ?>)">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" value="<?php echo $discount ?>" id="bk_dis<?php echo $j; ?>" name="bk_dis<?php echo $j; ?>" style="height:40px; width: 100px;" onInput="calculateTotalAmount(<?php echo $j; ?>)">
                                    </td>
                                    <?php 
                                    $total_inr = ($num_copies * $selected_books['paper_back_inr']) * (1 - $discount / 100);
                                    ?>
                                    <td>
                                        <input type="text" class="form-control" value="<?php echo $total_inr ?>" placeholder="0" id="tot_amt<?php echo $j; ?>" name="tot_amt<?php echo $j; ?>" style="color: black;" readonly required>
                                    </td>
                                </tr>
                            <?php 
                            $j++;
                            } ?>  
                    </tbody>
                </table>
                <br>
                <div class="d-sm-flex right-content-between">
                    <div class="field-wrapper">
                        <button style="background-color: #77B748 !important; border-color: #77B748 !important;" type="submit" class="btn btn-primary">Submit</button>
                        <a href="<?php echo base_url() . "pustaka_paperback/dashboard" ?>" class="btn btn-danger">Close</a>
                    </div>
                </div>
            </div>
        </form>             
    </div>
</div>
<script type="text/javascript">
    var base_url = window.location.origin;

    function calculateTotalAmount(i) {
        var bk_inr = document.getElementById("bk_inr" + i).value;
        var bk_qty = document.getElementById("bk_qty" + i).value;
        var bk_dis = document.getElementById("bk_dis" + i).value;
        var tmp_tot = bk_inr * bk_qty;
        var tmp_dis = tmp_tot * bk_dis / 100;
        var tmp = tmp_tot - tmp_dis;
        document.getElementById("tot_amt" + i).value = tmp;
    }

    $(document).ready(function() {
        
        $('#ajaxForm').on('keypress', function(e) {
            if (e.keyCode === 13) {
                e.preventDefault();
            }
        });

        
        $("#ajaxForm").submit(function(e) {
            e.preventDefault();

            var formData = $(this).serialize();
            $.ajax({
                type: "POST",
                url: base_url + "/pustaka_paperback/submit_bookshop_orders",
                data: formData,
                success: function(data) {
                    if (data == 1) {
                        alert("Added Successfully!!");
                        window.location.href = base_url + "/pustaka_paperback/bookshop_orderbooks_status";
                    } else {
                        alert("Unknown error!! Check again!");
                    }
                }
            });
        });
    });
</script>
