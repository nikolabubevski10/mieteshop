<?php
/**
 * Template Name: Blog Page
 */
global $post;
?>
<?php get_header(); ?>

<section class="blog-cat-filter-section">
    <div class="general-container">
        <div class="content-container">
            <div class="blog-cat-filter-select-row">
                <div class="blog-cat-filter-select">
                    <select id="js-blog-cat-filter-select">
                        <option value="0">Όλα</option>
                        <?php
                            $terms = get_terms('category', [
                                'order' => 'name',
                                'orderby' => 'ASC',
                                'hide_empty' => false,
                            ]);

                            foreach( $terms as $term ){
                        ?>
                                <option value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                    <!--div class="blog-cat-filter-select-icon"><?php //include get_template_directory() . '/assets/icons/arrow-down-white-icon.svg'; ?></div-->
                </div>
            </div>
        </div>
    </div>
</section>
<section class="blog-result-section">
    <div class="general-container">
        <?php
            $posts_per_page = 9;

            $args = [
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => $posts_per_page,
                'order' => 'DESC',
                'orderby' => 'date'
            ];

            $the_query = new WP_Query( $args );
            $total_post_count = $the_query->found_posts;

            $first_blog = [];
            $blog_list = [];

            if ( $the_query->have_posts() ) {
                $index = 0;
                while ( $the_query->have_posts() ){
                    $the_query->the_post();

                    if( $index === 0 ){
                        $first_blog = [
                            'id' => $post->ID,
                            'title' => $post->post_title
                        ];
                    } else {
                        $blog_list[] = [
                            'id' => $post->ID,
                            'title' => $post->post_title
                        ];
                    }

                    $index++;
                }
        ?>
                <div class="content-container">
                    <?php get_template_part('post/loop/loop', 'first-post-card', [ 'postId' => $first_blog['id'] ]); ?>
                </div>
                <div class="small-container">
                    <div id="js-blog-result-row" class="blog-result-row" data-nonce="<?php echo wp_create_nonce('filter_blog_result_nonce'); ?>">
                        <?php
                            foreach( $blog_list as $blog ){
                                get_template_part('post/loop/loop', 'post-card', [ 'postId' => $blog['id'] ]);
                            }
                        ?>
                    </div>
                </div>
        <?php
            }

            wp_reset_query();
        ?>
        <div class="small-container">
            <?php
                $page_count = round($total_post_count / $posts_per_page + 0.45);
            ?>
            <div id="js-blog-list-page-navigation" class="pcat-results-footer-options <?php echo $page_count < 2 ? 'hide' : ''; ?>">
                <div class="pcat-results-footer-options-col">
                    <div id="js-blog-results-navigation" class="pcat-results-navigation">
                        <?php
                            require_once dirname(dirname(__FILE__)) . '/inc/zebra-pagination.php';

                            $pagination = new Zebra_Pagination();
                            $pagination->records($total_post_count);
                            $pagination->records_per_page($posts_per_page);
                            $pagination->selectable_pages(5);
                            $pagination->set_page(1);
                            $pagination->padding(false);
                            $pagination->css_classes([
                                'list' => 'pcat-results-navigation-row',
                                'list_item' => 'js-blog-result-navigation-item pcat-results-navigation-item',
                                'prev' => 'js-blog-result-navigation-item pcat-results-navigation-prev',
                                'next' => 'js-blog-result-navigation-item pcat-results-navigation-next',
                                'anchor' => '',
                            ]);
                            $pagination->render();
                        ?>
                    </div>
                </div>
                <div class="pcat-results-footer-options-col">
                    <div class="pcat-results-footer-select">
                        <div class="pcat-results-footer-select-label">Mετάβαση στη σελίδα</div>
                        <div class="pcat-results-footer-select-elem">
                            <select id="js-blog-page-list">
                                <?php
                                    for($p = 1; $p <= $page_count; $p++){
                                ?>
                                        <option value="<?php echo $p; ?>"><?php echo $p; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                            <div class="pcat-results-footer-select-elem-icon"><?php include get_template_directory() . '/assets/icons/arrow-down-icon.svg'; ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php //get_template_part('product/page-nav/page-nav', 'per-page', [ 'selectDomId' => "js-blog-per-page" ]); ?>
        </div>
    </div>
</section>

<div id="js-blog-filter-load-spinner" class="load-spinner hide"></div>

<?php get_footer(); ?>