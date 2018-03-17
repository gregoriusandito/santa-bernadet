<div class="row">
	<div class="col-xs-8">
		<div class="x_panel">
			<div class="x_title">
				<h2>New Menu</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<form action="<?= base_url() ?>administrator/" method="POST" class="form-horizontal form-label-left">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="menu_title">Menu Title <span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
						  <input type="text" id="menu_title" name="menu_title" required="required" class="form-control col-md-7 col-xs-12">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="menu_type">Menu Type<span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
						  <select id="menu_type" required="required" class="form-control col-md-7 col-xs-12" onchange="showParent();">
							<option value="">- Chose Menu Type -</option>
							<option value="0">Parent</option>
							<option value="1">Child</option>
						  </select>
						</div>
					</div>
					<div class="form-group" id="parent" style="display : none;">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="menu_parent">Menu Parent<span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
						  <select id="menu_parent" name="menu_parent" required="required" class="form-control col-md-7 col-xs-12">
							<option value="">- Chose Parent Menu -</option>
							<?php
								$parent = $this->db->where('menu_parent','0')->get('menu')->result();
								if($parent){
									foreach($parent as $row){
										echo '<option value="'.$row->menu_id.'">'.$row->menu_title.'</option>';
									}
								}
							?>
						  </select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="menu_content">Menu Content<span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
						  <select id="menu_content" required="required" class="form-control col-md-7 col-xs-12" onchange="showParent();">
							<option value="">- Chose Menu Content -</option>
							<option value="0">Custom</option>
							<option value="1">Post</option>
						  </select>
						</div>
					</div>
					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
							<button type="submit" class="btn btn-success">Save Menu</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="col-xs-4">
		<div class="x_panel">
			<div class="x_title">
				<h2>Menu Preview</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<ul>
					<li><p>Schedule meeting with new client </p>
						<ul>
							<li><p>Schedule meeting with new client </p></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>

<script>
	function showParent(){
		if($('#menu_type').val() == 1){
			$('#parent').show();
		}else{
			$('#menu_parent').val('');
			$('#parent').hide();
		}
	}
</script>