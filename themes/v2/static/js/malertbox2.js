
function malertbox2(minute){
var boxhtml1 = '\
<div style="margin-top:20px">\
	<p id="alertmsg">您已在直播室收听'+minute+'分钟，赶紧领取会员或VIP马甲，点击下方注册会员或联系上方QQ在线客服，即刻享受更多优质服务。</p>\
	<div class="bts"><a id="reg" href="#">注册</a> <a id="login" href="#">登录</a></div>\
</div>';
		
		if(!isPhone && login_type == 1){
			TINY.box.show({html:boxhtml1 ,width:420,height:160,openjs:function(){
				$('.tcontent').before('<h5 class="alert_title">提示信息</h5>');
				$("#reg").attr('href','javascript:showRegForm();');
    			$("#login").attr('href','javascript:showLoginForm();');

    			$('.tbox').addClass('malert');
				$('.tclose').click(function(){
	    			$('.tbox').removeClass('malert');
				});
			}});

		}
	}

function malert_showRegForm(){
	showRegForm();
	$('.tbox').removeClass('malert');

}
function malert_showLoginForm(){
	showLoginForm();
	$('.tbox').removeClass('malert');
	
}


$(function(){
	if(!isPhone && login_type == 1){
	$('body').append('<style>\
.malert .bts{position: absolute;width: 100%;height: 40px;bottom:0px;overflow: hidden;}\
.malert .bts a{display: block;height: 32px;width:68px;text-align:center;color:#fff;float: left;text-decoration: none;padding:0px 10px;line-height: 32px;margin-left:85px;font-size:16px;}\
.malert .bts a:hover{color: #ff0;}\
.malert #reg{background:#C73C34; border-radius:2px; box-shadow:0 0 2px #555;}\
.malert #login{background:#619958; border-radius:2px; box-shadow:0 0 2px #555;}\
.malert #alertmsg{text-indent:2em; color:#666;font-size:16px; line-height:30px;text-shadow:3px 3px 2px #ddd; padding-top:8px;}\
.malert .tinner{border:4px solid #AAA; position:relative; background-color:#F5F6F8;}\
.alert_title{display:none;width:0;height:0;}\
.malert .alert_title{width:100%; height:30px; line-height:30px; background-color:#eee; border-bottom:1px solid #DDD; color:#666; text-align:center; position:absolute; left:0; top:0px; font-size:16px;display:block }\
.malert .tclose{top:-11px; right:-14px;}\
</style>');

		setTimeout('malertbox2(5)',5*60*1000);
		setTimeout('malertbox2(30)',30*60*1000);
	}
});