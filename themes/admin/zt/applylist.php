<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<div class="so_main">
  <div class="page_tit">《<?php echo $zt['title']?>》活动申请列表</div>
  <!-------- 广告列表 -------->
  <div class="Toolbar_inbox">
  	<div class="page right"></div>
	<a href="<?php echo site_url('admin/zt/addApply/'.$zt['id'])?>" class="btn_a"><span>添加</span></a>
	<a  class="btn_a"  onclick="delMore()"><span>删除</span></a>
  </div>
  <div class="list">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th style="width:30px;">
		<input type="checkbox" id="checkbox_handle" onclick="checkAll(this)" value="0">
    	<label for="checkbox"></label>
	</th>
    <th class="line_l" width="50px">真实姓名</th>
	<th class="line_l" width="100px">手机号码</th>
    <th class="line_l" width="150px">身份证号码</th>
	<th class="line_l" width="120px">QQ</th>
	<th class="line_l" width="120px">客户类型</th>
	<th class="line_l" width="150">申请时间</th>
	<th class="line_l" width="100">申请状态</th>
    <th class="line_l">操作</th>
  </tr>
	  </tr>
	  <form id="form1" name="form1" action="" method="post">
	  <?php foreach ($list as $k=>$v) {?>
	  <tr overstyle='on' id="user_1">
	  	<td><input type="checkbox" name="id[]" id="checkbox2" onclick="checkon(this)" value="<?php echo $v['id']; ?>"></td>
		<td><?php echo $v['real_name']; ?></td>
	    <td><?php echo $v['mobile']; ?></td>
		<td><?php echo $v['card_no']; ?></td>
		<td><?php echo $v['qq']; ?></td>
	    <td><?php if ($v['user_type']=='1'){ ?>新客户<?php } else {?>老客户<?php }?></td>
		<td><?php echo date('Y-m-d H:i:s',$v['ctime']); ?></td>
		<td><?php if ($v['status'] == '1'){ ?>奖品已颁发<?php } else {?>奖品未颁发<?php }?></td>
	    <td>
			<a href="<?php echo site_url('admin/zt/editApply' .'/' . $v['id'])?>">编辑</a>
			<a href="javascript:del(<?php echo $v['id']; ?>);">删除</a>
					</td>
			</tr>
		<?php }?>
		</form>
	</table>
  </div>
<td colspan="9"><div class="page">记录:<?php echo $pagecount; ?> 条&nbsp;&nbsp;<?php echo $page;?></div></td>

  <div class="Toolbar_inbox">
	<div class="page right"></div>
	<a href="<?php echo site_url('admin/zt/addApply/'.$zt['id'])?>" class="btn_a"><span>添加</span></a>
	<a  class="btn_a"  onclick="delMore()"><span>删除</span></a>
  </div>
</div>
<script>
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
	
	function checkon(o){
		if( o.checked == true ){
			$(o).parents('tr').addClass('bg_on') ;
		}else{
			$(o).parents('tr').removeClass('bg_on') ;
		}
	}
	
	function checkAll(o){
		if( o.checked == true ){
			$('input[name="id[]"]').attr('checked','true');
			$('tr[overstyle="on"]').addClass("bg_on");
		}else{
			$('input[name="id[]"]').removeAttr('checked');
			$('tr[overstyle="on"]').removeClass("bg_on");
		}
	}
	
	//搜索专题
	var isSearchHidden = 1;
	function searchUser() {
		if(isSearchHidden == 1) {
			$("#searchUser_div").slideDown("fast");
			$(".searchUser_action").html("搜索完毕");
			isSearchHidden = 0;
		}else {
			$("#searchUser_div").slideUp("fast");
			$(".searchUser_action").html("搜索专题");
			isSearchHidden = 1;
		}
	}

	function folder(type, _this) {
		$('#search_'+type).slideToggle('fast');
		if ($(_this).html() == '展开') {
			$(_this).html('收起');
		}else {
			$(_this).html('展开');
		}
		
	}


	//删除
	function del(id)
	{
	var submit = function (v, h, f) {
		if (v == 'ok')
			$.get("<?php echo site_url('admin/zt/del');?>"+"/"+id, 
			function(d){
				var data = eval('('+d+')');
				if (data.code == '1')
				{
//					jBox.tip(data.msg, 'success');
//					jBox.tip(data.msg, 'success');
					location.reload();
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

	$.jBox.confirm("确定删除该申请吗？", "提示", submit);

}

	function delMore()
	{
		postdata('form1', "<?php echo site_url('admin/zt/delMore');?>", 'wshow');
	}

</script>


<?php $this->load->view($cfg['tpl_admin'] . 'public/footer')?>