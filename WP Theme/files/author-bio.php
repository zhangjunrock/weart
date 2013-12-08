<div class="author-bio">
	<div class="author-info">
		<div class="author-avatar">
			<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'twentythirteen_author_bio_avatar_size', 76 ) ); ?>
			<b></b>
		</div>
		<div class="author-description">
			<div class="author-social r">
				<?php if ( get_the_author_meta('QQ') ) : ?><a href="http://wpa.qq.com/msgrd?v=3&uin=<?php the_author_meta('QQ'); ?>&site=qq&menu=yes" title="Q我" target="_blank" rel="nofollow">QQ</a><?php endif; ?><?php if ( get_the_author_meta('weibo') ) : ?><a href="<?php the_author_meta('weibo'); ?>" title="新浪微博" target="_blank" rel="nofollow">新浪</a><?php endif; ?><?php if ( get_the_author_meta('qweibo') ) : ?><a href="<?php the_author_meta('qweibo'); ?>" title="腾讯微博" target="_blank" rel="nofollow">腾讯</a><?php endif; ?><?php if ( get_the_author_meta('gplus') ) : ?><a href="<?php the_author_meta('gplus'); ?>" title="googleplus" target="_blank" rel="nofollow">G+</a><?php endif; ?><?php if ( get_the_author_meta('twitter') ) : ?><a href="<?php the_author_meta('twitter'); ?>" title="twitter" target="_blank" rel="nofollow">推特</a><?php endif; ?><?php if ( get_the_author_meta('facebook') ) : ?><a href="<?php the_author_meta('facebook'); ?>" title="facebook" target="_blank" rel="nofollow">脸书</a><?php endif; ?><?php if ( get_the_author_meta('douban') ) : ?><a href="<?php the_author_meta('douban'); ?>" title="豆瓣" target="_blank" rel="nofollow">豆瓣</a><?php endif; ?><?php if ( get_the_author_meta('renren') ) : ?><a href="<?php the_author_meta('renren'); ?>" title="人人" target="_blank" rel="nofollow">人人</a><?php endif; ?><?php if ( get_the_author_meta('user_email') ) : ?><a href="mailto:<?php the_author_meta('user_email'); ?>" title="给我发邮件" target="_blank" rel="nofollow">Email</a><?php endif; ?>
			</div>
			<h3 class="author-title"><a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php the_author(); ?></a></h3>
			<?php if ( get_the_author_meta('donate') ) : ?>
				<a class="r wbtn" href="<?php the_author_meta('donate'); ?>" title="不错，有赏！" target="_blank" rel="nofollow">打赏</a>
			<?php endif; ?>
			<div class="author-desc">
				<?php if(get_the_author_meta( 'description' ) ){ the_author_meta( 'description' ); }else{ echo '这家伙很懒，什么都没有留下！';}; ?>
			</div>
		</div>
	</div>
	<div class="author-bg"></div>
</div>