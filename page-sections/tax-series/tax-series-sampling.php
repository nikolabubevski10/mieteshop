<?php
    $current_series_taxonomy = get_queried_object();
    $series_sampling = get_field('series_sampling', 'series_'.$current_series_taxonomy->term_id);

    if( !empty($series_sampling) ){
?>
        <section class="series-sampling-section">
            <div class="series-sampling-title">
                <h2>Sampling</h2>
            </div>
            <div class="series-sampling-iframe">
                <!--div class="series-sampling-iframe-container"-->
                    <?php
                        if ($series_sampling) {
                            echo '<div class="embed-container">'.$series_sampling.'</div>';
                        }
                    ?>
                <!--/div-->
            </div>
        </section>
<?php
    }
?>