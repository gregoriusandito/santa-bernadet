<?php foreach($get_post->result() as $detail) { ?>
	<section class="aboutBrand">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 nopadding mobile-pl-pr-15">
					<h2 class="font-45 mobile-font-24 text-transform-none mt-0"><?php echo $detail->post_title; ?></h2>
				</div>	
			</div>
			<div class="row">
				<div class="col-sm-8 pb-20 nopadding">
					<div class="row pb-10 pl-pr-15">
						<div class="col-sm-12 nopadding mobile-pb-10 mobile-pl-pr-15">
							<span><?= $date ?></span>
						</div>
					</div>
					<div class="row pb-20 pl-pr-15">
						<div class="col-sm-12 nopadding mobile-pb-10 mobile-pl-pr-15">
							<div class="socmed-post-sharer-align">	
		                        <ul class="header-sharer-list v-align-top">
		                        	<li class="inline-block v-align-top socmed-wrapper socmed-share-to-text"><span>Bagikan ke:</span></li>
		                            <li class="inline-block v-align-top socmed-wrapper fb-post-sharer"><a class="header-sharer-list-link text-center" href="<?= $fb_share ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
		                            <li class="inline-block v-align-top socmed-wrapper twit-post-sharer"><a class="header-sharer-list-link text-center" href="<?= $twit_share ?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
		                            <li class="inline-block v-align-top socmed-wrapper wa-post-sharer"><a class="header-sharer-list-link text-center" href="<?= $wa_share ?>" target="_blank"><i class="fa fa-whatsapp" aria-hidden="true"></i></a></li>
		                        </ul>   						
							</div>														
						</div>
					</div>	
					<div class="pb-20">	
						<img src="<?= base_url('uploads/'.$detail->post_image); ?>" alt="<?php echo $detail->post_title; ?>">
					</div>
					<div class="pl-pr-15">
						<div class="pb-20">
							<?php echo htmlspecialchars_decode($detail->post_content); ?>
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
				<div class="col-sm-4 pb-20">
					<div class="pb-20">
						<h4 class="block-title mt-0">
							<span>Facebook Sanberna</span>
						</h4>
						<div class="fb-page" data-href="https://www.facebook.com/SantaBernadetCiledug/" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/SantaBernadetCiledug/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/SantaBernadetCiledug/">Santa Bernadet</a></blockquote></div>						
					</div>	
					<div class="pb-20">
						<h4 class="block-title">
							<span>Twitter Sanberna</span>
						</h4>
						<a class="twitter-timeline" href="https://twitter.com/st_bernadet">Tweets by st_bernadet</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
					</div>
				</div>	
			</div>
		</div>
	</section>
<?php } ?>

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
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v2.10&appId=1952981328318226";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>