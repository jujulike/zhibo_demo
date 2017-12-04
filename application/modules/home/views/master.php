		<?php foreach ($list as $k => $v) {?>
		<div class="lszb">
                <img <?php if ($v['userphoto'] == '') {?>src="<?php echo base_url('themes/images/avatar/male.gif') ?>" <?php } else {?>src="<?php echo base_url($v['userphoto']) ?>"<?php }?> />
                <h4><?php echo $v['author']?></h4>

               <?php if (!empty($v['lasttime']) && ($v['lasttime'] + $this->config->item('master_status_sleep') > time() )) { ?>
			   <a href="<?php echo site_url('live/room/' . $v['roomid'])?>" target="_blank"><img src="images/vip_enter.jpg"  style="margin-top:15px;" /></a>
			   <?php } else { if ($v['status'] == '1') {?>
			    <a href="<?php echo site_url('live/room/' . $v['roomid'])?>" ><img src="images/vip_40.jpg"  style="margin-top:15px;" /></a>
				<?php } else {?>
			   <a href="<?php echo site_url('live/lastDetail/' . $v['masterid'])?>" target="_blank"><img src="images/vip_40.jpg" style="margin-top:15px;"/></a><?php } } ?>
                <div class="clear"></div>
                <p style="width:200px; font-size:14px; line-height:22px;"><?php echo long2short(html2text($v['content']),0,65,'......')?></p>
        </div>
		<?php }?>
