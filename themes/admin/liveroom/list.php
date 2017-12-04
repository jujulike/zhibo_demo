<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<div class="so_main">
  <div class="page_tit">直播室管理</div>
  <!-------- 个人会员列表 -------->
  <div class="Toolbar_inbox">
  </div>
  <div class="list">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <!--<th class="line_l" width="30px">ID</th>-->
	<th class="line_l">直播室名称</th>
	<th class="line_l" width="150px">所属栏目</th>
	<th class="line_l" width="120px">创建时间</th>
	<th class="line_l" width="80px">关注度</th>
	<th class="line_l" width="80px">排序</th>
	<th class="line_l" width="80px">状态</th>
    <th class="line_l" width="120px">操作</th>
  </tr>
	  </tr>
	  <form id="form1" name="form1" action="" method="post">
		<?php if(!empty($list)) {?>
	  <?php foreach ($list as $k=>$v) {?>
	  <tr overstyle='on' id="user_1">
		<!--<td><?php echo $v['roomid']; ?></td>-->
		<td><?php echo $v['roomname']; ?></td>
		<td><?php echo $v['catename']; ?></td>
		<td><?php echo date('Y-m-d H:i:s',$v['ctime'])?></td>
		<td><?php echo $v['hits']?></td>
		<td><?php echo $v['sort']?></td>
		<td><?php if ($v['status'] == '1') { ?>有效<?php } else { ?>无效<?php } ?></td>
	    <td>
			<a href="javascript:modi(<?php echo $v['roomid']; ?>);" class="sgbtn">直播室设置</a></td>
			</tr>
		<?php } }?>
		</form>
	</table>
  </div>

<td colspan="9"><div class="page">记录:<?php if(!empty($pagecount)){  echo $pagecount;} ?> 条&nbsp;&nbsp;<?php if(!empty($page)){ echo $page;}?></div></td>

<script type="text/javascript">
function add() {
//	$.jBox("get:<?php echo site_url('admin/user/add')?>");
	$.jBox("iframe:<?php echo site_url('admin/liveroom/add')?>", {
			title: "",
			iframeScrolling: 'auto',
			height: 500,
			width: 500,
			buttons: { '关闭': true }
		});
}

function modi(id)
{
	$.jBox("iframe:<?php echo site_url('admin/liveroom/modi/" + id + "')?>", {
			title: "信息修改",
			iframeScrolling: 'auto',
			height: 500,
			width: 320,
			buttons: { '关闭': true }
		});
}


function del(id) {
    var submit = function (v, h, f) {
        if (v == 'ok')
		{
			$.get("<?php echo site_url('admin/liveroom/del/" + id + "');?>", function(){location.reload();}); 
			jBox.tip(v, 'info');
		}

		return true; //close
    };

	$.jBox.confirm("删除直播室会删除相应的直播主题，确定删除吗？", "提示", submit);
}
</script>
<?php $this->load->view($cfg['tpl_admin'] . 'public/footer')?>
