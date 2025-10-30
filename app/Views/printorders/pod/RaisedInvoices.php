<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 

<div class="layout-px-spacing">
    <div class="row">
        <div class="col-12">
            <!-- <div class="card shadow-sm radius-12 border"> -->
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">PoD Publisher Raised Invoices</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-4 zero-config text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Publisher Name</th>
                                    <th>Total Books</th>
                                    <th>Invoice Value (₹)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; foreach($raised_invoices as $invoice): ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= esc($invoice['publisher_name']); ?></td>
                                    <td><?= esc($invoice['total_books']); ?></td>
                                    <td><?= number_format($invoice['total_invoice_value'],2); ?></td>
                                    <td>
                                        <a href="<?= base_url('pod/raisedinvoicedetails/' . $invoice['publisher_id']); ?>" class="btn btn-sm btn-primary">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if(empty($raised_invoices)): ?>
                                <tr>
                                    <td colspan="5">No raised invoices found.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <!-- </div> -->
            <br>
               <h6>Raised Invoices - <?php echo sizeof($raised_invoice_data); ?></h6>
                <table class="table zero-config">
                    <thead>
                    <tr>
                        <th style="border: 1px solid grey">Publisher</th>
                        <th style="border: 1px solid grey">Title</th>
                        <th style="border: 1px solid grey">#Copies</th>
                        <th style="border: 1px solid grey">#Pages</th>
                        <th style="border: 1px solid grey">Value</th>
                        <th style="border: 1px solid grey">GST</th>
                        <th style="border: 1px solid grey">Invoice Date</th>
                        <th style="border: 1px solid grey">Invoice Number</th>
                        <th style="border: 1px solid grey">Action</th>
                    </tr>
                    </thead>
                    <tbody style="">
                        <?php for ($i = 0; $i < sizeof($raised_invoice_data); $i++) { 
                            $raised_invoice = $raised_invoice_data[$i]; 
                            $del_date = date_create($raised_invoice['delivery_date']);
                            $inv_date = date_create($raised_invoice['invoice_date']);   
                            $gst = $raised_invoice['sgst'] + $raised_invoice['cgst'] + $raised_invoice['igst'];                 
                        ?>
                        <tr>
                            <td style="border: 1px solid grey"><?php echo $raised_invoice['publisher_name']; ?></td>
                            <td style="border: 1px solid grey"><?php echo $raised_invoice['book_title']; ?></td>
                            <td style="border: 1px solid grey"><?php echo $raised_invoice['num_copies']; ?></td>
                            <td style="border: 1px solid grey"><?php echo $raised_invoice['total_num_pages']; ?></td>
                            <td style="border: 1px solid grey"><?php echo number_format($raised_invoice['invoice_value'],2); ?></td>                    
                            <td style="border: 1px solid grey"><?php echo $gst ?></td>
                            <td style="border: 1px solid grey"><?php echo date_format($inv_date, "d/m/Y"); ?></td>
                            <td style="border: 1px solid grey"><?php echo $raised_invoice['invoice_number']; ?></td>
                            <td style="border: 1px solid grey"><a href="" onclick="mark_payment_complete(<?php echo $raised_invoice['book_id'];?>)" class="btn btn-sm btn-info mt-2">Payment Received</a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script type="text/javascript">
    var base_url = window.location.origin;

    function mark_payment_complete(book_id) {
        $.ajax({
            url: base_url + '/pod/mark_payment/',
            type: 'POST',
            data: { book_id: book_id },
            dataType: 'json',
            success: function (data) {
                if (data == 1) {
                    alert("Successfully marked as payment received!!");
                }
                else {
                    alert("Unknown error!! Check again!")
                }
            },
            error: function (xhr) {
                alert("Server error! " + xhr.responseText);
            }
        });
    }
</script>
<?= $this->endSection(); ?>
