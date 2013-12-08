</div>
<div class="location box"></div>
<?php 
	if(dopt('blogrolls')){
		if(dopt('blogrolls_home') && dopt('blogrolls_homep')){
			if(is_home() && $paged <= 1) { get_template_part( 'files/blogrolls' ); } 
		}elseif(dopt('blogrolls_home')){		
			if(is_home()){ get_template_part( 'files/blogrolls' ); }
		}else{
			get_template_part( 'files/blogrolls' );
		}
	}
?>
</div>
<div class="footer" id="footer">
	<div class="footerInner"><?php if(dopt('bottom_ad_960')){echo dopt('bottom_ad_960');} ?></div>
	<p><?php echo copyright(); ?> <br /> <?php if(dopt('Statistics_Code')){echo dopt('Statistics_Code');} ?> <br /> <?php if(dopt('blog_ipc')){echo dopt('blog_ipc');} ?></p>
</div>
<div id="scrolltop">
	<span title="回到顶部" id="roll_top"></span>
	<?php if(is_singular() && comments_open()) { ?><span title="查看评论" id="ct"></span><?php } ?>
	<span title="转到底部" id="fall"></span>
</div>
<?php wp_footer(); ?>
<?php if(is_category('images') || is_category('video')) { ?>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/myfocus-2.0.4.min.js"></script>
<?php } ?>
<?php if(dopt('lazyload')) { ?>
	<script type="text/javascript">
		jQuery(document).ready(function($){
			$(".topLine img, .subTopLine img, .entry img, .post-thumb img").not('.pagerolls img').not('.widget_comments_star img.avatar').lazyload({
				placeholder:"<?php echo get_template_directory_uri(); ?>/images/ploading.gif",
				effect:"fadeIn"
			});
		});
	</script>
<?php } ?>
<?php if(dopt('post_bdshare') && dopt('bdshare_uid')) { ?>
	<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=<?php echo dopt('bdshare_uid'); ?>" ></script>
	<script type="text/javascript" id="bdshell_js"></script>
	<script id="bdlike_shell"></script>
	<script>
	var bdShare_config = {
		"type":"small",
		"color":"blue",
		"uid":"<?php echo dopt('bdshare_uid'); ?>",
		"likeText":"赞",
		"likedText":"已赞"
	};
	document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
	document.getElementById("bdlike_shell").src="http://bdimg.share.baidu.com/static/js/like_shell.js?t=" + Math.ceil(new Date()/3600000);
	</script>
<?php } ?>
</body>
</html>