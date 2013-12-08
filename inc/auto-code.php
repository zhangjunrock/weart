<?php
//代码自动转换
function escapeCE($arr) {
	if (version_compare(PHP_VERSION, '5.2.3') >= 0) { //所需PHP版本 
		$output = htmlspecialchars($arr[2], ENT_NOQUOTES, get_bloginfo('charset'), false); 
	}else {
		$needTo = array( //定义需要转换的标签 
		'&' => '&amp;',
		'<' => '&lt;',
		'>' => '&gt;'
		);
		$data = htmlspecialchars_decode($arr[2]);
		$output = strtr($data, $needTo);
	}
	if (! empty($output)) { //如果有实体符号则进行替换 
		return  $arr[1] . $output . $arr[3];
	}else{
		return  $arr[1] . $arr[2] . $arr[3];
	}
}
function replaceCE($data) { //匹配需要转换实体的标签 
	$replaceTag = preg_replace_callback('@(<pre.*>)(.*)(<\/pre>)@isU', 'escapeCE', $data);
	$replaceTag = preg_replace_callback('@(<code.*>)(.*)(<\/code>)@isU', 'escapeCE', $replaceTag);
	return $replaceTag;
}
add_filter( 'content_save_pre', 'replaceCE', 9 ); //通过wordpress的add_filter来挂钩 
add_filter( 'excerpt_save_pre', 'replaceCE', 9 ); //支持摘要格式 
add_filter( 'preprocess_comment', 'replaceCE', 9 );
?>