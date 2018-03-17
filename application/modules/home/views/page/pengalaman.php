<section class="aboutBrand">
	<div class="container">
		<?php foreach($get_pengalaman->result() as $detail) { ?>
		<header class="head text-center"><h3 class="mt-0"><?php echo $detail->post_title; ?></h3></header>
		<div class="row">
			<div class="col-sm-12 pb-20">
				<div class="pb-20">
					<?php echo $detail->post_content; ?>
				</div>
				<div class="mb-10 f-16 ln-24 mt-5 sp-h5" style="display:inline-block">
					<div class="fbo-2 pr-10 grey fl">Tags <i class='fa fa-tags grey'></i></div>
					<?php 
						$tag = $this->db->query('SELECT DISTINCT posts_tag.tag FROM posts_tag INNER JOIN posts ON posts.post_id = posts_tag.post_id WHERE posts_tag.post_asal = "post" AND posts_tag.post_id = '.$detail->post_id.'')->result();
						foreach ($tag as $data_kode) : ?>
							<h5 class='tagcloud3'>
								<a class='rd2' onclick="filter('<?= $data_kode->tag ?>')" title='<?= $data_kode->tag ?>'><?= $data_kode->tag ?></a>
							</h5>
					<?php endforeach; ?>
					<div class="cl2"></div>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
</section>

<script>
	function filter(tag){
		// alert(tag);
		var filters = "<?php echo site_url('home/filter')?>/"+tag;
		$.ajax({
			url : "<?php echo site_url('home/filter')?>/"+tag,
			type: "POST",
			dataType: "JSON",
			success: function(hasil)
			{
				alert(tag);
				//if success reload ajax table
				//$('#modal_form').modal('hide');
				window.location.href = "<?php echo site_url('home/filter')?>/"+tag;
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				window.location.href = "<?php echo site_url('home/filter')?>/"+tag;
			}
		});
	}
</script>
