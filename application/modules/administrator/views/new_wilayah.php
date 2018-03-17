<div class="row">
	<div class="col-xs-8">
		<div class="x_panel">
			<div class="x_title">
				<h2>Wilayah & Lingkungan</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<form action="<?= base_url() ?>administrator/new_wilayah" method="POST" class="form-horizontal form-label-left">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="wilayah_title">Nama Wilayah & Lingkungan<span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="text" id="wilayah_title" name="wilayah_title" required="required" class="form-control col-md-7 col-xs-12">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="wilayah_type">Type Wilayah & Lingkungan<span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<select id="wilayah_type" required="required" class="form-control col-md-7 col-xs-12" onchange="showParent();">
								<option value="">- Chose Wilayah & Lingkungan Type -</option>
								<option value="0">Parent</option>
								<option value="1">Child</option>
							</select>
						</div>
					</div>
					<div class="form-group" id="parent" style="display : none;">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="wilayah_parent">Wilayah & Lingkungan Parent<span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<select id="wilayah_parent" name="wilayah_parent" class="form-control col-md-7 col-xs-12">
								<option value="">- Chose Parent Wilayah & Lingkungan -</option>
								<?php
								$parent = $this->db->where('wilayah_parent','0')->get('wilayah')->result();
								if($parent){
									foreach($parent as $row){
										echo '<option value="'.$row->wilayah_id.'">'.$row->wilayah_title.'</option>';
									}
								}
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="wilayah_user">User<span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<select id="wilayah_user" name="user_id" class="form-control col-md-7 col-xs-12">
								<option value="">- Chose User -</option>
								<?php
								$user = $this->db->query('select * from users u where u.id NOT in(select w.user_id from wilayah w where w.user_id = u.id);')->result();
								if($user){
									foreach($user as $row){
										echo '<option value="'.$row->id.'">'.$row->first_name.' '.$row->last_name.'</option>';
									}
								}
								?>
							</select>
						</div>
					</div>
					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
							<button type="submit" class="btn btn-success">Save</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="col-xs-4">
		<div class="x_panel">
			<div class="x_title">
				<h2>Wilayah & Lingkungan</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<ul>
					<?php
						$parent = $this->db->where('wilayah_parent','0')->get('wilayah')->result();
					?>
					<?php if ($parent): ?>
						<?php foreach ($parent as $row): ?>
							<li>
								<p><?= $row->wilayah_title ?> </p>
								<ul>
									<?php $child = $this->db->where('wilayah_parent',$row->wilayah_id)->get('wilayah')->result(); ?>
									<?php foreach ($child as $row): ?>
										<li><p><?= $row->wilayah_title  ?> </p></li>
									<?php endforeach ?>
								</ul>
							</li>
						<?php endforeach ?>
					<?php endif ?>

				</ul>
			</div>
		</div>
	</div>


</div>

<script>
	function showParent(){
		if($('#wilayah_type').val() == 1){
			$('#parent').show();
			$("#wilayah_parent").attr('required','required');

		}else{
			$('#wilayah_parent').val('');
			$('#parent').hide();
    		$("#wilayah_parent").removeAttr('required');

		}
	}
</script>