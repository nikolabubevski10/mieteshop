<?php
    global $post;
    $searchKey = get_search_query();

    $publisher_term_list = get_terms([
        'taxonomy' => 'ekdotes', 
        'hide_empty' => true, 
        'orderby' => 'title',
        'order' => 'ASC',
        'name__like' => $searchKey,
    ]);

?>
<section class="search-result-category-section">
    <div class="general-container">
        <div class="content-container">
            <div class="search-result-category-title">
                <h2>ΕΚΔΟΤΕΣ/ ΟΡΓΑΝΙΣΜΟΙ: <?php echo count($publisher_term_list); ?></h2>
            </div>
            <?php
                if( !empty($publisher_term_list) ){
            ?>
                    <div class="search-result-category-list">
                        <?php
                            foreach($publisher_term_list as $term){
                        ?>
                                <div class="search-result-category-item">
                                    <a href="<?php echo get_term_link($term->term_id); ?>"><?php echo $term->name; ?></a>
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