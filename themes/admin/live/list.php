<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<div class="so_main">
  <div class="page_tit">直播室管理</div>
  <!-------- 个人会员列表 -------->
  <div class="Toolbar_inbox">
  </div>
  <div class="list">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th class="line_l" width="30px">ID</th>
	<th class="line_l" width="120px">类别名称</th>
	<th class="line_l" width="120px">应用对象</th>
	<th class="line_l" width="120px">排序</th>
	<th class="line_l" width="150px">状态</th>
    <th class="line_l">操作</th>
  </tr>
	  </tr>
	  <form id="form1" name="form1" action="" method="post">
		<?php if(!empty($list)) {?>
	  <?php foreach ($list as $k=>$v) {?>
	  <tr overstyle='on' id="user_1">
		<td><?php echo $v['cateid']; ?></td>
		<td><?php echo $v['catename']; ?></td>
		<td><?php echo $v['func']; ?></td>
		<td><?php echo $v['sort']; ?></td>
		<td><?php if ($v['status'] == '1') { ?><B>生效</B><?php } else { ?><B style="color:red">失效</B><?php } ?></td>
	    <td>
			<a href="javascript:modi(<?php echo $v['cateid']; ?>,'<?php echo $func ?>','<?php echo $alias?>');" class="sgbtn">类别修改</a>&nbsp;&nbsp;
			<a href="<?php echo site_url("admin/liveroom/tlist") . "/" . $v['cateid'];?>" class="sgbtn">管理直播室</a></td>
			</tr>
		<?php } }?>
		</form>
	</table>
  </div>
<script type="text/javascript">
<!--
function add() {
//	$.jBox("get:<?php echo site_url('admin/user/add')?>");
	$.jBox("iframe:<?php echo site_url('admin/category/add' . '/' . $func)?>", {
			title: "",
			iframeScrolling: 'auto',
			height: 330,
			width: 350,
			buttons: { '关闭': true }
		});
}

function modi(id,func)
{
	$.jBox("iframe:<?php echo site_url('admin/category/modi/" + id + "'. '/' . $func)?>", {
			title: "信息修改",
			iframeScrolling: 'auto',
			height: 330,
			width: 350,
			buttons: { '关闭': true }
		});
}

function del(id) {
    var submit = function (v, h, f) {
        if (v == 'ok')
		{
			$.get("<?php echo site_url('admin/live/del/" + id + "');?>", function(){location.reload();}); 
			jBox.tip(v, 'info');
		}

		return true; //close
    };

	$.jBox.confirm("确定删除吗？", "提示", submit);
}
</script>
<?php $this->load->view($cfg['tpl_admin'] . 'public/footer')?>
