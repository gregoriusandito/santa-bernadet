<div class="x_panel">
	<div class="x_title">
		<h2>New Category</h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<form method="POST" class="form-horizontal form-label-left">
			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_title">Category Title <span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <input type="text" id="category_title" name="category_title" required="required" class="form-control col-md-7 col-xs-12" value="<?= $value ?>">
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
					<button type="submit" class="btn btn-success">Save Category</button>
				</div>
			</div>
		</form>
		<div class="ln_solid"></div>
		<table class="table table-bordered" id="datatables">
			<thead>
				<tr>
					<th>No</th>
					<th>Category</th>
					<th>Permission</th>
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
					<td align="center"><?= $row->category_title ?></td>
					<td align="center">
						<?php echo ( $row->category_type == 0 ) ? anchor("administrator/set_category/".$row->category_id.'/1', "<span class='label label-success'>".'Only Admin'."</span>") : anchor("administrator/set_category/". $row->category_id."/0", "<span class='label label-primary'>".'All Users'."</span>");?>	
					</td>	
					<td>
						<?= anchor("administrator/all_category/edit/".$row->category_id, '<span class="label label-warning">Edit</span>') ?> 
						<?= anchor("administrator/all_category/del/".$row->category_id, '<span class="label label-danger">Delete</span>',array('onclick' => "return confirm('Do you want delete this record')")) ?>
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