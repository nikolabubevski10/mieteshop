<?php get_header(); ?>
<section class="search-page-title-section">
    <div class="content-container">
        <div class="search-page-title">
            <h1>αποτελέσματα για: <strong>“<?php echo get_search_query(); ?>”</strong></h1>
        </div>
    </div>
</section>
<?php
    $search_type = isset($_GET['search_type']) ? $_GET['search_type'] : 'book';
?>
<section class="search-page-filter-section">
    <div class="search-page-filter-list">
        <div class="js-search-page-filter-item search-page-filter-item <?php echo $search_type === 'book' ? 'active' : ''; ?>" data-search-type="book">ΒΙΒΛΙΑ</div>
        <div class="js-search-page-filter-item search-page-filter-item  <?php echo $search_type === 'art-object' ? 'active' : ''; ?>" data-search-type="art-object" style="display:none;">ΑΝΤΙΚΕΙΜΕΝΑ</div>
        <div class="js-search-page-filter-item search-page-filter-item  <?php echo $search_type === 'contributor' ? 'active' : ''; ?>" data-search-type="contributor">ΣΥΝΤΕΛΕΣΤΕΣ</div>
        <div class="js-search-page-filter-item search-page-filter-item  <?php echo $search_type === 'publisher' ? 'active' : ''; ?>" data-search-type="publisher">ΕΚΔΟΤΕΣ/ ΟΡΓΑΝΙΣΜΟΙ</div>
        <div class="js-search-page-filter-item search-page-filter-item  <?php echo $search_type === 'news' ? 'active' : ''; ?>" data-search-type="news">ΝΕΑ/ ΕΚΔΗΛΩΣΕΙΣ</div>
        <div class="js-search-page-filter-item search-page-filter-item  <?php echo $search_type === 'product-category' ? 'active' : ''; ?>" data-search-type="product-category">ΘΕΜΑΤΙΚΕΣ</div>
    </div>
</section>
<?php
    //echo $search_type .'<br/>';
    if( $search_type === 'book' ){
        get_template_part( 'page-sections/search', 'book' );
    } else if( $search_type === 'art-object' ){
        get_template_part( 'page-sections/search', 'art-object' );
    } else if( $search_type === 'contributor' ){
        get_template_part( 'page-sections/search', 'contributor' );
    } else if( $search_type === 'publisher' ){
        get_template_part( 'page-sections/search', 'publisher' );
    } else if( $search_type === 'news' ){
        get_template_part( 'page-sections/search', 'news' );
    } else if( $search_type === 'product-category' ){
        get_template_part( 'page-sections/search', 'product-category' );
    }
?>
<?php get_footer(); ?>
