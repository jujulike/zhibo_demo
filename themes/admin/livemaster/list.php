<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<div class="so_main">
  <div class="page_tit">直播主题</div>
  <!-------- 个人会员列表 -------->
  <div class="Toolbar_inbox">
  </div>
  <div class="list">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <!--<th class="line_l" width="30px">ID</th>-->
	<th class="line_l">主题名称</th>
	<th class="line_l" width="150px">直播室名称</th>
	<th class="line_l" width="120px">播主</th>
	<th class="line_l" width="120px">开设时间</th>
	<th class="line_l" width="100px">关注度</th>
	<th class="line_l" width="100px">状态</th>
    <th class="line_l" width="120px">操作</th>
  </tr>
	  </tr>
	  <form id="form1" name="form1" action="" method="post">
		<?php if(!empty($list)) {?>
	  <?php foreach ($list as $k=>$v) {?>
	  <tr overstyle='on' id="user_1">
		<!--<td><?php echo $v['masterid']; ?></td>-->
		<td><?php echo $v['mastertitle']; ?></td>
		<td><?php echo $v['roomname']; ?></td>
		<td><?php echo $v['author']; ?></td>
		<td><?php echo date("m-d H:i", $v['ctime'])?></td>
		<td><?php echo $v['hits']?></td>
		<td><?php if ($v['status'] == '0') { ?>未开启<?php } elseif ($v['status'] == '1') { ?>进行中<?php } else { ?>结束<?php } ?></td>
	    <td>
			<a href="javascript:modi(<?php echo $v['masterid']; ?>);" class="sgbtn">信息修改</a>&nbsp;<a href="<?php echo site_url('admin/handan/tlist') . "/" . $v['masterid']; ?>" class="sgbtn">喊单管理</a>&nbsp;</td>
			</tr>
		<?php } }?>
		</form>
	</table>
  </div>

<td colspan="9"><div class="page">记录:<?php if(!empty($pagecount)){  echo $pagecount;} ?> 条&nbsp;&nbsp;<?php if(!empty($page)){ echo $page;}?></div></td>



<script type="text/javascript">
function add() {
//	$.jBox("get:<?php echo site_url('admin/user/add')?>");
	$.jBox("iframe:<?php echo site_url('admin/livemaster/add')?>", {
			title: "",
			iframeScrolling: 'auto',
			height: 500,
			buttons: { '关闭': true }
		});
}

function modi(id)
{
	$.jBox("iframe:<?php echo site_url('admin/livemaster/edit/" + id + "')?>", {
			title: "信息修改",
			iframeScrolling: 'auto',
			width:400,
			height: 350,
			buttons: { '关闭': true }
		});
}


function del(id) {
    var submit = function (v, h, f) {
        if (v == 'ok')
		{
			$.get("<?php echo site_url('admin/livemaster/del/" + id + "');?>", function(){location.reload();}); 
			jBox.tip(v, 'info');
		}

		return true; //close
    };

	$.jBox.confirm("确定删除吗？", "提示", submit);
}
</script>
<?php $this->load->view($cfg['tpl_admin'] . 'public/footer')?>
