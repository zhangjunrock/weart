<?php
/*
Template Name: 留言页面模板
*/

get_header(); ?>
<div class="left box">
	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<h2 class="title">
					<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf('Permanent Link to %s', the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a>
				</h2>
				<?php miui_entry_meta(); ?>
				<?php if ( has_post_thumbnail() ) {  the_post_thumbnail();  } ?>
				<div class="entry clearfix">
					<?php the_content(); ?>
<ul class="guestbookelist clearfix">
<?php
	global $wpdb;
	$my_email = get_bloginfo('admin_email');
	$sql = "SELECT COUNT(comment_author) AS cnt, comment_author, comment_author_url,comment_author_email,comment_type 
	FROM (SELECT * FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts 
	ON ($wpdb->posts.ID=$wpdb->comments.comment_post_ID) 
	WHERE YEAR(comment_date)=YEAR(now()) AND comment_author_email != '$my_email' AND comment_type = '' AND post_password='' AND comment_approved='1') AS tempcmt
	GROUP BY comment_author ORDER BY cnt DESC LIMIT 30"; 
	$counts = $wpdb->get_results($sql);
	foreach ($counts as $count) {
		if($count->comment_author_url == ''){
			$output .= '<li class="uface">' . get_avatar($count->comment_author_email,72) . '<div class="author_detail"><strong>' . $count->comment_author . '</strong>';
		}else{
			$output .='<li class="uface">' . '<a href="'. $count->comment_author_url . '" target="_blank">' . get_avatar($count->comment_author_email,72) . '<div class="author_detail"><strong>' . $count->comment_author . '</strong>';
		}
		$output .= $count->cnt . ' 条评论';
		$output .= '</div></a></li>';
	}
	echo $output;
?>
</ul>

					<?php wp_link_pages(array('before' => '<p class="page_navi"><strong>' . __('日志分页:') . '</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				</div>
				<?php get_template_part( 'author-bio' ); ?>
			</div>
			<?php comments_template(); ?>
		<?php endwhile; else: ?>
			<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
	<?php endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>