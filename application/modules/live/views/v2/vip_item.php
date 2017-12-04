<?php 
if (!empty($viplist)) {
foreach($viplist as $k => $v) {?>
<div class="article article_content hot_<?php echo $v['ishot'] ?> cate_<?php echo $v['contentcate']?> top_<?php echo $v['istop'] ?>">
	<h6>
	<b>&nbsp;<?php echo $v['livecatename']?></b><img src="<?php echo base_url('themes/images/icon/notice.gif');?>">&nbsp;-- <?php echo date("m-d H:i:s", $v['ctime'])?><?php if ($v['istop'] == '1') {?><span style="float:right;margin-right:20px"><img src="<?php echo base_url('themes/images/icon/tu_03.jpg')?>"></span><?php } else if ($v['ishot'] == '1') {?><span style="float:right;margin-right:20px"><img src="<?php echo base_url('themes/images/icon/tu_06.jpg')?>"></span><?php }?> <br /><div style="font-size:14px;margin-top:20px;margin-left:20px"><span id="<?php echo $v['contentid']?>"><?php echo str_replace('<img', '<img onLoad="DrawImage(this,500,300)" onclick="preview_image(this)"', @$v['content'])?></span>
	<?php if ($u['userid'] == $masterinfo['userid']) {?>
	<a href="javascript:modiv(<?php echo $v['contentid']?>)" style="color:red">修改</a><?php }?>
	</div>
	</h6>
</div>
<?php } ?>
<script type="text/javascript">
	$("#lastvipid").val('<?php echo empty($v["contentid"]) ? 0 : $v["contentid"]?>');

function modiv(contentid)
{
	$.jBox("iframe:<?php echo site_url('module/live/content/editContent')?>"+"/"+contentid+"/1/3", {title: "修改直播内容",iframeScrolling: 'no',height: 400,width: 650,buttons: { '关闭': true }});
}

function preview_image(e)
{
	var image = $(e).attr('src');
	$("#previewimage").html('<img src="'+image+'" />');
	$.layer({
		type : 1,
		title : false,
		fix : false,
		shadeClose: true,
		area : ['auto','auto'],
		page : {dom : '#previewimage'}
	});
}
</script>
<?php }?>
