<?php get_header(); ?>

<?php if(category_description($cat)) { ?>
	<div class="category-desc clearfix">
		<img src="<?php echo get_template_directory_uri(); ?>/images/cat-video.png" class="cat-logo l">
		<h2><?php single_cat_title(); ?></h2>
		<?php echo category_description($cat); ?>
	</div>
<?php } ?>
<div class="imagesholder clearfix">
	<?php $posts = query_posts($query_string . '&orderby=date&showposts=20'); ?>
	<?php if (have_posts()) : ?>
		<div class="imagesboard clearfix">
		<?php while (have_posts()) : the_post(); ?>
			<div id="post-<?php the_ID(); ?>" class="videobox">	
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
					<?php post_thumbnail(224, 168); ?>
					<p><strong><?php the_title(); ?></strong></p>
					<cite></cite>
					<i></i>
				</a>
			</div>
		<?php endwhile; ?>
		</div>
		<?php if (function_exists('par_pagenavi')) : ?>
			<div class="pages"><?php par_pagenavi(); ?></div>
		<?php else : ?>
			<div class="navigation pages"">
				<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
				<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
			</div>
		<?php endif; ?>
	<?php else : ?>
		<?php get_template_part( 'content-none', get_post_format() ); ?>
	<?php endif; ?>
</div>
<?php get_footer(); ?>