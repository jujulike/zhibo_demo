<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?php echo $roominfo['roomname'];?></title>
<link type="text/css" media="all" rel="stylesheet" href="<?php echo base_url('themes/feibei/images/index_kefu_data/css.css')?>" />
<?php $this->load->view($cfg['tpl'] . "public/meta2");?>
<script type="text/javascript" src="<?php echo base_url('themes/comm/js/layer/layer.min.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('themes/feibei/js/show.js')?>"></script>
<style>
.kzzsx {
/*    background: url(<?php echo base_url($cfg['tpl']."images/public/wei.gif")?>) no-repeat scroll 0 0 rgba(0, 0, 0, 0);*/
	background:#292929;
    bottom: 0;
    height: 37px;no-repeat
    left: 0;
    line-height: 37px;
    position: absolute;
    text-indent: 10px;
    width: 390px;
    z-index: 5;
}

.kzzsx a {
    color: #fff;
    float: left;
    line-height: 37px;
    text-decoration: none;
}

#jin10{ background:#fff; position:relative; z-index:1;}
</style>
</head>
<body>
<!---------------------------顶部 -------------------------------------------------->
<?php $this->load->view($cfg['tpl'] . 'public/header');?>
<!---------------------------内容区 #main -------------------------------------------------->

<script type="text/javascript">
$(document).ready(function(){
	$("#<?php echo $roominfo['catealias']?>").addClass("on");

	$("#tabtopvideo").click(function(){
		$(".livediv").show();
		$(".newsdiv").hide();
		$("#tabtopnews").removeClass("cur");
		$(this).addClass("cur");
	});

	$("#tabtopnews").click(function(){
		$(".livediv").hide();
		$(".newsdiv").show();
		$("#tabtopvideo").removeClass("cur");
		$(this).addClass("cur");
	});


});

function edittile(masterid)
{
	$.jBox("iframe:<?php echo site_url('live/editTitle')?>"+"/"+masterid, {title: "修改直播主题",iframeScrolling: 'no',height: 250,width: 450,buttons: { '关闭': true }});
}

function editroom(roomid,cate)
{
	$.jBox("iframe:<?php echo site_url('live/editRoominfo')?>"+"/"+roomid+"/"+cate, {title: "修改简介",iframeScrolling: 'no',height: 200,width: 450,buttons: { '关闭': true }});
}

function handanlist()
{
	<?php if (!empty($userinfo['role']) && ($userinfo['role'] < 0)) { ?>
		$.jBox.tip('请登录后查看','info');
		return false;
	<?php } ?>

	$.jBox("iframe:<?php echo site_url('handan/tlist')?>"+"/"+$("#masterid").val(), {title: "喊单明细",iframeScrolling: 'no',height: 400,width: 780,buttons: { '关闭': true }});
}

</script>
<style type="text/css">
.logindiv{float:right;margin-right:0px;}
.logindiv a{border-right:0px;}
</style>
<div class="container_24 clearfix">
	<?php if (!empty($masterinfo)) { ?>
	<div class="grid_24 clearfix">		
	<div class="table clearfix">
		<div class="tabtop">
			<a class="cur" style="font-size:12px;padding:0 10px" rel="video" href="###" id="tabtopvideo"><img src="<?php echo base_url('themes/images/icon/icon-ChatRoom.png');?>" />&nbsp;视频直播</a>
			<a rel="newsdata" style="font-size:12px;padding:0 10px" href="###"  id="tabtopnews"><img src="<?php echo base_url('themes/images/icon/icon-report.gif');?>" />&nbsp;财经数据</a>
			<span class="logindiv">
				<?php if ((!empty($userinfo)) && ($userinfo['level'] != '-1')) { ?>
					<a href="javascript:void(0)"  onclick="modi()" title="修改个人信息" >&nbsp;<span class="orange"><?php echo $userinfo['name'];?></span></a>
					<a href="<?php echo site_url("user/logout") ?>">&nbsp;<span class="orange">退出</span></a>
					<script type="text/javascript">
					function modi()
						{
							$.jBox("iframe:<?php echo site_url('user/modi');?>", {title: "个人信息修改",iframeScrolling: 'no',height: 400,width: 350,buttons: { '关闭': true }});
						}
					</script>
				<?php }else{ ?>
					<script type="text/javascript">
						function poplogin()
						{
							$.jBox("iframe:<?php echo site_url('module/user/login/index/poplogin/1');?>", {id: 'poplogin', title: "用户登录",iframeScrolling: 'no',height: 250,width: 250,buttons: { '关闭': true }});
						}

						function register()
						{
							$.jBox("iframe:<?php echo site_url('user/reg');?>", {title: "用户注册",iframeScrolling: 'no',height: 400,width: 350,buttons: { '关闭': true }});
						}

						function getpasswd()
						{
							$.jBox("iframe:<?php echo site_url('user/getpasswd');?>", {title: "忘记密码",iframeScrolling: 'no',height: 250,width: 250,buttons: { '关闭': true }});
						}
						

					</script>
					<a href="###" onclick="poplogin()">&nbsp;<span class="orange">登录</span></a>
					<a href="###" onclick="register()">&nbsp;<span class="orange">注册</span></a>
					<!--<a href="###" onclick="getpasswd()"><span class="orange">忘记密码?</span></a>-->
				<?php } ?>
			</span>
			</div>
		</div>
	</div>
	<!--视频区-->
	<div class="grid_10 livediv clearfix">		
		<div id="video" style="position: relative;z-index:1">
			<div class="kzzsx">
				<a title="点击刷新" href="javascript:LoadVideo();">没有声音,有杂音,看不到视频，请点刷新</a>
			</div>
			<div id="video_player" style="position: relative;z-index:4">
				<embed width="390" height="400" align="middle" type="application/x-shockwave-flash" wmode="transparent" mode="transparent" allowfullscreen="true" allowscriptaccess="never" quality="high" src="http://yy.com/s/<?php echo $cfg['yy_channel']?><?php if (!empty($cfg['yy_subchannel'])) { echo "/".$cfg['yy_subchannel'];}?>/mini.swf">
		
			</div>
		</div>

		<script>
		function LoadVideo() {
			var videoId = "<?php echo $cfg['yy_channel']?>";
			<?php if (!empty($cfg['yy_subchannel'])) { ?>
				videoId = videoId + "/" + "<?php echo $cfg['yy_subchannel'] ?>";
			<?php }?>
			var videoHtml = "<embed id='yyEmbed' src='http://yy.com/s/"+videoId+"/mini.swf' quality='high' width='390'";
				videoHtml += " height='400' align='middle' allowscriptaccess='always' allowfullscreen='true'";
				videoHtml += " mode='transparent' wmode='transparent' type='application/x-shockwave-flash'></embed>";
			$("#video_player").html(videoHtml);
		} 		
		</script>

		<div class="table clearfix">
		<div class="zhao" style='font-family:"Microsoft YaHei",微软雅黑,"MicrosoftJhengHei",华文细黑,STHeiti,MingLiu; font-size:18px;height:40px;width:385px;padding-top:10px;margin-bottom:10px;text-align:center'>
			<span><img src="<?php echo base_url('themes/images/icon/lb.png');?>" /><a href="###" class="orange" onclick="handanlist()">实力见证请点击赢在这里在线喊单明细查询</a></span>
		</div>
		</div>

		<div class="table clearfix">
			<div class="zhao" style="height:188px;width:385px">				
				<div class="zx" style="float:left;border:none;margin-top:5px;">
					<ul class="namelist">

					<?php $i=0;foreach ($service as $k => $v) {?>
					   <li <?php if ($i==0){?>class="on"<?php }?> name="<?php echo $v['advertid']?>"><a><?php echo $v['title']?></a></li>
					   <?php $i++;}?>
					</ul>
					<div class="clear"></div>
					<?php foreach ($service as $k => $v) {?>
					<div class="info hide" id="info_<?php echo $v['advertid']?>">

						<img src="<?php echo base_url($v['imgthumb'])?>" alt="<?php echo $v['title']?>" class="bk">
						<ul>
						<?php echo $v['desc']?>
							<li><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $v['link']?>&amp;site=qq&amp;menu=yes"><img src="<?php echo base_url('themes/feibei/images/index_kefu_data/pa_008.gif')?>" alt="客服咨询" title="客服咨询" border="0"></a></li>
					  
						</ul>
				   </div>
				   <?php }?>
			  
				</div>
				<script type="text/javascript">
				$(function(){

				var lis = $(".namelist > li");
				//$(".namelist").html("");
				$.each(lis,function(i,n){
				$(".namelist").append(lis[i]);
				});
				$(".namelist >li:first").addClass("on");
				var cid =$(".namelist >li:first").attr("name");
				$("#info_"+cid).removeClass("hide");
				$(".namelist > li").click(
							function(e) {
								var cid =$(this).attr("name");	
								$(".namelist>li.on").removeClass("on");
								$(this).addClass("on");
								$("div.info").addClass("hide");
								$("#info_"+cid).removeClass("hide");
							  
							});
				});
				function randomsort(a, b) {
				   return Math.random()>.5 ? -1 : 1;
				}       
				function fnLuanXu(arr) {  
						var num = arr.length;
						for (var i = 0; i < num; i++) {  
							var iRand = parseInt(num * Math.random());  
							var temp = arr[i];  
							arr[i] = arr[iRand];  
							arr[iRand] = temp;  
						}  
						return arr;  
					}     
				</script>
			</div>
		</div>
	</div>
	<!-- 直播区-->
	<?php $this->load->module('live/content/getlivedata', array(array($roominfo['cateid']), array($roominfo), array($hostinfo)));?>
	<!-- 聊天区-->
	<?php $this->load->module('live/chat/room', array(array($roominfo['cateid']), array($roominfo), array($hostinfo)));?>
	<?php } else { ?>
	<h2>尚未开设过直播主题！</h2>
	<?php } ?>

	<div class="grid_18 newsdiv clearfix" style="display:none">		
	<iframe id="jin10" name="jin10" src="http://www.jin10.com/jin10.com.html" scrolling="auto" width="100%" frameborder="0" height="710"  style="margin-top:10px;"></iframe> 
	<div style="margin-left:12px;width:667px;height:58px;background:#f8faee;position:absolute;z-index:9;top:47px;"></div>
	</div>
	<div class="grid_6 newsdiv clearfix" style="display:none">		
	<iframe  src="http://www.jin10.com/data.html" scrolling="auto" width="100%" frameborder="0" height="710" style="margin-top:10px;"></iframe> 
	</div>
</div> 
<!-- begin: #footer -->
<?php  $this->load->view($cfg['tpl'] . 'public/footer');?>
<!-- end: #footer -->
</body>
</html>
