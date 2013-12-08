<div class="gridad">
	<ul>
		<?php if(dopt('4category')){ 
			$gridId = dopt('4categoryid');
			$gridposts = get_posts('cat=' . $gridId . '&numberposts=4&orderby=DESC'); 
			foreach($gridposts as $post) {
				setup_postdata($post);
				$title = get_the_title();
				if (strlen($title) == 0) { $title = get_the_time('Y年m月d日') . '无标题文章'; }
				echo '<li><a href="' . get_permalink() . '" target="_blank" title="' . $title . '">';
				post_thumbnail(225, 130);
				echo '</a></li>';
			}
			$post = $gridposts[0];
			wp_reset_postdata();
		}else{ ?>
			<li><?php echo dopt('4gridad_01'); ?></li>
			<li><?php echo dopt('4gridad_02'); ?></li>
			<li><?php echo dopt('4gridad_03'); ?></li>
			<li><?php echo dopt('4gridad_04'); ?></li>
		<?php } ?>
	</ul>
</div>