<link type="text/css" media="all" rel="stylesheet" href="<?php echo base_url('themes/comm/js/jBox/Skins/Brown/jbox.css')?>" />

<script type="text/javascript" src="<?php echo base_url('themes/comm/js/jquery.form.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('themes/comm/js/jBox/jquery.jBox-2.3.min.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('themes/comm/js/jBox/i18n/jquery.jBox-zh-CN.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('themes/comm/js/f.js')?>"></script>
<script src="<?php echo base_url('themes/home/sendUtil.js')?>" type="text/javascript"></script>
<ul>
	<li>
		<dt><a href="#"><?php echo $row['questionname']?></a>  <?php echo date("H:i:s",$row['ctime'])?></dt><br /><br />
		<dd><?php echo $row['questioncontent']?></dd>
	</li><br /><br /><br /><br /><br /><br /><br /><br />
	<li><div class="test"><?php echo $row['answername']?> <?php echo date("H:i:s",$row['mtime'])?>&nbsp;<?php if (date("Y-m-d",$masterinfo['ctime']) == date("Y-m-d")) {?><a href="<?php echo site_url('live/room/' . $masterinfo['roomid'])?>" target="_blank"><img src="images/vip_enter.jpg" /></a><?php } else {?><a href="<?php echo site_url('live/detailHistory/' . $masterinfo['masterid'])?>" target="_blank"><img src="images/vip_401.jpg" /></a><?php }?></div></li>
	<li><?php echo $row['answercontent']?></li>
</ul>
