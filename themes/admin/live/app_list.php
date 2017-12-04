<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<div class="so_main">
  <div class="page_tit">直播申请管理</div>
  <!-------- 个人会员列表 -------->
  <div class="Toolbar_inbox">
  </div>
  <div class="list">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th class="line_l" width="30px">ID</th>
	<th class="line_l" width="120px">申请直播室名称</th>
	<th class="line_l" width="120px">所属栏目</th>
	<th class="line_l" width="120px">直播时间</th>
	<th class="line_l" width="150px">联系人</th>
	<th class="line_l" width="200px">联系方式</th>
    <th class="line_l">操作</th>
  </tr>
	  </tr>
	  <form id="form1" name="form1" action="" method="post">
		<?php if(!empty($list)) {?>
	  <?php foreach ($list as $k=>$v) {?>
	  <tr overstyle='on' id="user_1">
		<td><?php echo $v['roomid']; ?></td>
		<td><?php echo $v['roomname']; ?></td>
		<td><?php echo $v['catename']; ?></td>
		<td><?php echo $v['btime']?>时-<?php echo $v['etime']?>时</td>
		<td><?php echo $v['linkman']; ?></td>
		<td>电话:<?php echo $v['linkphone'] ?> QQ:<?php echo $v['linkqq'] ?></td>
	    <td>
			<a href="javascript:modi(<?php echo $v['roomid']; ?>);" class="sgbtn">信息审核</a>&nbsp;&nbsp;</td>
			</tr>
		<?php } }?>
		</form>
	</table>
  </div>

<td colspan="9"><div class="page">记录:<?php if(!empty($pagecount)){  echo $pagecount;} ?> 条&nbsp;&nbsp;<?php if(!empty($page)){ echo $page;}?></div></td>

<script type="text/javascript">
//鼠标移动表格效果
	$(document).ready(function(){
		$("tr[overstyle='on']").hover(
		  function () {
		    $(this).addClass("bg_hover");
		  },
		  function () {
		    $(this).removeClass("bg_hover");
		  }
		);
	});


function modi(id)
{
	$.jBox("iframe:<?php echo site_url('admin/liveapp/modi/" + id + "')?>", {
			title: "信息修改",
			iframeScrolling: 'auto',
			height: 500,
			width: 450,
			buttons: { '关闭': true }
		});
}


function del(id) {
    var submit = function (v, h, f) {
        if (v == 'ok')
		{
			$.get("<?php echo site_url('admin/liveapp/del/" + id + "');?>", function(){location.reload();}); 
			jBox.tip(v, 'info');
		}

		return true; //close
    };

	$.jBox.confirm("确定删除吗？", "提示", submit);
}

function del_app()
{
	postdata('form1', "<?php echo site_url('admin/liveapp/del_app');?>", 'wshow');
}


</script>
<?php $this->load->view($cfg['tpl_admin'] . 'public/footer')?>
