<?php $this->load->view($cfg['tpl_admin'] . 'public/header') ?>
<div class="so_main">
    <form id="form1">
        <div class="form3">
            <table width="430" >	

                <tr>
                    <td width="100" class="tbtitle">用户帐号<span style=" color:#ff0000">*</span></td>
                    <td width="180">
                        <textarea name="users" cols='40' rows='13'></textarea>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>每行一个，帐号和密码以|分割如：admin|admin</td>
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
        postdata('form1', '<?php echo site_url("admin/user/muladd/"); ?>', 'show');
    }

</script>

</body>
</html>
