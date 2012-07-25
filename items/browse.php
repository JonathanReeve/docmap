<?php
$pageTitle = __('Browse Items');
head(array('title'=>$pageTitle,'bodyid'=>'items','bodyclass' => 'browse'));
?>

<div id="primary">

    <h1><?php echo $pageTitle;?> <?php echo __('(%s total)', total_results()); ?></h1>

    <ul class="items-nav navigation" id="secondary-nav">
        <?php echo custom_nav_items(); ?>
    </ul>

    <div id="pagination-top" class="pagination"><?php echo pagination_links(); ?></div>
    <div class="clear"></div>
   <div id="hTagCloudContainer_items">
	<a href="./tags"><h2>Top 30 Tags</h2></a>
	<?php 
		$tags = get_tags(array('sort' => 'most'), 30);  
		echo tag_cloud($tags,uri('exhibits/browse')); 
	?>
    </div> <!-- end div id="hTagCloudContainer" --> 
    <?php while (loop_items()): ?>
    <div class="item hentry"><div class="mosaic-block bar">

        <div class="item-meta">

        <div class="mosaic-overlay"><h2><?php echo link_to_item(item('Dublin Core', 'Title'), array('class'=>'permalink')); ?></h2></div>

        <?php if (item_has_thumbnail()): ?>
        <div class="item-img mosaic-backdrop">
            <?php echo link_to_item(item_square_thumbnail()); ?>
        </div>
        <?php endif; ?>

        <?php if ($text = item('Item Type Metadata', 'Text', array('snippet'=>250))): ?>
        <div class="item-description">
            <p><?php echo $text; ?></p>
        </div>
        <?php elseif ($description = item('Dublin Core', 'Description', array('snippet'=>250))): ?>
        <div class="item-description">
            <?php echo $description; ?>
        </div>
        <?php endif; ?>

        <?php if (item_has_tags()): ?>
        <div class="tags"><p><strong><?php echo __('Tags'); ?>:</strong>
            <?php echo item_tags_as_string(); ?></p>
        </div>
        <?php endif; ?>

        <?php echo plugin_append_to_items_browse_each(); ?>

        </div><!-- end class="item-meta" -->
    </div><!--end class="mosaic-block bar"--></div><!-- end class="item hentry" -->
    <?php endwhile; ?>

    <div id="pagination-bottom" class="pagination"><?php echo pagination_links(); ?></div>

    <?php echo plugin_append_to_items_browse(); ?>

</div><!-- end primary -->

<?php foot(); ?>
