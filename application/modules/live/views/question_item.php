<?php
if (!empty($contentlist)) {
	foreach($contentlist as $k => $v) {?>
<div class="article" id="question_<?php echo $v['questionid']?>" <?php if ($v['answercontent']) { ?> style="border-bottom:none"<?php }?>>
						<h6>
						<img class="ask-no" src="<?php echo base_url("themes/images/public/clear.gif")?>"><span class="orange">网友(<?php echo $v['questionname']?>)问：</span><?php echo $v['questioncontent']?>&nbsp;&nbsp;
						<?php if ($u['role']>0) { ?><a href="###" onclick="sendanswer(<?php echo $v['questionid']?>)" class="green">【回答】</a><?php } ?>
						</h6>						
					</div>
					<?php if ($v['answercontent']) { ?>
					<div class="article">
						<h6>
						<img class="ask-yes" src="<?php echo base_url("themes/images/public/clear.gif")?>"><span class="orange">播主(<?php echo $v['answername']?>)回复：</span><span id="<?php echo $v['questionid']?>"><?php echo $v['answercontent']?></span>--<i><?php echo date("d日H时i分s秒", $v['mtime'])?></i>
						</h6>						
					</div>
					<?php } ?>
<?php } ?>
<?php } ?>