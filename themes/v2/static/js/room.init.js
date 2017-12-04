
var WidthLevel = {'S': 480, 'M': 598, 'P': 880, 'L': 1366, 'B': 1600};
var topiccontent = '.topiccontent';//聊天显示块选择器
var topicbox = '#topicbox';
var chatcontainer;
var userlistcontainer;
var scrollconf = {scrollButtons: {enable: true}};

var checkMsgs = {};
var delMsgs = {};

function  isTelphone() {
    //alert(navigator.userAgent);
    if (/AppleWebKit.*Mobile/i.test(navigator.userAgent) || (/MIDP|SymbianOS|NOKIA|SAMSUNG|LG|NEC|TCL|Alcatel|BIRD|DBTEL|Dopod|PHILIPS|HAIER|LENOVO|MOT-|Nokia|SonyEricsson|SIE-|Amoi|ZTE/.test(navigator.userAgent))) {
        if (window.location.href.indexOf("?mobile") < 0) {
            try {
                if (/Android|Windows Phone|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)) {
                    return true;
                } else if (/iPad/i.test(navigator.userAgent)) {
                } else {
                }
            } catch (e) {
            }
        }
    }
    return false;

}

function resize() {
    var windowHeight = $(window).height();
    var windowWidth = $(window).width();
    var headerHeight = $('header').height();
    var footerHeight = $('footer').height();
    var mmargin = mMargin();
    var $topic = $('#topic');
    var $main = $('#main');
    $main.height(windowHeight - headerHeight - footerHeight - mmargin * 2); //设置主体高度

    var noticeHeight = $('.notice').height();//房间通知跑马灯高度
    var topicinputHeight = $('#topicinput').height();  //聊天输入块高度
    var warnmsgHeight = $('#warnmsg').height();
    var qqbtsHeight = $('#qqbts').height();
    if (windowWidth > WidthLevel.P) {
        $topic.height($main.height()); //聊天模块高度
        $('.topiccontent').height($topic.height() - topicinputHeight - noticeHeight - mmargin * 2 - warnmsgHeight - qqbtsHeight - 10); //聊天显示块高度
    } else if (windowWidth <= WidthLevel.M) {
        if (isPhone) {
            $main.height(windowHeight);
            $topic.css('margin-top', '30px');
        } else {
            $main.height(windowHeight - headerHeight); //设置主体高度
        }

        $topic.height($main.height() - $('#me_use').height()); //聊天模块高度	
        $('.topiccontent').height($topic.height() - topicinputHeight - mmargin * 2); //聊天显示块高度
    } else {
        $topic.height($main.height() - $('#sidebar').height()); //聊天模块高度
        $('.topiccontent').height($topic.height() - topicinputHeight - noticeHeight - mmargin * 2 - 10); //聊天显示块高度
    }

    //$('#print').html($('.topiccontent').height());
    var ulist_above_height = $('.toupiao').height() + $('.user_ti').height() + $('.user_sh').height() + mmargin + 33;
    var hangqingheight = $("#hangqing").height();
    var leftadheight = $("#leftad").height();
    $('#list_u').height(windowHeight - headerHeight - footerHeight - ulist_above_height - hangqingheight - leftadheight - 1); //用户列表高度

    var liveHeight = $('#shiping').height() + $('.sp_ti').height(); //视频高度

    $('#kefu').height($main.height() - liveHeight - mmargin * 2);//

    $('#kefu_gonggao').height($('#kefu').height() - 32);
    $('#banquan_con').height($('#kefu').height() - 32);

    $('#topqq').width(windowWidth - $('#headlogo').width() - $('#favlink').width() - 300 - 80);
}

function mMargin() {//大屏间距10  小屏间距5
    var windowWidth = $(window).width();
    return windowWidth > WidthLevel.B ? 10 : 5;
}

//数组乱序
function fnLuanXu(arr) {
    if (arr == null)
        return false;
    var num = arr.length;
    for (var i = 0; i < num; i++) {
        var iRand = parseInt(num * Math.random());
        var temp = arr[i];
        arr[i] = arr[iRand];
        arr[iRand] = temp;
    }
    return arr;
}
//初始化客服
function formatKefuDetail(e) {
    var name = e.attr('name');
    var id = e.attr('id');
    var image = e.attr('image');
    var qq = e.attr('qq');
    var detail = '<img class="figure" src="' + image + '" alt="客服"/>' + name + '<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=' + qq + '&amp;site=qq&amp;menu=yes"><img src="http://wpa.qq.com/pa?p=2:' + qq + ':41" alt="' + name + '" title="请加QQ：' + qq + '" class="qqimg"></a><br/>QQ:' + qq;
    return detail;
}


//初始化客服列表
function initKefu() {

    $('#kefunavdiv').mCustomScrollbar(scrollconf);
    $kefunav = $('#kefunav');
    var kefuarr = fnLuanXu(roomconf.kefu);
    if (kefuarr == false)
        return;
    var num = 0;
    if (kefu_num) {
        num = Math.min(kefuarr.length, kefu_num);
    } else {
        num = kefuarr.length;
    }

    for (var i = 0; i < num; i++) {
        var kefu = kefuarr[i];
        if (kefu.image) {
            image = image_url + kefu.image;
        } else {
            image = '/Public/images/kefu.jpg';
        }
        $kefunav.append('<li rel=' + kefu.id + ' image=' + image + ' qq=' + kefu.qq + ' name=' + kefu.name + '><a href="#">' + kefu.name + '</a></li>');

    }
    $pdetail = $("#kefucon");
    $kefunav.children().click(function() {
        $kefunav.children().removeClass('k_cur');
        $(this).addClass('k_cur');
        var detail = formatKefuDetail($(this));
        $pdetail.html(detail);
    });
    $kefunav.children().first().addClass('k_cur');
    var detail = formatKefuDetail($kefunav.children().first());
    $pdetail.html(detail);


}
;
function initKefu2() {

    $('#kefunavdiv').mCustomScrollbar(scrollconf);
    $kefunav = $('#kefunav');
    var kefuarr = fnLuanXu(roomconf.kefu);
    if (kefuarr == false)
        return;
    var num = 0;
    if (kefu_num) {
        num = Math.min(kefuarr.length, kefu_num);
    } else {
        num = kefuarr.length;
    }

    for (var i = 0; i < num; i++) {
        var kefu = kefuarr[i];
        if (kefu.image) {
            image = image_url + kefu.image;
        } else {
            image = '/Public/images/kefu.jpg';
        }
        $kefunav.append('<li><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=' + kefu.qq + '&amp;site=qq&amp;menu=yes"><img src="http://wpa.qq.com/pa?p=2:' + kefu.qq + ':41" alt="' + kefu.name + '" title="请加QQ：' + kefu.qq + '" class="qqimg"></a></li>');

    }


}
;
function initKefu3() {


    var kefuarr = fnLuanXu(roomconf.kefu);
    if (kefuarr == false)
        return;
    var num = Math.min(kefuarr.length, 6);
    var topqqhtml = '<i>在线客服：</i>';

    for (var i = 0; i < num; i++) {
        var kefu = kefuarr[i];
        topqqhtml += '<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=' + kefu.qq + '&amp;site=qq&amp;menu=yes"><img src="http://wpa.qq.com/pa?p=2:' + kefu.qq + ':41" alt="' + kefu.name + '" title="请加QQ：' + kefu.qq + '" class="qqimg"></a>';

    }
    var topqqbt = '';

    $('#topqq').prepend('<span id="topqq1">' + topqqhtml + '</span>');
}
;

function initKefu4() {
    var kefuarr = fnLuanXu(roomconf.kefu);
    if (kefuarr == false)
        return;
    var num = Math.min(kefuarr.length, 8);
    var qqboxhtml = '<h3 style="text-align:center;padding-bottom:10px">联系我们</h3>';
    for (var i = 0; i < num; i++) {
        var kefu = kefuarr[i];
        qqboxhtml += '<li class="qqli"><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=' + kefu.qq + '&amp;site=qq&amp;menu=yes"><img src="http://wpa.qq.com/pa?p=2:' + kefu.qq + ':41" alt="' + kefu.name + '"  class="qqimg">' + kefu.qq + '</a></li>';

    }
    TINY.box.show({html: qqboxhtml, width: 180, height: 290});

}
function initScroll() {
    //右侧导航滚动
    $("#sidebar").mCustomScrollbar(scrollconf);
    //版权声明滚动
    $("#banquan_con").mCustomScrollbar(scrollconf);
    //公告滚动
    $('#kefu_gonggao').mCustomScrollbar(scrollconf);

}
function updateScroll() {
    $("#banquan_con").mCustomScrollbar('update');
    $('#kefu_gonggao').mCustomScrollbar('update');
}
function  initFuncs() {

    //清屏
    $('#bt_qingping').on('click', function() {
        chatcontainer.clear();
    });
    //滚动
    $('#bt_gundong').on('click', function() {
        chatcontainer.dynamicscroll = !chatcontainer.dynamicscroll;
        var iss = $(this).attr('select');
        var issele = iss == 'true' ? 'false' : 'true';
        $(this).attr('select', issele);

    });
    //聊天内容筛选键
    if (isHasPower(0, 'is_company_role')) {
        $('#talk_filter').show();
    }
    $('#talk_filter a').on('click', function() {
        var rel = $(this).attr('rel');
        chatcontainer.tabToType(rel);
    });
    //客服区tab导航
    $('.kefu_ti a').click(function() {
        var rel = $(this).attr('rel');
        if (rel == "hd_con") {
            if ($('#level').val() != -1) {
                showJYCZ();
            } else {
                alertBox('操作建议仅限会员参考，详情请联系直播室QQ客服', 'error');
            }
            return;
        }
        if (rel == "chanpinjs") {
            showCPJS();
            return;
        }

        $('.kefu_ti a').removeClass('write');
        $(this).addClass('write');

        $('#kefu .tab-pane').hide();
        $('#' + rel).show();
        updateScroll();
    });
}

//初始化在线列表
function initUlist() {
    userlistcontainer = new UserList();
    userlistcontainer.create('#list_u', '#all');
//	loadUlistTimeout(300);
}

function loadUlistTimeout(time) {
    userlistcontainer.clear();
    setTimeout('loadUlist()', time);
}

//加载用户列表
function loadUlist() {
    /*	$.post( load_user_url ,{'id': room_id ,'myRoole':myRole['type']},function(data){	
     if(data == null) return;
     
     $('#user_cutover').text('在线会员');
     
     var count = data.count;
     if(count){
     $('#user_count').text('(' + count +')');
     }else{
     $('#user_count').text('[刷新]');
     }
     more = data.more
     delete data.count;
     delete data.more;
     delete data.server;
     
     $.each(data,function(k,v){
     var user = new UserClass();
     user.id = ''+ v.member_id;
     user.name = v.name;
     if(v.is_visitor == 1){
     user.rid = 1;
     user.isCompanyRole = 0;
     }else{
     user.rid = v.rid;
     user.isCompanyRole = v.is_company_role;
     }
     user.ip =v.ip ? v.ip :'';
     
     
     user.isVistor = v.is_visitor;
     user.isCompanyRole = v.is_company_role;
     var listr = user.toUlistLi();
     listr.on('click',function(){
     userlistcontainer.container.children().removeClass('u_cur');
     $(this).addClass('u_cur');
     });
     userlistcontainer.container.append(listr);
     });
     
     userlistcontainer.scroolwrap.mCustomScrollbar('update');
     if(more > -1){ 
     userlistcontainer.container.append('<li style="text-align:center" class="loadUmore"><a href="javascript:void(0)" onclick="loadUMore(' + more + ')">更多...</a></li>')	
     }
     },'json');*/
}

function loadUMore(more_num) {
    $.post(load_user_more_url, {'id': room_id, 'myRoole': myRole['type'], 'more': more_num}, function(data) {
        if (data == null)
            return;

        var count = data.count;
        if (count) {
            $('#user_count').text('(' + count + ')');
        } else {
            $('#user_count').text('[刷新]');
        }
        more = data.more
        delete data.count;
        delete data.more;
        delete data.server;

        $.each(data, function(k, v) {
            if ($('#u_' + v.member_id).attr('name') == undefined) { //是否重复
                var user = new UserClass();
                user.id = '' + v.member_id;
                user.name = v.name;
                if (v.is_visitor == 1) {
                    user.rid = 1;
                    user.isCompanyRole = 0;
                } else {
                    user.rid = v.rid;
                    user.isCompanyRole = v.is_company_role;
                }
                user.isVistor = v.is_visitor;
                user.ip = v.ip;

                var listr = user.toUlistLi();
                listr.on('click', function() {
                    userlistcontainer.container.children().removeClass('u_cur');
                    $(this).addClass('u_cur');
                });
                userlistcontainer.container.append(listr);
            }
        });
        userlistcontainer.scroolwrap.mCustomScrollbar('update');
        $('.loadUmore').remove();

        if (more > 0) {
            userlistcontainer.container.append('<li style="text-align:center" class="loadUmore"><a href="javascript:void(0)" onclick="loadUMore(' + more + ')">更多...</a></li>')
        }
    }, 'json');
}




//用户搜索
function ulistSearch() {
    var wdinput = $('#usearch').val().trim();
    $('#usearch').val(wdinput);
    if (wdinput == '')
        return;
    userlistcontainer.search(wdinput);
}

//加载历史聊天记录
function loadChatHistory() {
    $.post(load_chat_url, {'id': room_id}, function(data) {
        if (data == null)
            return false;
        $.each(data, function(k, v) {
            var msg = new MsgClass();
            msg.create(v);

            if (msg.isICanSee()) {
                chatcontainer.push(msg.toMsgItem());
            }
            if (isHasPower(0, 'purview_check')) {
                if (msg.ischecked == '0') {
                    checkMsgs[v.id] = v;
                }
                delMsgs[v.id] = v;

            }

        });
        if (myRole['purview_check'] == 1) {
            hoverDel();
        }
    }, 'json');
}


//初始化表情包和彩条

function showFacePanel(e, toinput) {
    var offset = $(e).offset();

    var t = offset.top;
    var l = offset.left;
    $('#face').css({"top": t - $('#face').outerHeight(), "left": l});
    $('#face').show();
    $('#face').attr("toinput", toinput);
}
function  initFaceColobar() {

    /*	$.get("/room/Image/phiz",function(data){
     $('#face').html(data);
     $('#facenav li').on('click',function(){
     var rel = $(this).attr('rel');
     $('#face dl').hide();
     $('#f_'+rel).show();
     $(this).siblings().removeClass('f_cur');
     $(this).addClass('f_cur');
     
     });	
     }).success(function(){
     $(document).bind('mouseup',function(e){
     if($(e.target).attr('isface')!='1' && $(e.target).attr('isface')!='2')
     {
     $('#face').hide();
     //$(document).unbind('mouseup');
     }
     else if($(e.target).attr('isface')=='1')
     {
     var pack_id = $(e.target).parents('dl').attr('pack');
     if( $.inArray(pack_id,myRole['phiz_id']) >= 0 ){
     var toinput =$('#face').attr("toinput");
     $(toinput).insertAtCaret('['+$(e.target).attr('title')+']');
     }else{
     var nav_name = $('#phiz_nav_'+pack_id).text();
     alertBox('抱歉，您的等级无[' + nav_name + ']表情包使用权限','error');
     }
     }
     });
     
     
     });
     $.get("/room/Image/colorbar",function(data){
     //$('#caitiao').html(data);
     //彩条*/
    $('#bt_caitiao').on('click', function() {
        $('#caitiao').show();

    });
    $('#caitiaonav li').on('click', function() {

        var rel = $(this).attr('rel');
        $('#caitiao dl').hide();
        $('#c_' + rel).show();
        $(this).siblings().removeClass('f_cur');
        $(this).addClass('f_cur');
    });
    $(document).bind('mouseup', function(e) {
        if ($(e.target).attr('isnav') != '1')
        {
            $('#caitiao').hide();
        }
    });




}

//加载投票
function loadVote(obj) {
    if (obj) {

        t_up = $('.toupiao #w_' + obj['class_id'] + ' .t_up em');
        t_leve = $('.toupiao #w_' + obj['class_id'] + ' .t_leve em');
        t_down = $('.toupiao #w_' + obj['class_id'] + ' .t_down em');

        t_up.text(Math.round(obj['percent'][0]) + "%");
        t_leve.text(Math.round(obj['percent'][1]) + "%");
        t_down.text(Math.round(obj['percent'][2]) + "%");
    } else {
        for (var vote_id = 3; vote_id <= 5; vote_id++) {
            /*			$.post(load_vote_url,{'room_id':room_id,'vote_id':vote_id}, function(data){
             
             t_up = $('.toupiao #w_'+data['class_id']+' .t_up em');
             t_leve = $('.toupiao #w_'+data['class_id']+' .t_leve em');
             t_down = $('.toupiao #w_'+data['class_id']+' .t_down em');
             
             t_up.text(Math.round(data['percent'][0]) +"%");
             t_leve.text(Math.round(data['percent'][1]) +"%");
             t_down.text(Math.round(data['percent'][2]) +"%");
             },'json');*/
        }
    }
}


//加载导航
function loadLink() {
//	$.post( link_url ,{'room_id':room_id},function(data){
//		var linkformat ='';
//		var linkhtml ='';
//		var footlinkhtml ='';
//		var vediolinkhtml ='';
//		i=0;
//		$.each(data,function(k,v){
//			if(v['type'] == 0){ //右侧导航
//				i++;
//
//				if(v['target'] == 1){
//				linkformat = '<li class="side{3}">\
//					<a href="javascript:void(0)" class="sidenav" rel="tiny" url="{0}" pwidth="{4}" pheight="{5}" >\
//					<img src="{1}" title="{2}"/><br>{2}</a>\
//					</li>';
//				}else{
//					linkformat = '<li class="side{3}">\
//					<a href="{0}" class="sidenav" target="_blank">\
//					<img src="{1}" title="{2}"><br>{2}</a>\
//					</li>';
//
//				}
//				linkhtml += $.format(linkformat, v['link'],image_url + v['image_src'],v['name'],i,v['width'],v['height']);
//				$('#sidebar ul').html(linkhtml);
//				$('#sidebar').mCustomScrollbar('update');
//			}else if(v['type'] == 1){
//				if(v['target'] == 1){
//					linkformat = ' | <a href="javascript:void(0)" class="sidenav" rel="tiny" url="{0}" pwidth="{4}" pheight="{5}" >{2}</a>';
//				}else{
//					linkformat = ' | <a href="{0}"  target="_blank">{2}</a>';
//				}
//				footlinkhtml += $.format(linkformat, v['link'],v['image_src'],v['name'],i,v['width'],v['height']);
//				$('footer div.f_left').html(footlinkhtml.substr(3));
//			}else{
//				if(v['target'] == 1){
//					linkformat = ' <a href="javascript:void(0)" style="color:#ff0;font-weight:bold;" class="sidenav" rel="tiny" url="{0}" pwidth="{4}" pheight="{5}" >{2}</a>';
//				}else{
//					linkformat = ' <a href="{0}" style="color:#ff0;font-weight:bold;" target="_blank">{2}</a>';
//				}
//				vediolinkhtml += $.format(linkformat, v['link'],v['image_src'],v['name'],i,v['width'],v['height']);
//				
//				$('#videolink').html(vediolinkhtml);
//			}
//		});
//		$('a.sidenav[rel=tiny]').on('click',function(){
//			var url = $(this).attr('url');
//			var width = $(this).attr('pwidth');
//			var height = $(this).attr('pheight');
//			TINY.box.show({iframe:url,width:width,height:height});
//		});
//		
//	},'json');
}


function showLive(Live_id) {
    var liveurl = '';
    var livehtml = '';

    if (Live_id == '-1') {
        $("#btlogin").click();
        livehtml = "<div id='shiping-shelte'><p>抱歉，您的观看时间已经结束。</p></div>";
        $('.sp_ti a').attr('href', 'javascript:showLive(-1)');
        $('#shiping').html(livehtml);
        return;
    }
    if (live_video_type == 0) {
        livehtml = $('#shiping').html();
        $('#shiping').children().remove();
        $('#shiping').html(livehtml);

    } else {
        livehtml = $('#videoComponent').html();
        $('#videoComponent').children().remove();
        $('#videoComponent').html(livehtml);
    }



}


function closeLiveTimeout() {
    /*	if(video_time>0){
     setTimeout('showLive(-1)', video_time * 1000);
     }*/

}


function initMyImage() {
    $.post(myImage, {}, function(data) {
        var img_html = '';
        $.each(data, function(k, v) {
            var img_format = '<dd onclick="send_image(\'{1}/{2}\')" >\
			<img src="{0}/Uploads/{1}/m_{2}" isface="1" style="max-width:100px;max-height:80px">\
			</dd>';

            img_html += $.format(img_format, image_url, v['0'], v['1']);
        });
        // console.log( img_html)
        $('#myimagelist').prepend(img_html);
    }, 'json');
}
//喊单
function initHd() {
    if (myRole['is_handan'] != '1') {
        $('.hd_input').hide();
    }
    var $handan = $("#hd_con");
    $handan.mCustomScrollbar(scrollconf);
    if (myRole['look_handan'] == 1) {
        $.post(Hd_url, {id: room_id}, function(data) {
            var hd_html = '';
            $.each(data, function(k, v) {
                var time = new Date(parseInt(v['time']) * 1000).format('MM-dd hh:mm:ss');
                var hd_format = '<li>\
				<span>{0}<i>{2}</i></span>\
				<p>{1}</p>\
				</li>';
                hd_html += $.format(hd_format, v['from_name'], v['content'], time);
            });
            $('#hd_ul').html(hd_html);
        }, 'json');
    } else {
        $('#hd_ul').html('<li style="padding-top:10px"><p style="">抱歉，您的等级还不能查看操作建议!</p></li>');

    }
}

function loadVideo(Live_id) {
    if (Live_id == '-1') {
        $("#btlogin").click();
        livehtml = "<div id='shiping-shelte'><p>抱歉，您的观看时间已经结束。</p></div>";
        $('.sp_ti a').attr('href', 'javascript:showLive(-1)');
        $('#shiping').html(livehtml);
        return;
    }
    switch (live_video_type) {
        case 0:
            var shiping = '<embed id="v8Player" src="http://yy.com/s/' + YY_id + '/yyscene.swf" quality="high" height="100%" width="100%" align="middle" allowscriptaccess="always" allowfullscreen="true" mode="transparent" wmode="transparent" type="application/x-shockwave-flash">';
            break;
        case 1:
            var shiping = '<gs:video-live id="videoComponent" site="jrzx666.gensee.com" ctx="training" ownerid="' + GS_series + '" authcode="' + GS_authcode + '" uname="' + name + '"/>';
            break;
    }
    $('#shiping').html(shiping);
}
;

function switchVideo() {
    live_video_type = live_video_type == 0 ? 1 : 0;
    switch (live_video_type) {
        case 0:
            loadVideo();
            break;
        case 1:
            document.location.href = '/room/' + room_id + '?tv=1';
            break;
    }

}




function user_cutover() {
    $('#user_cutover').click(function() {
        initVisitor();
        $(this).text('在线游客');
    });
}

function initVisitor() {
    userlistcontainer.clear();
    $.post(load_visitor_url, {'id': room_id}, function(data) {
        if (data == null)
            return;

        $.each(data, function(k, v) {
            var user = new UserClass();
            user.id = '' + v.member_id;
            user.name = v.name;

            user.rid = 1;

            user.ip = v.ip ? v.ip : '';

            user.isVistor = 1;
            user.isCompanyRole = 0;
            var listr = user.toUlistLi();
            listr.on('click', function() {
                userlistcontainer.container.children().removeClass('u_cur');
                $(this).addClass('u_cur');
            });

            userlistcontainer.container.append(listr);
        });
        userlistcontainer.scroolwrap.mCustomScrollbar('update');

    }, 'json');

}


function createIframe() {
    if (quotes_url) {
        $('#hangqing').append('<iframe src="' + quotes_url + '" height="144px" width="190px" scrolling="no" frameborder="0"></iframe>');
    }
    if (quotes_adurl) {
        $('#leftad').append('<iframe src="' + quotes_adurl + '" height="90px" width="190px" scrolling="no" frameborder="0"></iframe>');

    }
}
;

(function($) {
    $(window).load(function() {

        //    initKefu2();	
        //    initKefu3();
        initFaceColobar();
        loadVote();
        loadLink();

        initScroll();
        closeLiveTimeout();

        //	enterSend();
        initUlist();
        /*	if(myRole['is_private_chat'] == '1'){
         user_cutover();
         }*/
        //	setTimeout('loadChatHistory()',500);

        //	setInterval('active_session()',240000);

        //	setTimeout('createIframe()',1500);

    });
})(jQuery);



var isPhone;
$(function() {
    isPhone = isTelphone();
    initFuncs();

    if (isPhone) {
        live_video_type = 1;
        var $header = $('header').clone();
        $('header').remove();
        $('#main').css('margin-top', '0px');
        $('#shiping').after($header);

    }
    $(window).resize(function() {
        resize();
    });
    resize();
    //实例化聊天窗

    //loadVideo(Live_id);

    chatcontainer = new ChatContainer();
    chatcontainer.create(topiccontent, topicbox, 50);

    $('#bt_caitiao').on('click', function() {
        $('#caitiao').show();
    });
    $(document).bind('mouseup', function(e) {
        if ($(e.target).attr('isnav') != '1')
        {
            $('#caitiao').hide();
        }
    });

    $('#sidebar .side7').click(function() {
        TINY.box.show({iframe: '/index.php/live/classes', width: 680, height: 300, openjs: function() {
                $('.tbox').css('position', 'absolute');
            }});
    });

//	$('#sidebar .side1').click(function(){
//		TINY.box.show({iframe:'/cpjj/cpjj.html',width:1280,height:600,openjs:function(){
//			$('.tbox').css('position','absolute');
//		}});
//	});
//
    $('#videolink .sidenav').click(function() {
        TINY.box.show({iframe: "/index.php/vote/jsvote/index/", width: 800, height: 500, openjs: function() {
            $('.tbox').css('position', 'absolute');
        }});
    });
    $('header #favlink a.open_box').click(function() {
        var url = $(this).attr('data-url');
        TINY.box.show({iframe: url, width: 1000, height: 500, openjs: function() {
            $('.tbox').css('position', 'absolute');
        }});
    });

});


