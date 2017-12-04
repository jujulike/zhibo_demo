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

	<?php if (!empty($masterlist)) { ?>
	<div class = "historylist ">
		<div class = "p20">
			<h1>
				<span>历史直播</span>
			</h1>
			<div class ="gonggaolist">
				<ul>
					<?php foreach ($masterlist as $k => $v) {?>
					<li>
						<span><?php echo date("Y-m-d H:i:s",$v['etime'])?></span>
						<a target="_blank" href="<?php echo site_url('live/detailHistory/' . $v['masterid'])?>"> <?php echo $v['mastertitle']?> </a>
					</li>
					<?php }?>
				</ul>
			</div>
		</div>
		<div style="margin:0 auto;text-align:center">记录：共 <?php echo $count?>条 &nbsp; &nbsp;<?php echo $page?></div>
	</div> 
	<?php } else { ?>
	<h2>没有历史直播主题！</h2>
	<?php } ?>
</div> 
<!-- begin: #footer -->
<?php $this->load->view($cfg['tpl'] . 'public/footer');?>
<!-- end: #footer -->
</body>
</html>
