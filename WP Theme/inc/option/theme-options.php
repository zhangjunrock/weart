<?php
$themename = $theme_name.'主题';
//Stylesheets Reader
$alt_stylesheet_path = TEMPLATEPATH . '/css/';
$alt_stylesheets = array();
$alt_stylesheets[] = '';

if ( is_dir($alt_stylesheet_path) ) {
    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) { 
        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {
            if(stristr($alt_stylesheet_file, ".css") !== false) {
                $alt_stylesheets[] = $alt_stylesheet_file;
            }
        }    
    }
}
$options = array (
	//基本设置
	array("name" => "基本设置","type" => "section","desc" => "主题的基本设置"),
		array("name" => "选择博客颜色风格",	"type" => "tit"),
		array("name" => "选择颜色风格",	"desc" => "还有4种主题风格供选择","id" => "theme_style","std" => "Select a CSS skin:","type" => "select","options" => $alt_stylesheets,		"default_option_value" => "默认风格"),
		array("name" => "网站关键词（KeyWords）",	"type" => "tit"),
		array("id" => "KeyWords","class" => "d_area","type" => "textarea","std" => "网站的关键词，SEO项目，极其重要。用英文半角逗号隔开，一般不超过100个字符。"),
		array("name" => "网站描述（Description）","type" => "tit"),
		array("id" => "Description","class" => "d_area","type" => "textarea","std" => "网站的描述，SEO项目，极其重要，一般不超过200个字符。"),
		array("name" => "建站日期","type" => "tit"),	
		array("id" => "blog_date","type" => "text","std" => "2013-8-1","txt" => "建站日期："),
		array("name" => "第三方订阅地址","type" => "tit"),	
		array("id" => "feed_url","type" => "text","std" => "使用外部订阅地址，如：http://happyet.feedsky.com","txt" => "订阅地址"),
		array("name" => "订阅到邮箱ID","type" => "tit"),	
		array("id" => "feed_to_email","type" => "text","std" => "QQ的订阅到邮箱功能，此处填写ID，类似：e34768f3bedee9ebb5bfd561aece9626056fee1590f62545","txt" => "订阅地址："),
		array("name" => "备案信息","type" => "tit"),	
		array("id" => "blog_ipc","type" => "text","std" => "干ICP备OOXXXOO号-1","txt" => "工信部备案号："),
		array("name" => "统计代码","type" => "tit"	),
		array("id" => "Statistics_Code","class" => "d_area","type" => "textarea","std" => "第三方统计代码，用于统计网站流量。"),
	array( "type" => "endtag"),
	//首页5格
	array( "name" => "首页5格","type" => "section","desc" => "主题功能开关控制。"),
		array( "name" => "首页5格图片展示","type" => "tit"),
		array( "id" => "home_pic_show","desc" => "开启首页顶部图片5格展示：","type" => "checkbox" ),
		//5格左侧大图轮播
		array( "name" => "首页图片展示左侧轮播大图设置","type" => "tit"),
		array( "id" => "home_pic_show_mode","desc" => "左侧大图获取模式：",'options'=>array('','置顶','指定','手动'),"type" => "select" ),
		array( "id" => "show_mode_id","type" => "text","desc" => "指定模式下文章ID：","std" => "英文半角逗号隔开，如：12,53,68，不要超过5个","class" => "d_inp_short"),
		array( "name" => "左侧大图手动模式下图片地址与连接","type" => "tit"),
		array( "id" => "diy_mode_title1","type" => "text","desc" => "标题1：","std" => "显示的文字内容","class" => "d_inp_short"),
		array( "id" => "diy_mode_link1","type" => "text","desc" => "链接1：","std" => "图片跳转的链接","class" => "d_inp_short"),
		array( "type" => "clear"),
		array( "id" => "diy_mode_img1","type" => "text","desc" => "图片地址1：","std" => "图片大小：600*331或594*325","class" => "d_inp_middle"),
		array( "type" => "clear"),
		array( "id" => "diy_mode_title2","type" => "text","desc" => "标题2：","std" => "显示的文字内容","class" => "d_inp_short"),
		array( "id" => "diy_mode_link2","type" => "text","desc" => "链接2：","std" => "图片跳转的链接","class" => "d_inp_short"),
		array( "type" => "clear"),
		array( "id" => "diy_mode_img2","type" => "text","desc" => "图片地址2：","std" => "图片大小：600*331或594*325","class" => "d_inp_middle"),
		array( "type" => "clear"),
		array( "id" => "diy_mode_title3","type" => "text","desc" => "标题3：","std" => "显示的文字内容","class" => "d_inp_short"),
		array( "id" => "diy_mode_link3","type" => "text","desc" => "链接3：","std" => "图片跳转的链接","class" => "d_inp_short"),
		array( "type" => "clear"),
		array( "id" => "diy_mode_img3","type" => "text","desc" => "图片地址3：","std" => "图片大小：600*331或594*325","class" => "d_inp_middle"),
		//右侧4图
		array( "name" => "首页图片展示右侧4图设置","type" => "tit"),
		array( "id" => "home_right_show_mode","desc" => "右侧四图获取模式：",'options'=>array('','指定','手动'),"type" => "select" ),
		array( "id" => "right_show_id","type" => "text","desc" => "指定模式下文章ID：","std" => "英文半角逗号隔开，如：12,53,68，4个","class" => "d_inp_short"),
		array( "name" => "右侧四图手动模式下图片地址与连接","type" => "tit"),
		array( "id" => "right_mode_title1","type" => "text","desc" => "标题1：","std" => "显示的文字内容","class" => "d_inp_short"),
		array( "id" => "right_mode_link1","type" => "text","desc" => "链接1：","std" => "图片跳转的链接","class" => "d_inp_short"),
		array( "type" => "clear"),
		array( "id" => "right_mode_img1","type" => "text","desc" => "图片地址1：","std" => "图片大小：179*201或173*195","class" => "d_inp_middle"),
		array( "type" => "clear"),
		array( "id" => "right_mode_title2","type" => "text","desc" => "标题2：","std" => "显示的文字内容","class" => "d_inp_short"),
		array( "id" => "right_mode_link2","type" => "text","desc" => "链接2：","std" => "图片跳转的链接","class" => "d_inp_short"),
		array( "type" => "clear"),
		array( "id" => "right_mode_img2","type" => "text","desc" => "图片地址2：","std" => "图片大小：179*126或173*120","class" => "d_inp_middle"),
		array( "type" => "clear"),
		array( "id" => "right_mode_title3","type" => "text","desc" => "标题3：","std" => "显示的文字内容","class" => "d_inp_short"),
		array( "id" => "right_mode_link3","type" => "text","desc" => "链接3：","std" => "图片跳转的链接","class" => "d_inp_short"),
		array( "type" => "clear"),
		array( "id" => "right_mode_img3","type" => "text","desc" => "图片地址3：","std" => "图片大小：179*126或173*120","class" => "d_inp_middle"),
		array( "type" => "clear"),
		array( "id" => "right_mode_title4","type" => "text","desc" => "标题4：","std" => "显示的文字内容","class" => "d_inp_short"),
		array( "id" => "right_mode_link4","type" => "text","desc" => "链接4：","std" => "图片跳转的链接","class" => "d_inp_short"),
		array( "type" => "clear"),
		array( "id" => "right_mode_img4","type" => "text","desc" => "图片地址4：","std" => "图片大小：179*201或173*195","class" => "d_inp_middle"),
	array( "type" => "endtag"),
	//首页其他
	array( "name" => "首页其他","type" => "section","desc" => "主题功能开关控制。"),
		array( "name" => "开启首页列表顶部5篇文章","type" => "tit"),
		array( "id" => "home_top5_show","desc" => "开启首页文章列表顶部5篇文章：","type" => "checkbox" ),
		//TOP第一篇
		array( "name" => "TOP第一篇显示内容","type" => "tit"),
		array( "id" => "top_no1_mode","desc" => "TOP第一篇来源：",'options'=>array('','置顶文章','指定分类','指定文章'),"type" => "select" ),
		array( "id" => "top_no1_category","type" => "number","std" => "745","txt" => "指定分类的ID："),
		array( "id" => "top_no1_post","type" => "number","std" => "3","txt" => "指定文章的ID："),
		//TOP后四篇
		array( "name" => "TOP并排四篇显示内容","type" => "tit"),
		array( "id" => "top_no4_mode","desc" => "TOP并排4篇来源：",'options'=>array('','置顶文章','指定分类','指定文章'),"type" => "select" ),
		array( "id" => "top_no4_category","type" => "number","std" => "745","txt" => "指定分类的ID："),
		array( "id" => "top_no4_post","type" => "text","std" => "3,4,5,6","txt" => "指定文章的ID：","desc" => "指定文章的ID：",'class'=>'d_inp_150'),
		//首页列表文章排除置顶
		array( "name" => "首页列表文章排除置顶","type" => "tit"),
		array( "id" => "exclude_sticky","desc" => "开启文章列表中不显示置顶文章：","type" => "checkbox" ),
		array( "name" => "首页列表文章排除分类","type" => "tit"),
		array( "id" => "exclude_category","type" => "text","desc" => "不在首页显示的分类ID：","std" => "如：-1000,-842，ID前加负号，多个ID半角英文隔开","class" => "d_inp_short"),
		array( "name" => "首页及其他列表页文章缩略图及自动摘要","type" => "tit"),
		array( "id" => "auto_thumbpic","desc" => "开启自动缩略图：","type" => "checkbox" ),
		array( "id" => "auto_excerpt","desc" => "开启自动摘要：","type" => "checkbox" ),
		array( "id" => "excerpt_length","type" => "number","std" => "180","txt" => "摘要长度："),
		array( "type" => "clear"),
		array( "id" => "use_more_link","desc" => "开启摘要末尾的read more链接：","type" => "checkbox" ),
		array( "id" => "read_more_link","type" => "text","desc" => "自定义read more文字：","std" => "如：阅读全文》","class" => "d_inp_150"),
		array( "type" => "clear"),
		array( "id" => "allowed_tag","type" => "text","std" => "如：<p><h2><h3><blockquote><a>等等","desc" => "摘要不过滤的HTM标签：","class" => "d_inp_short"),
		array( "name" => "底部友情链接设置","type" => "tit"),
		array( "id" => "blogrolls","desc" => "开启首页底部友情链接显示：","type" => "checkbox" ),
		array( "id" => "blogrolls_home","desc" => "只在首页显示：","type" => "checkbox" ),
		array( "id" => "blogrolls_homep","desc" => "只在首页第一页显示：","type" => "checkbox" ),
		array( "type" => "clear"),
		array( "id" => "blogrolls_image","type" => "text","desc" => "有图片logo的链接分类名称（不是分类别名，没有请留空）：","std" => "","class" => "d_inp_150"),
		array( "type" => "clear"),
		array( "id" => "blogrolls_txt","type" => "text","desc" => "显示在首页的链接分类名称（不是分类别名，留空显示全部）：","std" => "","class" => "d_inp_150"),
	array( "type" => "endtag"),
	//功能开关
	array( "name" => "功能开关","type" => "section","desc" => "主题功能开关"),
		//JQ
		array( "name" => "选择JQUERY","type" => "tit"),
		array( "id" => "the_jquery","desc" => "选择jQuery库来源：",'options'=>array('博客自带','JQUERY','MSDN','SINA','GOOGLE'),"type" => "select" ),
		array( "name" => "禁用文章自动保存功能","type" => "tit"),
		array( "id" => "disautosave","desc" => "禁用文章发布编辑时自动保存和修订版本：","type" => "checkbox" ),
		array( "name" => "使用wordpress自带的thickbox放大图片","type" => "tit"),
		array( "id" => "use_thickbox","desc" => "使用thickbox请务必使图片链接到原媒体图片：","type" => "checkbox" ),
		array( "name" => "文章页正文内容顶部显示吐槽","type" => "tit"),
		array( "id" => "show_tucao","desc" => "开启文章页显示吐槽：","type" => "checkbox" ),
		array( "id" => "tucao_page_id","type" => "number","std" => "343","txt" => "吐槽页面ID："),
		array( "name" => "文章页面内容底部相关文章","type" => "tit"),
		array( "id" => "relate_posts","desc" => "开启文章页面相关文章显示：","type" => "checkbox" ),
		array( "name" => "文章页面版权声明","type" => "tit"),
		array( "id" => "post_copyright","desc" => "开启文章页面版权声明显示：","type" => "checkbox" ),
		array( "name" => "文章页面作者信息显示","type" => "tit"),
		array( "id" => "post_author","desc" => "开启文章页面作者信息显示：","type" => "checkbox" ),
		array( "name" => "文章代码自动转换","type" => "tit"),
		array( "id" => "auto_trancode","desc" => "开启使用pre code发代码时自动转译，以前发的无效须重新编辑保存：","type" => "checkbox" ),
		array( "name" => "文章页面百度分享","type" => "tit"),
		array( "id" => "post_bdshare","desc" => "开启文章页面百度分享按钮显示：","type" => "checkbox" ),
		array( "id" => "bdshare_uid","type" => "text","std" => "如：757903","desc" => "你的百度分享识别UID：",'class'=>'d_inp_150'),
		array( "name" => "文章关键字自动链接到tag页面","type" => "tit"),
		array( "id" => "auto_tagslink","desc" => "开启标签自动链接：","type" => "checkbox" ),
		array( "id" => "auto_tags_less","type" => "number","std" => "5","txt" => "同个标签少于不替换："),
		array( "id" => "auto_tags_more","type" => "number","std" => "2","txt" => "同篇文章同个标签最多替换："),
		array( "name" => "lazyload延迟加载图片","type" => "tit"),
		array( "id" => "lazyload","desc" => "开启lazyload延迟加载图片：","type" => "checkbox" ),
		array( "name" => "固定链接格式为[%category%/%文件名或者日期%]时优化","type" => "tit"),
		array( "id" => "permalink_nocat","desc" => "分类链接不显示category，如原domain/category/read显示为domain/read：","type" => "checkbox" ),
	array( "type" => "endtag"),
	//评论系统
	array( "name" => "评论相关","type" => "section","desc" => "主题评论系统设置，完美提高用户体验，对症下药。"),
		array( "name" => "评论楼层设定","type" => "tit"),
		array( "id" => "comment_floor","desc" => "开启评论楼层显示：","type" => "checkbox" ),
		array( "name" => "自定义前三楼显示文字，须设置【评论分页】和【每页顶部显示旧的评论】支持","type" => "tit"),
		array( "id" => "shafa_floor","type" => "text","std" => "如：沙发","desc" => "第一楼：",'class'=>'d_inp_150'),
		array( "id" => "bandeng_floor","type" => "text","std" => "如：板凳","desc" => "第二楼：",'class'=>'d_inp_150'),
		array( "id" => "diban_floor","type" => "text","std" => "如：地板","desc" => "第三楼：",'class'=>'d_inp_150'),

		array( "name" => "评论其他功能设定","type" => "tit"),
		array( "id" => "antispam_mail","desc" => "小强防垃圾和评论回复邮件通知：","type" => "checkbox" ),
		array( "id" => "guest_useragent","desc" => "评论者浏览器操作系统显示：","type" => "checkbox" ),
		array( "type" => "clear"),
		array( "id" => "guest_level","desc" => "评论者评论等级和友链识别显示：","type" => "checkbox" ),
		array( "id" => "comment_smily","desc" => "评论表情功能：","type" => "checkbox" ),
		array( "type" => "clear"),
		array( "id" => "comment_no_english","desc" => "拒绝纯英文评论：","type" => "checkbox" ),
		array( "id" => "comment_count_check","desc" => "评论字数检测：","type" => "checkbox" ),
		array( "id" => "comment_count_less","type" => "number","std" => "5","txt" => "评论字数不得少于："),
		array( "id" => "comment_count_more","type" => "number","std" => "10000","txt" => "评论字数不得超过："),
		array( "type" => "clear"),
		array( "id" => "insert_image","desc" => "评论可插入外部来源图片：","type" => "checkbox" ),
		array( "id" => "check_username_email","desc" => "已注册用户名邮箱检测，注册用户须登陆评论：","type" => "checkbox" ),
		array( "type" => "clear"),
		array( "id" => "check_black_list","desc" => "黑名单用户评论直接拒绝：","type" => "checkbox" ),
		array( "id" => "black_notify","type" => "text","std" => "如：你已被列入垃圾评论黑名单，如果是误伤请联系博主！","desc" => "拒绝返回内容：",'class'=>'d_inp_short'),
		array( "type" => "clear"),
		array( "id" => "comment_link_blank","desc" => "评论者链接新窗口打开：","type" => "checkbox" ),
		array( "id" => "comment_link_nofollow","desc" => "评论内容中链接添加nofollow：","type" => "checkbox" ),
		array( "type" => "clear"),
		array( "id" => "comment_avatar_duoshuo","desc" => "使用多说网站中转评论者头像,可加速头像显示：","type" => "checkbox" ),
		array( "type" => "clear"),
		array( "id" => "comment_avatar_diy","desc" => "自定义默认头像：","type" => "checkbox" ),
		array( "id" => "avatar_diy_name","type" => "text","std" => "如：default.png 请传至miui/images文件夹下","desc" => "自定义头像文件名：",'class'=>'d_inp_short'),
		array( "type" => "desc","desc" => "开启自定义默认头像并填入默认头像文件名后，需到【设置】-【讨论】-【默认头像】选择自定义头像才能生效。"),
	array( "type" => "endtag"),
	//后台杂项
	array( "name" => "后台杂项","type" => "section","desc" => "用此功能，可以减少绝大多数在优化或增强后台的插件。"),
		array( "name" => "主题CSS样式自定义代码，这里添加的代码升级不会被覆盖","type" => "tit"),
		array( "id" => "header_csscode","class" => "d_area","type" => "textarea","std" => "","rows" => "10"),
		array( "name" => "主题Javascript自定义代码，这里添加的代码升级不会被覆盖","type" => "tit"),
		array( "id" => "footer_jscode","class" => "d_area","type" => "textarea","std" => "","rows" => "10"),
	array( "type" => "endtag"),	
	//广告系统
	array( "name" => "博客广告","type" => "section","desc" => "非js广告可直接预览。"),
		array( "name" => "非首页顶部导航下四格广告（225*130）","type" => "tit"),
		array( "id" => "4gridad","desc" => "开启非首页四格广告","type" => "checkbox" ),
		array( "id" => "4category","desc" => "指定分类前4篇填充该四格广告","type" => "checkbox" ),
		array( "id" => "4categoryid","type" => "number","std" => "745","txt" => "指定分类的ID："),
		array( "type" => "clear"),
		array( "id" => "4gridad_01","class" => "f_area","type" => "textarea","std" => "","rows" => "6"),
		array( "id" => "4gridad_02","class" => "f_area","type" => "textarea","std" => "","rows" => "6"),
		array( "id" => "4gridad_03","class" => "f_area","type" => "textarea","std" => "","rows" => "6"),
		array( "id" => "4gridad_04","class" => "f_area","type" => "textarea","std" => "","rows" => "6"),
		array( "name" => "侧边顶部广告（300*250）","type" => "tit"),
		array( "id" => "side_ad_300250","class" => "d_area","type" => "textarea","std" => "","rows" => "6"),
		array( "name" => "侧边底部广告（260*185）","type" => "tit"),
		array( "id" => "side_ad_260185","class" => "d_area","type" => "textarea","std" => "","rows" => "6"),
		array( "name" => "底部广告960","type" => "tit"),
		array( "id" => "bottom_ad_960","class" => "d_area","type" => "textarea","std" => "","rows" => "6"),
		array( "name" => "评论顶部广告（645*）","type" => "tit"),
		array( "id" => "commenttopad","class" => "d_area","type" => "textarea","std" => "","rows" => "6"),
		array( "name" => "文章内容广告","type" => "tit"),
		array( "id" => "single_ad","class" => "d_area","type" => "textarea","std" => "","rows" => "6"),
	array( "type" => "endtag"),

);

function mytheme_add_admin() {
	global $themename, $options;
	if ( $_GET['page'] == basename(__FILE__) ) {
		if ( 'save' == $_REQUEST['action'] ) {
			foreach ($options as $value) {
				update_option( $value['id'], $_REQUEST[ $value['id'] ] ); 
			}
			
			foreach ($options as $value) {
				if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); }
				else { delete_option( $value['id'] ); } 
			}
			
			header("Location: admin.php?page=theme-options.php&saved=true");
			die;
			foreach ($options as $value) {delete_option( $value['id'] ); }
		}
		else if( 'reset' == $_REQUEST['action'] ) {
			header("Location: admin.php?page=theme-options.php&reset=true");
			die;
		}
	}
	//add_menu_page($themename." Options", $themename , 'edit_themes', basename(__FILE__), 'mytheme_admin' , $icon);
	add_theme_page($themename,$themename.'设置','edit_themes',basename(__FILE__),'mytheme_admin'); 
}

function mytheme_admin() {
	global $themename, $options;
	$i=0;
	if ( $_REQUEST['saved'] ) echo '<div class="d_message">'.$themename.'修改已保存</div>';
	if ( $_REQUEST['reset'] ) echo '<div class="d_message">'.$themename.'已恢复设置</div>';
?>
<?php
//获取站点所有分类的di
function show_category() {
	global $wpdb;
	$request = "SELECT $wpdb->terms.term_id, name FROM $wpdb->terms ";
	$request .= " LEFT JOIN $wpdb->term_taxonomy ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id ";
	$request .= " WHERE $wpdb->term_taxonomy.taxonomy = 'category' ";
	$request .= " ORDER BY term_id asc";
	$categorys = $wpdb->get_results($request);
	foreach ($categorys as $category) {
		$output = '<span>'.$category->name."(".$category->term_id.')</span>';
		echo $output;
	}
}
?>
<div class="wrap d_wrap">
	<link rel="stylesheet" href="<?php bloginfo('template_url') ?>/inc/option/theme-option.css"/>
	<h2><?php echo $themename; ?>设置
		<span class="d_themedesc">Theme By：<a href="http://www.happyet.org/" target="_blank">不亦乐乎</a> &nbsp;&nbsp; 
	</h2>
	
	<form method="post" class="d_formwrap">
		<div class="d_tab">
			<ul>
				<li class="d_tab_on">基本设置</li>
                <li>首页五格</li>
				<li>首页其他</li>
				<li>功能开关</li>
                <li>评论相关</li>
				<li>主题杂项</li>
                <li>博客广告</li>
			</ul>
		</div>
		<?php foreach ($options as $value) { switch ( $value['type'] ) { case "": ?>
			<?php break; case "tit": ?>
			</li><li class="d_li">
			<h4><?php echo $value['name']; ?>：</h4>
			<div class="d_tip"><?php echo $value['tip']; ?></div>
			
			<?php break; case "clear": ?>
			</li><li class="d_li">

			<?php break; case 'text': ?>
			<?php if ( $value['desc'] != "") { ?><span class="d_the_desc" id="<?php echo $value['id']; ?>_desc"><?php echo $value['desc']; ?></span><?php } ?>
			<input class="d_inp <?php echo $value['class']; ?>" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id'])  ); }?>" placeholder="<?php echo $value['std'];  ?>" />

			<?php break; case 'number': ?>
			<label class="d_number"><?php echo $value['txt']; ?><input class="d_num <?php echo $value['class']; ?>" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id'])  ); } ?>" placeholder="<?php echo $value['std']; ?>" /></label>
			
			<?php break; case 'textarea': ?>
			<textarea class="<?php echo $value['class']; ?>" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" cols="<?php echo $value['cols']; ?>" rows="<?php echo $value['rows']; ?>"   placeholder="<?php echo $value['std']; ?>"><?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id']) ); } ?></textarea>
			
			<?php break; case 'desc': ?>
			<p><?php echo $value['desc']; ?></p>

			<?php break; case 'select': ?>
			<?php if ( $value['desc'] != "") { ?><span class="d_the_desc" id="<?php echo $value['id']; ?>_desc"><?php echo $value['desc']; ?></span><?php } ?>
			<select class="d_sel" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
				<?php foreach ($value['options'] as $option) { ?>
				<option <?php if (get_settings( $value['id'] ) == $option) { echo 'selected="selected" class="d_sel_opt"'; } ?>>
				<?php
					if ((empty($option) || $option == '' ) && isset($value['default_option_value'])) {
						echo $value['default_option_value'];
					} else {
						echo $option; 
					}
				?>
				</option>
				<?php } ?>
			</select>
			
			<?php break; case "checkbox": ?>
			<?php if ( $value['desc'] != "") { ?><span class="d_the_desc" id="<?php echo $value['id']; ?>_desc"><?php echo $value['desc']; ?></span><?php } ?>
			<?php if(get_settings($value['id']) != ""){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
			<label class="d_check"><input type="checkbox" id="<?php echo $value['id']; ?>" name="<?php echo $value['id']; ?>" <?php echo $checked; ?> />开启</label>
			
			<?php break; case "section": $i++; ?>
			<div class="d_mainbox" id="d_mainbox_<?php echo $i; ?>">
				<ul class="d_inner">
					<li class="d_li">
				
			<?php break; case "endtag": ?>
			</li></ul>
			<div class="d_desc"><input class="button-primary" name="save<?php echo $i; ?>" type="submit" value="保存设置" /></div>
			</div>
			
		<?php break; }} ?>
				
		<input type="hidden" name="action" value="save" />

	</form>
	<div id="showcategoryId"><h5>分类对应ID</h5><div><?php show_category(); ?></div></div>
</div>
<?php 
	}
add_action('admin_menu', 'mytheme_add_admin');
add_filter('manage_posts_columns', 'wpjam_id_manage_posts_columns');
add_filter('manage_pages_columns', 'wpjam_id_manage_posts_columns');
function wpjam_id_manage_posts_columns($columns){
    $columns['post_id'] = 'ID';
    return $columns;
}

add_action('manage_posts_custom_column','wpjam_id_manage_posts_custom_column',10,2);
add_action('manage_pages_custom_column','wpjam_id_manage_posts_custom_column',10,2);
function wpjam_id_manage_posts_custom_column($column_name,$id){
    if ($column_name == 'post_id') {
        echo $id;
    }
}
function dw_admin_font(){
	echo'<style type="text/css">.column-post_id{width:10% !important;}</style>';
}
add_action('admin_head', 'dw_admin_font');
function theme_js(){
	echo '<script src="' . get_bloginfo('template_url') . '/inc/option/theme-option.js"></script>';
}
add_action("admin_print_footer_scripts", "theme_js", 100);
?>