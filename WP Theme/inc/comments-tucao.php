<?php
	if (isset($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');
	if ( post_password_required() ) { 
		echo '<p class="nocomments">这是一篇受密码保护的博文，请输入密码查看评论！</p>'; 
		return;
	}
?>
<div id="comments">
	<?php if ( comments_open() ) : ?>
		<div id="respond" <?php if(! current_user_can('level_10')) : ?>style="display:none;"<?php endif; ?>>
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
					<span class="r"><a title="插入图片" href="javascript:embedImage();">插入图片</a></span>
					<?php include(TEMPLATEPATH . '/files/smiley.php'); ?>
					<p><textarea name="comment" id="comment" cols="60" tabindex="4"></textarea></p>
					<p><input name="submit" type="submit" id="submit" tabindex="5" value="提交评论/Ctrl+Enter" /></p>
					<div id="cancel-comment-reply" class="wbtn r"><?php cancel_comment_reply_link('取消回复') ?></div> 
					<?php comment_id_fields(); ?> 
					<?php do_action('comment_form', $post->ID); ?>
				</form>
				<script type="text/javascript">        
					document.getElementById("comment").onkeydown = function (moz_ev){
						var ev = null;
						if (window.event){
						   ev = window.event;
						}else{
							ev = moz_ev;
						}
						if (ev != null && ev.ctrlKey && ev.keyCode == 13){
							document.getElementById("submit").click();
						}
					}
				</script>
			<?php endif; ?>
		</div>
<?php endif; // if you delete this the sky will fall on your head ?>

<?php if ( have_comments() ) : ?>
	<h2 id="comments-title">
		<?php
		$my_email = get_bloginfo ( 'admin_email' );
		$str = "SELECT COUNT(*) FROM $wpdb->comments WHERE comment_post_ID = $post->ID AND comment_approved = '1' AND comment_type = '' AND comment_author_email";
		$count_v = $wpdb->get_var("$str != '$my_email'");
		$count_h = $wpdb->get_var("$str = '$my_email' AND comment_parent = '0'");
		echo '已有 ' . $count_h . ' 条吐槽，' . $count_v . ' 次声援';
	?>
	</h2>
	<div class="comments-container">
	<ol class="commentlist tc-commentlist">
		<?php wp_list_comments('type=comment&callback=tucao_comment&reverse_top_level=false&end-callback=mytheme_end_comment'); ?>
	</ol>
	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<div class="pages comment_page_navi tc-cp">
			<?php paginate_comments_links(array('prev_text' => '&laquo;', 'next_text' => '&raquo;')); ?>
		</div>
	<?php endif; ?>
	</div>
 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments"><?php _e('Comments are closed.'); ?></p>

	<?php endif; ?>
<?php endif; ?>
</div>