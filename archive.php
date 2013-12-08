<?php get_header(); ?>
<div class="left box">
	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
			<?php get_template_part( 'content', get_post_format() ); ?>
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
