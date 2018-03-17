<?php if (validation_errors()): ?>
<div class="col-sm-12">
	<div class="row alert alert-danger alert-dismissible fade in" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">×</span>
		</button>
		<?= validation_errors()  ?>
	</div>
</div>
<?php endif ?>

<div class="row">
	<form method="POST" enctype="multipart/form-data" class="form-horizontal form-label-left">
		<div class="col-xs-8">
			<div class="x_panel">
				<div class="x_title">
					<h2>Edit Seksi</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="seksi_title">Nama Seksi<span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="text" id="seksi_title" name="seksi_title" required="required" class="form-control col-md-7 col-xs-12" value="<?= $data_seksi ? $data_seksi->seksi_title: '' ?>" >
						</div>
					</div>
					<div class="form-group">
						<label>Konten Seksi <span class="required">*</span></label>
						<textarea id="seksi_content" name="seksi_content" class="form-control editor-wysiwyg"><?= $data_seksi ? $data_seksi->seksi_content : '' ?></textarea>
					</div>
	
				</div>
			</div>
		</div>
	
		<div class="col-xs-4">
			<div class="x_panel">
				<div class="x_content">
					<div class="form-group">
						<label>Gambar Utama</label>
						<input type="file" name="seksi_file" onchange="readURL(this);" />
					</div>
					<div class="form-group" id="image_display">
						<img id="seksi-image" src="<?= base_url().'uploads/'.$data_seksi->seksi_image ?>" width="100%"/>
					</div>
					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<button type="submit" class="btn btn-success">Save</button>
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
			$('#seksi-image').show();
			$('#seksi-image').attr('src', e.target.result);
		};
		reader.readAsDataURL(input.files[0]);
	  }
	}

</script>