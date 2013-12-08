jQuery(document).ready(function($){
	var l = $(".comments-container"),
    y = happyet_org.postid,
    r = happyet_org.ajaxurl,
    z = '<div style="padding-top:20px;text-align:center;"><img src="' + r + 'wp-content/themes/miui/images/loading.gif"></div>';
	l.on("click", ".ccp a", function(b) {
        b.preventDefault();
        var b = $(this).attr("href"),
        c = 1;
        /comment-page-/i.test(b) ? c = b.split(/comment-page-/i)[1].split(/(\/|#|&).*$/)[0] : /cpage=/i.test(b) && (c = b.split(/cpage=/)[1].split(/(\/|#|&).*$/)[0]);
        $.ajax({
            url: r + "?action=AjaxCommentsPage&post=" + y + "&page=" + c,
            beforeSend: function() {
                l.html(z)
            },
            error: function(a) {
                alert(a.responseText)
            },
            success: function(b) {
                l.html(b);
                $("body, html").animate({
                    scrollTop: l.offset().top - 50
                },
                1E3)
            }
        })
    });
	l.on("click", ".tc-cp a", function(b) {
        b.preventDefault();
        var b = $(this).attr("href"),
        c = 1;
        /comment-page-/i.test(b) ? c = b.split(/comment-page-/i)[1].split(/(\/|#|&).*$/)[0] : /cpage=/i.test(b) && (c = b.split(/cpage=/)[1].split(/(\/|#|&).*$/)[0]);
        $.ajax({
            url: r + "?action=AjaxTcCommentsPage&post=" + y + "&page=" + c,
            beforeSend: function() {
                l.html(z)
            },
            error: function(a) {
                alert(a.responseText)
            },
            success: function(b) {
                l.html(b);
                $("body, html").animate({
                    scrollTop: l.offset().top - 50
                },
                1E3)
            }
        })
    });
	$(".tab-title").click(function() {
        var _this = $(this);
        if (!_this.hasClass("active")) {
            var _parent = _this.closest('.post-tabs'),
            _tab = _parent.children(".post-tabul").children(".tab-title"),
            _card = _parent.children(".post-card").children(".tab-panel"),
            _index = _tab.index(_this);
            _tab.removeClass("active");
            _this.addClass("active");
            _card.removeClass("active");
            _card.eq(_index).addClass("active")
        }
        return false
    });
});
function embedImage() {
  var URL = prompt('请输入图片 URL 地址:', 'http://');
  if (URL) {
    document.getElementById('comment').value = document.getElementById('comment').value + '[img]' + URL + '[/img]';
  }
}