<?php
/*
Template Name: 标签页面模板
*/

get_header(); ?>
<div class="left box">
	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
			<div id="post-<?php the_ID(); ?>" class="post hentry">
				<h2 class="title">
					<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf('Permanent Link to %s', the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a>
				</h2>
				<?php miui_entry_meta(); ?>
				
				<div class="entry clearfix">
					<?php
						the_content();
						wp_link_pages( array( 'before' => '<div class="page-links">', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
						$tags_list = get_tags('orderby=count&order=DESC');
						echo '<p>标签总数：' . wp_count_terms('post_tag') . ' 枚</p>';
						echo '<ul class="alltags">';
						if ($tags_list) { 
							foreach($tags_list as $tag) {
								echo '<li><a class="wbtn" href="'.get_tag_link($tag).'" title="标签：'. $tag->name .'">'. $tag->name .'</a><em><i>×</i>'. $tag->count .'</em></li>'; 

							} 
						}
						echo '</ul>';
					?>
				</div>
			</div>
		<?php endwhile; ?>
		<?php if (function_exists('par_pagenavi')) : ?>
			<div class="pages"><?php par_pagenavi(); ?></div>
		<?php else : ?>
			<div class="navigation">
				<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
				<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
			</div>
		<?php endif; ?>
	<?php else : ?>
		<h2 class="center"><?php _e('Not Found'); ?></h2>
		<p class="center"><?php _e('Sorry, but you are looking for something that isn&#8217;t here.'); ?></p>
		<?php get_search_form(); ?>
	<?php endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
