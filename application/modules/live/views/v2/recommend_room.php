<?php foreach ($list as $k => $v) { ?>
<div class="grid_8 clearfix">
	<ul>
		<li>
		<div class="img-80 img-bd" style="margin-right:6px;"> 
		<a href="<?php echo site_url('live/room') . '/' . $v['roomid']?>" target="_blank"><img width="80" height="80" src="<?php if (!empty($v['roomimgthumb'])) echo base_url($v['roomimgthumb']); else echo base_url('themes/images/avatar/default_room.jpg')?>"></a> 
		</div>
		<div class="w-160">
			<p class="font-size14">
				<span style="margin:4px;font-weight:700"><a href="<?php echo site_url('live/room') . '/' . $v['roomid']?>" target="_blank" class="orange"><?php echo $v['roomname'] ?></a></span><br/>
				<span>主题：<?php echo @$v['masterinfo']['mastertitle']?></span><br/>
				<?php
				if (!empty($v['masterinfo']['etime']) && ($v['masterinfo']['etime'] + $this->config->item('master_status_sleep') > time() )) { ?>
					<span style="color:red">正在直播...</span>
				<?php }else {?>
					<span style="color:gray">暂停直播</span>
				<?php } ?>
				<img src="<?php echo base_url('themes/images/icon/people-ico.gif')?>">
				&nbsp;<span class="gray" style="font-size:12px"><?php echo $v['hits']?>人已看</span>
			</p>
		</div>
		</li>
	</ul>
</div>
<?php } ?>