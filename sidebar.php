<div class="right sidebar">
	<?php if(dopt('side_ad_300250')){echo '<div class="right-ad">' . dopt('side_ad_300250') . '</div>';} ?>
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
		<div class="widget_hotandnew box">
			<?php
				if (is_singular()) {
					$boxtitle = '最新文章';
				} else {
					$boxtitle = '热评文章';
				}
			?>
			<h4><strong><?php echo $boxtitle; ?></strong></h4>
			<ul>
				<?php
					if (is_singular()) {
						$myposts = get_posts('numberposts=10&orderby=post_date');
					} else {
						$myposts = get_posts('numberposts=10&orderby=comment_count');
					}
					foreach($myposts as $post) {
						setup_postdata($post);
						$i==1;$i++;
						$title = get_the_title();
						if (strlen($title) == 0) { $title = get_the_time('Y年m月d日') . '无标题文章'; }
						if($i < 4){ $class = '<li class="topRank">';}else{ $class="<li>"; }
						echo $class . '<em>' . $i . '</em><a href="' . get_permalink() . '">' . $title . '</a></li>';
					}
					$post = $myposts[0];
					wp_reset_postdata();
				?>
			</ul>
		</div>
		<div class="widget_comments_star box">
			<h4><strong class="tab SwapTab"><span class="fb">最新评论</span><span>灌水明星</span></strong></h4>
			<div class="tab-content">
				<ul style="display:block"><?php Happyet_news_comments(); ?></ul>
				<ul style="display:none" class="star"><?php comments_star(); ?></ul>
			</div>
		</div>
		<div class="widget_picshow box">
			<h4><strong>我的相册 <a class="r" href="<?php echo esc_url( get_category_link( 1000 )); ?>" target="_blank">更多 &gt;</a></strong></h4>
			<ul>
				<?php $showposts = get_posts('cat=1000&numberposts=4&orderby=DESC'); 
					foreach($showposts as $post) {
						setup_postdata($post);
						$title = get_the_title();
						if (strlen($title) == 0) { $title = get_the_time('Y年m月d日') . '无标题文章'; }
						$i==1;$i++;
						if($i==1){$class='<li class="current">';}else{$class='<li>';}
						echo $class . '<a href="' . get_permalink() . '" target="_blank">';
						post_thumbnail(61, 47);
						echo '</a><span><a href="' . get_permalink() . '" target="_blank">';
						post_thumbnail(260, 185);
						echo '<strong>' . $title . '</strong></a></span></li>';	
					}
					$post = $showposts[0];
					wp_reset_postdata();
				?>
			</ul>
		</div>
		<div class="widget_activities box">
			<h4><strong>小品阅读 <a class="r" href="<?php echo esc_url( get_category_link( 842 )); ?>" target="_blank">更多 &gt;</a></strong></h4>
			<?php $readposts = get_posts('cat=842&numberposts=4&orderby=DESC'); 
				foreach($readposts as $post) {
					setup_postdata($post);
					$title = get_the_title();
					if (strlen($title) == 0) { $title = get_the_time('Y年m月d日') . '无标题文章'; }
					echo '<dl><dt><a href="' . get_permalink() . '" target="_blank" title="' . mb_substr(strip_tags($post->post_excerpt),0,66) . '...">';
					post_thumbnail(125, 80);
					echo get_the_title() . '</a></dt><dd><a href="' . get_permalink() . '" target="_blank">阅读全文</a></dd></dl>';
				}
				$post = $readposts[0];
				wp_reset_postdata();
			?>
		</div>
		<div class="widget_recentviews box">
			<h4><strong class="tab SwapTab"><span class="fb">近期批阅</span><span>最近更新</span></strong></h4>
			<div class="tab-content">
				<?php zg_recently_viewed(); ?>
				<ul style="display:none">
					<?php $args = array(
						'orderby' => 'modified',
						'showposts' => 7,
						'ignore_sticky_posts' => 1
						);
						$posts = query_posts($args);
						while(have_posts()) : the_post(); ?>
							<li><span class="r"><?php the_modified_date('m-j'); ?></span><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>
						<?php endwhile;wp_reset_query();
					?>
				</ul>
			</div>
		</div>
		<div class="widget_tagclouds box">
			<h4><strong>标签凌乱</strong></h4>
			<div>
			<?php $tags_list = get_tags('orderby=count&number=30&order=DESC');
			if ($tags_list) { 
				foreach($tags_list as $tag) {
					echo '<a class="wbtn" href="' . get_tag_link($tag) . '" title="' . $tag->name . '(' . $tag->count . ')">' . $tag->name . '<strong>' . $tag->count . '</strong></a>';
				}
			} ?>
			</div>
		</div>
	<?php endif; ?>
	<?php if(dopt('side_ad_260185')){echo '<div class="recommend box"><h4><strong>精品推荐</strong></h4><div>' . dopt('side_ad_260185') . '</div></div>';} ?>
	<?php
		if(is_home()) {dynamic_sidebar('sidebar-home');}
		elseif(is_category()) {dynamic_sidebar('sidebar-category');} 
		elseif(is_single()) {dynamic_sidebar('sidebar-single');}
		elseif(is_page()) {dynamic_sidebar('sidebar-page');}
		else {dynamic_sidebar('sidebar-archive');}
	?>
	<?php if(is_active_sidebar('slidebox')) : ?>
		<div id="slidebox"><?php dynamic_sidebar( 'slidebox' ); ?></div>
	<?php else: ?>
		<div id="slidebox">
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
		</div>
	<?php endif; ?>
</div>