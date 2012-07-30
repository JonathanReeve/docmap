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
							echo item_square_thumbnail($item);
							while (loop_files_for_item($item)):
								$file = get_current_file();                                             
//							print_r($file['archive_filename']);
							   //  echo($file->getStoragePath('square thumbnail'));
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





function pinstripe_get_exhibit_image() { 
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
                            print_r($file['archive_filename']);
                            //exit;
                            if ($file->hasThumbnail()):                
                                if ($index == 0):                        
                                     $Exhibit_image = array('image'=>'/'.$file->getStoragePath('fullsize'),'title'=>item('Dublin Core','Title',array(),$item));
                                //     print_r($file->getStoragePath('fullsize'));
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


//pulls featured exhibits and one image for use in slideshow
//see README file before trying to reuse (requires plugin hack)
function pinstripe_display_exhibit_gallery($exhibits_array=array()){
        $featured_exhibits = array(1,2,3); //todo: figure out how to populate this array using exhibit_builder_get_exhibits(), which throws an error for some reason
        foreach($featured_exhibits as $featured_exhibit){
        $exhibit = exhibit_builder_get_exhibit_by_id($featured_exhibit);
        $items = get_items(array('exhibit' => $featured_exhibit),1);
        if ($items!=null) //todo: make sure that the item also is an image (non-image will probably break function, or at least slideshow)
        {
        set_items_for_loop($items);
        while(loop_items()):
        //get exhibit item
            $index = 0; 
            while ($file = loop_files_for_item()):
                if ($file->hasThumbnail()):
                //this makes sure the loop grabs only the first image for the exhibit item 
                    if ($index == 0): 
                       echo '<div><img src="'.$file->getWebPath('fullsize').'"/>'; 
                    endif;
                endif; 
            endwhile;
        endwhile; 
        echo '<div class="showcase-caption">';
        echo /*Exhibit Title and Link*/'<h3><a href="'.$exhibit->slug.'">'.$exhibit->title.'</a></h3>';
        echo /*Exhibit Description Excerpt*/'<p>'.snippet($exhibit->description, 0, 300,exhibit_builder_link_to_exhibit($exhibit, '<br/>...more')).'';
        echo '</p></div></div>';
        }
        else 
            {
            //Exhibit with no files
            echo'<div><img src="'.uri('').'/themes/deco/images/poster.jpg" alt="Oops! This exhibit has no preview image" />
            <div class="showcase-caption">
            <h3>'.exhibit_builder_link_to_exhibit($exhibit->slug,$exhibit->title).'</h3>
            <p>'.snippet($exhibit->description, 0, 300,exhibit_builder_link_to_exhibit($exhibit, '<br/>...more')).'</p></div></div>';
            }
        }
    } 
?>
