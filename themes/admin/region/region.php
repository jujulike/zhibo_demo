<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<div class="so_main">
  <div class="page_tit">地区管理</div>
</head>
<body>
<div class="so_main">
  <div class="page_tit">地区配置</div>
  <div class="Toolbar_inbox">
    <?php if ($parentid != '0') {?><a href="<?php echo site_url('admin/region/regionList' . '/' . $parentid )?>" class="btn_a"><span>返回</span></a><?php }?>    
	<a href="javascript:void(0);" class="btn_a" onclick="add(<?php echo $regionid;?>,<?php echo $regiontype;?>);"><span>添加地区</span></a>
    <a href="javascript:void(0);" class="btn_a" onclick="delMore();"><span>删除地区</span></a>
  </div>
  
  <div class="list">
  <table id="area_list" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th style="width:30px;">
        <input type="checkbox" id="checkbox_handle" onclick="checkAll(this)" value="0">
        <label for="checkbox"></label>
    </th>
    <th class="line_l">ID</th>
    <th class="line_l">地区名称</th>
	<!--<th class="line_l">是否热门</th>-->
    <th class="line_l">操作</th>
  </tr>
  <form id="form1" name="form1" action="" method="post">
  <?php foreach ($list as $k=>$v) {?>
  <tr overstyle='on' id="area_2">
        <td><input type="checkbox" name="regionid[]" id="checkbox2" onclick="checkon(this)" value="<?php echo $v['regionid']; ?>"></td>
		<td><?php echo $v['regionid']; ?></td>
        <td><div style="float:left"><a href="<?php echo site_url('admin/region/regionList' . '/' . $v['regionid'])?>" id="area_title_2"><?php echo $v['name'];?></a></div></td>
		<!--<td><?php if ($v['ishot'] == '1') { echo '是';} else { echo '否';} ?></td>-->
        <td>
            <a href="javascript:void(0);" onclick="edit(<?php echo $v['regionid']; ?>);">编辑</a>
			<input type="hidden" name="regiontype" id = "regiontype" value="<?php echo $v['regiontype']; ?>">
            <a href="javascript:void(0);" onclick="del(<?php echo $v['regionid']; ?>);">删除</a>  
        </td>
      </tr>  
<?php }?>
</form>
</table>
  </div>
  <div class="Toolbar_inbox">
    <?php if ($parentid != '0') {?><a href="<?php echo site_url('admin/region/regionList' . '/' . $parentid )?>" class="btn_a"><span>返回</span></a><?php }?>    <a href="javascript:void(0);" class="btn_a" onclick="add();"><span>添加地区</span></a>
    <a href="javascript:void(0);" class="btn_a" onclick="delMore();"><span>删除地区</span></a>
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
			$('input[name="regionid[]"]').attr('checked','true');
			$('tr[overstyle="on"]').addClass("bg_on");
		}else{
			$('input[name="regionid[]"]').removeAttr('checked');
			$('tr[overstyle="on"]').removeClass("bg_on");
		}
	}

    //获取已选择用户的ID数组
    function getChecked() {
        var gids = new Array();
        $.each($('input:checked'), function(i, n){
            gids.push( $(n).val() );
        });
        return gids;
    }

    //添加地区
    function add(regionid,regiontype) {
		//var regiontype =$("#regiontype").val();
        $.jBox.open('iframe:<?php echo site_url("admin/region/addRegion");?>' + '/' + regionid + '/' + regiontype, "添加地区", 500, 200, { buttons: { '关闭': true} });
    }
    
    //编辑地区
    function edit(area_id) {
         $.jBox.open('iframe:<?php echo site_url("admin/region/editRegion");?>' + '/' + area_id, "编辑地区", 500, 200, { buttons: { '关闭': true} });
    }

	//删除
	function del(reginid)
	{
	var submit = function (v, h, f) {
		if (v == 'ok')
			$.get("<?php echo site_url('admin/region/del');?>"+"/"+reginid, 
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
    
    function delMore()
	{
		postdata('form1', "<?php echo site_url('admin/region/delMore');?>", 'show');
	}
</script>

<?php $this->load->view($cfg['tpl_admin'] . 'public/footer')?>

