<?php
    global $post;
    $searchKey = get_search_query();

    $child_cat_search_list = get_terms([
        'taxonomy' => 'product_cat', 
        'hide_empty' => false, 
        'name__like' => $searchKey
    ]);

    $child_cat_list_count = count($child_cat_search_list);
?>
<section class="search-result-category-section">
    <div class="general-container">
        <div class="content-container">
            <div class="search-result-category-title">
                <h2>ΘΕΜΑΤΙΚΕΣ: <?php echo $child_cat_list_count; ?></h2>
            </div>
            <?php
                if( !empty($child_cat_search_list) ){
            ?>
                    <div class="search-result-category-list">
                        <?php
                            foreach( $child_cat_search_list as $key => $cat ){
                                $product_cat_parent_list = array_reverse(get_ancestors($cat->term_id, 'product_cat'));
                        ?>
                                <div class="search-result-category-item">
                                    <?php
                                        foreach( $product_cat_parent_list as $parent ){
                                            $parent_object = get_term($parent);
                                    ?>
                                            <span><a href="<?php echo get_term_link($parent_object->term_id); ?>"><?php echo $parent_object->name; ?></a></span>
                                    <?php
                                        }
                                    ?>
                                    <span><a href="<?php echo get_term_link($cat->term_id); ?>"><?php echo $cat->name; ?></a></span>
                                </div>
                        <?php
                            }
                        ?>
                    </div>
            <?php
                }
            ?>
        </div>
    </div>
</section>