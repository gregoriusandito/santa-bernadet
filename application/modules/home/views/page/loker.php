<script>
	function detailLoker(i){
		var listLoker;
		$.ajax({
			dataType : 'json',
			type : 'GET',
			url: '<?= base_url() ?>home/detail_loker?post_id='+i,
			success: function(data){
				var itemsLoker = data
				// for(i = 0; i < items.length; i++){
					// var item = items[i];
					// listLoker += '<tr>';
					// listLoker += '<td>'+itemsLoker.post_content+'</td>';
					// listLoker += '</tr>';
				// }
				$('#listLoker').html(listLoker);
				$('#lokerTitle').html(itemsLoker.post_title);
				$('#post_id').html(i);
				$('#myModal2').modal("show");
			}
		});
	}
</script>
<style>
div.scroll {
    background-color: #FFF;
    width: 100px;
    height: 350px;
    overflow: scroll;
}

div.hidden {
    background-color: #00FF00;
    width: 100px;
    height: 100px;
    overflow: hidden;
}
</style>
<section class="xvPortfolio styleLg">
    <div class="container">
			
		<ul class="portfolioWrap custom-filter-elements clearfix">
		<?php foreach ($loker->result() as $loker){ ?>
			<li class="portfolioItem filter-active filter-item filter1">
				<div class="folioInner">
					<div class="visual imgAsBG">
						<img src="<?php echo base_url('uploads/'.$loker->post_image); ?>" alt="asd">
						<div class="folioLay"></div></div>
					<div class="folioInfo">
						<div class="infoInner scroll">
							<h5><?= $loker->post_title ?></h5>
							<!--<ul class="tag">
								<li>fashion</li>
								<li>business</li>
							</ul>-->
							<p><?= $loker->post_content ?></p>
							<!--<ul class="stats">
								<li><a href="#" onclick="detailLoker('<?//=$loker->post_id?>');"><i class="xv-basic_eye"></i>detail</a></li>
							</ul>-->
						</div>
					</div>
				</div>
			</li>
		<?php } ?>
		</ul>
	</div>
</section>

<!-- Modal -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel3"><h4><span id="lokerTitle"></span></h4></h4>
      </div>
      <div class="modal-body">
		<table class="table">
			<tbody id="listLoker"></tbody>
		</table>
      </div>
      <div class="modal-footer">

      </div>
    </div>
  </div>
</div>
