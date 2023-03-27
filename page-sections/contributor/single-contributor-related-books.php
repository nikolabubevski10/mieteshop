    <?php
        if ( get_field('contributor_related_books') ) {
    ?> 
    <section class="single-product-recently-section">
            <div class="content-container">
                <div class="single-product-recently-title">
                    <h2>ΣΧΕΤΙΚΟΙ ΤΙΤΛΟΙ</h2>
                </div>
                <div class="pcat-results-row">
                    <?php
                        $relatedbooks = get_field('contributor_related_books');
                    
                        foreach($relatedbooks as $relatedbook){
                    ?>
                            <div class="pcat-results-col">
                                <?php get_template_part('product/loop/loop', 'product-card', [ 'postId' => $relatedbook->ID ]); ?>
                            </div>
                    <?php
                        }
                        wp_reset_query();
                    ?>
                </div>
            </div>
    </section>        
    <?php
        }
    ?>
