<div class="x_panel">
	<div class="x_title">
		<h2>All Post</h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<table class="table table-bordered" id="datatables">
			<thead>
				<tr>
					<th>No</th>
					<th>Post Title</th>
					<th>Post Author</th>
					<th>Category</th>
					<th>Created On</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
					if($post){
						$no = 0;
						foreach($post as $row){
							$no++;
				?>
							<tr>
								<td><?= $no ?></td>
								<td><?= $row->post_title ?></td>
								<td><?= $row->first_name.' '.$row->last_name  ?></td>
								<td><?= $row->category_title  ?></td>
								<td><?= date('d M Y H:i', strtotime($row->post_created))  ?></td>
								<td align="center">
									<?php 
									echo ($row->post_status) ? anchor("administrator/activate_post/".$row->post_id."/0", "<span class='label label-success'>".lang('index_active_link')."</span>") : anchor("administrator/activate_post/". $row->post_id."/1", "<span class='label label-danger'>".lang('index_inactive_link')."</span>");
									?>
										
								</td>
								<td align="center">
									<?php // anchor("administrator/all_category/edit/".$row->category_id, '<span class="label label-warning">Edit</span>') ?> 
									<?php // anchor("administrator/all_category/del/".$row->category_id, '<span class="label label-danger">Delete</span>') ?>

									<?php if ($this->ion_auth->is_admin() || ($this->ion_auth->user()->row()->id == $row->post_author)): ?>
										<?= anchor("administrator/edit_post/".$row->post_id, '<span class="label label-warning">Edit</span>') ?> 
										<?= anchor("administrator/delete_post/".$row->post_id, '<span class="label label-danger">Delete</span>',array('onclick' => "return confirm('Do you want delete this record')")) ?>
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