<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<div class="so_main">
  <div class="page_tit">Logo管理</div>
  
  <!-------- Logo列表 -------->
  <div class="Toolbar_inbox">
  	<div class="page right"></div>
	<a href="javascript:void(0);"" class="btn_a" onclick="add();"><span>添加Logo</span></a>
	<a  class="btn_a"  onclick="delMore()"><span>删除Logo</span></a>
  </div>
  <div class="list">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th style="width:30px;">
		<input type="checkbox" id="checkbox_handle" onclick="checkAll(this)" value="0">
    	<label for="checkbox"></label>
	</th>
    <th class="line_l" width="50px">ID</th>
    <th class="line_l" width="250px">标题</th>
	<th class="line_l" width="250px">Logo</th>
    <th class="line_l">状态</th>
    <th class="line_l">操作</th>
  </tr>
	  </tr>
	  <form id="form1" name="form1" action="" method="post">
	  <?php foreach ($list as $k=>$v) {?>
	  <tr overstyle='on' id="user_1">
	  	<td><input type="checkbox" name="id[]" id="checkbox2" onclick="checkon(this)" value="<?php echo $v['id']; ?>"></td>
			    <td><?php echo $v['id']; ?></td>
	    <td><?php echo $v['title']; ?></td>
		<td><img src="<?php echo base_url($v['imgthumb']); ?>" /></td>
	    <td><?php if ($v['status'] == '1') { ?><B>激活</B><?php } else { ?><B style="color:red">未激活</B><?php } ?></td>
	    <td>
			<a href="javascript:editLogo(<?php echo $v['id']; ?>);">编辑</a>
			<a href="javascript:del(<?php echo $v['id']; ?>);">删除</a>
					</td>
			</tr>
		<?php }?>
		</form>
	</table>
  </div>
<td colspan="9">记录:<?php echo $pagecount; ?> 条<?php echo $page;?></td>

  <div class="Toolbar_inbox">
	<div class="page right"></div>
	<a href="javascript:void(0);"" class="btn_a" onclick="add();"><span>添加Logo</span></a>
	<a  class="btn_a"  onclick="delMore()"><span>删除Logo</span></a>
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

	//获取已选择用户的ID数组
	function getChecked() {
		var uids = new Array();
		$.each($('table input:checked'), function(i, n){
			uids.push( $(n).val() );
		});
		return uids;
	}	

	// 添加
	function add() {
//	$.jBox("get:<?php echo site_url('admin/user/add')?>");
	$.jBox("iframe:<?php echo site_url('admin/setting/add')?>", {
			title: "Logo添加",
			iframeScrolling: 'auto',
			height: 440,
			width: 450,
			buttons: { '关闭': true }
		});
		}

	//编辑
	function editLogo(id)
	{
		$.jBox.open('iframe:<?php echo site_url("admin/setting/editLogo");?>'+"/"+id, "Logo修改", 450, 440, { buttons: { '关闭': true} });
	}

	//删除
	function del(id)
	{
	var submit = function (v, h, f) {
		if (v == 'ok')
			$.get("<?php echo site_url('admin/setting/delLogo');?>"+"/"+id, 
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

	$.jBox.confirm("确定删除该Logo吗？", "提示", submit);

}

	function delMore()
	{
		postdata('form1', "<?php echo site_url('admin/setting/delMore');?>", 'wshow');
	}

</script>


<?php $this->load->view($cfg['tpl_admin'] . 'public/footer')?>