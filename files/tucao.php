<div class="tucao">
	<?php
		$tucao_id = dopt('tucao_page_id');
		$args = array('status' => 'approve', 'parent' => '0', 'number' => '1', 'post_id' => $tucao_id );
		$comments = get_comments($args);
		if (!empty($comments)) {
			foreach($comments as $comment) :
				$tuchao .= convert_smilies( '<a class="r" href="' . htmlspecialchars(get_comment_link( $comment->comment_ID )) . '">' . get_comment_date('Y-m-d',$comment->comment_ID) . '</a><span>' . $comment->comment_content . '</span>');
			endforeach;	
		}else{
			$tuchao ='博主还木有吐槽喔...';
		}
		echo $tuchao; 
	?>
</div>