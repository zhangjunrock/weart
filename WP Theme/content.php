<div id="post-<?php the_ID(); ?>" class="post hentry">
	<h2 class="title">
		<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf('%s', the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a>
	</h2>
	<?php miui_entry_meta(); ?>
	
	<div class="entry clearfix">
		<?php
			if ( is_single() ) {

				if(dopt('show_tucao') && dopt('tucao_page_id')){ get_template_part( 'files/tucao' ); }
				if(has_post_thumbnail()){ echo '<div class="post-thumb">'; the_post_thumbnail(); echo '</div>'; }

				the_content();

				wp_link_pages( array( 'before' => '<div class="page-links">', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );

			}else{
				if(dopt('auto_thumbpic')){
					echo '<a href="' . get_permalink() . '" title="' . get_the_title() . '" class="thumbpic">';
					post_thumbnail(605, 220);
					echo '</a>';
				}
				if(dopt('auto_excerpt')){ the_excerpt(); }else{ the_content(); }

			}
		?>
	</div>
	<?php if(is_single()){
		the_tags( '<div class="tags">', ', ', '</div>');
		if(dopt('post_copyright')) get_template_part( 'files/copyright' );
		if(dopt('post_author')) get_template_part( 'files/author-bio' );
		if(dopt('post_bdshare') && dopt('bdshare_uid')) get_template_part( 'files/bdshare' );
		if(dopt('relate_posts')) get_template_part( 'files/relate' );
	} ?>
</div>