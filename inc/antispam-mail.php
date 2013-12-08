<?php
/* comment_mail_notify v1.0 by willin kan. (所有回覆都發郵件) */
function comment_mail_notify($comment_id) {
  $comment = get_comment($comment_id);
  $parent_id = $comment->comment_parent ? $comment->comment_parent : '';
  $spam_confirmed = $comment->comment_approved;
  if (($parent_id != '') && ($spam_confirmed != 'spam')) {
    $wp_email = 'i@happyet.org'; //e-mail 發出點, no-reply 可改為可用的 e-mail.
    $to = trim(get_comment($parent_id)->comment_author_email);
    $subject = '您在 [' . get_option("blogname") . '] 的留言被围观';
    $message = '
    <div style="color: #111; padding: 0 15px;">
      <p>' . trim(get_comment($parent_id)->comment_author) . ', 您好!</p>
      <p>您在《' . get_the_title($comment->comment_post_ID) . '》的留言:</p>
      <p style="background-color: #eef2fa; border: 1px solid #d8e3e8; color: #111; padding:15px; -moz-border-radius:5px; -webkit-border-radius:5px; -khtml-border-radius:5px;">'. trim(get_comment($parent_id)->comment_content) . '</p>
      <p>被' . trim($comment->comment_author) . ' 围观:</p>
      <p style="background-color: #eef2fa; border: 1px solid #d8e3e8; color: #111; padding:15px; -moz-border-radius:5px; -webkit-border-radius:5px; -khtml-border-radius:5px;">' . trim(convert_smilies($comment->comment_content)) . '<br /></p>
      <p>您可以点击 <a href="' . htmlspecialchars(get_comment_link($parent_id, array('type' => 'comment'))) . '">这里查看围观內容。</a></p>
      <p><a href="' . get_option('home') . '">' . get_option('blogname') . '</a>-' . get_option('siteurl') . '欢迎您的再度光临！</p>
      <p>(此邮件由系统自动发出, 请勿回复.)</p>
    </div>';
    $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
    $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
    wp_mail( $to, $subject, $message, $headers );
    //echo 'mail to ', $to, '<br/> ' , $subject, $message; // for testing
  }
}
add_action('comment_post', 'comment_mail_notify');
//垃圾评论检测
/* <<小牆>> Anti-Spam v1.83 by Willin Kan. */
class anti_spam {
	function anti_spam() {
		if ( !current_user_can('read') ) {
			add_action('template_redirect', array($this, 'w_tb'), 1);
			add_action('init', array($this, 'gate'), 1);
			add_action('preprocess_comment', array($this, 'sink'), 1);
		}
	}
	// 設欄位
	function w_tb() {
		if ( is_singular() ) {
			// 非中文語系
			//if ( stripos($_SERVER['HTTP_ACCEPT_LANGUAGE'], 'zh') === false ) {
			//	add_filter( 'comments_open', create_function('', "return false;") ); // 關閉評論
			//} else {
				ob_start(create_function('$input','return preg_replace("#textarea(.*?)name=([\"\'])comment([\"\'])(.+)/textarea>#","textarea$1name=$2w$3$4/textarea><textarea name=\"comment\" cols=\"100%\" rows=\"4\" style=\"display:none\"></textarea>",$input);') );
			//}
		}
	}
	// 檢查
	function gate() {
		$w = 'w';
		if ( !empty($_POST[$w]) && empty($_POST['comment']) ) {
			$_POST['comment'] = $_POST[$w];
		} else {
			$request = $_SERVER['REQUEST_URI'];
			$IP = $_SERVER['REMOTE_ADDR']; // 可用於屏蔽 IP
			$way = isset($_POST[$w]) ? '手動操作' : '未經評論表格';
			$spamcom = isset($_POST['comment']) ? $_POST['comment'] : '';
			$_POST['spam_confirmed'] = "請求: ". $request. "\nIP: ". $IP. "\n方式: ".
			$way. "\n內容: ". $spamcom. "\n -- 記錄成功 --";
		}
	}
	// 處理
	function sink( $comment ) {
		// 不管 Trackbacks/Pingbacks
		if ( in_array( $comment['comment_type'], array('pingback', 'trackback') ) ) return $comment;
		// 已確定為 spam
		if ( !empty($_POST['spam_confirmed']) ) {
			// 方法一: 直接擋掉, 將 die(); 前面兩斜線刪除即可.
			//die();
			// 方法二: 標記為 spam, 留在資料庫檢查是否誤判.
			add_filter('pre_comment_approved', create_function('', 'return "spam";'));
			$comment['comment_content'] = "[ 小牆判斷這是Spam! ]\n". $_POST['spam_confirmed'];
			$this->add_black( $comment );
		} else {
			// 檢查頭像
			$f = md5( strtolower($comment['comment_author_email']) );
			$g = sprintf( "http://%d.gravatar.com", (hexdec($f{0}) % 2) ) .'/avatar/'. $f .'?d=404';
			$headers = @get_headers( $g );
			if ( !preg_match("|200|", $headers[0]) ) {
				// 沒頭像的列入待審
				add_filter('pre_comment_approved', create_function('', 'return "0";'));
			}
		}
		return $comment;
	}
	// 列入黑名單
	function add_black( $comment ) {
		$blacklist = get_option('blacklist_keys');
		update_option('blacklist_keys', $comment['comment_author'] . "\n" . $blacklist);
	}
}
$anti_spam = new anti_spam();
?>