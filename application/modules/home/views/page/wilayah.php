<section class="aboutBrand">
	<div class="container">
		<?php foreach($get_wilayah->result() as $detail) {  ?>
		<header class="head text-center">
			<h3 class="mt-0 wilayah-title"><?php echo $detail->wilayah_title; ?></h3>
		</header>
		<div class="row">
			<div class="col-sm-12 col-md-3 text-center mobile-pad-bottom-30">
				<div class="pb-20">
					<i class="fa fa-user text-color-333 font-36" aria-hidden="true"></i>
				</div>
				<span><?= $detail->first_name ?> <?= $detail->last_name ?></span>
			</div>
			<div class="col-sm-12 col-md-3 text-center mobile-pad-bottom-30">
				<div class="pb-20">
					<i class="fa fa-phone-square text-color-333 font-36" aria-hidden="true"></i>
				</div>
				<span><?= $detail->phone ? $detail->phone : '---' ?></span>
			</div>
			<div class="col-sm-12 col-md-3 text-center mobile-pad-bottom-30">
				<div class="pb-20">
					<i class="fa fa-mobile text-color-333 font-36" aria-hidden="true"></i>
				</div>
				<span><?= $detail->hp ? $detail->hp : '---' ?></span>
			</div>
			<div class="col-sm-12 col-md-3 text-center mobile-pad-bottom-30">
				<div class="pb-20">
					<i class="fa fa-home text-color-333 font-36" aria-hidden="true"></i>
				</div>
				<span><?= $detail->alamat ? $detail->alamat : '---' ?></span>
			</div>

		</div>
		<?php } ?>
	</div>
</section>