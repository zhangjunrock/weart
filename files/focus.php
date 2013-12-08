<div class="focus">
	<?php
	echo '<div class="col topCol" style="width:594px">';
	if(dopt('home_pic_show_mode')=='手动'){
		echo '<a href="' . dopt('diy_mode_link1') . '" target="_blank">';
		echo '<img src="' . dopt('diy_mode_img1') . '" alt="' . dopt('diy_mode_title1') . '" width="594" height="325" />';
		echo '<h3>' . dopt('diy_mode_title1') . '</h3></a>';
		echo '<a href="' . dopt('diy_mode_link2') . '" target="_blank">';
		echo '<img src="' . dopt('diy_mode_img2') . '" alt="' . dopt('diy_mode_title2') . '" width="594" height="325" />';
		echo '<h3>' . dopt('diy_mode_title2') . '</h3></a>';
		echo '<a href="' . dopt('diy_mode_link3') . '" target="_blank">';
		echo '<img src="' . dopt('diy_mode_img3') . '" alt="' . dopt('diy_mode_title3') . '" width="594" height="325" />';
		echo '<h3>' . dopt('diy_mode_title3') . '</h3></a>';
	}else{
		if(dopt('home_pic_show_mode')=='置顶'){
			$sticky = get_option( 'sticky_posts' );
			$args = array('posts_per_page' => 3, 'post__in'  => $sticky, 'ignore_sticky_posts' => 1);
		}elseif(dopt('home_pic_show_mode')=='指定'){
			$post_ids = explode(",", dopt('show_mode_id'));
			$args = array('post__in' => $post_ids );
		}
		$slidePosts = get_posts($args);
		foreach( $slidePosts as $post ) { setup_postdata($post);
			echo '<a href="' . get_permalink() . '" target="_blank">';
			post_thumbnail(594, 325);
			echo '<h3>' . get_the_title() . '</h3></a>';
		}
		wp_reset_postdata();
	}
	echo '</div>';
	if(dopt('home_right_show_mode')=='指定'){
		$right_posts_id = explode(",", dopt('right_show_id'));
		$args = array(
			'post__in' => $right_posts_id,
		);
		$Adposts = get_posts($args);
		for ($i = 0; $i < 2; $i++){
			if($i==1){
				echo '<div class="col">';
				$j=0;
				foreach ($Adposts as $post) { setup_postdata($post); $j++;?>
					<?php if($j==1){ ?>
					<a href="<?php the_permalink(); ?>" target="_blank" title="<?php the_title(); ?>" target="_blank">
						<?php post_thumbnail(173, 120);?>
						<span title="<?php the_title(); ?>">
							<?php post_thumbnail(179, 126);?>
						</span>
					</a>
					<?php } ?>
					<?php if($j==2){ ?>
					<a href="<?php the_permalink(); ?>" target="_blank" title="<?php the_title(); ?>" target="_blank">
						<?php post_thumbnail(173, 195);?>
						<span title="<?php the_title(); ?>">
							<?php post_thumbnail(179, 201);?>
						</span>
					</a>
					<?php }
					wp_reset_postdata();
				}
				echo '</div>';
			}else{
				echo '<div class="col">';
				$j=0;
				foreach ($Adposts as $post) { setup_postdata($post); $j++;?>
					<?php if($j==3){ ?>
					<a href="<?php the_permalink(); ?>" target="_blank" title="<?php the_title(); ?>" target="_blank">
						<?php post_thumbnail(173, 195);?>
						<span title="<?php the_title(); ?>">
							<?php post_thumbnail(179, 201);?>
						</span>
					</a>
					<?php } ?>
					<?php if($j==4){ ?>
					<a href="<?php the_permalink(); ?>" target="_blank" title="<?php the_title(); ?>" target="_blank">
						<?php post_thumbnail(173, 120);?>
						<span title="<?php the_title(); ?>">
							<?php post_thumbnail(179, 126);?>
						</span>
					</a>
					<?php }
					wp_reset_postdata();
				}
				echo '</div>';
			}	
		}
	}elseif(dopt('home_right_show_mode')=='手动'){
		echo '<div class="col">';
		echo '<a href="' . dopt('right_mode_link1') . '" target="_blank" title="' . dopt('right_mode_title1') . '">';
		echo '<img src="' . dopt('right_mode_img1') . '" alt="' . dopt('right_mode_title1') . '" width="173" height="195" />';
		echo '<span title="' . dopt('right_mode_title1') . '">';
		echo '<img src="' . dopt('right_mode_img1') . '" alt="' . dopt('right_mode_title1') . '" width="179" height="201" />';
		echo '</span></a>';
		echo '<a href="' . dopt('right_mode_link2') . '" target="_blank" title="' . dopt('right_mode_title2') . '">';
		echo '<img src="' . dopt('right_mode_img2') . '" alt="' . dopt('right_mode_title2') . '" width="173" height="120" />';
		echo '<span title="' . dopt('right_mode_title2') . '">';
		echo '<img src="' . dopt('right_mode_img2') . '" alt="' . dopt('right_mode_title2') . '" width="179" height="126" />';
		echo '</span></a>';
		echo '</div>';
		echo '<div class="col">';
		echo '<a href="' . dopt('right_mode_link3') . '" target="_blank" title="' . dopt('right_mode_title3') . '">';
		echo '<img src="' . dopt('right_mode_img3') . '" alt="' . dopt('right_mode_title3') . '" width="173" height="120" />';
		echo '<span title="' . dopt('right_mode_title3') . '">';
		echo '<img src="' . dopt('right_mode_img3') . '" alt="' . dopt('right_mode_title3') . '" width="179" height="126" />';
		echo '</span></a>';
		echo '<a href="' . dopt('right_mode_link4') . '" target="_blank" title="' . dopt('right_mode_title4') . '">';
		echo '<img src="' . dopt('right_mode_img4') . '" alt="' . dopt('right_mode_title4') . '" width="173" height="195" />';
		echo '<span title="' . dopt('right_mode_title4') . '">';
		echo '<img src="' . dopt('right_mode_img4') . '" alt="' . dopt('right_mode_title4') . '" width="179" height="201" />';
		echo '</span></a>';
		echo '</div>';
	} ?>
</div>