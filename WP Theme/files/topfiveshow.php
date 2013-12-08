<dl class="topLine">
<?php
	if(dopt('top_no1_mode')=='指定分类'){
		$categoryID = dopt('top_no1_category');
		$args = array(
			'posts_per_page' => 1,
			'cat'  => $categoryID,
			'ignore_sticky_posts' => 1,
		);
	}elseif(dopt('top_no1_mode')=='置顶文章'){
		$sticky = get_option( 'sticky_posts' );
		$args = array(
			'posts_per_page' => 1,
			'post__in'  => $sticky,
			'ignore_sticky_posts' => 1,
		);
	}elseif(dopt('top_no1_mode')=='指定文章'){
		$postID = dopt('top_no1_post');
		$args = array(
			'posts_per_page' => 1,
			'p'  => $postID,
			'ignore_sticky_posts' => 1,
		);
	}
	query_posts( $args );
	while( have_posts() ) { the_post(); ?>
		<dt>
			<h2><a href="<?php the_permalink(); ?>" target="_blank"><?php the_title(); ?></a></h2>
			<a href="<?php the_permalink(); ?>" target="_blank"><?php post_thumbnail(300, 175);?></a>
		</dt>
		<dd>
			<span>
				<?php if(function_exists('the_views')) { echo '<em class="views">' . the_views(false) .'</em>'; }else{echo '<em class="views">';post_views();echo '</em>';} ?>
				<?php //comments_popup_link('0','1','%', 'replies', '评论关闭' ); ?>
				<script type="text/javascript">document.write('<a href="http://v.t.sina.com.cn/share/share.php?url=' + encodeURIComponent('<?php the_permalink() ?>') + '&appkey=1874498659&title=' + encodeURIComponent('<?php the_title(); ?> ——来自@<?php bloginfo('name'); ?>') + '" title="分享到新浪微博" target="_blank" class="share">分享</a>');</script>
			</span>
			<?php the_category(', '); ?> | <?php time_diff( $time_type='post' ); ?>
			<?php 
				$permalink=get_permalink($ID);
				if (!(strtoupper(get_locale()) == 'ZH_CN')){
					echo '<p>';
					the_content_rss('', true, '', 55);
				}else{
					$content = strip_tags($post->post_content);
					$content = strip_shortcodes($content);
					$content = trim($content);
					$content = preg_replace('/\s\s+/', " ", $content);
					$content = trim(mb_substr ($content,0,110, 'utf-8')); 
					$content = str_replace(array('"','\'','<','>'), "", $content);
					echo '<p>'.$content.' ...  ';
				}
				_e("<a href=\"$permalink\" class=\"more\"  target=\"_blank\">全文》</a></p>");
			?>
		</dd>
	<?php }
	wp_reset_query();
?>
</dl>
<ul class="subTopLine">
<?php 
	if(dopt('top_no4_mode')=='指定分类'){
		$categoryID = dopt('top_no4_category');
		$args = array(
			'posts_per_page' => 4,
			'cat'  => $categoryID,
			'ignore_sticky_posts' => 1,
		);
	}elseif(dopt('top_no4_mode')=='置顶文章'){
		$sticky = get_option( 'sticky_posts' );
		$args = array(
			'posts_per_page' => 4,
			'post__in'  => $sticky,
			'ignore_sticky_posts' => 1,
		);
	}elseif(dopt('top_no4_mode')=='指定文章'){
		$postID = explode(",", dopt('top_no4_post'));
		$args = array(
			'posts_per_page' => 4,
			'post__in'  => $postID,
			'ignore_sticky_posts' => 1,
		);
	}
	$readposts = get_posts($args); 
	foreach($readposts as $post) {
		setup_postdata($post); ?>
		<li>
			<a href="<?php the_permalink(); ?>" target="_blank" title="<?php echo mb_substr(strip_tags($post->post_content),0,66); ?>...">
			<?php post_thumbnail(145, 85);?></a>
			<h3><a href="<?php the_permalink(); ?>" target="_blank"><?php the_title(); ?></a></h3>
			<span>
				<?php if(function_exists('the_views')) { echo '<em class="views">' . the_views(false) .'</em>'; }else{echo '<em class="views">';post_views();echo '</em>';} ?>
				<script type="text/javascript">document.write('<a href="http://v.t.sina.com.cn/share/share.php?url=' + encodeURIComponent('<?php the_permalink() ?>') + '&appkey=1874498659&title=' + encodeURIComponent('<?php the_title(); ?> ——来自@<?php bloginfo('name'); ?>') + '" title="分享到新浪微博" target="_blank" class="share">分享</a>');</script>
			</span>
		</li>
	<?php }
	$post = $readposts[0];
	wp_reset_postdata();
?>
</ul>