<!--<div class="xvModal newsletter modal-show-delay" data-delay="1">
	<div class="xvModalInner imgAsBG">
		<img src="assets/home/img/newsleter-popup.jpg" alt="">
		<a href="#" class="modalRemove"><i class="xv-arrows_remove"></i></a>
		<div class="content">
			<h3>signup for newsletter</h3>
			<p>Signup for our newletter and stay upto date with latest
			fashion news and our upcoming designer products.</p>
			<div class="form">
				<form>
					<input type="text" class="light" placeholder="EMAIL ADDERSS">
					<button type="submit" class="btn btn btn-default">subscribe</button>
				</form>
			</div>
		</div>
	</div>
</div>-->

<section class="lookBook bgBlack">
	<div class="container">
		<header class="head text-center"><h3 class="mt-0">Kegiatan 2016</h3></header>
		<div class="packeryWrap">
			<?php foreach($profile->result() as $data) { ?>
			<div class="item"><a data-rel="prettyPhoto[lookbookgal]" class="preview imgAsBG" href="<?php echo base_url('uploads/'.$data->profile_image); ?>">
				<img src="<?php echo base_url('uploads/'.$data->profile_image); ?>" alt="<?php echo $data->profile_title; ?>">
				<div class="looklay"></div></a>
			</div>
			<?php } ?>
			

		</div>
	</div>
</section>

<div class="sectionHalf visualLeft clearfix xvAboutus bgGrey">
	<div class="visualdiv fadeInLeft animate imgAsBG">
		<img src="assets/img/aboutus.jpg" alt="asd">
	</div>
	<div class="content">
		<div class="contentWrap">
		    <div class="text-widget">
				<div class="col-md-8">
					<h3>about us</h3>
					<p>Aliquam hendrerit a augue in Pellentes que id erat quis sapien dign issim solli citud inmattis tortor sit amet sollicitudin aliquam. In sequat magna rutrum egestas hendrerit  tortor mi tempus quam pharetraed fringilla eros odio et risus. Aenean feugiat neque id maximus liquam maximus enim.
					<br><br>
					Nullam vulputate euismod urna non pharetra khasellus blandit mais ipsum ac laoreet lorem lacinia ligula lorem ipsum dolor sit ametedse nsectetuer adipiscing elit donec odio tuisque volutpat mattis eros. </p>
							<a href="#" class="btn btn-default button button--tamaya" data-text="download media kit"><span>download media kit</span></a>
				</div>
				<div class="col-md-4">
					<p><strong>Kalender Liturgi</strong></p>
					<table width="150" height="200" bgcolor="#FFFFCC" cellspacing="0" border="1" >
						<tr>
							<td align="center">
								<b><a href="http://www.imankatolik.or.id" style="text-decoration:none">
								<small>imankatolik.or.id</small></a></b>
							</td>
						</tr>
						<tr>
							<td align="center">
								<a href="http://www.imankatolik.or.id/kal_tgl_link.php" target="_blank">
								<img border="0" src="http://www.imankatolik.or.id/kal_tgl_img.php" /></a>
							</td>
						</tr>
						<tr height="80%">
							<td>
								<table width="100%">
									<tr>
										<td align="center"><a href="http://www.imankatolik.or.id/kal_tgl_link.php" target="_blank">
											<img border="0" src="http://www.imankatolik.or.id/kal_perayaan_img.php" /></a>
										</td>
									</tr>
									<tr>
										<td align="center">
											<a href="http://www.imankatolik.or.id/kal_alkitab_link.php" target="_blank">
											<img border="0" src="http://www.imankatolik.or.id/kal_alkitab_img.php" /></a></small>
										</td>
									</tr>
									<tr>
										<td align="center">
											<img src="http://www.imankatolik.or.id/kal_warna_img.php" />
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td align="center">
								<a href="http://www.imankatolik.or.id/kalender.php" target="_blank" style="text-decoration:none">
								<small>Kalender bulan ini</small></a>
							</td>
						</tr>
					</table>
					<br>
					
					<p><strong>Alamat Gereja</strong></p>
					<table>
						<tr>
							<td>
								<p>Komplek Barata, Jl. Barata Raya No.32, Karang Tengah
								Tangerang 15157
								Phone: 021-7306550
								021-7311885
								Fax: 021-7338483</p>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>