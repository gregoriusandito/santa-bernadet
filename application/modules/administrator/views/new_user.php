<?php
// print_r($this->ion_auth->get_users_groups($user->id)->row()); die;

	if($this->uri->segment(2) == 'edit_user'){
		$groups = $this->ion_auth->get_users_groups($user->id)->row();
		$dph = $this->dph->get_users_dph($user->id)->row();
		$disabled = $this->ion_auth->is_admin()? '': 'disabled';
		$fn = $user->first_name;
		$ln = $user->last_name;
		$email = $user->email;
		$alamat = $user->alamat;
		$phone = $user->phone;
		$hp = $user->hp;
		$pass = '(if changing password)';
		$groups_id = ($groups) ? $groups->id : '';
		$dph_id = ($dph) ? $dph->id : '';
		$file = ($user->foto) ? base_url().'uploads/user/'.$user->foto : '';
		$required = '';
	}else{
		$disabled = '';
		$fn = '';
		$ln = '';
		$email = '';
		$alamat = '';
		$phone = '';
		$hp = '';
		$pass = '*';
		$groups_id = '';
		$dph_id = '';
		$file = '';
		$required = 'required="required"';
	}
?>
<div class="x_panel">
	<div class="x_title">
		<h2>New Users</h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<br>
		<?php echo $message;?>
		<form method="POST" enctype="multipart/form-data" id="demo-form2" class="form-horizontal form-label-left">
			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">First Name <span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="text" id="first-name" name="first_name" required="required" class="form-control col-md-7 col-xs-12" value="<?= $fn ?>">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Last Name <span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="text" id="last-name" name="last_name" required="required" class="form-control col-md-7 col-xs-12" value="<?= $ln ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Email <span class="required">*</span></label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input id="middle-name" class="form-control col-md-7 col-xs-12" type="text" name="email" required="required" <?= $disabled ?> value="<?= $email ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="alamat" class="control-label col-md-3 col-sm-3 col-xs-12">Alamat <span class="required">*</span></label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<textarea <?= $disabled ?> id="alamat" class="form-control col-md-7 col-xs-12" name="alamat" required="required" ><?= $alamat ?></textarea>
				</div>
			</div>

			<div class="form-group">
				<label for="phone" class="control-label col-md-3 col-sm-3 col-xs-12">Telp. Rumah</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input id="phone" class="form-control col-md-7 col-xs-12" type="text" name="phone" <?= $disabled ?> value="<?= $phone ?>">
				</div>
			</div>

			<div class="form-group">
				<label for="hp" class="control-label col-md-3 col-sm-3 col-xs-12">HP</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input id="hp" class="form-control col-md-7 col-xs-12" type="text" name="hp" <?= $disabled ?> value="<?= $hp ?>">
				</div>
			</div>

			<div class="form-group">
				<label for="confirm-password" class="control-label col-md-3 col-sm-3 col-xs-12">User Group </label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<select id="groups_id" <?= (!$this->ion_auth->is_admin()) ? 'disabled' : '' ; ?> name="groups_id" required="required" class="form-control">
						<option value="">- Chose User Group -</option>
						<?php
							$cat = $this->m_crud->get_data('*','groups','')->result();
							if($cat){
								foreach($cat as $row){
									$option_content = ($groups_id == $row->id) ? '<option selected value="'.$row->id.'">'.$row->description.'</option>' : '<option value="'.$row->id.'">'.$row->description.'</option>' ;
									echo $option_content;
								}
							}
						?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="confirm-password" class="control-label col-md-3 col-sm-3 col-xs-12">DPH </label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<select id="dph_id" <?= (!$this->ion_auth->is_admin()) ? 'disabled' : '' ; ?> name="dph_id" class="form-control">
						<option value="">- Chose DPH -</option>
						<?php
							$cat = $this->m_crud->get_data('*','master_dph','')->result();
							if($cat){
								foreach($cat as $row){
									$option_content = ($dph_id == $row->dph_id) ? '<option selected value="'.$row->dph_id.'">'.$row->dph_title.'</option>' : '<option value="'.$row->dph_id.'">'.$row->dph_title.'</option>' ;
									echo $option_content;
								}
							}
						?>
					</select>
				</div>
			</div>


			
			<div class="form-group">
				<label for="password" class="control-label col-md-3 col-sm-3 col-xs-12">Password <span class="required"><?= $pass ?></span></label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input id="password" class="form-control col-md-7 col-xs-12" type="password" name="password" <?= $required ?>>
				</div>
			</div>
			<div class="form-group">
				<label for="confirm-password" class="control-label col-md-3 col-sm-3 col-xs-12">Confirm Password <span class="required"><?= $pass ?></span></label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input id="confirm-password" class="form-control col-md-7 col-xs-12" type="password" name="password_confirm" <?= $required ?>>
					<span class="text-danger" id="hint-pass"></span>
				</div>
			</div>

			<!-- ////////////////////////////////////////////////////////////// -->
			<div class="form-group">
				<label for="hp" class="control-label col-md-3 col-sm-3 col-xs-12">User Photo</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="file" name="file" class="form-control col-md-7 col-xs-12" onchange="readURL(this);" />
				</div>
				<!-- Display -->
				<div class="col-md-6 col-sm-6 col-xs-12  col-md-offset-3 col-sm-offset-3" id="image_display">
					<img <?= ($file == '')? 'hidden="hidden"' : '' ?> src="<?= $file ?>" id="image" width="100%"/>
				</div>
			</div>
			<!-- ////////////////////////////////////////////////////////////// -->


			<div class="ln_solid"></div>
			<div class="form-group">
				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
					<a href="<?= base_url() ?>administrator/all_users" class="btn btn-primary">Cancel</a>
					<button type="submit" class="btn btn-success">Submit</button>
				</div>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
	$('#password').keyup(function(){
		if( $(this).val() !== $('#confirm-password').val() )
		{
			$('#hint-pass').html('Your password and confirmation password do not match.');	
		}
		else
		{
			$('#hint-pass').html('');	
		}
	});

	$('#confirm-password').keyup(function(){
		if( $(this).val() !== $('#password').val() )
		{
			$('#hint-pass').html('Your password and confirmation password do not match.');	
		}
		else
		{
			$('#hint-pass').html('');	
		}
	});
</script>



<script>
	function readURL(input) {
	  if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			$('#image').show();
			$('#image').attr('src', e.target.result);
		};
		reader.readAsDataURL(input.files[0]);
	  }
	}
</script>