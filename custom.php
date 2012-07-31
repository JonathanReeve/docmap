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
?>
