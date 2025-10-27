<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div id="content" class="main-content">
  <div class="layout-px-spacing">
    <div class="page-header">
      <div class="page-title">
        <h3>Edit Author Details (Publisher Table) - <?php echo $author_details['author_name']; ?>(<?php echo $author_details['author_name']; ?>)</h3>
        <?php if ($author_details['status']==0) 
        {
          $status = "InActive";
        } else {
          $status = "Active";
        } ?>
        <h3>Current State - <?php echo $status; ?> </h3>
      </div>
    </div>
    <div class="row">
      <div class="col-6">
        <label class="mt-3">Mobile:</label>
        <input type="text" id="mobile" value="<?php echo $publisher_details['mobile'] ?>" class="form-control" name="mobile">

        <label class="mt-3">Email id:</label>
        <input type="text" id="email_id" value="<?php echo $publisher_details['email_id'] ?>" class="form-control" name="email_id">

      <label class="mt-3">Address</label>
      <textarea class="form-control" id="address" rows="7"><?php echo $publisher_details['address']; ?></textarea>
      <div class=" mt-1">
        <span class="badge badge-info">
        <small id="" class="form-text mt-0">Characters: <span id="num_chars">0</span></small>
        </span>
      </div>

      <label class="mt-3">Copyright Owner:</label>
      <input type="text" id="copyright_owner" value="<?php echo $publisher_details['copyright_owner'] ?>" class="form-control" disabled name="copyright_owner">

      <label class="mt-3">Publisher URL Name: (Use only for a publisher like Manimegalai, Dhwanidhare, etc.)</label>
      <input type="text" id="publisher_url_name" value="<?php echo $publisher_details['publisher_url_name'] ?>" class="form-control" name="publisher_url_name">

      <label class="mt-3">Publisher Image: (Use only for a publisher like Manimegalai, Dhwanidhare, etc. as logo)</label>
      <input type="text" id="publisher_image" value="<?php echo $publisher_details['publisher_image'] ?>" class="form-control" name="publisher_url_name">

      <a href="#" onclick="edit_author_publisher_details()" class="mt-4 btn btn-outline-primary btn-lg">Modify</a>      
    </div>    
  </div>
</div>

<script type="text/javascript">
    var base_url = window.location.origin;
    // Storing all values from form into variables
    function edit_author_publisher_details() {
      var copyright_owner = document.getElementById('copyright_owner').value;
      var mobile = document.getElementById('mobile').value;
      var email_id = document.getElementById('email_id').value;
      var address = document.getElementById('address').value;
      var publisher_url_name = document.getElementById('publisher_url_name').value;
      var publisher_image = document.getElementById('publisher_image').value;
      // Sending the updated values into database
      $.ajax({
            url: base_url + 'author/editauthorpublisherdetailspost',
            type: 'POST',
            data: {
                "copyright_owner": copyright_owner,
                "mobile": mobile,
                "email_id": email_id,
                "address": address,
                "publisher_url_name": publisher_url_name,
                "publisher_image": publisher_image
            },
            success: function(data) {
                if (data == 1) {
                  alert("Edited Author Details Successfully!!!");
                }
                else if (data == 0) {
                    alert("Error Occurred!!");
                }
            }
        });
    }

  function count_chars() {
        var num_chars = document.getElementById('desc_text').value.length;
        document.getElementById('num_chars').textContent = num_chars;
    }
</script>
<?= $this->endSection(); ?>