<?php $this->load->view($cfg['tpl_admin'] . 'public/header') ?>
<div class="so_main">
    <form id="form1">
        <div class="form3">
            <table width="280" >	

                <tr>
                    <td width="100" class="tbtitle">用户帐号<span style=" color:#ff0000">*</span></td>
                    <td width="180">
                        <input type="text" name="username" id="username" value="" />				</td>
                </tr>
                <tr>
                    <td class="tbtitle">用户密码<span style=" color:#ff0000">*</span></td>
                    <td>
                        <input type="password" name="passwd" id="newpasswd"  value="" />				</td>
                </tr>
                <tr>
                    <td class="tbtitle">确认密码<span style=" color:#ff0000">*</span></td>
                    <td>
                        <input type="password" name="repasswd" id="repasswd"  value="" />				</td>
                </tr>
                <tr>
                    <td class="tbtitle">姓名</td>
                    <td>
                        <input type="text" name="name" id="name" value="" />					</td>
                </tr>
                <tr>
                    <td class="tbtitle">QQ</td>
                    <td>
                        <input type="text" name="qq" id="qq" value="" />					</td>
                    <td>&nbsp;</td>
                </tr>

                <tr>
                    <td class="tbtitle">电话</td>
                    <td>
                        <input type="text" name="phone" id="phone"  value="" />				</td>
                    <td>&nbsp;</td>
                </tr>

                <tr>
                    <td class="tbtitle">性别</td>
                    <td>
                        <label><INPUT TYPE="radio" NAME="gender" value="1" <?php if ($row['gender'] == '1') { ?> checked <?php } ?>  />男</label>&nbsp;
                        <label><INPUT TYPE="radio" NAME="gender" value="2" <?php if ($row['gender'] == '2') { ?> checked <?php } ?>  />女</label>&nbsp;
                        <label><INPUT TYPE="radio" NAME="gender" value="0" <?php if ($row['gender'] == '0') { ?> checked <?php } ?> />未知</label>				</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td class="tbtitle">帐号状况</td>
                    <td>
                        <label><INPUT TYPE="radio" NAME="status" value="1" <?php if ($row['status'] == '1') { ?> checked <?php } ?>  />正常</label>&nbsp;
                        <label><INPUT TYPE="radio" NAME="status" value="0" <?php if ($row['status'] == '2') { ?> checked <?php } ?>  />屏蔽</label>&nbsp;
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
        postdata('form1', '<?php echo site_url("admin/user/add/"); ?>', 'show');
    }

</script>

</body>
</html>
