<?php

	$data_mod = $latest_post->result();
	
// var_dump($kegiatan_mod->result());
?>

<section class="main-section">
	<div class="container mobile-pad-0">
		<div class="col-md-12">
			<div class="featured" id="featured">
				<div class="featured-sec" id="featured-sec" name="Featured Posts">
					<div class="widget HTML" data-version="1" id="HTML2">
						<div class="widget-content">
							<div class="feat-align feat-column1">
								<div class="hot-item item1">
									<div class="featured-inner">
										<a class="rcp-thumb" href="<?php echo base_url('home/post/'.$data_mod[0]->post_id); ?>">
											<span class="featured-overlay"></span>
											<img class="img-utama lazy-hidden" data-lazy-src="<?= base_url('uploads/'.$data_mod[0]->post_image); ?>" />
										</a>
										<div class="post-panel">
											<a class="post-tag" href="<?php echo base_url('home/category/'.$data_mod[0]->category_id); ?>"><?= $data_mod[0]->category_title ?></a>
											<h3 class="rcp-title">
												<a href="<?php echo base_url('home/post/'.$data_mod[0]->post_id); ?>"><?= $data_mod[0]->post_title ?></a>
											</h3>
										</div>
									</div>
								</div>
							</div>
							<div class="feat-align feat-column2">
								<div class="hot-item item2">
									<div class="featured-inner">
										<a class="rcp-thumb" href="<?php echo base_url('home/post/'.$data_mod[1]->post_id); ?>">
											<span class="featured-overlay"></span>
											<img class="img-utama lazy-hidden" data-lazy-src="<?= base_url('uploads/'.$data_mod[1]->post_image); ?>" />
										</a>
										<div class="post-panel">
											<a class="post-tag" href="<?php echo base_url('home/category/'.$data_mod[1]->category_id); ?>"><?= $data_mod[1]->category_title ?></a>
											<h3 class="rcp-title">
												<a href="<?php echo base_url('home/post/'.$data_mod[1]->post_id); ?>"><?= $data_mod[1]->post_title ?></a>
											</h3>
										</div>
									</div>
								</div>
								<div class="hot-item item3">
									<div class="featured-inner">
										<a class="rcp-thumb" href="<?php echo base_url('home/post/'.$data_mod[2]->post_id); ?>">
											<span class="featured-overlay"></span>
											<img class="img-utama lazy-hidden" data-lazy-src="<?= base_url('uploads/'.$data_mod[2]->post_image); ?>" />
										</a>
										<div class="post-panel">
											<a class="post-tag"><?= $data_mod[2]->category_title ?></a>
											<h3 class="rcp-title">
												<a href="<?php echo base_url('home/post/'.$data_mod[2]->post_id); ?>"><?= $data_mod[2]->post_title ?></a>
											</h3>
										</div>
									</div>
								</div>
							</div>
							<div class="feat-align feat-column4">
								<div class="hot-item item4">
									<div class="featured-inner">
										<a class="rcp-thumb" href="<?php echo base_url('home/post/'.$data_mod[3]->post_id); ?>">
											<span class="featured-overlay"></span>
											<img class="img-utama lazy-hidden" data-lazy-src="<?= base_url('uploads/'.$data_mod[3]->post_image); ?>" />
										</a>
										<div class="post-panel">
											<a class="post-tag" href="<?php echo base_url('home/category/'.$data_mod[3]->category_id); ?>"><?= $data_mod[3]->category_title ?></a>
											<h3 class="rcp-title">
												<a href="<?php echo base_url('home/post/'.$data_mod[3]->post_id); ?>"><?= $data_mod[3]->post_title ?></a>
											</h3>
										</div>
									</div>
								</div>
								<div class="hot-item item5">
									<div class="featured-inner">
										<a class="rcp-thumb" href="<?php echo base_url('home/post/'.$data_mod[4]->post_id); ?>">
											<span class="featured-overlay"></span>
											<img class="img-utama lazy-hidden" data-lazy-src="<?= base_url('uploads/'.$data_mod[4]->post_image); ?>" />
										</a>
										<div class="post-panel">
											<a class="post-tag" href="<?php echo base_url('home/category/'.$data_mod[4]->category_id); ?>"><?= $data_mod[4]->category_title ?></a>
											<h3 class="rcp-title">
												<a href="<?php echo base_url('home/post/'.$data_mod[4]->post_id); ?>"><?= $data_mod[4]->post_title ?></a>
											</h3>
										</div>
									</div>
								</div>
							</div>
							<div class="clear"></div>
						</div>
					</div>
				</div>
			</div>				
		</div>
	</div>	
</section>

<section class="content-below">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="col-md-9">
					<h3>Liputan</h3>
					<div class="row pb-20">
						<?php foreach($liputan->result() as $liputan) { ?>
	                        <div class="col-md-3 col-sm-12 pb-20">
	                            <figure class="category-item-wrapper margin-0">
	                                <a class="category-section-link" href="<?= base_url('home/post/'.$liputan->post_id); ?>">
	                                    <img class="category-figure lazy-hidden" data-lazy-src="<?= base_url('uploads/'.$liputan->post_image); ?>" alt="">
	                                </a>
	                            </figure>
	                            <h4 class="category-frontpage-title pt-20 margin-0">
	                                <a class="hover-underline" href="<?= base_url('home/post/'.$liputan->post_id); ?>"><?= $liputan->post_title ?></a>
	                            </h4>
	                        </div>
                        <?php } ?>
					</div>
					<div class="row">
	                    <div class="col-md-12 col-sm-12 pb-20">
							<div class="text-right mobile-text-center pb-20">
								<a href="<?php echo base_url('home/category/10'); ?>" class="category-to-index-frontpage">Lihat liputan lainnya</a>                        
							</div>
						</div>					
					</div>					
					<h3>Serba Serbi</h3>
					<div class="row pb-20">
						<?php foreach($serba_serbi->result() as $serba_serbi) { ?>
	                        <div class="col-md-3 col-sm-12 pb-20">
	                            <figure class="category-item-wrapper margin-0">
	                                <a class="category-section-link" href="<?= base_url('home/post/'.$serba_serbi->post_id); ?>">
	                                    <img class="category-figure lazy-hidden" data-lazy-src="<?= base_url('uploads/'.$serba_serbi->post_image); ?>" alt="">
	                                </a>
	                            </figure>
	                            <h4 class="category-frontpage-title pt-20 margin-0">
	                                <a class="hover-underline" href="<?= base_url('home/post/'.$serba_serbi->post_id); ?>"><?= $serba_serbi->post_title ?></a>
	                            </h4>
	                        </div>
                        <?php } ?>
					</div>
					<div class="row">
	                    <div class="col-md-12 col-sm-12 pb-20">
							<div class="text-right mobile-text-center pb-20">
								<a href="<?php echo base_url('home/category/12'); ?>" class="category-to-index-frontpage">Lihat serba-serbi lainnya</a>                        
							</div>
						</div>					
					</div>
					<h3>Pengalaman Iman</h3>
					<div class="row pb-20">
						<?php foreach($pengalaman->result() as $pengalaman) { ?>
	                        <div class="col-md-3 col-sm-12 pb-20">
	                            <figure class="category-item-wrapper margin-0">
	                                <a class="category-section-link" href="<?= base_url('home/post/'.$pengalaman->post_id); ?>">
	                                    <img class="category-figure lazy-hidden" data-lazy-src="<?= base_url('uploads/'.$pengalaman->post_image); ?>" alt="">
	                                </a>
	                            </figure>
	                            <h4 class="category-frontpage-title pt-20 margin-0">
	                                <a class="hover-underline" href="<?= base_url('home/post/'.$pengalaman->post_id); ?>"><?= $pengalaman->post_title ?></a>
	                            </h4>
	                        </div>
                        <?php } ?>
					</div>
					<div class="row">
	                    <div class="col-md-12 col-sm-12 pb-20">
							<div class="text-right mobile-text-center pb-20">
								<a href="<?php echo base_url('home/category/11'); ?>" class="category-to-index-frontpage">Lihat pengalaman lainnya</a>                        
							</div>
						</div>					
					</div>
					<div class="row pb-20">
						<div class="col-md-6 col-sm-12 pb-20">
							<h3>Facebook Sanberna</h3>
							<div class="fb-page" data-href="https://www.facebook.com/SantaBernadetCiledug/" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/SantaBernadetCiledug/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/SantaBernadetCiledug/">Santa Bernadet</a></blockquote></div>
						</div>
						<div class="col-md-6 col-sm-12 pb-20">
							<h3>Twitter Sanberna</h3>
							<div class="intrinsic-container intrinsic-container-16x9">
								<a class="twitter-timeline" data-height="400" data-chrome="nofooter" href="https://twitter.com/st_bernadet">Tweets by st_bernadet</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="pb-20">
						<h4 class="block-title">
							<span>Jadwal Misa</span>
						</h4>
						<div class="mass-sch">
							<table class="table-fill">
								<thead>
									<tr>
										<th class="text-left text-bold">Hari</th>
										<th class="text-left text-bold">Jam (Lokasi)</th>
									</tr>
								</thead>
								<tbody class="table-hover">
									<tr>
										<td class="text-left text-bold">Senin</td>
										<td class="text-left">05.45 (Sang Timur)</td>
									</tr>

									<tr>
										<td class="text-left text-bold">Selasa</td>
										<td class="text-left">05.45 (Sang Timur)</td>
									</tr>
									<tr>
										<td class="text-left"></td>
										<td class="text-left">05.45 (Metro)</td>
									</tr>

									<tr>
										<td class="text-left text-bold">Rabu</td>
										<td class="text-left">05.45 (Sang Timur)</td>
									</tr>
									<tr>
										<td class="text-left"></td>
										<td class="text-left">06.00 (Pinang)</td>
									</tr>

									<tr>
										<td class="text-left text-bold">Kamis</td>
										<td class="text-left">05.45 (Sang Timur)</td>
									</tr>
									<tr>
										<td class="text-left"></td>
										<td class="text-left">05.45 (Metro)</td>
									</tr>
									<tr>
										<td class="text-left text-bold">Jumat</td>
										<td class="text-left">05.45 (Sang Timur)</td>
									</tr>
									<tr>
										<td class="text-left"></td>
										<td class="text-left">06.00 (Pinang)</td>
									</tr>
									<tr>
										<td class="text-left text-bold">Jumat 1</td>
										<td class="text-left">19.30 (Pinang)</td>
									</tr>
									<tr>
										<td class="text-left"></td>
										<td class="text-left">19.30 (Metro)</td>
									</tr>
									<tr>
										<td class="text-left text-bold">Sabtu</td>
										<td class="text-left">18.30 (Pinang)</td>
									</tr>
									<tr>
										<td class="text-left text-bold">Minggu</td>
										<td class="text-left">06.00 (Pinang)</td>
									</tr>
									<tr>
										<td class="text-left"></td>
										<td class="text-left">07.00 (Metro)</td>
									</tr>
									<tr>
										<td class="text-left"></td>
										<td class="text-left">08.30 (Pinang)</td>
									</tr>
									<tr>
										<td class="text-left"></td>
										<td class="text-left">17.00 (Metro)</td>
									</tr>
									<tr>
										<td class="text-left text-bold">Minggu 1,3</td>
										<td class="text-left">08.30 (Pd. Lestari)</td>
									</tr>

								</tbody>
							</table>
						  </div>
					</div>	  
					
					<div class="pb-20">
						<h4 class="block-title">
							<span>Kalender Liturgi</span>
						</h4>
						<div class="gg-kl-table icon-table">
							<div class="single-kl-table text-center clearfix">
								<!-- Heading -->
								<div class="mb-10">
									<a href="https://www.imankatolik.or.id" style="text-decoration:none">
										<small>imankatolik.or.id</small>
									</a>									
								</div>
								<div class="kl-table-heading">
									<div class="kl-icon">
										<a href="https://www.imankatolik.or.id/kal_tgl_link.php" target="_blank" rel="noopener">										
											<img border="0" src="https://www.imankatolik.or.id/kal_tgl_img.php" class="center-block img-responsive">
										</a>	
									</div>
								</div>
								<div class="peringatan">
									<a href="https://www.imankatolik.or.id/kal_tgl_link.php" target="_blank" rel="noopener">
										<img src="https://www.imankatolik.or.id/kal_perayaan_img.php" alt="" class="center-block img-responsive">
									</a>
								</div>
								<div class="kl-item">
									<ul>
										<li>
											<a href="https://www.imankatolik.or.id/kal_alkitab_link.php" target="_blank" rel="noopener">
												<img border="0" src="https://www.imankatolik.or.id/kal_alkitab_img.php" />
											</a>
										</li>
										<li>
											<img src="https://www.imankatolik.or.id/kal_warna_img.php" />
										</li>
									</ul>
								</div>
								<!-- Button -->
								<div class="kl-button">
									<a href="https://www.imankatolik.or.id/kalender.php" class="btn btn-kl" target="_blank" rel="noopener">Kalender bulan ini</a>
								</div>
							</div>							
						</div>
					</div>
					<!--<div class="pb-20">-->
					<!--	<h4 class="block-title">-->
					<!--		<span>Radio KAJ</span>-->
					<!--	</h4>-->
					<!--	<audio controls style="width: 100%;">-->
					<!--	  <source src="http://kaj.onlivestreaming.net:9500/stream" type="audio/ogg">-->
					<!--	  <source src="http://kaj.onlivestreaming.net:9500/stream" type="audio/mpeg">-->
					<!--	Your browser does not support the audio element.-->
					<!--	</audio>-->
					<!--</div>-->
				</div>
			</div>
		</div>
	</div>
</section>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v2.10&appId=1952981328318226";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>