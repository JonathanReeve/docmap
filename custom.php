<?php 
/**
 * Use this file to define customized helper functions, filters or 'hacks'
 * defined specifically for use in your Omeka theme. Ideally, you should
 * namespace these with your theme name to avoid conflicts with functions
 * in Omeka and any plugins.
 */

function pinstripe_get_first_exhibit_image($exhibitobject) {
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
							     $html=('<img  class="exhibitImage" src="'.item_file('square thumbnail uri').'" />');
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

//adapted from the rhythm theme
function pinstripe_display_random_featured_exhibit()
{
    $html = '<div id="featured-exhibit">';
    $featuredExhibit = exhibit_builder_random_featured_exhibit();
    $html .= '<h2>' . __('Featured Exhibit') . '<span class="ribbonEffect"></span></h2>';
    $exhibitobject=$featuredExhibit;
    $html .= '<div class="exhibitImage">'.pinstripe_get_first_exhibit_image($exhibitobject).'</div>';
    if ($featuredExhibit) {
       $html .= '<div id="featuredExhibitDescription" ><h3>' . exhibit_builder_link_to_exhibit($featuredExhibit) . '</h3>'."\n";
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
    $html = '<h2>' . __('Featured Collection') . '</h2>';
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


?>
