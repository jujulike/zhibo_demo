<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<div class="so_main">
 
  <form id="form1">
  <input type="hidden" name="userid" value="<?php echo $row['userid']?>"/>
  <div class="form3">
	为播主设置直播室：(如果是会员，则都不选)
    <table width="400" >	
				
			<?php foreach ($roomlist as $k => $v) {
				if (!empty($v['checkbox'])){?>
            <tr>
                <td width="30%"><?php echo $v['name']; ?></td>
                <td colspan="2">	
					<?php echo $v['checkbox']; ?>
				</td>
            </tr>
			<?php } ?>
			<tr>
                <td colspan="3"></td>
            </tr>	
			<?php }?>            
            <tr>
                <td></td>
                <td colspan="2">
					<input type="button" class="btn_b" value="提交" ONCLICK="submitSet()" />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<INPUT TYPE="reset" class="btn_b"> </td>
            </tr>
      </table>
  </div>
  </form>
</div>
<?php $this->load->view($cfg['tpl_admin'] . 'public/footer')?>

<script type="text/javascript">
function submitSet()
{
	postdata('form1', "<?php echo site_url('admin/user' . '/' . $act . '/' . $row['userid']);?>", 'show');
}

</script>
