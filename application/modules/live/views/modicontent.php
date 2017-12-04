<link type="text/css" media="all" rel="stylesheet" href="<?php echo base_url('themes/comm/js/jBox/Skins/Brown/jbox.css')?>" />
<script type="text/javascript" src="<?php echo base_url('themes/comm/js/jquery.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('themes/comm/js/jquery.form.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('themes/comm/js/jBox/jquery.jBox-2.3.min.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('themes/comm/js/jBox/i18n/jquery.jBox-zh-CN.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('themes/comm/js/f.js')?>"></script>

<style type="text/css">
<!--
.login{ background:#FEFAF1; border:1px solid #E7D5B4}
.login h6{ font-weight:100; border-bottom:1px solid #f0f0f0; text-indent:8px; padding:8px 0}
.box-login{ overflow:hidden; width:420px; margin:5px 8px}
.box-login td{ padding:6px 0; line-height:24px}
.login-con{border-top:1px solid #f0f0f0; padding:15px 0 20px 0; text-align:center; color:#666; line-height:24px}
.login-con .num{ font-family:'Arial'; font-weight:700; font-size:20px; color:#ff9000}
.newtitle{border:1px solid #ddd; padding:2px 5px; height:20px; line-height:20px; width:200px}
.red{color:red}
.newtextarea{border:1px solid #ddd; padding:2px 5px; height:100px; line-height:20px; width:300px}
-->
</style>
<body>
<!---------------------------顶部 -------------------------------------------------->
<!---------------------------内容区 #main -------------------------------------------------->
<div class="login clearfix">
			<form name="regform" id="regform">
			<table border="0" class="box-login" style="width:100%">
			<tbody>
			<tr>
				<td colspan="2">
				<?php if ($mtype == '1' || $mtype == '3') {?>
				<textarea name="content" id="content" style="width:600px;height:250px"><?php echo $row['content'];?></textarea>
				<?php } else if ($mtype == '2') {?>
				<textarea name="answercontent" id="content" style="width:600px;height:250px"><?php echo $row['answercontent'];?></textarea>
				<?php }?>
				</td>
				</tr>		
				<tr>
					<td>&nbsp;</td>
					<td style="padding-top:15px">
					<?php if ($mtype == '1'|| $mtype == '3') {?>
					<input type="button" onClick="modi(<?php echo $row['contentid']?>,<?php echo $mtype?>)" value=" 修 改 " class="login-button">
					<?php } else if ($mtype == '2') {?>
					<input type="button" onClick="modi(<?php echo $row['questionid']?>,<?php echo $mtype?>)" value=" 修 改 " class="login-button">
					<?php }?>
					&nbsp;&nbsp;</td>
				</tr>

			</tbody></table>			
			</form>
<script type="text/javascript">
function modi(contentid,mtype)
{
	editor.sync();
	postdata('regform', '<?php echo site_url("module/live/content/editContent");?>'+'/'+contentid+"/2/"+mtype, 'retmodi');
}

function retmodi(d)
{
	if(d.code == '1'){
		$("#" + d.modiid, parent.document).html(d.content);
		$.jBox.tip(d.msg, 'success');
		window.setTimeout(function () {
			if (d.mtype == '1')
			{
				top.tabshow($('.tab', parent.document).find("a[rel='live']"));
			}

			if (d.mtype == '2')
			{
				top.tabshow($('.tab', parent.document).find("a[rel='qa']"));
			}
			if (d.mtype == '3')
			{
				top.tabshow($('.tab', parent.document).find("a[rel='vip']"));
			}
			
			top.$.jBox.close();
		}, 1000);
	}else{
		$.jBox.tip(d.msg,'error');
	}
}


function initcontent() {
	KindEditor.ready(function(K) {
		K.basePath = '<?php echo base_url('themes/comm/js/kindeditor/')?>/';
		editor = K.create('#content', {
			items : ['fontname','fontsize','|','forecolor','bold','italic','underline', '|', 'justifyleft', 'justifycenter', 'justifyright', '|','image','emoticons']
		});
	});
}		

$.ajax({
  url: '<?php echo base_url('themes/comm/js/kindeditor/kindeditor-min.js')?>',
  dataType: "script",
	async: false,
  success: initcontent
});

</script>

</body>
</html>
