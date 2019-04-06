<?php

$title = isset($all_news) ? "Semua Berita" : $results[0]->category_title;

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
                                <figure class="category-item-wrapper margin-0">
                                    <a class="category-section-link" href="<?= base_url('home/post/'.$value->post_id); ?>">
                                        <img class="category-figure" src="<?= base_url('uploads/'.$value->post_image); ?>" alt="">
                                    </a>
                                </figure>
                                <h4 class="category-title pt-20 margin-0">
                                    <a class="hover-underline" href="<?= base_url('home/post/'.$value->post_id); ?>"><?= $value->post_title ?></a>
                                </h4>
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

    