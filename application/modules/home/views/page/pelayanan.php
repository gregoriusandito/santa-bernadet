<?php foreach($get_pelayanan->result() as $detail) { ?>
	<section class="aboutBrand">
		<div class="container">
			<header class="head text-center"><h3 class="mt-0"><?php echo $detail->pelayanan_title; ?></h3></header>
			<div class="row">
				<div class="col-sm-12">
					<?php echo $detail->pelayanan_content; ?>
				</div>
				<?php if ($detail->pelayanan_image) : ?>
					<div class="col-sm-12">	
						<a href="<?php echo base_url('home/lakukan_download/'.$detail->pelayanan_id.'/pelayanan'); ?>" class="btn btn-default button button--tamaya" data-text="Unduh Formulir"><span>Unduh Formulir</span></a>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php } ?>	