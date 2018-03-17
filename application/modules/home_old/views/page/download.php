<section class="aboutBrand">
	<div class="container">
		<?php foreach($get_download->result() as $detail) { ?>
		<header class="head text-center"><h3 class="mt-0"><?php echo $detail->post_title; ?></h3></header>
		<div class="row">
			<div class="col-sm-12">
				<?php echo $detail->post_content; ?>
			</div>
			<div class="col-sm-12">
				<a href="<?php echo base_url('home/lakukan_download/'.$detail->post_id.''); ?>" class="btn btn-default button button--tamaya" data-text="Download File"><span>Download File</span></a>
			</div>
		</div>
		<?php } ?>
	</div>
</section>