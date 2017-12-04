<link type="text/css" media="all" rel="stylesheet" href="<?php echo base_url('themes/comm/js/jBox/Skins/Brown/jbox.css')?>" />

<script type="text/javascript" src="<?php echo base_url('themes/comm/js/jquery.form.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('themes/comm/js/jBox/jquery.jBox-2.3.min.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('themes/comm/js/jBox/i18n/jquery.jBox-zh-CN.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('themes/comm/js/f.js')?>"></script>
<script src="<?php echo base_url('themes/home/sendUtil.js')?>" type="text/javascript"></script>
<script type="text/javascript">

</script>

	<?php if (!empty($list)) { $i = 1; foreach ($list as $k => $v) {?>
	<table>
		<tr><td width="78"><?php if ($i == 1) {?><img src="<?php echo base_url('themes/images/home/vip_51.jpg')?>"><?php } else if ($i == 2) {?><img src="<?php echo base_url('themes/images/home/vip_57.jpg')?>"><?php } else if ($i==3){?><img src="<?php echo base_url('themes/images/home/vip_67.jpg')?>"><?php } else {echo $i;}?></td>
			<td class="tdul"><ul><ol><a href="#"><img src="<?php if (!empty($v['roomimgthumb'])) echo base_url($v['roomimgthumb']); else echo base_url('themes/images/avatar/default_room.jpg')?>"></a></ol>
				<li class="fwr">
				<?php if (empty($u)) {?>
					<a href="<?php echo site_url('live/lastDetail/' . $v['masterinfo']['masterid'])?>" target="_blank"><?php echo $v['roomname']?></a>
				<?php } else {?>
				<?php if (date("Y-m-d",$v['masterinfo']['ctime']) == date("Y-m-d")) {?>
					<a href="<?php echo site_url('live/room/' . $v['roomid'])?>" target="_blank"><?php echo $v['roomname']?></a>
				<?php } else { if ($v['masterinfo']['status'] == 1) {?>
					<a href="<?php echo site_url('live/room/' . $v['roomid'])?>" target="_blank"><?php echo $v['roomname']?></a>
				<?php } else {?>
					<a href="<?php echo site_url('live/lastDetail/' . $v['masterinfo']['masterid'])?>" target="_blank"><?php echo $v['roomname']?></a>
				<?php } } } ?></li><br />
				<!--<li>多空观点<span class="fb">震荡</span></li>-->
				<li>今日人气<em><?php echo $v['hits']?></em></li>
				<div class="clear"></div>
			</ul><td>

			<?php
				if (!empty($v['masterinfo']['etime']) && ($v['masterinfo']['etime'] + $this->config->item('master_status_sleep') > time() )) { ?>
					<td class="tddl"><dl><span style="color:red">正在直播...</span><dd><a href="<?php echo site_url('live/room') . '/' . $v['roomid']?>" target="_blank">主题:
					<?php echo @$v['masterinfo']['mastertitle']?></a></dd></dl></td>
					<td><a href="<?php echo site_url('live/room/' . $v['roomid'])?>" target="_blank"><img src="images/vip_enter.jpg" /></a><td>			
				<?php }else {?>
					<td class="tddl"><dl><span style="color:gray">暂停直播</span><dd><a href="<?php echo site_url('live/room') . '/' . $v['roomid']?>" target="_blank">主题:
					<?php echo @$v['masterinfo']['mastertitle']?></a></dd></dl></td>
					<td><a href="<?php echo site_url('live/room/' . $v['roomid'])?>" target="_blank"><img src="images/vip_40.jpg" /></a><td>			
				<?php } ?>


<!--
			<?php if (date("Y-m-d",$v['masterinfo']['ctime']) == date("Y-m-d")) {?>
				<td class="tddl"><dl><dt>主题</dt><dd><a href="<?php echo site_url('live/room') . '/' . $v['roomid']?>" target="_blank">				
					<?php echo @$v['masterinfo']['mastertitle']?></a></dd></dl></td>
				<td><a href="<?php echo site_url('live/room/' . $v['roomid'])?>" target="_blank"><img src="images/vip_enter.jpg" /></a><td>
			<?php } else { if ($v['masterinfo']['status'] == 1) { ?>
				<td class="tddl"><dl><dt>主题</dt><dd><a href="<?php echo site_url('live/room') . '/' . $v['roomid']?>" target="_blank">
				
					<?php echo @$v['masterinfo']['mastertitle']?></a></dd></dl></td>
				<td><a href="<?php echo site_url('live/room/' . $v['roomid'])?>" target="_blank"><img src="images/vip_40.jpg" /></a><td>
			<?php } else if ($v['masterinfo']['status'] == 2) {?>

				<td class="tddl"><dl><dt>主题</dt><dd><a href="<?php echo site_url('live/lastDetail/' . $v['masterinfo']['masterid'])?>" target="_blank">
				
					<?php echo @$v['masterinfo']['mastertitle']?></a></dd></dl></td>
				<td><a href="<?php echo site_url('live/lastDetail/' . $v['masterinfo']['masterid'])?>" target="_blank"><img src="images/vip_40.jpg" border="0"></a><td>
			<?php } }  ?>
-->
			
		</tr>
	</table>
	<?php  $i++; } }?>

