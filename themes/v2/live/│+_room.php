
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"/>
        <title><?php echo $cfg['site_title']; ?></title>
        <meta name="renderer" content="webkit">
        <meta name="description" content="" />
        <meta name="keywords" content="<?php echo $cfg['site_title']; ?>" />

        <link href="/themes/v2/static/css/global.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="/themes/v2/static/css/jquery.mCustomScrollbar.css"/>
        <link rel="stylesheet" href="/themes/v2/static/css/jquery.sinaEmotion.css"/>

        <!--[if lt IE 9]>
        <link href="/themes/v2/static/css/less.css" rel="stylesheet" type="text/css">
        <script src="/themes/v2/static/js/css3-mediaqueries.js"></script>
        <![endif]-->

        <script type="text/javascript" src="/themes/v2/static/js/html5.js"></script>
        <script type="text/javascript" src="/themes/v2/static/js/jquery-1.9.js"></script>

        <script type="text/javascript" src="/themes/v2/js/layer/layer.min.js"></script>
        <script type="text/javascript" src="/themes/v2/static/js/jquery.form.js"></script>
        <script type="text/javascript" src="/themes/v2/static/js/jquery.mCustomScrollbar.js"></script>
        <script type="text/javascript" src="/themes/v2/static/js/jquery.sinaEmotion.js"></script>

        <script type="text/javascript" src="/themes/v2/static/js/tinybox2.js"></script>

        <script type="text/javascript" src="/themes/v2/static/js/room.api.js"></script>
        <script type="text/javascript" src="/themes/v2/static/js/room.init.js"></script>

        <style>
            .bo_logo{background-image:url(<?php if (!empty($cfg['imgthumb'])) echo base_url($cfg['imgthumb']); ?>)}
        </style>


    </head>
    <body>
        <div id="zoomWallpaperGrid" class="zoomWallpaperGrid">
            <img src="/themes/v2/static/images/551121af96d13.jpg"/>
        </div>
        <header>
            <h1 class="bo_logo f_left" id="headlogo">银金汇</h1>
            <span class="f_left" id="favlink">
                <a class="link1 left1" href="/themes/v2/static/down.php"><b>保存到桌面</b></a>
                <a class="link1 open_box" href="javascript:void(0);" rel="tiny" data-url="/index.php/nav/caijing" pwidth="1000" pheight="500"><b>财经日历</b></a>
                <a class="link1 open_box" href="javascript:void(0);" rel="tiny" data-url="/index.php/nav/baiyin" pwidth="1000" pheight="500"><b>白银ETF</b></a>
                <a class="link1 open_box" href="javascript:void(0);" rel="tiny" data-url="/index.php/nav/huangjin" pwidth="1000" pheight="500"><b>黄金ETF</b></a>
                <a class="link1" href="http://www.yinjinhui.com/forum.php?mod=forumdisplay&fid=2" target="_blank"><b>大师在线</b></a>
                <a class="link1" href="http://www.yinjinhui.com/forum.php?mod=forumdisplay&fid=36" target="_blank"><b>高手交流</b></a>
                <a class="link1" href="http://www.yinjinhui.com/forum.php?mod=forumdisplay&fid=37" target="_blank"><b>VIP学习</b></a>
                <a class="link1" href="http://www.yinjinhui.com" target="_blank"><b>更多</b></a>
                <div id="olzx">
                    <li class="swbt">
                    </li>
                    <?php
                    if (!empty($adlist['kefu'])) {
                        foreach ($adlist['kefu'] as $k => $v) {
                    ?>
                    <li style="display: none;">
                        <a onclick="qqbtclick(<?php echo $v['link'] ?>,'top')" href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $v['link'] ?>&amp;site=qq&amp;menu=yes" target="_blank">
                            <img class="qqimg" title="请加QQ：<?php echo $v['link'] ?>" alt="<?php echo $v['title'] ?>" src="http://wpa.qq.com/pa?p=2:<?php echo $v['link'] ?>:41">
                        </a>
                    </li>
                    <?php
                        }
                    }
                    ?>
                </div>
                <script>
                    $("#olzx .swbt").mouseenter(function(e) {
                        $(this).siblings().show();
                    });
                    $("#olzx").mouseleave(function(e) {
                        $("#olzx .swbt").siblings().hide();
                    });
                </script>
<!--                <a href="javascript:void(0)" onclick="AddFavorite('/', '金汇通')">收藏</a>
                <a href="javascript:void(0);" class="sidenav" rel="tiny" url="" pwidth="1000" pheight="500">公司官网</a>
                <a href="javascript:void(0);" class="sidenav jiangshi" rel="tiny" pwidth="830" pheight="480">讲师榜单</a>
                <a href="javascript:void(0);" class="sidenav caijing" url="http://www.dailyfx.com.hk/calendar/index.html">财经日历</a>	
                <a href="javascript:void(0);" class="sidenav">非农数据</a>
                <a href="javascript:void(0);" class="sidenav">原油库存</a>	
                <a href="javascript:void(0);" class="sidenav" rel="tiny" pwidth="1000" pheight="500">下载中心</a>	
                <a href="javascript:void(0);" class="sidenav" rel="tiny" url="" pwidth="700" pheight="370">课程安排</a>	
                <a href="javascript:void(0);" class="sidenav" rel="tiny" url="" pwidth="700" pheight="370">高级客服</a>-->
            </span>
            <span class="f_right" style="padding-top:1px;"><a href="javascript:initKefu4();" id="topqq2">联系我们</a></span>
            <span class="f_right" id="loginstatus"><span id="ykname"><img src="/themes/v2/static/images/17yk.png" title=""><a><?php echo $userinfo['name']; ?></a></span>
                <?php if ((!empty($userinfo)) && ($userinfo['level'] != '-1')) { ?>
                    <a id="btlogout" href="/index.php/user/logout">退出</a> 
                <?php } else { ?>
                    <a id="btreg" onclick="showRegForm();">注册会员</a><a id="btlogin" onclick="showLoginForm();">登录</a> 
                <?php } ?>
            </span>


            <div class="clearfix"></div>
        </header>

        <div id="main" class="clearfix ption_r" style="">
            <!-- 用户列表模块开始 -->
            <div id="user_use" class="f_left">
                <!--
                        <div class="mt">
                                
                        <ul>
                        <li id="n_3" class="curr" onclick="vote_nav_switch(3);">原油</li>  
                        <li id="n_4" class="line" onclick="vote_nav_switch(4);">白银</li>  
                        <li id="n_5" class="line" onclick="vote_nav_switch(5);">铜</li>
                        </ul>
                
                        </div>-->
                <div class="toupiao">
                    <div id="w_3" class="show">
                        <a class="t_up" href="javascript:void(0)" onclick="javascript:more_vote(2, 3)">看涨<em id="kz3"><?php echo $vote_result[3][2]['v'] ?>%</em></a>
                        <a class="t_leve" href="javascript:void(0)" onclick="javascript:more_vote(1, 3)">盘整<em id="pz3"><?php echo $vote_result[3][1]['v'] ?>%</em></a>
                        <a class="t_down" href="javascript:void(0)" onclick="javascript:more_vote(0, 3)">看空<em id="kk3"><?php echo $vote_result[3][0]['v'] ?>%</em></a></div>

                    <div id="w_4" class="hide">
                        <a class="t_up" href="javascript:void(0)" onclick="javascript:more_vote(2, 4)">看涨<em id="kz4"><?php echo $vote_result[4][2]['v'] ?>%</em></a>
                        <a class="t_leve" href="javascript:void(0)" onclick="javascript:more_vote(1, 4)">盘整<em id="pz4"><?php echo $vote_result[4][1]['v'] ?>%</em></a>
                        <a class="t_down" href="javascript:void(0)" onclick="javascript:more_vote(0, 4)">看空<em id="kk4"><?php echo $vote_result[4][0]['v'] ?>%</em></a></div>

                    <div id="w_5" class="hide">
                        <a class="t_up" href="javascript:void(0)" onclick="javascript:more_vote(2, 5)">看涨<em id="kz5"><?php echo $vote_result[5][2]['v'] ?>%</em></a>
                        <a class="t_leve" href="javascript:void(0)" onclick="javascript:more_vote(1, 5)">盘整<em id="pz5"><?php echo $vote_result[5][1]['v'] ?>%</em></a>
                        <a class="t_down" href="javascript:void(0)" onclick="javascript:more_vote(0, 5)">看空<em id="kk5"><?php echo $vote_result[5][0]['v'] ?>%</em></a></div>
                </div>	
                <div id="hangqing" style="margin-top:5px;height:144px">
                    <style>
                        .red{color:#f00;}
                        .green{color:#00B259;}
                        .datatable{padding-top: 5px}
                        .datatable td{color: #000; font-size: 14px; padding: 5px 0; padding-left: 5px; border-bottom: 1px solid #ccc;}
                        .datatable .t3 span{text-align: center;width: 85%; padding: 1px 3px; color: #fff;border-radius: 3px;display: block;}
                    </style>

                    <div style="height:144px; padding:3px 0;background-color: #ECECEC;">
                        <table class="datatable" width="100%" cellpadding="0" cellspacing="0">
                            <tbody><tr class="AG">
                                    <td class="t1">现货白银</td>
                                    <td class="t2" style="color: red;">3427.00</td>
                                    <td class="t3"><span style="background-color: red;">0.32</span></td>
                                </tr>
                                <tr class="PT">
                                    <td class="t1">现货铂金</td>
                                    <td class="t2" style="color: green;">229.00</td>
                                    <td class="t3"><span style="background-color: green;">-0.43</span></td>
                                </tr>
                                <tr class="PD">
                                    <td class="t1">现货钯金</td>
                                    <td class="t2" style="color: red;">155.00</td>
                                    <td class="t3"><span style="background-color: red;">0.00</span></td>
                                </tr>
                            </tbody></table>
                        <script type="text/javascript">
                            function strFormat(str)
                            {
                                if (str.indexOf(".") > 0)
                                {
                                    var minNumber = str.substr(str.indexOf(".") + 1, str.length);
                                    var folglen = minNumber.indexOf("+") > 0 ? minNumber.indexOf("+") : minNumber.indexOf("-") > 0 ? minNumber.indexOf("-") : 0;
                                    var newStr = str.substr(0, str.indexOf(".") + folglen);
                                    return newStr;
                                }
                                else
                                {
                                    return str;
                                }
                            }
                            function formatFloat(src, pos)
                            {
                                return parseFloat(Math.round(src * Math.pow(10, pos)) / Math.pow(10, pos)).toFixed(2);
                            }
                            function getZd(now, low)
                            {
                                var newstr = parseFloat(now - low).toFixed(2);
                                return newstr;
                            }
                            function getMarketData() {
                                $.get('/getdata.php', function(data) {
                                    for (var i = data.length - 1; i >= 0; i--) {
                                        var code = data[i];
                                        if (code.Code == "AG" || code.Code == "PT" || code.Code == "PD") {
                                            var t3 = '', color = 'red';
                                            if (code.fLastClose == '0.00') {
                                                t3 = '0.00';
                                            } else {
                                                t3 = formatFloat(getZd(strFormat(code.fNow), strFormat(code.fLastClose)) / strFormat(code.fLastClose) * 100, 2);
                                            }
                                            if (formatFloat(t3, 2) < 0) {
                                                color = 'green';
                                            }
                                            $('.datatable .' + code.Code + ' .t3 span').html(t3);
                                            $('.datatable .' + code.Code + ' .t3 span').css('background-color', color);
                                            $('.datatable .' + code.Code + ' .t2').html(formatFloat(strFormat(code.fNow), 2));
                                            $('.datatable .' + code.Code + ' .t2').css('color', color);
                                        }
                                    };
                                }, 'json');
                            }
                            getMarketData();
                            setInterval(getMarketData, 3000);
                        </script>
                        <div style="text-align: center; padding-top: 2px;"><a target="_blank" href="http://www.yinjinhui.com/forum.php?gid=1"><img src="/themes/v2/images/btn.gif"></a></div>
                    </div>
                </div>
                <div id="user_list">
                    <div class="user_ti clearfix"><!--a href="javascript:void(0)" class="u_ty friend_u" title="我的好友" onClick="userlistcontainer.tabToType('follow')"></a--><a href="javascript:void(0)" class="u_ty manage_u" title="在线客服" onclick="userlistcontainer.tabToType('manager')"></a><a href="javascript:void(0)" class="u_ty all_u" title="所有成员" onclick="userlistcontainer.tabToType('all')"></a><span id="user_cutover">在线会员</span> <a href="javascript:void(0)" onclick="" id="user_count">[刷新]</a></div>

                    <div class="user_sh clearfix">
                        <input type="text" name="ukey" id="usearch">
                        <a href="javascript:void(0)" onclick="ulistSearch()" title="搜索"></a>
                        <span><i id="usertotal">1023</i>人在线</span>
                    </div>
                    <!-- 用户列表 -->
                    <div id="list_u" class="mCustomScrollbar _mCS_5" style="height: 170px;">
                        <div class="mCustomScrollBox mCS-light" id="mCSB_5" style="position:relative; height:100%; overflow:hidden; max-width:100%;">
                            <div class="mCSB_container" style="position: relative; top: 0px;">
                                <ul id="all">
                                </ul>

                            </div><div class="mCSB_scrollTools" style="position: absolute; display: block; opacity: 0;"><a class="mCSB_buttonUp" oncontextmenu="return false;"></a><div class="mCSB_draggerContainer"><div class="mCSB_dragger" style="position: absolute; top: 0px; height: 30px;" oncontextmenu="return false;"><div class="mCSB_dragger_bar" style="position: relative; line-height: 30px;"></div></div><div class="mCSB_draggerRail"></div></div><a class="mCSB_buttonDown" oncontextmenu="return false;"></a></div></div></div><!-- /用户列表 -->

                    <script type="text/javascript">
                        var onlineuptime;
                        window.clearInterval(onlineuptime);
                        onlineuptime = setInterval(useronline, 10000);

                        function userflash()
                        {
                            $.ajax({url: '/index.php/module/live/useronline/getUsers' + '/' + $("#masterid").val() + '?t=' + new Date().getTime(),
                                type: "GET",
                                ifModified: true,
                                success: function(d) {
                                    $("#all").html(d);
                                }
                            });
                        }

                        function useronline()
                        {
                            $.ajax({url: '/index.php/userstatus/setUserOnline' + '/' + $("#roomid").val() + '?t=' + new Date().getTime(),
                                type: "GET",
                                ifModified: true,
                                async: false,
                                success: function(d) {
                                    var ll = $('#all li');
                                    var l = $('#all li:last').is(":visible");
                                    if (l || ll.length == 0)
                                        $("#all").html(d);
                                }
                            });
                        }
                        $(function() {
                            useronline();
                        });
                    </script>

                </div>

            </div><!-- /用户列表模块结束 -->

            <!-- 聊天模块开始 -->
            <div id="topic" class="ption_r" style="height: 464px;">
                <div class="notice">
                    <marquee direction="left" id="notice" scrollamount="3">金汇通的新老客户，本直播室现有原油、白银和钯金等多种交易产品，详情请点击上方QQ咨询。</marquee>
                </div>
                <!-- 聊天开始 -->
                <div class="topiccontent mCustomScrollbar _mCS_1" style=""><div class="mCustomScrollBox mCS-light" id="mCSB_1" style="position:relative; height:100%; overflow:hidden; max-width:100%;"><div class="mCSB_container" style="position: relative;">
                            <div id="topicbox">
                                <!--
                                <div id="4405-1431414574" class="talk  public member">		<span><img class="roleimg" src="/Public/images/level/0/15hy.png" title="会员"></span>		<div class="talk_name"><a href="javascript:void(0)" class="u_mor" rid="224" uid="4405">有你很幸福</a><a class="time">[15:09]</a></div>		<div class="clear"></div>		<div class="talk_hua"><p>铜是不是要下来啊</p>		</div>		<div class="clear"></div>		</div>
                                -->
                                <?php $this->load->module('live/chat/getitem', array('masterid' => $masterinfo['masterid'])); ?>
                            </div>
                        </div><div class="mCSB_scrollTools" style="position: absolute; display: block; opacity: 0;"><a class="mCSB_buttonUp" oncontextmenu="return false;"></a><div class="mCSB_draggerContainer"><div class="mCSB_dragger" style="position: absolute; top: 268px; height: 33px;" oncontextmenu="return false;"><div class="mCSB_dragger_bar" style="position: relative; line-height: 33px;"></div></div><div class="mCSB_draggerRail"></div></div><a class="mCSB_buttonDown" oncontextmenu="return false;"></a></div></div></div>
                <!-- 聊天结束 -->
                <div id="warnmsg">
                    <p style="">★如果老师不能及时回答您的问题，请点击上方QQ交谈进行咨询★</p>
                </div>
                <div id="qqbts">
                    <p style="" class="qq_kefu">
                        <span>高级客服：</span>
                        <a class="morekf" href="javascript: void(0)"  onclick="$('#kf_content').show();">更多客服</a>
                        <?php
                        if (!empty($adlist['kefu'])) {
                            foreach ($adlist['kefu'] as $k => $v) {
                                ?>
                                <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $v['link'] ?>&amp;site=qq&amp;menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:<?php echo $v['link'] ?>:41" alt="<?php echo $v['title'] ?>" title="请加QQ：<?php echo $v['link'] ?>"></a>
                            <?php
                            }
                        }
                        ?>
                    </p>
                </div>
                <div id="topicinput" class="ption_a">
                    <div class="tool_bar">
                        <span>
                            <a href="javascript:void(0)" id="bt_face" class="bar_2 bar" isface="2">表情</a>
                            <a href="javascript:void(0)" class="bar_3 bar" id="bt_caitiao">彩条</a>
                            <a href="javascript:void(0)" onclick="javascript:new_upImage()" class="bar_1 bar" id="bt_myimage">图片</a>
                            <a href="javascript:void(0)" class="bar_4 bar" id="bt_qingping">清屏</a>
                            <a href="javascript:void(0)" class="bar_5 bar" id="bt_gundong" select="true">滚动</a>
                        </span>
                        <span class="s_right"><!--input type="checkbox" id="shiliao" disabled=true/><label for="shiliao">私聊</label-->
                        </span></div>
                    <!-- <form id="imgUpload" name="imgUpload" action="/index.php/Upload" method="post" enctype="multipart/form-data" target="frameFile"> -->
                    <form id="imgUpload" name="imgUpload" action="/index.php/upload/multiupload/imgthumb/200/200" method="post" enctype="multipart/form-data" target="frameFile">
                        <input id="filedata" contenteditable="false" type="file" style="display:none;" onchange="$('#imgUpload').attr('action', '/index.php/upload/multiupload/imgthumb/200/200?' + new Date().getTime());
                                document.imgUpload.submit();" name="imgFile">
                    </form>
                    <iframe id="frameFile" name="frameFile" style="display: none;"></iframe>
                    <div class="input_area">
<?php $this->load->module('live/content/getlivedata', array(array($roominfo['cateid']), array($roominfo), array($hostinfo))); ?>
                        <a href="javascript:void(0)" onclick="sendMsg()" class="sub_btn" style="background-color: rgb(244, 107, 10);">发送</a></div>
                </div>
                <div id="caitiao" class="hid ption_a" style="display: none;">				<dl id="c_pt" class="clearfix " isface="2" pack="3">
                        <dd onclick="sendCaitiao('pt顶一个')">顶一个</dd><dd onclick="sendCaitiao('pt赞一个')">赞一个</dd><dd onclick="sendCaitiao('pt掌声')">掌声</dd><dd onclick="sendCaitiao('pt鲜花')">鲜花</dd><dd onclick="sendCaitiao('pt看多')">看多</dd><dd onclick="sendCaitiao('pt看空')">看空</dd><dd onclick="sendCaitiao('pt震荡')">震荡</dd>		</dl>

                    <div class="clearfix"></div>
                    <ul id="caitiaonav">
                        <li rel="pt" class="f_cur" isnav="1" id="caitiao_nav_3">普通</li>		</ul></div>
            </div><!-- /聊天模块结束 -->

            <!-- 视频模块开始 -->
            <div id="me_use" class="ption_a">
                <div class="sp_ti"><span><a href="javascript:void(0);">视频直播</a></span><a href="javascript:location.reload()" style="margin-right:20px;">刷新</a>
                    <!--marquee direction="left"   id="livenotice" scrollamount="3" ></marquee-->

                    <div id="videolink"> <a href="javascript:void(0)" style="color:#ff0;font-weight:bold;" class="sidenav" rel="tiny" url="/News/TeacherVote/redirectLottery/room_id/7.html" pwidth="830" pheight="500">&lt;给老师点赞&gt;</a></div>
                </div>

                <div id="shiping">
                    <embed width="100%" height="100%" align="middle" type="application/x-shockwave-flash" wmode="transparent"   allowfullscreen="true" allowscriptaccess="never" quality="high" src="http://yy.com/s/<?php echo $cfg['yy_channel']; ?><?php
                    if (!empty($cfg['yy_subchannel'])) {
                        echo "/" . $cfg['yy_subchannel'];
                    }
                    ?>/yyscene.swf">
                </div>

                <div id="kefu" style="height: 7px;">
                    <div class="kefu_ti">
                        <a class="write" rel="kefu_gonggao">关于我们</a>
                        <!--a  rel='kefu_con'  >在线客服</a-->
                        <a href="javascript:void(0);" rel="chanpinjs">联系我们</a>
                        <a href="javascript:void(0);" style="color:#ff0;font-weight:bold;" rel="hd_con">操作建议</a>
                        <a rel="banquan_con">ICP备案</a>
                    </div>
                    <div id="kefu_gonggao" class="tab-pane mCustomScrollbar _mCS_4"><div class="mCustomScrollBox mCS-light" id="mCSB_4" style="position:relative; height:100%; overflow:hidden; max-width:100%;"><div class="mCSB_container mCS_no_scrollbar" style="position: relative; top: 0px;">
                                <pre style="white-space: pre-wrap;
                                     word-wrap: break-word;margin:10px;color:#eee;font-family: Microsoft Yahei,Verdana, Geneva, sans-serif;"><?php echo $adlist[169][1]['desc']; ?>
                                </pre>
                                <div class="clearfix"></div>
                            </div><div class="mCSB_scrollTools" style="position: absolute; display: none;"><a class="mCSB_buttonUp" oncontextmenu="return false;"></a><div class="mCSB_draggerContainer"><div class="mCSB_dragger" style="position: absolute; top: 0px;" oncontextmenu="return false;"><div class="mCSB_dragger_bar" style="position:relative;"></div></div><div class="mCSB_draggerRail"></div></div><a class="mCSB_buttonDown" oncontextmenu="return false;"></a></div></div></div>
                    <!--div id="kefu_con" class="tab-pane hid">
            
                    <div class="f_right" id="kefunavdiv">
                    <ul id ="kefunav">
                    </ul>
                    </div>
                    <div class="clearfix"></div>
                    </div-->

                    <div id="hd_con" class="tab-pane hid">
                        <div class="hd_input"><input name="hd_text" id="hd_text" type="text"><a href="javascript:void(0)" onclick="sendHd(this);">发布</a>
                        </div>
                        <ul id="hd_ul">

                        </ul>
                        <div class="clearfix"></div>
                    </div>


                    <div id="banquan_con" class="tab-pane hid mCustomScrollbar _mCS_3"><div class="mCustomScrollBox mCS-light" id="mCSB_3" style="position:relative; height:100%; overflow:hidden; max-width:100%;"><div class="mCSB_container mCS_no_scrollbar" style="position: relative; top: 0px;">
                                <pre style="white-space: pre-wrap;
                                     word-wrap: break-word;margin:10px;color:#eee;font-family: Microsoft Yahei,Verdana, Geneva, sans-serif;"><?php echo $adlist[169][2]['desc']; ?></pre>
                                <div class="clearfix"></div>
                            </div><div class="mCSB_scrollTools" style="position: absolute; display: none;"><a class="mCSB_buttonUp" oncontextmenu="return false;"></a><div class="mCSB_draggerContainer"><div class="mCSB_dragger" style="position: absolute; top: 0px;" oncontextmenu="return false;"><div class="mCSB_dragger_bar" style="position:relative;"></div></div><div class="mCSB_draggerRail"></div></div><a class="mCSB_buttonDown" oncontextmenu="return false;"></a></div></div></div>

                </div>

            </div><!-- /视频模块结束 -->
            <!-- 抽奖模块开始 -->
            <div class="lottery" id="lottery" style="display:none;">
                <div class="close"><img id="cls" onclick="document.getElementById('lottery').style.display = 'none';" src="/themes/v2/static/images/close.gif"></div>
                <h2></h2>
                <ul id="lottery_ul">
                    <li id="lottery_li"></li>
                </ul>
                <div id="lotteryresult"></div>
            </div>
            <!-- /抽奖模块结束 -->
        </div>

        <script src="/themes/v2/static/js/malertbox2.js"></script>

        <script type="text/javascript">
                    $('#sendMsgInput').keyup(function(event) {
                        if (event.keyCode == 13) {
                            $(".sub_btn").trigger("click");
                            return false;
                        }
                    });
                    function login()
                    {
                        postdata('loginform', "/index.php/user/login", 'show');
                    }
                    function show(d)
                    {
                        if (d.code == '1') {
                            //$.jBox.tip(d.msg, 'success');
                            layer.msg(d.msg, 2, 0);
                            window.setTimeout(function() {
                                parent.window.location.reload();
                            }, 1000);
                        } else {
                            layer.msg(d.msg, 2, 0);
                            //	$.jBox.tip(d.msg,'error');
                        }
                    }
                    $('#bt_face').SinaEmotion($('#sendMsgInput'));
        </script>

        <style>
            .kf_content{position: absolute;top: 50% ;left: 50% ;width: 800px;height: 285px;margin: -140px 0 0 -400px;color: #f00;z-index: 999;background: url(/themes/v2/static/images/kfbg.png) no-repeat}
            /*.kf_content: hover{border-color: #00f;}*/
            .kf_content div{position: relative;}
            .kf_content div img#cls{position: absolute;width: 20px;height: 20px;top: 0px;right: 0px;overflow: hidden;text-indent: -99px;cursor: pointer;}
            #kfpn{margin-top: 130px;padding: 10px;}
            #kfpn.ms{color: #0000FF;font-size: 16px;text-align: center;height: 40px;font-weight: bold}
            #kfpn li{float: left;height: 28px;line-height: 28px;width: 95px;list-style-type: none;display: inline-block;}
            #kfpn li img{height: 22px;width: 77px;}
            #kfpn li span{display: inline-block;color: #fff;margin-left: 5px;font-size: 14px;}
            #kfpn li a{margin-top: 0px;margin-right: 2px;padding-left: 12px;}
            #kfpn li span.sn{width: 45px;display: block}
            #kfs{text-align: center;display: block;width: 770px;}
        </style>
        <div id="kf_content" class="kf_content" style="display: none;">
            <div>
                <img src="/themes/v2/static/images/close.gif" onclick="$('#kf_content').hide();" id="cls">
            </div>
            <div id="kfpn">
                <div id="kfs">
                    <?php
                        if (!empty($adlist['kefu_more'])) {
                            foreach ($adlist['kefu_more'] as $k => $v) {
                        ?>
                            <li>
                                <a onclick="qqbtclick(<?php echo $v['link'] ?>, 'middle')" href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $v['link'] ?>&amp;site=qq&amp;menu=yes"
                                   target="_blank">
                                    <img border="0" title="请加QQ：<?php echo $v['link'] ?>" alt="<?php echo $v['title'] ?>" src="http://wpa.qq.com/pa?p=2:<?php echo $v['link'] ?>:41" alt="<?php echo $v['title'] ?>"
                                         style="vertical-align:middle">
                                </a>
                            </li>
                    <?php
                            }
                        }
                    ?>
                </div>
            </div>
        </div>

    </body>
</html>
