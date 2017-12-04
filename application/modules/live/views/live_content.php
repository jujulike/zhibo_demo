
<script type="text/javascript">
$(document).ready(function (){
	$(".tab").find("a").click(function()
	{
		$("#category option[value='']").attr("selected",true);
		$("#seehot").attr("checked",false);
		$(".article_content").show();
		tabshow(this);

		// 2014-05-16 begin:
		if ($(this).attr('rel') == 'chat')
		{
			$("#liveformdiv").hide();
			$("#chatformdiv").show();
		}
		else
		{
			$("#liveformdiv").show();
			$("#chatformdiv").hide();
		}

		if ($(this).attr('rel') == 'live')
		{
			$("#live_title").show();
			$("#other_title").hide();
		}
		else
		{
			$("#live_title").hide();
			$("#other_title").show();
		}

		// end;
	});

	
	
	$("#category").change(function(){
		
		if ($("#seehot").attr("checked") == 'checked')
		{
			if ($(this).val() != '')
			{
				$(".article_content").hide(); 
				$(".article").filter(".article_content").filter(".hot_1").filter(".cate_"+$(this).val()).show();					 
			}
			else
			{
			 	$(".article").filter(".article_content").filter(".hot_1").show();
			}
			
		}
		else
		{
			if ($(this).val() != '')
			{
				 $(".article_content").hide(); 
				$(".cate_"+$(this).val()).show();					 
			}
			else
			{
			 	$(".article_content").show();			
			}
			
		}			
			
		});
		
	$("#seehot").click(function(){
		if ($("#category").val() != '')
		{
			if ($("#seehot").attr("checked") == 'checked')
			{
				$(".hot_0").hide();
				$(".article").filter(".article_content").filter(".hot_1").filter(".cate_"+$("#category").val()).show();
			}
			else
			{
				$(".article").filter(".article_content").filter(".hot_0").filter(".cate_"+$("#category").val()).show();
				$(".article").filter(".article_content").filter(".hot_1").filter(".cate_"+$("#category").val()).show();
			}
		}
		else
		{
			if ($("#seehot").attr("checked") == 'checked')
			{
				$(".hot_0").hide();
			}
			else
			{
				$(".hot_0").show();
				$(".hot_1").show();
			}
		}
		//$(".article_content").hide(); 
		
		
	});
})

<?php 
if (($u['role'] == '-1') && ($cfg['visitor_viewlive'] == '0')){} else { ?>
	//var contenttime = setInterval(contentflash, 3000);
<?php } ?>
//var qatime = setInterval(qaflash, 5000);
//var viptime = setInterval(vipflash, 5000);
//var myqatime = setInterval(myqaflash, 5000);

var _timeobj;
var _titleflashtime = 3000;
var _title = document.title;

var contenttime; 
var qatime;
var myqatime;
var chattime;

chattime = setInterval(chatflash, 3000);

function SetRemainTime(titletip){
	if (_titleflashtime > 0) { 
		_titleflashtime = _titleflashtime - 500; 
		var second = Math.floor(_titleflashtime);             // 计算秒     
		if (second % 200 == 0) { 
			document.title = '【'+titletip+'】' + _title;
		} 
		else { 
			document.title = _title ;
		}; 
	} else {
		window.clearInterval(_timeobj); 
		document.title = _title;
		_titleflashtime = 3000;
	}
}

function setTitleTip(s)
{
	window.clearInterval(_timeobj); 	
	SetRemainTime();
	_timeobj = window.setInterval(_tempTip(s), 1000);	
}

function _tempTip(_s){
   return function(){
		 SetRemainTime(_s);
	}
}


function tabshow(e)
{
	if ($(e).attr("rel") != 'vip')
	{
		$(".tab").find("a").removeClass("cur");
		$(e).addClass("cur");
		$("#livecontent").find(".messagelist").hide();
		$("#" + $(e).attr("rel")).show();
	}
		
	$("#viptab").addClass("cur");
	$("#vip").show();	
	document.getElementById($(e).attr("rel")).scrollTop=document.getElementById($(e).attr("rel")).scrollHeight;

	if ($(e).attr("rel") == 'live')
	{
		$("#qacate").val("3");

		window.clearInterval(chattime);
		window.clearInterval(qatime);
		window.clearInterval(contenttime);
		window.clearInterval(myqatime);
		contenttime = setInterval(contentflash, 4000);
	}
	else if($(e).attr("rel") == 'chat')
	{
//		$("#qacate").val("2");
		
		window.clearInterval(qatime);
		window.clearInterval(contenttime);
		window.clearInterval(myqatime);
		window.clearInterval(chattime);
		chattime = setInterval(chatflash, 3000);
	}
	else if($(e).attr("rel") == 'qa')
	{
		$("#qacate").val("1");
		window.clearInterval(chattime);
		window.clearInterval(qatime);
		window.clearInterval(contenttime);
		window.clearInterval(myqatime);

		<?php if (($u['role'] == '-1') && ($cfg['visitor_viewqa'] == '0')){} else { ?>
			qatime = setInterval(qaflash, 3000);
		<?php } ?>
	
	}
	else if($(e).attr("rel") == 'myqa')
	{
		$("#qacate").val("2");
		window.clearInterval(chattime);
		window.clearInterval(qatime);
		window.clearInterval(contenttime);
		window.clearInterval(myqatime);
	
		<?php if (($u['role'] == '-1') && ($cfg['visitor_viewqa'] == '0')){} else { ?>
				myqatime = setInterval(myqaflash, 5000);
		<?php } ?>
	}
	
}


function chatflash()
{
	$.ajax({url:'<?php echo site_url("module/live/chat/getitem") ?>'+'/'+ $("#masterid").val() +'/' + $("#lastchatid").val() + '?t=' + new Date().getTime(),
		 type: "GET",
		ifModified:true,
		success: function(d){
			$("#chat").append(d);
			document.getElementById("chat").scrollTop=document.getElementById("chat").scrollHeight;
		}
	});
}



function contentflash()
{
	//alert($("#lastcontentid").val());
	$.ajax({url:'<?php echo site_url("module/live/content/appLiveContent") ?>'+'/' + $("#masterid").val() + '/' + $("#lastcontentid").val() + '/' + $("#category").val() + '/' + $("#hot").val() + '?t=' + new Date().getTime(),
		 type: "GET",
		ifModified:true,
		async: false,
		success: function(d){
//			alert($(".top_1", d).context); 
			if ($(d).hasClass("top_1"))
			{
				$("#livetop").after(d);
			}
			else
				$("#live").append(d);

			if ($.trim(d) != '')
			{
					 $('#notice_wav').remove(); 
                     $('body').append('<embed id="notice_wav" src="<?php echo base_url("themes/notice.wav")?>" autostart="true" hidden="true" loop="false">');
					document.getElementById("live").scrollTop=document.getElementById("live").scrollHeight;
					setTitleTip("新内容");
//					$('title').text(d);
			}
		}
	});
}

/*function vipflash()
{
	$.ajax({url:'<?php echo site_url("module/live/content/appVipContent") ?>'+'/'+ $("#roomid").val() +'/' + $("#masterid").val() + '/' + $("#lastvipid").val() + '?t=' + new Date().getTime(),
		 type: "GET",
		ifModified:true,
		async: false,
		success: function(d){
			if ($(d).hasClass("top_1"))
			{
				$("#viptop").after(d);
			}
			else
				$("#vip").append(d);

			if ($.trim(d) != '')
			{
				document.getElementById("vip").scrollTop=document.getElementById("vip").scrollHeight;
				setTitleTip("VIP新内容");
			}
		}
	});
}*/

function qaflash()
{
	$.ajax({url:'<?php echo site_url("module/live/content/getQuestions") ?>'+'/'+ $("#roomid").val() +'/' + $("#masterid").val() + '/' + $("#lastquestionid").val() + '?t=' + new Date().getTime(),
		 type: "GET",
		ifModified:true,
		async: false,
		success: function(d){
			$("#qa").html(d);
			/*
			if ($.trim(d) != '')
			{
				$('#qanotice_wav').remove(); 
                $('body').append('<embed id="qanotice_wav" src="<?php echo base_url("themes/qanotice.wav")?>" autostart="true" hidden="true" loop="false">');

				document.getElementById("qa").scrollTop=document.getElementById("qa").scrollHeight;
				setTitleTip("新问题");
			}
			*/
		}
	});
}

function myqaflash()
{
	$.ajax({url:'<?php echo site_url("module/live/content/getMyQuestions") ?>'+'/'+ $("#roomid").val() +'/' + $("#masterid").val() + '/' + $("#lastmyquestionid").val() + '?t=' + new Date().getTime(),
		 type: "GET",
		ifModified:true,
		async: false,
		success: function(d){
			$("#myqa").html(d);
		/*
			$("#myqa").append(d);
			if ($.trim(d) != '')
			{
				$('#myqanotice_wav').remove(); 
                $('body').append('<embed id="myqanotice_wav" src="<?php echo base_url("themes/qanotice.wav")?>" autostart="true" hidden="true" loop="false">');
				document.getElementById("myqa").scrollTop=document.getElementById("myqa").scrollHeight;				
				setTitleTip("我的问题");
			}
		*/
		}
	});
}



function sendquestion()
{
	var posttime;

	if ($("#nextsend").val() != '')
	{
		if (parseInt(Date.parse(new Date()).toString().substring(0,10)) < parseInt($("#nextsend").val()))
		{
			$.jBox.tip('请在1分种后再提问','info');
			return false;
		}
	}

	postdata('contentsubmit', "<?php echo site_url('live/setQuestion')?>", "retquestion");
}


function retquestion(d)
{
	if(d.code == '1'){
		$("#questionlasttime").val(d.lasttime);
		$.jBox.tip(d.msg, 'success');
		$("#nextsend").val(parseInt(Date.parse(new Date()).toString().substring(0,10)) + 60);
		$("#content").val('');
		var qacate = $("qacate").val();
		if (qacate == '1')
		{
			tabshow($(".tab").find("a[rel='qa']"));
		}
		else
		{
			tabshow($(".tab").find("a[rel='myqa']"));
		}
		
	}else{
		$.jBox.tip(d.msg,'error');
	}
}

function appVip(roomid)
{
	$.jBox("iframe:<?php echo site_url('live/appVip');?>"+'/'+roomid, {title: "申请VIP",iframeScrolling: 'no',height: 500,width: 450,buttons: { '关闭': true }});
}


function DrawImage(ImgD,iwidth,iheight){
    //参数(图片,允许的宽度,允许的高度)
    var image=new Image();
    image.src=ImgD.src;
    if(image.width>0 && image.height>0){
    if(image.width/image.height>= iwidth/iheight){
        if(image.width>iwidth){  
        ImgD.width=iwidth;
        ImgD.height=(image.height*iwidth)/image.width;
        }else{
        ImgD.width=image.width;  
        ImgD.height=image.height;
        }
        ImgD.alt=image.width+"×"+image.height;
        }
    else{
        if(image.height>iheight){  
        ImgD.height=iheight;
        ImgD.width=(image.width*iheight)/image.height;        
        }else{
        ImgD.width=image.width;  
        ImgD.height=image.height;
        }
        ImgD.alt=image.width+"×"+image.height;
        }
    }
}

function preview_image(e)
{
	var image = $(e).attr('src');
	$("#previewimage").html('<img src="'+image+'" />');
	$.layer({
		type : 1,
		title : false,
		fix : false,
		shadeClose: true,
		offset:['0px' , '0px'],
		area : ['auto','auto'],
		page : {dom : '#previewimage'}
	});
}

$('#previewimage').live('click', function() {
	layer.closeAll();
});

function modic(contentid)
{
	$.jBox("iframe:<?php echo site_url('module/live/content/editContent')?>"+"/"+contentid+"/1/1", {title: "修改直播内容",iframeScrolling: 'no',height: 400,width: 650,buttons: { '关闭': true }});
}

function chataudit(chatid,status)
{
	$.get("<?php echo site_url('module/live/chat/chataudit')?>" + "/"+chatid+"/"+status,function(data){
		var d = eval('('+data+')');
		if (d.code == '1')
		{
			$.jBox.tip(d.msg,'success');
			$("#audit_"+d.chatid).remove();
			
		}
		else
		{
			$.jBox.tip(d.msg,'error');
		}
	});
}


</script>
	<div id="previewimage" style="display:none"></div>
	<div class="grid_10 livediv contentdiv clearfix">
		<div class="table clearfix">
			<div class="tab">
				<a href="###" class="cur" rel="chat" style="font-size:12px;padding:0 10px"><img src="<?php echo base_url('themes/images/icon/icon-Message.gif');?>"/>&nbsp;网友互动</a>
				<a href="###" rel="live" style="font-size:12px;padding:0 10px"><img src="<?php echo base_url('themes/images/icon/icon-sound.gif');?>"/>&nbsp;直播室</a>
				<a href="###" rel="qa" style="font-size:12px;padding:0 10px"><img src="<?php echo base_url('themes/images/icon/tip.png');?>" />&nbsp;播主问答</a>
				<?php if ((!empty($u) && $u['level'] !='-1') && ($u['ismaster'] != $roominfo[0]['roomid'])) {?><a href="###" rel="myqa" style="font-size:12px;padding:0 10px">我的问答</a><?php }?>			
			</div>
			<div class="tab-c  padd-10-0" id="livecontent">
				<!---------------------------------- 直播消息开始---------------------------------------------->
				<div class="messagelist" id="chat">
					<?php $this->load->module('live/chat/getitem', array('masterid'=> $masterinfo['masterid']));?>
				</div>

				<div class="messagelist" id="live" style="display:none;">
					<div id="livetop">
					</div>
					<?php
					if ((!empty($u) && $u['level'] != '-1') &&($u['ismaster'] == $roominfo[0]['roomid']))
					{
						$this->load->module('live/content/getLiveInit');
					}
					else if (($cfg['visitor_viewlive'] != '1') && ($u['role'] == '-1'))
					{
							echo "<div style='text-align:center;margin-top:20px'><h3>需要会员登录浏览。</h3></div>";						
					}
					else
						$this->load->module('live/content/getLiveInit');
					?>
				</div>
				<div class="messagelist"  id="qa" style="display:none;">
				<?php
				if ((!empty($u) && $u['level'] != '-1') &&($u['ismaster'] == $roominfo[0]['roomid']))
				{
					$this->load->module('live/content/getQuestionsAll', array('masterid'=> $masterinfo['masterid']));
				}
				else if (($cfg['visitor_viewqa'] != '1') && ($u['role'] == '-1'))
				{
					echo "<div style='text-align:center;margin-top:20px'><h3>需要会员登录浏览。</h3></div>";						
				}
				else
					$this->load->module('live/content/getQuestions', array('roomid'=>$roominfo[0]['roomid'], 'masterid'=> $masterinfo['masterid']));
				 ?>

				</div>
				<div class="messagelist"  id="newsdata" style="display:none;">
<!--					<iframe id="jin10" name="jin10" src="http://www.jin10.com/jin10.com.html" scrolling="no" width="300" frameborder="0" height="350"></iframe> -->
				</div>

				<?php if ((!empty($u) && $u['level'] != '-1') && ($u['ismaster'] != $roominfo[0]['roomid'])) {?>
				<div class="messagelist"  id="myqa" style="display:none;">
				<?php $this->load->module('live/content/getMyQuestions', array('roomid'=>$roominfo[0]['roomid'], 'masterid'=> $masterinfo['masterid']));?>
				</div>
				<?php }?>

				
				<div class="msg_title" id="live_title" style="display:none"><img src="<?php echo base_url('themes/images/icon/article-ico.gif');?>" />&nbsp;&nbsp;我有话要说
				&nbsp;&nbsp;&nbsp;
						<select id="category">
						<option value="" id="first">浏览全部</option>	
						<?php echo $livecate?>
						</select>
						
						<label><input type="checkbox" id="seehot" value="1" />&nbsp;精华</label>
				</div>

				<div class="msg_title" id="other_title"><img src="<?php echo base_url('themes/images/icon/article-ico.gif');?>"/>&nbsp;&nbsp;我有话要说				
				</div>

				</div>
			
			<div class="msg_con" id="liveformdiv" style="display:none;height:130px" >
			<form name="contentsubmit" id="contentsubmit">

				<table>			
				<tr>
					<td>
						<textarea name="content" id="content" style="height:100px; width:370px; border:1px solid #E7D5B4" ></textarea>
					</td>
				</tr>
				<tr>
					<td>
					<INPUT TYPE="hidden" NAME="roomid" id="roomid" value="<?php echo $roominfo[0]['roomid'];?>">
					<INPUT TYPE="hidden" NAME="masterid"  id="masterid" value="<?php echo $masterinfo['masterid'];?>">
					<INPUT TYPE="hidden" NAME="livestatus" id="livestatus" value="1">
					<INPUT TYPE="hidden" id="lastcontentid" name="lastcontentid" value="<?php echo $lastcontentid?>">
					<INPUT TYPE="hidden" NAME="lastvipid" id="lastvipid" value="<?php echo $lastvipid?>" />
					<INPUT TYPE="hidden" NAME="lastquestionid" id="lastquestionid" value="<?php echo $lastquestionid?>" />
					<INPUT TYPE="hidden" NAME="lastmyquestionid" id="lastmyquestionid" value="<?php echo @$lastmyquestionid?>" />


					<INPUT TYPE="hidden" NAME="qacate" id="qacate" value="" />
					<INPUT TYPE="hidden" NAME="hot" id="hot" value="" />

															
					<?php if (!empty($u) && $u['level'] != '-1'){ ?>
						<script type="text/javascript">
						function sendanswer(questionid)
						{
							$.jBox("iframe:<?php echo site_url('live/setAnswer')?>" + '/' + questionid, {title: "解答",iframeScrolling: 'no',height: 400,width: 400,buttons: { '关闭': true }});
						}
						

						</script>


						<INPUT TYPE="hidden" NAME="userid" value="<?php echo @$u['userid'];?>">
						<INPUT TYPE="hidden" NAME="name" value="<?php echo @$u['name'];?>">
						
						<!-- 上次提问时间 -->
						<INPUT TYPE="hidden" id="questionlasttime" name="quetionlasttime" value="<?php echo time()?>">
						<INPUT TYPE="hidden" id="nextsend" name="nextsend" value="">
						
						
						<?php if ((!empty($u) && $u['level'] != '-1') &&  (!empty($u['ismaster']))) {  //主播界面?>
							<INPUT TYPE="hidden" NAME="hostid" value="<?php echo $hostinfo[0]['userid'];?>">
							<INPUT TYPE="hidden" NAME="author" value="<?php echo $hostinfo[0]['name'];?>">
							<INPUT TYPE="hidden" id="type" name="type" value="">
							<input type="button" class="login-button" style="margin:10px" value="发送" onclick="sendLive()" />							
												<select name="contentcate">
												<?php echo $livecate?>
												</select>
												<label><input type="checkbox" name="istop" value="1" />&nbsp;置顶</label>
												<label><input type="checkbox" name="ishot" value="1" />&nbsp;精华</label>
							<!--<input type="button" class="button3" style="margin:10px" value="发至VIP室"  onclick="sendVip()" />-->
							<script type="text/javascript">
										function masterEditInit() {
											KindEditor.ready(function(K) {
												K.basePath = '<?php echo base_url("themes/comm/js/kindeditor/")?>/';
												editor = K.create('#content', {
													minWidth: '370px',
													minHeight: '100px',
													items : ['fontname','fontsize','|','forecolor','bold','italic','underline', '|', 'justifyleft', 'justifycenter','|','image','emoticons','flower']
												});
											});
										}								

										$.ajax({
										  url: '<?php echo base_url("themes/comm/js/kindeditor/kindeditor-min.js")?>',
										  dataType: "script",
											async: false,
										  success: masterEditInit
										});
							
						

								function sendLive()
								{
									$("#type").val('1');
									editor.sync();
									postdata('contentsubmit', "<?php echo site_url('live/setLiveContent')?>", "retlive");
								}

								function sendVip()
								{
									$("#type").val('2');
									editor.sync();
									postdata('contentsubmit', "<?php echo site_url('live/setLiveContent')?>", "retvip");
								}

								function retlive(d)
								{
									if(d.code == '1'){
										$.jBox.tip(d.msg, 'success');
//										$("#content").val('');	
										editor.html('');
										tabshow($(".tab").find("a[rel='live']"));
									}else{
										$.jBox.tip(d.msg,'error');
									}
								}

								function retvip(d)
								{
									if(d.code == '1'){
										$.jBox.tip(d.msg, 'success');
										editor.html('');
										tabshow($(".tab").find("a[rel='vip']"));
									}else{
										$.jBox.tip(d.msg,'error');
									}
								}
							</script>
						<?php } else { // 登录界面 ?>
							<input type="button" class="login-button" style="margin:10px" value="提问" onclick="sendquestion()"/>
						<?php } ?>
					<?php } else { // 非登录界面 ?>
							<input type="button" class="login-button" style="margin:10px" value="提问" onclick="poplogin()" />
					<?php } ?>
					</td>
				<tr>
				</table>
			</form>
			</div>
			<div class="msg_con" id="chatformdiv" style="height:130px">
			<form name="chatform" id="chatform">
			
			<INPUT TYPE="hidden" NAME="roomid" id="roomid" value="<?php echo $masterinfo['roomid']?>">
			<INPUT TYPE="hidden" NAME="masterid" id="masterid" value="<?php echo $masterinfo['masterid']?>">
			<INPUT TYPE="hidden" NAME="lastchatid" id="lastchatid" value="<?php echo (empty($lastchatid))? 0 : $lastchatid;?>">
	
			<INPUT TYPE="hidden" NAME="nextchat" id="nextchat" value="">

				<table width=100% style="margin-bottom:5px">
				<tr>
					<td width=100%>
						<textarea name="chatcontent" id="chatcontent" style="width:370px;height:100px;border:1px solid #E7D5B4"></textarea>						
					</td>
				<tr>
				<tr>
					<td align="center">
						<?php if (!empty($u)) { ?>
							<INPUT TYPE="hidden" NAME="chatname" id="chatname" value="<?php echo $u['name']?>">
							<INPUT TYPE="hidden" NAME="chatuserid" id="chatuserid" value="<?php echo $u['userid']?>">
							<script type="text/javascript">

										function userEditInit() {
											KindEditor.ready(function(K) {
												K.basePath = '<?php echo base_url("themes/comm/js/kindeditor/")?>/';
												editor1  = K.create('#chatcontent', {
													minWidth: '370px',
													minHeight: '100px',
													items : ['emoticons','flower'],
													htmlTags:{
														img : ['src', 'width', 'height', 'border', 'alt', 'title', 'align', '.width', '.height', '.border'],
        'p,ol,ul,li,blockquote,h1,h2,h3,h4,h5,h6' : [
                'align', '.text-align', '.color', '.background-color', '.font-size', '.font-family', '.background',
                '.font-weight', '.font-style', '.text-decoration', '.vertical-align', '.text-indent', '.margin-left'
        ]
													},
													afterChange : function() {
													K('.word_count').val(this.count('text'));
													}
												});
											});
										}

										$.ajax({
										  url: '<?php echo base_url("themes/comm/js/kindeditor/kindeditor-min.js")?>',
										  dataType: "script",
											async: false,
										  success: userEditInit
										});
							</script>
							<input type="hidden" name="wordcount" class="word_count" id="wordcount" />
							<input type="button" class="login-button" style="margin:10px 0px 0px 300px;" value="发 送" onclick="setitem()"/>
						<?php } else { // 非登录界面 ?>
							<input type="button" class="login-button" style="margin:10px 0px 0px 300px" value="发 送" onclick="poplogin()"/>
						<?php } ?>
					</td>
				</tr>
				</table>
			</form>
			</div>			
		</div>
	</div>

<script>document.getElementById("live").scrollTop=document.getElementById("live").scrollHeight;</script>