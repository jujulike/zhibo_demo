<?php $this->load->view($cfg['tpl_admin'] . 'public/header') ?>
<div class="so_main">
    <form id="form1">
        <INPUT TYPE="hidden" NAME="view" value="manage/user/modi_user">
        <INPUT TYPE="hidden" NAME="id" value="<?php echo $row['id']; ?>">
        <INPUT TYPE="hidden" NAME="passwd" value="<?php echo $row['passwd']; ?>">
        <div class="form3">
            <table width="580" >	
                <tr>
                    <td class="tbtitle">发言内容</td>
                    <td>
                        <textarea cols="60" rows="5" name="content" id="name"><?php echo set_value('content', $row['content']); ?></textarea>
                        <!--<input type="text" name="content" id="name" value="<?php echo set_value('content', $row['content']); ?>" />-->
                    </td>
                </tr>
                <tr>
                    <td class="tbtitle">状态</td>
                    <td>
                        <label><INPUT TYPE="radio" NAME="status" value="1" <?php if ($row['status'] == '1') { ?> checked <?php } ?>  />正常</label>&nbsp;
                        <label><INPUT TYPE="radio" NAME="status" value="0" <?php if ($row['status'] == '0') { ?> checked <?php } ?>  />屏蔽</label>&nbsp;
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td class="tbtitle"></td>
                    <td>
                        <input type="button" class="btn_b" value="提交" ONCLICK="submitUserModi()" />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<INPUT TYPE="reset" class="btn_b"></td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </div>
</div>
<?php $this->load->view($cfg['tpl_admin'] . 'public/footer') ?>
<script type="text/javascript">
    function submitUserModi()
    {
        postdata('form1', '<?php echo site_url("admin/say_manage/modi"); ?>', 'show');
    }

</script>

</body>
</html>
