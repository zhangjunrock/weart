<?php
/*
Template Name: 链接页面模板
*/

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
				<?php $link_cats = get_terms( 'link_category' );
					if($link_cats) : foreach($link_cats as $linkcat) : ?>
					<div class="blogroll-catigories"><h1><?php echo $linkcat->name; ?></h1>
						<ul class="pagerolls">
							<?php 
								$bookmarks = get_bookmarks('orderby=date&category_name=' . $linkcat->name);
								if ( !empty($bookmarks) ) {
									foreach ($bookmarks as $bookmark) {
										$sitelink = $bookmark->link_url;
										$bsite = $sitelink{strlen($sitelink)-1} == '/' ? substr($sitelink, 0, -1) : $sitelink;
										$siteico = $bsite . '/favicon.ico';
										if(empty($bookmark->link_description)) $bookmark->link_description = '友情链接文字介绍未添加。';
										echo '<li><img width="16" height="16" src="' . $siteico . '" onerror="javascript:this.src=\'' . get_template_directory_uri() . '/images/links_default.ico\'"/><a href="' . $bookmark->link_url . '" title="' . $bookmark->link_name . '" target="_blank" >';
										echo $bookmark->link_name . '</a>';
										echo '<p>' . $bookmark->link_description . '</p></li>';
									}
								}
							?>
						</ul>
					</div>
				<?php endforeach; endif; ?>
			</div>
		</div>
		<?php comments_template(); ?>
	<?php endwhile; else: ?>
		<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
	<?php endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>