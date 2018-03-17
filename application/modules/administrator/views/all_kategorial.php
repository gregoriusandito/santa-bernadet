<div class="x_panel">
	<div class="x_title">
		<h2>Kelompok Kategorial / Dll</h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<table class="table table-bordered" id="datatables">
			<thead>
				<tr>
					<th>No</th>
					<th>Kelompok Kategorial</th>
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
								<td align="center"><?= $row->kategorial_title ?></td>
								<td>
									<?= anchor("administrator/edit_kategorial/".$row->kategorial_id, '<span class="label label-warning">Edit</span>') ?> 
									<?= anchor("administrator/delete_kategorial/".$row->kategorial_id, '<span class="label label-danger">Delete</span>',array('onclick' => "return confirm('Do you want delete this record')")) ?>
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