<div class="d-flex flex-column gap-32 mt-32">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
        <div class="widget-two">
            <div class="widget-content">
                <div class="w-numeric-value">
                    <div class="w-content">
                        <!-- <span class="w-value">Monthly Invoice</span> -->
                    </div>
                </div>					
                <div class="table-responsive">
                    <table class="table zero-config">
                        <thead>
                        <tr>
                            <th style="border: 1px solid grey">Publisher</th>
                            <!-- <th style="border: 1px solid grey">Publisher Reference No</th> -->
                            <th style="border: 1px solid grey">Title</th>
                            <th style="border: 1px solid grey">#Copies</th>
                            <th style="border: 1px solid grey">#Pages</th>
                            <th style="border: 1px solid grey">Cost</th>
                            <th style="border: 1px solid grey">Fixed</th>
                            <th style="border: 1px solid grey">Cost/Book</th>
                            <th style="border: 1px solid grey">Value</th>
                            <th style="border: 1px solid grey">GST</th>
                            <th style="border: 1px solid grey">Status</th>
                            <th style="border: 1px solid grey">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php 
                            for ($i = 0; $i < sizeof($invoice['pending_invoice_list']); $i++) { 
                                $pending_invoice = $invoice['pending_invoice_list'][$i]; 
                                $del_date = date_create($pending_invoice['delivery_date']);
                                $book_cost = ($pending_invoice['num_pages_quote1'] * $pending_invoice['cost_per_page1']) 
                                           + ($pending_invoice['num_pages_quote2'] * $pending_invoice['cost_per_page2']) 
                                           + $pending_invoice['fixed_charge_book'];
                                if ($pending_invoice['igst_flag']==1) {
                                    $gst = number_format($pending_invoice['igst'],2);
                                } else {
                                    $gst = number_format($pending_invoice['cgst'],2) . "/" . number_format($pending_invoice['sgst'],2);
                                }
                            ?>
                            <tr>
                                <td style="border: 1px solid grey"><?php echo $pending_invoice['publisher_name']?></td>
                                <!-- <td style="border: 1px solid grey"><?php echo $pending_invoice['publisher_reference']; ?></td> -->
                                <td style="border: 1px solid grey"><?php echo $pending_invoice['book_title']; ?> <br>
                                <?php echo $pending_invoice['publisher_reference']; ?>
                                </td>
                                <td style="border: 1px solid grey"><?php echo $pending_invoice['num_copies']; ?></td>
                                <td style="border: 1px solid grey"><?php echo $pending_invoice['total_num_pages']; ?></td>
                                <td style="border: 1px solid grey">
                                    <?php echo $pending_invoice['num_pages_quote1'] . "/" . number_format($pending_invoice['cost_per_page1'],2); ?><br>
                                    <?php echo $pending_invoice['num_pages_quote2'] . "/" . number_format($pending_invoice['cost_per_page2'],2); ?>
                                </td>
                                <td style="border: 1px solid grey"><?php echo number_format($pending_invoice['fixed_charge_book'],2); ?></td>
                                <td style="border: 1px solid grey"><?php echo number_format($book_cost,2); ?></td>
                                <td style="border: 1px solid grey"><?php echo number_format($pending_invoice['invoice_value'],2); ?></td>                    
                                <td style="border: 1px solid grey"><?php echo $gst ?></td>
                                <td style="border: 1px solid grey">
                                    <?php  
                                    if ($pending_invoice['delivery_flag'] == 1) { 
                                        echo "<span style='color: red;'>Delivered</span>"; 
                                    } else if ($pending_invoice['delivery_flag'] == 0) { 
                                        echo "<span style='color: green;'>In progress</span>"; 
                                    } 
                                    ?>
                                </td>
                                <td style="border: 1px solid grey">
                                    <a href="<?php echo base_url();?>pod/pod_publisher_book_create_invoice/<?php echo $pending_invoice['book_id'];?>" 
                                       class="btn btn-sm btn-info mt-2">Create Invoice</a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>                                             
    </div>
</div>
