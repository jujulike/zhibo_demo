<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="<?php echo base_url($cfg['tpl_admin'])?>/css/style.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $cfg['site_title']?>后台管理</title>
<script type="text/javascript" src="<?php echo base_url($cfg['comm'])?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url($cfg['comm'])?>/js/jquery.form.js"></script>
<script type="text/javascript">
/* 按下F5时仅刷新iframe页面 */
function inactiveF5(e) {
	return ;
	e=window.event||e;
	var key = e.keyCode;
	if (key == 116){
		parent.MainIframe.location.reload();
		if(document.all) {
			e.keyCode = 0;
			e.returnValue = false;
		}else {
			e.cancelBubble = true;
			e.preventDefault();
		}
	}
}

function nof5() {
    return ;
	if(window.frames&&window.frames[0]) {
		window.frames[0].focus();
		for (var i_tem = 0; i_tem < window.frames.length; i_tem++) {
			if (document.all) {
				window.frames[i_tem].document.onkeydown = new Function("var e=window.frames[" + i_tem + "].event; if(e.keyCode==116){parent.MainIframe.location.reload();e.keyCode = 0;e.returnValue = false;};");
			}else {
				window.frames[i_tem].onkeypress = new Function("e", "if(e.keyCode==116){parent.MainIframe.location.reload();e.cancelBubble = true;e.preventDefault();}");
			}
		} //END for()
	} //END if()
}

function support()
{	

	parent.MainIframe.$.jBox.info("<B>技术支持</B><Br>营销有道 QQ：100000<br/>公司官网：<a href='http://www.cn' target='_blank'>www.u.cn</a>", '技术支持:一洋网络');
}

function refresh() {
	parent.MainIframe.location.reload();
}

document.onkeydown=inactiveF5;
</script>
</head>

<body scroll="no" style="margin:0; padding:0;" onLoad="nof5()">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="3">
		<div class="header"><!-- 头部 begin -->
		    <div class="logo"><a href="<?php echo site_url('admin/user/setmain'); ?>" >&nbsp;</a></div>
		    <div class="nav_sub">
		    	您好,<?php echo $adminfo['user_name']?>(<?php if (empty($adminfo['role_id'])) { echo "超级管理员";} else {echo $adminfo['role_name'];}?>)&nbsp; | <a href="<?php echo site_url('/')?>">返回前台</a> | <a href="javascript:void(0);" onClick="refresh();">刷新</a><!-- | <a href="javascript:;" onclick="support()">技术支持</a>--> | <a href="<?php echo site_url("admin/login/logout"); ?>">退出</a><br/>
		    	<div id="TopTime"></div>
		    </div>
		    <div class="main_nav">
				<?php foreach ($menu_list as $k => $v) {?>
				<a id="channel_<?php echo $v['action_code']?>"  href="javascript:void(0)" onClick="switchChannel('<?php echo $v['action_code']?>');" hidefocus="true" style="outline:none;"><?php echo $v['action_name']?></a>
				<?php }?>
			</div>           
		</div>

		<div class="header_line"><span>&nbsp;</span></div>
	</td>
  </tr>
  <tr>
  	<td width="200px" height="100%" valign="top" id="FrameTitle" background="<?php echo base_url($cfg['tpl_admin'])?>/css/images/left_bg.gif">
  		<div class="LeftMenu">
			<?php foreach ($menu_list as $k => $v) {?>
	<!-- 第一级菜单，即大频道 -->
			<ul class="MenuList" id="root_<?php echo $v['action_code']?>" style="display:none;">
				<?php foreach ($v['menu_2'] as $k2 => $v2) {?>
	      	<!-- 第二级菜单 -->
				<li class="treemenu">
				<a id="root_<?php echo $v2['action_code']?>" class="actuator" href="javascript:void(0)" onClick="switch_root_menu('<?php echo $v2['action_code']?>');" hidefocus="true" style="outline:none;"><?php echo $v2['action_name']?></a>
				<ul id="tree_<?php echo $v2['action_code']?>" class="submenu">
					<?php foreach ($v2['menu_3'] as $k3 => $v3) {?>
				<!-- 第三级菜单 -->
					<li><a id="menu_<?php echo $v3['action_code']?>" href="javascript:void(0)" onClick="switch_sub_menu('<?php echo $v3['action_code']?>', '<?php echo site_url($v3['action_link'])?>');" class="submenuA" hidefocus="true" style="outline:none;"><?php echo $v3['action_name']?></a></li>
					<?php }?>
				</ul>
				</li>
				<?php }?>
			</ul>
			<?php }?>
		</div>
	</td>
    <td>
   	  <iframe onload="nof5()" id="MainIframe" name="MainIframe" scrolling="yes" src="{$home_url}" width="100%" height="100%" frameborder="0" noresize> </iframe>
	</td>
  </tr>
</table>
</body>

<script type="text/javascript">
	var current_channel   = null;
	var current_menu_root = null;
	var current_menu_sub  = null;
	var viewed_channel	  = new Array();
	var initmenu = "<?php echo $menu_list[0]['action_code']?>";
	
	$(document).ready(function(){
		switchChannel(initmenu);
	});
	
	//切换频道（即头部的tab）
	function switchChannel(channel) {
		if(current_channel == channel) return false;
		
		$('#channel_'+current_channel).removeClass('on');
		$('#channel_'+channel).addClass('on');
		
		$('#root_'+current_channel).css('display', 'none');
		$('#root_'+channel).css('display', 'block');
		
		var tmp_menulist = $('#root_'+channel).find('a');
		tmp_menulist.each(function(i, n) {
			// 防止重复点击ROOT菜单
			if( i == 0 && $.inArray($(n).attr('id'), viewed_channel) == -1 ) {
				$(n).click();
				viewed_channel.push($(n).attr('id'));
			}
			if ( i == 1 ) {
				$(n).click();
			}
		});

		current_channel = channel;
	}
	
	function switch_root_menu(root) {
		root = $('#tree_'+root);
		if (root.css('display') == 'block') {
			root.css('display', 'none');
			root.parent().css('backgroundImage', 'url(<?php echo base_url($cfg['tpl_admin'])?>/css/images/ArrOn.png)');
		}else {
			root.css('display', 'block');
			root.parent().css('backgroundImage', 'url(<?php echo base_url($cfg['tpl_admin'])?>/css/images/ArrOff.png)');
		}
	}
	
	function switch_sub_menu(sub, url) {
		if(current_menu_sub) {
			$('#menu_'+current_menu_sub).attr('class', 'submenuA');
		}
		$('#menu_'+sub).attr('class', 'submenuB');
		current_menu_sub = sub;
		
		parent.MainIframe.location = url;
	}
	
	/*
	function resetEscAndF5(e) {
		e = e ? e : window.event;
		actualCode = e.keyCode ? e.keyCode : e.charCode;
		if(actualCode == 116 && parent.MainIframe) {
			parent.MainIframe.location.reload();
			if(document.all) {
				e.keyCode = 0;
				e.returnValue = false;
			} else {
				e.cancelBubble = true;
				e.preventDefault();
			}
		}
	}
	
	function _attachEvent(obj, evt, func, eventobj) {
		eventobj = !eventobj ? obj : eventobj;
		if(obj.addEventListener) {
			obj.addEventListener(evt, func, false);
		} else if(eventobj.attachEvent) {
			obj.attachEvent('on' + evt, func);
		}
	}
	
	_attachEvent(document.documentElement, 'keydown', resetEscAndF5);
	_attachEvent(window, 'keydown', resetEscAndF5, parent.frames[0]);
	*/
</script>
</html>