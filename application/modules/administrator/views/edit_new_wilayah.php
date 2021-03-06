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
					<h2>Edit Wilayah</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="wilayah_title">Nama Wilayah<span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="text" id="wilayah_title" name="wilayah_title" required="required" class="form-control col-md-7 col-xs-12" value="<?= $data_wilayah ? $data_wilayah->wilayah_title: '' ?>" >
						</div>
					</div>
					<div class="form-group">
						<label>Konten Wilayah <span class="required">*</span></label>
						<textarea id="wilayah_content" name="wilayah_content" class="form-control editor-wysiwyg"><?= $data_wilayah ? $data_wilayah->wilayah_content : '' ?></textarea>
					</div>
	
				</div>
			</div>
		</div>
	
		<div class="col-xs-4">
			<div class="x_panel">
				<div class="x_content">
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