<div class="row">
	<div class="col-xs-8">
		<div class="x_panel">
			<div class="x_title">
				<h2>KAJ</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<form action="<?= base_url() ?>administrator/new_kaj" method="POST" class="form-horizontal form-label-left">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="wilayah_title">Judul Sub Folder<span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="text" id="judul_folder" name="judul_folder" class="form-control col-md-7 col-xs-12">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="wilayah_type">Folder Parent<span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<select id="folder_type"  class="form-control col-md-7 col-xs-12" onchange="showParent();">
								<option value="">- Chose Folder Parent -</option>
								<option value="0">Parent</option>
								<option value="1">Child</option>
							</select>
						</div>
					</div>
					<div class="form-group" id="parent" style="display : none;">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="judul_parent">Folder<span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<select id="judul_parent" name="judul_parent" class="form-control col-md-7 col-xs-12">
								<option value="">- Choose Folder -</option>
								<?php
								$parent = $this->db->where('judul_parent','0')->get('kaj')->result();
								if($parent){
									foreach($parent as $row){
										echo '<option value="'.$row->id_kaj.'">'.$row->judul_folder.'</option>';
									}
								}
								?>
							</select>
						</div>
					</div>
					<!-- TAG FIELD -->
					<div class="form-group">
						<label multiple="multiple">Tags</span>
						</label>
						<div >
							<select  class="form-control col-md-7 col-xs-12 js-tags-post" multiple="multiple" name="post_tags[]">
								<?php
								$array = array(1,9);
								$tag = $this->db->group_by('tag')->get('posts_tag')->result();
								// if($parent){
									foreach($tag as $row){
										echo '<option value="'.$row->tag.'">'.$row->tag.'</option>';
									}
								// }
								?>
							</select>
						</div>
					</div>
					<!-- TAG FIELD -->
          <div class="form-group">
						<label>Post Content <span class="required">*</span></label>
						<textarea id="isi_content" name="isi_content" class="form-control editor-wysiwyg"></textarea>
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
		<!-- <div class="x_panel">
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
		</div> -->
	</div>


</div>

<script>
	function showParent(){
		if($('#folder_type').val() == 1){
			$('#parent').show();
			$("#judul_parent").attr('required','required');

		}else{
			$('#folder_type').val('');
			$('#parent').hide();
    		$("#judul_parent").removeAttr('required');

		}
	}
</script>
