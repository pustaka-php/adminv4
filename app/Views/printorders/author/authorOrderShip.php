<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 
<div id="content" class="main-content">
	<div class="layout-px-spacing">
		<div class="page-header">
			<div class="page-title">
            <center><h3>shipping and tracking id & tracking url</h3></center>
			</div>
		</div>
        <br>
        <h5>Order Id: <?php echo $orderbooks['order_id'] ?> </h5>
        <h5>Author Name: <?php echo $details['order']['author_name'] ?> </h5>
        <br>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Shipping Address</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong>  <?php echo $details['order']['ship_name'];; ?> </p>
                        <p><strong>Address:</strong><?php echo $details['order']['ship_address'] ?> </p>
                        <p><strong>Mobile: </strong><?php echo $details['order']['ship_mobile'];; ?></p>
                        
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                    <form> 
                        <input  type="hidden" class="form-control" id="order_id" name="order_id" value="<?php echo $orderbooks['order_id']; ?>">
                        <div class="form-group">
                            <label for="bookId">Tracking Id</label>
                            <input type="text-dark" class="form-control" id="tracking_id" name="tracking_id" value="<?php echo $orderbooks['tracking_id']; ?>"  >
                        </div>

                        <div class="form-group">
                            <label for="bookTitle">Tracking URL</label>
                            <input type="text" class="form-control" id="tracking_url" name="tracking_url" value="<?php echo $orderbooks['tracking_url']; ?>" >
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
        <br>
       <center> <div class="field-wrapper">
        <a href="" onclick="mark_ship()" class="btn btn-success">Ship</a>
		<a href="<?php echo base_url()."paperback/authororderbooksstatus"?>" class="btn btn-danger">Close</a>
		</div></center>
    </div>
</div>

<script type="text/javascript">
    var base_url = window.location.origin;
    
function mark_ship(){

        var order_id=document.getElementById('order_id').value;
        var tracking_id = document.getElementById('tracking_id').value;
        var tracking_url=document.getElementById('tracking_url').value;
        

        if (order_id === '' || tracking_id === '' || tracking_url === '') {
        alert("Please fill in all fields before marking as shipped.");
        return;
        }
            $.ajax({
                    url: base_url + 'paperback/authormarkshipped',
                    type: 'POST',
                    data: {
                        "order_id":order_id,
                        "tracking_id": tracking_id,
                        "tracking_url":tracking_url
                    },
                    success: function(data) {
                        //alert(data);
                        if (data == 1) {
                            alert("completed Successfully!!");
                        }
                        else {
                            alert("Unknown error!! Check again!")
                        }
                    }
          });
 }
</script>
<?= $this->endSection(); ?>  