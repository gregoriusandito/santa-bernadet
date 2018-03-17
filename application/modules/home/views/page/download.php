<?php
	$dev_mode = true;
?>

<?php if ($dev_mode) : ?>
	<section class="aboutBrand">
		<div class="container">
			<h3>Mohon Maaf</h1>
			<h5>Laman Unduh (Download) sedang dalam tahap pengembangan</h5>	
		</div>
	</section>
<?php else : ?>
	<section class="aboutBrand">
		<div class="container">
			<?php foreach($get_download->result() as $detail) { ?>
			<header class="head text-center"><h3 class="mt-0"><?php echo $detail->post_title; ?></h3></header>
			<div class="row">
				<div class="col-sm-12">
					<?php echo $detail->post_content; ?>
				</div>
				<div class="col-sm-12">
					<a href="<?php echo base_url('home/lakukan_download/'.$detail->post_id.''); ?>" class="btn btn-default button button--tamaya" data-text="Download File"><span>Unduh Berkas</span></a>
				</div>
			</div>
			<?php } ?>
		</div>
	</section>
	<script>
		function filter(tag){
			// alert(tag);
			var filters = "<?php echo site_url('home/filter')?>/"+tag;
			$.ajax({
				url : "<?php echo site_url('home/filter')?>/"+tag,
				type: "POST",
				dataType: "JSON",
				success: function(hasil)
				{
					alert(tag);
					//if success reload ajax table
					//$('#modal_form').modal('hide');
					window.location.href = "<?php echo site_url('home/filter')?>/"+tag;
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					window.location.href = "<?php echo site_url('home/filter')?>/"+tag;
				}
			});
		}
	</script>

<?php endif; ?>