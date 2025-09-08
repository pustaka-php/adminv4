<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="card bg-info" style="width: 45rem; margin: 0 auto; border-radius: 10px; overflow: hidden;">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <h3 class="text-center">Bookshop Details</h3>
                </li>
                <li class="list-group-item">
                    <h5>Bookshop: <?php echo $orderbooks['details']['bookshop_name']; ?> </h5>
                    <h5>Contact Person: <?php echo $orderbooks['details']['contact_person_name']; ?> </h5>
                    <h5>Mobile No: <?php echo $orderbooks['details']['mobile']; ?> </h5>
                    <h5>Transport Details: <?php echo $orderbooks['details']['preferred_transport']."-".$orderbooks['details']['preferred_transport_name']; ?> </h5>
                    <h5>Address: <br> <?php echo $orderbooks['details']['ship_address']; ?> </h5>
                    <br>
                </li>
                <li class="list-group-item">
                    <!-- style=" font-weight: bold; color:blue;" -->
                    <h5 >Buyer's Order No: <?php echo $orderbooks['details']['vendor_po_order_number']; ?> </h5>
                    <h5 >Transport Payment: <?php echo $orderbooks['details']['transport_payment']; ?> </h5>
                    <h5 >Buyer's Order No: <?php echo $orderbooks['details']['vendor_po_order_number']; ?> </h5>
                <h5>Order Date:
                    <?php
                    if ($orderbooks['details']['order_date']== NULL) {
                        echo '';
                    } else {
                        echo date('d-m-Y',strtotime($orderbooks['details']['order_date']));
                    }?></h5>
                <h5>Ship Date: <?php echo date('d-m-Y',strtotime($orderbooks['details']['ship_date']));?></h5>
                <h5><a href="<?php echo$orderbooks['details']['tracking_url']; ?>" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck">
                        <rect x="1" y="3" width="15" height="13"></rect>
                        <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                        <circle cx="5.5" cy="18.5" r="2.5"></circle>
                        <circle cx="18.5" cy="18.5" r="2.5"></circle>
                    </svg>  <?php echo$orderbooks['details']['tracking_id']; ?>
                </a></h5>
                </li>
            </ul>
        </div>
        <br>
        <br>
        <table class="table table-bordered mb-4">
            <thead class="thead-dark">
            <center><h4>List of Books</h4></center>
            <tr>
                <th style="border: 1px solid grey">S.No</th> 
                <th style="border: 1px solid grey">BookId</th>  
                <th style="border: 1px solid grey">Title</th>
                <th style="border: 1px solid grey">PaperBack ISBN</th>
                <th style="border: 1px solid grey">Author</th>
                <th style="border: 1px solid grey">Quantity</th>
                <th style="border: 1px solid grey">Stock In Hand</th>
                <th style="border: 1px solid grey">Qty Details</th>
                <th style="border: 1px solid grey">Book Price</th>
                <th style="border: 1px solid grey">Discount %</th>
                <th style="border: 1px solid grey">Final amount</th>
                <th style="border: 1px solid grey">Status</th>
            </tr>
            </thead>
            <tbody style="font-weight: 800;">
                <?php
                    $totalValue = 0;
                    $i = 1;
                    foreach ($orderbooks['list'] as $books_details) {
                        $totalValue += $books_details['total_amount'];

                        $original_isbn = $books_details['paper_back_isbn'];
                        $formatted_isbn = str_replace('-', '', $original_isbn);

                ?>
                    <tr>
                        <td style="border: 1px solid grey"><?php echo $i++; ?></td>
                        <td style="border: 1px solid grey"><?php echo $books_details['book_id'] ?></td>
                        <td style="border: 1px solid grey">
                                <?php echo $books_details['book_title'] ?><br>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-copy" onclick="copyToClipboard(this, '<?php echo addslashes($books_details['book_title']); ?>')">
                                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                </svg>
                        </td>
                        <td style="border: 1px solid grey">
                            <?php echo $formatted_isbn ?><br>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-copy" style="color: #000;" onclick="copyToClipboard(this, '<?php echo $formatted_isbn; ?>')">
                                <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                            </svg>
                        </td>

                        <td style="border: 1px solid grey"><?php echo $books_details['author_name'] ?></td>
                        <td style="border: 1px solid grey"><?php echo $books_details['quantity'] ?></td>
                        <td class="table-success" style="border: 1px solid grey"><?php echo $books_details['stock_in_hand'] ?></td>
                        <td  class="table-warning" style="border: 1px solid grey">
							Ledger: <?php echo $books_details['qty'] ?><br>
							Fair / Store: <?php echo ($books_details['bookfair']+$books_details['bookfair2']+$books_details['bookfair3']+$books_details['bookfair4']+$books_details['bookfair5']) ?><br>
							<?php if ($books_details['lost_qty'] < 0) { ?>
								<span style="color:#008000;">Excess: <?php echo abs($books_details['lost_qty']) ?></span><br>
							<?php } elseif ($books_details['lost_qty'] > 0) { ?>
								<span style="color:#ff0000;">Lost: <?php echo $books_details['lost_qty'] ?><br></span>
							<?php } ?>
						</td>
                        <td style="border: 1px solid grey"><?php echo $books_details['book_price'] ?></td>
                        <td style="border: 1px solid grey"><?php echo $books_details['discount']?></td>
                        <td style="border: 1px solid grey"><?php echo $books_details['total_amount'] ?></td>
                        <td style="border: 1px solid grey"><?php if($books_details['ship_status']==0){
                             echo "In Progress";
                           }else if($books_details['ship_status']==1){
                             echo "Shipped";
                           }else if($books_details['ship_status']==2){
                            echo "Cancle";
                           }else if($books_details['ship_status']==3){
                            echo "Return";
                           }else{
                            echo "";
                           } ?>
                        </td>
                        </tr>
                    <?php
                 }?>
                 <tr>
                    <td colspan="10" style="text-align: right; border: 1px solid grey; font-weight: bold; color:blue;">Total amount</td>
                    <td style="border: 1px solid grey; font-weight: bold; color:blue;"><?php echo number_format($totalValue, 2) ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // alert('Copied to clipboard: ' + text);
            }, function(err) {
                // alert('Failed to copy: ', err);
            });
        }
      function copyToClipboard(icon, text) {
            navigator.clipboard.writeText(text);
            var copyText = icon.nextElementSibling;
            icon.style.color = "Blue"; // Change icon color to green
            setTimeout(function() {
                icon.style.color = "#000"; // Reset icon color
            }, 50000); // Reset text after 1 second
        }


    </script>
