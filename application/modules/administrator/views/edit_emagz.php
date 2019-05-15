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
		<div class="col-md-8">
			<div class="x_panel">
				<div class="x_title">
					<h2>Edit e-Magazine</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="form-group">
						<label>e-Magazine Title <span class="required">*</span></label>
						<input type="text" id="post_title" name="post_title" required="required" class="form-control" value="<?= $data_post ? $data_post->post_title: '' ?>">
					</div>

					<!-- TAG FIELD -->
					<div class="form-group">
						<label multiple="multiple">Tags</span>
						</label>
						<div >
							<select  class="form-control col-md-7 col-xs-12 js-tags-post" multiple="multiple" name="post_tags[]" >
								<?php
									$selected = $this->db->select('tag')->where('post_id', $data_post->post_id)->where('post_asal', 'post')->get('posts_tag')->result_array();
									$selected = array_map(function($selected) { return $selected['tag']; },$selected);
									
									$tag = $this->db->select('tag')->group_by('tag')->get('posts_tag')->result_array();
									$tag = array_map(function($tag) { return $tag['tag']; },$tag);

									foreach($tag as $row){
										$isSelected = in_array($row, $selected) ? 'selected' : ''; 
										echo '<option value="'.$row."\" $isSelected >".$row.'</option>';
									}
								?>
							</select>
						</div>
					</div>
					<!-- TAG FIELD -->
	
					<div class="form-group">
						<label>e-Magazine Description <span class="required">*</span></label>
						<textarea id="post_content" name="post_content" class="editor-wysiwyg form-control"><?= $data_post ? $data_post->post_content: '' ?> </textarea>
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
						<label>Category</label>
						<select id="category_id" name="category_id" required="required" class="form-control">
							<option value="">- Chose Category -</option>
							<?php
								$cat = $this->m_crud->get_data('*','categories','')->result();
								if($cat){
									foreach($cat as $row){
										$option_content = ($data_post->category_id == $row->category_id) ? '<option selected value="'.$row->category_id.'">'.$row->category_title.'</option>' : '<option value="'.$row->category_id.'">'.$row->category_title.'</option>' ;
										echo $option_content;
									}
								}
							?>
						</select>
					</div>
					<div class="form-group">
						<label>e-Magazine Content</label>
						<input type="file" name="emagz_file" />
					</div>
 					<div class="form-group" >
						<label>Url e-Magazine saat ini:</label>
						<p><?= base_url().'uploads/'.$data_post->post_emagz_url ?></p>
					</div>
					<div class="form-group">
						<label>Image Content</label>
						<input type="file" name="file" onchange="readURL(this);" />
					</div>
 					<div class="form-group" >
						<label>Gambar saat ini:</label>
					</div>
					<div class="form-group" id="image_display">
						<img id="image" src="<?= base_url().'uploads/'.$data_post->post_image ?>" width="100%"/>
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