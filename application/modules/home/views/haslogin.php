<link type="text/css" media="all" rel="stylesheet" href="<?php echo base_url('themes/comm/js/jBox/Skins/Brown/jbox.css')?>" />

<script type="text/javascript" src="<?php echo base_url('themes/comm/js/jquery.form.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('themes/comm/js/jBox/jquery.jBox-2.3.min.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('themes/comm/js/jBox/i18n/jquery.jBox-zh-CN.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('themes/comm/js/f.js')?>"></script>
<script src="<?php echo base_url('themes/home/sendUtil.js')?>" type="text/javascript"></script>
<script type="text/javascript">
function usermodi()
{
	$.jBox("iframe:<?php echo site_url('user/modi');?>", {title: "个人信息修改",iframeScrolling: 'no',height: 530,width: 350,buttons: { '关闭': true }});
}

function goroom(url)
{
//	window.top.location.href=url;
	window.open(url,"_blank")
}

function setLiveMaster()
{
	$.jBox("iframe:<?php echo site_url('live/setMaster');?>", {title: "开设直播主题",iframeScrolling: 'no',height: 250,width: 450,buttons: { '关闭': true }});
}

function roomappshow()
{
	$.jBox("iframe:<?php echo site_url('live/roomapp');?>", {title: "直播室申请",iframeScrolling: 'no',height: 565,width: 450,buttons: { '关闭': true }});
}
</script>
<div class="dl" >
<?php if ($u['ismaster'] != '') {?>
	<link href="<?php echo base_url('themes/home/ys2.css')?>" rel="stylesheet" type="text/css" />
	<img src="images/VIPdlh_03.jpg" />
    <div class="huanying">
		<ul>
        	<li>您好：<span class="wy"><?php echo $u['username']?></span>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onclick="usermodi()"><img src="images/VIPdlh_07.jpg" /></a></li>
        	<br />
            <li><a href="javascript:void(0)" onclick="goroom('<?php echo site_url("live/room" . "/" . $u['ismaster']);?>')"><img src="images/VIPdlh_04.jpg" /></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onclick="setLiveMaster()"><img src="images/VIPdlh_05.jpg" /></a></li>
            <br /><br /><br /><br /><br />
            <li style="color:#333333; font-size:12px;">欢迎来到国腾贵金属直播平台！&nbsp;&nbsp;<a href="<?php echo site_url('user/logout')?>">退出</a></li>
        </ul>  
    </div>
    <div class="jrzbs">
    	<ul>
        	<li id="teshu">已有<span id="renshu"><?php echo $hasregister?></span>人注册</li> 
        </ul>
    </div>
	<?php } else {?>
	<link href="<?php echo base_url('themes/home/ys1.css')?>" rel="stylesheet" type="text/css" />
	<img src="images/VIPdlh_03.jpg" />
    <div class="huanying">
		<ul>
        	<li>您好：<span class="wy"><?php echo $u['username']?></span>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onclick="usermodi()"><img src="images/VIPdlh_07.jpg" /></a></li>
        	<br />
            <li>欢迎来到国腾贵金属直播平台！&nbsp;&nbsp;<a href="<?php echo site_url('user/logout')?>">退出</a></li>
        </ul>  
    </div>
    <div class="jrzbs">
    	<ul>
        	<li id="teshu">已有<span id="renshu"><?php echo $hasregister?></span>人注册</li><br />
            <li><a href="javascript:void(0)" onclick="roomappshow()"><img src="images/VIPdlh_11.jpg" /></a></li>
        </ul>
    </div>
	<?php }?>
</div>
