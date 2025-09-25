<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 
<div id="content" class="main-content">
	<div class="layout-px-spacing">
		<div class="page-header">
			<div class="page-title">
            <h5 class="text-center">shipping and tracking id & tracking url</h5><br>
			</div>
		</div>
        <br>
        <h6>Order Id: <?php echo $orderbooks['order_id'] ?> </h6>
        <h6>Author Name: <?php echo $details['order']['author_name'] ?> </h6>
        <br><br>
        <div class="row">
            <!-- Shipping Address Card -->
            <div class="col-md-6">
                <div class="card h-100 radius-12 bg-gradient-success text-end">
                    <div class="card-body p-24">
                        <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-success-600 text-white mb-16 radius-12">
                            <iconify-icon icon="mdi:map-marker" class="h5 mb-0"></iconify-icon>
                        </div>
                        <h6 class="mb-8 text-start">Shipping Address</h6>
                        <p class="card-text mb-8 text-secondary-light text-start">
                            <strong>Name:</strong> <?php echo $details['order']['ship_name']; ?><br>
                            <strong>Address:</strong> <?php echo $details['order']['ship_address']; ?><br>
                            <strong>Mobile:</strong> <?php echo $details['order']['ship_mobile']; ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Tracking Info Card -->
            <div class="col-md-6">
                <div class="card h-100 radius-12 bg-gradient-danger text-end">
                    <div class="card-body p-24">
                        <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-danger-600 text-white mb-16 radius-12">
                            <iconify-icon icon="mdi:truck-delivery" class="h5 mb-0"></iconify-icon>
                        </div>
                        <h6 class="mb-8 text-start">Tracking Info</h6>
                        <form>
                            <input type="hidden" class="form-control" id="order_id" name="order_id"
                                value="<?php echo $orderbooks['order_id']; ?>">
                            <div class="form-group mb-3 text-start">
                                <label for="tracking_id">Tracking Id</label>
                                <input type="text" class="form-control" id="tracking_id" name="tracking_id"
                                    value="<?php echo $orderbooks['tracking_id']; ?>">
                            </div>
                            <div class="form-group mb-3 text-start">
                                <label for="tracking_url">Tracking URL</label>
                                <input type="text" class="form-control" id="tracking_url" name="tracking_url"
                                    value="<?php echo $orderbooks['tracking_url']; ?>">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <br>
       <center> <div class="field-wrapper">
        <button type="button" onclick="mark_ship()" class="btn btn-success">Ship</button>
        <a href="<?= base_url()."paperback/authororderbooksstatus"?>" class="btn btn-danger">Close</a>

		</div></center>
    </div>
</div>

<script type="text/javascript">
    var base_url = "<?= base_url(); ?>"; 
    
    function mark_ship() {
        var order_id = document.getElementById('order_id').value;
        var tracking_id = document.getElementById('tracking_id').value;
        var tracking_url = document.getElementById('tracking_url').value;

        if (order_id === '' || tracking_id === '' || tracking_url === '') {
            alert("Please fill in all fields before marking as shipped.");
            return;
        }

        $.ajax({
            url: base_url + "/paperback/authormarkshipped",
            type: 'POST',
            data: {
                "order_id": order_id,
                "tracking_id": tracking_id,
                "tracking_url": tracking_url
            },
            success: function(data) {
                if (data == 1) {
                    alert("Completed Successfully!!");
                } else {
                    alert("Unknown error!! Check again!");
                }
            },
            error: function(xhr, status, error) {
                alert("AJAX Error: " + error);
            }
        });
    }
</script>

<?= $this->endSection(); ?>  