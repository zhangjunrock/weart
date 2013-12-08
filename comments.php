<?php if(dopt('commenttopad')){echo '<div class="comenttopad">' . dopt('commenttopad') . '</div>';} ?>
<?php
	if (isset($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');
	if ( post_password_required() ) { ?>
		<div class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.'); ?></div> 
	<?php
		return;
	}
?>
<div id="comments">

	<?php if ( have_comments() ) : ?>
		<?php
			$numPingBacks = 0;
			$numComments  = 0;
			foreach ($comments as $comment)
				if (get_comment_type() != "comment") $numPingBacks++; else $numComments++;
		?>
		<h2 id="comments-title">《<?php the_title(); ?>》有评论： <?php echo $numComments; ?> <?php if($numPingBacks <> 0) { ?>，<a href="#trackback" rel="nofollow">Trackback： <?php echo $numPingBacks; ?></a><?php } ?></h2>

		<div class="comments-container">
		<ol class="commentlist">
			<?php wp_list_comments('type=comment&callback=mytheme_comment&end-callback=mytheme_end_comment'); ?>
		</ol>
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<div class="pages comment_page_navi ccp">
				<?php paginate_comments_links(array('prev_text' => '&laquo;', 'next_text' => '&raquo;')); ?>
			</div>
		<?php endif; ?>
		</div>
		
		<?php if($numPingBacks <> 0) { ?>
			<h2 id="trackback">Trackbacks: <?php echo $numPingBacks; ?> </h2>
			<ol class="tb-commentlist">
				<?php foreach ($comments as $comment) : ?>
				<?php $comment_type = get_comment_type(); ?>
				<?php if($comment_type != 'comment') { ?>
					<li>• <?php comment_author_link() ?></li>
				<?php } ?>
				<?php endforeach; ?>
 			</ol>
		<?php } ?>
		

	<?php else : // 如果没有评论 ?>

		<?php if ( comments_open() ) : //允许评论但还没有评论 ?>
			<p class="nocomments">暂无评论！</p>
		<?php else : // 评论关闭 ?>
			<p class="nocomments">评论已关闭！</p>
		<?php endif; ?>

	<?php endif; ?>
</div>
	<?php if ( comments_open() ) : ?>

		<div id="respond">

			<h3 class="respond-title"><?php comment_form_title( __('Leave a Reply'), __('Leave a Reply for %s' ) ); ?></h3>
			
			<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
				<p>你必须<?php wp_loginout(); ?>才能发表评论。</p>
			<?php else : ?>
				<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
					<?php if ( is_user_logged_in() ) : ?>
						<p><?php printf(__('Logged in as <a href="%1$s">%2$s</a>.'), get_option('siteurl') . '/wp-admin/profile.php', $user_identity); ?> <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e('Log out of this account'); ?>"><?php _e('Log out &raquo;'); ?></a></p>
					<?php else : ?>
						<!-- 有资料的访客 -->
						<?php if ( $comment_author != "" ) : ?>
							<script type="text/javascript">function setStyleDisplay(id, status){document.getElementById(id).style.display = status;}</script>
							<div class="welcomeback">
								<?php printf('欢迎回来 <strong>%s</strong>', $comment_author) ?>
								<span id="show_author_info"><a href="javascript:setStyleDisplay('author_info','');setStyleDisplay('show_author_info','none');setStyleDisplay('hide_author_info','');">[ 换个身份 <i class="icon-collapse"></i> ]</a></span>
								<span id="hide_author_info"><a href="javascript:setStyleDisplay('author_info','none');setStyleDisplay('show_author_info','');setStyleDisplay('hide_author_info','none');">[ 收起 <i class="icon-collapse-top"></i> ]</a></span>
							</div>
						<?php endif; ?>
						<div id="author_info" class="clearfix">
							<p><input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" tabindex="3" <?php if ($req) echo "aria-required='true'"; ?> placeholder="昵称 <?php if ($req) _e("(required)"); ?>" /></p>
							<p><input type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" tabindex="4" <?php if ($req) echo "aria-required='true'"; ?> placeholder="邮箱 <?php if ($req) _e("(required)"); ?>" /></p>
							<p><input type="text" name="url" id="url" value="<?php echo  esc_attr($comment_author_url); ?>" tabindex="5" placeholder="你的博客" /></p>
						</div>
						<!-- 有资料的访客 -->
						<?php if ( $comment_author != "" ) : ?>
							<script type="text/javascript">setStyleDisplay('hide_author_info','none');setStyleDisplay('author_info','none');</script>
						<?php endif; ?>
					<?php endif; ?>
					<?php if(dopt('insert_image')){ ?><span class="r"><a title="插入图片" href="javascript:embedImage();">插入图片</a></span><?php } ?>
					<?php if(dopt('comment_smily')){get_template_part( 'files/smiley' );} ?>
					<p><textarea name="comment" id="comment" cols="60" tabindex="4"></textarea></p>
					<p><input name="submit" type="submit" id="submit" tabindex="5" value="提交评论/Ctrl+Enter" /></p>
					<div id="cancel-comment-reply" class="wbtn r"><?php cancel_comment_reply_link('取消回复') ?></div> 
					<!--<p><small><?php printf(__('<strong>XHTML:</strong> You can use these tags: <code>%s</code>'), allowed_tags()); ?></small></p>-->
					<?php comment_id_fields(); ?> 
					<?php do_action('comment_form', $post->ID); ?>
				</form>
	<script type="text/javascript">
		document.getElementById("comment").onkeydown = function (moz_ev)
			{
			var ev = null;
			if (window.event){
				ev = window.event;
					}else{
					ev = moz_ev;
				}
				if (ev != null && ev.ctrlKey && ev.keyCode == 13)
				{
				document.getElementById("submit").click();
				}
			}
	</script>
			<?php endif; ?>
		</div>
	<?php endif; ?>
