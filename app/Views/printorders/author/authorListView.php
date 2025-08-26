<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 
<div id="content" class="main-content">
	<div class="layout-px-spacing">
		<div class="page-header">
			<div class="page-title">
				<h6 class="text-center">POD Author Order-Author Selection </h6>
			</div>
		</div>

		<table class="zero-config table table-hover mt-4" style="font-size:13px;">
			<thead>
				<th style="padding:6px 8px;">Author ID</th>
				<th style="padding:6px 8px;">Author Name</th>
				<th class="text-center" style="padding:6px 8px;">Actions</th>
			</thead>
			<tbody>
				<?php for ($i = 0; $i < count($orderbooks); $i++) { ?>
					<tr>
						<td style="padding:6px 8px;"><?php echo $orderbooks[$i]['author_id'] ?></td>
						<td style="padding:6px 8px;"><?php echo $orderbooks[$i]['author_name'] ?></td>
						<td class="text-center" style="padding:6px 8px;">
							<a href="<?php echo base_url()."paperback/authororderbooks/".$orderbooks[$i]['author_id'] ?>" 
							   class="btn btn-success" 
							   style="padding:2px 8px; font-size:12px; border-radius:4px;">
								Select
							</a>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<br><br>
	</div>
</div>
<?= $this->endSection(); ?>
