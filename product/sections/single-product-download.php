<?php
    global $product;
    
    $book_contents_file = get_field('book_contents_file', $product->get_id());
    $book_sample_file = get_field('book_sample_file', $product->get_id());
    $book_index_file = get_field('book_index_file', $product->get_id());
    $book_press_kit_file = get_field('book_press_kit_file', $product->get_id());

    $section_class = 'single-product-download-row--center';

    if( !empty($book_contents_file) && !empty($book_sample_file) && !empty($book_index_file) && !empty($book_press_kit_file) ){
        $section_class = '';
    }

    if( !empty($book_contents_file) || !empty($book_sample_file) || !empty($book_index_file) || !empty($book_press_kit_file) ){
?>
        <section class="single-product-download-section">
            <div class="content-container">
                <div class="single-product-download-row <?php echo $section_class; ?>">
                    <?php
                        if( !empty($book_contents_file) ){
                    ?>
                            <div class="single-product-download-col">
                                <a href="<?php echo $book_contents_file['url']; ?>"><div class="single-product-download-label">Περιεχομενα<div class="single-product-download-icon"><?php include get_template_directory() . '/assets/icons/download-icon.svg' ?></div></div></a>
                            </div>
                    <?php
                        }

                        if( !empty($book_sample_file) ){
                    ?>
                            <div class="single-product-download-col">
                                <a href="<?php echo $book_sample_file['url']; ?>"><div class="single-product-download-label">δειγμα<div class="single-product-download-icon"><?php include get_template_directory() . '/assets/icons/download-icon.svg' ?></div></div></a>
                            </div>
                    <?php
                        }

                        if( !empty($book_index_file) ){
                    ?>
                            <div class="single-product-download-col">
                                <a href="<?php echo $book_index_file['url']; ?>"><div class="single-product-download-label">ευρετηριο<div class="single-product-download-icon"><?php include get_template_directory() . '/assets/icons/download-icon.svg' ?></div></div></a>
                            </div>
                    <?php
                        }

                        if( !empty($book_press_kit_file) ){
                    ?>
                            <div class="single-product-download-col">
                                <a href="<?php echo $book_press_kit_file['url']; ?>"><div class="single-product-download-label">press kit<div class="single-product-download-icon"><?php include get_template_directory() . '/assets/icons/download-icon.svg' ?></div></div></a>
                            </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </section>
<?php
    }
?>