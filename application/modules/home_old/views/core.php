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
<meta name="description" content="">
<meta content="yes" name="apple-mobile-web-app-capable" />
<meta name="viewport" content="minimum-scale=1.0, width=device-width, maximum-scale=1, user-scalable=no" />
<!--=================================
Style Sheets
=================================-->
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
    
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/home/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/home/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/home/css/custom-icons.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/home/css/my-instagram-gallery.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/home/css/odometer-theme-default.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/home/css/slick.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/home/css/prettyPhoto.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/home/css/animate.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/home/css/main.css">

<script src="<?= base_url() ?>assets/home/js/modernizr-2.6.2-respond-1.1.0.min.js"></script>
</head>
<body class="getting-ready">

    <div class="pre-loading">
        <div class="loading-animation">
            <div class="loader-container arc-rotate2">
                <div class="loader">
                    <div class="arc"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="bodyWrap">
        <!--====================
         Header
        ====================-->
        <header class="doc-header">
            <div class="topHeader">
                <div class="container">
                    <div class="topSearch">
                        <img src="http://parokisantabernadet.org/wp-content/uploads/2016/03/logo2_sanberna_plain.png"  width="100%" />
                    </div>
                    
                    <a href="#" class="logo" style="margin-left : -20%">
                        <h4>OFFICIAL WEB PAROKI CILEDUG, GEREJA SANTA BERNADET</h4>
                    </a>
					
                    <ul class="topLinks">
                        <li class="accountDropdownTriger">
                            <a href="#"><i class="xv-basic_lock"></i></a>
                            <div class="accountDropdown style clearfix">
                                <ul class="tabs">
                                    <li class="active">
                                        <a href="#tab1">Login</a>
                                    </li>
                                    <li>
                                        <a href="#tab2">Register</a>
                                    </li>
                                </ul>
                                <div class="tab-panel">
                                    <div id="tab1" class="tab-pane active">
                                        <form>
                                            <input type="text" placeholder="Email address">
                                            <input type="text" placeholder="Password">
                                            <a class="btn btn-default" href="#">Login</a>
                                            <a class="resetPass" href="#">Forgot your password?</a>
                                        </form>
                                    </div>

                                    <div id="tab2" class="tab-pane">
                                        <form>
                                            <input type="text" placeholder="First name">
                                            <input type="text" placeholder="Last name">
                                            <input type="text" placeholder="Email address">
                                            <input type="text" placeholder="Password">
                                            <a class="btn btn-default" href="#">create account</a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <nav class="bgBlack">
                
                    <ul class="mainNav">
                        <li><a href="<?php echo base_url('home'); ?>">Home</a></li>
                        <li><a href="#">Profile</a>
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
                        <li><a href="#">KAJ</a></li>
                        <li><a href="#">Dewan Paroki</a>
                            <ul>
                                <li><a href="blog-masonry.html">Blog - Masonry</a></li>
                                <li><a href="blog-mini1.html">Blog - Standard</a></li>
                                <li><a href="blog-mini-sidebar.html">Blog Standard - Sidebar</a></li>
                                <li><a href="blog-read-sidebar.html">Blog Single - Sidebar</a></li>
                                <li><a href="blog-read-full.html">Blog Single - Wide</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Kategorial</a>
                            <ul>
							<?php
								foreach ($kategorial->result() as $kategorial) {
							?>
                            	<li><a href="<?php echo base_url('home/kategorial/'.$kategorial->post_id.''); ?>"><?= $kategorial->post_title ?></a></li>
							<?php
								}
							?>
							</ul>
                        </li>
                        <li><a href="#">Wilayah</a>
                            <ul>
                                <li><a href="shortcodes-banners.html">Banners</a></li>
                                <li><a href="shortcodes-buttons.html">Buttons</a></li>
                                <li><a href="shortcodes-elements.html">Elements</a></li>
                                <li><a href="shortcodes-products.html">Products</a></li>
                                <li><a href="shortcodes-typography.html">Typography</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Pelayanan</a>
                            <ul>
							<?php
								foreach ($pelayanan->result() as $pelayanan) {
							?>
                            	<li><a href="<?php echo base_url('home/pelayanan/'.$pelayanan->post_id.''); ?>"><?= $pelayanan->post_title ?></a></li>
							<?php
								}
							?>
							</ul>
                        </li>
						<li><a href="#">Download</a>
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
						<li><a href="#">Galery</a>
                            <ul>
                                <li><a href="shortcodes-banners.html">Banners</a></li>
                                <li><a href="shortcodes-buttons.html">Buttons</a></li>
                                <li><a href="shortcodes-elements.html">Elements</a></li>
                                <li><a href="shortcodes-products.html">Products</a></li>
                                <li><a href="shortcodes-typography.html">Typography</a></li>
                            </ul>
                        </li>
                    </ul>

                
            </nav>
        </header>
		
		<?php
			$this->load->view($page);
		?>
		
        <footer class="doc-footer bgBlack">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <h6>FOLLOW US</h6>
                        <ul class="links">
                            <li><a href="<?= $option[4]->option_value ?>">FACEBOOK</a></li>
                            <li><a href="<?= $option[6]->option_value ?>">INSTAGRAM</a></li>
                            <li><a href="<?= $option[5]->option_value ?>">TWITTER</a></li>
                            <li><a href="<?= $option[7]->option_value ?>">YOUTUBE</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-4">
                        <h6>Lain - lain</h6>
                        <ul class="links">
                            <li><a href="#">Informasi Loker</a></li>
                            <li><a href="#">Ulang Tahun Perkawinan</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-4">
                        <h6>Santa Bernadet</h6>
                        <ul class="links">
                            <li><a href="#">ABOUT</a></li>
                            <li><a href="#">OFFICES</a></li>
                            <li><a href="#">CONTACT</a></li>
                        </ul>
                    </div>
                </div>
                <span class="copyrights">Copyright © 2016. Developed by <a href="http://6atmedia.com/" target="_blank">6 At Media</a></span>
            </div>
        </footer>

  </div>
<!--====================
 Scripts
====================-->
<script src="<?= base_url() ?>assets/home/js/jquery-1.11.3.min.js"></script>
<script src="<?= base_url() ?>assets/home/js/bootstrap.min.js"></script>
<script src="<?= base_url() ?>assets/home/js/packery.pkgd.min.js"></script>
<script src="<?= base_url() ?>assets/home/js/masonry.pkgd.min.js"></script>
<script src="<?= base_url() ?>assets/home/js/isotope.pkgd.min.js"></script>
<script src="<?= base_url() ?>assets/home/js/jquery.stellar.min.js"></script>
<script src="<?= base_url() ?>assets/home/js/my-instagram-gallery.js"></script>
<script src="<?= base_url() ?>assets/home/js/slick.min.js"></script>
<script src="<?= base_url() ?>assets/home/js/jquery.inview.js"></script>
<script src="<?= base_url() ?>assets/home/js/odometer.min.js"></script>
<script src="<?= base_url() ?>assets/home/js/tweetie.min.js"></script>
<script src="<?= base_url() ?>assets/home/js/jquery.timeago.js"></script>
<script src="<?= base_url() ?>assets/home/js/jquery.knob.min.js"></script>
<script src="<?= base_url() ?>assets/home/js/product-logic.js"></script>
<script src="<?= base_url() ?>assets/home/js/css3-animate-it.js"></script>
<script src="<?= base_url() ?>assets/home/js/imagesloaded.pkgd.min.js"></script>
<script src="<?= base_url() ?>assets/home/js/jquery.prettyPhoto.js"></script>
<script src="<?= base_url() ?>assets/home/js/main.js"></script>

</body>
</html>