<section class="aboutBrand">
	<div class="container">
		<?php foreach($get_kaj->result() as $detail) { ?>
		<header class="head text-center"><h3 class="mt-0"><?php echo $detail->judul_folder; ?></h3></header>
		<div class="row">
			<?php if (1==2) : ?>
			<div class="col-sm-12">

				<?php $tag = $this->db->query('SELECT posts_tag.tag FROM posts_tag INNER JOIN kaj ON kaj.id_kaj = posts_tag.post_id WHERE posts_tag.post_asal = "kaj" AND posts_tag.post_id = '.$detail->id_kaj.'')->result();
							$stringsaas = '';
							echo '<label>tag</label>';
							 foreach ($tag as $data_kode) {?>

											<!-- // $stringsaas .= '<input type="text" name="cat" value="'.$data_kode->category_title.'" style="display:none"/><button type="submit" class="btn btn-sm">'.$data_kode->category_title.'</button>, '; -->
											<input type="text" name="cat" value="<?= $data_kode->tag ?>" style="display:none"/><button type="button" class="btn btn-sm" onclick="filter('<?= $data_kode->tag ?>')"><?= $data_kode->tag ?></button>

							<?php }
							$stringsaas = rtrim($stringsaas,', ');

							echo $stringsaas;
				 ?>

			</div>
			<?php endif; ?>
			
			<div class="col-sm-12">
				<?php echo $detail->isi_content; ?>
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
			success: function(data)
			{
				//if success reload ajax table
				//$('#modal_form').modal('hide');
				window.location.href = filters;
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				window.location.href = "<?php echo site_url('home/filter')?>/"+tag;
			}
		});
	}
</script>
