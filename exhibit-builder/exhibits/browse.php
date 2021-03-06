<?php
$title = __('Browse Exhibits');
head(array('title'=>$title, 'bodyid' => 'exhibit', 'bodyclass'=>'browse'));
?>
<div id="primary">
    <h1><?php echo $title; ?> <?php echo __('(%s total)', $total_records); ?></h1>
	<?php if (count($exhibits) > 0): ?>
	
	<ul class="navigation" id="secondary-nav">
	    <?php echo nav(array(__('Browse All') => uri('exhibits'), __('Browse by Tag') => uri('exhibits/tags'))); ?>
    </ul>	
	
    <div class="pagination"><?php echo pagination_links(); ?></div>
	
    <div id="exhibits">	
		<?php if ((get_theme_option('Display Featured Exhibit') !== '0')
            		&& plugin_is_active('ExhibitBuilder')
			&& function_exists('exhibit_builder_display_random_featured_exhibit')  			
			&& pinstripe_is_browse_all()): ?> 
		    <?php  
			echo '<div id="browseExhibitsFeaturedExhibit" class="exhibit">'; 
			echo pinstripe_display_random_featured_exhibit(); 
			echo '</div> <!--end browseExhibitsFeaturedExhibit-->'; ?>
    		<?php endif; ?>
		<?php if (pinstripe_is_browse_all()): 
			$tags = get_tags(array('type' => 'exhibit', 'sort' => 'most'), 30);  
			echo pinstripe_tag_cloud_exhibits($tags,uri('exhibits/browse')); 
		endif; 
		?>
    <?php $exhibitCount = 0; ?>
    <?php while(loop_exhibits()): ?>
    	<?php $exhibitCount++; ?>
    	<div class="exhibit <?php if ($exhibitCount%2==1) echo ' even'; else echo ' odd'; ?>">
    		<h2><?php echo link_to_exhibit(); ?></h2>

		<div id="exhibit-credits">	
			<h3><?php 
				$exhibit=get_current_exhibit();
				echo html_escape($exhibit->credits); 
			   ?>
			</h3>
		</div>
		<div class="exhibitImage">
			<?php echo pinstripe_get_first_exhibit_image($exhibitobject, "small") ?>
		</div>  
		<div class="description">
		<p><!--put it in a paragraph if it isn't already-->
		<?php 
				//this strips HTML from exhibit descriptions if the user checked the appropriate box in the theme config. 
			$description=exhibit('description'); 
			if (get_theme_option('Strip HTML Descriptions') == 1) { 
				$description=strip_tags($description, '<p><a>');
				echo $description;
			} else { 
				echo $description; 
			}
		?>
		</p>
		</div>
    		<p class="tags"><?php echo tag_string(get_current_exhibit(), uri('exhibits/browse/tag/')); ?></p>
    	</div>
    <?php endwhile; ?>


    </div>
    
   
    <div id="pagination-bottom" class="pagination"><?php echo pagination_links(); ?></div>

    <?php else: ?>
	<p><?php echo __('There are no exhibits available yet.'); ?></p>
	<?php endif; ?>
</div> <!-- End of Primary --> 
<?php foot(); ?>
