<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 

<div id="content" class="main-content">
  <div class="layout-px-spacing">
    <div class="page-header">
      <div class="page-title">
        <h6>Edit Author Bank Details (Publisher Table) - <?php echo $author_details['author_name']; ?>(<?php echo $author_details['author_name']; ?>)</h6>
        <?php if ($author_details['status']==0) 
        {
          $status = "InActive";
        } else {
          $status = "Active";
        } ?>
        <h7>Current State - <?php echo $status; ?> </h7>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-8">
        <h6 mb-4>From Author Language Table:</h6>
        <table class="table table-bordered zero-config mb-4">
          <thead>
            <tr>
              <th scope="col">Author Id</th>
              <th scope="col">Language Id</th>
              <th scope="col">Display Name 1</th>
              <th scope="col">Display Name 2</th>
              <th scope="col">Regional Author Name</th>
            </tr>
          </thead>
          <tbody style="font-weight: normal;">
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
    const requestUrl = "<?= site_url('author/editauthorbankdetailspost') ?>";
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
            url: requestUrl,
            type: 'POST',
            dataType: 'JSON',
            data: {
                "copyright_owner": copyright_owner,
                "bank_acc_no": bank_acc_no,
                "bank_acc_name": bank_acc_name,
                "bank_acc_type": bank_acc_type,
                "ifsc_code": ifsc_code,
                "pan_number": pan_number,
                "bonus_percentage": bonus_percentage
            },
            success: function(response) {
                if (response.status == 1) {
                  alert("Edited Author Details Successfully!!!");
                  window.location.href = "<?= site_url('author/editauthor/') ?>/<?= $author_details['author_id']; ?>";
                }
                else if (response.status == 0) {
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