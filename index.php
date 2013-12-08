<?php get_header(); ?>
<div class="left box">
	<?php if(dopt('home_top5_show')) {get_template_part( 'files/topfiveshow' );} ?>
	<a name="news"></a> 
	<?php if (have_posts()) : ?>
		<?php 
		if(dopt('exclude_category') && dopt('exclude_sticky')){
			$categoryId = dopt('exclude_category');
			$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1; 
			$sticky = get_option( 'sticky_posts' );
			$args = array(
				'ignore_sticky_posts' => 1,
				'post__not_in' => $sticky,
				'paged' => $paged,
				'cat' => $categoryId
			);
			query_posts( $args );
		}elseif(dopt('exclude_sticky')){
			$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1; 
			$sticky = get_option( 'sticky_posts' );
			$args = array(
				'ignore_sticky_posts' => 1,
				'post__not_in' => $sticky,
				'paged' => $paged,
			);
			query_posts( $args );
		}elseif(dopt('exclude_category')){
			$categoryId = dopt('exclude_category');
			$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1; 
			$args = array(
				'cat' => $categoryId,
				'paged' => $paged,
			);
			query_posts( $args );
		}
		while (have_posts()) : the_post();
			get_template_part( 'content', get_post_format() );
		endwhile;
		if (function_exists('par_pagenavi')) : ?>
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