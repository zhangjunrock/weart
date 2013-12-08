<div class="links box">
	<h4><strong>友情链接</strong></h4>
	<div class="topLink">
		<?php
			$blogrolls_image_name = dopt('blogrolls_image');
			$bookmarks = get_bookmarks(array('orderby' => 'name','category_name' => $blogrolls_image_name));
			if ( $bookmarks ) {
				foreach ($bookmarks as $bookmark) {
					if($bookmark->link_image){
						echo '<a href="' . $bookmark->link_url . '" title="' . $bookmark->link_description . '" target="_blank" ><img src="' . $bookmark->link_image . '" alt="' . $bookmark->link_name . '" /></a>';
						echo "\n";
					}
				}
			}
		?>
	</div>
	<div class="link">
		<?php
			$blogrolls_txt_name = dopt('blogrolls_txt');
			$bookmarks = get_bookmarks(array('orderby' => 'name','category_name' => $blogrolls_txt_name));
			if ( $bookmarks ) {
				foreach ($bookmarks as $bookmark) {
					if(empty($bookmark->link_image)){
						echo '<a href="' . $bookmark->link_url . '" title="' . $bookmark->link_description . '" target="_blank" >' . $bookmark->link_name . '</a>';
						echo "\n";
					}
				}
			}
		?>
	</div>
</div>