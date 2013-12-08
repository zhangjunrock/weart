<?php get_header(); ?>
<div id="photoFocus" class="photoFocus" style="visibility:hidden">
	<div class="loading"><span>请稍候...</span></div>
	<ul class="pic">
	<?php 
		$photoposts = array(
			'posts_per_page' => '5',
			'cat' => $cat,
			'orderby' => 'date',
			'order' => 'DESC',
			'ignore_sticky_posts' => 1
		);
		query_posts( $photoposts );
		while ( have_posts() ) : the_post();
			$title = get_the_title();
			if (strlen($title) == 0) { $title = get_the_time('Y年m月d日') . '无标题文章'; }
			echo '<li><a href="' . get_permalink() . '" target="_blank">';
			post_thumbnail(960, 350);
			echo '</a></li>';
		endwhile;
		wp_reset_query();
	?>
	</ul>
</div>
<?php if(category_description($cat)) { ?>
	<div class="category-desc clearfix">
		<img src="<?php echo get_template_directory_uri(); ?>/images/cat-images.png" class="cat-logo l">
		<h2><?php single_cat_title(); ?></h2>
		<?php echo category_description($cat); ?>
	</div>
<?php } ?>
<div class="imagesholder clearfix">
	<?php $posts = query_posts($query_string . '&orderby=date&showposts=30'); ?>
	<?php if (have_posts()) : ?>
		<div class="imagesboard clearfix">
		<?php while (have_posts()) : the_post(); ?>
			<div id="post-<?php the_ID(); ?>" class="imagesbox">	
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
					<?php post_thumbnail(185, 185); ?>
					<p><strong><?php the_title(); ?></strong></p>
					<cite></cite>
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