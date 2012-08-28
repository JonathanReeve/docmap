<?php 
/**
 * Use this file to define customized helper functions, filters or 'hacks'
 * defined specifically for use in your Omeka theme. Ideally, you should
 * namespace these with your theme name to avoid conflicts with functions
 * in Omeka and any plugins.
 */

function pinstripe_get_first_exhibit_image($exhibitobject, $size) {
	if(empty($exhibitobject)){
		$exhibitobject=get_current_exhibit();
	}
		// from nancym, https://groups.google.com/forum/?fromgroups#!topic/omeka-dev/OGo6LMBOedk 
		$itemcount=0;
		$page="";
		$section = $exhibitobject->getFirstSection();
		if(!empty($section)){
			$page= $exhibitobject->getFirstSection()->getPageByOrder(1);
			$itemcount = count($page['ExhibitPageEntry']);

			$itempageobject = $page['ExhibitPageEntry'];
			$found=false;
			if($itemcount>0){
				for ($i=1; $i <= $itemcount; $i++) {
					if($found!=true){
						$item = $itempageobject[$i]['Item'];
						if(!empty($item)){
							while (loop_files_for_item($item)):
								$file = get_current_file();                                             
								
						//	print_r($file);
							     if ($size=="small") $html=('<img  class="exhibitImage" src="'.item_file('square thumbnail uri').'" />');
							     if ($size=="large") $html=('<img  class="exhibitImage" src="'.item_file('thumbnail uri').'" />');
							return $html;
							//exit;
							if ($file->hasThumbnail()):                
								if ($index == 0):                        
									$Exhibit_image = array('image'=>'/'.$file->getStoragePath('fullsize'),'title'=>item('Dublin Core','Title',array(),$item));
//							     print_r($file->getStoragePath('thumbnail'));
							//     exit;
							$index=1;
							$found=true;
endif;
endif;
endwhile;
						}                    
					}
				}
			} 
		}
}

function pinstripe_display_random_featured_exhibit_slider()
{
    $html = '<div id="featured-exhibit">';
    $featuredExhibit = exhibit_builder_random_featured_exhibit();
    $html .= '<h2>' . __('Featured Exhibit') . '<span class="ribbonEffect"></span></h2>';
    $exhibitobject=$featuredExhibit;
	    $html .= '<div id="sliderContainer"><!--Start Slider-->
		    		<div id="mySlides"> 
					<div id="slide1" class="slide">
						<img src="http://cinderellatravel.com/wp-content/uploads/2012/04/Excellence_Food_Sample-600x300.jpg"  /> 
						<div class="slideContent">
						<h3>Title of Exhibit Here</h3>
						<p>Description Here</p>
						</div><!--end slideContent-->
					</div> <!--end slide1-->
					<div id="slide2" class="slide">
						<img src="http://everybliss.com/wp-content/uploads/2012/07/example-2-600x300.jpg"  /> 
					</div> <!--end slide2-->
					<div id="slide3" class="slide">
						<img src="http://cinderellatravel.com/wp-content/uploads/2012/01/ocean_club_bahamas_weddings_12_01_2011_8484-600x300.jpg" /> 
					</div> <!--end slide3-->
				</div> <!--end mySlides-->
				<div id="myController">
					<span class="jFlowControl">1</span>
					<span class="jFlowControl">2</span>
					<span class="jFlowControl">3</span>
				</div>
				<div class="jFlowPrev"></div>
				<div class="jFlowNext"></div>
				</div> <!--end of myController--> 
		      </div><!--end of sliderContainer-->';
    $html .= '</div><!--End of featured-exhibit-->';
    $html = apply_filters('exhibit_builder_display_random_featured_exhibit', $html);
    return $html;
}

//adapted from the rhythm theme
function pinstripe_display_random_featured_exhibit()
{
    $html = '<div id="featured-exhibit">';
    $featuredExhibit = exhibit_builder_random_featured_exhibit();
    $html .= '<h2>' . __('Featured Exhibit') . '<span class="ribbonEffect"></span></h2>';
    $exhibitobject=$featuredExhibit;
    $html .= '<div class="exhibitImage">'.pinstripe_get_first_exhibit_image($exhibitobject, $size="small").'</div>';
    if ($featuredExhibit) {
       $html .= '<div id="featuredExhibitDescription" ><h3>' . exhibit_builder_link_to_exhibit($featuredExhibit) . '</h3>'."\n";
       $credits=html_escape($exhibitobject->credits);
       $html .= '<div id="exhibit-credits"><h3>'.$credits.'</h3></div>';
       $html .= '<p>'.pinstripe_snippet_by_word_count(exhibit('description', array(), $featuredExhibit),50).'</p></div><!--end featuredExhibitDescription-->';
    } else {
       $html .= '<p>' . __('You have no featured exhibits.') . '</p>';
    }
    $html .= '</div>';
    $html = apply_filters('exhibit_builder_display_random_featured_exhibit', $html);
    return $html;
}

/**
 * Returns the HTML markup for displaying a random featured item.  Most commonly
 * used on the home page of public themes.
 *
 * @since 0.10
 * @param boolean $withImage Whether or not the featured item should have an image associated
 * with it.  If set to true, this will either display a clickable square thumbnail
 * for an item, or it will display "You have no featured items." if there are
 * none with images.
 * @return string HTML
 */
function pinstripe_display_random_featured_item($withImage = null)
{
    $html = '<h2>'. __('Featured Item') .'<span class="ribbonEffect"></span></h2>';
    $html .= pinstripe_display_random_featured_items('1', $withImage);
    return $html;
}

function pinstripe_display_random_featured_items($num = 5, $hasImage = null)
{
    $html = '';

    if ($randomFeaturedItems = random_featured_items($num, $hasImage)) {
        foreach ($randomFeaturedItems as $randomItem) {
            $itemTitle = item('Dublin Core', 'Title', array(), $randomItem);

	    if (item_has_thumbnail($randomItem)) {
                $html .= '<div id="randomFeaturedItemImage">'.link_to_item(item_square_thumbnail(array(), 0, $randomItem), array('class'=>'image'), 'show', $randomItem).'</div>';
            }

            $html .= '<div id="featuredItemMetadata"><h3>' . link_to_item($itemTitle, array(), 'show', $randomItem) . '</h3>';

            

            if ($itemDescription = item('Dublin Core', 'Description', array('snippet'=>150), $randomItem)) {
                $html .= '<p class="item-description">' . $itemDescription . '</p></div><!--end featuredItemMetadata-->';
            }
        }
    } else {
        $html .= '<p>'.__('No featured items are available.').'</p>';
    }

    return $html;
}

/**
 * Retrieve a substring of the text by limiting the word count.
 * Note: it strips the HTML tags from the text before getting the snippet
 *
 * @since 0.10
 * @param string $text
 * @param integer $maxWords
 * @param string $ellipsis Optional '...' by default.
 * @return string
 */
function pinstripe_snippet_by_word_count($text, $maxWords = 20, $ellipsis = ' ... ')
{
    // strip html tags from the text
    $text = strip_formatting($text);

    if ($maxWords > 0) {
        $textArray = explode(' ', $text);
        if (count($textArray) > $maxWords) {
            $text = implode(' ', array_slice($textArray, 0, $maxWords)) . $ellipsis;
        }
    } else {
        return '';
    }
    return $text;
}

/**
 * Returns the HTML markup for displaying a random featured collection.
 *
 * @since 0.10
 * @return string
 */
function pinstripe_display_random_featured_collection()
{
    $featuredCollection = random_featured_collection();
    $html = '<h2>' . __('Featured Collection') . '<span class="ribbonEffect"></span></h2>';
    if ($featuredCollection) {
        $html .= '<h3>' . link_to_collection($collectionTitle, array(), 'show', $featuredCollection) . '</h3>';
        if ($collectionDescription = collection('Description', array('snippet'=>150), $featuredCollection)) {
            $html .= '<p class="collection-description">' . $collectionDescription . '</p>';
        }

    } else {
        $html .= '<p>' . __('No featured collections are available.') . '</p>';
    }
    return $html;
}

function pinstripe_get_first_collection_images() {
	if (total_items_in_collection() == 0) {
		/* find child items  */
		$collectionId = collection('ID');
		$childArray=pinstripe_get_child_collections($collectionId);
		$thumbnailCount=0;
		$childCount=0;
		while ($thumbnailCount <= 3): 
			$childID=$childArray[$childCount]['id'];
			set_current_collection(get_collection_by_id($childID));
			while (loop_items_in_collection() AND $thumbnailCount <= 3){
				echo item_square_thumbnail();
				$thumbnailCount++;
			}
			$childCount++;
		endwhile;
	} else {
	while(loop_items_in_collection(4)) echo item_square_thumbnail();
	return $html;
	}
}

function pinstripe_get_child_collections($collectionId) {
    if(plugin_is_active('CollectionTree')) {
        $treeChildren = get_db()->getTable('CollectionTree')->getChildCollections($collectionId);
        $childCollections = array();
        foreach($treeChildren as $treeChild) {
            $childCollections[] = get_collection_by_id($treeChild['id']);
        }
        return $childCollections;
    }
    return array();
}

/* adapted from function tag_cloud
 * returns html with tag count instead of font size category
 */
function pinstripe_tag_cloud($recordOrTags = null, $link = null, $maxClasses = 9)
{
    if (!$recordOrTags) {
        $recordOrTags = array();
    }

    if ($recordOrTags instanceof Omeka_Record) {
        $tags = $recordOrTags->Tags;
    } else {
        $tags = $recordOrTags;
    }

    if (empty($tags)) {
        $html = '<p>'. __('No tags are available.') .'</p>';
        return $html;
    }

    //Get the largest value in the tags array
    $largest = 0;
    foreach ($tags as $tag) {
        if($tag["tagCount"] > $largest) {
            $largest = $tag['tagCount'];
        }
    }
    $html = '<div class="hTagcloud">';
    $html .= '<ul class="popularity">';

    if ($largest < $maxClasses) {
        $maxClasses = $largest;
    }

    foreach( $tags as $tag ) {
        $size = (int)(($tag['tagCount'] * $maxClasses) / $largest - 1);
	$count=$tag['tagCount'];
        $html .= '<li>';
        if ($link) {
            $html .= '<a href="' . html_escape($link . '?tags=' . urlencode($tag['name'])) . '">';
        }
        $html .= html_escape($tag['name']);
        if ($link) {
            $html .= '</a> ('.$count.')';
        }
        $html .= '</li>' . "\n";
    }
    $html .= '</ul></div>';

    return $html;
}

/* adapted from function tag_cloud
 * returns html with tag count instead of font size category
 * this one is for the exhibits page, contains h2 elements and such 
 */
function pinstripe_tag_cloud_exhibits($recordOrTags = null, $link = null, $maxClasses = 9)
{
    if (!$recordOrTags) {
        $recordOrTags = array();
    }

    if ($recordOrTags instanceof Omeka_Record) {
        $tags = $recordOrTags->Tags;
    } else {
        $tags = $recordOrTags;
    }

    if (empty($tags)) {
        $html = '<p>'. __('No tags are available.') .'</p>';
        return $html;
    }

    //Get the largest value in the tags array
    $largest = 0;
    foreach ($tags as $tag) {
        if($tag["tagCount"] > $largest) {
            $largest = $tag['tagCount'];
        }
    }

    $html .= '<div id="hTagCloudContainer_exhibits">';
    $html .= '<h2>Top Tags</h2>';
    $html .= '<div class="hTagcloud">';
    $html .= '<ul class="popularity">';

    if ($largest < $maxClasses) {
        $maxClasses = $largest;
    }

    foreach( $tags as $tag ) {
        $size = (int)(($tag['tagCount'] * $maxClasses) / $largest - 1);
	$count=$tag['tagCount'];
        $html .= '<li>';
        if ($link) {
            $html .= '<a href="' . html_escape($link . '?tags=' . urlencode($tag['name'])) . '">';
        }
        $html .= html_escape($tag['name']);
        if ($link) {
            $html .= '</a> ('.$count.')';
        }
        $html .= '</li>' . "\n";
    }
    $html .= '</ul></div>';
    $html .= '</div> <!-- end div id="hTagCloudContainer" -->'; 

    return $html;
}
function pinstripe_custom_nav_items($navArray = array())
{
    if (!$navArray) {
        $navArray = array(__('Browse All') => uri('items'), __('Browse by Tag') => uri('items/tags'));
    }

    // Check to see if the function public_nav_items, introduced in Omeka 1.3, exists.
    if (function_exists('public_nav_items')) {
        return public_nav_items($navArray);
    } else {
        return nav($navArray);
    }
}

/* This function tells whether you're on the /omeka/exhibits page or a search results page, like /omeka/exhibits/browse?tags=photographs
 * This helps to differentiate the pages so that the search results page doesn't show a featured exhibit and tag list. 
 * returns TRUE if the URL basename is /exhibits, returns FALSE if the URL basename is something else */  
function pinstripe_is_browse_all() { 
	$uri=$_SERVER[REQUEST_URI];
	$parsed=basename($uri);
	return ($parsed==exhibits); 
}

?>
