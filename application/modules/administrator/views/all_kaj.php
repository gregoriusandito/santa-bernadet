<div class="x_panel">
	<div class="x_title">
		<h2>All Kaj</h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<table class="table table-bordered" id="datatables">
			<thead>
				<tr>
					<th>No</th>
					<th>Judul Folder</th>
					<th>Parent Folder</th>
					<!-- <th>User</th> -->
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
								<td align="center"><?= $row->judul_folder ?></td>
								<td align="center"><?= $row->judul_parent ?></td>
								<!-- <td align="center"><?= $row->first_name.' '.$row->last_name ?></td> -->
								<td>
									<?= anchor("administrator/edit_kaj/".$row->id_kaj, '<span class="label label-warning">Edit</span>') ?>
									<?= anchor("administrator/delete_kaj/".$row->id_kaj, '<span class="label label-danger">Delete</span>',array('onclick' => "return confirm('Do you want delete this record')")) ?>
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
