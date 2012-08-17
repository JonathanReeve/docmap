<?php
$pageTitle = __('Browse Collections');
head(array('title'=>$pageTitle,'bodyid'=>'collections','bodyclass' => 'browse'));
?>
<div id="primary">
    <h1><?php echo $pageTitle; ?></h1>
    <div class="pagination pagination_left"><?php echo pagination_links(); ?></div>
    <div class="clear"></div>

    <?php while (loop_collections()): ?>
    <div class="collection">

        <h2><?php echo link_to_collection(); ?></h2>
	<div class="collectionImage">
		<?php echo pinstripe_get_first_collection_images() ?>
        </div><!--end collectionImage-->
        <div class="element">
            <div class="element-text"><?php echo nls2p(collection('Description', array('snippet'=>250))); ?></div>
        </div>

        <?php echo plugin_append_to_collections_browse_each(); ?>

    </div><!-- end class="collection" -->
    <?php endwhile; ?>

    <?php echo plugin_append_to_collections_browse(); ?>

</div><!-- end primary -->

<?php foot(); ?>
