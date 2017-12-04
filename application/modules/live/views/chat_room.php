<style type="text/css">
<!--
.login{ background:#FEFAF1; border:1px solid #E7D5B4}
.login h6{ font-weight:100; border-bottom:1px solid #f0f0f0; text-indent:8px; padding:8px 0}
.box-login{ overflow:hidden; width:100%; margin:5px 8px}
.box-login td{ padding:6px 0; line-height:16px}
.login-con{border-top:1px solid #f0f0f0; padding:15px 0 20px 0; text-align:center; color:#666; line-height:24px}
.login-con .num{ font-family:'Arial'; font-weight:700; font-size:20px; color:#ff9000}
-->
.invote {
    display: inline;
    float: left;
    height: 128px;
    padding-top: 0;
}
.invote li {
    cursor: pointer;
    font-size: 14px;
    font-weight: bold;
    height: 40px;
    line-height: 20px;
    padding-left: 0;
    text-align: center;
    width: 138px;
}
.invote li.dz {
    background: url("<?php echo base_url($cfg['tpl'].'images/public/kduo.jpg')?>") no-repeat scroll left center #f6787b;
}
.invote li.sp {
    background: url("<?php echo base_url($cfg['tpl'].'images/public/pz.jpg')?>") no-repeat scroll left center #b1b1b1;
}
.invote li.zc {
    background: url("<?php echo base_url($cfg['tpl'].'images/public/kk.jpg')?>") no-repeat scroll left center #7dd26b;
}
.invote li .ss {
    display: block;
    font-size: 14px;
    line-height: 40px;
	text-align:left;
	margin-left:46px;
}
</style>

<div class="grid_4 livediv clearfix">
		<!-- 网友互动-->				
		
			<div class="tab3">
<!--				<a href="###"  rel="chat" style="font-size:12px;padding:0 10px">在线聊天</a>-->

				<a href="###" rel="au" class="cur" style="font-size:12px;padding:0 10px"><img src="<?php echo base_url('themes/images/icon/icon-userGroup.gif');?>"/>&nbsp;在线网友</a>
				<?php if ($confdisallowed == '1') { if (($u['userid'] == $masterinfo['userid']) && ($isaudit == 1)) {?><a href="###" rel="au">禁言网友</a><?php } }?>
			</div>
			<div class="tab-c  padd-10-0" style="border:1px solid #E7D5B4">
				<div class="messagelist" id="au">					
				</div>				
				<div class="msg_title"><img src="<?php echo base_url('themes/images/icon/article-ico.gif');?>"/>&nbsp;&nbsp;在线投票</div>
					<form id="voteform" name="voteform">
					<table border="1" class="box-login">
						<tbody>
						<tr>
							<td>
								<ul class="invote">
									<?php if (!empty($vote_result)) {?>
									<li class="dz" name="kanduo" onclick="setVote(0)">
									<span class="ss">
									看涨<span id="kz"><?php echo $vote_result[0]['v']?>%</span>
									</span>
									</li>
									<li class="sp" name="panzheng" onclick="setVote(1)">
									<span class="ss">
									盘整<span id="pz"><?php echo $vote_result[1]['v']?>%</span>
									</span>
									</li>
									<li class="zc" name="kankong" onclick="setVote(2)">
									<span class="ss">
									看空<span id="kk"><?php echo $vote_result[2]['v']?>%</span>
									</span>
									</li>
									<?php } else {?>当前还没有人参与投票<?php }?>
								</ul>
							</td>
						</tr>
						
						
					</tbody></table>		
					</form>				
			</div>
	</div>
<script type="text/javascript">
$(document).ready(function (){
	/*
	$(".tab3").find("a").click(function()
	{
		tabshow2(this);
	});
	*/
});

var onlineuptime;
//window.clearInterval(chattime);
window.clearInterval(onlineuptime);

useronline();
//chattime = setInterval(chatflash, 3000);
onlineuptime = setInterval(useronline, <?php echo $cfg['status_offline_time'] / 2 * 1000; ?>);

/*function chatflash()
{
	$.ajax({url:'<?php echo site_url("module/live/chat/getitem") ?>'+'/'+ $("#masterid").val() +'/' + $("#lastchatid").val() + '?t=' + new Date().getTime(),
		 type: "GET",
		ifModified:true,
		success: function(d){
			$("#chat").append(d);
			document.getElementById("chat").scrollTop=document.getElementById("chat").scrollHeight;
		}
	});
}*/

function userflash()
{
	$.ajax({url:'<?php echo site_url("module/live/chat/getUsers") ?>'+'/'+ $("#masterid").val() + '?t=' + new Date().getTime(),
		 type: "GET",
		ifModified:true,
		success: function(d){
			$("#au").html(d);
		}
	});
}

function useronline()
{
	$.ajax({url:'<?php echo site_url("userstatus/setUserOnline") ?>'+'/'+ $("#roomid").val() + '?t=' + new Date().getTime(),
		 type: "GET",
		ifModified:true,
		success: function(d){
			$("#au").html(d);
		}
	});
}



/*function tabshow2(e)
{
	$(".tab3").find("a").removeClass("cur");
	$(e).addClass("cur");
	$("#chat").hide();
	$("#au").hide();
	$("#" + $(e).attr("rel")).show();	

	document.getElementById($(e).attr("rel")).scrollTop=document.getElementById($(e).attr("rel")).scrollHeight;

	if ($(e).attr("rel") == 'chat')
	{
		window.clearInterval(chattime);
		chattime = setInterval(chatflash, 3000);
	}
	else if($(e).attr("rel") == 'au')
	{
		//alert("au");
//		userflash();
		
	}	
}*/

function setitem()
{
	/*
	var posttime;

	if ($("#nextchat").val() != '')
	{
		if (parseInt(Date.parse(new Date()).toString().substring(0,10)) < parseInt($("#nextchat").val()))
		{
			$.jBox.tip('请在10后再提问','info');
			return false;
		}
	}
	*/
	editor1.sync();
	postdata('chatform', "<?php echo site_url('chat/setContent')?>", "retchat");
}

function retchat(d)
{
	if(d.code == '1'){
		$("#questionlasttime").val(d.lasttime);
		$.jBox.tip(d.msg, 'success');
		$("#nextchat").val(parseInt(Date.parse(new Date()).toString().substring(0,10)) + 10);
		editor1.html('');		
		$("#chat").append(d.content);
		document.getElementById("chat").scrollTop=document.getElementById("chat").scrollHeight;
	}
	else if (d.code == '-1')
	{
		$.jBox.tip('你已被踢出,请过一段时间再来!','error');
		top.location.href='<?php echo  site_url('home');?>';
	}
	else{
		$.jBox.tip(d.msg,'error');
	}
}

<?php if ($cfg['open_vote'] == '1') { ?>


function setVote(_flag)
{
	$.ajax({
		type: "POST",
		url: '<?php echo site_url("vote");?>',
		dataType: "json",
		data: "vote="+ _flag,
		success: function(d){
			if (d.code == '1')
			{
				$.jBox.tip(d.msg, 'success');
				$("#kz").html(d.kz);
				$("#pz").html(d.pz);
				$("#kk").html(d.kk);
			}
			else
				$.jBox.tip(d.msg, 'error');
		}
	});
}


/*
function setVote()
{
	<?php if (!empty($userinfo['role']) && ($userinfo['role'] < 0)) { ?>
		$.jBox.tip('请登录后投票','info');
		return false;
	<?php } ?>
	$.jBox("iframe:<?php echo site_url('vote') ?>", {id: 'popvote', title: "在线投票",iframeScrolling: 'no',height: 250,width: 250,buttons: { '关闭': true }});
}
*/

function getVote()
{
	<?php if (!empty($userinfo['role']) && ($userinfo['role'] < 0)) { ?>
		$.jBox.tip('请登录后查看结果','info');
		return false;
	<?php } ?>
	$.jBox("iframe:<?php echo site_url('vote/result') ?>", {id: 'popvote', title: "投票结果",iframeScrolling: 'no',height: 300,width: 350,buttons: { '关闭': true }});
}

<?php } ?>

<?php if ($userinfo['ismaster'] == $masterinfo['roomid']) { ?>
function setStop(uid){
	$.ajax({url:'<?php echo site_url("userstatus/setStop") ?>'+'/'+ $("#roomid").val() + '/' + uid + '?t=' + new Date().getTime(),
		type: "GET",
		dataType: "json",
		success: function(d){
			if (d.code == '1')
			{
				$("#u_"+d.msg).find("a").eq(0).removeClass("red");
				$("#u_"+d.msg).find("a").eq(0).attr("onclick",'');
				$.jBox.tip('设置禁言成功','success');
			}
		}
	});
}

function setOut(uid){
	$.ajax({url:'<?php echo site_url("userstatus/setOut") ?>'+'/'+ $("#roomid").val() + '/' + uid + '?t=' + new Date().getTime(),
		type: "GET",
		dataType: "json",
		success: function(d){
			if (d.code == '1')
			{
				$("#u_"+d.msg).remove();
				$.jBox.tip('踢除成功','success');
			}
		}
	});
}

<?php } ?>
</script>