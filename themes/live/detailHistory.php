<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?php echo SYSTEM_NAME ?></title>
<?php $this->load->view($cfg['tpl'] . "public/meta2");?>
</head>
<body>
<!---------------------------顶部 -------------------------------------------------->
<?php $this->load->view($cfg['tpl'] . 'public/header');?>
<!---------------------------内容区 #main -------------------------------------------------->
<script type="text/javascript">
$(document).ready(function(){
	$("#<?php echo $roominfo['catealias']?>").addClass("on");
});
</script>

<div class="container_24 clearfix">
	<div style = "margin-bottom:5px;padding-left:5px" >
			<span style="color: #573512;font-size: 16px;">直播主题：<?php echo $masterinfo['mastertitle']?></span>&nbsp;&nbsp;&nbsp;结束时间：<?php echo date("Y-m-d H:i:s",$masterinfo['etime'])?><span style="float:right;"><a href="<?php echo site_url("live/listHistory" . "/" . $masterinfo['roomid'])?>" target="_blank" style="color:#573512;font-size: 16px;">>>历史直播列表</a></span>
	</div>
	<!-- 直播区-->
	<div class="grid_16 clearfix">
		<div class="table clearfix">
			<div class="tab">
				<a href="###" class="cur" rel="live">直播室</a>
			</div>
			<div class="tab-c  padd-10-0" id="livecontent">
				<!---------------------------------- 直播消息开始---------------------------------------------->
				<div class="messagelist" id="live">
					<?php foreach($contentlist as $k => $v) {?>
					<div class="article">
						<h6>
						<b>&nbsp;直播观点</b><img src="<?php echo base_url('themes/images/icon/notice.gif');?>">&nbsp;<?php echo str_replace('<img', '<img onLoad="DrawImage(this,500,300)"', $v['content'])?> --<?php echo date("d日H时i分s秒", $v['ctime'])?>
						</h6>						
					</div>
					<?php } ?>
				</div>
			</div>	
			
		</div>
	</div>
	<!-- 聊天区-->
	<div class="grid_8 clearfix">
		<!-- 网友互动-->				
		
			<div class="wy-title">
			  <span style="margin-top:10px">网友互动</span>
			</div>
			<div class="tab-c  padd-10-0" style="border:1px solid #E7D5B4">
				<div class="messagelist" id="chat">
					<?php 
					if (!empty($chatlist)) {
					foreach($chatlist as $k => $v) {?>
					<div class="article">
						<h6>
						<b>&nbsp;<?php echo $v['chatname']?>:</b><?php echo @$v['chatcontent']?> --<?php echo date("m-d H:i:s", $v['ctime'])?>
						</h6>						
					</div>
					<?php } ?>
					<?php }?>
				</div>
				
			</div>
			
	</div>
</div> 
<!-- begin: #footer -->
<?php $this->load->view($cfg['tpl'] . 'public/footer');?>
<!-- end: #footer -->
</body>
</html>
