<div class="visitorList"> <span class="arrow"></span> <span class="arrowOn"></span>
	<ul id="visitorListScrollbar" >
	<div id="au"></div>
	</ul>
  </div>

<script type="text/javascript">

var onlineuptime;
window.clearInterval(onlineuptime);
onlineuptime = setInterval(useronline, <?php echo $cfg['status_offline_time'] / 2 * 1000; ?>);

function userflash()
{
	$.ajax({url:'<?php echo site_url("module/live/useronline/getUsers") ?>'+'/'+ $("#masterid").val() + '?t=' + new Date().getTime(),
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
		async:false,
		success: function(d){
			$("#au").html(d);
		}
	});
}

<?php if ($userinfo['ismaster'] == $masterinfo['roomid']) { ?>
function setStop(uid){
	$.ajax({url:'<?php echo site_url("userstatus/setStop") ?>'+'/'+ $("#roomid").val() + '/' + uid + '?t=' + new Date().getTime(),
		type: "GET",
		dataType: "json",
		success: function(d){
			if (d.code == '1')
			{
				$("#u_"+d.msg).find("a").eq(0).text("解禁");
				$("#u_"+d.msg).find("a").eq(0).attr("onclick",'setCancelStop(' + d.msg + ')');
				layer.msg('设置禁言成功', 2, 1);
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
				layer.msg('踢除成功', 2, 1);
			}
		}
	});
}

function setCancelStop(uid)
{
	$.ajax({url:'<?php echo site_url("userstatus/setCancelStop") ?>'+'/'+ $("#roomid").val() + '/' + uid + '?t=' + new Date().getTime(),
		type: "GET",
		dataType: "json",
		success: function(d){
			if (d.code == '1')
			{
				$("#u_"+d.msg).find("a").eq(0).text("禁");
				$("#u_"+d.msg).find("a").eq(0).attr("onclick",'setStop(' + d.msg + ')');
//				layer.msg('设置取消禁言成功', 2, 1);
			}
		}
	});
}

<?php } ?>

</script>