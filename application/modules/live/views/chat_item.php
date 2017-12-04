<?php 
if (!empty($chatlist)) {
foreach($chatlist as $k => $v) {?>
<div class="article" id="audit_<?php echo $v['chatid']?>">
	<h6>
	<span class="orange">&nbsp;<?php echo $v['chatname']?>:</span>
	<?php echo @$v['chatcontent']?>--<span><?php echo date("H:i:s", $v['ctime'])?></span>	
	</h6>
	
	<?php if (!empty($u) && $u['level'] >= 0) {?>	
	<?php if ($isaudit == 1) { if (!empty($u['ismaster']) && ($masterinfo['roomid'] == $u['ismaster']) && ($v['status'] == 0)) { if ($u['userid'] != $v['chatuserid']) {?><div style="float:right"><a href="javascript:void(0)" class="red" onclick="chataudit('<?php echo $v['chatid']?>','1')">通过</a>&nbsp;<a href="javascript:void(0)" class="red" onclick="chataudit('<?php echo $v['chatid']?>','3')" >删除</a>&nbsp;</div><?php } } } }?>
</div>
<?php } ?>
<script type="text/javascript">
	$("#lastchatid").val('<?php echo empty($v["chatid"]) ? 0 : $v["chatid"]?>');	
</script>
<?php }?>
