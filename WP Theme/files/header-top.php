<div class="topTB">
	<div class="topTBInner">
		<div class="l">
			<a onclick="setHomepage('<?php echo get_option('home'); ?>');" href="javascript:;">设为首页</a>
			<a onclick="addFavorite(this.href, '<?php bloginfo('name'); ?>');return false;" href="javascript:;">收藏本站</a>
		</div>
		<div class="r">
			<ul>
			<?php wp_nav_menu( array(
				'theme_location' => 'top-menu',
				'container' => '',
				'depth' => 1,
				'fallback_cb' => 'link_to_menu_editor',
				'items_wrap' => '%3$s'
				));
			?>
			</ul>
		</div>
	</div>
</div>