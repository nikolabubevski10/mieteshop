<?php
/**
 * Template Name: Best Sellers Page
 */
global $post;
?>
<?php get_header(); ?>

<?php

    $product_per_page = 16;

    if( wp_is_mobile() ){
        $product_per_page = 4;
    }

    $product_per_page = isset($_GET['productPerPage']) ? $_GET['productPerPage'] : $product_per_page;
    $current_page = isset($_GET['current_page']) ? $_GET['current_page'] : 1;

    $args = [
        'post_type' => 'product',
        'post_status' => 'publish',        
        'posts_per_page' => $product_per_page,
        'offset' => ( $current_page - 1 ) * $product_per_page,
        'fields' => 'ids',
        'meta_key' => 'total_sales',
        'orderby' => 'meta_value_num',
        'order' => 'desc',
    ];

    $the_query = new WP_Query( $args );

    $total_product_count = $the_query->found_posts;

    if ( !empty($the_query->posts) ) {
?>
        <section id="js-best-sellers-results-section" class="pcat-results-section" data-nonce="<?php echo wp_create_nonce('filter_best_sellers_product_nonce'); ?>">
            <div class="general-container">
                <div class="content-container">
                    <div class="pcat-results-top-row">
                        <div class="pcat-results-top-left-col">
                            <div class="pcat-results-title">
                                <h2>ΤΙΤΛΟΙ: <?php echo $total_product_count; ?></h2>
                            </div>
                        </div>
                    </div>
                    <div id="js-best-sellers-results-row" class="pcat-results-row">
                        <?php
                            foreach( $the_query->posts as $postid ) {
                        ?>
                                <div class="pcat-results-col">
                                    <?php get_template_part('product/loop/loop', 'product-card', [ 'postId' => $postid ]); ?>
                                </div>
                        <?php
                            }
                        ?>
                    </div>
                    <?php
                        if( $total_product_count > $product_per_page ){
                            get_template_part('product/page-nav/page-nav', 'navigation', [ 
                                'navWrapperDomId' => "js-best-sellers-results-navigation",
                                'navDomClass' => "js-best-sellers-results-navigation-item",
                                'gotoDomId' => "js-best-sellers-products-page-list",
                                'total' => $total_product_count,
                                'perPage' => $product_per_page,
                                'currentPage' => $current_page,
                            ]);
                        }

                        get_template_part('product/page-nav/page-nav', 'per-page', [ 
                            'selectDomId' => "js-best-sellers-products-per-page",
                            'perPage' => $product_per_page,
                        ]);
                    ?>
                </div>
            </div>
        </section>
<?php
    }
?>

<div id="js-best-sellers-product-filter-load-spinner" class="load-spinner hide"></div>

<?php get_footer(); ?>