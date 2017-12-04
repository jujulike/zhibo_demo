<?php foreach($toplist as $k => $v) {?>
<div class="article article_content hot_<?php echo $v['ishot'] ?> cate_<?php echo $v['contentcate']?>">
	<h6>
	<b>&nbsp;直播观点</b><img src="<?php echo base_url('themes/images/icon/notice.gif');?>">&nbsp;<?php echo str_replace('<img', '<img onLoad="DrawImage(this,500,300)"', $v['content'])?> --<?php echo date("d日H时i分s秒", $v['ctime'])?>
	</h6>						
</div>
<?php } ?>
<script type="text/javascript">
	$("#lastcontentid").val('<?php echo empty($v["contentid"]) ? 0 : $v["contentid"]?>');
</script>