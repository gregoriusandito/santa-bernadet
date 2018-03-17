<section class="aboutBrand">
	<div class="container">
		<?php foreach($get_page->result() as $detail) { ?>
		<header class="head text-center">
			<h3 class="mt-0 page-title"><?php echo $detail->page_title; ?></h3>
		</header>
		<div class="row">
			<div class="col-sm-12">
				<?php echo $detail->page_content; ?>
			</div>
		</div>
		<?php } ?>
	</div>
</section>