<?php
if (!empty($list)) { 
foreach ($list as $k => $v) { ?>
<ul class="recos-s">
	<li class="recos-s-even">
	<a class="recos-pic" href="<?php echo site_url('live/room') . '/' . $v['ismaster'] ?>">
					<?php if (!empty($v['imgthumb'])) { ?>
						<img src="<?php echo base_url($v['imgthumb']);?>"  width=65 height=65 />
					<?php } else { ?>
						<?php if ($v['gender'] == '2')  echo '<img src=' . base_url('themes/images/avatar/female.gif') . ' width=65 height=65>'; else echo   '<img src=' . base_url('themes/images/avatar/male.gif') . ' width=65 height=65>';?>
					<?php } ?></a>
		<div>
			<h6>播主：<a href="###"><?php echo $v['name']?></a></h6>
			<?php if (!empty($v['masterinfo'])) { ?>
			<p>主题：<span class="orange"><?php echo $v['masterinfo']['mastertitle']?></span></p>
			<?php } ?>
		</div>
		<span style="padding:10px;">
		<?php if (!empty($v['masterinfo'])) { ?>
		<a  target="_blank" href="<?php echo site_url('live/room') . '/' . $v['ismaster'] ?>"> 
		<?php echo $v['masterinfo']['masterinfo']; ?>
		</a>
		<?php } ?>
		</span>

	</li>
</ul>
<?php } ?>
<?php } ?>