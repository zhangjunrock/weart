<div id="post-<?php the_ID(); ?>" class="post hentry format-gallery">
	<h2 class="title">
		<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf('%s', the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a>
	</h2>
	<?php miui_entry_meta(); ?>
	<div class="entry clearfix">
		<?php if ( is_single() || ! get_post_gallery() ) {
			the_content(); 
			wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); 
			the_tags( '<div class="tags">', ', ', '</div>');
			get_template_part( 'files/copyright' );
			get_template_part( 'files/author-bio' );
			get_template_part( 'files/bdshare' );
			get_template_part( 'files/relate' );
		}else{
			echo get_post_gallery();
		} ?>
	</div>
</div>