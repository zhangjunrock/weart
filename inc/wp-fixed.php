<?php
remove_action( 'wp_head', 'wp_generator');
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
remove_filter( 'the_content', 'wptexturize');
remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'wpautop' , 12);
//关闭前台显示管理工具条
show_admin_bar(false);
//后台登陆LOGO修改
function custom_login_logo() {
	echo "<link rel='stylesheet' id='colors-fresh-css'  href='".get_bloginfo("template_url")."/inc/admin-style.css' type='text/css' media='all' />";
}
add_action('login_head', 'custom_login_logo');
//移除自动保存和修订版本
if(dopt('disautosave')){
	remove_action('pre_post_update', 'wp_save_post_revision' );
	function disable_autosave() {
		wp_deregister_script('autosave');
	}
	add_action( 'wp_print_scripts', 'disable_autosave' );
}
//友情链接
add_filter( 'pre_option_link_manager_enabled', '__return_true' );
//固定链接去除category
if(dopt('permalink_nocat')){
	function kill_category_base($string)  {
		$string = str_replace('category/', '', $string);
		return $string;
	}
	add_filter('category_link', 'kill_category_base');
}
//分类rel优化
function the_category_filter($thelist){
	return preg_replace('/rel=".*?"/','rel="tag"',$thelist);
}
add_filter('the_category','the_category_filter');
//菜单增加首页
function twentytwelve_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) )
		$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'twentytwelve_page_menu_args' );
//菜单样式优化
function special_nav_class($classes, $item){
    $current_and_home = array("current-menu-item", "menu-item-home", 'last');
    $classes = array_intersect($item->classes,$current_and_home);
    return $classes;
}
add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2); 
function special_nav_item_id($item_id, $item){
	$item_id = ""; //去除 id
    return $item_id;
}
add_filter('nav_menu_item_id' , 'special_nav_item_id' , 10 , 2);
//禁用默认相册样式
add_filter( 'use_default_gallery_style', '__return_false' );
//链接图片添加thickbox
function add_gallery_id_rel($link) {
    global $post;
    return str_replace('<a href', '<a class="thickbox" rel="gallery-'. $post->ID .'" href', $link);
}
add_filter('wp_get_attachment_link', 'add_gallery_id_rel');
function thickbox( $content ){
	global $post;
	return preg_replace( '/<a(.*?)href=(.*?).(bmp|gif|jpeg|jpg|png)"(.*?)>/i', '<a$1href=$2.$3" $4 class="thickbox" rel="gallery-'. $post->ID .'">', $content );
}
add_filter( 'the_content', 'thickbox', 2 );
//退出后回首页 
function mk_logout_redirect_home($logouturl, $redir){
    $redir = home_url();
    return $logouturl . '&redirect_to=' . urlencode($redir);
}
add_filter('logout_url', 'mk_logout_redirect_home', 10, 2);
//纯英文评论拒绝
if(dopt('comment_no_english')){
	function scp_comment_post( $incoming_comment ) {
		$pattern = '/[一-龥]/u';
		if(!preg_match($pattern, $incoming_comment['comment_content'])) {
			err( "为防止垃圾评论，您的评论中必须包含汉字!" );
		}
		return( $incoming_comment );
	}
	add_filter('preprocess_comment', 'scp_comment_post');
}
//用户名邮箱检测
if(dopt('check_username_email')){
	function CheckEmailAndName(){
		global $wpdb;
		$comment_author = ( isset($_POST['author']) ) ? trim(strip_tags($_POST['author'])) : null;
		$comment_author_email = ( isset($_POST['email']) ) ? trim($_POST['email']) : null;
		if(!$comment_author || !$comment_author_email){
			return;
		}
		$result_set = $wpdb->get_results("SELECT display_name, user_email FROM $wpdb->users WHERE display_name = '" . $comment_author . "' OR user_email = '" . $comment_author_email . "'");
		if ($result_set) {
			if ($result_set[0]->display_name == $comment_author){
				err(__('用户名已被注册，注册用户请 <a href="/wp-login.php" style="color:#ff6f3d">登录</a> 后评论！<a href="/wp-login.php?action=lostpassword">忘记密码？</a>'));
			}else{
				err(__('邮箱已被注册，注册用户请 <a href="/wp-login.php" style="color:#ff6f3d">登录</a> 后评论！<a href="/wp-login.php?action=lostpassword">忘记密码？</a>'));
			}
			fail($errorMessage);
		}
	}
	add_action('pre_comment_on_post', 'CheckEmailAndName');
}
// 检测黑名单用户
if(dopt('check_black_list') && dopt('black_notify')){
	function BYMT_fuckspam($comment) {
		if(  is_user_logged_in()){ return $comment;} //登录用户无压力...
		if( wp_blacklist_check($comment['comment_author'],$comment['comment_author_email'],$comment['comment_author_url'], $comment['comment_content'], $comment['comment_author_IP'], $comment['comment_agent'] )){
			$notify_txt= dopt('black_notify');
			header("Content-type: text/html; charset=utf-8");
			 err($notify_txt);
		}  else  {
			return $comment; 
		}
	} 
	add_filter('preprocess_comment', 'BYMT_fuckspam');
}
//评论字数限制
if(dopt('comment_count_check')){
	function BYMT_comment_length( $commentdata ) {
		$minCommentlength = dopt('comment_count_less');
		$maxCommentlength = dopt('comment_count_more');
		$pointCommentlength = mb_strlen($commentdata['comment_content'],'UTF8');
		if ( $pointCommentlength < $minCommentlength )
			{
				err( __('抱歉，您的评论太短了，请至少输入' . $minCommentlength .'个字（已输入'. $pointCommentlength .'个字）') );
			}
		if ( $pointCommentlength > $maxCommentlength )
			{
				err( __('抱歉，您的评论太长了，请不要超过' . $maxCommentlength .'个字（已输入'. $pointCommentlength .'个字）') );
			}
		return $commentdata;
	}
	add_filter( 'preprocess_comment', 'BYMT_comment_length' );
}
//评论链接新窗口打开
if(dopt('comment_link_blank')){
	function hu_popuplinks($text) {
		$text = preg_replace('/<a (.+?)>/i', "<a $1 target='_blank'>", $text);
		return $text;
	}
	add_filter('get_comment_author_link', 'hu_popuplinks', 6);
}
//添加nofollow在评论回复链接中
if(dopt('comment_link_nofollow')){
	function add_nofollow_to_reply_link( $link ) {
		return str_replace( '")\'>', '")\' rel=\'nofollow\'>' , $link );
	}
	add_filter( 'comment_reply_link', 'add_nofollow_to_reply_link' );
}
//设置默认头像
if(dopt('comment_avatar_diy')){
	function fb_addgravatar( $avatar_defaults ) {
		if(dopt('avatar_diy_name')){$myavatar_name = dopt('avatar_diy_name');}else{$myavatar_name = defaultgravatar.png;}
		$myavatar = get_bloginfo('template_directory') . '/images/' . $myavatar_name;
		$avatar_defaults[$myavatar] = '自定义头像';
		return $avatar_defaults;
	}
	add_filter( 'avatar_defaults', 'fb_addgravatar' );
}
//头像中转多说 解决被墙问题
if(dopt('comment_avatar_duoshuo')){
	function mytheme_get_avatar($avatar) {
		$avatar = str_replace(array("www.gravatar.com","0.gravatar.com","1.gravatar.com","2.gravatar.com"),"gravatar.duoshuo.com",$avatar);
		return $avatar;
	}
	add_filter( 'get_avatar', 'mytheme_get_avatar', 10, 3 );
}
//判断是否有头像
//function validate_gravatar($email) {
//	$hash = md5(strtolower(trim($email)));
//	$uri = 'http://gravatar.duoshuo.com/avatar/' . $hash . '?d=404';
//	$headers = @get_headers($uri);
//	if (!preg_match("|200|", $headers[0])) {
//		$has_valid_avatar = FALSE;
//	} else {
//		$has_valid_avatar = TRUE;
//	}
//return $has_valid_avatar;
//}
//自定义表情路径
function custom_smilies_src ($img_src, $img, $siteurl){
	return get_template_directory_uri() .'/images/smilies/'.$img;
};
add_filter('smilies_src','custom_smilies_src',1,10);
//移除wordpress登陆漏洞
add_filter('login_errors',create_function('$a', "return null;"));
// 只搜索文章，排除页面
add_filter('pre_get_posts','search_filter');
function search_filter($query) {
	if ($query->is_search) {
		$query->set('post_type', 'post');
	}
	return $query;
}
//设置个人资料相关选项
function my_profile( $contactmethods ) {
	$contactmethods['QQ'] = 'QQ';   //增加
	$contactmethods['douban'] = '豆瓣';
	$contactmethods['renren'] = '人人';
	$contactmethods['qweibo'] = '腾讯微博';
	$contactmethods['weibo'] = '新浪微博';
	$contactmethods['twitter'] = 'twitter';
	$contactmethods['facebook'] = 'facebook';
	$contactmethods['gplus'] = 'google+';
	$contactmethods['donate'] = '捐助链接';
	unset($contactmethods['aim']);   //删除
	unset($contactmethods['yim']);
	unset($contactmethods['jabber']);
	return $contactmethods;
}
add_filter('user_contactmethods','my_profile');
//Feed中添加版权信息
add_filter('the_content', 'BYMT_feed_copyright');
function BYMT_feed_copyright($content) {    
	if(is_feed()) {                    
		$content.= '<div>声明: 本文采用 <a rel="external" href="http://creativecommons.org/licenses/by-nc-sa/3.0/deed.zh" title="署名-非商业性使用-相同方式共享 3.0 Unported">CC BY-NC-SA 3.0</a> 协议进行授权</div>';
		$content.= '<div>转载请注明来源：<a rel="external" title="'.get_bloginfo('name').'" href="'.get_permalink().'">'.get_bloginfo('name').'</a></div>';    
		$content.= '<div>本文链接地址：<a rel="external" title="'.get_the_title().'" href="'.get_permalink().'">'.get_permalink().'</a></div>';                    
	}
	return $content;    
}
//body手机class
function browser_body_class($classes) {
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
	if($is_lynx) $classes[] = 'lynx';
	elseif($is_gecko) $classes[] = 'gecko';
	elseif($is_opera) $classes[] = 'opera';
	elseif($is_NS4) $classes[] = 'ns4';
	elseif($is_safari) $classes[] = 'safari';
	elseif($is_chrome) $classes[] = 'chrome';
	elseif($is_IE){
	   $classes[] = 'ie';
	   //if the browser is IE6
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6') !== false){
			$classes[] = 'ie6'; //add 'ie6' class to the body class array
		}
	}
	else $classes[] = 'unknown';
	if($is_iphone) $classes[] = 'iphone';
	return $classes;
}
add_filter('body_class','browser_body_class');
?>