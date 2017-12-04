<?php 
if (!empty($userlist)) {
foreach($userlist as $k => $v) {?>
<div class="article">
	<h6>
	<b>&nbsp;被禁言网友 :  <?php echo $v['username']?>:</b>&nbsp;&nbsp;<a href="javascript:void(0)" style="color:#E86300;font-size:14px" onclick="canchat('<?php echo $v['id']?>')" >激活</a>
	
	</h6>	
</div>
<?php } ?>
<script type="text/javascript">

	function canchat(id)
	{
		$.get("<?php echo site_url('module/live/chat/canChat')?>" + "/"+id,function(data){
			var d = eval('('+data+')');
			if (d.code == '1')
			{
				window.location.reload();
			}
			else
			{
				$.jBox.tip(d.msg,'error');
			}
		});
	}
</script>
<?php }?>
