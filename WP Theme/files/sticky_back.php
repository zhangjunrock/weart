<?php
$sticky = get_option( 'sticky_posts' );
$args = array(
	'posts_per_page' => 1,
	'post__in'  => $sticky,
	'ignore_sticky_posts' => 1,
);
query_posts( $args );
while( have_posts() ) { 
	the_post();
	if($sticky[0]) { ?>
		<dl class="topLine">
			<dt>
				<h2><a href="<?php the_permalink(); ?>"><?php the_title_attribute(); ?></a></h2>
				<a href="<?php the_permalink(); ?>"><img src="<?php bloginfo('template_url') ?>/timthumb.php?src=<?php echo post_thumbnail_src(); ?>&h=175&w=300&zc=1" alt="<?php the_title(); ?>" class="thumbnail"/></a>
			</dt>
			<dd>
				<span>
					<?php if(function_exists('the_views')) { echo '<em class="views">' . the_views(false) .'</em>'; } ?>
					<?php //comments_popup_link('0','1','%', 'replies', '评论关闭' ); ?>
					<script type="text/javascript">document.write('<a href="http://v.t.sina.com.cn/share/share.php?url=' + encodeURIComponent('<?php the_permalink() ?>') + '&appkey=1874498659&title=' + encodeURIComponent('<?php the_title(); ?> ——来自@<?php bloginfo('name'); ?>') + '" title="分享到新浪微博" target="_blank" class="share">分享</a>');</script>
				</span>
				<?php the_category(', '); ?> | <?php the_time('Y年m月d日'); ?>
				<?php 
					$permalink=get_permalink($ID);
					if (!(strtoupper(get_locale()) == 'ZH_CN')){
						echo '<p>';
						the_content_rss('', true, '', 55);
					}else{
						$exp=mb_substr(strip_tags($post->post_content),0,116);
						echo '<p>'.$exp.' ...  ';
					}
					_e("<a href=\"$permalink\" class=\"more\">全文》</a></p>");
				?>
			</dd>
		</dl>
	<?php }
	}
wp_reset_query();
$args = array(
	'posts_per_page' => 5,
	'post__in'  => $sticky,
	'ignore_sticky_posts' => 0,
);
$stickyPosts = get_posts($args);
if($sticky){
	echo '<ul class="subTopLine">';
	foreach( $stickyPosts as $post ) {
		setup_postdata($post);
		$i==1;
		$i++;
		if ($i<>1) { ?>
			<li>
				<a href="<?php the_permalink(); ?>">
					<img src="<?php bloginfo('template_url') ?>/timthumb.php?src=<?php echo post_thumbnail_src(); ?>&h=85&w=145&zc=1" alt="<?php the_title(); ?>" class="thumbnail"/>
				</a>
				<h3><a href="<?php the_permalink(); ?>"><?php the_title_attribute(); ?></a></h3>
				<span>
					<?php if(function_exists('the_views')) { echo '<em class="views">' . the_views(false) .'</em>'; } ?>
					<script type="text/javascript">document.write('<a href="http://v.t.sina.com.cn/share/share.php?url=' + encodeURIComponent('<?php the_permalink() ?>') + '&appkey=1874498659&title=' + encodeURIComponent('<?php the_title(); ?> ——来自@<?php bloginfo('name'); ?>') + '" title="分享到新浪微博" target="_blank" class="share">分享</a>');</script>
				</span>
			</li>
		<?php }
		wp_reset_postdata();
	}
	echo '</ul>';
}
?>