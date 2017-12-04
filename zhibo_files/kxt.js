function showlayer(){	
var appendhtml= '<style type="text/css">\
.fixedlayer{ position:fixed; left:30px; bottom:40px;}\
.fixedlayer .close{  position:absolute; left:0px; top:0;  z-index:2; cursor:pointer;}\
</style>\
<div class="fixedlayer" id="fixedlayer">\
<span class="close" id="close"><img src="http://style.pme10.com/layer-erweima/images/x.png" width="18" height="18" onclick="$(\'#fixedlayer\').fadeOut()"></span>\
<span id="pica"> <a href="" target="_blank"><img src="http://style.pme10.com/layer-erweima/images/388.gif"></a></span>\
</div>';
$('body').append(appendhtml);
}
function filter(str){
	var hrefValue = window.location.href;
   return String(hrefValue).indexOf(str) >= 0;
}
$(function(){
	
	showlayer();
	if(filter("xhyzhibo")){
		
		$("#pica").html('<img src="http://style.pme10.com/layer-erweima/images/kxt.png">');
	}else if(filter("ytx")){
		
		$("#pica").html(' <a href="http://www.kxt.com/eia/ytx/" target="_blank"><img src="http://style.pme10.com/layer-erweima/images/388.gif"></a>');
	}else if(filter("oilzhibo")){
		$("#pica").html('<a href="http://www.kxt.com/eia/oil/" target="_blank"><img src="http://style.pme10.com/layer-erweima/images/388.gif"></a>');
	}else if(filter("shiyouzhibo")){
		$("#pica").html('<a href="http://www.kxt.com/eia/dysy/" target="_blank"><img src="http://style.pme10.com/layer-erweima/images/388.gif"></a>');
	}else if(filter("gaosheng")){
		$("#pica").html('<a href="http://www.kxt.com/eia/gs/" target="_blank"><img src="http://style.pme10.com/layer-erweima/images/388.gif"></a>');
	}
});