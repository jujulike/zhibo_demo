<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<META HTTP-EQUIV="expires" CONTENT="0">
<title><?php echo SYSTEM_NAME; ?> - 用户管理</title>
<?php echo $this->load->view('admin/public/meta.php')?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('themes/admin/css/admincp.css')?>" media="all" />
</head>
<body>
<div id="append"></div>
<div class="container">

<h4 class="marginbot">
	内容管理 >> 地区级管理
</h4>
			
		<div class="mainbox">
			<form id="regionForm" name="regionForm">
			<lable>地区二级管理</lable>&nbsp;<input type="text" name="name" id="name" />&nbsp;<a href="javascript:submitAdd()" class="sgbtn" >添加</a>
			</form>
            <div class="provincelist">
			
            <?php foreach($list as $item){?>
 
				<dt>
					<span><a href="<?php echo site_url('admin/region/city/' .$item['regionid']);?>"><?php echo $item['name']?></a></span>
					<span><a href="javascript:modi(<?php echo $item['regionid']?>,'<?php echo $item['name'] ?>')" class="sgbtn" style="font-size:12px">修改</a><a href="javascript:delregion(<?php echo $item['regionid']?>)" class="sgbtn" style="font-size:12px;margin-left:-1px">删除</a></span>
				</dt>
			<?php }?>
            </div>
        </div>		
</div>
<script type="text/javascript">

function submitAdd()
{
	postdata('regionForm', "<?php echo site_url('admin/region/add/'.$parentid.'/1');?>", 'show');
}

function modi(regionid,name)
{
	$.jBox.open('iframe:<?php echo site_url("admin/region/edit");?>' + "/" + regionid + "/"  + encodeURIComponent(name), "地区修改", 500, 200, { buttons: { '关闭': true} });
}

function delregion(regionid)
{
	var submit = function (v, h, f) {
		if (v == 'ok')
			$.get("<?php echo site_url('admin/region/del');?>"+"/"+regionid, 
			function(d){
				var data = eval('('+d+')');
				if (data.code == '1')
				{
					gopage($("#pagecur").val(), $("#pagecount").val());
				}
				else
				{
					jBox.tip(data.msg, 'error');
				}
			});
			
		else if (v == 'cancel')
//			jBox.tip(v, 'info');
		return true; //close
	};

	$.jBox.confirm("确定删除该地区吗？", "提示", submit);

}

</script>
</body>
</html>
