<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
	<meta name="viewport" content="initial-scale=1.0,user-scalable=no">
	<?php if (is_single() || is_page() || is_home() || is_category() ) : ?>
	<meta name="robots" content="index,follow" /><?php else : ?>
	<meta name="robots" content="noindex,follow" /><?php endif; ?>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<?php mytheme_keywords(); ?>
	<?php mytheme_description(); ?>
	<?php wp_head(); ?>
<!-- 请置于所有广告位代码之前 -->
<script type="text/javascript" src="http://cbjs.baidu.com/js/m.js"></script>
<meta name="baidu_union_verify" content="f21e61f21def7bd50106eac5283599b4">
</head>
<body <?php body_class(); ?>>
<div class="header">
	<div class="headerInner">
		<div class="logo" id="logo">
			<a href="<?php echo get_option('home'); ?>/">
				<span class="blogName"><?php bloginfo('name'); ?></span>
			</a>
		</div>
		<div class="signInFrame">
			<?php get_template_part( 'files/loginout' ); ?>
		</div>
		<ul class="nav" id="nav">
			<?php wp_nav_menu( array(
				'theme_location' => 'blog-menu',
				'container' => '',
				'fallback_cb' => 'link_to_menu_editor',
				'items_wrap' => '%3$s'
				));
			?>
			<div class="search fold" id="indexSearch">
				<form role="search" method="get" id="indexsearchform" action="<?php bloginfo('url'); ?>/"><input type="text" value="" name="s" id="s" placeholder="请输入搜索内容" /><button type="button" id="searchsubmit" value="Search" onclick="iSearch.post();"></button></form>
			</div>
			<?php get_template_part( 'files/menu-right' ); ?>
		</ul>
	</div>
</div>
<div class="main">
	<div class="banner box"></div>
	<!--<?php if(!is_home()){ ?><div class="crumbs"><?php echo wp_breadcrumb(); ?></div><?php } ?> !-->
	<?php
		if(is_home() && dopt('home_pic_show')){
			get_template_part( 'files/focus' );
		}elseif(dopt('4gridad')){
			get_template_part( 'files/4gridad' );
		}
	?>
	<div class="content clearfix">