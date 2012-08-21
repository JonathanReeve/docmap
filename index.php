<?php head(array('bodyid'=>'home')); ?>

<div id="primary">

    <?php if (get_theme_option('Homepage Text')): ?>
    <p><?php echo get_theme_option('Homepage Text'); ?></p>
    <?php endif; ?>

    <?php if ((get_theme_option('Display Featured Exhibit') !== '0')
            && plugin_is_active('ExhibitBuilder')
            && function_exists('exhibit_builder_display_random_featured_exhibit')): ?>
    <!-- Featured Exhibit -->
    <?php echo pinstripe_display_random_featured_exhibit(); ?>
    <?php endif; ?>


    <?php if (get_theme_option('Display Featured Item') !== '0'): ?>
    <!-- Featured Item -->
    <div id="featured-item">
        <?php echo pinstripe_display_random_featured_item(); ?>
    </div><!--end featured-item-->
    <?php endif; ?>

    <?php if (get_theme_option('Display Featured Collection') !== '0'): ?>
    <!-- Featured Collection -->
    <div id="featured-collection">
        <?php echo pinstripe_display_random_featured_collection(); ?>
    </div><!-- end featured collection -->
    <?php endif; ?>

</div><!-- end primary -->

<div id="secondary">


        <?php
        $homepageRecentItems = (int)get_theme_option('Homepage Recent Items') ? get_theme_option('Homepage Recent Items') : '0';
	if ($homepageRecentItems != 0) set_items_for_loop(recent_items($homepageRecentItems)); 
	if (has_items_for_loop()):
        ?>

    <div id="recent-items">
        <h2><?php echo __('Recently Added Items'); ?></h2>
        <div class="items-list">
            <?php while (loop_items()): ?>
            <div class="item">

                <h3><?php echo link_to_item(); ?></h3>

                <?php if(item_has_thumbnail()): ?>
                <div class="item-img">
                    <?php echo link_to_item(item_square_thumbnail()); ?>
                </div> <!--End  -->
                <?php endif; ?>

                   </div> <!--End  -->   
            <?php endwhile; ?>
        </div> <!--End  -->

    </div><!--end recent-items -->
        <?php endif; ?>

</div><!-- end secondary -->

<?php foot(); ?>
