$(function(){
	 
    
	$("#content").height($(window).height()-90);
	$("#contentRight").width($(document).width()-$("#contentLeft").width());	
	$(".drop-nav-list li:last-child").css({"background":"none;","padding-right":"0","margin-right":"0"}) 
 	if($(document).width()<1240){
		$("#video_player embed").height(250)}

	if($(window).height()<960){
	$("#rightTabContent").find(".tabContent").height($(window).height()-$("#videoShowContent").height()-180)
	}
	
	if($(document).width()>=1440){	
		 $("#rightMenu").width($("#videoShow").width())
		 }
		 
	 $("#postAreatext").width($(".talkPost").width()-60)
	 $(".speakText").width($(".talkList").width()-160); 
	 $(".talkList").height( $("#content").height()-235);
	 $(".visitorList").height($(".talkList").height()+30)
	 $(".visitorList ul").height( $(".visitorList").height())
	 $(".peopleNumber").height($(".talkPost").height()+6)
	 var peopleNumberH=$(".peopleNumber").height()
	 $(".peopleNumber").css({"line-height":peopleNumberH+"px"})
	$(".visitorList .arrow").click(function(){
		 $("#contentLeft").animate({"marginLeft":"-25%"});
		 $("#contentRight").css({"margin-left":"0","width":"100%"})
		 $(".speakText").width($(".talkList").width()-160); 		 
		 $("#postAreatext").width($(".talkPost").width()-60)
		$(".arrowOn").show()
		$(".visitorList .arrow").hide()
		})
		
	$(".visitorList .arrowOn").click(function(){
		$("#contentLeft").animate({"marginLeft":"0"})
       $(".speakText").width($(".talkList").width()-160);
		  $("#contentRight").css({"margin-left":"25%","width":"auto"})
		   $("#postAreatext").width($(".talkPost").width()-60)
		   
		    $(".speakText").width($(".talkList").width()-160);
		$(this).hide()
		$(".visitorList .arrow").show()
		})	
		
		
	$(".tab1 a").click(function(){
		$(this).addClass("on").siblings().removeClass("on")
		})
		
	$(".tab3 a").click(function(){
		$(this).addClass("on").siblings().removeClass("on");
		var tabdata=$(this).attr("data-role");
		 
		$(".tabdata").hide();
		$(".tabdata[data-role='"+tabdata+"']").show();
	});
		
	})
	
	
//下拉菜单	
          
 var timeout         = 500;
var closetimer		= 0;
var ddmenuitem      = 0;

function jsddm_open()
{	jsddm_canceltimer();
	jsddm_close();
	ddmenuitem = $(this).find('ul').eq(0).css('display', 'block');
	$(this).addClass("on")
	}

function jsddm_close()
{	if(ddmenuitem){ ddmenuitem.css('display', 'none');
$('.top  .drop').removeClass("on")}}

function jsddm_timer()
{	closetimer = window.setTimeout(jsddm_close, timeout);}

function jsddm_canceltimer()
{	if(closetimer)
	{	window.clearTimeout(closetimer);
		closetimer = null;}}
		
		$(document).ready(function()
{	$('#NavList').bind('mouseover', jsddm_open);
	$('#NavList').bind('mouseout',  jsddm_timer);});

document.onclick = jsddm_close;

