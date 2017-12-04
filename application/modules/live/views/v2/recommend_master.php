<?php
if (!empty($list)) { 
foreach ($list as $k => $v) { ?>
<tr>
	<td><?php echo $k+5?></td>
	<td><?php echo $v['roomname']?></td>
	<td><?php echo $v['hits']?></td><td>
	<td><?php echo @$v['masterinfo']['mastertitle']?></td>
	<td>
	<?php if (!empty($v['masterinfo']['etime']) && ($v['masterinfo']['etime'] + $this->config->item('master_status_sleep') > time() )) { ?>
		<a href="<?php echo site_url('live/room') . '/' . $v['roomid']?>" target="_blank" style="color:red">正在直播</a>
	<?php }else {?>
		<a href="<?php echo site_url('live/room') . '/' . $v['roomid']?>" target="_blank">暂停直播</a>
	<?php } ?>
	</td>
</tr>
<?php } ?>
<?php } ?>