
<div class="x_panel">
	<div class="x_title">
		<h2>Data Profile</h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<table class="table table-bordered" id="datatables">
			<thead>
				<tr>
					<th>No</th>
					<th width="40%">Profile Title</th>
					<th>Profile Author</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
					if($content){
						$no = 0;
						foreach($content as $row){
							$no++;
				?>
							<tr>
								<td><?= $no ?></td>
								<td><?= $row->profile_title ?></td>
								<td><?= $row->first_name.' '.$row->last_name  ?></td>
								<td align="center">
									<?php 
									echo ($row->profile_status) ? anchor("administrator/activate_profiles/".$row->profile_id."/0", "<span class='label label-success'>".lang('index_active_link')."</span>") : anchor("administrator/activate_profiles/". $row->profile_id."/1", "<span class='label label-danger'>".lang('index_inactive_link')."</span>");
									?>
										
								</td>
								<td>
									<?php if ($this->ion_auth->is_admin() && ($this->ion_auth->user()->row()->id == $row->profile_author)): ?>
										<?= anchor("administrator/edit_profiles/".$row->profile_id, '<span class="label label-warning">Edit</span>') ?> 
										<?= anchor("administrator/delete_profiles/".$row->profile_id, '<span class="label label-danger">Delete</span>',array('onclick' => "return confirm('Do you want delete this record')")) ?>
									<?php else: ?>
										<span class="label label-default">Edit</span> 
										<span class="label label-default">Delete</span>
									<?php endif ?>

										
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
	
