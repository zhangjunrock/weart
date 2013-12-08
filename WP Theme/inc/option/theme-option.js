jQuery(document).ready(function($) {
	//tab tit
	$('.d_mainbox:eq(0)').show();
	$('.d_tab ul li').each(function(i) {
		$(this).click(function(){
			$(this).addClass('d_tab_on').siblings().removeClass('d_tab_on');
			$($('.d_mainbox')[i]).show().siblings('.d_mainbox').hide();
		})
	});
	//ad preview
	$('.d_mainbox:last .d_tarea').each(function(i) {
		$(this).bind('keyup',function(){
			$(this).next().html( $(this).val() );
		}).bind('change',function(){
			$(this).next().html( $(this).val() );
		}).bind('click',function(){
			$(this).next().html( $(this).val() );
			if( $(this).next().attr('class') != 'd_adviewcon' ){
				$(this).after('<div class="d_adviewcon">' + $(this).val() + '</div>');
			}else{
				$(this).next().slideDown();
			}
		})
		
	});
	$('#showcategoryId h5').click(function(){
		if($(this).next().is(':visible')){
			$(this).next().hide();
		}else{
			$(this).next().show();
		}
	});
})
if ( typeof QTags != 'undefined' ){
	QTags.addButton( 'h1', 'h1', "\n<h1>", "</h1>\n" );
	QTags.addButton( 'h2', 'h2', "\n<h2>", "</h2>\n" );
	QTags.addButton( 'h3', 'h3', "\n<h3>", "</h3>\n" );
	QTags.addButton( 'h4', 'h4', "\n<h4>", "</h4>\n" );
	QTags.addButton( 'h5', 'h5', "\n<h5>", "</h5>\n" );
	QTags.addButton( 'pre', 'pre', "\n<pre>", "</pre>\n" );
	QTags.addButton( 'span', 'span', "\n[sp]", "[/sp]\n" );
	QTags.addButton( 'task', 'task', "\n[task]蓝色项目面板", "[/task]\n" );
	QTags.addButton( 'noway', 'noway', "\n[noway]红色禁止面板", "[/noway]\n" );
	QTags.addButton( 'warning', 'warn', "\n[warning]黄色警告面板", "[/warning]\n" );
	QTags.addButton( 'buy', 'buy', "\n[buy]绿色购买面板", "[/buy]\n" );
	QTags.addButton( 'hide', 'hide', '\n[hide]', '[/hide]\n');
	QTags.addButton( 'Down', 'downlink', "\n[Downlink href='下载链接' downtxt='点此下载：']", "[/Downlink]\n" );
	QTags.addButton( 'mp3', 'mp3', "\n[mp3]", "[/mp3]\n" );
	QTags.addButton( 'flv', 'flv', "\n[flv]", "[/flv]\n" );
	QTags.addButton( 'embed', 'embed', "\n[embed]", "[/embed]\n" );
	QTags.addButton( 'tab', 'tab', "\n[tabs]\n[tab title='tab标题' active='y']tab内容[/tab]\n[tab title='tab标题2']tab内容2[/tab]\n", "[/tabs]\n" );
	QTags.addButton( 'next', '分页', "\n<!--nextpage-->\n", "" );
	QTags.addButton( 'sm1', '嘿', ' :mrgreen: ', ''); 
	QTags.addButton( 'sm2', '色', ' :razz: ',  ''); 
	QTags.addButton( 'sm3', '悲', ' :sad: ',  ''); 
	QTags.addButton( 'sm4', '笑', ' :smile: ',  ''); 
	QTags.addButton( 'sm5', '惊', ' :oops: ',  ''); 
	QTags.addButton( 'sm6', '亲', ' :grin: ',  ''); 
	QTags.addButton( 'sm7', '雷', ' :eek: ',  ''); 
	QTags.addButton( 'sm8', '晕', ' :???: ',  ''); 
	QTags.addButton( 'sm9', '酷', ' :cool: ',  ''); 
	QTags.addButton( 'sm10', '奸', ' :lol: ',  ''); 
	QTags.addButton( 'sm11', '怒', ' :mad: ',  ''); 
	QTags.addButton( 'sm12', '狂', ' :twisted: ',  ''); 
	QTags.addButton( 'sm13', '萌', ' :roll: ',  ''); 
	QTags.addButton( 'sm14', '吃', ' :wink: ',  ''); 
	QTags.addButton( 'sm15', '贪', ' :idea: ',  ''); 
	QTags.addButton( 'sm16', '囧', ' :arrow: ',  ''); 
	QTags.addButton( 'sm17', '羞', ' :neutral: ',  ''); 
	QTags.addButton( 'sm18', '哭', ' :cry: ',  ''); 
	QTags.addButton( 'sm19', '汗', ' :?: ',  ''); 
	QTags.addButton( 'sm20', '宅', ' :evil: ',  ''); 
	QTags.addButton( 'sm21', '馋', ' :shock: ',  ''); 
	QTags.addButton( 'sm22', '槑', ' :!: ',  '');
}