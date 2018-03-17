<?php if (validation_errors()): ?>
<div class="col-sm-12">	
	<div class="row alert alert-danger alert-dismissible fade in" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">×</span>
		</button>
		<!-- <strong>Holy guacamole!</strong> Best check yo self, you're not looking too good. -->
		<?= validation_errors()  ?>
	</div>
</div>
<?php endif ?>

<div class="row">
	<form method="POST" enctype="multipart/form-data" class="form-horizontal form-label-left">
		<div class="col-md-8">
			<div class="x_panel">
				<div class="x_title">
					<h2>Edit Profiles</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="form-group">
						<label>Profile Title <span class="required">*</span></label>
						<input type="text" id="profile_title" name="profile_title" required="required" class="form-control" value="<?= $data_profiles ? $data_profiles->profile_title: '' ?>">
					</div>
					<div class="form-group">
						<label>Profile Content <span class="required">*</span></label>
						<textarea id="profile_content" name="profile_content" class="editor-wysiwyg form-control"><?= $data_profiles ? $data_profiles->profile_content: '' ?> </textarea>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="x_panel">
				<div class="x_title">
					<h2>Action</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="form-group">
						<label>Image Content</label>
						<input type="file" name="file" onchange="readURL(this);" />
					</div>
<!-- 					<div class="form-group" >
						<img id="profile_image" src="<?= base_url().'uploads/'.$data_profiles->profile_image ?>" width="100%"/>
					</div> -->
					<div class="form-group" id="image_display">
						<img id="image" src="<?= base_url().'uploads/'.$data_profiles->profile_image ?>" width="100%"/>
					</div>
					<div class="ln_solid"></div>
					<div class="form-group">
						<div>
							<button type="submit" class="btn btn-success">Publish</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
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