<?php $this->load->view($cfg['tpl_admin'] . 'public/header') ?>
<div class="so_main">
    <div class="list">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <form id="form1" name="form1" action="" method="post" onsubmit="say_start(); return false;">
                <tr overstyle='on'>
                    <td width="60"> </td>
                    <td><b>一句话一行</b></td>
                </tr>
                <tr overstyle='on'>
                    <td>发言内容</td>
                    <td><textarea cols="100" rows="15" name="content"></textarea></td>
                </tr>
                <tr overstyle='on'>
                    <td>发言间隔</td>
                    <td><input type="text" name="gap"></td>
                </tr>
                <tr overstyle='on'>
                    <td> </td>
                    <td><input type="submit" value="提交"></td>
                </tr>
            </form>
        </table>
    </div>

    <script type="text/javascript">
        //鼠标移动表格效果
        $(document).ready(function() {
            $("tr[overstyle='on']").hover(
                    function() {
                        $(this).addClass("bg_hover");
                    },
                    function() {
                        $(this).removeClass("bg_hover");
                    }
            );
        });

        function say_start()
        {
            postdata('form1', "<?php echo site_url('admin/say_setting/say_start'); ?>", 'wshow');
        }


    </script>
<?php $this->load->view($cfg['tpl_admin'] . 'public/footer') ?>
