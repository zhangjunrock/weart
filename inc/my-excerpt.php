<?php
if ( !function_exists('mb_strlen') ) {
	function mb_strlen ($text, $encode) {
		if ($encode=='UTF-8') {
			return preg_match_all('%(?:
					  [\x09\x0A\x0D\x20-\x7E]           # ASCII
					| [\xC2-\xDF][\x80-\xBF]            # non-overlong 2-byte
					|  \xE0[\xA0-\xBF][\x80-\xBF]       # excluding overlongs
					| [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2} # straight 3-byte
					|  \xED[\x80-\x9F][\x80-\xBF]       # excluding surrogates
					|  \xF0[\x90-\xBF][\x80-\xBF]{2}    # planes 1-3
					| [\xF1-\xF3][\x80-\xBF]{3}         # planes 4-15
					|  \xF4[\x80-\x8F][\x80-\xBF]{2}    # plane 16
					)%xs',$text,$out);
		}else{
			return strlen($text);
		}
	}
}
if (!function_exists('mb_substr')) {
    function mb_substr($str, $start, $len = '', $encoding="UTF-8"){
        $limit = strlen($str);
        for ($s = 0; $start > 0;--$start) {// found the real start
            if ($s >= $limit)
                break;
            if ($str[$s] <= "\x7F")
                ++$s;
            else {
                ++$s; // skip length
                while ($str[$s] >= "\x80" && $str[$s] <= "\xBF")
                    ++$s;
            }
        }
        if ($len == '')
            return substr($str, $s);
        else
            for ($e = $s; $len > 0; --$len) {//found the real end
                if ($e >= $limit)
                    break;
                if ($str[$e] <= "\x7F")
                    ++$e;
                else {
                    ++$e;//skip length
                    while ($str[$e] >= "\x80" && $str[$e] <= "\xBF" && $e < $limit)
                        ++$e;
                }
            }
        return substr($str, $s, $e - $s);
    }
}

function wp_new_excerpt($text){
	global $post;
	$text = $post->post_excerpt;
	if ($text == ''){
		$text = $post->post_content;
		$text = strip_shortcodes($text);
		$text = str_replace(']]>', ']]&gt;', $text);

		$length = dopt('excerpt_length');
		$allowed_tag = dopt('allowed_tag');
		if(($length > mb_strlen(strip_tags($text), 'utf-8'))) {
			if(empty($allowed_tag)){
				$text = strip_tags($text);
				$text = preg_replace('/\s\s+/', " ", $text);
			}else{
				$text = strip_tags($text, $allowed_tag);
			}
			return $text;
		}else{
			$num = 0;
			$in_tag = false;
			for ($i=0; $num<$length || $in_tag; $i++) {
				if(mb_substr($text, $i, 1) == '<') $in_tag = true;
				elseif(mb_substr($text, $i, 1) == '>') $in_tag = false;
				elseif(!$in_tag) $num++;
			}
			$text = mb_substr ($text,0,$i,'utf-8');
			if(empty($allowed_tag)){
				$text = strip_tags($text);
				$text = preg_replace('/\s\s+/', " ", $text);
			}else{
				$text = strip_tags($text, $allowed_tag);
			}
		}
		$text = trim($text);
		$text = force_balance_tags($text);
		if(dopt('use_more_link')) $text = excerpt_readmore ($text);
		return $text;
	}
	return $text;
}
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'wp_new_excerpt');
function excerpt_readmore ($text) {
	if(dopt('read_more_link')){$read_more_link = dopt('read_more_link');}else{$read_more_link = 'Read More';}
	$text .=' ... ';
	$text .= '<a href="'.get_permalink().'" class="read-more">'.$read_more_link.'</a>';
	return $text;
}
?>