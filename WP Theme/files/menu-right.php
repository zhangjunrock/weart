<div id="qmenu">
	<a class="qmenua">快捷导航</a>
	<div class="qmenu-drop">
		<div class="feedurl">
			<p>
				订阅到：<a rel="nofollow" href="http://mail.qq.com/cgi-bin/feed?u=<?php bloginfo('rss2_url'); ?>" target="_blank">QQ邮箱</a>
				<a rel="nofollow" href="http://www.xianguo.com/subscribe.php?url=<?php bloginfo('rss2_url'); ?>" target="_blank">鲜果</a> 
				<a rel="nofollow" href="http://www.zhuaxia.com/add_channel.php?url=<?php bloginfo('rss2_url'); ?>" target="_blank">抓虾</a> 
				<a rel="nofollow" href="http://fusion.google.com/add?feedurl=<?php bloginfo('rss2_url'); ?>" target="_blank">谷歌</a> 
				<a rel="nofollow" href="http://9.douban.com/reader/subscribe?url=<?php bloginfo('rss2_url'); ?>" target="_blank">豆瓣</a>
			</p>
			<h3>订阅地址：</h3>
			<input type="text" value="<?php bloginfo('rss2_url'); ?>" onmouseover="$(this).select()" />
			<input type="text" value="<?php bloginfo('atom_url'); ?>" onmouseover="$(this).select()" />
			<?php if(dopt('feed_url')){ ?>
				<input type="text" value="<?php echo dopt('feed_url'); ?>" onmouseover="$(this).select()" />
			<?php } ?>
		</div>
		<?php if(dopt('feed_to_email')){ ?>
		<div class="feedtoemail">
			<h3>订阅到邮箱：</h3>
			<form action="http://list.qq.com/cgi-bin/qf_compose_send" target="_blank" name="form" id="form" method="post" onsubmit="if(document.getElementById('to').value =='' || document.getElementById('to').value == '例如：username@qq.com'){ alert('请填写邮件地址'); return false;}else{return true;}">
				<div class="input-append">
					<input type="hidden" name="t" value="qf_booked_feedback">
					<input type="hidden" name="id" value="<?php echo dopt('feed_to_email'); ?>">
					<input type="text" onblur="if(this.value==''){this.value='例如：username@qq.com';this.style.color='#a0a0a0'}" onfocus="if(this.value=='例如：username@qq.com'){this.value='';this.style.color='#a0a0a0'}" class="txt" value="例如：username@qq.com" name="to" id="to">
					<button class="submit" onclick="javascript:document.form.submit();" id="btnsubmit" type="submit">Submit</button>
				</div>
			</form>
		</div>
		<?php } ?>
	</div>
</div>