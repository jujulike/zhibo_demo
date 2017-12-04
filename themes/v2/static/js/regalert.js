
function showraPanel(){
	
var phmt= '<style>\
.input_area input{font-size:26px;}\
.ra_content{display:none;position:absolute;top:50%; left:50%; width:520px;height:160px;margin:-120px 0  0 -260px; color:#f00; z-index:999;background:url(/Public/images/kfbg.jpg?2) 0px  -270px  no-repeat} \
.ra_content:hover{ border-color:#00f;}\
.ra_content div{ position:relative;}\
.ra_content div img#cls{ position:absolute; width:20px; height:20px;  top:0px;right:0px; overflow:hidden; text-indent:-99px; cursor:pointer;}\
#ra_kfpn{margin-top:40px;padding:10px;color:#fff;}\
#ra_kfpn .ms{color:#0000FF;font-size:16px;text-align:center;height:40px;font-weight:bold}\
#ra_kfpn li{float:left;height:28px;line-height:28px;width:95px;list-style-type:none;display:inline-block;}\
#ra_kfpn li img{height:height:22px;width:77px;}\
#ra_kfpn li span{display:inline-block;color:#fff;margin-left:5px;font-size:14px;}\
#ra_kfpn li a{margin-top:0px;margin-right:2px;padding-left:12px;}\
#ra_kfpn li span.sn{width:45px;display:block}\
#ra_kfpn p{margin-bottom:30px;font-size:20px;padding-left:10px;}\
#ra_kfs{text-align: center;display:block;width:540px;}\
</style>\
<div class="ra_content" id="ra_content" ><div>\
<img id="cls" onClick="$(\'#ra_content\').hide();"  src="/Public/images/close.gif"/>\
</div>\
<div id = "ra_kfpn">\
<p>请联系在线QQ客服，免费领取体验帐号。</p>\
<div id="ra_kfs">\
</div>\
</div>\
</div>';

$('body').append(phmt);
}
function showrakf(){
	$('#ra_content').show();
}
$(function(){
showraPanel();
var kefuarr = fnLuanXu(roomconf.kefu);
var num =0;
num = Math.min(kefuarr.length,5);

var ra_kfpnstr = '';
for(var i=0;i<num;i++){
var kefu = kefuarr[i];
ra_kfpnstr +='<li> <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin='+kefu.qq+'&site=qq&menu=yes"><img border="0" style="vertical-align:middle" src="http://wpa.qq.com/pa?p=2:'+kefu.qq+':41"  alt="'+kefu.qq+'" title="请加QQ：'+kefu.qq+'"/></a> </li>';
}

$("#ra_kfs").html(ra_kfpnstr);
});
