<div id="post-<?php the_ID(); ?>" class="post hentry format-status">
	<?php if(is_single()) { ?>
		<h2 class="title">
			<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf('%s', the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a>
		</h2>
		<?php miui_entry_meta(); ?>
	<?php } ?>
	<div class="statusHolder">
		<div class="entry clearfix">
			<?php the_content(); wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );?>
		</div>
		<div class="statusDate">
			<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf('%s', the_title_attribute('echo=0')); ?>">
				<span class="month"><?php the_time('M月'); ?></span>
				<span class="day"><?php the_time('d'); ?></span>
			</a>
		</div>
		<?php if(!is_single()) { ?>
			<span class="meta">
			<?php if(function_exists('the_views')) { echo '<em class="views">' . the_views(false) .'</em>'; } ?>
			<?php comments_popup_link('0','1','%', 'replies', '评论关闭' ); ?>
			<script type="text/javascript">document.write('<a href="http://v.t.sina.com.cn/share/share.php?url=' + encodeURIComponent('<?php the_permalink() ?>') + '&appkey=2617885470&title=' + encodeURIComponent('<?php the_title(); ?> ——来自@<?php bloginfo('name'); ?>') + '" title="分享到新浪微博" target="_blank" class="share">分享</a>');</script>
			</span>
			<?php the_category(', '); ?> | <?php time_diff( $time_type='post' ); ?> <?php if(is_single()) { edit_post_link( '编辑', '', '' );} ?>
		<?php } ?>
	</div>
	<?php if ( is_single() ) {
		the_tags( '<div class="tags">', ', ', '</div>');
		get_template_part( 'files/copyright' );
		get_template_part( 'files/author-bio' );
		get_template_part( 'files/bdshare' );
		get_template_part( 'files/relate' );
	} ?>
</div>