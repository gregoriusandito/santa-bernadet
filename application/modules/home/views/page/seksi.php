<?php foreach($get_seksi->result() as $detail) { ?>
	<div class="bg-fixed-post" style="background-image: url('<?= base_url('uploads/'.$detail->seksi_image); ?>');">
		<div class="article-headline-container">	
			<div class="row">
				<div class="col-sm-12">
					<div class="max-width-600">
						<h2 class="text-center text-white font-45 text-shadow mobile-font-30 font-pt-sans text-transform-none"><?php echo $detail->seksi_title; ?></h1>
					</div>
				</div>
			</div>	
		</div>	
	</div>
	<section class="aboutBrand">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<?php echo $detail->seksi_content; ?>
				</div>
	
			</div>
		</div>
	</section>
<?php } ?>