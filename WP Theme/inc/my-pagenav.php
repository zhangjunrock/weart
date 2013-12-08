<?php
//分页导航
function par_pagenavi( $before = '', $after = '', $p = 1 ) {   
	if ( is_singular() ) return;
	global $wp_query, $paged;
	$max_page = $wp_query->max_num_pages;   
	if ( $max_page == 1 ) return;
	if ( empty( $paged ) ) $paged = 1;
	echo $before;   
	if ( $paged > 1 ) p_link( $paged - 1, '上一页', ' < ' );
	if ( $paged > $p + 1 ) p_link( 1, '最前一页' );   
	if ( $paged > $p + 2 ) echo '<span class="disable">...</span>';   
	for( $i = $paged - $p; $i <= $paged + $p; $i++ ) {
		if ( $i > 0 && $i <= $max_page ) $i == $paged ? print "<span class='current'>{$i}</span>" : p_link( $i );
	}   
	if ( $paged < $max_page - $p - 1 ) echo '<span class="disable">...</span>';
	if ( $paged < $max_page - $p ) p_link( $max_page, '最后一页' );   
	if ( $paged < $max_page ) p_link( $paged + 1,'下一页', ' > ' );
	echo $after;
}   
function p_link( $i, $title = '', $linktype = '' ) {
	if ( $title == '' ) $title = "第{$i}页";
	if ( $linktype == '' ) { 
		$linktext = $i;
	} else { 
		$linktext = $linktype; 
	}
	echo "<a href='", esc_html( get_pagenum_link( $i ) ), "#news' title='{$title}'>{$linktext}</a>";   
}
?>