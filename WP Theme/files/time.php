<div class="time">
<script type="text/javascript">
today=new Date();
var day; var date; var hello;
hour=new Date().getHours()
if(hour < 6)hello='  凌晨好! '
else if(hour < 9)hello=' 早上好! '
else if(hour < 12)hello=' 上午好! '
else if(hour < 14)hello=' 中午好! '
else if(hour < 17)hello=' 下午好! '
else if(hour < 19)hello=' 傍晚好! '
else if(hour < 22)hello=' 晚上好! '
else {hello='夜深了! '}
var webUrl = webUrl;
document.write(' '+hello);
</script>
<?php
	global $user_identity,$user_level;
	get_currentuserinfo();
	if ($user_identity) { ?><?php echo $user_identity; ?>,  
	<?php } elseif ( $comment_author != "" ) { ?>
	<?php printf('%s 欢迎回来.', $comment_author) ?>
	<?php } else { ?> 朋友, 
<?php } ?>现在时间 : 
<span id=localtime>
<script type="text/javascript">
function showLocale(objD)
{
var str,colorhead,colorfoot;
var yy = objD.getYear();
if(yy<1900) yy = yy+1900;
var MM = objD.getMonth()+1;
if(MM<10) MM = '0' + MM;
var dd = objD.getDate();
if(dd<10) dd = '0' + dd;
var hh = objD.getHours();
if(hh<10) hh = '0' + hh;
var mm = objD.getMinutes();
if(mm<10) mm = '0' + mm;
var ss = objD.getSeconds();
if(ss<10) ss = '0' + ss;
var ww = objD.getDay();
if ( ww==0 ) colorhead="<font color=\"#000\">";
if ( ww > 0 && ww < 6 ) colorhead="<font color=\"#000\">";
if ( ww==6 ) colorhead="<font color=\"#000\">";
if (ww==0) ww="星期日";
if (ww==1) ww="星期一";
if (ww==2) ww="星期二";
if (ww==3) ww="星期三";
if (ww==4) ww="星期四";
if (ww==5) ww="星期五";
if (ww==6) ww="星期六";
colorfoot="</font>"
str = colorhead + yy + "年" + MM + "月" + dd + "日 " + hh + ":" + mm + ":" + ss + " " + ww + colorfoot;
return(str);
}
function tick()
{
var today;
today = new Date();
document.getElementById("localtime").innerHTML = showLocale(today);
window.setTimeout("tick()", 1000);
}
tick();
</script>
</span> 
</div>