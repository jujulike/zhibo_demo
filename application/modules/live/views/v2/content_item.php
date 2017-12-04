<style>
.red{border:1px solid #d00;background:#ffe9e8;color:#d00;}
</style>
<?php foreach($contentlist as $k => $v) {?>
<div class="article article_content hot_<?php echo $v['ishot'] ?> cate_<?php echo $v['contentcate']?> top_<?php echo $v['istop'] ?>" id="item_<?php echo $v['contentid']?>">
	<h6>
	<span class="orange">&nbsp;<?php echo $v['livecatename']?>:</span><img src="<?php echo base_url('themes/images/icon/notice.gif');?>">&nbsp; -- <?php echo date("m-d H:i", $v['ctime'])?><?php if ($v['istop'] == '1') {?><span style="float:right;margin-right:20px"><img src="<?php echo base_url('themes/images/icon/tu_03.jpg')?>"></span><?php } else if ($v['ishot'] == '1') {?><span style="float:right;margin-right:20px"><img src="<?php echo base_url('themes/images/icon/tu_06.jpg')?>"></span><?php }?> <br /> <div style="margin-left:10px"> <span id="<?php echo $v['contentid']?>"><?php echo str_replace('<img', '<img rel="'.$v['contentid'].'" onLoad="DrawImage(this,200,200)" onclick="preview_image(this)" class="upimg" ', $v['content'])?></span>
	<?php if (!empty($u) && ($u['userid'] == $masterinfo['userid'])) {?>
	<a href="javascript:modic(<?php echo $v['contentid']?>)" style="color:red">修改</a><?php }?>
	</div>
	</h6>
</div>
<?php } ?>
<script type="text/javascript">
	$("#lastcontentid").val('<?php echo empty($v["contentid"]) ? 0 : $v["contentid"]?>');
shake($("#item_<?php echo $v['contentid']?>"),"red",3);
</script>