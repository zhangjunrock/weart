<div id="post-<?php the_ID(); ?>" class="post hentry format-quote">
	<div class="entry clearfix">
		<blockquote>
			<div class="bq-title r">
				<p><a class="title" href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf('%s', the_title_attribute('echo=0')); ?>"><?php time_diff( $time_type='post' ); ?></a></p>
				<span class="meta">
					<?php if(function_exists('the_views')) { echo '<em class="views">' . the_views(false) .'</em>'; } ?>
					<?php comments_popup_link('0','1','%', 'replies', '评论关闭' ); ?>
					<script type="text/javascript">document.write('<a href="http://v.t.sina.com.cn/share/share.php?url=' + encodeURIComponent('<?php the_permalink() ?>') + '&appkey=2617885470&title=' + encodeURIComponent('<?php the_title(); ?> ——来自@<?php bloginfo('name'); ?>') + '" title="分享到新浪微博" target="_blank" class="share">分享</a>');</script>
					<?php if(is_single()) { edit_post_link( '编辑', '', '' );} ?>
				</span>
			</div>
			<?php the_content(); ?>
		</blockquote>
	</div>
	<?php if(is_single()){
		the_tags( '<div class="tags">', ', ', '</div>');
		get_template_part( 'files/copyright' );
		get_template_part( 'files/author-bio' );
		get_template_part( 'files/bdshare' );
		get_template_part( 'files/relate' );
	} ?>
</div>