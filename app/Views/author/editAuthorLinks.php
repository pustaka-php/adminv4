<div id="content" class="main-content">
  <div class="layout-px-spacing">
		<div class="page-header">
      <div class="page-title">
        <h3>Edit Author Links</h3>
      </div>
		</div>
		<div class="row">
			<div class="col-7">
				<label class="mt-3" for="">Amazon Link</label>
				<input type="text" value="<?php echo $author_link_data['link_data']['amazon_link'] ?>" class="form-control" placeholder="Amazon Link" id="amazon_link">
				<label class="mt-3" for="">Scribd Link</label>
				<input type="text" value="<?php echo $author_link_data['link_data']['scribd_link'] ?>" class="form-control" placeholder="Scribd Link" id="scribd_link">
				<label class="mt-3" for="">Google Books Link</label>
				<input type="text" value="<?php echo $author_link_data['link_data']['googlebooks_link'] ?>" class="form-control" placeholder="Google Books Link" id="google_link">
				<label class="mt-3" for="">Overdrive Link</label>
				<input type="text" value="<?php echo $author_link_data['link_data']['overdrive_link'] ?>" class="form-control" placeholder="Overdrive Link" id="overdrive_link">
				<label class="mt-3" for="">Storytel Link</label>
				<input type="text" value="<?php echo $author_link_data['link_data']['storytel_link'] ?>" class="form-control" placeholder="Storytel Link" id="storytel_link">
				<label class="mt-3" for="">Pratilipi Link</label>
				<input type="text" value="<?php echo $author_link_data['link_data']['pratilipi_link'] ?>" class="form-control" placeholder="Pratilipi Link" id="pratilipi_link">
				<label class="mt-3" for="">Audible Link</label>
				<input type="text" value="<?php echo $author_link_data['link_data']['audible_link'] ?>" class="form-control" placeholder="Audible Link" id="audible_link">
				<label class="mt-3" for="">Odilo Link</label>
				<input type="text" value="<?php echo $author_link_data['link_data']['odilo_link'] ?>" class="form-control" placeholder="Odilo Link" id="odilo_link">
				<label class="mt-3" for="">Pinterest Link</label>
				<input type="text" value="<?php echo $author_link_data['link_data']['pinterest_link'] ?>" class="form-control" placeholder="Pinterest Link" id="pinterest_link">

			</div>
		</div>
		<a href="" onclick="edit_author_links()" class="mt-3 mb-5 btn btn-rounded btn-outline-success btn-lg">Finish</a>
  </div>
</div>
<script>
	var base_url = window.location.origin;
	function edit_author_links() {
		var amazon_link = document.getElementById('amazon_link').value;
		var scribd_link = document.getElementById('scribd_link').value;
		var google_link = document.getElementById('google_link').value;
		var storytel_link = document.getElementById('storytel_link').value;
		var overdrive_link = document.getElementById('overdrive_link').value;
		var pratilipi_link = document.getElementById('pratilipi_link').value;
		var audible_link = document.getElementById('audible_link').value;
		var odilo_link = document.getElementById('odilo_link').value;
		var pinterest_link = document.getElementById('pinterest_link').value;

		$.ajax({
			url: base_url + '/adminv3/edit_author_link_post',
			type: 'POST',
			data:{
				"amazon_link": amazon_link,
				"scribd_link": scribd_link,
				"storytel_link": storytel_link,
				"google_link": google_link,
				"overdrive_link": overdrive_link,
				"pratilipi_link": pratilipi_link,
				"audible_link": audible_link,
				"odilo_link": odilo_link,
				"pinterest_link": pinterest_link,
				"author_id": <?php echo $this->uri->segment(3) ?>
			},
			success: function(data) {
				//alert(data);
				if (data == 1) {
					location.reload();
					alert("Added Links to author Successfully");
				}
			}
		});
	}
</script>