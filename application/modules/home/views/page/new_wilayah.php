<section class="aboutBrand">
	<div class="container">
		<?php foreach($get_new_wilayah->result() as $detail) { ?>
		<header class="head text-center">
			<h3 class="mt-0 wilayah-title"><?php echo $detail->wilayah_title; ?></h3>
		</header>
		<div class="row">
			<div class="col-sm-12">
				<?php echo $detail->wilayah_content; ?>
			</div>
		</div>
		<?php } ?>
	</div>
</section>