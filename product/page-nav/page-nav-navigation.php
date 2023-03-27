<?php
    /**
     * Product Navigation
     * Template Args
     * navWrapperDomId : nav wrapper dom id for javascript working
     * navDomClass : nav dom class for javascript working
     * gotoDomId : goto dom id for javascript working
     * total : total
     * perPage : perPage
     * currentPage : currentPage
     */

     $currentPage = isset($args['currentPage']) ? intval($args['currentPage']) : 1; 
     $total_product_count = isset($args['total']) ? intval($args['total']) : 0; 
     $product_per_page = isset($args['perPage']) ? intval($args['perPage']) : 0; 
?>
<div id="<?php echo $args['navWrapperDomId']; ?>-wrapper" class="pcat-results-footer-options <?php echo $total_product_count > $product_per_page ? '' : 'hide'; ?>">
    <div class="pcat-results-footer-options-col">
        <div id="<?php echo $args['navWrapperDomId']; ?>" class="pcat-results-navigation">
            <?php
                require_once get_template_directory() . '/inc/zebra-pagination.php';

                $pagination = new Zebra_Pagination();
                $pagination->records($total_product_count);
                $pagination->records_per_page($product_per_page);
                $pagination->selectable_pages(5);
                $pagination->set_page($currentPage);
                $pagination->padding(false);
                $pagination->css_classes([
                    'list' => 'pcat-results-navigation-row',
                    'list_item' => $args['navDomClass'] . ' pcat-results-navigation-item',
                    'prev' => $args['navDomClass'] . ' pcat-results-navigation-prev',
                    'next' => $args['navDomClass'] . ' pcat-results-navigation-next',
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
                <select id="<?php echo $args['gotoDomId']; ?>">
                    <?php
                        $pageCounts = $pagination->get_pages();

                        for($i = 1; $i <= $pageCounts; $i++){
                    ?>
                            <option value="<?php echo $i; ?>" <?php echo $i === $currentPage ? 'selected' : '' ?>><?php echo $i; ?></option>
                    <?php
                        }
                    ?>
                </select>
                <div class="pcat-results-footer-select-elem-icon"><?php include get_template_directory() . '/assets/icons/arrow-down-icon.svg'; ?></div>
            </div>
        </div>
    </div>
</div>