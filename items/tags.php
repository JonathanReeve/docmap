<?php
$pageTitle = __('Browse Items');
head(array('title'=>$pageTitle,'bodyid'=>'items','bodyclass'=>'tags'));
?>

<div id="primary">

    <h1><?php echo $pageTitle; ?></h1>

    <ul class="navigation item-tags" id="secondary-nav">
        <?php echo custom_nav_items(); ?>
    </ul>

<div id="tags_alpha" class="bigTagCloud">
    <h2>All Tags Sorted Alphabetically</h2>
    <?php 
	$tags = get_tags(array('sort' => 'alpha'), null);
	echo tag_cloud($tags,uri('items/browse')); 
    ?>
</div>
<div id="tags_most" class="bigTagCloud">
    <h2>All Tags Sorted by Frequency of Occurrence</h2>
    <?php 
	$tags = get_tags(array('sort' => 'most'), null);
	echo tag_cloud($tags,uri('items/browse')); 
    ?>
</div>

</div><!-- end primary -->

<?php foot(); ?>
