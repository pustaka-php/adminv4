<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="row gy-4">
    <!-- Page Header -->
    <div class="col-12">
        <div class="page-header d-flex justify-content-between align-items-center">
            <div class="page-title text-center flex-grow-1">
                <h6 class="text-center">Shipping and tracking id & tracking url</h6><br>
            </div>
            <a href="<?= base_url('paperback/onlineorderbooksstatus'); ?>" 
               class="btn btn-outline-secondary btn-sm">
                ← Back
            </a>
        </div>
    </div>
    <!-- Order Basic Info -->
    <div class="col-lg-4 col-sm-6 text-center mx-auto">
        <div class="p-16 bg-info-50 radius-8 border-start-width-3-px border-info border-top-0 border-end-0 border-bottom-0">   
            <h5 class="text-primary-light text-md mb-8">Order Basic Info</h5>
            <div class="text-start">
                <span >
                    <strong>Order Id:</strong> <?= esc($orderbooks['order_id']) ?? '' ?>
                </span><br>
                <span>
                    <strong>Book Id:</strong> <?= esc($orderbooks['book_id']) ?? '' ?>
                </span><br>
                <span>
                    <strong>User Name:</strong> <?= esc($details['details']['username']) ?? '' ?>
                </span><br>
            </div>
        </div>
    </div>

    <div class="row mt-80">
        <!-- Shipping Address Card -->
        <div class="col-md-6">
            <div class="card h-100 radius-12 bg-gradient-success text-end">
                <div class="card-body p-24">
                    <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-success-600 text-white mb-16 radius-12">
                        <iconify-icon icon="mdi:map-marker" class="h5 mb-0"></iconify-icon>
                    </div>
                    <h6 class="mb-8 text-start">Shipping Address</h6>

                    <p class="card-text mb-8 text-secondary-light text-start">
                        <strong>Name:</strong> <?= esc($details['details']['shipping_name']); ?><br>
                        <strong>Address:</strong> <?= esc($details['details']['shipping_address1']); ?><br>
                        <?= esc($details['details']['shipping_address2']); ?><br>
                        <?= esc($details['details']['shipping_area_name']); ?><br>
                        <strong>City:</strong> <?= esc($details['details']['shipping_city']); ?>
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

                    <h6 class="mb-8 text-start">Tracking Information</h6>

                    <form>
                        <input type="hidden" id="book_id" name="book_id" value="<?= esc($orderbooks['book_id']); ?>">
                        <input type="hidden" id="order_id" name="order_id" value="<?= esc($orderbooks['order_id']); ?>">

                        <div class="form-group mb-3 text-start">
                            <label for="tracking_id">Tracking Id</label>
                            <input type="text" class="form-control" id="tracking_id" name="tracking_id"
                                value="<?= esc($orderbooks['tracking_id']); ?>">
                        </div>

                        <div class="form-group mb-3 text-start">
                            <label for="tracking_url">Tracking URL</label>
                            <input type="text" class="form-control" id="tracking_url" name="tracking_url"
                                value="<?= esc($orderbooks['tracking_url']); ?>">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> <br>
    <!-- Buttons -->
    <center>
        <div class="field-wrapper">
            <button type="button" onclick="mark_ship()" class="btn btn-success">Ship</button>
            <a href="<?= base_url('paperback/onlineorderbooksstatus'); ?>" class="btn btn-danger">Close</a>
        </div>
    </center>
</div>


<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    var base_url = "<?= base_url() ?>";

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
            dataType:'JSON',
            success: function(response) {
                if (response.status == 1) {
                    alert("Completed Successfully!!");
                    setTimeout(function() {
                    window.location.href = base_url + 'paperback/onlineorderbooksstatus';
                }, 4000);
                } else {
                    alert("Unknown error!! Check again!");
                }
            }
        });
    }
</script>
<?= $this->endSection(); ?>
