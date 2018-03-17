<div class="x_panel">
	<div class="x_title">
		<h2>New DPH</h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<form method="POST" class="form-horizontal form-label-left">
			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="dph_title">DPH Title <span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <input type="text" id="dph_title" name="dph_title" required="required" class="form-control col-md-7 col-xs-12" value="<?= $value ?>">
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
					<button type="submit" class="btn btn-success">Save DPH</button>
				</div>
			</div>
		</form>
		<div class="ln_solid"></div>
		<table class="table table-bordered" id="datatables">
			<thead>
				<tr>
					<th>No</th>
					<th>DPH</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
					if($cat){
						$no = 0;
						foreach($cat as $row){
							$no++;
				?>
							<tr>
								<td><?= $no ?></td>
								<td align="center"><?= $row->dph_title ?></td>
								<td>
									<?= anchor("administrator/all_dph/edit/".$row->dph_id, '<span class="label label-warning">Edit</span>') ?> 
									<?= anchor("administrator/all_dph/del/".$row->dph_id, '<span class="label label-danger">Delete</span>',array('onclick' => "return confirm('Do you want delete this record')")) ?>
								</td>
							</tr>
				<?php
						}
					}
				?>
			</tbody>
		</table>
	</div>
</div>