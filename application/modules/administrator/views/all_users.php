<div class="x_panel">
	<div class="x_title">
		<h2>Data Users</h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<table class="table table-bordered" id="datatables">
			<thead>
				<tr>
					<th><?php echo lang('index_fname_th');?></th>
					<th><?php echo lang('index_lname_th');?></th>
					<th><?php echo lang('index_email_th');?></th>
					<th><?php echo lang('index_groups_th');?></th>
					<th><?php echo lang('index_status_th');?></th>
					<th><?php echo lang('index_action_th');?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($all_users as $user):?>
					<tr>
						<td><?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?></td>
						<td><?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?></td>
						<td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
						<td><?php echo htmlspecialchars($user->groups[0]->name,ENT_QUOTES,'UTF-8');?></td>
						<td align="center">
							<?php if ($this->ion_auth->is_admin()): ?>
								<?php echo ($user->active) ? anchor("administrator/deactivate/".$user->id, "<span class='label label-success'>".lang('index_active_link')."</span>") : anchor("administrator/activate/". $user->id, "<span class='label label-danger'>".lang('index_inactive_link')."</span>");?>	
							<?php else: ?>
								<?php echo ($user->active) ? '<span class="label label-default">Active</span>' : '<span class="label label-default">Inactive</span>' ;?>	
							<?php endif ?>			
						</td>
						<td>
							<?php if ($this->ion_auth->is_admin() || ($this->ion_auth->user()->row()->id == $user->id)): ?>
								<?php echo anchor("administrator/edit_user/".$user->id, '<span class="label label-warning">Edit</span>') ;?>
							<?php else: ?>
								<span class="label label-default">Edit</span>
							<?php endif ?>
						</td>

					</tr>
				<?php endforeach;?>
			</tbody>
		</table>
	</div>
</div>
