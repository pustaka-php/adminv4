<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-title">
            <h6 class="text-center">Paperback Stock Dashboard</h6>
        </div>

        <div class="d-flex gap-4 justify-content-end">
            <a href="<?= base_url('stock/addstock'); ?>">
                <button class="btn btn-outline-success-600 radius-8 px-20 py-11">
                    Add Stock
                </button>
            </a>
        </div>

        <?php 
            $total_stock = $get_paperback_stock['quantity_cnt'];
            $stock_data = $get_paperback_stock['stock_data'];
        ?>
        <br><br>

        <table class="table table-hover table-bordered zero-config">
            <thead>
                <tr>
                    <th>S.No</th>
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
                    <th>Stock In Hand</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody style="font-weight: normal;">
                <?php 
                    $i = 1;
                    foreach($stock_data as $stock): ?>
                    <tr>
                        <td><?= $i++; ?></td>
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
                        <td><?= $stock['stock_in_hand']; ?></td>
                        <td class="text-center">
                            <button 
                                type="button" 
                                class="btn btn-outline-lilac-600 radius-8 px-14 py-6" 
                                data-bs-toggle="modal" 
                                data-bs-target="#exampleModal"
                                onclick="set_quantity_data(<?= $stock['id']; ?>, '<?= $stock['title']; ?>')">
                                Edit
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>   
        <br><br>

        <!-- Edit Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Quantity</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <h5>Book ID: <span id="editQuantityId"></span></h5>
                        <h5>Title: <span id="editQuantityTitle"></span></h5>
                        <form class="mt-0">
                            <div class="form-group">
                                <div class="row mb-2">
                                    <div class="col-4"><h6>Total Quantity:</h6></div>
                                    <div class="col"><input type="number" class="form-control" id="newQuantity" placeholder="Enter Quantity"></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4"><h6>Bookfair Count:</h6></div>
                                    <div class="col"><input type="number" class="form-control" id="newBookfair" placeholder="Enter Bookfair count"></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4"><h6>Bookfair Count2:</h6></div>
                                    <div class="col"><input type="number" class="form-control" id="newBookfair2" placeholder="Enter Bookfair2 count"></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4"><h6>Bookfair Count3:</h6></div>
                                    <div class="col"><input type="number" class="form-control" id="newBookfair3" placeholder="Enter Bookfair3 count"></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4"><h6>Bookfair Count4:</h6></div>
                                    <div class="col"><input type="number" class="form-control" id="newBookfair4" placeholder="Enter Bookfair4 count"></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4"><h6>Bookfair Count5:</h6></div>
                                    <div class="col"><input type="number" class="form-control" id="newBookfair5" placeholder="Enter Bookfair5 count"></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4"><h6>Lost Qty:</h6></div>
                                    <div class="col"><input type="number" class="form-control" id="lost_qty" placeholder="Enter Lost Qty"></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4"><h6>Stock In Hand:</h6></div>
                                    <div class="col"><input type="number" class="form-control" id="newStockInHand" placeholder="Enter Stock In Hand"></div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button onclick="save_quantity()" class="btn btn-success" data-bs-dismiss="modal">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</div>

<script type="text/javascript">
    function set_quantity_data(id, title) {
        document.querySelector("#editQuantityId").innerHTML = id;
        document.querySelector("#editQuantityTitle").innerHTML = title;
    }

    function save_quantity() {
        const base_url = window.location.origin;
        const book_id = document.querySelector("#editQuantityId").innerHTML;
        const quantity = document.querySelector("#newQuantity").value;
        const bookfair = document.querySelector("#newBookfair").value;
        const bookfair2 = document.querySelector("#newBookfair2").value;
        const bookfair3 = document.querySelector("#newBookfair3").value;
        const bookfair4 = document.querySelector("#newBookfair4").value;
        const bookfair5 = document.querySelector("#newBookfair5").value;
        const lostqty = document.querySelector("#lost_qty").value;
        const stock_in_hand = document.querySelector("#newStockInHand").value;

        $.ajax({
            url: base_url + 'paperback/savequantity',
            type: 'POST',
            data: {
                "book_id": book_id,
                "quantity": quantity,
                "bookfair": bookfair,
                "bookfair2": bookfair2,
                "bookfair3": bookfair3,
                "bookfair4": bookfair4,
                "bookfair5": bookfair5,
                "lost_qty": lostqty,
                "stock_in_hand": stock_in_hand
            },
            success: function(data) {
                if (data == 1) {
                    alert("Quantity Updated Successfully");
                    location.reload();
                }
            }
        });
    }
</script>

<!--Ensure these scripts are loaded in your layout (if not already): -->
<!-- Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery (for AJAX) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<?= $this->endSection(); ?>
