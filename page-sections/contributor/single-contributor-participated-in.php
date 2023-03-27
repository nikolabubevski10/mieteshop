<?php
    global $post;

    $productPerPage = 16;

    if( wp_is_mobile() ){
        $productPerPage = 4;
    }

    $page = 1;
?>
<section id="js-single-contributor-books" class="single-product-recently-section single-product-recently-section--border-bottom">
    <div class="content-container">
        <div class="single-product-recently-title">
            <h2>ΒΙΒΛΙΑ ΣΤΑ ΟΠΟΙΑ ΕΧΕΙ ΣΥΜΜΕΤΑΣΧΕΙ ΩΣ ΣΥΝΤΕΛΕΣΤΗΣ</h2>
        </div>
        <div id="js-single-contributor-product-row" class="pcat-results-row" data-nonce="<?php echo wp_create_nonce('filter_single_contributor_product_nonce'); ?>" data-product-per-page="<?php echo $productPerPage; ?>" data-contributor-id="<?php echo $post->ID; ?>">
            <?php
            //get book contributors custom relationship fields (all except book_contributors_syggrafeas):

            $book_contributor_fields = acf_get_fields('3523'); //3523 is the group id
            
            $meta_query_arrays['relation'] =  'OR';
            $i = 0;
            foreach ( $book_contributor_fields as $book_contributor_field ) {
                if ( $book_contributor_field['name'] != 'book_contributors_syggrafeas' ) {
                    $meta_query_arrays[$i] = array(                            
                        'key'     => $book_contributor_field['name'],
                        'value'   => '"' . $post->ID . '"',
                        'compare' => 'LIKE'
                    ); 
                    $i++;
                }    
            } 
            //$meta_query = array('relation' => 'OR', $meta_query_arrays);
            /*    
            $meta_query_args = array(
                'relation' => 'OR', 
                array(
                    'key'     => 'book_contributors_metafrasi',
                    'value'   => '"' . $post->ID . '"',
                    'compare' => 'LIKE'
                ),
                array(
                    'key'     => 'book_contributors_epimeleia',
                    'value'   => '"' . $post->ID . '"',
                    'compare' => 'LIKE'
                ),
                array(
                    'key'     => 'book_contributors_epimetro',
                    'value'   => '"' . $post->ID . '"',
                    'compare' => 'LIKE'
                )
                );
                */
            $args = [
                'post_type' => 'product',
                'posts_per_page' => $productPerPage,
                'offset' => ($page - 1) * $productPerPage,
                'meta_key' => 'book_first_published_date',
                'orderby' => 'meta_value',
                'order' => 'desc',
                'fields' => 'ids',
                'meta_query' => $meta_query_arrays
            ];

            $query = new WP_Query( $args );
            //echo '<pre>'; var_dump($meta_query); echo '</pre>';
            //$query->set('meta_query', $meta_query);

            $count_product_list_include_single_contributor = $loop->found_posts;

            foreach ( $query->posts as $postid ){
            ?>
                <div class="pcat-results-col">
                    <?php get_template_part('product/loop/loop', 'product-card', [ 'postId' => $postid ]); ?>
                </div>
            <?php
            }
            ?>
        </div>
        <?php
            if( $count_product_list_include_single_contributor > $productPerPage ){
                get_template_part('product/page-nav/page-nav', 'navigation', [ 
                    'navWrapperDomId' => "js-single-contributor-product-navigation",
                    'navDomClass' => "js-sc-product-navigation-item",
                    'gotoDomId' => "js-sc-page-list",
                    'total' => $count_product_list_include_single_contributor,
                    'perPage' => $productPerPage
                ]);
            }
        ?>
    </div>
</section>