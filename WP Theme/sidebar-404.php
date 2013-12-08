<div class="right">
	<?php if(dopt('side_ad_300250')){echo '<div class="right-ad">' . dopt('side_ad_300250') . '</div>';} ?>
	<div class="widget_tagclouds box">
		<h4><strong>标签凌乱</strong></h4>
		<ul>
		<?php $tags_list = get_tags('orderby=count&number=30&order=DESC');
		if ($tags_list) { 
			foreach($tags_list as $tag) {
				echo '<a class="wbtn" href="' . get_tag_link($tag) . '" title="' . $tag->name . '(' . $tag->count . ')">' . $tag->name . '<strong>' . $tag->count . '</strong></a>';
			}
		} ?>
		</ul>
	</div>
	<div class="widget_randposts box">
		<h4><strong>随机阅读</strong></h4>
		<ul>
			<?php $randposts = get_posts('numberposts=6&orderby=rand'); 
				foreach($randposts as $post) {
					setup_postdata($post);
					$title = get_the_title();
					if (strlen($title) == 0) { $title = get_the_time('Y年m月d日') . '无标题文章'; }
					echo '<li><a href="' . get_permalink() . '" rel="bookmark">';
					post_thumbnail(125, 80);
					echo $title . '</a></li>';
				}
				$post = $randposts[0];
				wp_reset_postdata();
			?>
		</ul>
	</div>
	<?php if(dopt('side_ad_260185')){echo '<div class="recommend box"><h4><strong>精品推荐</strong></h4><div>' . dopt('side_ad_260185') . '</div></div>';} ?>
</div>