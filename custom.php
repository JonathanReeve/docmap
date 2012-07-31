<?php 
/**
 * Use this file to define customized helper functions, filters or 'hacks'
 * defined specifically for use in your Omeka theme. Ideally, you should
 * namespace these with your theme name to avoid conflicts with functions
 * in Omeka and any plugins.
 */

function pinstripe_get_first_exhibit_image() {
	$exhibitobject=get_current_exhibit();
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
							     echo('<img src="'.item_file('square thumbnail uri').'" />');
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

function pinstripe_display_random_featured_exhibit()
{
    $html = '<div id="featured-exhibit">';
    $featuredExhibit = exhibit_builder_random_featured_exhibit();
    $html .= '<h2>' . __('Featured Exhibit') . '</h2>';
    $html .= pinstripe_get_first_exhibit_image();
    if ($featuredExhibit) {
       $html .= '<h3>' . exhibit_builder_link_to_exhibit($featuredExhibit) . '</h3>'."\n";
       $html .= '<p>'.snippet_by_word_count(exhibit('description', array(), $featuredExhibit)).'</p>';
    } else {
       $html .= '<p>' . __('You have no featured exhibits.') . '</p>';
    }
    $html .= '</div>';
    $html = apply_filters('exhibit_builder_display_random_featured_exhibit', $html);
    return $html;
}

?>
