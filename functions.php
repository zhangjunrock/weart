<?php
define('IsMobile', wp_is_mobile());
function dopt($e){
    return stripslashes(get_option($e));
}
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => '通用侧边',
		'description'   => '全站通用侧边�&#65533;',
		'before_widget' => '<div class="widget %2$s box">',
		'after_widget' => '</div>',
		'before_title' => '<h4><strong>',
		'after_title' => '</strong></h4>',
	));
	register_sidebar(array(
		'name' => '首页侧边（home�&#65533;',
		'description'   => '添加在这里的小工具显示在首页侧边�&#65533;',
		'id' => 'sidebar-home',
		'before_widget' => '<div class="widget %2$s box">',
		'after_widget' => '</div>',
		'before_title' => '<h4><strong>',
		'after_title' => '</strong></h4>',
	));
	register_sidebar(array(
		'name' => '分类页侧边（category�&#65533;',
		'description'   => '添加在这里的小工具显示在分类页侧边栏',
		'id' => 'sidebar-category',
		'before_widget' => '<div class="widget %2$s box">',
		'after_widget' => '</div>',
		'before_title' => '<h4><strong>',
		'after_title' => '</strong></h4>',
	));
	register_sidebar(array(
		'name' => '内容页侧边（single�&#65533;',
		'description'   => '添加在这里的小工具显示在内容页侧边栏',
		'id' => 'sidebar-single',
		'before_widget' => '<div class="widget %2$s box">',
		'after_widget' => '</div>',
		'before_title' => '<h4><strong>',
		'after_title' => '</strong></h4>',
	));
	register_sidebar(array(
		'name' => '页面侧边（page�&#65533;',
		'description'   => '添加在这里的小工具显示在单页侧边�&#65533;',
		'id' => 'sidebar-page',
		'before_widget' => '<div class="widget %2$s box">',
		'after_widget' => '</div>',
		'before_title' => '<h4><strong>',
		'after_title' => '</strong></h4>',
	));
	register_sidebar(array(
		'name' => '其他页面侧边（archive�&#65533;',
		'description'   => '添加在这里的小工具显示在tag、search、archive、author等页面侧边栏',
		'id' => 'sidebar-archive',
		'before_widget' => '<div class="widget %2$s box">',
		'after_widget' => '</div>',
		'before_title' => '<h4><strong>',
		'after_title' => '</strong></h4>',
	));
	register_sidebar(array(
		'name' => '跟随页面滚动侧边（slider�&#65533;',
		'description'   => '添加在这里的内容会跟随页面滚�&#65533;',
		'id' => 'slidebox',
		'before_widget' => '<div class="widget %2$s box">',
		'after_widget' => '</div>',
		'before_title' => '<h4><strong>',
		'after_title' => '</strong></h4>',
	));
}
function minu_setup() {
	load_theme_textdomain( 'simple_write', get_template_directory() . '/languages' );
	add_editor_style();
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-formats', array( 'aside', 'gallery', 'quote', 'image' ) );
	register_nav_menus(array('top-menu' => __('顶部菜单'),'blog-menu' => __('导航菜单'),'side-menu'=> __('侧边菜单'),'footer-menu' => __('页角菜单'),'widget-menu' => __('侧边小工具菜�&#65533;') ));
	add_theme_support( 'post-thumbnails' );
}
add_action( 'after_setup_theme', 'minu_setup' );
function minu_scripts_styles() {
	global $wp_styles;
	if(dopt('the_jquery')=='JQUERY'){
		$jqueryurl = "http://code.jquery.com/jquery-1.8.3.min.js";
	}elseif(dopt('the_jquery')=='GOOGLE'){
		$jqueryurl = "http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js";
	}elseif(dopt('the_jquery')=='MSDN'){
		$jqueryurl = "http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.3.min.js";
	}elseif(dopt('the_jquery')=='SINA'){
		$jqueryurl = "http://lib.sinaapp.com/js/jquery/1.8.3/jquery.min.js";
	}else{
		$jqueryurl = get_template_directory_uri() . '/js/jquery.min.js';
	}
	wp_deregister_script( 'jquery' );
	wp_enqueue_script( 'jquery', $jqueryurl ,array(), '', true );
	wp_deregister_script( 'comment-reply' );
	wp_enqueue_script('theme-js', get_bloginfo('template_directory') . '/js/main.js', array(), '', true );
	//if( IsMobile ) wp_enqueue_script( 'mobile', get_bloginfo('template_directory') . '/js/mobile.js', array(), '1.0.0', true);
	if ( is_singular() ){ 
		global $post;
		$postid = $post->ID;
		$ajaxurl = home_url("/");
		wp_enqueue_script( 'single-js', get_template_directory_uri() . '/js/single.js', array(), '', true);
		wp_localize_script( 'single-js', 'happyet_org', array(
			"postid" => $postid,
			"ajaxurl" => $ajaxurl
		));
		wp_enqueue_script( 'comment-reply', get_bloginfo('template_directory') . '/js/comments-ajax.js', array(), '', true );
		wp_enqueue_script( 'comment-reply' );
		if(dopt('use_thickbox')) {
			wp_enqueue_script('thickbox');
			wp_enqueue_style('thickbox');
		}
	}else{
		$ajaxurl = home_url("/");
		wp_localize_script( 'theme-js', 'happyet_org', array(
			"ajaxurl" => $ajaxurl
		));
	}
	wp_enqueue_style( 'style', get_stylesheet_uri() );
	if(dopt('theme_style')!=='默认风格'){
		wp_register_style( 'theme-style', get_template_directory_uri() . '/css/' . dopt('theme_style'), array(), '20130920' );
		wp_enqueue_style('theme-style');
	}
	if(dopt('lazyload')) wp_enqueue_script('lazy-load',get_bloginfo('template_directory') . '/js/lazyload.js', array(), '', true );
	wp_enqueue_style( 'ie-css', get_template_directory_uri() . '/css/hack/ie7.css', array( 'minu_style' ), '20121010' );
	$wp_styles->add_data( 'ie-css', 'conditional', 'lt IE 9' );
}    
add_action('wp_enqueue_scripts', 'minu_scripts_styles'); 

if (is_admin()) require get_template_directory() . '/inc/option/theme-options.php';
require get_template_directory() . '/inc/wp-fixed.php';
require get_template_directory() . '/inc/addon-functions.php';
require get_template_directory() . '/inc/my-pagenav.php';
if(dopt('auto_trancode')) require get_template_directory() . '/inc/auto-code.php';
if(dopt('auto_excerpt')) require get_template_directory() . '/inc/my-excerpt.php';
require get_template_directory() . '/inc/my-comments.php';
require get_template_directory() . '/inc/miui-widget.php';
if(dopt('auto_tagslink')) require get_template_directory() . '/inc/auto-tagslink.php';
if(dopt('antispam_mail')) require get_template_directory() . '/inc/antispam-mail.php';
if(dopt('guest_useragent')) require get_template_directory() . '/inc/my-useragent.php';
require get_template_directory() . '/inc/shortcode.php';
require get_template_directory() . '/inc/custom-register.php';
require get_template_directory() . '/inc/zww-achevies.php';
require get_template_directory() . '/inc/recentviews.php';
if(dopt('header_csscode')){
	function header_csscode(){
		echo '<style type="text/css">' . dopt('header_csscode') . '</style>';
	}
	add_filter("wp_head", "header_csscode", 99);
}
if(dopt('footer_jscode')){
	function footer_jscode(){
		echo '<script type="text/javascript">' . dopt('footer_jscode') . '</script>';
	}
	add_filter("wp_footer", "footer_jscode", 99);
}

function _remove_script_version( $src ){
	$parts = explode( '?', $src );
	return $parts[0];
}
add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );
?>