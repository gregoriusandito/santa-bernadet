<?php

if ( $results ) :
    $results_chunked = array_chunk( $results, 3 );
endif;

?>

<section class="aboutBrand">
    <header class="head text-center">
        <h3 class="mt-0"><?= $title ?></h3>
    </header>
    <div class="container">
        <?php foreach ( $results_chunked as $chunked_result ) : ?>
            <div class="row pt-20">
                <div class="col-md-12">
                    <div class="row">
                        <?php foreach ( $chunked_result as $value ) : ?>
                            <div class="col-md-4 col-sm-12 pb-20">
                                <div class="sanberna-box-container emagz-index flex-child-vertical-center">
                            		<div class="sanberna-inner-left-box width-30-percent">
                            			<img class="" src="<?= base_url('uploads/'.$value->post_image); ?>">
                            		</div>
                            		<div class="sanberna-inner-right-box width-70-percent">
                        				<div class="pl-25">
                        					<p class="fbo-2 line-height-1-8"><?= $value->post_title ?></p>
                        					<p class="font-12 line-height-1-5 word-break"><?= strip_tags($value->post_content) ?></p>
                        					<div class="sanberna-button-container">
                        						<a href="<?= base_url('home/emagz/'.$value->post_id); ?>" target="_blank" class="sanberna-button-orange text-center">Baca</a>
                        					</div>
                        				</div>
                            		</div>		
                            	</div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <nav>
        <?php echo $links; ?>
    </nav>
    </div>    
    
</section>

    