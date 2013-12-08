<div id="post-<?php the_ID(); ?>" class="post hentry">
	<h2 class="title">
		<?php _e( 'Nothing Found', 'twentythirteen' ); ?>
	</h2>


	<div class="entry clearfix">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'twentythirteen' ), admin_url( 'post-new.php' ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'twentythirteen' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'twentythirteen' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>
	</div>
</div>