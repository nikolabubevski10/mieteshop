<?php
    /**
     * Product Display Counts Setting
     * Template Args
     * selectDomId : dropdown html element id for javascript working
     * perPage : perPage
     */

    $perPage = isset($args['perPage']) ? intval($args['perPage']) : 0; 
?>
<div class="pcat-results-projection-options">
    <div class="pcat-results-footer-select">
        <div class="pcat-results-footer-select-label">Προβολή</div>
        <div class="pcat-results-footer-select-elem">
            <select id="<?php echo $args['selectDomId']; ?>">
                <?php
                    if( wp_is_mobile() ){
                ?>
                        <option value="4" <?php echo $perPage === 4 ? 'selected' : ''; ?> >4</option>
                <?php
                    }
                ?>
                <option value="16" <?php echo $perPage === 16 ? 'selected' : ''; ?> >16</option>
                <option value="32" <?php echo $perPage === 32 ? 'selected' : ''; ?> >32</option>
                <option value="64" <?php echo $perPage === 64 ? 'selected' : ''; ?> >64</option>
            </select>
            <div class="pcat-results-footer-select-elem-icon"><?php include get_template_directory() . '/assets/icons/arrow-down-icon.svg'; ?></div>
        </div>
    </div>
</div>