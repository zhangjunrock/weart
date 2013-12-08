jQuery(document).ready(function($){
	$body=(window.opera)?(document.compatMode=="CSS1Compat"?$('html'):$('body')):$('html,body');//修复Opera滑动异常地，加过就不需要重复加了。
	$('.adminInfor, #qmenu').hover(function(){
		$(this).addClass('open');
	},function(){
		$(this).removeClass('open');
	});
	$(window).scroll(function(){
		var bodyHeight = $(document).height();
		var scrollTopHeight = $('#scrolltop').offset().top;
		var bottomHeight = bodyHeight - scrollTopHeight;
		if ( scrollTopHeight > 600) {
			$('#roll_top').css('display', 'block');
		} else {
			$('#roll_top').css('display', 'none');
			$animating = false;
		}
		
		if ( bottomHeight > 900) {
			$('#fall').css('display', 'block');
		} else {
			$('#fall').css('display', 'none');
			$animating = false;
		}
	});
	$('#roll_top').click(function(){$('html,body').animate({scrollTop: '0px'}, 800);}); 
	$('#ct').click(function(){$('html,body').animate({scrollTop:$('#comments').offset().top}, 800);});
	$('#fall').click(function(){$('html,body').animate({scrollTop:$('#footer').offset().top}, 800);});
	$('.hentry h2.title a').click(function(){$(this).text('页面载入中……');window.location = $(this).attr('href');});
	$('#headLogin').click(function(){$(this).parent().toggleClass('open');});
	$(document).click(function(){$('.signIn').removeClass('open');});
	$('#logo, .signIn').click(function(event){event.stopPropagation();});
	$("#slidebox").scrollFollow({bottomObj:'#footer',marginTop:0,marginBottom:0});
	$('.focus').find("a").mouseenter(function(){$('.focus').find("a").not($(this)).find("> img").stop().animate({opacity: 0.6}, 1000);});
	$('.focus').find("a").mouseleave(function(){$('.focus').find("a").find("> img").stop().animate({opacity: 1}, 1000);});
	$(".widget_picshow").picShow();
	$(".search").searchBar();
	$(".focus").focusShow();
});
$.fn.searchBar = function () {
    var obj = $(this);
    var str = obj.find("#s");
    obj.click(function(e) {
        if (obj.hasClass("fold")) {
            obj.removeClass("fold");
            e.stopPropagation();
            return false
        }
	})	
    str
		.keydown(function(e){
			if(e.keyCode == 13){
				iSearch.post();
			}
		})
}
var iSearch = {
    init: function(){
        var iSearchObj = $("#indexSearch"),
            iSpan     =  iSearchObj.find("span"),
            iTxt      =  $("#s"),
            spanHide  = function(){
                iSpan.hide();
                iTxt.focus();
            }
        iSpan.click(spanHide);
        iTxt.click(spanHide)
            .keydown(function(e){
                if(e.keyCode == 13){
                    iSearch.post();
                }
            })
        iTxt.val("");
    },
    post: function(){
        var itext = $("#s"), txt = itext.val();
        if (txt.length === 0 ){
            alert("请您输入内容！");
            itext.focus();
            return;
        }
		window.open( happyet_org.ajaxurl + "?s=" + txt);
    }
}
$.fn.picShow = function () {
    var obj = $(this);
    var item = obj.find("li");
    item.eq(0).addClass("current");
    item.mouseenter(function() {
        if (!$(this).hasClass("current")) {
            obj.find(".current").removeClass("current");
            $(this).addClass("current");
        }
    })
}
$.fn.focusShow = function () {
    var obj = $(this);
    //幻灯切换
    var topCol = obj.find(".topCol");
    var topItem = topCol.find("a");
    var topItemLength = topItem.length;
    var topNow = 0;
    var timer;
    var points = $("<ul></ul>");
    topCol.append(points);
    for (var i = 0; i < topItemLength; i++) {
        points.append("<li></li>")
    }
    var point = points.find("li");
    point.first().addClass("now");
    var scrollTop = function() {
        point.filter(".now").removeClass("now");
        point.eq(topNow).addClass("now");

        topItem.filter(":not(:eq(" + topNow + "))").fadeOut();
        topItem.eq(topNow).fadeIn();

        topNow++;
            if (topNow == topItemLength) {
            topNow = 0;
        }
        timer = setTimeout(scrollTop, 5000);
    }
    scrollTop();

    topCol
        .mouseenter(function () {
            points.hide();
            clearTimeout(timer);
        })
        .mouseleave(function () {
            points.show();
            timer = setTimeout(scrollTop, 2500);
        })
    //鼠标高亮
    var item = obj.find("a");
    item
        .each(function () {
            $(this).prepend("<em></em>")
        })
        .mouseenter(function () {
            var shadow = item.not($(this)).find("em");
            shadow.stop().animate({opacity: 0.4}, (0.4-shadow.css("opacity"))/0.4*500)
        })
        .mouseleave(function () {
            var shadow = item.not($(this)).find("em");
            item.find("em").stop().animate({opacity: 0}, (shadow.css("opacity"))/0.4*500)
        })
}
$.fn.extend({
	scrollFollow:function(d){
		d=d||{};
		d.container=d.container||$(this).parent();
		d.bottomObj=d.bottomObj||'';
		d.bottomMargin=d.bottomMargin||0;
		d.marginTop=d.marginTop||0;
		d.marginBottom=d.marginBottom||0;
		d.zindex=d.zindex||99;
		var e=$(window);
		var f=$(this);
		if(f.length<=0){
			return false
		}
		var g=f.position().top;
		var h=d.container.height();
		var i=f.css("position");
		if(d.bottomObj==''||$(d.bottomObj).length<=0){
			var j=false
		}else{
			var j=true
		}
		e.scroll(function(a){
			var b=f.height();
			if(f.css("position")==i){
				g=f.position().top
			}
			scrollTop=e.scrollTop();
			topPosition=Math.max(0,g-scrollTop);
			if(j==true){
				var c=$(d.bottomObj).position().top-d.marginBottom-d.marginTop;
				topPosition=Math.min(topPosition,(c-scrollTop)-b)
			}
			if(scrollTop>g){
				if(j==true&&(g+b>c)){
					f.css({position:i,top:g})
				}else{
					if(window.XMLHttpRequest){
						f.css({position:"fixed",top:topPosition+d.marginTop,'z-index':d.zindex})
					}else{
						f.css({position:"absolute",top:scrollTop+topPosition+d.marginTop+'px','z-index':d.zindex})
					}
				}
			}else{
				f.css({position:i,top:g})
			}
		});
		return this
	}
});
//TAB切换
function SwapTab(name,title,content,Sub,cur){
  $(name+' '+title).mouseover(function(){
	  $(this).addClass(cur).siblings().removeClass(cur);
	  $(content+" > "+Sub).eq($(name+' '+title).index(this)).show().siblings().hide();
  });
}
$(function(){
	new SwapTab(".SwapTab","span",".tab-content","ul","fb");//排行TAB
})
function addFavorite(url, title) {
	try {
		window.external.addFavorite(url, title);
	} catch (e){
		try {
			window.sidebar.addPanel(title, url, '');
        	} catch (e) {
			alert("请按 Ctrl+D 键添加到收藏夹");
		}
	}
}
function setHomepage(sURL) {
	if(navigator.userAgent.indexOf("MSIE")>0){
		document.body.style.behavior = 'url(#default#homepage)';
		document.body.setHomePage(sURL);
	} else {
		alert("非 IE 浏览器请手动将本站设为首页");
	}
}
//不支持placeholder浏览器下对placeholder进行处理
if(document.createElement('input').placeholder !== '') {
	$('head').append('<style>.placeholder{color: #aaa;}</style>');
	$('[placeholder]').focus(function() {
		var input = $(this);
		if(input.val() == input.attr('placeholder')) {
			input.val('');
			input.removeClass('placeholder');
		}
	}).blur(function() {
		var input = $(this);
		//密码框空
		if(this.type === 'password') {
			return false;
		}
		if(input.val() == '' || input.val() == input.attr('placeholder')) {
			input.addClass('placeholder');
			input.val(input.attr('placeholder'));
		}
	}).blur().parents('form').submit(function() {
		$(this).find('[placeholder]').each(function() {
			var input = $(this);
			if(input.val() == input.attr('placeholder')) {
				input.val('');
			}
		});
	});
}