<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 

<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="page-title">
            <h6 class="text-center">Paperback Stock Dashboard</h6>
        </div>

        <div class="d-flex gap-4 justify-content-end mb-3">
            <a href="<?= base_url('stock/addstock'); ?>">
                <button class="btn btn-success-600 radius-8 px-20 py-11">
                    Add Stock
                </button>
            </a>
             <a href="<?= base_url('stock/stockdashboard'); ?>" class="btn btn-outline-secondary btn-sm d-flex align-items-center shadow-sm">
            <iconify-icon icon="mdi:arrow-left" class="me-1 fs-5"></iconify-icon> Back
        </a>
        </div>

        <?php 
            $bookfair   = $get_paperback_stock['bookfair_retailer'];
            $stock_data = $get_paperback_stock['stock_data'];
        ?>

        <!-- Bookfair Table -->
        <div class="d-flex justify-content-center mb-4">
            <div class="col-xl-6 col-lg-7 col-md-8 col-sm-10 col-12">
                <div class="widget-two">
                    <div class="widget-content">
                        <table class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>BookFair Name</th>
                                    <th>Retailer Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($bookfair as $row): ?>
                                    <tr>
                                        <td><?= $row['bookfair_name'] ?></td>
                                        <td><?= $row['retailer_name'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stock Table -->
        <div class="table-responsive" style="max-height: 600px;">
            <table class="table table-hover table-bordered zero-config">
                <thead class="table-light" style="position: sticky; top: 0">
                    <tr>
                        <th>Book Id</th>
                        <th><center>Book Title</center></th>
                        <th><center>Author Name</center></th>
                        <th>Quantity</th>
                        <th>BookFair</th>
                        <th>BookFair 2</th>
                        <th>BookFair 3</th>
                        <th>BookFair 4</th>
                        <th>BookFair 5</th>
                        <th>Lost Qty</th>
                        <th>Excess Qty</th>
                        <th>Stock In Hand</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($stock_data as $stock): ?>
                        <tr>
                            <td><?= $stock['id']; ?></td>
                            <td><?= $stock['title']; ?></td>
                            <td><?= $stock['author_name']; ?></td>
                            <td><?= $stock['qty']; ?></td>
                            <td><?= $stock['bookfair']; ?></td>
                            <td><?= $stock['bookfair2']; ?></td>
                            <td><?= $stock['bookfair3']; ?></td>
                            <td><?= $stock['bookfair4']; ?></td>
                            <td><?= $stock['bookfair5']; ?></td>
                            <td><?= $stock['lost_qty']; ?></td>
                            <td><?= $stock['excess_qty']; ?></td>
                            <td><?= $stock['stock_in_hand']; ?></td>

                            <td class="text-center">
                                <button 
                                    type="button" 
                                    class="btn btn-outline-lilac-600 radius-8 px-14 py-6"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#exampleModal"
                                    onclick="set_quantity_data(
                                        '<?= $stock['id']; ?>',
                                        '<?= htmlspecialchars($stock['title'], ENT_QUOTES); ?>',
                                        '<?= $stock['qty']; ?>',
                                        '<?= $stock['bookfair']; ?>',
                                        '<?= $stock['bookfair2']; ?>',
                                        '<?= $stock['bookfair3']; ?>',
                                        '<?= $stock['bookfair4']; ?>',
                                        '<?= $stock['bookfair5']; ?>',
                                        '<?= $stock['lost_qty']; ?>',
                                        '<?= $stock['excess_qty']; ?>',
                                        '<?= $stock['stock_in_hand']; ?>'
                                    )">
                                    Edit
                                </button>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl"> 
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Update Quantity</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <h5>Book ID: <span id="editQuantityId"></span></h5>
                        <h5>Title: <span id="editQuantityTitle"></span></h5>

                        <form>
                            <div class="row g-2 mt-3">

                                <div class="col-md-6">
                                    <label>Total Quantity:</label>
                                    <input type="number" class="form-control" id="newQuantity">
                                </div>

                                <div class="col-md-6">
                                    <label>Bookfair Count:</label>
                                    <input type="number" class="form-control" id="newBookfair">
                                </div>

                                <div class="col-md-6">
                                    <label>Bookfair Count 2:</label>
                                    <input type="number" class="form-control" id="newBookfair2">
                                </div>

                                <div class="col-md-6">
                                    <label>Bookfair Count 3:</label>
                                    <input type="number" class="form-control" id="newBookfair3">
                                </div>

                                <div class="col-md-6">
                                    <label>Bookfair Count 4:</label>
                                    <input type="number" class="form-control" id="newBookfair4">
                                </div>

                                <div class="col-md-6">
                                    <label>Bookfair Count 5:</label>
                                    <input type="number" class="form-control" id="newBookfair5">
                                </div>

                                <div class="col-md-6">
                                    <label>Lost Qty:</label>
                                    <input type="number" class="form-control" id="lost_qty">
                                </div>

                                <div class="col-md-6">
                                    <label>Excess Qty:</label>
                                    <input type="number" class="form-control" id="excess_qty">
                                </div>

                                <div class="col-md-6">
                                    <label>Stock In Hand:</label>
                                    <input type="number" class="form-control" id="newStockInHand">
                                </div>

                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button onclick="save_quantity()" class="btn btn-success">Save</button>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<script>
function set_quantity_data(id, title, qty, b1, b2, b3, b4, b5, lost,excess,hand) {
    $("#editQuantityId").text(id);
    $("#editQuantityTitle").text(title);

    $("#newQuantity").val(qty);
    $("#newBookfair").val(b1);
    $("#newBookfair2").val(b2);
    $("#newBookfair3").val(b3);
    $("#newBookfair4").val(b4);
    $("#newBookfair5").val(b5);
    $("#lost_qty").val(lost);
    $("#excess_qty").val(excess);
    $("#newStockInHand").val(hand);
}

function save_quantity() {

    $.ajax({
        url: "<?= base_url('stock/savequantity'); ?>",
        type: "POST",
        data: {
            book_id: $("#editQuantityId").text(),
            quantity: $("#newQuantity").val(),
            bookfair: $("#newBookfair").val(),
            bookfair2: $("#newBookfair2").val(),
            bookfair3: $("#newBookfair3").val(),
            bookfair4: $("#newBookfair4").val(),
            bookfair5: $("#newBookfair5").val(),
            lost_qty: $("#lost_qty").val(),
            excess_qty:$("#excess_qty").val(),
            stock_in_hand: $("#newStockInHand").val()
        },

        success: function (data) {
            console.log("Response:", data);

            if (data.status == 1) {
                alert("Quantity Updated Successfully");
                $("#exampleModal").modal('hide');
                location.reload();
            } else {
                alert("Update Failed");
            }
        },

        error: function(xhr, status, error) {
            alert("AJAX Error: " + error);
        }
    });
}
</script>

<?= $this->endSection(); ?>
