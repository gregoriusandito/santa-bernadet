<section class="aboutBrand">
	<div class="container">
		<?php foreach($get_pelayanan->result() as $detail) { ?>
		<header class="head text-center"><h3 class="mt-0"><?php echo $detail->post_title; ?></h3></header>
		<div class="row">
			<div class="col-sm-12">
				<?php echo $detail->post_content; ?>
			</div>

		</div>
		<?php } ?>
	</div>
</section>