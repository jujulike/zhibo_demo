<?php $this->load->view($cfg['tpl_admin'] . 'public/header') ?>
<div class="so_main">
    <form id="form1">
        <INPUT TYPE="hidden" NAME="userid" value="<?php echo $row['userid']; ?>">
        <div class="form3">
            <table width="" >	
                <tr>
                    <td class="tbtitle">发言间隔</td>
                    <td>
                        <input type="text" name="gap" id="name" value="<?php echo set_value('gap', $row['gap']); ?>" />
                    </td>
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
        postdata('form1', '<?php echo site_url("admin/say_manage/say"); ?>', 'show');
    }

</script>

</body>
</html>
