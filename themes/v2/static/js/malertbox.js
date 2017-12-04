
var boxhtml = '<style>\
.malertbox{position: fixed;z-index:9999;top: 50%;left: 50%;margin: -90px 0 0 -150px;box-shadow: 1px 1px 3px #000;display:block;width:300px;height:180px;background-color: #fff;}\
.malertbox img#cls {position: absolute;width: 20px;height: 20px;top: 0px;right: 0px;overflow: hidden;text-indent: -99px;cursor: pointer;}\
.malertbox p{margin:20px;margin-top:30px;text-indent: 2em;color:#333;}\
.bts{position: absolute;width: 100%;height: 40px;bottom: 20px;right: 0px;overflow: hidden;}\
.bts a{display: block;height: 30px;width:50px;text-align:center;color:#fff;float: left;text-decoration: none;padding:0px 10px;line-height: 30px;margin-left:50px;}\
.bts a:hover{color: #ff0;}\
#reg{background-color: #a00;}\
#login{background-color: #0a0;}\
</style>\
<div class="malertbox" id="malertbox" style="display:none">\
	<div class="close"><img id="cls" onclick="document.getElementById(\'malertbox\').style.display = \'none\';" src="/Public/images/close.gif"></div>\
	<p id="alertmsg"></p>\
	<div class="bts"><a id="reg" href="/Member/register">娉ㄥ唽</a> <a id="login" href="/Member/login">鐧诲綍</a></div>\
</div>';

$(function(){
	$('body').append(boxhtml);
	if (self.frameElement && self.frameElement.tagName == "IFRAME") {
        $("#reg").attr('href','javascript:window.parent.showRegForm();');
    	$("#login").attr('href','javascript:window.parent.showLoginForm();');
	}
});

function malertbox(msg){
	$('#alertmsg').text(msg);
	$('#malertbox').show();
}