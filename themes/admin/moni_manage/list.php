<?php $this->load->view($cfg['tpl_admin'] . 'public/header') ?>
<div class="so_main">
    <div class="page_tit">会员</div>

    <div id="searchUser_div" style="display:none;">
        <div class="page_tit">搜索用户 [ <a href="javascript:void(0);" onclick="searchUser();">隐藏</a> ]</div>

        <div class="form2">
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
        </div>
    </div>
    <!-------- 个人会员列表 -------->
    <div class="Toolbar_inbox">
        <div class="page right"></div>
        <a  class="btn_a"  onclick="del_user()"><span>删除会员</span></a>
        <span style="margin-left: 30px;">生成<input type="text" name="moni_count" style="width: 30px;">个虚拟人 <a  class="btn_a"  onclick="create_user()"><span>确定</span></a></span>
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
                <th class="line_l" width="10%">用户名</th>
                <th class="line_l" width="10%">姓名</th>
                <th class="line_l" width="10%">QQ</th>
                <th class="line_l" width="10%">邮箱</th>
                <th class="line_l" width="10%">电话</th>
                <th class="line_l" width="10%">注册IP</th>
                <th class="line_l" width="10%">会员等级</th>
                <th class="line_l" width="5%">身份</th>
                <?php if ($cfg['open_recommend'] == '1') { ?>
                    <th class="line_l" width="5%">推荐号</th>
                <?php } ?>
                <th class="line_l">操作</th>
            </tr>
            </tr>
            <form id="form1" name="form1" action="" method="post">
                <?php if (!empty($list)) { ?>
                    <?php foreach ($list as $k => $v) { ?>
                        <tr overstyle='on' id="user_1">
                            <td><input type="checkbox" name="userid[]" id="checkbox2" onclick="checkon(this)" value="<?php echo $v['userid']; ?>"></td>
                            <td><?php echo $v['userid']; ?></td>
                            <td><?php echo $v['username']; ?></td>
                            <td><?php echo $v['name']; ?></td>
                            <td><?php echo $v['qq']; ?></td>
                            <td><?php echo $v['email']; ?></td>
                            <td><?php echo $v['phone']; ?></td>
                            <td><?php echo long2ip($v['regip']); ?></td>
                            <td>
                                <a href="javascript:setLevel(<?php echo $v['userid']; ?>);" class="sgbtn"><?php
                                    if (empty($v['ismaster'])) {
                                        $level = $this->config->item('level');
                                        echo $level[$v['level']]['name'];
                                    } else {
                                        $kflevel = $this->config->item('kflevel');
                                        echo $kflevel[$v['level']]['name'];
                                    }
                                    ?></a>
                            </td>
                            <?php if (!empty($v['ismaster'])) { ?>
                                <td><a href="javascript:setMaster(<?php echo $v['userid']; ?>);">播主</a></td>				
                            <?php } else { ?>
                                <td><a href="javascript:setMaster(<?php echo $v['userid']; ?>);">会员</a></td>	
                            <?php } ?>
                            <?php if ($cfg['open_recommend'] == '1') { ?>
                                <td>
                                    <?php echo $v['recommid']; ?>
                                </td>
                            <?php } ?>

                            <td>
                                <!--<a href="javascript:<?php echo $v['is_say'] != 1 ? 'say(' . $v['userid'] . ')' : 'nosay(' . $v['userid'] . ')'; ?>;" class="sgbtn"><?php echo $v['is_say'] != 1 ? '启用' : '禁用'; ?></a>-->
                                <a href="javascript:modi(<?php echo $v['userid']; ?>);" class="sgbtn">修改</a>
                                <a href="javascript:delUser(<?php echo $v['userid']; ?>);" class="sgbtn">删除</a>
                            </td>
                        </tr>
                    <?php }
                } ?>
            </form>
        </table>
    </div>

    <td colspan="9"><div class="page">记录:<?php if (!empty($pagecount)) {
                    echo $pagecount;
                } ?> 条&nbsp;&nbsp;<?php if (!empty($page)) {
                    echo $page;
                } ?></div></td>

    <div class="Toolbar_inbox">
        <div class="page right"></div>
        <a  class="btn_a"  onclick="del_user()"><span>删除会员</span></a>
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
                $('input[name="userid[]"]').attr('checked', 'true');
                $('tr[overstyle="on"]').addClass("bg_on");
            } else {
                $('input[name="userid[]"]').removeAttr('checked');
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

        function openreg()
        {
            $.jBox.open('iframe:<?php echo site_url("admin/user/add"); ?>', "用户添加", 500, 420, {buttons: {'关闭': true}});
        }

        function setLevel(userid)
        {
            $.jBox.open('iframe:<?php echo site_url("admin/user/setLevel"); ?>' + "/" + userid, "用户等级设置", 500, 420, {buttons: {'关闭': true}});
        }

        function say(userid)
        {
            $.jBox.open('iframe:<?php echo site_url("admin/say_manage/say"); ?>' + "/" + userid, "发言设置", 300, 150, {buttons: {'关闭': true}});
        }

        function nosay(userid)
        {
            $.get("<?php echo site_url('admin/say_manage/nosay'); ?>" + "/" + userid, function() {});
            location.reload();
        }

        function modi(userid)
        {
            $.jBox.open('iframe:<?php echo site_url("admin/user/modi"); ?>' + "/" + userid, "用户信息修改", 300, 350, {buttons: {'关闭': true}});
        }

        function create_user()
        {
            var moni_count = $('input[name="moni_count"]').val();
            $.get("<?php echo site_url("admin/moni_manage/create_user"); ?>" + "/" + moni_count, {}, function(){
                window.location.reload();
            });
        }

        // 设为播主
        function setMaster(userid)
        {
            $.jBox.open('iframe:<?php echo site_url("admin/user/setMaster"); ?>' + "/" + userid, "用户身份设置", 500, 420, {buttons: {'关闭': true}});
        }



        function delUser(userid)
        {
            var submit = function(v, h, f) {
                if (v == 'ok')
                    $.get("<?php echo site_url('admin/user/del'); ?>" + "/" + userid,
                            function(d) {
                                var data = eval('(' + d + ')');
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

            $.jBox.confirm("确定删除该用户吗？", "提示", submit);

        }

        function del_user()
        {
            postdata('form1', "<?php echo site_url('admin/user/del_user'); ?>", 'wshow');
        }


    </script>
<?php $this->load->view($cfg['tpl_admin'] . 'public/footer') ?>
