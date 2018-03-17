<section class="text-center xvBlogWrap">
	<div class="container">
		<header class="head text-center"><h3 class="mt-0">Gallery Santa Bernadet</h3></header>
		<div class="row masonry" style="position: relative; height: 1878px;">
			<?php
				if($galery->result()){
					foreach($galery->result() as $row){
						echo '
						<div class="col-sm-4 col-xs-12 masonry-item" style="position: absolute; left: 390px; top: 0px;">
						<article class="xvBlogPost">
							<header>
								<div class="visual imgAsBG" style="background-image: url('.base_url().'uploads/'.$row->post_image.');"><img src="'.base_url().'uploads/'.$row->post_image.'" alt="Ravish Demo Content"></div>
								<h6><a data-rel="prettyPhoto[lookbookgal]" class="preview imgAsBG" href="'.base_url().'uploads/'.$row->post_image.'">'.$row->post_title.'</a></h6>
								<span class="date">'.date('d', strtotime($row->post_created)).' - '.date('F', strtotime($row->post_created)).', '.date('Y', strtotime($row->post_created)).'</span>
							</header>
							<div class="xvPostInfo">
								'.$row->post_content.'
							</div>
						</article>
					</div>
						';
					}
				}
			?>
		</div>
	</div>
</section>
