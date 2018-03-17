<div class="x_panel">
	<div class="x_title">
		<h2>Data Slider</h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<table class="table table-bordered" id="datatables">
			<thead>
				<tr>
					<th>No</th>
					<th width="40%">Image Slider</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
					if($slider){
						$no = 0;
						foreach($slider as $row){
							$no++;
				?>
							<tr>
								<td><?= $no ?></td>
								<td><img src="<?= base_url() ?>uploads/slider/<?= $row->img_slider ?>" width="100%"/></td>
								<td align="center"><?php echo ($row->active) ? anchor("administrator/deactivate/".$row->id_slider, "<span class='label label-success'>".lang('index_active_link')."</span>") : anchor("administrator/activate/". $row->id_slider, "<span class='label label-danger'>".lang('index_inactive_link')."</span>");?></td>
								<td><?= anchor("administrator/delete_slider/".$row->id_slider, '<span class="label label-warning">Delete</span>') ?></td>
							</tr>
				<?php
						}
					}
				?>
			</tbody>
		</table>
	</div>
</div>
