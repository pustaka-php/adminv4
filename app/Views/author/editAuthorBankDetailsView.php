<div id="content" class="main-content">
  <div class="layout-px-spacing">
    <div class="page-header">
      <div class="page-title">
        <h3>Edit Author Bank Details (Publisher Table) - <?php echo $author_details['author_name']; ?>(<?php echo $author_details['author_name']; ?>)</h3>
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
        <input type="hidden" id="copyright_owner" name="copyright_owner" value="<?php echo $publisher_details['copyright_owner'] ?>">
        <label class="mt-3">Bank Account No:</label>
        <input type="text" id="bank_acc_no" value="<?php echo $publisher_details['bank_acc_no'] ?>" class="form-control" name="bank_acc_no">

        <label class="mt-3">Bank Account Name:</label>
        <input type="text" id="bank_acc_name" value="<?php echo $publisher_details['bank_acc_name'] ?>" class="form-control" name="bank_acc_name">

        <label class="mt-3">Bank Account Type:</label>
        <input type="text" id="bank_acc_type" value="<?php echo $publisher_details['bank_acc_type'] ?>" class="form-control" name="bank_acc_type">
        <p>Note: Bank type can only be "Savings" or "Current".</p>

        <label class="mt-3">IFSC Code:</label>
        <input type="text" id="ifsc_code" value="<?php echo $publisher_details['ifsc_code'] ?>" class="form-control" name="ifsc_code">

        <label class="mt-3">PAN Number:</label>
        <input type="text" id="pan_number" value="<?php echo $publisher_details['pan_number'] ?>" class="form-control" name="pan_number">

        <label class="mt-3">Bonus Percentage:</label>
        <input type="text" id="bonus_percentage" value="<?php echo $publisher_details['bonus_percentage'] ?>" class="form-control" name="bonus_percentage">
        <p>Note: Do not modify any value for bonus percentage without checking properly.</p>
        <a href="#" onclick="edit_author_bank_details()" class="mt-4 btn btn-outline-primary btn-lg">Modify</a>      
    </div>    
  </div>
</div>

<script type="text/javascript">
    var base_url = window.location.origin;
    // Storing all values from form into variables
    function edit_author_bank_details() {
      var copyright_owner = document.getElementById('copyright_owner').value;
      var bank_acc_no = document.getElementById('bank_acc_no').value;
      var bank_acc_name = document.getElementById('bank_acc_name').value;
      var bank_acc_type = document.getElementById('bank_acc_type').value;
      var ifsc_code = document.getElementById('ifsc_code').value;
      var pan_number = document.getElementById('pan_number').value;
      var bonus_percentage = document.getElementById('bonus_percentage').value;
      // Sending the updated values into database
      $.ajax({
            url: base_url + '/author/edit_author_bank_details_post',
            type: 'POST',
            data: {
                "copyright_owner": copyright_owner,
                "bank_acc_no": bank_acc_no,
                "bank_acc_name": bank_acc_name,
                "bank_acc_type": bank_acc_type,
                "ifsc_code": ifsc_code,
                "pan_number": pan_number,
                "bonus_percentage": bonus_percentage
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