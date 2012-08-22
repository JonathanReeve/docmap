<?php head(array('title' => html_escape(exhibit('title') . ' : '. exhibit_page('title')), 'bodyid'=>'exhibit','bodyclass'=>'show')); ?>
	<h1><?php echo link_to_exhibit(); ?></h1>
<div id="primary">

	<h2><?php echo exhibit_page('title'); ?></h2>
	
	<?php exhibit_builder_render_exhibit_page(); ?>
	
	<div id="exhibit-page-navigation">
	   	<?php echo exhibit_builder_link_to_previous_exhibit_page(); ?>
    	<?php echo exhibit_builder_link_to_next_exhibit_page(); ?>
	</div>
</div>	

<div id="secondary">
<div id="nav-container">
	<?php echo exhibit_builder_nested_nav();?>
</div>
</div>
<?php foot(); ?>
