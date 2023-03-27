<?php
    global $product;

    $title_types = get_the_terms( $product->get_id(), 'title_type' );
    $product_cats = get_the_terms( $product->get_id(), 'product_cat' );

    $breadcrumb_product_cat = $product_cats[0];
    $primary_product_cat_id = get_post_meta($product->get_id(), '_yoast_wpseo_primary_product_cat', true);

    if( !empty($primary_product_cat_id) ){
        $primary_product_cat_id = intval($primary_product_cat_id);

        foreach($product_cats as $term) {
            if( $primary_product_cat_id == $term->term_id ) {
                $breadcrumb_product_cat = $term;    
            }
        }
    }
?>
<section class="breadcrumb-section">
    <div class="content-container">
        <div class="breadcrumb-list">
            <?php
                if( !empty($title_types) ){
            ?>
                    <div class="breadcrumb-item"><a href="<?php echo get_term_link($title_types[0]->term_id); ?>"><?php echo $title_types[0]->name; ?></a></div>
            <?php
                }

                if( !empty($product_cats) ){
                    $product_cat_parent_list = array_reverse(get_ancestors($breadcrumb_product_cat->term_id, 'product_cat'));

                    foreach( $product_cat_parent_list as $parent ){
                        $parent_object = get_term($parent);
            ?>
                        <div class="breadcrumb-item"><a href="<?php echo get_term_link($parent_object->term_id); ?>"><?php echo $parent_object->name; ?></a></div>
            <?php
                    }
            ?>
                    <div class="breadcrumb-item"><a href="<?php echo get_term_link($breadcrumb_product_cat->term_id); ?>"><?php echo $breadcrumb_product_cat->name; ?></a></div>
            <?php
                }
            ?>
        </div>
    </div>
</section>