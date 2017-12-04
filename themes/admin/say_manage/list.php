<?php $this->load->view($cfg['tpl_admin'] . 'public/header') ?>
<div class="so_main">
    <div class="page_tit">发言</div>

    <div id="searchUser_div" style="display:none;">
        <!--<div class="page_tit">搜索用户 [ <a href="javascript:void(0);" onclick="searchUser();">隐藏</a> ]</div>-->

        <!--        <div class="form2">
                    <form id="form3" name="form3" action="<?php echo site_url("admin/user"); ?>" method="post">
                        <dl class="lineD">
                            <dt>用户名：</dt>
                            <dd>
                                <input name="username" id="username" type="text" value="<?php echo $username ?>">
                                <p>用户进行登录的帐号</p>
                            </dd>
                        </dl>
                        <dl class="lineD">
                            <dt>注册时间：</dt>
                            <dd>
                                <input type="text" name="s_btime" id="s_btime" value="<?php echo $s_btime ?>" /> ~ <input type="text" name="s_etime" id="s_etime" value="<?php echo $s_etime ?>" />&nbsp;&nbsp;YYYY-MM-DD
                            </dd>
                        </dl>
                        <div class="page_btm">
                            <input type="submit" class="btn_b"  value="确定" />
                        </div>
                    </form>
                </div>-->
    </div>
    <!-------- 个人会员列表 -------->
    <div class="Toolbar_inbox">
        <div class="page right"></div>
        <a  class="btn_a"  onclick="del_say()"><span>删除内容</span></a>
        <a  class="btn_a"  onclick="add_say()"><span>添加内容</span></a>
        <!--        <a href="javascript:void(0);" class="btn_a" onclick="searchUser();">
                    <span class="searchUser_action">搜索用户</span>
                </a>-->
    </div>
    <div class="list">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th style="width:30px;">
                    <input type="checkbox" id="checkbox_handle" onclick="checkAll(this)" value="0">
                    <label for="checkbox"></label>
                </th>
                <th class="line_l" width="5%">ID</th>
                <th class="line_l" width="">发言内容</th>
                <th class="line_l" width="5%">状态</th>
                <th class="line_l" width="100">操作</th>
            </tr>
            </tr>
            <form id="form1" name="form1" action="" method="post">
                <?php if (!empty($list)) { ?>
                    <?php foreach ($list as $k => $v) { ?>
                        <tr overstyle='on' id="user_1">
                            <td><input type="checkbox" name="id[]" id="checkbox2" onclick="checkon(this)" value="<?php echo $v['id']; ?>"></td>
                            <td><?php echo $v['id']; ?></td>
                            <td><?php echo $v['content']; ?></td>
                            <td><?php echo $v['status'] == 1 ? '可用' : '不可用'; ?></td>
                            <td>
                                <a href="javascript:edit_say(<?php echo $v['id']; ?>);" class="sgbtn">修改</a>
                                <a href="javascript:delSay(<?php echo $v['id']; ?>);" class="sgbtn">删除</a>
                            </td>
                        </tr>
                    <?php }
                }
                ?>
            </form>
        </table>
    </div>

    <td colspan="9"><div class="page">记录:<?php
            if (!empty($pagecount)) {
                echo $pagecount;
            }
            ?> 条&nbsp;&nbsp;<?php
            if (!empty($page)) {
                echo $page;
            }
            ?></div></td>

    <div class="Toolbar_inbox">
        <div class="page right"></div>
        <a  class="btn_a"  onclick="del_say()"><span>删除内容</span></a>
        <!--        <a href="javascript:void(0);" class="btn_a" onclick="searchUser();">
                    <span class="searchUser_action">搜索用户</span>
                </a>-->
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

        function checkon(o) {
            if (o.checked == true) {
                $(o).parents('tr').addClass('bg_on');
            } else {
                $(o).parents('tr').removeClass('bg_on');
            }
        }

        function checkAll(o) {
            if (o.checked == true) {
                $('input[name="id[]"]').attr('checked', 'true');
                $('tr[overstyle="on"]').addClass("bg_on");
            } else {
                $('input[name="id[]"]').removeAttr('checked');
                $('tr[overstyle="on"]').removeClass("bg_on");
            }
        }

        //获取已选择用户的ID数组
        function getChecked() {
            var uids = new Array();
            $.each($('table input:checked'), function(i, n) {
                uids.push($(n).val());
            });
            return uids;
        }

        //搜索用户
        var isSearchHidden = 1;
        function searchUser() {
            if (isSearchHidden == 1) {
                $("#searchUser_div").slideDown("fast");
                $(".searchUser_action").html("搜索完毕");
                isSearchHidden = 0;
            } else {
                $("#searchUser_div").slideUp("fast");
                $(".searchUser_action").html("搜索用户");
                isSearchHidden = 1;
            }
        }

        function folder(type, _this) {
            $('#search_' + type).slideToggle('fast');
            if ($(_this).html() == '展开') {
                $(_this).html('收起');
            } else {
                $(_this).html('展开');
            }
        }

        function add_say()
        {
            $.jBox.open('iframe:<?php echo site_url("admin/say_manage/modi"); ?>', "添加发言内容", 800, 300, {buttons: {'关闭': true}});
        }

        function edit_say(id)
        {
            $.jBox.open('iframe:<?php echo site_url("admin/say_manage/modi"); ?>' + "/" + id, "发言内容修改", 800, 300, {buttons: {'关闭': true}});
        }

        function delSay(id)
        {
            var submit = function(v, h, f) {
                if (v == 'ok')
                    $.get("<?php echo site_url('admin/say_manage/del'); ?>" + "/" + id,
                            function(d) {
                                var data = eval('(' + d + ')');
                                if (data.code == '1')
                                {
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

            $.jBox.confirm("确定删除该内容吗？", "提示", submit);

        }

        function del_say()
        {
            postdata('form1', "<?php echo site_url('admin/say_manage/del_say'); ?>", 'wshow');
        }


    </script>
<?php $this->load->view($cfg['tpl_admin'] . 'public/footer') ?>
