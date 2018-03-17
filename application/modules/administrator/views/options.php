<?php
	$option = $this->db->get('options')->result();
	foreach($option as $row){
		$data[] = $row;
	}
?>
<div class="x_panel">
	<div class="x_title">
		<h2>Website Setting</h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<?= $this->session->flashdata('msg') ?>
		<br>
		<div class="" role="tabpanel" data-example-id="togglable-tabs">
		  <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
			<li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">General</a>
			</li>
			<li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Company</a>
			</li>
			<li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Logo</a>
			</li>
			<li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Social Media</a>
			</li>
		  </ul>
		  <div id="myTabContent" class="tab-content">
			<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
				<form action="<?= base_url() ?>administrator/update_website_option" method="POST" class="form-horizontal form-label-left">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="sitename">Website Name <span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
						  <input type="text" id="sitename" name="sitename" required="required" class="form-control col-md-7 col-xs-12" value="<?= $data[0]->option_value ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="sitedescription">Website Description <span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
						  <textarea id="sitedescription" name="sitedescription" required="required" class="form-control" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10"><?= strip_tags($data[1]->option_value) ?></textarea>
						</div>
					</div>
					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
							<button type="submit" class="btn btn-success">Save Change</button>
						</div>
					</div>
				</form>
			</div>
			<div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
				<form action="<?= base_url() ?>administrator/update_website_option" method="POST" class="form-horizontal form-label-left">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="office">Office <span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
						  <textarea id="office" name="office" required="required" class="form-control" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10"><?= $data[2]->option_value ?></textarea>
						  <!--<input type="text" id="office" name="office" required="required" value="<?= $data[2]->option_value ?>" class="form-control col-md-7 col-xs-12">-->
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="about">About <span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
						  <textarea id="about" name="about" required="required" class="form-control" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10"><?= strip_tags($data[3]->option_value) ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="contact">Contact <span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
						  <textarea id="contact" name="contact" required="required" class="form-control" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10"><?= strip_tags($data[8]->option_value) ?></textarea>
						</div>
					</div>
					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
							<button type="submit" class="btn btn-success">Save Change</button>
						</div>
					</div>
				</form>
			</div>
			<div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
				<div style="text-align : center">
				<img src="<?= base_url() ?>uploads/company/logo.png" width="30%"/><br><br>
				</div>
				<form action="<?= base_url() ?>administrator/upload_logo" enctype="multipart/form-data" method="POST" class="form-horizontal form-label-left">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="sitename">Company Logo <span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
						  <input type="file" name="file" class="form-control">
						</div>
					</div>
					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
							<button type="submit" class="btn btn-success">Save Change</button>
						</div>
					</div>
				</form>
			</div>
			<div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profile-tab">
				<form action="<?= base_url() ?>administrator/update_website_option" method="POST" class="form-horizontal form-label-left">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="facebook">Facebook
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
						  <input type="text" id="facebook" name="facebook" class="form-control col-md-7 col-xs-12" value="<?= $data[4]->option_value ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="twitter">Twitter
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
						  <input type="text" id="twitter" name="twitter" class="form-control col-md-7 col-xs-12" value="<?= $data[5]->option_value ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="instagram">Instagram
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
						  <input type="text" id="instagram" name="instagram" class="form-control col-md-7 col-xs-12" value="<?= $data[6]->option_value ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="youtube">Youtube
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
						  <input type="text" id="youtube" name="youtube" class="form-control col-md-7 col-xs-12" value="<?= $data[7]->option_value ?>">
						</div>
					</div>
					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
							<button type="submit" class="btn btn-success">Save Change</button>
						</div>
					</div>
				</form>
			</div>
		  </div>
		</div>
	</div>
</div>