<?php
///////////////////标签云/////////////////////////////////////////////////
class miui_tagclouds extends WP_Widget {
	function miui_tagclouds() {
		$widget_ops = array('description' => '配合主题样式，字体大小统一');
		$this->WP_Widget('tagclouds', 'MIUI_标签云', $widget_ops);
	}
	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title',esc_attr($instance['title']));
		$limit = strip_tags($instance['limit']);
		echo $before_widget.$before_title.$title.$after_title;
	?> 
		<div>
			<?php
				$tags_list = get_tags('orderby=count&number=' . $limit . '&order=DESC');
				if ($tags_list) { 
					foreach($tags_list as $tag) {
						echo '<a class="wbtn" href="' . get_tag_link($tag) . '" title="' . $tag->name . '(' . $tag->count . ')">' . $tag->name . '<strong>' . $tag->count . '</strong></a>';
					}
				}
			?>
		</div>		
	<?php		 
		echo $after_widget;
	}
	function update($new_instance, $old_instance) {
		if (!isset($new_instance['submit'])) {
			return false;
		}
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['limit'] = strip_tags($new_instance['limit']);
		return $instance;
	}
	function form($instance) {
		global $wpdb;
		$instance = wp_parse_args((array) $instance, array('title'=> '标签凌乱', 'limit' => '30'));
		$title = esc_attr($instance['title']);
		$limit = strip_tags($instance['limit']);
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">标题：<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('limit'); ?>">显示数量（默认30）：<input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" /></label>
		</p>
		<input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
	<?php
	}
}
function miui_tagclouds_init() {
	register_widget('miui_tagclouds');
}
add_action('widgets_init', 'miui_tagclouds_init');
///////////////////热评文章/最新文章///////////////////////////////////////
class miui_hotandnew extends WP_Widget {
	function miui_hotandnew() {
		$widget_ops = array('description' => '首页显示热评文章，其他页面显示最新文章');
		$this->WP_Widget('hotandnew', 'MIUI_热评/最新', $widget_ops);
	}
	function widget($args, $instance) {
		extract($args);
		$newposts = strip_tags($instance['newposts']);
		$hotposts = strip_tags($instance['hotposts']);
		$limit = strip_tags($instance['limit']);
		echo $before_widget.$before_title;
		if (is_singular()) {
			$boxtitle = $newposts;
		} else {
			$boxtitle = $hotposts;
		}
		echo $boxtitle;
		echo $after_title;
		echo '<ul>';
		if (is_singular()) {
			$myposts = array( 'posts_per_page' => $limit, 'orderby' => 'date', 'order' => 'DESC', 'ignore_sticky_posts' => 1 );
		} else {
			$myposts = array( 'posts_per_page' => $limit, 'orderby' => 'comment_count', 'order' => 'DESC', 'ignore_sticky_posts' => 1 );
		}
		query_posts( $myposts );
			while (have_posts()) : the_post();
				$i==1;$i++;
				$title = get_the_title();
				if (strlen($title) == 0) { $title = get_the_time('Y年m月d日') . '无标题文章'; }
				if($i < 4){ $class = '<li class="topRank">';}else{ $class="<li>"; }
				echo $class . '<em>' . $i . '</em><a href="' . get_permalink() . '" title="comments：' . get_comments_number() . '">' . $title . '</a></li>';
			endwhile;
		wp_reset_query();
		echo '</ul>';
		echo $after_widget;
    }
	function update($new_instance, $old_instance) {
		if (!isset($new_instance['submit'])) {
		return false;
	}
		$instance = $old_instance;
		$instance['newposts'] = strip_tags($new_instance['newposts']);
		$instance['hotposts'] = strip_tags($new_instance['hotposts']);
		$instance['limit'] = strip_tags($new_instance['limit']);
		return $instance;
	}
	function form($instance) {
		global $wpdb;
		$instance = wp_parse_args((array) $instance, array('newposts' => '最新文章', 'hotposts' => '热评文章', 'limit' => '10'));
		$newposts = strip_tags($instance['newposts']);
		$hotposts = strip_tags($instance['hotposts']);
		$limit = strip_tags($instance['limit']);
	?>
		<p>
			<label for="<?php echo $this->get_field_id('newposts'); ?>">最新文章标题：<input class="widefat" id="<?php echo $this->get_field_id('newposts'); ?>" name="<?php echo $this->get_field_name('newposts'); ?>" type="text" value="<?php echo $newposts; ?>" /></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('hotposts'); ?>">热评文章标题：<input class="widefat" id="<?php echo $this->get_field_id('hotposts'); ?>" name="<?php echo $this->get_field_name('hotposts'); ?>" type="text" value="<?php echo $hotposts; ?>" /></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('limit'); ?>">文章数量（默认10）：<input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" /></label>
		</p>
		<input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
	<?php
    }
}
function miui_hotandnew_init() {
	register_widget('miui_hotandnew');
}
add_action('widgets_init', 'miui_hotandnew_init');
//////////////////最新评论/评论明星///////////////////////////////////////
class miui_comments_star extends WP_Widget {
	function miui_comments_star() {
		$widget_ops = array('description' => '显示带有头像的最新评论和当月评论排行，tab切换');
		$this->WP_Widget('comments_star', 'MIUI_最新评论/本月水榜', $widget_ops);
	}
	function widget($args, $instance) {
		extract($args);
		$newcomments = strip_tags($instance['newcomments']);
		$commentstar = strip_tags($instance['commentstar']);
		$rclimit = strip_tags($instance['rclimit']);
		$starlimit = strip_tags($instance['starlimit']);
		$email = strip_tags($instance['email']);
		echo $before_widget.$before_title;
		echo '<strong class="tab SwapTab"><span class="fb">' . $newcomments . '</span><span>' . $commentstar . '</span></strong>';
		echo $after_title;
	?>
		<div class="tab-content">
			<ul style="display:block">
				<?php
					global $wpdb;
					$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type,comment_author_url,comment_author_email,comment_content FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND comment_author_email != '$email' AND post_password = '' ORDER BY comment_date_gmt DESC LIMIT $rclimit";
					$comments = $wpdb->get_results($sql);
					$gravatar_status = 'on';
					foreach ($comments as $rc_comment) {
						$rc_comments .= '<li><a href="' . htmlspecialchars(get_comment_link( $rc_comment->comment_ID )) .'" title="《' . get_post( $rc_comment->comment_post_ID )->post_title  . '》">'. get_avatar($rc_comment->comment_author_email,46) . $rc_comment->comment_author . '<b></b></a><p>' . mb_substr(strip_tags($rc_comment->comment_content),0,30) . '</p></li>';
					}
					$rc_comments .= $post_HTML;
					$rc_comments = convert_smilies($rc_comments);
					echo $rc_comments;
				?>
			</ul>
			<ul style="display:none" class="star">
				<?php
					global $wpdb;
					$sql = "SELECT COUNT(comment_author_email) AS cnt, comment_author, comment_author_url,comment_author_email,comment_type FROM (SELECT * FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->posts.ID=$wpdb->comments.comment_post_ID) WHERE MONTH(comment_date)=MONTH(now()) and YEAR(comment_date)=YEAR(now()) AND comment_author_email != '$email' AND comment_type = '' AND post_password='' AND comment_approved='1') AS tempcmt GROUP BY comment_author_email ORDER BY cnt DESC LIMIT $starlimit";
					$counts = $wpdb->get_results($sql);
					if (!empty($counts)) {
						foreach ($counts as $count) {
							if($count->comment_author_url == ''){$url = 'TA来自火星';}else{$url = '<a href="' . $count->comment_author_url . '" target="_blank">去看看TA</a>';}
							$stars.= '<li>' . get_avatar($count->comment_author_email, 64) . '<b>' . $count->comment_author . '</b><span>月评论：' . $count->cnt . '，总评论：' . get_comments(array('author_email' => $count->comment_author_email, 'status' => 'approve', 'count' => true)) . '</span><em>' . $url . '</em></li>';
						}
					} else {
						$stars.= '本月评论热潮还没开始';
					}
					echo $stars;
				?>
			</ul>
		</div>		 
	<?php		 
		echo $after_widget;
	}
	function update($new_instance, $old_instance) {
		if (!isset($new_instance['submit'])) {
			return false;
		}
		$instance = $old_instance;
		$instance['newcomments'] = strip_tags($new_instance['newcomments']);
		$instance['commentstar'] = strip_tags($new_instance['commentstar']);
		$instance['rclimit'] = strip_tags($new_instance['rclimit']);
		$instance['starlimit'] = strip_tags($new_instance['starlimit']);
		$instance['email'] = strip_tags($new_instance['email']);
		return $instance;
	}
	function form($instance) {
		global $wpdb;
		$instance = wp_parse_args((array) $instance, array('newcomments'=> '最新评论', 'commentstar'=> '本月水榜', 'rclimit' => '6', 'starlimit' => '5', 'email' => ''));
		$newcomments = strip_tags($instance['newcomments']);
		$commentstar = strip_tags($instance['commentstar']);
		$rclimit = strip_tags($instance['rclimit']);
		$starlimit = strip_tags($instance['starlimit']);
		$email = strip_tags($instance['email']);
	?>
		<p>
			<label for="<?php echo $this->get_field_id('newcomments'); ?>">最新评论标题：<input class="widefat" id="<?php echo $this->get_field_id('newcomments'); ?>" name="<?php echo $this->get_field_name('newcomments'); ?>" type="text" value="<?php echo $newcomments; ?>" /></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('commentstar'); ?>">本月水榜标题：<input class="widefat" id="<?php echo $this->get_field_id('commentstar'); ?>" name="<?php echo $this->get_field_name('commentstar'); ?>" type="text" value="<?php echo $commentstar; ?>" /></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('rclimit'); ?>">最新评论显示数量（默认6）：<input class="widefat" id="<?php echo $this->get_field_id('rclimit'); ?>" name="<?php echo $this->get_field_name('rclimit'); ?>" type="text" value="<?php echo $rclimit; ?>" /></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('starlimit'); ?>">本月水榜显示数量（默认5）：<input class="widefat" id="<?php echo $this->get_field_id('starlimit'); ?>" name="<?php echo $this->get_field_name('starlimit'); ?>" type="text" value="<?php echo $starlimit; ?>" /></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('email'); ?>">排除回复的Email：（留空则不排除）<br />管理员email：<?php echo get_bloginfo ('admin_email'); ?><input class="widefat" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" type="text" value="<?php echo $email; ?>" /></label>
		</p>
		<input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
	<?php
	}
 }
function miui_comments_star_init() {
	register_widget('miui_comments_star');
}
add_action('widgets_init', 'miui_comments_star_init');
/////////////////////最新评论////////////////////////////////////////////
class miui_rccomments extends WP_Widget {
	function miui_rccomments() {
		$widget_ops = array('description' => '最新评论独立小工具，显示头像和表情');
		$this->WP_Widget('rccomments', 'MIUI_最新评论', $widget_ops);
	}
	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title',esc_attr($instance['title']));
		$limit = strip_tags($instance['limit']);
		$email = strip_tags($instance['email']);
		echo $before_widget.$before_title.$title.$after_title;
	?> 
		<ul>
			<?php
				global $wpdb;
				$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type,comment_author_url,comment_author_email,comment_content FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND comment_author_email != '$email' AND post_password = '' ORDER BY comment_date_gmt DESC LIMIT $limit";
				$comments = $wpdb->get_results($sql);
				$gravatar_status = 'on';
				foreach ($comments as $rc_comment) {
					$rc_comments .= '<li><a href="' . htmlspecialchars(get_comment_link( $rc_comment->comment_ID )) .'" title="《' . get_post( $rc_comment->comment_post_ID )->post_title  . '》">'. get_avatar($rc_comment->comment_author_email,46) . $rc_comment->comment_author . '<b></b></a><p>' . mb_substr(strip_tags($rc_comment->comment_content),0,30) . '</p></li>';
				}
				$rc_comments .= $post_HTML;
				$rc_comments = convert_smilies($rc_comments);
				echo $rc_comments;
			?>
		</ul>		
	<?php		 
		echo $after_widget;
	}
	function update($new_instance, $old_instance) {
		if (!isset($new_instance['submit'])) {
			return false;
		}
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['limit'] = strip_tags($new_instance['limit']);
		$instance['email'] = strip_tags($new_instance['email']);
		return $instance;
	}
	function form($instance) {
		global $wpdb;
		$instance = wp_parse_args((array) $instance, array('title'=> '最新评论', 'limit' => '5', 'email' => ''));
		$title = esc_attr($instance['title']);
		$limit = strip_tags($instance['limit']);
		$email = strip_tags($instance['email']);
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">标题：<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('limit'); ?>">显示数量(默认5)：<input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" /></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('email'); ?>">排除回复的Email：（留空则不排除）<br />管理员email：<?php echo get_bloginfo ('admin_email'); ?><input class="widefat" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" type="text" value="<?php echo $email; ?>" /></label>
		</p>
		<input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
	<?php
	}
}
add_action('widgets_init', 'miui_rccomments_init');
function miui_rccomments_init() {
	register_widget('miui_rccomments');
}
//////////////////////最新评论无头像版///////////////////////////////////
class miui_ngcomments extends WP_Widget {
	function miui_ngcomments() {
		$widget_ops = array('description' => '最新评论无头像版，支持评论表情');
		$this->WP_Widget('ngcomments', 'MIUI_最新评论(无头像)', $widget_ops);
	}
	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title',esc_attr($instance['title']));
		$limit = strip_tags($instance['limit']);
		$email = strip_tags($instance['email']);
		echo $before_widget.$before_title.$title.$after_title;
	?> 
		<ul>
			<?php
				global $wpdb;
				$rc_comms = $wpdb->get_results("SELECT ID, post_title, comment_ID, comment_author,comment_author_email,comment_date,comment_content FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID  = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' AND comment_author_email != '$email' ORDER BY comment_date_gmt DESC LIMIT $limit ");
				$rc_comments = '';
				foreach ($rc_comms as $rc_comm) { 
					$rc_comments .= "<li class='reccomtli cf'><a href='". get_permalink($rc_comm->ID) . "#comment-" . $rc_comm->comment_ID. "' title='在 " . $rc_comm->post_title .  " 发表的评论'><span class='comer'>".$rc_comm->comment_author."</span></a>：".mb_substr(strip_tags($rc_comm->comment_content),0,20)."</li>\n";
				}
				$rc_comments = convert_smilies($rc_comments);
				echo $rc_comments;
			?>
		</ul>
	<?php
		echo $after_widget;
	}
	function update($new_instance, $old_instance) {
		if (!isset($new_instance['submit'])) {
			return false;
		}
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['limit'] = strip_tags($new_instance['limit']);
		$instance['email'] = strip_tags($new_instance['email']);
		return $instance;
	}
	function form($instance) {
		global $wpdb;
		$instance = wp_parse_args((array) $instance, array('title'=> '最新评论', 'limit' => '10', 'email' => ''));
		$title = esc_attr($instance['title']);
		$limit = strip_tags($instance['limit']);
		$email = strip_tags($instance['email']);
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">标题：<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('limit'); ?>">显示数量： <input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" /></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('email'); ?>">排除回复的Email：（留空则不排除）<br />管理员email：<?php echo get_bloginfo ('admin_email'); ?><input class="widefat" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" type="text" value="<?php echo $email; ?>" /></label>
		</p>
		<input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
	<?php
	}
}
add_action('widgets_init', 'miui_ngcomments_init');
function miui_ngcomments_init() {
	register_widget('miui_ngcomments');
}
////////////////////////读者头像///////////////////////////////////////
class miui_guestface extends WP_Widget {
	function miui_guestface() {
		$widget_ops = array('description' => '30天为一周期,5个头像为一行');
		$this->WP_Widget('guestface', 'MIUI_月读者墙', $widget_ops);
	}
	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title',esc_attr($instance['title']));
		$limit = strip_tags($instance['limit']);
		echo $before_widget.$before_title.$title.$after_title;
		echo '<ul>';
		global $wpdb;
		$admin_email = get_bloginfo ('admin_email');
		$sql = "SELECT COUNT(comment_author_email) AS cnt, comment_author, comment_author_url,comment_author_email,comment_type FROM (SELECT * FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->posts.ID=$wpdb->comments.comment_post_ID) WHERE MONTH(comment_date)=MONTH(now()) and YEAR(comment_date)=YEAR(now()) AND comment_author_email != '$admin_email' AND comment_type = '' AND post_password='' AND comment_approved='1') AS tempcmt GROUP BY comment_author_email ORDER BY cnt DESC LIMIT $limit";
		$counts = $wpdb->get_results($sql);
		if (!empty($counts)) {
			foreach ($counts as $count) {
				if($count->comment_author_url == ''){
					echo '<li class="l" title="' . $count->comment_author . ' 月评论：' . $count->cnt . '，总评论：' . get_comments(array('author_email' => $count->comment_author_email, 'status' => 'approve', 'count' => true)) . '">' . get_avatar($count->comment_author_email, 40) . '</li>';
				}else{
					echo '<li class="l"><a href="' . $count->comment_author_url . '" title="' . $count->comment_author . '月评论：' . $count->cnt . '，总评论：' . get_comments(array('author_email' => $count->comment_author_email, 'status' => 'approve', 'count' => true)) . '" target="_blank">' . get_avatar($count->comment_author_email, 40) . '</a></li>';
				}
			}
		} else {
			echo '本月评论热潮还没开始';
		}
		echo '</ul>';		 
		echo $after_widget;
	}
	function update($new_instance, $old_instance) {
		if (!isset($new_instance['submit'])) {
			return false;
		}
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['limit'] = strip_tags($new_instance['limit']);
		return $instance;
	}
	function form($instance) {
		global $wpdb;
		$instance = wp_parse_args((array) $instance, array('title'=> '', 'limit' => '10'));
		$title = esc_attr($instance['title']);
		$limit = strip_tags($instance['limit']);
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">标题：<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('limit'); ?>">显示数量(默认10)：<input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" /></label>
		</p>
		<input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
	<?php
	}
}
function miui_guestface_init() {
	register_widget('miui_guestface');
}
add_action('widgets_init', 'miui_guestface_init');
///////////////////我的相册///////////////////////////////////////////////
class miui_picshow extends WP_Widget {
	function miui_picshow() {
		$widget_ops = array('description' => '显示4张图片切换，须指定图片所在分类');
		$this->WP_Widget('picshow', 'MIUI_我的相册', $widget_ops);
	}
	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title',esc_attr($instance['title']));
		$picshowid = strip_tags($instance['picshowid']);
		echo $before_widget.$before_title.$title;
		echo '<a class="r" href="' . esc_url( get_category_link( $picshowid )) . '" target="_blank">更多 &gt;</a>';
		echo $after_title;
		echo '<ul>';
		$showposts = array( 'posts_per_page' => '4', 'cat' => $picshowid, 'orderby' => 'date', 'order' => 'DESC', 'ignore_sticky_posts' => 1 );
		query_posts( $showposts );
		while ( have_posts() ) : the_post();
			$title = get_the_title();
			if (strlen($title) == 0) { $title = get_the_time('Y年m月d日') . '无标题文章'; }
			$i==1;$i++;
			if($i==1){$class='<li class="current">';}else{$class='<li>';}
			echo $class . '<a href="' . get_permalink() . '" target="_blank">';
			post_thumbnail(61, 47);
			echo '</a><span><a href="' . get_permalink() . '" target="_blank">';
			post_thumbnail(260, 185);
			echo '<strong>' . $title . '</strong></a></span></li>';	
		endwhile;
		wp_reset_query();
		echo '</ul>';
		echo $after_widget;
    }
	function update($new_instance, $old_instance) {
		if (!isset($new_instance['submit'])) {
		return false;
	}
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['picshowid'] = strip_tags($new_instance['picshowid']);
		return $instance;
	}
	function form($instance) {
		global $wpdb;
		$instance = wp_parse_args((array) $instance, array('title' => '相册展示', 'picshowid' => ''));
		$title = esc_attr($instance['title']);
		$picshowid = strip_tags($instance['picshowid']);
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">标题：<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('picshowid'); ?>">相册所在分类的ID：<input class="widefat" id="<?php echo $this->get_field_id('picshowid'); ?>" name="<?php echo $this->get_field_name('picshowid'); ?>" type="text" value="<?php echo $picshowid; ?>" /></label>
		</p>
		<input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
	<?php
    }
}
function miui_picshow_init() {
	register_widget('miui_picshow');
}
add_action('widgets_init', 'miui_picshow_init');
///////////////////指定分类文章样式1///////////////////////////////////////
class miui_activities extends WP_Widget {
	function miui_activities() {
		$widget_ops = array('description' => '以小缩略图(125*80)、标题和阅读全文的形式显示某分类下最新文章');
		$this->WP_Widget('activities', 'MIUI_指定分类文章1', $widget_ops);
	}
	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title',esc_attr($instance['title']));
		$thecatid = strip_tags($instance['thecatid']);
		$limited = strip_tags($instance['limited']);
		echo $before_widget.$before_title.$title;
		echo '<a class="r" href="' . esc_url( get_category_link( $thecatid )) . '" target="_blank">更多 &gt;</a>';
		echo $after_title;
		echo '<ul>';
		$showposts = array( 'posts_per_page' => $limited, 'cat' => $thecatid, 'orderby' => 'date', 'order' => 'DESC', 'ignore_sticky_posts' => 1 );
		query_posts( $showposts );
		while ( have_posts() ) : the_post();
			$title = get_the_title();
			if (strlen($title) == 0) { $title = get_the_time('Y年m月d日') . '无标题文章'; }
			echo '<dl><dt><a href="' . get_permalink() . '" target="_blank" title="' . mb_substr(strip_tags(get_the_content()),0,66) . '...">';
			post_thumbnail(125, 80);
			echo get_the_title() . '</a></dt><dd><a href="' . get_permalink() . '" target="_blank">阅读全文</a></dd></dl>';
		endwhile;
		wp_reset_query();
		echo '</ul>';
		echo $after_widget;
    }
	function update($new_instance, $old_instance) {
		if (!isset($new_instance['submit'])) {
		return false;
	}
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['thecatid'] = strip_tags($new_instance['thecatid']);
		$instance['limited'] = strip_tags($new_instance['limited']);
		return $instance;
	}
	function form($instance) {
		global $wpdb;
		$instance = wp_parse_args((array) $instance, array('title' => '', 'thecatid' => '', 'limited' => '5'));
		$title = esc_attr($instance['title']);
		$thecatid = strip_tags($instance['thecatid']);
		$limited = strip_tags($instance['limited']);
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">标题：<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('thecatid'); ?>">分类的ID：<input class="widefat" id="<?php echo $this->get_field_id('thecatid'); ?>" name="<?php echo $this->get_field_name('thecatid'); ?>" type="text" value="<?php echo $thecatid; ?>" /></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('limited'); ?>">文章数量（默认5）：<input class="widefat" id="<?php echo $this->get_field_id('limited'); ?>" name="<?php echo $this->get_field_name('limited'); ?>" type="text" value="<?php echo $limited; ?>" /></label>
		</p>
		<input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
	<?php
    }
}
function miui_activities_init() {
	register_widget('miui_activities');
}
add_action('widgets_init', 'miui_activities_init');
///////////////////指定分类文章2//////////////////////////////////////////
class miui_showcat2 extends WP_Widget {
	function miui_showcat2() {
		$widget_ops = array('description' => '以大缩略图(260*99)和标题的形式显示某分类下最新文章');
		$this->WP_Widget('showcat2', 'MIUI_指定分类文章2', $widget_ops);
	}
	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title',esc_attr($instance['title']));
		$thecatid = strip_tags($instance['thecatid']);
		$limited = strip_tags($instance['limited']);
		echo $before_widget.$before_title.$title;
		echo '<a class="r" href="' . esc_url( get_category_link( $thecatid )) . '" target="_blank">更多 &gt;</a>';
		echo $after_title;
		echo '<ul>';
		$showposts = array( 'posts_per_page' => $limited, 'cat' => $thecatid, 'orderby' => 'date', 'order' => 'DESC', 'ignore_sticky_posts' => 1 );
		query_posts( $showposts );
		while ( have_posts() ) : the_post();
			$title = get_the_title();
			if (strlen($title) == 0) { $title = get_the_time('Y年m月d日') . '无标题文章'; }
			echo '<li><a href="' . get_permalink() . '" target="_blank" title="' . mb_substr(strip_tags(get_the_content()),0,66) . '...">';
			post_thumbnail(260, 99);
			echo $title . '</a></li>';
		endwhile;
		wp_reset_query();
		echo '</ul>';
		echo $after_widget;
    }
	function update($new_instance, $old_instance) {
		if (!isset($new_instance['submit'])) {
		return false;
	}
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['thecatid'] = strip_tags($new_instance['thecatid']);
		$instance['limited'] = strip_tags($new_instance['limited']);
		return $instance;
	}
	function form($instance) {
		global $wpdb;
		$instance = wp_parse_args((array) $instance, array('title' => '', 'thecatid' => '', 'limited' => '5'));
		$title = esc_attr($instance['title']);
		$thecatid = strip_tags($instance['thecatid']);
		$limited = strip_tags($instance['limited']);
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">标题：<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('thecatid'); ?>">分类的ID：<input class="widefat" id="<?php echo $this->get_field_id('thecatid'); ?>" name="<?php echo $this->get_field_name('thecatid'); ?>" type="text" value="<?php echo $thecatid; ?>" /></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('limited'); ?>">文章数量（默认5）：<input class="widefat" id="<?php echo $this->get_field_id('limited'); ?>" name="<?php echo $this->get_field_name('limited'); ?>" type="text" value="<?php echo $limited; ?>" /></label>
		</p>
		<input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
	<?php
    }
}
function miui_showcat2_init() {
	register_widget('miui_showcat2');
}
add_action('widgets_init', 'miui_showcat2_init');
///////////////////指定分类文章3//////////////////////////////////////////
class miui_showcat3 extends WP_Widget {
	function miui_showcat3() {
		$widget_ops = array('description' => '列出某分类下的文章仅标题');
		$this->WP_Widget('showcat3', 'MIUI_指定分类文章3', $widget_ops);
	}
	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title',esc_attr($instance['title']));
		$limit = strip_tags($instance['limit']);
		$cateid = strip_tags($instance['cateid']);
		echo $before_widget.$before_title.$title;
		echo '<a class="r" href="' . esc_url( get_category_link( $cateid )) . '" target="_blank">更多 &gt;</a>';
		echo $after_title;
	?> 
		<ul>
			<?php query_posts( array('showposts' => $limit,'cat' => $cateid,));?>
			<?php while (have_posts()) : the_post(); ?>   
			<li><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></li>  
			<?php endwhile; wp_reset_query(); ?>
		</ul>
	<?php		 
		echo $after_widget;
	}
	function update($new_instance, $old_instance) {
		if (!isset($new_instance['submit'])) {
			return false;
		}
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['limit'] = strip_tags($new_instance['limit']);
		$instance['cateid'] = strip_tags($new_instance['cateid']);
		return $instance;
	}
	function form($instance) {
		global $wpdb;
		$instance = wp_parse_args((array) $instance, array('title'=> '', 'limit' => '', 'cateid' => ''));
		$title = esc_attr($instance['title']);
		$limit = strip_tags($instance['limit']);
		$cateid = strip_tags($instance['cateid']);
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">标题：<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('limit'); ?>">显示数量：<input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" /></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('cateid'); ?>">输入分类ID：<input class="widefat" id="<?php echo $this->get_field_id('cateid'); ?>" name="<?php echo $this->get_field_name('cateid'); ?>" type="text" value="<?php echo $cateid; ?>" /></label>
		</p>
		<input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
	<?php
	}
}
function miui_showcat3_init() {
	register_widget('miui_showcat3');
}
add_action('widgets_init', 'miui_showcat3_init');
///////////////////随机文章//////////////////////////////////////////////
class miui_randposts extends WP_Widget {
	function miui_randposts() {
		$widget_ops = array('description' => '双列显示带缩略图的随机文章');
		$this->WP_Widget('randposts', 'MIUI_随机文章', $widget_ops);
	}
	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title',esc_attr($instance['title']));
		$limited = strip_tags($instance['limited']);
		echo $before_widget.$before_title.$title.$after_title;
		echo '<ul>';
		$showposts = array( 'posts_per_page' => $limited, 'orderby' => 'rand', 'order' => 'DESC', 'ignore_sticky_posts' => 1 );
		query_posts( $showposts );
		while ( have_posts() ) : the_post();
			$title = get_the_title();
			if (strlen($title) == 0) { $title = get_the_time('Y年m月d日') . '无标题文章'; }
			echo '<li><a href="' . get_permalink() . '" rel="bookmark">';
			post_thumbnail(125, 80);
			echo $title . '</a></li>';
		endwhile;
		wp_reset_query();
		echo '</ul>';
		echo $after_widget;
    }
	function update($new_instance, $old_instance) {
		if (!isset($new_instance['submit'])) {
		return false;
	}
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['limited'] = strip_tags($new_instance['limited']);
		return $instance;
	}
	function form($instance) {
		global $wpdb;
		$instance = wp_parse_args((array) $instance, array('title' => '随机文章', 'limited' => '6'));
		$title = esc_attr($instance['title']);
		$limited = strip_tags($instance['limited']);
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">标题：<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('limited'); ?>">文章数量（默认6，请输入偶数）：<input class="widefat" id="<?php echo $this->get_field_id('limited'); ?>" name="<?php echo $this->get_field_name('limited'); ?>" type="text" value="<?php echo $limited; ?>" /></label>
		</p>
		<input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
	<?php
    }
}
function miui_randposts_init() {
	register_widget('miui_randposts');
}
add_action('widgets_init', 'miui_randposts_init');
////////////////////双栏分类目录////////////////////////////////////////
class miui_twocats extends WP_Widget {
	function miui_twocats() {
		$widget_ops = array('description' => '双列排序的分类目录，只支持一级目录');
		$this->WP_Widget('twocats', 'MIUI_双列分类目录', $widget_ops);
	}
	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title',esc_attr($instance['title']));
		$limit = strip_tags($instance['limit']);
		$orderby = strip_tags($instance['orderby']);
		echo $before_widget.$before_title.$title.$after_title;
	?> 
		<ul>
			<?php 
				wp_list_categories( 
					array(
						'style' => 'list',
						'show_count' => $limit,
						'hide_empty' => 1,
						'hierarchical' => false,
						'title_li' => '',
						'orderby' => $orderby,
						'order' => 'ASC',
						'echo' => 1
					)
				);
			?>
		</ul>
	<?php		 
		echo $after_widget;
	}
	function update($new_instance, $old_instance) {
		if (!isset($new_instance['submit'])) {
			return false;
		}
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['limit'] = strip_tags($new_instance['limit']);
		$instance['orderby'] = strip_tags($new_instance['orderby']);
		return $instance;
	}
	function form($instance) {
		global $wpdb;
		$instance = wp_parse_args((array) $instance, array('title'=> '栏目分类', 'limit' => '', 'orderby' => ''));
		$title = esc_attr($instance['title']);
		$limit = strip_tags($instance['limit']);
		$orderby = strip_tags($instance['orderby']);
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">标题：<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('limit'); ?>">是否显示文章统计：<br>输入“1”为显示，输入“0”为不显示<input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" /></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('orderby'); ?>">排序：<br>(使用普通排序，输入“name”，可留空)<br><input class="widefat" id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>" type="text" value="<?php echo $orderby; ?>" /></label>
		</p>
		<input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
	<?php
	}
}
function miui_twocats_init() {
	register_widget('miui_twocats');
}
add_action('widgets_init', 'miui_twocats_init');
////////////////////友情链接//////////////////////////////////////////
class  miui_blogrolls extends WP_Widget {
	function miui_blogrolls() {
		$widget_ops = array('description' => '双列排序的友情链接，只支持一级目录');
		$this->WP_Widget('blogrolls', 'MIUI_双列友情链接', $widget_ops);
	}
	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title',esc_attr($instance['title']));
		$limit = strip_tags($instance['limit']);
		$orderby = strip_tags($instance['orderby']);
		echo $before_widget.$before_title.$title.$after_title;
	?> 
		<ul>
			<?php 
				wp_list_bookmarks(
					array(
						'limit' => $limit,
						'hide_empty' => 1,
						'categorize' => 0,
						'title_li' => '',
						'orderby' => $orderby,
						'order' => 'ASC',
						'echo' => 1,
						'show_images' => 0
					)
				);
			?>
		</ul>		
	<?php		 
		echo $after_widget;
	}
	function update($new_instance, $old_instance) {
		if (!isset($new_instance['submit'])) {
			return false;
		}
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['limit'] = strip_tags($new_instance['limit']);
		$instance['orderby'] = strip_tags($new_instance['orderby']);
		return $instance;
	}
	function form($instance) {
		global $wpdb;
		$instance = wp_parse_args((array) $instance, array('title'=> '友情链接', 'limit' => '-1', 'orderby' => 'name'));
		$title = esc_attr($instance['title']);
		$limit = strip_tags($instance['limit']);
		$orderby = strip_tags($instance['orderby']);
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">标题：<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('limit'); ?>">数量（默认“-1”为全部显示—）：<input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" /></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('orderby'); ?>">排序：<br>（默认“name”按名称排列）<br>（如果需要其他排列，输入相应的排序形式。<a target="_blank" href="http://codex.wordpress.org/Function_Reference/wp_list_bookmarks">查看orderby排序参数</a>）<input class="widefat" id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>" type="text" value="<?php echo $orderby; ?>" /></label>
		</p>
		<input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
	<?php
	}
}
add_action('widgets_init', 'miui_blogrolls_init');
function miui_blogrolls_init() {
	register_widget('miui_blogrolls');
}
///////////////////分类目录/自定内容//////////////////////////////////
class miui_catanddiy extends WP_Widget {
	function miui_catanddiy() {
		$widget_ops = array('description' => '双列自定义分类菜单和自定义内容tab切换');
		$this->WP_Widget('catanddiy', 'MIUI_栏目分类/自定义内容', $widget_ops);
	}
	function widget($args, $instance) {
		extract($args);
		$cattitle = strip_tags($instance['cattitle']);
		$diytitle = strip_tags($instance['diytitle']);
		$diycontent = strip_tags($instance['diycontent']);
		echo $before_widget.$before_title;
		echo '<strong class="tab SwapTab"><span class="fb">' . $cattitle . '</span><span>' . $diytitle . '</span></strong>';
		echo $after_title;
	?>
		<div class="tab-content">
			<?php
				wp_nav_menu( array(
					'theme_location' => 'widget-menu',
					'menu_class' =>'btc',
					'menu_id' => '',
					'container' => '',
					'depth' => 1,
					'fallback_cb' => 'link_to_menu_editor',
					'items_wrap' => '<ul id="%1$s" class="%2$s" style="display:block">%3$s</ul>'
				));
			?>
			<ul style="display:none" class="pd20">
				<?php
					echo $diycontent;
				?>
			</ul>
		</div>
	<?php
		echo $after_widget;
    }
	function update($new_instance, $old_instance) {
		if (!isset($new_instance['submit'])) {
		return false;
	}
		$instance = $old_instance;
		$instance['cattitle'] = strip_tags($new_instance['cattitle']);
		$instance['diytitle'] = strip_tags($new_instance['diytitle']);
		$instance['diycontent'] = strip_tags($new_instance['diycontent']);
		return $instance;
	}
	function form($instance) {
		global $wpdb;
		$instance = wp_parse_args((array) $instance, array('cattitle' => '分类菜单', 'diytitle' => '', 'diycontent' => '', 'limit' => '10'));
		$cattitle = strip_tags($instance['cattitle']);
		$diytitle = strip_tags($instance['diytitle']);
		$diycontent = strip_tags($instance['diycontent']);
	?>
		<p>栏目分类内容为自定义菜单，须到 <a href="nav-menus.php" target="_blank">自定义菜单</a> 下设置【<a href="nav-menus.php?action=locations" target="_blank">侧边小工具菜单</a>】，只支持1级菜单。</p>
		<p>
			<label for="<?php echo $this->get_field_id('cattitle'); ?>">栏目分类标题：<input class="widefat" id="<?php echo $this->get_field_id('cattitle'); ?>" name="<?php echo $this->get_field_name('cattitle'); ?>" type="text" value="<?php echo $cattitle; ?>" /></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('diytitle'); ?>">自定义内容标题：<input class="widefat" id="<?php echo $this->get_field_id('diytitle'); ?>" name="<?php echo $this->get_field_name('diytitle'); ?>" type="text" value="<?php echo $diytitle; ?>" /></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('diycontent'); ?>">自定义内容：<textarea class="widefat" id="<?php echo $this->get_field_id('diycontent'); ?>" name="<?php echo $this->get_field_name('diycontent'); ?>" type="text" rows="16"><?php echo $diycontent; ?></textarea></label>
		</p>
		<input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
	<?php
    }
}
function miui_catanddiy_init() {
	register_widget('miui_catanddiy');
}
add_action('widgets_init', 'miui_catanddiy_init');
////////////////////吐槽工具//////////////////////////////////////////
class  miui_tucao extends WP_Widget {
	function miui_tucao() {
		$widget_ops = array('description' => '显示吐槽内容,需要建立吐槽页面和后台设置吐槽页面ID支持');
		$this->WP_Widget('tucao', 'MIUI_吐槽', $widget_ops);
	}
	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title',esc_attr($instance['title']));
		$limit = strip_tags($instance['limit']);
		echo $before_widget.$before_title.$title.$after_title;
	?> 
		<ul>
			<?php 
				$tucao_id = dopt('tucao_page_id');
				$args = array('status' => 'approve', 'parent' => '0', 'number' => $limit, 'post_id' => $tucao_id );
				$comments = get_comments($args);
				if (!empty($comments)) {
					foreach($comments as $comment) :
						$tuchao .= '<li>';
						$tuchao .= '<p>' . convert_smilies( $comment->comment_content) . '</p>';
						$tuchao .= '<a href="' . htmlspecialchars(get_comment_link( $comment->comment_ID )) . '">' . get_comment_date('Y.m.d',$comment->comment_ID) . '</a>';
						$tuchao .= '</li>';
					endforeach;	
				}else{
					$tuchao ='<li>博主还木有吐槽喔...</li>';
				}
				echo $tuchao;
			?>
		</ul>		
	<?php		 
		echo $after_widget;
	}
	function update($new_instance, $old_instance) {
		if (!isset($new_instance['submit'])) {
			return false;
		}
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['limit'] = strip_tags($new_instance['limit']);
		return $instance;
	}
	function form($instance) {
		global $wpdb;
		$instance = wp_parse_args((array) $instance, array('title'=> '吐槽', 'limit' => '10'));
		$title = esc_attr($instance['title']);
		$limit = strip_tags($instance['limit']);
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">标题：<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('limit'); ?>">数量（默认10）：<input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" /></label>
		</p>
		<input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
	<?php
	}
}
add_action('widgets_init', 'miui_tucao_init');
function miui_tucao_init() {
	register_widget('miui_tucao');
}
///////////////////记录最近浏览//////////////////////////////////////////
class miui_recentviews extends WP_Widget {
	function miui_recentviews() {
		$widget_ops = array('description' => '记录访客360天内看过的10篇文章，须浏览器cookie支持');
		$this->WP_Widget('recentviews', 'MIUI_最近浏览', $widget_ops);
	}
	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title',esc_attr($instance['title']));
		echo $before_widget.$before_title.$title.$after_title;
		zg_recently_viewed();
		echo $after_widget;
    }
	function update($new_instance, $old_instance) {
		if (!isset($new_instance['submit'])) {
		return false;
	}
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
	function form($instance) {
		global $wpdb;
		$instance = wp_parse_args((array) $instance, array('title' => '最近浏览'));
		$title = esc_attr($instance['title']);
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">标题：<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
		</p>
		<input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
	<?php
    }
}
function miui_recentviews_init() {
	register_widget('miui_recentviews');
}
add_action('widgets_init', 'miui_recentviews_init');
?>