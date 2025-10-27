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
      <div class="col-8">
        <h4 mb-4>From Author Language Table:</h4>
        <table class="table table-bordered table-hover mt-5">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Author Id</th>
              <th scope="col">Language Id</th>
              <th scope="col">Display Name 1</th>
              <th scope="col">Display Name 2</th>
              <th scope="col">Regional Author Name</th>
            </tr>
          </thead>
          <tbody style="font-weight: 800;">
            <?php foreach ($author_language_details as $author_language_detail) { ?>
            <tr>
              <th><?php echo $author_language_detail['author_id']; ?></th>
              <th><?php echo $author_language_detail['language_id']; ?></th>
              <th><?php echo $author_language_detail['display_name1']; ?></th>
              <th><?php echo $author_language_detail['display_name2']; ?></th>
              <th><?php echo $author_language_detail['regional_author_name']; ?></th>
            </tr>
            <?php } ?>
          </tbody>
        </table>
        <a target="_blank" href="" class="ml-2 btn btn-info">Add Author Language Name</a>        
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