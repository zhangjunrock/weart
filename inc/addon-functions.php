<?php
//title优化
function simple_write_wp_title( $title, $sep ) {
	global $paged, $page;
	if ( is_feed() ) return $title;
	$title .= get_bloginfo( 'name' );
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $paged >= 2 || $page >= 2 ) $title = "$title $sep " . sprintf( __( 'Page %s', 'simple_write' ), max( $paged, $page ) );
	if ( $site_description && ( is_home() || is_front_page() ) ) $title = "$title $sep $site_description";
	return $title;
}
add_filter( 'wp_title', 'simple_write_wp_title', 10, 2 );
//自动关键字生成
function mytheme_keywords() {
	global $s, $post;
	$keywords = '';
	if ( is_single() ) {
		if ( get_the_tags( $post->ID ) ) {
			foreach ( get_the_tags( $post->ID ) as $tag ) $keywords .= $tag->name . ', ';
		}
		foreach ( get_the_category( $post->ID ) as $category ) $keywords .= $category->cat_name . ', ';
		$keywords = substr_replace( $keywords, "" , -2 );
	} elseif ( is_home () ) { 
		$keywords = dopt('KeyWords');
	} elseif ( is_tag() ) { 
		$keywords = single_tag_title('', false);
	} elseif ( is_category() ) { 
		$keywords = single_cat_title('', false);
	} elseif ( is_search() ) { 
		$keywords = esc_html( $s, 1 );
	} else { 
		$keywords = trim( wp_title('', false) );
	}
	if ( $keywords ) {
		echo "<meta name=\"keywords\" content=\"$keywords\" />\n";
	}
}
//自动描述自动产生
function mytheme_description() {
	global $s, $post;
	$description = '';
	$blog_name = get_bloginfo('name');
	if ( is_singular() ) {
		if( !empty( $post->post_excerpt ) ) { 
			$text = $post->post_excerpt; 
		} else { 
			$text = $post->post_content; 
		}
		$description = trim( str_replace( array( "\r\n", "\r", "\n", "　", " "), " ", str_replace( "\"", "'", strip_tags( $text ) ) ) );
		if ( !( $description ) ) $description = $blog_name . " - " . trim( wp_title('', false) );
		} elseif ( is_home () ) {
			$description = dopt('Description');
		} elseif ( is_tag() ) { 
			$description = $blog_name . "有关 '" . single_tag_title('', false) . "' 的文章";
		} elseif ( is_category() ) { 
			$description = $blog_name . single_cat_title('', false) ."栏目下关于" .trim(strip_tags(category_description())) ."的文章";
		} elseif ( is_archive() ) { 
			$description = $blog_name . "在: '" . trim( wp_title('', false) ) . "' 的文章";
		} elseif ( is_search() ) { 
			$description = $blog_name . ": '" . esc_html( $s, 1 ) . "' 的搜索結果";
		} else { 
			$description = $blog_name . "有关 '" . trim( wp_title('', false) ) . "' 的文章";
		}
		$description = mb_substr( $description,0, 400 ) . '..';
		echo "<meta name=\"description\" content=\"$description\" />\n";
}
//views备胎
function happyet_record_views() {
    if (is_singular()) {
        global $post, $user_ID;
        $post_ID = $post->ID;
        if (empty($_COOKIE[USER_COOKIE]) && intval($user_ID) == 0) {
            if ($post_ID) {
                $post_views = (int)get_post_meta($post_ID, 'views', true);
                if (!update_post_meta($post_ID, 'views', ($post_views + 1))) {
                    add_post_meta($post_ID, 'views', 1, true);
                }
            }
        }
    }
}
add_action('wp_head', 'happyet_record_views');
function post_views($before = '', $after = '', $echo = 1) {
    global $post;
    $post_ID = $post->ID;
    $views = (int)get_post_meta($post_ID, 'views', true);
    if ($echo) {
        echo $before, number_format($views) , $after;
    } else {
        return $views;
    }
}
//面包屑导航
function wp_breadcrumb(){
	$line = '<em>&gt;</em>';
	global $page, $paged;
	$page = '';
	if ( $paged >= 2 || $page >= 2 ){$page = ' 第'.$paged . $page . '页';}
	$breadcrumb = '<a href="'.get_bloginfo('home').'">'.__('Home').'</a>';
	if(is_home() && $paged >= 2 ){$breadcrumb.= '' . $line . $page;}
	elseif(is_category()){$breadcrumb.= $line . '<b>' . single_cat_title("", false) . '</b>' . $page;}
	elseif(is_single()){
		$categories = get_the_category();
		$separator = ',';
		$output = '';
		foreach($categories as $category) {
			$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">'.$category->cat_name.'</a><em>' . $separator . '</em>';
		}
		$breadcrumb.= $line . trim($output, $separator) . get_the_title();}
	elseif(is_page()){$breadcrumb.= $line . get_the_title();}
	elseif(is_search()){global $s; $breadcrumb.= $line . '<b>'.$s.'</b> 的搜索结果' . $page;}
	elseif(is_tag()){$breadcrumb.= $line . '标签：<b>'.single_tag_title("", false).'</b>' . $page;}
	elseif(is_author()){
		global $author;
		$user = get_userdata($author);
		$breadcrumb.= $line . '作者：<b>' . $user->display_name . '</b>' . $page;
	}
	elseif(is_archive()){
		if ( is_day() ) : $breadcrumb.= $line . '日存档：<b>' . get_the_date() . '</b>' . $page;
		elseif ( is_month() ) : $breadcrumb.= $line . '月存档：<b>' . get_the_date( 'F Y' ) . '</b>' . $page;
		elseif ( is_year() ) : $breadcrumb.= $line . '年存档：<b>' . get_the_date('Y') . ' 年</b>' . $page;
		else : _e( 'Archives' );
		endif;
	}
	elseif(is_404()){$breadcrumb.= $line . '404 - Page Not Found';}
	return $breadcrumb;
}
//人性化时间显示
function time_diff( $time_type ){
    switch( $time_type ){
		case 'comment':    //如果是评论的时间
			$time_diff = current_time('timestamp') - get_comment_time('U');
			if( $time_diff < 86400 )
				echo human_time_diff(get_comment_time('U'), current_time('timestamp')).'前';
			elseif( $time_diff <= 604800 )    //7天之内
				echo human_time_diff(get_comment_time('U'), current_time('timestamp')).'前';    //显示格式 OOXX 之前
			else
				the_time('Y年m月d日 g:i');    //显示格式 X年X月X日 OOXX 时
		break;
        case 'post';    //如果是日志的时间
            $time_diff = current_time('timestamp') - get_the_time('U');
			$current_year = date('Y', current_time('timestamp'));
			$post_year = date('Y', get_the_time('U'));
            if( $time_diff <= 43200 ){
				echo human_time_diff(get_the_time('U'), current_time('timestamp')).'前';
            }else{
				if($current_year > $post_year ){
					the_time('Y年m月d日');
				}else{
					the_time('F j, G:i');
				}
			}
		break;
    }
}
//菜单引导
function link_to_menu_editor( $args ) {
    extract( $args );
	if ( ! current_user_can( 'manage_options' ) ) {
        $link  = '<li><a href="'.get_bloginfo('url').'">HOME</a></li><li><a href="'. get_settings('siteurl') . '/wp-login.php">博客导航未设置，admin请点此登录后设置</a></li>';
    }else{
		$link = '<li><a href="'.get_bloginfo('url').'">HOME</a></li><li><a href="' . admin_url( 'nav-menus.php' ) . '">点击设置导航菜单</a></li>';
		if ( FALSE !== stripos( $items_wrap, '<ul' ) or FALSE !== stripos( $items_wrap, '<ol' ) ) {
			$link = '<li><a href="'.get_bloginfo('url').'">HOME</a></li><li>'.$link.'</li>';
		}
	}
    $output = sprintf( $items_wrap, $menu_id, $menu_class, $link );
	if ( ! empty ( $container ) ) {
		$output  = "$output";
	}
	if ( $echo ) {
		echo $output;
	}
    return $output;
}
//最新评论
function Happyet_news_comments($limit = 7, $length = 30 ) {
	global $wpdb;
	$admin_email = get_bloginfo ('admin_email');
	$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type,comment_author_url,comment_author_email,comment_content 	FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND comment_author_email != '$admin_email' AND post_password = '' ORDER BY comment_date_gmt DESC LIMIT $limit";
	$comments = $wpdb->get_results($sql);
	$gravatar_status = 'on';
	foreach ($comments as $rc_comment) {
		$output .= '<li><a href="' . htmlspecialchars(get_comment_link( $rc_comment->comment_ID )) .'" title="《' . get_post( $rc_comment->comment_post_ID )->post_title  . '》">'. get_avatar($rc_comment->comment_author_email,46) . $rc_comment->comment_author . '<b></b></a><p>' . mb_substr(strip_tags($rc_comment->comment_content),0,$length) . '</p></li>';
	}
	$output .= $post_HTML;
	$output = convert_smilies($output);
	echo $output;
}
//明星评论员
function comments_star($limit=6) {
	global $wpdb;
    $my_email = get_bloginfo('admin_email');
	$sql = "SELECT COUNT(comment_author_email) AS cnt, comment_author, comment_author_url,comment_author_email,comment_type FROM (SELECT * FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->posts.ID=$wpdb->comments.comment_post_ID) WHERE MONTH(comment_date)=MONTH(now()) and YEAR(comment_date)=YEAR(now()) AND comment_author_email != '$my_email' AND comment_type = '' AND post_password='' AND comment_approved='1') AS tempcmt GROUP BY comment_author_email ORDER BY cnt DESC LIMIT $limit";
	$counts = $wpdb->get_results($sql);
	if (!empty($counts)) {
		foreach ($counts as $count) {
			//$f = md5( strtolower($count->comment_author_email) );
			//$g = sprintf( "http://gravatar.duoshuo.com", (hexdec($f{0}) % 2) ) .'/avatar/'. $f .'?d=404';
			//$headers = @get_headers( $g );
			//if ( preg_match("|200|", $headers[0]) ) {
				if($count->comment_author_url == ''){$url = 'TA来自火星';}else{$url = '<a href="' . $count->comment_author_url . '" target="_blank">去看看TA</a>';}
				$output.= '<li>' . get_avatar($count->comment_author_email, 64) . '<b>' . $count->comment_author . '</b><span>月评论：' . $count->cnt . '，总评论：' . get_comments(array('author_email' => $count->comment_author_email, 'status' => 'approve', 'count' => true)) . '</span><em>' . $url . '</em></li>';
			//}
		}
	} else {
		$output.= '本月评论热潮还没开始';
	}
	echo $output;
}
//评论插入外链图片
function embed_images($content) { 
	$content = preg_replace('/\[img=?\]*(.*?)(\[\/img)?\]/e','"<img src=\"$1\" alt=\"" . basename("$1") . "\" />"', $content); 
	return $content; 
} 
add_filter('comment_text', 'embed_images');
//meta
function miui_entry_meta() {
	echo '<span class="meta">';
	if(function_exists('the_views')) { echo '<em class="views">' . the_views(false) .'</em>'; }else{ echo '<em class="views">'; post_views(); echo '</em>'; }
	comments_popup_link('0','1','%', 'replies', '评论关闭' );
	if(!is_page()) echo '<script type="text/javascript">document.write(\'<a href="http://v.t.sina.com.cn/share/share.php?url=\' + encodeURIComponent(\'' . get_permalink() . '\') + \'&appkey=2617885470&title=\' + encodeURIComponent(\'' . get_the_title() . ' ——来自@' .get_bloginfo('name') . '\') +\'" title="分享到新浪微博" target="_blank" class="share">分享</a>\');</script>';
	echo '</span>';
	if(!is_page()){
		the_category(', ');
		echo ' | ';
	}
	time_diff( $time_type='post' );
	if(is_singular()){edit_post_link( ' 编辑', '', '' );}
}
//自动版权时间
function auto_copyright() {
    global $wpdb;
    $copyright_dates = $wpdb->get_results("SELECT YEAR(min(post_date_gmt)) AS firstdate,YEAR(max(post_date_gmt)) AS lastdate FROM $wpdb->posts WHERE post_status = 'publish'");
    $output = '';
    if ($copyright_dates) {
        $copyright = "&copy; " . $copyright_dates[0]->firstdate;
        if ($copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate) {
            $copyright.= '-' . $copyright_dates[0]->lastdate;
        }
        $output = $copyright;
    }
    return $output;
}
function copyright() {
    if (function_exists("copyright")) {
		$site_time = dopt('blog_date');
		if(empty($site_time)) { 
			$output = auto_copyright();
		}else{
			if (floor((date('Y') - date("Y",strtotime($site_time))) > 0) ){
				$output = '&copy ' . date("Y",strtotime($site_time)) . ' - ' . date('Y');
			}else{
				$output = '&copy ' . date('Y');
			}
		}
		$output .= ' ' . get_bloginfo('name') . ', All Rights Reserved.';
    }
    return $output;
}
//自定义域
$new_meta_boxes = array(
	"pre_image" => array( "name" => "pre_image","std" => "","title" => "自定义缩略图地址:" ),
	"flash_url" => array( "name" => "flash_url","std" => "","title" => "引用视频flash地址:" ),
);
function new_meta_boxes() {
    global $post, $new_meta_boxes;
    foreach($new_meta_boxes as $meta_box) {
        $meta_box_value = get_post_meta($post->ID, $meta_box['name'], true);
        if($meta_box_value == "") $meta_box_value = $meta_box['std'];
        echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
        // 自定义字段标题
        echo'<p><strong>'.$meta_box['title'].'</strong></p>';
        // 自定义字段输入框
        echo '<p><input type="text" class="code" value="'.$meta_box_value.'" name="'.$meta_box['name'].'" style="width:100%" /></p>';
    }
}
function create_meta_box() {
    global $theme_name;
    if ( function_exists('add_meta_box') ) {
        add_meta_box( 'new-meta-boxes', '自定义模块', 'new_meta_boxes', 'post', 'normal', 'high' );
    }
}
function save_postdata( $post_id ) {
    global $post, $new_meta_boxes;
    foreach($new_meta_boxes as $meta_box) {
        if ( !wp_verify_nonce( $_POST[$meta_box['name'].'_noncename'], plugin_basename(__FILE__) ))  {
            return $post_id;
        }
        if ( 'page' == $_POST['post_type'] ) {
            if ( !current_user_can( 'edit_page', $post_id ))
                return $post_id;
        } 
        else {
            if ( !current_user_can( 'edit_post', $post_id ))
                return $post_id;
        }
        $data = $_POST[$meta_box['name']];

        if(get_post_meta($post_id, $meta_box['name']) == "")
            add_post_meta($post_id, $meta_box['name'], $data, true);
        elseif($data != get_post_meta($post_id, $meta_box['name'], true))
            update_post_meta($post_id, $meta_box['name'], $data);
        elseif($data == "")
            delete_post_meta($post_id, $meta_box['name'], get_post_meta($post_id, $meta_box['name'], true));
    }
}
add_action('admin_menu', 'create_meta_box');
add_action('save_post', 'save_postdata');
function SpHtml2Text($str){
	$str = preg_replace("/<sty(.*)\\/style>|<scr(.*)\\/script>|<!--(.*)-->/isU","",$str);
	$alltext = "";
	$start = 1;
	for($i=0;$i<strlen($str);$i++){
		if($start==0 && $str[$i]==">"){
			$start = 1;
		}elseif($start==1){
			if($str[$i]=="<"){
				$start = 0;
				$alltext .= " ";
			}elseif(ord($str[$i])>31){
				$alltext .= $str[$i];
			}
		}
	}
	$alltext = str_replace("　"," ",$alltext);
	$alltext = preg_replace("/&([^;&]*)(;|&)/","",$alltext);
	$alltext = preg_replace("/[ ]+/s"," ",$alltext);
	return $alltext;
}
function delHtmlContent(){
	global $post, $posts;
	$a = SpHtml2Text($post->post_content);
	return $a; 
}
function videoContent(){
	global $post, $posts;
	$a = SpHtml2Text($post->post_content);
	$a = preg_replace('/\[(youku|tudou|56|flash) (id=\"(.*)\"|url=\"(.*)\"|w=\"([0-9]*)\"|h=\"([0-9]*)\")\]/i','',$a);
	return $a; 
}
//----------获取视频的图片URl-----------//
include("VideoUrlParser.class.php");
function vide_url(){
	global $post;
	$infor = VideoUrlParser::parse(videoContent());
	$imgurl = $infor['img'];
	if($imgurl){
		return $imgurl;
   } 
}
//缩略图
function post_thumbnail($w='', $h=''){
	global $post;
	$title = $post->post_title;
	$dir = get_bloginfo('template_directory');
	$infor = VideoUrlParser::parse(videoContent());
	if( $values = get_post_custom_values("pre_image") ) {	//输出自定义域图片地址
		$values = get_post_custom_values("pre_image");
		$post_thumbnail_src = $values [0];
	}elseif( has_post_thumbnail() ){    //如果有特色缩略图，则输出缩略图地址
		$thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full');
		$post_thumbnail_src = $thumbnail_src [0];
	}elseif($infor['img']){
		$post_thumbnail_src = $infor['img'];
	}else{
		$post_thumbnail_src = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		$post_thumbnail_src = $matches [1] [0];   //获取该图片 src
		if(empty($post_thumbnail_src)){	//如果日志中没有图片，则显示随机图片
			$random = mt_rand(1, 10);
			$post_thumbnail_src = $dir. '/images/rand/' . $random . '.jpg';
		}
	};
	$post_thumbmail = $dir . '/files/timthumb.php?src=' . $post_thumbnail_src . '&amp;w='.$w.'&amp;h='.$h.'&amp;zc=1&amp;q=100';
	echo '<img src="' . $post_thumbmail . '" alt="' . $title . '" width="' . $w . '" height="' . $h . '" />';
}
?>