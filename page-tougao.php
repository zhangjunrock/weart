<?php
/**
 * Template Name: 投稿页面模板
 * 作者：露兜
 * 博客：http://www.ludou.org/
 * 
 * 更新记录
 *  2010年09月09日 ：
 *  首个版本发布
 *  
 *  2011年03月17日 ：
 *  修正时间戳函数，使用wp函数current_time('timestamp')替代time()
 *  
 *  2011年04月12日 ：
 *  修改了wp_die函数调用，使用合适的页面title
 *  
 *  2013年01月30日 ：
 *  错误提示，增加点此返回链接
 *  
 *  2013年07月24日 ：
 *  去除了post type的限制；已登录用户投稿不用填写昵称、email和博客地址
 */
    
if (!isset($_SESSION)) {
	session_start();
	session_regenerate_id(TRUE);
} 
if( isset($_POST['tougao_form']) && $_POST['tougao_form'] == 'send') {
	if(empty($_POST['captcha_code']) || empty($_SESSION['ludou_lcr_secretword']) || (trim(strtolower($_POST['captcha_code'])) != $_SESSION['ludou_lcr_secretword'])) {
		wp_die('验证码不正确！<a href="'.$current_url.'">点此返回</a>');
	}
    global $wpdb;
    $current_url = esc_url( get_permalink( get_page_by_title( 'tougao' ) ) );;   // 注意修改此处的链接地址
        
    // 表单变量初始化
    $name = isset( $_POST['tougao_authorname'] ) ? trim(htmlspecialchars($_POST['tougao_authorname'], ENT_QUOTES)) : '';
    $email =  isset( $_POST['tougao_authoremail'] ) ? trim(htmlspecialchars($_POST['tougao_authoremail'], ENT_QUOTES)) : '';
    $blog =  isset( $_POST['tougao_authorblog'] ) ? trim(htmlspecialchars($_POST['tougao_authorblog'], ENT_QUOTES)) : '';
    $title =  isset( $_POST['tougao_title'] ) ? trim(htmlspecialchars($_POST['tougao_title'], ENT_QUOTES)) : '';
    $category =  isset( $_POST['cat'] ) ? (int)$_POST['cat'] : 0;
    $content =  isset( $_POST['tougao_content'] ) ? trim(htmlspecialchars($_POST['tougao_content'], ENT_QUOTES)) : '';
    
    // 表单项数据验证
    if ( empty($name) || mb_strlen($name) > 20 ) {
        wp_die('昵称必须填写，且长度不得超过20字。<a href="'.$current_url.'">点此返回</a>');
    }
    
    if ( empty($email) || strlen($email) > 60 || !preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) {
        wp_die('Email必须填写，且长度不得超过60字，必须符合Email格式。<a href="'.$current_url.'">点此返回</a>');
    }
    
    if ( empty($title) || mb_strlen($title) > 100 ) {
        wp_die('标题必须填写，且长度不得超过100字。<a href="'.$current_url.'">点此返回</a>');
    }
    
    if ( empty($content) || mb_strlen($content) > 10000 || mb_strlen($content) < 100) {
        wp_die('内容必须填写，且长度不得超过10000字，不得少于100字。<a href="'.$current_url.'">点此返回</a>');
    }
    
    $post_content = '昵称: '.$name.'<br />Email: '.$email.'<br />blog: '.$blog.'<br />内容:<br />'.$content;
    
    $tougao = array(
        'post_title' => $title, 
        'post_content' => $post_content,
        'post_category' => array($category)
    );


    // 将文章插入数据库
    $status = wp_insert_post( $tougao );
  
    if ($status != 0) { 
        // 投稿成功给博主发送邮件
        // somebody#example.com替换博主邮箱
        // My subject替换为邮件标题，content替换为邮件内容
        wp_mail("somebody@example.com","My subject","content");

        wp_die('投稿成功！感谢投稿！<a href="'.$current_url.'">点此返回</a>', '投稿成功');
    }
    else {
        wp_die('投稿失败！<a href="'.$current_url.'">点此返回</a>');
    }
	
	$last_post = $wpdb->get_var("SELECT `post_date` FROM `$wpdb->posts` ORDER BY `post_date` DESC LIMIT 1");

    // 博客当前最新文章发布时间与要投稿的文章至少间隔120秒。
    // 可自行修改时间间隔，修改下面代码中的120即可
    // 相比Cookie来验证两次投稿的时间差，读数据库的方式更加安全
    if ( current_time('timestamp') - strtotime($last_post) < 1 ) {
        wp_die('您投稿也太勤快了吧，先歇会儿！<a href="'.$current_url.'">点此返回</a>');
    }
}
get_header(); ?>
<div class="left box">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class('single clearfix'); ?>>
			<h2 class="title">
				<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf('Permanent Link to %s', the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a>
			</h2>
			<?php miui_entry_meta(); ?>
			<?php if ( has_post_thumbnail() ) {  the_post_thumbnail();  } ?>
			<div class="entry clearfix">
				<?php the_content(); ?>
				<?php wp_link_pages(array('before' => '<p class="page_navi"><strong>' . __('日志分页:') . '</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				
				<!-- 关于表单样式，请自行调整-->
				
				<form class="tougao-form" method="post" action="<?php echo $_SERVER["REQUEST_URI"]; $current_user = wp_get_current_user(); ?>">
					<fieldset>
						<legend>投稿表单</legend>
						
						<p>
							<label for="tougao_authorname">昵  称：</label>
							<input type="text" size="40" value="<?php if ( 0 != $current_user->ID ) echo $current_user->user_login; ?>" id="tougao_authorname" name="tougao_authorname" /><span>*</span>
						</p>

						<p>
							<label for="tougao_authoremail">E-Mail：</label>
							<input type="text" size="40" value="<?php if ( 0 != $current_user->ID ) echo $current_user->user_email; ?>" id="tougao_authoremail" name="tougao_authoremail" /><span>*</span>
						</p>
										
						<p>
							<label for="tougao_authorblog">您的博客：</label>
							<input type="text" size="40" value="<?php if ( 0 != $current_user->ID ) echo $current_user->user_url; ?>" id="tougao_authorblog" name="tougao_authorblog" />
						</p>

						<p>
							<label for="tougao_title">文章标题：</label>
							<input type="text" size="40" value="<?php echo $title; ?>" id="tougao_title" name="tougao_title" /><span>*</span>
						</p>

						<p>
							<label for="tougaocategorg">选择分类：</label>
							<?php wp_dropdown_categories('hide_empty=0&id=tougaocategorg&show_count=1&hierarchical=1'); ?><span>*</span>
						</p>
										
						<p>
							<textarea rows="25" id="tougao_content" name="tougao_content" placeholder="投稿内容"></textarea>
						</p>
						<p class="clearfix">
							<label for="CAPTCHA">验证码：</label>
							<input id="CAPTCHA" style="width:110px;" class="input l" type="text" tabindex="24" size="10" value="" name="captcha_code" /> <img id="captcha_img" class="l" src="<?php bloginfo('template_url'); ?>/captcha/captcha.php" /> <em class="l">看不清？<a href="javascript:void(0)" onclick="document.getElementById('captcha_img').src='<?php bloginfo('template_url'); ?>/captcha/captcha.php?'+Math.random();document.getElementById('CAPTCHA').focus();return false;">点击更换</a></em>
						</p>
						<p class="r">
							<input type="hidden" value="send" name="tougao_form" />
							<input type="submit" value="提交" class="wbtn" />
							<input type="reset" value="重填" class="wbtn" />
						</p>
						<div class="clearfix"></div>
						<div class="noway scbox">投稿如果提交失败，投稿内容将被清空，请做好内容备份以防数据丢失！</div>
					</fieldset>
				</form>
			</div>
		</div>
		<?php comments_template(); ?>
	<?php endwhile; else: ?>
		<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
	<?php endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>