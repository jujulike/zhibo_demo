
<script type="text/javascript">
    $(document).ready(function() {
        var chattime;
        chattime = setInterval(chatflash, 3000);
    })

<?php if (($u['role'] == '-1') && ($cfg['visitor_viewlive'] == '0')) {
    
} else { ?>
        //var contenttime = setInterval(contentflash, 3000);
<?php } ?>
//var qatime = setInterval(qaflash, 5000);
//var viptime = setInterval(vipflash, 5000);
//var myqatime = setInterval(myqaflash, 5000);

    var _timeobj;
    var _titleflashtime = 3000;
    var _title = document.title;

//var contenttime; 
//var qatime;
//var myqatime;


//chattime = setInterval(chatflash, 3000);

    function SetRemainTime(titletip) {
        if (_titleflashtime > 0) {
            _titleflashtime = _titleflashtime - 500;
            var second = Math.floor(_titleflashtime);             // 计算秒     
            if (second % 200 == 0) {
                document.title = '【' + titletip + '】' + _title;
            }
            else {
                document.title = _title;
            }
            ;
        } else {
            window.clearInterval(_timeobj);
            document.title = _title;
            _titleflashtime = 3000;
        }
    }

    function setTitleTip(s)
    {
        window.clearInterval(_timeobj);
        SetRemainTime();
        _timeobj = window.setInterval(_tempTip(s), 1000);
    }

    function _tempTip(_s) {
        return function() {
            SetRemainTime(_s);
        }
    }



    function chatflash()
    {
        $.ajax({url: '<?php echo site_url("module/live/chat/getitem") ?>' + '/' + $("#masterid").val() + '/' + $("#lastchatid").val() + '?t=' + new Date().getTime(),
            type: "GET",
            ifModified: true,
            success: function(d) {
                var _s = AnalyticEmotion(d);
                if (_s != '') {
                    chatcontainer.push(_s);
                }
            }
        });
    }

    function DrawImage(ImgD, iwidth, iheight) {
        //参数(图片,允许的宽度,允许的高度)
        var image = new Image();
        image.src = ImgD.src;
        if (image.width > 0 && image.height > 0) {
            if (image.width / image.height >= iwidth / iheight) {
                if (image.width > iwidth) {
                    ImgD.width = iwidth;
                    ImgD.height = (image.height * iwidth) / image.width;
                } else {
                    ImgD.width = image.width;
                    ImgD.height = image.height;
                }
                ImgD.alt = image.width + "×" + image.height;
            }
            else {
                if (image.height > iheight) {
                    ImgD.height = iheight;
                    ImgD.width = (image.width * iheight) / image.height;
                } else {
                    ImgD.width = image.width;
                    ImgD.height = image.height;
                }
                ImgD.alt = image.width + "×" + image.height;
            }
        }
    }

    function preview_image(url)
    {
        var image = url;
        $("#previewimage").html('<img src="' + image + '" />');
        $.layer({
            type: 1,
            title: false,
            fix: false,
            shadeClose: true,
            area: ['auto', 'auto'],
            page: {dom: '#previewimage'}
        });
    }

    function modic(contentid)
    {
        $.jBox("iframe:<?php echo site_url('module/live/content/editContent') ?>" + "/" + contentid + "/1/1", {title: "修改直播内容", iframeScrolling: 'no', height: 400, width: 650, buttons: {'关闭': true}});
    }

    function chataudit(chatid, status)
    {
        $.get("<?php echo site_url('module/live/chat/chataudit') ?>" + "/" + chatid + "/" + status, function(data) {
            var d = eval('(' + data + ')');
            if (d.code == '1')
            {
                layer.msg(d.msg, 2, 1);
                $("#audit_" + d.chatid).remove();

            }
            else
            {
                layer.msg(d.msg, 1, 5);
            }
        });
    }

    function retchat(d)
    {
        if (d.code == '1') {
            //$("#questionlasttime").val(d.lasttime);
            //alert(d.msg);
            $("#nextchat").val(parseInt(Date.parse(new Date()).toString().substring(0, 10)));
            $("#sendMsgInput").val('');
            chatcontainer.push(AnalyticEmotion(d.content));
            $("#show_img").html("");
            $("#imgthumb").val("");
            $("#sourceimg").val("");
        }
        else if (d.code == '-1')
        {
            alert('你已被踢出,请过一段时间再来!');
            top.location.href = '<?php echo site_url('home'); ?>';
        }
        else {
            alert(d.msg);
        }
    }

    function removeHTMLTag(str)
    {
        str = str.replace(/<\/?[^>]*>/g, ''); //去除HTML tag
        str = str.replace(/(^\s*)|(\s*$)/g, "");
        str = str.replace(/(^\s*)/g, "");
        str = str.replace(/(\s*$)/g, "");
        str = str.replace(/&nbsp;/ig, '');//去掉&nbsp;
        return str;
    }

    function sendMsg() {
        var _s = removeHTMLTag($("#sendMsgInput").val());
        if ((_s.length == 0))
        {
            $("#sendMsgInput").val('');
            alert('内容不能为空');
            return false;
        }

        if ($('#level').val() == -1) {
            var time = parseInt(Date.parse(new Date()).toString().substring(0, 10));
            var nchat = time - parseInt($('#nextchat').val());
            if (nchat < 30) {
                var boxhtml = '<div class="tinner" id="" style="width: 440px; height: 170px; background-image: none;"><div class="tcontent"><div class="qqalert">	<div class="alert_title">提示信息</div>		<p id="alertmsg">游客的发言时间间隔为30秒,还有<span id="chatTimeSpan">' + (30 - nchat) + '</span>秒！<br>请联系QQ客服，免费获取马甲和老师解答，发言不受限！</p><div class="kflis">';
<?php if (!empty($adlist[130])) {
    foreach ($adlist[130] as $k => $v) { ?>
                        boxhtml += '<li> <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $v['link'] ?>&amp;site=qq&amp;menu=yes"><img border="0" style="vertical-align:middle" src="http://wpa.qq.com/pa?p=2:<?php echo $v['link'] ?>:41" alt="<?php echo $v['link'] ?>" title="请加QQ：<?php echo $v['link'] ?>"></a> </li>';
    <?php }
} ?>
                boxhtml += '</div></div></div></div>';
                TINY.box.show({html: boxhtml, width: 470, height: 200, openjs: function() {
                        $('.tbox').css('position', 'absolute');
                    }});
                return false;
            }
        }

        $("#sendMsgInput").val(_s);
        postdata('chatform', "/index.php/chat/setContent", "retchat");
        return false;
    }

    function showJYCZ() {
        var htmlstr = $('#showJYCZ').html();
        TINY.box.show({html: htmlstr, width: '550', height: '400'});
    }

    function showCPJS() {
        var htmlstr = $('#showCPJS').html();
        TINY.box.show({html: htmlstr, width: '1000', height: '500'});
    }

    $(function() {
        $('#ykname a').html('<?php echo $u['name'] ?>');
    });

    window.onload = function()
    {
        $("#topicbox").find(".talk_hua").find("p").each(function() {
            var _s = $(this).html();
            if (_s.indexOf('[') != -1)
            {
                var _t = AnalyticEmotion(_s);
                $(this).html(_t);
            }
        });
        chatcontainer.scrollToLast();
    }
<?php if ((!empty($userinfo)) && ($userinfo['level'] != '-1')) { ?>
        var login_type = 0;
<?php } else { ?>
        var login_type = 1;
<?php } ?>

</script>
<form name="chatform" id="chatform" action="javascript:;" onsubmit="return false;">
    <INPUT TYPE="hidden" NAME="roomid" id="roomid" value="<?php echo $masterinfo['roomid'] ?>">
    <INPUT TYPE="hidden" NAME="masterid" id="masterid" value="<?php echo $masterinfo['masterid'] ?>">
    <INPUT TYPE="hidden" NAME="lastchatid" id="lastchatid" value="<?php echo (empty($lastchatid)) ? 0 : $lastchatid; ?>">
    <INPUT TYPE="hidden" NAME="chatname" id="chatname" value="<?php echo $u['name'] ?>">
    <INPUT TYPE="hidden" id="nextchat" value="0">
    <INPUT TYPE="hidden" NAME="chatuserid" id="chatuserid" value="<?php echo $u['userid'] ?>">
    <INPUT TYPE="hidden" NAME="level" id="level" value="<?php if ($u['ismaster'] == 26) echo '-' . ($u['level'] + 2);
else echo $u['level'] ?>">
    <INPUT TYPE="hidden" NAME="imgthumb" id="imgthumb" value="">
    <INPUT TYPE="hidden" NAME="sourceimg" id="sourceimg" value="">
    <input type="hidden" name="wordcount" class="word_count" id="wordcount" />
    <input type="text" id="sendMsgInput" name="chatcontent">
</form>
<div id="showJYCZ" style="display:none"><?php if ($u['level'] != -1) echo $adlist[169][3]['desc']; ?></div>
<div id="showCPJS" style="display:none"><?php echo $adlist[169][4]['desc']; ?></div>