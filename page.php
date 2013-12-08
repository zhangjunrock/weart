<?php get_header(); ?>
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
					<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
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