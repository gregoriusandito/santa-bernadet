<script>
	function cek(e){
		var list;
		$.ajax({
			dataType : 'json',
			type : 'GET',
			url: '<?= base_url() ?>home/detail_dph?id='+e,
			success: function(data){
				var items = data
				// for(i = 0; i < items.length; i++){
					// var item = items[i];
					list += '<tr>';
					list += '<td>Nama Lengkap</td><td>'+items.first_name+' '+items.last_name+'</td>';
					list += '</tr>';
					list += '<tr>';
					list += '<td>Telpon</td><td>'+items.phone+'</td>';
					list += '</tr>';
					list += '<tr>';
					list += '<td>Handphone</td><td>'+items.hp+'</td>';
					list += '</tr>';
					list += '<tr>';
					list += '<td>Alamat</td><td>'+items.alamat+'</td>';
					list += '</tr>';
				// }
				$('#list').html(list);
				$('#jabatan').html(items.dph_title);
				$('#id').html(e);
				$('#myModal').modal("show");
			}
		});
	}
</script>

<?php 

$all_dph		=	$dph->result();

$ketua_umum		=	array(); //1
$ketua			=	array(); //8
$wakil_ketua	=	array(); //2
$sekretaris_1	=	array(); //3
$sekretaris_2	=	array(); //4
$bendahara_1	=	array(); //5
$bendahara_2	=	array(); //6
$anggota		=	array(); //7

foreach($all_dph as $dph) :
	if ( $dph->dph_id == 1 ) :
		$ketua_umum		=	$dph;
	elseif ( $dph->dph_id == 8 ) :
		$ketua			=	$dph;
	elseif ( $dph->dph_id == 2 ) :
		$wakil_ketua	=	$dph;
	elseif ( $dph->dph_id == 3 ) :
		$sekretaris_1	=	$dph;
	elseif ( $dph->dph_id == 4 ) :
		$sekretaris_2	=	$dph;
	elseif ( $dph->dph_id == 5 ) :
		$bendahara_1	=	$dph;
	elseif ( $dph->dph_id == 6 ) :
		$bendahara_2	=	$dph;
	elseif ( $dph->dph_id == 7 ) :
		$anggota[]	=	$dph;
	endif;	
endforeach;	

?>

<section class="productsWrap">
	<div class="products style3">
		<div class="container">
			<header class="head"><h3 class="mt-0">Dewan Paroki Harian</h3></header>

			<div class="slick-carousel controls-right item-margin-30" data-dots="false" data-prev="xv-arrows_square_left" data-next="xv-arrows_square_right" data-slides-scroll="1" data-slides="4" data-slides-lg="3" data-slides-md="2" data-slides-sm="1" data-loop="false" data-nav="true">
				<div class="product text-center">
					<div class="productImages">
						<div class="image-default imgAsBG">
							<img src="<?php echo base_url('uploads/user/'.$ketua_umum->foto); ?>" alt="asd">
						</div>
						<div class="image-hover imgAsBG">
							<img src="<?php echo base_url('uploads/user/'.$ketua_umum->foto); ?>" alt="asd">
						</div>
					</div>
					<ul class="links">
						<li><a onclick="cek('<?=$ketua_umum->id?>');"><i class="xv-basic_eye"></i></a></li>
					</ul>
					<div class="productInfo">
						<h3><a href="#"><?php echo $ketua_umum->dph_title; ?></a></h3>
						<span class="price"><p><?php echo $ketua_umum->first_name.' '.$ketua_umum->last_name; ?></p></span>
					</div>
				</div>
				<div class="product text-center">
					<div class="productImages">
						<div class="image-default imgAsBG">
							<img src="<?php echo base_url('uploads/user/'.$ketua->foto); ?>" alt="asd">
						</div>
						<div class="image-hover imgAsBG">
							<img src="<?php echo base_url('uploads/user/'.$ketua->foto); ?>" alt="asd">
						</div>
					</div>
					<ul class="links">
						<li><a onclick="cek('<?=$ketua->id?>');"><i class="xv-basic_eye"></i></a></li>
					</ul>
					<div class="productInfo">
						<h3><a href="#"><?php echo $ketua->dph_title; ?></a></h3>
						<span class="price"><p><?php echo $ketua->first_name.' '.$ketua->last_name; ?></p></span>
					</div>
				</div>
				<div class="product text-center">
					<div class="productImages">
						<div class="image-default imgAsBG">
							<img src="<?php echo base_url('uploads/user/'.$wakil_ketua->foto); ?>" alt="asd">
						</div>
						<div class="image-hover imgAsBG">
							<img src="<?php echo base_url('uploads/user/'.$wakil_ketua->foto); ?>" alt="asd">
						</div>
					</div>
					<ul class="links">
						<li><a onclick="cek('<?=$wakil_ketua->id?>');"><i class="xv-basic_eye"></i></a></li>
					</ul>
					<div class="productInfo">
						<h3><a href="#"><?php echo $wakil_ketua->dph_title; ?></a></h3>
						<span class="price"><p><?php echo $wakil_ketua->first_name.' '.$wakil_ketua->last_name; ?></p></span>
					</div>
				</div>
			</div>

			<div class="slick-carousel controls-right item-margin-30" data-dots="false" data-prev="xv-arrows_square_left" data-next="xv-arrows_square_right" data-slides-scroll="1" data-slides="4" data-slides-lg="3" data-slides-md="2" data-slides-sm="1" data-loop="false" data-nav="true">
				<div class="product text-center">
					<div class="productImages">
						<div class="image-default imgAsBG">
							<img src="<?php echo base_url('uploads/user/'.$sekretaris_1->foto); ?>" alt="asd">
						</div>
						<div class="image-hover imgAsBG">
							<img src="<?php echo base_url('uploads/user/'.$sekretaris_1->foto); ?>" alt="asd">
						</div>
					</div>
					<ul class="links">
						<li><a onclick="cek('<?=$sekretaris_1->id?>');"><i class="xv-basic_eye"></i></a></li>
					</ul>
					<div class="productInfo">
						<h3><a href="#"><?php echo $sekretaris_1->dph_title; ?></a></h3>
						<span class="price"><p><?php echo $sekretaris_1->first_name.' '.$sekretaris_1->last_name; ?></p></span>
					</div>
				</div>
				<div class="product text-center">
					<div class="productImages">
						<div class="image-default imgAsBG">
							<img src="<?php echo base_url('uploads/user/'.$sekretaris_2->foto); ?>" alt="asd">
						</div>
						<div class="image-hover imgAsBG">
							<img src="<?php echo base_url('uploads/user/'.$sekretaris_2->foto); ?>" alt="asd">
						</div>
					</div>
					<ul class="links">
						<li><a onclick="cek('<?=$sekretaris_2->id?>');"><i class="xv-basic_eye"></i></a></li>
					</ul>
					<div class="productInfo">
						<h3><a href="#"><?php echo $sekretaris_2->dph_title; ?></a></h3>
						<span class="price"><p><?php echo $sekretaris_2->first_name.' '.$sekretaris_2->last_name; ?></p></span>
					</div>
				</div>
			</div>

			<div class="slick-carousel controls-right item-margin-30" data-dots="false" data-prev="xv-arrows_square_left" data-next="xv-arrows_square_right" data-slides-scroll="1" data-slides="4" data-slides-lg="3" data-slides-md="2" data-slides-sm="1" data-loop="false" data-nav="true">
				<div class="product text-center">
					<div class="productImages">
						<div class="image-default imgAsBG">
							<img src="<?php echo base_url('uploads/user/'.$bendahara_1->foto); ?>" alt="asd">
						</div>
						<div class="image-hover imgAsBG">
							<img src="<?php echo base_url('uploads/user/'.$bendahara_1->foto); ?>" alt="asd">
						</div>
					</div>
					<ul class="links">
						<li><a onclick="cek('<?=$bendahara_1->id?>');"><i class="xv-basic_eye"></i></a></li>
					</ul>
					<div class="productInfo">
						<h3><a href="#"><?php echo $bendahara_1->dph_title; ?></a></h3>
						<span class="price"><p><?php echo $bendahara_1->first_name.' '.$bendahara_1->last_name; ?></p></span>
					</div>
				</div>
				<div class="product text-center">
					<div class="productImages">
						<div class="image-default imgAsBG">
							<img src="<?php echo base_url('uploads/user/'.$bendahara_2->foto); ?>" alt="asd">
						</div>
						<div class="image-hover imgAsBG">
							<img src="<?php echo base_url('uploads/user/'.$bendahara_2->foto); ?>" alt="asd">
						</div>
					</div>
					<ul class="links">
						<li><a onclick="cek('<?=$bendahara_2->id?>');"><i class="xv-basic_eye"></i></a></li>
					</ul>
					<div class="productInfo">
						<h3><a href="#"><?php echo $bendahara_2->dph_title; ?></a></h3>
						<span class="price"><p><?php echo $bendahara_2->first_name.' '.$bendahara_2->last_name; ?></p></span>
					</div>
				</div>
			</div>

			<div class="slick-carousel controls-right item-margin-30" data-dots="false" data-prev="xv-arrows_square_left" data-next="xv-arrows_square_right" data-slides-scroll="1" data-slides="4" data-slides-lg="3" data-slides-md="2" data-slides-sm="1" data-loop="false" data-nav="true">
				<?php foreach($anggota as $dph) { ?>
				<div class="product text-center">
					<div class="productImages">
						<div class="image-default imgAsBG">
							<img src="<?php echo base_url('uploads/user/'.$dph->foto); ?>" alt="asd">
						</div>
						<div class="image-hover imgAsBG">
							<img src="<?php echo base_url('uploads/user/'.$dph->foto); ?>" alt="asd">
						</div>
					</div>
					<ul class="links">
						<li><a onclick="cek('<?=$dph->id?>');"><i class="xv-basic_eye"></i></a></li>
					</ul>
					<div class="productInfo">
						<h3><a href="#"><?php echo $dph->dph_title; ?></a></h3>
						<span class="price"><p><?php echo $dph->first_name.' '.$dph->last_name; ?></p></span>
					</div>
				</div>
				<?php } ?>
			</div>

		</div>
	</div>
</section>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><h4>Jabatan : <span id="jabatan"></span></h4></h4>
      </div>
      <div class="modal-body">
		<table class="table">
			<tbody id="list"></tbody>
		</table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
