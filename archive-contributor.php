<?php
    global $post, $wpdb;

    get_header();
?>
<section class="archive-contributor-title">
    <div class="content-container">
        <h1>Συγγραφείς</h1>
    </div>
</section>
<div class="archive-contributor-search-section">
    <div class="general-container">
        <div class="content-container">
            <div class="archive-contributor-search-greek-letter-wrapper">
                <div class="archive-contributor-search-greek-letter-row">
                    <?php
                        $greek_letter_list = ['α','β','γ','δ','ε','ζ','η','θ','ι','κ','λ','μ','ν','ξ','ο','π','ρ','σ','τ','υ','φ','χ','ψ','ω'];
                        for($i = 0; $i < 24; $i++){
                    ?>
                            <div class="archive-contributor-search-greek-letter-col js-archive-contributor-search-greek-letter-col <?php echo $i == 0 ? 'active' : ''; ?>"><?php echo $greek_letter_list[$i]; ?></div>
                    <?php
                        }
                    ?>
                </div>
            </div>
            <div class="archive-contributor-search-english-letter-wrapper">
                <div class="archive-contributor-search-english-letter-row">
                    <?php
                        $english_letter_list = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];

                        for($i = 0; $i < 26; $i++){
                    ?>
                            <div class="archive-contributor-search-english-letter-col js-archive-contributor-search-english-letter-col"><?php echo $english_letter_list[$i]; ?></div>
                    <?php
                        }
                    ?>
                </div>
            </div>
            <div class="archive-contributor-search-result-row">
                <?php
                    $args = [
                        'post_type' => 'contributor',
                        'posts_per_page' => -1,
                        'fields' => 'ids',
                        'meta_key' => 'contributor_first_name',
                        'meta_query' => [
                            [
                                'key'     => 'book_contributors_syggrafeas',
                                'value'   => array(''),
                                'compare' => 'NOT IN',
                            ],
                            'contributor_last_name_clause' => [
                                'key' => 'contributor_last_name',
                                'value'   => '^α',
                                'compare' => 'REGEXP',
                            ],
                        ],
                        'orderby' => [
                            'contributor_last_name_clause' => 'ASC',
                            'meta_value' => 'ASC',
                        ]
                    ];
                
                    $qryContributors = new WP_Query( $args );
                ?>
                <div class="archive-contributor-search-result-left-col">
                    <?php //echo $qryContributors->found_posts .' <br/>'; ?>
                    <span id="js-archive-contributor-search-result-count"></span> Συγγραφείς
                </div>
                <div class="archive-contributor-search-result-right-col">
                    <div id="js-archive-contributor-search-result-list" class="archive-contributor-search-result-list" data-nonce="<?php echo wp_create_nonce('filter_search_archive_contributor_nonce'); ?>">
                        <?php
                        $contrCount=0;                        
                        foreach( $qryContributors->posts as $contributor_id ) {
                            $ContributorBooks = get_field('book_contributors_syggrafeas', $contributor_id);
                            //echo $ContributorBooks->post_title .'<br/>';

                            // check that the contributor is connected with published books
                            $atLeastOnePublished = false;
                            foreach($ContributorBooks as $ContributorBook) {                                
                                if($ContributorBook->post_status == 'publish') {
                                    $atLeastOnePublished = true;
                                    //echo '<strong>'.$ContributorBook->post_title .'</strong><br/>';
                                    break;
                                }
                            }   
                            
                            if($atLeastOnePublished === true) { //display only contributors who have at least one published book
                                ?>  
                                <div class="archive-contributor-search-result-col"><a href="<?php echo get_permalink($contributor_id); ?>"><?php echo get_field('contributor_last_name', $contributor_id); ?> <?php echo get_field('contributor_first_name', $contributor_id); ?></a></div>                                  
                                <?php
                                $contrCount++;
                            }
                        }

                        wp_reset_query();
                        ?>
                        <div>
                            <script>
                                jQuery('#js-archive-contributor-search-result-count').text("<?php echo $contrCount; ?>");
                            </script>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="js-archive-contributor__load-spinner" class="load-spinner hide"></div>

<?php get_footer(); ?>