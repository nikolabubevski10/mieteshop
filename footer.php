<footer class="site-footer">
    <div class="footer-top">
        <div class="small-container">
            <div class="footer-top-row">
                <div class="footer-top-left-col">
                    <div class="footer-news-letter-form">
                        <?php echo do_shortcode('[ms-form id=1]'); ?>
                        <script>
                            jQuery('.footer-news-letter-form input[type=email]').attr('placeholder', 'Διεύθυνση email');
                            jQuery('.footer-news-letter-form form').submit(function(){
                                mootrack('identify', jQuery('.footer-news-letter-form input[type=email]').val());
                            })
                        </script>
                    </div>
                </div>
                <div class="footer-top-right-col">
                    <div class="footer-top-social-row">
                        <div class="footer-top-social-col">
                            <a href="<?php echo get_field('youtube_url', 'option'); ?>"><div class="footer-top-social-icon footer-top-social-icon--youtube"><?php include get_template_directory() . '/assets/icons/youtube-large-icon.svg' ?></div></a>
                        </div>
                        <div class="footer-top-social-col">
                            <a href="<?php echo get_field('sound_cloude_url', 'option'); ?>"><div class="footer-top-social-icon footer-top-social-icon--sound-cloude"><?php include get_template_directory() . '/assets/icons/sound-cloude-large-icon.svg' ?></div></a>
                        </div>
                        <div class="footer-top-social-col">
                            <a href="<?php echo get_field('facebook_url', 'option'); ?>"><div class="footer-top-social-icon footer-top-social-icon--facebook"><?php include get_template_directory() . '/assets/icons/facebook-large-icon.svg' ?></div></a>
                        </div>
                        <div class="footer-top-social-col">
                            <a href="<?php echo get_field('instagram_url', 'option'); ?>"><div class="footer-top-social-icon footer-top-social-icon--instagram"><?php include get_template_directory() . '/assets/icons/instagram-large-icon.svg' ?></div></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<section class="footer-middle">
	<div class="general-container">
		<div class="footer-middle-row">
			<div class="footer-middle-col">
				<div class="footer-middle-item"><span class="footer-middle-item-icon footer-middle-item-icon--bus"><?php include get_template_directory() . '/assets/icons/bus-icon.svg' ?></span>Δωρεάν μεταφορικά και δωρεάν αντικαταβολή από 30€</div>
			</div>
			<div class="footer-middel-col">
				<div class="footer-middle-item"><span class="footer-middle-item-icon footer-middle-item-icon--calendar"><?php include get_template_directory() . '/assets/icons/calendar-icon.svg' ?></span>Αποστολή εντός 3 ημερών</div>
			</div>
		</div>
	</div>
</section>    
    <div class="footer-menu">
        <?php
            $theme_locations = get_nav_menu_locations();
            $footer_menu_1 = wp_get_nav_menu_object($theme_locations['footer-menu-1']);
            $footer_menu_2 = wp_get_nav_menu_object($theme_locations['footer-menu-2']);
            $footer_menu_3 = wp_get_nav_menu_object($theme_locations['footer-menu-3']);
            $footer_menu_4 = wp_get_nav_menu_object($theme_locations['footer-menu-4']);
        ?>
        <div class="small-container">
            <div class="footer-menu-row">
                <div class="footer-menu-col">
                    <div class="footer-menu-title">
                        <h2><?php echo $footer_menu_1->name; ?></h2>
                    </div>
                    <?php
                        wp_nav_menu([
                            'theme_location' => 'footer-menu-1',
                            'container_class' => 'footer-menu-list',
                            'container' => 'nav',
                        ]);
                    ?>
                </div>
                <div class="footer-menu-col">
                    <div class="footer-menu-title">
                        <h2><?php echo $footer_menu_2->name; ?></h2>
                    </div>
                    <?php
                        wp_nav_menu([
                            'theme_location' => 'footer-menu-2',
                            'container_class' => 'footer-menu-list',
                            'container' => 'nav',
                        ]);
                    ?>
                </div>
                <!--div class="footer-menu-col">
                    <div class="footer-menu-title">
                        <h2><?php //echo $footer_menu_3->name; ?></h2>
                    </div>
                    <?php
                        /*
                        wp_nav_menu([
                            'theme_location' => 'footer-menu-3',
                            'container_class' => 'footer-menu-list',
                            'container' => 'nav',
                        ]);
                        */
                    ?>
                </div-->
                <div class="footer-menu-col">
                    <div class="footer-menu-title">
                        <h2><?php echo $footer_menu_4->name; ?></h2>
                    </div>
                    <?php
                        wp_nav_menu([
                            'theme_location' => 'footer-menu-4',
                            'container_class' => 'footer-menu-list',
                            'container' => 'nav',
                        ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-description">
        <div class="container">
            <div class="footer-description-row">
                <div class="footer-description-left-col">&copy; <?php echo date('Y'); ?> MIET</div>
                <div class="footer-description-right-col"><?php echo get_field('footer_description', 'option'); ?></div>                
            </div>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
<?php
    // integrate moosend
    if( is_user_logged_in() ){
        global $current_user;
        get_currentuserinfo();
?>
        <script>mootrack('identify', '<?php echo $current_user->user_email; ?>');</script>
<?php
    }
?>
</body>
</html>
