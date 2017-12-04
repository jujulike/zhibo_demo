<?php
if (!empty($list)) { 
foreach ($list as $k => $v) { ?>
<li>
<div class="img-68 img-bd"> 
<a href="<?php echo site_url('live/room') . '/' . $v['ismaster'] ?>" target="_blank">
					<?php if (!empty($v['imgthumb'])) { ?>
						<img src="<?php echo base_url($v['imgthumb']);?>"  width=68 height=68 />
					<?php } else { ?>
						<?php if ($v['gender'] == '2')  echo '<img src=' . base_url('themes/images/avatar/female.gif') . ' width=68 height=68>'; else echo   '<img src=' . base_url('themes/images/avatar/male.gif') . ' width=68 height=68>';?>
					<?php } ?></a>
</div>
<div class="w-160">
	<p class="">
		主播：<a href="<?php echo site_url('live/room') . '/' . $v['ismaster'] ?>" target="_blank"><?php echo $v['name']?></a></a><br>										
		简介：<?php echo $v['roominfo']['userinfo']?>
	</p>
</div>
</li>
<?php } ?>
<?php } ?>