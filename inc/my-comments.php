<?php
function AjaxCommentsPage(){
	header('Content-Type: text/html;charset=UTF-8');
	if( isset($_GET['action'])&& $_GET['action'] == 'AjaxCommentsPage'  ){
		global $post,$wp_query, $wp_rewrite;
		$postid = isset($_GET['post']) ? $_GET['post'] : null;
		$pageid = isset($_GET['page']) ? $_GET['page'] : null;
		if(!$postid || !$pageid){
			fail(__('Error post id or comment page id.'));
		}
		// get comments
		$comments = get_comments('post_id='.$postid);
		$post = get_post($postid);
		if(!$comments){
			fail(__('Error! can\'t find the comments'));
		}
		if( 'desc' != get_option('comment_order') ){
			$comments = array_reverse($comments);
		}
		// set as singular (is_single || is_page || is_attachment)
		$wp_query->is_singular = true;
		// base url of page links
		$baseLink = '';
		if ($wp_rewrite->using_permalinks()) {
			$baseLink = '&base=' . user_trailingslashit(get_permalink($postid) . 'comment-page-%#%', 'commentpaged');
		}
		// response 注意修改callback为你自己的，没有就去掉callback
		echo '<ol class="commentlist">';
		wp_list_comments('callback=mytheme_comment&end-callback=mytheme_end_comment&type=comment&page=' . $pageid . '&per_page=' . get_option('comments_per_page'), $comments);
		echo '</ol>';
		echo '<div class="pages comment_page_navi ccp">';
		paginate_comments_links(array('current' => $pageid . $baseLink, 'prev_text' => '&laquo;', 'next_text' => '&raquo;'));
		echo '</div>';
		die;
	}else{return;}
}
add_action('init', 'AjaxCommentsPage');

function AjaxTcCommentsPage(){
	header('Content-Type: text/html;charset=UTF-8');
	if( isset($_GET['action'])&& $_GET['action'] == 'AjaxTcCommentsPage'  ){
		global $post,$wp_query, $wp_rewrite;
		$postid = isset($_GET['post']) ? $_GET['post'] : null;
		$pageid = isset($_GET['page']) ? $_GET['page'] : null;
		if(!$postid || !$pageid){
			fail(__('Error post id or comment page id.'));
		}
		// get comments
		$comments = get_comments('post_id='.$postid);
		$post = get_post($postid);
		if(!$comments){
			fail(__('Error! can\'t find the comments'));
		}
		if( 'desc' != get_option('comment_order') ){
			$comments = array_reverse($comments);
		}
		// set as singular (is_single || is_page || is_attachment)
		$wp_query->is_singular = true;
		// base url of page links
		$baseLink = '';
		if ($wp_rewrite->using_permalinks()) {
			$baseLink = '&base=' . user_trailingslashit(get_permalink($postid) . 'comment-page-%#%', 'commentpaged');
		}
		// response 注意修改callback为你自己的，没有就去掉callback
		echo '<ol class="commentlist tc-commentlist">';
		wp_list_comments('callback=tucao_comment&reverse_top_level=false&end-callback=mytheme_end_comment&type=comment&page=' . $pageid . '&per_page=' . get_option('comments_per_page'), $comments);
		echo '</ol>';
		echo '<div class="pages comment_page_navi tc-cp">';
		paginate_comments_links(array('current' => $pageid . $baseLink, 'prev_text' => '&laquo;', 'next_text' => '&raquo;'));
		echo '</div>';
		die;
	}else{return;}
}
add_action('init', 'AjaxTcCommentsPage');

function mytheme_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	global $commentcount, $comment_depth, $page, $wpdb;
	$lms_depth = $comment_depth-1;
	if ( (int) get_option('page_comments') === 1 && (int) get_option('thread_comments') === 1 ) { //开启嵌套评论和分页才启用
   		if(!$commentcount) {
			$page = ( !empty($in_comment_loop) ) ? get_query_var('cpage') : get_page_of_comment( $comment->comment_ID, $args );
			$cpp=get_option('comments_per_page');
			if ( get_option('comment_order') === 'desc' ) { //倒序
				$comments = get_comments(array('post_id' => $post->ID, 'status' => 'approve', 'comment_parent' => '0' ));
				$cnt = count($comments);
				if (ceil($cnt / $cpp) == 1 || ($page > 1 && $page  == ceil($cnt / $cpp))) {
					$commentcount = $cnt + 1;
				} else {
					$commentcount = $cpp * $page + 1;
				}
			} else {
				$commentcount = $cpp * ($page - 1);
			}
		}
		if ( !$parent_id = $comment->comment_parent ) {
			$commentcountText = '';
			if ( get_option('comment_order') === 'desc' ) { //倒序
				$commentcountText .= '<span class="r">' . --$commentcount . '#</span>';
			} else {
				switch ($commentcount) {
					case 0:
						if(dopt('shafa_floor')){$shafa = dopt('shafa_floor');}else{$shafa = '沙发';}
						$commentcountText .= '<span class="r" style="background: #ee5567">' . $shafa . '</span>'; ++$commentcount;
						break;
					case 1:
						if(dopt('bandeng_floor')){$bandeng = dopt('bandeng_floor');}else{$bandeng = '板凳';}
						$commentcountText .= '<span class="r" style="background: #ff6f3d">' . $bandeng . '</span>'; ++$commentcount;
						break;
					case 2:
						if(dopt('diban_floor')){$diban = dopt('diban_floor');}else{$diban = '地板';}
						$commentcountText .= '<span class="r" style="background: #ffce55">' . $diban . '</span>'; ++$commentcount;
						break;
					default:
						$commentcountText .= '<span class="r">' . ++$commentcount . '#</span>';
						break;
				}
			}
		}else{
			$commentcountText = '<span class="r">' . $commentcount.'-'.$lms_depth . '</span>';
		}
	}
	switch ($comment->comment_type) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		• <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)' ), '<span class="edit-link">', '</span>' ); ?>
	<?php
		break;
		default :
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<div id="comment-<?php comment_ID(); ?>" class="comment-body">
			<div class="comment-author">
				<div class="comment-face l">
					<?php if( $comment->comment_parent == 0 ) { echo get_avatar( $comment, 76 ); }else{ echo get_avatar( $comment, 32 ); } ?><b></b>
				</div>		
				<?php if(dopt('comment_floor')){ echo $commentcountText; }?>
				<strong><?php echo get_comment_author_link(); ?></strong> <?php if(dopt('guest_level')){get_author_class($comment->comment_author_email,$comment->comment_author_url);} ?> 
				<?php 
					if($comment->comment_parent){
						//$comment_parent_href = htmlspecialchars(get_comment_link( $comment->comment_parent ));
						$comment_parent = get_comment($comment->comment_parent);
					?>
					<span><a href="#comment-<?php echo $comment->comment_parent; ?>">@ <?php echo $comment_parent->comment_author;?></a></span>
				<?php } ?>
				<span class="reply<?php if(!dopt('comment_floor')){ echo ' r'; }?>"><?php comment_reply_link( array_merge( $args, array( 'reply_text' => ' 回复', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></span>
				<div class="comment-date">
					<span><?php printf(__('%1$s %2$s'), get_comment_date(),  get_comment_time()) ?></span>
					<span class="country-flag"><?php if (function_exists("get_useragent")) { get_useragent($comment->comment_agent); } ?></span>
					<span><?php edit_comment_link(__('(Edit)'),'  ','') ?></span>
				</div>
			</div>
			<div class="commnet-main">
				<?php comment_text() ?>
				<?php if ($comment->comment_approved == '0') : ?>
					<em><?php _e('Your comment is awaiting moderation.') ?></em>
				<?php endif; ?>
			</div>
		</div>
<?php
		break;
	endswitch;
}

function tucao_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
	case 'pingback' :
	case 'trackback' :
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
		break;
		default :
		global $post;
	?>
	<li class="comment<?php if($depth == 1){ echo ' depth-1';}elseif($depth == 2){echo ' depth-2';}else{echo ' depth-deep';} ?>" id="li-comment-<?php comment_ID(); ?>">
		<?php if( $comment->comment_parent == 0 ) { ?>
			<div id="comment-<?php comment_ID(); ?>" class="clearfix">
				<div class="clearfix">
					<div class="l" style="padding-right:20px"><?php echo get_avatar( $comment, 50 ); ?></div>
					<div style="padding-bottom:10px">
						<strong><?php comment_author_link(); ?></strong>
						<span style="font-size:12px; color:#999">
						<time datetime="<?php echo get_comment_time( 'c' ); ?>"><?php printf(__('%1$s %2$s'), get_comment_date(),  get_comment_time()) ?></time>
						<?php edit_comment_link( __( 'Edit' ), ' <span class="edit-link">', '</span>' ); ?>
						</span>
						<span class="r"><?php comment_reply_link( array_merge( $args, array( 'reply_text' => '<span class="btn" style="padding: 3px 6px 4px;font-size:12px">+1</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></span>
					</div>
					<div style="overflow:auto"><?php comment_text(); ?></div>
				</div>
			</div>
		<?php }else{ ?>
			<div id="comment-<?php comment_ID(); ?>" class="clearfix" style="border-bottom:1px solid #e0dbd1;padding-bottom:15px;margin-bottom:15px">
				<div class="clearfix" style="padding-bottom:6px">
					<span class="r" style="font-size:12px; color:#999">
						<?php comment_reply_link( array_merge( $args, array( 'reply_text' => '<span class="btn" style="padding:0 3px;">+1</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
						<time datetime="<?php echo get_comment_time( 'c' ); ?>"><?php printf(__('%1$s %2$s'), get_comment_date(),  get_comment_time()) ?></time>
						<?php edit_comment_link( __( 'Edit' ), '<span class="edit-link"> ', '</span>' ); ?>
					</span>
					<span class="l" style="padding-right:8px"><?php echo get_avatar( $comment, 20 ); ?></span><?php comment_author_link(); ?>
					<?php 
						//$comment_parent_href = get_comment_link( $comment->comment_parent );
						$comment_parent = get_comment($comment->comment_parent);
					?>
					<span><a href="#comment-<?php echo $comment->comment_parent; ?>">@ <?php echo $comment_parent->comment_author;?></a></span>
				</div>
				<?php comment_text(); ?>
				<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></p>
				<?php endif; ?>
			</div>
		<?php } ?>
<?php
	break;
	endswitch;
}

function mytheme_end_comment() {
	echo '</li>';
}
//获取访客VIP样式
function get_author_class($comment_author_email,$comment_author_url){
	$adminEmail = get_bloginfo ('admin_email');
	$author_comment = get_comments(array('author_email' => $comment_author_email, 'status' => 'approve'));
	$author_count = count($author_comment);//$wpdb->get_results("SELECT comment_ID as author_count FROM $wpdb->comments WHERE comment_author_email = '$comment_author_email' ")
	if($comment_author_email == $adminEmail){
		echo '<span class="vp" title="我是博主"></span>';
	}
	if($author_count>=1 && $author_count<5 && $comment_author_email!=$adminEmail){
		echo '<span class="vip1" title="不到 5 评的过客"></span>';
	}elseif($author_count>=5 && $author_count<15 && $comment_author_email!=$adminEmail){
		echo '<span class="vip2" title="还没 15 评的群众"></span>';
	}elseif($author_count>=15 && $author_count<30 && $comment_author_email!=$adminEmail){
		echo '<span class="vip3" title="将近 30 评的播音"></span>';
	}elseif($author_count>=30 && $author_count<50 && $comment_author_email!=$adminEmail){
		echo '<span class="vip4" title="就要 50 评的专家"></span>';
	}elseif($author_count>=50 &&$author_count<80 && $comment_author_email!=$adminEmail){
		echo '<span class="vip5" title="马上 80 评的讲师"></span>';
	}elseif($author_count>=80 && $author_coun<200 && $comment_author_email!=$adminEmail){
		echo '<span class="vip6" title="目标 200 评的水神"></span>';
	}elseif($author_count>=200 && $comment_author_email!=$adminEmail){
		echo '<span class="vip7" title="超过 200 评的龙王来了！"></span>';
	}
	$linkurls = get_bookmarks();
	foreach ($linkurls as $linkurl) {
		if ($linkurl->link_url == $comment_author_url ){
			echo ' <a class="vip" target="_blank" href="/links" title="链接榜上的名人"></a>';
		}
	}
}
?>