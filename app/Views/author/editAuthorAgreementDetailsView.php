<div id="content" class="main-content">
  <div class="layout-px-spacing">
    <div class="page-header">
      <div class="page-title">
        <h3>Edit Author Agreement Details (Author Table) - <?php echo $author_details['author_name']; ?>(<?php echo $author_details['author_name']; ?>)</h3>
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
        <label class="mt-3">Agreement Details:</label>
        <textarea class="form-control" id="agreement_details"  rows="7"><?php echo $author_details['agreement_details']; ?></textarea>
        <p>Note:Enter the agreement id and date. Eg. PUS/TAM/180/2022 dated 28th June 2022. The addendum should also be entered in this field in the same format.</p>

        <label class="mt-3">Ebook Count (As per Agreement):</label>
        <input type="text" id="agreement_ebook_count" value="<?php echo $author_details['agreement_ebook_count'] ?>" class="form-control" name="agreement_ebook_count">
        <p>Note: Update this field whenever an addendum is created for the author.</p>

        <label class="mt-3">Audiobook Count (As per Agreement)</label>
        <input type="text" id="agreement_audiobook_count" value="<?php echo $author_details['agreement_audiobook_count'] ?>" class="form-control" name="agreement_audiobook_count">
        <p>Note: Update this field whenever an addendum is created for the author.</p>

        <label class="mt-3">Paperback Count (As per Agreement)</label>
        <input type="text" id="agreement_paperback_count" value="<?php echo $author_details['agreement_paperback_count'] ?>" class="form-control" name="agreement_audiobook_count">
        <p>Note: Update this field whenever an addendum is created for the author.</p>
      <a href="#" onclick="edit_author_agreement_details()" class="mt-4 btn btn-outline-primary btn-lg">Modify</a>      
    </div>    
  </div>
</div>

<script type="text/javascript">
    var base_url = window.location.origin;
    // Storing all values from form into variables
    function edit_author_agreement_details() {
      var agreement_details = document.getElementById('agreement_details').value;
      var agreement_ebook_count = document.getElementById('agreement_ebook_count').value;
      var agreement_audiobook_count = document.getElementById('agreement_audiobook_count').value;
      var agreement_paperback_count = document.getElementById('agreement_paperback_count').value;
      // Sending the updated values into database
      $.ajax({
            url: base_url + '/author/edit_author_agreement_details_post',
            type: 'POST',
            data: {
                "author_id":  <?php echo $this->uri->segment(3)?>,
                "agreement_details": agreement_details,
                "agreement_ebook_count": agreement_ebook_count,
                "agreement_audiobook_count": agreement_audiobook_count,
                "agreement_paperback_count": agreement_paperback_count
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
</script>