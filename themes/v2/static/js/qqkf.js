function  isphone(){
	if(/AppleWebKit.*Mobile/i.test(navigator.userAgent) || (/MIDP|SymbianOS|NOKIA|SAMSUNG|LG|NEC|TCL|Alcatel|BIRD|DBTEL|Dopod|PHILIPS|HAIER|LENOVO|MOT-|Nokia|SonyEricsson|SIE-|Amoi|ZTE/.test(navigator.userAgent))){
		if(window.location.href.indexOf("?mobile")<0){
			try{
				if(/Android|Windows Phone|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)){
					return true;
				}else if(/iPad/i.test(navigator.userAgent)){
				}else{
					//window.location.href="/wap/"
				}
			}catch(e){}
		}
	}
	return false;

}

function showPanel(){
	
var phmt= '<style>\
.kf_content{position:absolute;top:50%; left:50%; width:800px;height:285px;margin:-140px 0  0 -400px; color:#f00; z-index:999;background:url(/Public/images/kfbg.png?1) no-repeat} \
.kf_content:hover{ border-color:#00f;}\
.kf_content div{ position:relative;}\
.kf_content div img#cls{ position:absolute; width:20px; height:20px;  top:0px;right:0px; overflow:hidden; text-indent:-99px; cursor:pointer;}\
#kfpn{margin-top:130px;padding:10px;}\
#kfpn .ms{color:#0000FF;font-size:16px;text-align:center;height:40px;font-weight:bold}\
#kfpn li{float:left;height:28px;line-height:28px;width:95px;list-style-type:none;display:inline-block;}\
#kfpn li img{height:height:22px;width:77px;}\
#kfpn li span{display:inline-block;color:#fff;margin-left:5px;font-size:14px;}\
#kfpn li a{margin-top:0px;margin-right:2px;padding-left:12px;}\
#kfpn li span.sn{width:45px;display:block}\
#kfs{text-align: center;display:block;width:770px;}\
</style>\
<div class="kf_content" id="kf_content" ><div>\
<img id="cls" onClick="$(\'#kf_content\').hide();"  src="/Public/images/close.gif"/>\
</div>\
<div id = "kfpn">\
<div id="kfs">\
</div>\
</div>\
</div>';
$('body').append(phmt);
}
function showkf(){
	$('#kf_content').show();
}
$(function(){
if(!isphone())showPanel();
var kefuarr = fnLuanXu(roomconf.kefu);
var num =0;
num = Math.min(kefuarr.length,8);

var kfpnstr = '';
for(var i=0;i<num;i++){
var kefu = kefuarr[i];
kfpnstr +='<li> <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin='+kefu.qq+'&site=qq&menu=yes" onclick="qqbtclick('+kefu.qq+',\'middle\')"><img border="0" style="vertical-align:middle" src="/Public/images/qqjt.gif"  alt="'+kefu.qq+'" title="请加QQ：'+kefu.qq+'"/></a> </li>';
}

$("#kfs").html(kfpnstr);
$("#topqq").append("<a href=\"javascript:showkf();\" class=\"f_right\">[更多]</a>");
});
