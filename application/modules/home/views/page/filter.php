<section class="aboutBrand">
	<div class="container">
		<div class="col-md-12">
			Tags : <?php print_r($filters_post[0]->tag); ?>
		</div>
		<div class="container">
			<div class="col-md-12">
				<table class="table">
					<?php foreach($filters_post as $filters) { ?>

							<tr>
								<td>
									<?php
										if($filters->post_asal == 'post'){
											switch($filters->category_title){
												case 'Uji Coba' :
													$cat = 'uji_coba';
													break;
												case 'KAJ' :
													$cat = 'kaj';
													break;
												case 'Dewan Paroki' :
													$cat = 'dph';
													break;
												case 'Kategorial' :
													$cat = 'kategorial';
													break;
												case 'Wilayah' :
													$cat = 'wilayah';
													break;
												case 'Pelayanan' :
													$cat = 'pelayanan';
													break;
												case 'Download' :
													$cat = 'download';
													break;
												case 'Lain-lain' :
													$cat = 'lain_lain';
													break;
												case 'Liputan' :
													$cat = 'liputan';
													break;
												case 'Pengalaman Iman' :
													$cat = 'pengalaman';
													break;
												case 'Serba Serbi Gereja' :
													$cat = 'serba_serbi';
													break;
												case 'Gallery' :
														$cat = 'galery';
														break;
												case 'Lowongan Kerja' :
														$cat = 'lowongan_kerja';
														break;
												case 'Kegiatan' :
														$cat = 'kegiatan';
														break;
											}
									?>
									<a href="<?php echo site_url('home') ?>/<?=$cat?>/<?=$filters->post_id?>"><?=$filters->judul?></a>
									<?php
										}else{
									?>
											<a href="<?php echo site_url('home/kaj') ?>/<?=$filters->category_title?>"><?=$filters->judul?></a>
									<?php
										}
									?>
								</td>
							</tr>


					<?php } ?>
				</table>
			</div>
		</div>
	</div>
</section>
