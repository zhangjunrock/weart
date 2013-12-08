<?php get_header(); ?>
<div class="left box">
<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>
		<?php get_template_part( 'content', get_post_format() ); ?>
		<div class="postbottom">
			<div class="navigation">
				<div class="alignleft"><?php previous_post_link('%link','<span>上一篇</span>%title') ?></div>
				<div class="alignright"><?php next_post_link('%link','<span>下一篇</span>%title') ?></div>
			</div>
		</div>
		<?php comments_template(); ?>
	<?php endwhile; else: ?>
		<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>