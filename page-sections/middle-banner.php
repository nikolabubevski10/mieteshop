<section class="middle-banner">
    <?php
        $middle_banner_1 = get_field('middle_banner_1');
        $middle_banner_1_link = get_field('middle_banner_1_link');
        $middle_banner_2 = get_field('middle_banner_2');
        $middle_banner_2_link = get_field('middle_banner_2_link');
    ?>
    <div class="wide-container">
        <div class="middle-banner-row">
			<div class="middle-banner-col">	
				<?php
                    if( !empty( $middle_banner_1 ) ){
                ?>
                        <a href="<?php echo esc_url($middle_banner_1_link); ?>">
                            <div class="middle-banner-image">
                                <img
                                    class="lazyload"
                                    src="<?php echo placeholderImage(620, 230); ?>"
                                    data-src="<?php echo aq_resize($middle_banner_1['url'], 620, 230, true); ?>"
                                    alt="<?php echo $middle_banner_1['alt']; ?>">
                            </div>
                        </a>
				<?php
                    }
                ?>
			</div>
			<div class="middle-banner-col">	
				<?php 
				    if( !empty( $middle_banner_2 ) ){
                ?>
                        <a href="<?php echo esc_url($middle_banner_2_link); ?>">
                            <div class="middle-banner-image">
                                <img
                                    class="lazyload"
                                    src="<?php echo placeholderImage(620, 230); ?>"
                                    data-src="<?php echo aq_resize($middle_banner_2['url'], 620, 230, true); ?>"
                                    alt="<?php echo $middle_banner_2['alt']; ?>">
                            </div>
                        </a>
				<?php
                    }
                ?>
			</div>	
        </div>
	</div>
</section>