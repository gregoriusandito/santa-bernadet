<?php
	$option = $this->db->get('options')->result();
?>
<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js gt-ie8"><!--<![endif]-->
<head>
<meta charset="utf-8">
<title><?= $option[0]->option_value ?></title>

<!--=================================
Meta tags
=================================-->
<meta name="description" content="Website Resmi Paroki Santa Bernadet Ciledug">
<meta content="yes" name="apple-mobile-web-app-capable" />
<meta name="viewport" content="minimum-scale=1.0, width=device-width, maximum-scale=1, user-scalable=yes" />
<meta name="theme-color" content="#181818">
<meta name="author" content="Santa Bernadet">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php

if ( isset($og) && isset($card) ) :
	echo $og;
	echo $card;
endif;	

?>
<!--=================================
Style Sheets
=================================-->
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=PT+Serif:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700" rel="stylesheet" type="text/css">
<link href='https://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Hind|Playfair+Display">

<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/home/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/home/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/home/css/custom.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/home/css/main.css">
<!--LOGO-->
<link rel="icon" href="<?= base_url() ?>assets/home/img/logo/logo-optimized.png" sizes="32x32"/>
<link rel="icon" href="<?= base_url() ?>assets/home/img/logo/logo-optimized.png" sizes="192x192"/>
<link rel="apple-touch-icon-precomposed" href="<?= base_url() ?>assets/home/img/logo/logo-optimized.png"/>
<meta name="msapplication-TileImage" content="<?= base_url() ?>assets/home/img/logo/logo-optimized.png"/>

</head>
<body>
    <div class="bodyWrap">
        <!--====================
         Header
        ====================-->
        <header class="doc-header">
            <div class="topHeader">
                <div class="container hidden-xs">
                	<a href="<?php echo base_url('home'); ?>">
                    	<img src="<?php echo base_url('uploads/company/banner-web 1.png'); ?>" width="100%" />
                	</a>
                </div>
	            <div class="container header-height-100 visible-xs">
	            	<div class="row">
	            		<div class="flex-vertical-center absolute-left">
	            			<div class="image-container-30 pl-10">
	            				<a href="<?php echo base_url('home'); ?>">
	            					<img src="<?php echo base_url('uploads/company/index.jpg'); ?>">
	            				</a>	
	            			</div>
	            		</div>
	            		<div class="flex-vertical-center absolute-right">
	            			<div id="js-mobile-menu" class="menu-container-28 pr-10">
	            				<img src="<?php echo base_url('uploads/menu-burger.png'); ?>">
	            			</div>
	            		</div>
	            	</div>
	            </div>
			</div>
        </header>
        
        <?php if ( !isset($error_state) ) : ?>
			<nav class="bgBlack">
	            <ul class="mainNav mobile hidden">
	                <li><a href="<?php echo base_url('home'); ?>">Beranda</a></li>
	                <li><a href="#">Profil</a>
	                    <ul>
						<?php
							foreach ($profile->result() as $row) {
						?>
	                    	<li><a href="<?php echo base_url('home/profile/'.$row->profile_id.''); ?>"><?= $row->profile_title ?></a></li>
	                    	
						<?php
							}
						?>
						</ul>
	                </li>
					<li class="megaparent"><a href="#">Kaj</a>
	                    <div class="mega-xv mega-black">
	                        <div class="container">
	                            <div class="row">
									<?php foreach($kaj_parent->result() as $parent) { ?>
										<div class="col-xs-12 col-md-3">
											<a href="<?php echo base_url('home/kaj/'.$parent->id_kaj.''); ?>"><h6><?php echo $parent->judul_folder ?></h6></a>
											<ul>
												<?php
	                                                $child = $this->db->query('SELECT * FROM kaj WHERE judul_parent = '.$parent->id_kaj)->result();
	                                                if($child){
	                                                    foreach ($child as $child) {
	                                                        echo '<li><a href="'.base_url('home/kaj/'.$child->id_kaj).'">'.$child->judul_folder.'</a></li>';
	                                                    }
	                                                }
	                                            ?>
											</ul>
										</div>
									<?php } ?>
	                            </div>
	                        </div>
	                    </div>
	                </li>
					<li><a href="#">Dewan Paroki</a>
	                    <ul>
	                    	<li><a href="<?php echo base_url('home/page/1'); ?>">Dewan Paroki Harian</a></li>
	                    	<li><a href="<?php echo base_url('home/page/2'); ?>">Seksi-seksi</a></li>
						</ul>
	                </li>                        
	                <li><a href="<?php echo base_url('home/page/3'); ?>">Kategorial</a>
	                    <?php if (1==2) : ?>
			                <ul>
								<?php
									foreach ($kategorial->result() as $kategorial) {
								?>
			                    	<li><a href="<?php echo base_url('home/kategorial/'.$kategorial->kategorial_id.''); ?>"><?= $kategorial->kategorial_title ?></a></li>
								<?php
									}
								?>
							</ul>
						<?php endif; ?>	
	                </li>
	                <?php if (1==1) : ?>
	                <li><a href="#">Wilayah</a>
	                    <ul>
						<?php
							foreach ($wilayah->result() as $wilayah) {
						?>
	                    	<li><a href="<?php echo base_url('home/new_wilayah/'.$wilayah->wilayah_id.''); ?>"><?= $wilayah->wilayah_title ?></a></li>
						<?php
							}
						?>
						</ul>
	                </li>
	                <?php endif; ?>
	                <li><a href="#">Pelayanan</a>
	                    <ul>
						<?php
							foreach ($pelayanan->result() as $pelayanan) {
						?>
	                    	<li><a href="<?php echo base_url('home/pelayanan/'.$pelayanan->pelayanan_id.''); ?>"><?= $pelayanan->pelayanan_title ?></a></li>
						<?php
							}
						?>
						</ul>
	                </li>
					<?php if (1 == 2) : ?>
						<li><a href="#">Unduhan</a>
		                    <ul>
							<?php
								foreach ($download->result() as $download) {
							?>
		                    	<li><a href="<?php echo base_url('home/download/'.$download->post_id.''); ?>"><?= $download->post_title ?></a></li>
							<?php
								}
							?>
							</ul>
		                </li>
					<?php endif; ?>
	                <?php if ( 1 == 2 ) : ?>
						<li><a href="<?php echo base_url('home/galery'); ?>">Galeri</a></li>
					<?php endif; ?>	
	            </ul>
	        </nav>   
        <?php endif; ?>

		<?php
			$this->load->view($page);
		?>

        <footer class="doc-footer bgBlack">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <h6>FOLLOW US</h6>
                    	<div class="pb-45">
	                        <ul class="header-sharer-list v-align-top">
	                            <li class="inline-block v-align-top socmed-wrapper fb"><a class="header-sharer-list-link text-center" href="<?= $option[4]->option_value ?>"><i class="fa fa-facebook text-color-333" aria-hidden="true"></i></a></li>
	                            <li class="inline-block v-align-top socmed-wrapper ig"><a class="header-sharer-list-link text-center" href="<?= $option[6]->option_value ?>"><i class="fa fa-instagram text-color-333" aria-hidden="true"></i></a></li>
	                            <li class="inline-block v-align-top socmed-wrapper twit"><a class="header-sharer-list-link text-center" href="<?= $option[5]->option_value ?>"><i class="fa fa-twitter text-color-333" aria-hidden="true"></i></a></li>
	                            <li class="inline-block v-align-top socmed-wrapper yt"><a class="header-sharer-list-link text-center" href="<?= $option[7]->option_value ?>"><i class="fa fa-youtube text-color-333" aria-hidden="true"></i></a></li>
	                        </ul>                    		
                    	</div>
                    </div>
                    <?php if (1==2) : ?>
	                    <div class="col-sm-3">
	                        <h6>Lain - lain</h6>
	                        <ul class="links">
	                            <li><a href="<?php echo base_url('home/lowongan_kerja'); ?>">Informasi Loker</a></li>
	                            <li><a href="#">Ulang Tahun Perkawinan</a></li>
	                        </ul>
	                    </div>
					<?php endif; ?>
                    <div class="col-sm-4">
                    	<h6>Alamat Pastoran</h6>
                    	<div class="links">
							<span class="footer-address">Komplek Barata</span> 
							<span class="footer-address">Jl. Barata Raya No.32,</span> 
							<span class="footer-address">Karang Tengah, Tangerang 15157</span> 
							<span class="footer-address">Phone: 021-7306550 021-7311885</span> 
							<span class="footer-address">Fax: 021-7338483</span>
                    	</div>
                        <?php if( 1==2 ) : ?>
	                        <h6>Santa Bernadet</h6>
	                        <ul class="links">
	                            <li><a onclick="detail('<?php echo $option[2]->option_name ?>');">ALAMAT</a></li>
	                            <li><a onclick="detail('<?php echo $option[3]->option_name ?>');">TENTANG</a></li>
	                            <li><a onclick="detail('<?php echo $option[8]->option_name ?>');">KONTAK</a></li>
	                        </ul>
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-4">
                    	<h6>Alamat Gereja</h6>
                    	<div class="links">
                    		<span class="footer-address">Jl. Boulevard Graha Raya</span>
                    		<span class="footer-address">Sudimara Pinang,</span>
                    		<span class="footer-address">Pinang, Kota Tangerang,</span>
                    		<span class="footer-address">Banten 15145</span>
                    	</div>
                    </div>
                </div>
                <div class="pt-20">
                	<span class="copyrights">Copyright &copy; <?= date("Y"); ?>. Paroki Santa Bernadet Ciledug</span>
                </div>
            </div>
        </footer>



  </div>
<!--====================
 Scripts
====================-->
<script>
if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('service-worker.js')
    .then(function(registration) {
      console.log('Service Worker registration successful with scope: ',
      registration.scope);
    })
    .catch(function(err) {
      console.log('Service Worker registration failed: ', err);
    });
}
</script>
<script src="<?= base_url() ?>assets/home/js/jquery/dist/jquery.min.js"></script>
<script src="<?= base_url() ?>assets/home/js/main.js" async></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>
