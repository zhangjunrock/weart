<?php
///////////////////////////短代码///////////////////////////
//插入代码注释
function spancolor( $atts, $content = null, $code="" ) {
   return '<span style="color:#75715e">' . do_shortcode($content) . '</span>';
}
add_shortcode('sp', 'spancolor');
//警示
function warningbox($atts, $content=null, $code="") {
	$return = '<div class="warning scbox">';
	$return .= $content;
	$return .= '</div>';
	return $return;
}
add_shortcode('warning' , 'warningbox' );

//禁止
function nowaybox($atts, $content=null, $code="") {
	$return = '<div class="noway scbox">';
	$return .= $content;
	$return .= '</div>';
	return $return;
}
add_shortcode('noway' , 'nowaybox' );

//购买
function buybox($atts, $content=null, $code="") {
	$return = '<div class="buy scbox">';
	$return .= $content;
	$return .= '</div>';
	return $return;
}
add_shortcode('buy' , 'buybox' );

//项目版
function taskbox($atts, $content=null, $code="") {
	$return = '<div class="task scbox">';
	$return .= $content;
	$return .= '</div>';
	return $return;
}
add_shortcode('task' , 'taskbox' );

//登陆可见内容
function hide_content($atts, $content = null) {
	if ( !is_user_logged_in() ){
		return '<div class="hide scbox">此内容须登陆才能查看！</div>';
	}else{
		return '<div class="hide scbox">' . $content . '</div>';
	}
}  
add_shortcode('hide', 'hide_content');

//下载链接
function downlink($atts,$content=null){
	extract(shortcode_atts(array('href'=>'http://','downtxt'=>''),$atts));
	return '<div class="but_down clearfix">'.$downtxt.'<a href="'.$href.'" target="_blank"><span class="btn">'.$content.'</span></a></div>';
}
add_shortcode('Downlink','downlink');

//收缩栏
function post_toggle($atts, $content=null){
	extract(shortcode_atts(array("title"=>''),$atts));	
	return '<div class="toggle_title">'.$title.'</div><div class="toggle_content">'.$content.'</div>';
} 
add_shortcode('toggle','post_toggle');

//tab内容切换
$tabs_divs = '';
function tabs_group( $atts, $content = null ) {
    global $tabs_divs;
    $tabs_divs = '';
    extract(shortcode_atts(array('id' => ''), $atts));
	$output = '<div class="post-tabs">';
    $output .= '<ul class="post-tabul clearfix">'.do_shortcode($content).'</ul>';
    $output .= '<div class="post-card">'.$tabs_divs.'</div>';
	$output .= '</div>';
    return $output;  
}  
add_shortcode('tabs', 'tabs_group');

function tab($atts, $content = null) {  
    global $tabs_divs;
    extract(shortcode_atts(array('title' => '','active'=>'n'), $atts));  
    $activeClass = $active == 'y' ? ' active' :'';
    $output = '<li class="tab-title' .$activeClass.'">'.$title.'</li>';
    $tabs_divs .= '<div class="tab-panel' .$activeClass.'">'.$content.'</div>';
    return $output;
}
add_shortcode('tab', 'tab');

//豆瓣音乐播放器
function doubanplayer($atts, $content=null){
	extract(shortcode_atts(array("auto"=>'0'),$atts));
	return '<embed src="'.get_bloginfo("template_url").'/images/players/doubanplayer.swf?url='.$content.'&amp;autoplay='.$auto.'" type="application/x-shockwave-flash" wmode="transparent" allowscriptaccess="always" width="400" height="30">';
	}
add_shortcode('music','doubanplayer');

function flvlink($atts,$content=null){
	extract(shortcode_atts(array("auto"=>'0'),$atts));
	return'<embed src="'.get_bloginfo("template_url").'/images/players/flvideo.swf?auto='.$auto.'&flv='.$content.'" menu="false" quality="high" wmode="transparent" bgcolor="#ffffff" width="100%" height="340" name="flvideo" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer_cn" />';
}
add_shortcode('flv','flvlink');

function mp3link($atts, $content=null){
	extract(shortcode_atts(array("auto"=>'0',"replay"=>'0',),$atts));	
	return '<embed src="'.get_bloginfo("template_url").'/images/players/dewplayer.swf?mp3='.$content.'&amp;autostart='.$auto.'&amp;autoreplay='.$replay.'" wmode="transparent" height="20" width="240" type="application/x-shockwave-flash" />';
}
add_shortcode('mp3','mp3link');

//在线视频
function wp_embed_handler_youku_1( $matches, $attr, $url, $rawattr ) { return apply_filters( 'embed_youku', '<embed src="http://player.youku.com/player.php/sid/' . esc_attr($matches[1]) . '/v.swf" quality="high" width="100%" height="500" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" allowfullscreen="true" wmode="opaque"></embed>', $matches, $attr, $url, $rawattr ); }
wp_embed_register_handler( 'youku', '#http://v.youku.com/v_show/id_(.*?).html#i', 'wp_embed_handler_youku_1' );
				
function wp_embed_handler_tudou_1( $matches, $attr, $url, $rawattr ) { return apply_filters( 'embed_tudou', '<embed src="http://www.tudou.com/v/' . esc_attr($matches[1]) . '/v.swf"  quality="high" width="100%" height="500" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" allowfullscreen="true" wmode="opaque"></embed>', $matches, $attr, $url, $rawattr );}
wp_embed_register_handler( 'tudou', '#http://www.tudou.com/programs/view/(.*?)/#i', 'wp_embed_handler_tudou_1' );
				
function wp_embed_handler_ku6_1( $matches, $attr, $url, $rawattr ) { return apply_filters( 'embed_ku6', '<embed src="http://player.ku6.com/refer/' . esc_attr($matches[1]) . '/v.swf" quality="high" width="100%" height="500" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" allowfullscreen="true" wmode="opaque"></embed>', $matches, $attr, $url, $rawattr ); }
wp_embed_register_handler( 'ku6', '#http://v.ku6.com/show/(.*?).html#i', 'wp_embed_handler_ku6_1' );
				
function wp_embed_handler_youtube_1( $matches, $attr, $url, $rawattr ) { return apply_filters( 'embed_youtube', '<embed src="http://www.youtube.com/v/' . esc_attr($matches[1]) . '?&amp;hl=zh_CN&amp;rel=0" width="100%" height="500" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" allowfullscreen="true" wmode="opaque"></embed>', $matches, $attr, $url, $rawattr ); }
wp_embed_register_handler( 'youtube', '#http://youtu.be/(.*?)/#i', 'wp_embed_handler_youtube_1' );
			
function wp_embed_handler_56_1($matches, $attr, $url, $rawattr ) { return apply_filters( 'embed_56', '<embed src="http://player.56.com/v_' . esc_attr($matches[1]) . '.swf" quality="high" width="100%" height="500" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" allowfullscreen="true" wmode="opaque"></embed>', $matches, $attr, $url, $rawattr ); }
wp_embed_register_handler( '56', '#http://player.56.com/v_(.*?).swf#i', 'wp_embed_handler_56_1' );
			
function wp_embed_handler_sohu_1( $matches, $attr, $url, $rawattr ) { return apply_filters( 'embed_sohu', '<embed src="http://share.vrs.sohu.com/' . esc_attr($matches[1]) . '/v.swf" quality="high" width="100%" height="500" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" allowfullscreen="true" wmode="opaque"></embed>', $matches, $attr, $url, $rawattr ); }
wp_embed_register_handler( 'sohu', '#http://share.vrs.sohu.com/(.*?)/v.swf#i', 'wp_embed_handler_sohu_1' );

function wp_embed_handler_6cn_1( $matches, $attr, $url, $rawattr ) { return apply_filters( 'embed_6cn', '<embed src="http://6.cn/p/' . esc_attr($matches[1]) . '.swf" quality="high" width="100%" height="500" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" allowfullscreen="true" wmode="opaque"></embed>', $matches, $attr, $url, $rawattr ); }
wp_embed_register_handler( '6cn', '#http://6.cn/p/(.*?).swf#i', 'wp_embed_handler_6cn_1' );
				
function wp_embed_handler_letv_1( $matches, $attr, $url, $rawattr ) { return apply_filters( 'embed_letv', '<embed src="http://www.letv.com/player/' . esc_attr($matches[1]) . '.swf" quality="high" width="100%" height="500" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" allowfullscreen="true" wmode="opaque"></embed>', $matches, $attr, $url, $rawattr ); }
wp_embed_register_handler( 'letv', '#http://www.letv.com/player/(.*?).swf#i', 'wp_embed_handler_letv_1' );
				
function wp_embed_handler_sina_1( $matches, $attr, $url, $rawattr ) { return apply_filters( 'embed_sina', '<embed src="http://you.video.sina.com.cn/api/sinawebApi/outplayrefer.php/vid=' . esc_attr($matches[1]) . '/s.swf" quality="high" width="100%" height="500" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" allowfullscreen="true" wmode="opaque"></embed>', $matches, $attr, $url, $rawattr ); }
wp_embed_register_handler( 'sina', '#http://you.video.sina.com.cn/api/sinawebApi/outplayrefer.php/vid=(.*?)/s.swf#i', 'wp_embed_handler_sina_1' );

/////////////////////////////////////////////////////////////

function Shortpage(){?>
<style type="text/css">
.wrap{padding:10px; font-size:12px; line-height:24px;color:#383838;}
.devetable td{vertical-align:top;text-align: left; }
.top td{vertical-align: middle;text-align: left; }
pre{white-space: pre;overflow: auto;padding:0px;line-height:19px;font-size:12px;color:#898989;}
strong{ color:#666}
.none{display:none;}
fieldset{ border:1px solid #ddd;margin:5px 0 10px;padding:10px 10px 20px 10px;-moz-border-radius:5px;-khtml-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;}
fieldset:hover{border-color:#bbb;}
fieldset legend{padding:0 5px;color:#777;font-size:14px;font-weight:700;cursor:pointer}
fieldset .line{border-bottom:1px solid #e5e5e5;padding-bottom:15px;}
</style>
<div class="wrap">
<div id="icon-themes" class="icon32"><br></div>
<h2>主题短代码</h2>
    <div style="padding-left:20px;">
	<p>写文章时如果需要可以加入下列短代码（在“可视化”与“HTML”两种模式均可直接加入）</p>
    <p></p>
<fieldset>
<legend>各种短代码面板</legend>
	<div>
      <table width="100%" border="0" class="devetable">
      	<tr><td width="120">蓝色项目面板：</td><td width="80%"><code>[task]文字内容[/task]</code></td></tr>
  		<tr><td width="120">红色禁止面板：</td><td width="80%"><code>[noway]文字内容[/noway]</code></td></tr>
        <tr><td width="120">黄色警告面板：</td><td width="80%"><code>[warning]文字内容[/warning]</code></td></tr>
        <tr><td width="120">绿色购买面板：</td><td width="80%"><code>[buy]文字内容[/buy]</code></td></tr>
		<tr><td width="120">灰色隐藏面板：</td><td width="80%"><code>[hide]文字内容[/hide]</code></td></tr>
		<tr><td width="120">TAB内容切换面板：</td><td width="80%"><code>[tabs]
		[tab title='tab标题' active='y']tab内容[/tab]
		[tab title='tab标题2' active='']tab内容2[/tab]
		[/tabs]</code></td></tr>
       </table>
      </div>
</fieldset>
<fieldset>
<legend>下载样式</legend>
	<div>
      <table width="800" border="0" class="devetable">
      	<tr><td width="120"><strong>下载样式</strong></td><td width="584"><code>[Downlink href="http://www.xxx.com/xxx.zip"]download xxx.zip[/Downlink]</code></td></tr>
  </table>
  </div>
</fieldset>
<fieldset>
<legend>音乐播放器</legend>
	<div>
      <table width="800" border="0" class="devetable">
	  	<tr><td width="120"><strong>豆瓣音乐播放器</strong></td><td>&nbsp;</td></tr>
      	<tr><td width="120">默认不自动播放：</td><td width="463"><code>[music]http://www.xxx.com/xxx.mp3[/music]</code></td></tr> 
        <tr><td width="120">自动播放:</td><td><code>[music auto=1]http://www.xxx.com/xxx.mp3[/music]</code></td></tr>

		<tr><td width="120"><strong>Mp3专用播放器</strong></td><td>&nbsp;</td></tr>
        <tr><td width="210">默认不循环不自动播放：</td><td><code>[mp3]http://www.xxx.com/xxx.mp3[/mp3]</code></td></tr>
         <tr><td width="120">自动播放：　</td><td><code>[mp3 auto="1"]http://www.xxx.com/xxx.mp3[/mp3]</code></td></tr>  
         <tr><td width="120">循环播放：	</td><td><code>[mp3 replay="1"]http://www.xxx.com/xxx.mp3[/mp3]</code></td></tr>
         <tr><td width="120">自动及循环播放：</td><td><code>[mp3 auto="1" replay="1"]http://www.xxx.com/xxx.mp3[/mp3]</code></td></tr>
       </table>
      </div>
</fieldset> 
<fieldset>
<legend>Flv专用播放器</legend>
	<div>
		<table width="600" border="0" class="devetable">
		<tr><td width="120"><strong>Flv专用播放器</strong></td><td>&nbsp;</td></tr>
         <tr><td width="120">默认不自动播放：</td><td><code>[flv]http://www.xxx.com/xxx.flv[/flv]</code></td></tr>
         <tr><td width="120">自动播放：</td><td><code>[flv auto="1"]http://www.xxx.com/xxx.flv[/flv]</code></td></tr>
		</table> 
       <p><span style="color: #808000;">注意：如果要使用这个播放器，一定要添加flv格式的视频文件</span></p>
  </div>
</fieldset>
<fieldset>
<legend>视频网站Flash嵌入</legend>
	<div>
    <br>
      <table width="600" border="0" class="devetable">
      	<tr><td width="120"><span style="color: #993300;"> 通用代码：</span></td><td width="504"><code>[embed]视频播放页面网址或Flash地址[/embed]</code></td></tr>
      </table>
       <br>
        <fieldset>
        <legend>使用视频播放页面网址的网站</legend>
            <p><span style="color: #808000;">以下网站中的视频，直接复制浏览器中的地址，粘贴到短代码中即可 </span></p>
              <table width="810" border="0" class="devetable">
               <tr><td width="80">优酷网：</td><td width="714"><code>[embed]http://v.youku.com/v_show/id_XMjgyNDk1NTYw.html[/embed]</code></td></tr>
               <tr><td width="80">土豆网：</td><td width="714"><code>[embed]http://www.tudou.com/programs/view/tFny-0UbTEM/[/embed]</code>&nbsp;&nbsp;(注意:网址的最后有个斜杠不能漏掉)</td></tr>
               <tr><td width="80">酷6网：</td><td width="714"><code>[embed]http://v.ku6.com/show/7eenXUV4xNfiUsSu.html[/embed]</code></td></tr>
               <tr><td width="80">Youtube：</td><td width="714"><code>[embed]http://youtu.be/vtjJe4elifI/[/embed]</code>&nbsp;&nbsp;(此为分享中给出的分享网址,记得在网址的最后加上斜杠)</td></tr>
              </table>
        </fieldset>  
           <br>   
       <fieldset>
        <legend>使用Flash地址的网站</legend>
            <p><span style="color: #808000;">以下网站中的视频，需要复制视频给出的分享中的flash地址，粘贴到短代码中即可 </span></p>
              <table width="810" border="0" class="devetable">
               <tr><td width="80">56.com：</td><td width="714"><code>[embed]http://player.56.com/v_NTM4ODY0NjY.swf[/embed]</code></td></tr>
               <tr><td width="80">搜狐视频：</td><td width="714"><code>[embed]http://share.vrs.sohu.com/374302/v.swf[/embed]</code> </td></tr>
               <tr><td width="80">6房间：</td><td width="714"><code>[embed]http://6.cn/p/1/n4WbeuI_Gn7GBxCVccLQ.swf[/embed]</code></td></tr>
               <tr><td width="80">乐视网：</td><td width="714"><code>[embed]http://www.letv.com/player/x725792.swf [/embed]</code></td></tr>
               <tr><td width="80">新浪视频：</td><td width="714"><code>[embed]http://you.video.sina.com.cn/api/sinawebApi/outplayrefer.php/vid=XXX/s.swf[/embed]</code></td></tr>
           </table>    
        </fieldset></div>
</fieldset>   
    </div>
</div>
<?php }
function shortcode_page(){
  add_theme_page("主题短代码","主题短代码",'edit_themes','shortcode_page','Shortpage'); 
}
add_action('admin_menu','shortcode_page');
function add_editor_buttons($buttons) {
	
	$buttons[] = 'fontselect';
	$buttons[] = 'fontsizeselect';
	$buttons[] = 'cleanup';
	$buttons[] = 'styleselect';
	$buttons[] = 'hr';
	$buttons[] = 'del';
	$buttons[] = 'sub';
	$buttons[] = 'sup';
	$buttons[] = 'copy';
	$buttons[] = 'paste';
	$buttons[] = 'cut';
	$buttons[] = 'undo';
	$buttons[] = 'image';
	$buttons[] = 'anchor';
	$buttons[] = 'backcolor';
	$buttons[] = 'wp_page';
	$buttons[] = 'charmap';
	return $buttons;
}
add_filter("mce_buttons_3", "add_editor_buttons");
?>