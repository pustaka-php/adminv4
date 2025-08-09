<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="row gy-4">
    <!-- Order & User Info -->
    <div class="col-12">
        <h6 class="text-center">shipping and tracking id & tracking url<h6><br>
        <div class="row justify-content-center"> 
            <div class="col-md-6 col-lg-5"> 
                <div class="radius-8 p-20 shadow-sm bg-purple-light text-center">
                    <h6 class="mb-4">Order Details</h6><br>
                    <p><strong>Order Id:</strong> <?= esc($orderbooks['order_id']); ?></p>
                    <p><strong>Book Id:</strong> <?= esc($orderbooks['book_id']); ?></p>
                    <p><strong>User Name:</strong> <?= esc($details['details']['username']); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Two Column Layout -->
    <div class="row g-4">
        <!-- Shipping Address -->
        <div class="col-md-6">
            <div class="radius-8 h-100 p-20 bg-success-100 shadow-sm">
                <h6 class="mb-3">Shipping Address</h6>
                <p><strong>Name:</strong> <?= esc($details['details']['shipping_name']); ?></p>
                <p><strong>Address:</strong> <?= esc($details['details']['shipping_address1']); ?></p>
                <p><?= esc($details['details']['shipping_address2']); ?></p>
                <p><?= esc($details['details']['shipping_area_name']); ?></p>
                <p><strong>City:</strong> <?= esc($details['details']['shipping_city']); ?></p>
            </div>
        </div>

        <!-- Tracking Form -->
        <div class="col-md-6">
            <div class="radius-8 h-100 p-20 bg-info-focus shadow-sm">
                <h6 class="mb-3">Tracking Information</h6>
                <form>
                    <input type="hidden" id="book_id" name="book_id" value="<?= esc($orderbooks['book_id']); ?>">
                    <input type="hidden" id="order_id" name="order_id" value="<?= esc($orderbooks['order_id']); ?>">

                    <div class="form-group mb-3">
                        <label for="tracking_id">Tracking Id</label>
                        <input type="text" class="form-control" id="tracking_id" name="tracking_id"
                            value="<?= esc($orderbooks['tracking_id']); ?>">
                    </div>
                    <div class="form-group mb-3">
                        <label for="tracking_url">Tracking URL</label>
                        <input type="text" class="form-control" id="tracking_url" name="tracking_url"
                            value="<?= esc($orderbooks['tracking_url']); ?>">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Buttons -->
    <div class="text-center mt-4 pt-3">
        <a href="#" onclick="mark_ship()" class="btn btn-success rounded-pill me-2">Ship</a>
        <a href="<?= base_url('paperback/onlineorderbooksstatus'); ?>" class="btn btn-danger rounded-pill">Close</a>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    var base_url = window.location.origin;

    function mark_ship() {
        var order_id = document.getElementById('order_id').value;
        var book_id = document.getElementById('book_id').value;
        var tracking_id = document.getElementById('tracking_id').value;
        var tracking_url = document.getElementById('tracking_url').value;

        if (order_id === '' || book_id === '' || tracking_id === '' || tracking_url === '') {
            alert("Please fill in all fields before marking as shipped.");
            return;
        }

        $.ajax({
            url: base_url + 'paperback/onlinemarkshipped',
            type: 'POST',
            data: {
                "order_id": order_id,
                "book_id": book_id,
                "tracking_id": tracking_id,
                "tracking_url": tracking_url
            },
            success: function(data) {
                if (data == 1) {
                    alert("Completed Successfully!!");
                } else {
                    alert("Unknown error!! Check again!");
                }
            }
        });
    }
</script>
<?= $this->endSection(); ?>
