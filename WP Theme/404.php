<?php get_header(); ?>
<div class="left box">
	<div class="hentry 404">
		<h2 class="title">404 -- Not Found</h2>
		<div class="entry clearfix">
			<div class="inner404">
				<p>你所查找的内容已经不存在，或者暂时不能访问。</p>
				<?php get_search_form(); ?>
				<span><a class="back1" onclick="javascript:history.go(-1);return false;" href="javascript:;">返回？</a></span>
			</div>
		</div>
	</div>
</div>
<?php get_sidebar(404); ?>
<?php get_footer(); ?>