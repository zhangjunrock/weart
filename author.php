<?php get_header(); ?>
<div class="left box">
	<?php if (have_posts()) : ?>			
		<?php while (have_posts()) : the_post(); ?>
			<?php get_template_part( 'content', get_post_format() ); ?>
		<?php endwhile;?>
		<?php if (function_exists('par_pagenavi')) : ?>
			<div class="pages"><?php par_pagenavi(); ?></div>
		<?php else : ?>
			<div class="navigation">
				<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
				<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
			</div>
		<?php endif; ?>
	<?php else : ?>
		<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
	<?php endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>