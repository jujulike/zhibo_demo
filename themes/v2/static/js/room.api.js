$.format = function (source, params) 
{
	if (arguments.length == 1)
	return function () {
	var args = $.makeArray(arguments);
	args.unshift(source);
	return $.format.apply(this, args);
	};
	if (arguments.length > 2 && params.constructor != Array) {
	params = $.makeArray(arguments).slice(1);
	}
	if (params.constructor != Array) {
	params = [params];
	}
	$.each(params, function (i, n) {
	source = source.replace(new RegExp("\\{" + i + "\\}", "g"), n);
	});
	return source;
}; 
jQuery.fn.extend({     
    /**    
     * 选中内容    
     */    
    selectContents: function(){     
        $(this).each(function(i){     
            var node = this;     
            var selection, range, doc, win;     
            if ((doc = node.ownerDocument) &&     
                (win = doc.defaultView) &&     
                typeof win.getSelection != 'undefined' &&     
                typeof doc.createRange != 'undefined' &&     
                (selection = window.getSelection()) &&     
                typeof selection.removeAllRanges != 'undefined')     
            {     
                range = doc.createRange();     
                range.selectNode(node);     
                if(i == 0){     
                    selection.removeAllRanges();     
                }     
                selection.addRange(range);     
            }     
            else if (document.body &&     
                     typeof document.body.createTextRange != 'undefined' &&     
                     (range = document.body.createTextRange()))     
            {     
                range.moveToElementText(node);     
                range.select();     
            }     
        });     
    },     
    /**    
     * 初始化对象以支持光标处插入内容    
     */    
    setCaret: function(){     
        if(!$.browser.msie) return;     
        var initSetCaret = function(){     
            var textObj = $(this).get(0);     
            textObj.caretPos = document.selection.createRange().duplicate();     
        };     
        $(this)     
        .click(initSetCaret)     
        .select(initSetCaret)     
        .keyup(initSetCaret);     
    },     
    /**    
     * 在当前对象光标处插入指定的内容    
     */    
    insertAtCaret: function(textFeildValue){     
       var textObj = $(this).get(0);     
       if(document.all && textObj.createTextRange && textObj.caretPos){     
           var caretPos=textObj.caretPos;     
           caretPos.text = caretPos.text.charAt(caretPos.text.length-1) == '' ?     
                               textFeildValue+'' : textFeildValue;     
       }     
       else if(textObj.setSelectionRange){     
           var rangeStart=textObj.selectionStart;     
           var rangeEnd=textObj.selectionEnd;     
           var tempStr1=textObj.value.substring(0,rangeStart);     
           var tempStr2=textObj.value.substring(rangeEnd);     
           textObj.value=tempStr1+textFeildValue+tempStr2;     
           textObj.focus();     
           var len=textFeildValue.length;     
           textObj.setSelectionRange(rangeStart+len,rangeStart+len);     
           textObj.blur();     
       }     
       else {     
           textObj.value+=textFeildValue;     
       }     
    }  
}); 
function InsertMsgPic(e,i)
{
	$('#sendMsgInput').insertAtCaret('[img='+e+']');
	$('#sourceimg').val(i);
	$('#imgthumb').val(e);
}

/**
 * 时间对象的格式化;
 */
Date.prototype.format = function(format) {
    /*
     * eg:format="YYYY-MM-dd hh:mm:ss";
     */
    var o = {
        "M+" :this.getMonth() + 1, // month
        "d+" :this.getDate(), // day
        "h+" :this.getHours(), // hour
        "m+" :this.getMinutes(), // minute
        "s+" :this.getSeconds(), // second
        "q+" :Math.floor((this.getMonth() + 3) / 3), // quarter
        "S" :this.getMilliseconds()
    // millisecond
    }

    if (/(y+)/.test(format)) {
        format = format.replace(RegExp.$1, (this.getFullYear() + "")
                .substr(4 - RegExp.$1.length));
    }

    for ( var k in o) {
        if (new RegExp("(" + k + ")").test(format)) {
            format = format.replace(RegExp.$1, RegExp.$1.length == 1 ? o[k]
                    : ("00" + o[k]).substr(("" + o[k]).length));
        }
    }
    return format;
}   

//闪烁提醒 
function twinkleAlert(where,aclass){
	setTimeout((function (s,c) { return function (){$(s).addClass(c);}; })(where,aclass), 200);
	setTimeout((function (s,c) { return function (){$(s).removeClass(c);}; })(where,aclass), 400);
	setTimeout((function (s,c) { return function (){$(s).addClass(c);}; })(where,aclass), 600);
	setTimeout((function (s,c) { return function (){$(s).removeClass(c);}; })(where,aclass), 800);
	setTimeout((function (s,c) { return function (){$(s).addClass(c);}; })(where,aclass), 1000);
}

//发言框select对某人说
function selectTalkTo(uid,name,rid){
	var $select = $('#send_talkto');
	var $op = $select.children('option[value="'+uid+'"]');
	$select.children().removeAttr('selected');
	if($op && $op.length>0){	
		$op.remove();
	}
	$select.append('<option value="'+uid+'" rid="'+rid+'" selected=selected>'+name+'</option>');
	//$('#send_talkto option[value="'+uid+'"]').attr('selected',true);
	talktoSelectChange();
}
//根据用户角色id 判断是否有私聊权限
function hasSiLiaoPower(rid){
	if(isHasPower(rid,'is_private_chat')){
		return true;
	}
	return false;
}
//禁言
function forbidSpeak(type,uid){
	
	$.post( gag_url,{ 'room_id':room_id,'member_id':uid,'time':'300','type':type},function(data){
		if(data.rs){
			alertBox(data.content,'success');
		}else{
			alertBox(data.content,'error');
		}
	},'json');
}
//踢出房间
function kickout(uid){
	$.post( kick_url ,{'room_id':room_id , 'to_uid':uid,'time':3600},function(data){
		if(data.rs){
			alertBox(data.content,'success');
			$('li#u_'+uid).remove();
		}else{
			alertBox(data.content,'error');
		}
	},'json');
}
//聊天对象改变的时候，判断是否具有私聊功能
function talktoSelectChange(){
	var $select = $('#send_talkto option:selected');
	var urid = $select.attr('rid');

	if(hasSiLiaoPower(urid) || hasSiLiaoPower(myRole.id)){
		$('#shiliao').removeAttr('disabled');
	}else{
		$('#shiliao').attr('checked',false);
		$('#shiliao').attr('disabled',true);
	}
}
function alertBox(msg,type){ //type:error 、success
	TINY.box.show({html:msg,animate:false,mask:true,close:false,boxid:type,top:150,width:'auto'});
}
//生成用户操作菜单
function uMenu(id,rid,name,ip){
	$menu = $('#MoreM');
	var mhtml = (rid > '1' && isHasPower(0,'is_company_role')) ? '<dd>ID:'+id+'</dd>':'';
	if(myInfo.id != id){
		mhtml += '<dd><a href="javascript:void(0)" onclick="sayTo(this)" uid="'+id+'" rid="'+rid+'" name="'+name+'">对他说</a></dd>';

		if(myRole['look_ip'] == 1){
			mhtml += '<dd><a href="javascript:void(0)" onclick="lookIP(this)" ip="' + ip  + '" uid="'+id+'" >查看IP</a></dd>';

		}

		if(isHasPower(0,'is_gag') && !isHasPower(rid,'is_prevent_gag')) mhtml += '<dd><a href="javascript:void(0)" onclick="forbidSpeak(1,\''+id+'\')">禁言5分钟</a></dd><dd><a href="javascript:void(0)" onclick="forbidSpeak(0,\''+id+'\')">恢复发言</a></dd>';
		if(isHasPower(0,'is_kick_room') && !isHasPower(rid,'is_prevent_kick_room'))   mhtml +='<dd><a href="javascript:void(0)" onclick="kickout(\''+id+'\');">踢出1小时</a></dd>';
		
		if(isMyFollow(id)){
			mhtml += 	'<dd><a href="javascript:void(0)" onclick="dofollow(\'' + id + '\', \'' + rid + '\',\'0\')">取消关注</a></dd>';	
		}else{
			mhtml += 	'<dd><a href="javascript:void(0)" onclick="dofollow(\'' + id + '\', \'' + rid + '\',\'1\')">添加关注</a></dd>';	
		}
		if(isHasPower(rid,'is_private_chat') || isHasPower(0,'is_private_chat')){
			 mhtml +='<dd><a href="javascript:void(0)" onclick="privateTalkto(\''+id+'\',\''+name+'\',\''+rid+'\');">对TA私聊</a></dd>';
		}
	}
	
	$menu.html(mhtml);
	$menu.on('mouseleave',function(){$menu.hide()});
	$menu.children('dd').on('click',function(){
		$menu.hide();
	});
	
	return $menu;
}
//对他说 点击事件
function sayTo(e){
	var uid =$(e).attr('uid');
	var name =$(e).attr('name');
	var rid =$(e).attr('rid');
	selectTalkTo(uid,name,rid);
}
//关注
function dofollow(uid,rid,type){ //1：关注 0：取消关注
;

	// if(rid>'1'){
	if(myRole.id>'1'){
		$.post(attention_url, {to_uid:uid ,type:type},function(data){
			if(data.rs){
				 //alertBox(data.content,'success');
			}else{
				 //alertBox(data.content,'error');
			}
		},'json');	
	}
	if(myConcern == null) return;
	var ridex = myConcern.indexOf(uid);
	if(type==0){
		if(ridex != -1){
			delete myConcern[ridex];
			$('#u_'+uid).removeClass('follow');
		}
		// ridex || delete myConcern[ridex];
	}else{
		if(ridex == -1){
			delete myConcern.push(uid);
			$('#u_'+uid).addClass('follow');
		}
		//ridex != -1 || myConcern.push(uid);
	}

}
//判断角色是否有某权限
function isHasPower(roleid,power){
/*	if(roleid == '0' || roleid ==null || roleid == 0){
		return myRole[power]=="1" ? true:false;
	}else{
		return roomRole[roleid][power]=="1" ? true:false;
	}*/
	return true;
}
//判断是否是我关注对象
function isMyFollow(uid){
	if(myConcern == null )return false;
	return $.inArray(uid,myConcern) >= 0 ? true:false;
	// return myConcern.indexOf(uid) >=0 ? true:false;
}
function RoleClass(roleid){
	this.rid=roleid;
	this.title = roomRole[this.rid]['name'];

	this.image = roomRole[this.rid]['image'];
	this.tostring = function(){
		return '<img src="'+this.image+'" title="'+this.title+'"/>';
	}
}
function getRoleImg(roleid){
	var title = roomRole[roleid]['name'];
	var image = role_img_url+roomRole[roleid]['image'];
	return '<img class="roleimg" src="'+image+'" title="'+title+'"/>';
}

//处理聊天语言，替换表情
function msgFilter(msg){
	var key=[];

	var str = msg.match(/^:caitiao\[([a-z0-9\.\/\u4e00-\u9fa5]+?)\]$/g);
	if( str ){
		var ckey = str[0].substr(9, str[0].indexOf(']')-9 );
		msg = '<img src="' + phiz_path +'color_bar/'+caitiao[ckey]+'"/>';
		return msg;
	}
	key =msg.match(/\[([a-zA-Z0-9=\.\/\u4e00-\u9fa5]+?)\]/g);
	if( key == null) return msg;
	for(i = 0;i< key.length;i++){ 
		var pkey = key[i].substr(1,key[i].indexOf(']')-1 );
		if( pkey.length >24 && pkey.substr(0,4) =='img='){
			pkeys=pkey.split('/');
			if(pkeys.length == 2){
				msg = msg.replace(key[i],'<img class="talk_pic" src="' + image_url + '/Uploads/' + pkeys[0].substr(4) + '/m_' + pkeys[1] + '" title="点击看大图" onClick="talk_pic(\'' +pkeys[0].substr(4) + '/' + pkeys[1] + '\')">');
			}
		}else{
			if(!phiz.hasOwnProperty(pkey)){
				continue;
			}

			msg = msg.replace( key[i],'<img src="' + phiz_path +'phiz/'+phiz[pkey]+'"/>');
		}
	}
	return  msg;
}

function UserClass(){
	this.id;
	this.name;
	this.rid;
	this.ip;
	this.isVisitor;
	this.isCompanyRole;
	this.toUlistLi = function(){
		var roleimg  = getRoleImg(this.rid);
		var liclass = isHasPower(this.rid,'is_company_role')=="1" ? 'manager':'';
		var hidemanager = isHasPower(this.rid,'is_company_role')=="1" ? 'style="display:none;"':'';
		var caozuo  = isHasPower(0,'is_company_role') ? '<a href="javascript:void(0)" uid="'+this.id+'" rid="'+this.rid+'" name="'+this.name+'" ip="' + this.ip + '" class="u_mor">操作</a>':isHasPower(this.rid,'is_private_chat')?'<a href="javascript:void(0)" style="margin-right:10px" onclick="privateTalkto(\''+this.id+'\',\''+this.name+'\',\''+this.rid+'\');">私聊</a>':'';
		var listr_format = '<li class="{0} {7}" {9} id="u_{1}" uid="{1}" rid="{2}" name="{3}" ip="{8}">\
		<span>{4}</span>\
		<a href="javascript:void(0)" class="f_left">{3}</a>\
		<p>{5}<a href="javascript:void(0)" class="talkto" onclick="sayTo(this)" uid="'+this.id+'" rid="'+this.rid+'" name="'+this.name+'">对他说</a><a href="javascript:void(0)" class="like" title="{6}">{6}</a></p>\
		</li>';
		if( isMyFollow(this.id) ){
			var twd ='取消关注'
			var follow ='follow';
		}else{
			var twd ='关注';
			var follow ='';

		}
		var listr = $.format(listr_format,liclass,this.id,this.rid,this.name,roleimg,caozuo,twd, follow,this.ip,hidemanager);
		var $listr =$(listr);
		
		//操作
		$listr.find('.u_mor').on('click',function(){
			var id = $(this).attr('uid');
			var rid = $(this).attr('rid');
			var name = $(this).attr('name');
			var ip = $(this).attr('ip');
			
			$menu = uMenu(id,rid,name,ip);
			var offset = $(this).offset();
			var t = offset.top;
			var l = offset.left;
			$menu.css("top",t).css("left",l);
			$menu.show();	
		});
		//关注
		
		$listr.find('.like').on('click',function(){
			$li = $(this).parent().parent();
			$li.toggleClass('follow');
			var twd = $(this).attr('title');
			var type;
			if(twd == '关注'){
				type = 1;
				$(this).attr('title','取消关注');
			}else{
				type = 0;

				$(this).attr('title','关注');
			}
			dofollow($li.attr('uid'),$li.attr('rid'),type);
		});
		return $listr;
	}
}

function MsgClass(){
	this.create = function(data){
		this.id = data.id;
		this.company_id = data.company_id;
		this.from_uid = data.from_uid;
		this.to_uid = data.to_uid;
		this.content = data.content;
		this.time = data.time;
		this.type= data.type;
		this.room_id= data.room_id;
		this.from_name= data.from_name;
		this.to_name= data.to_name;
		this.from_roleid= data.from_roleid;
		this.to_roleid= data.to_roleid;
		this.ischecked= data.ischecked;
		this.checkuid= data.checkuid;

	};
	this.toPrivateMsgItem = function(){
		var liclass = this.from_uid == myInfo.id ? 'class="mine"' : '';
		var roleimg = getRoleImg(this.from_roleid);
		//var time = new Date(parseInt(this.time) * 1000).format('[MM/dd hh:mm:ss]');
		var formatstr = '<li {0}>{1}<span>{2}</span><div class="TalkCon_p"><span>{3}</span></div></li>';
		var talkhtml =  $.format(formatstr,liclass,roleimg,this.from_name,msgFilter(this.content));
		return talkhtml;
	};
	this.toMsgItem = function(){
		var dclass = this.type=='0' ? ' private' :' public';
		if(this.from_roleid != "1" && this.type != '0'){
			dclass += ' member';
		}
		var from_role_image = getRoleImg(this.from_roleid);
		if(this.type == '0' ){
			if( this.from_uid==myInfo.id){
				this.from_name = "你";
			}else if(this.to_uid==myInfo.id){
				this.to_name = "你";
			}	
		}

		var fromname = '<a href="javascript:void(0)" class="u_mor" rid="'+this.from_roleid+'" uid="'+this.from_uid+'" >'+this.from_name+'</a>';		
		var toname = this.to_uid != 0? '<a class="dui">对</a>'+getRoleImg(this.to_roleid)+'<a href="javascript:void(0)"  class="u_mor" rid="'+this.to_roleid+'" uid="'+this.to_uid+'">'+this.to_name+'</a>':'';
		
		var time = '<a class="time">'+ new Date(parseInt(this.time) * 1000).format('[hh:mm]') + '</a>';
		var talkcontent = msgFilter(this.content);
		var checkbt = '';
		var del = '';
		if(myRole.purview_check=='1'){
			del = '<a href="javascript:void(0)" onClick="delMsg(this)" rel="'+this.id+'" class="delete" >删除</a>';
			this.del=1;
			if(this.ischecked=="0" && this.from_uid != myInfo.id  && this.type!='0'){
				checkbt = '<a href="javascript:void(0)" onClick="checkMsg(this)" rel="'+this.id+'" class="shenhe" >审核通过</a>';
			}

		}
		
		var talkformat = '<div id="{7}" class="talk {0}">\
		<span>{1}</span>\
		<div class="talk_name">{2}{3}{4}</div>\
		<div class="clear"></div>\
		<div class="talk_hua"><p>{5}</p>{6}{8}\
		</div>\
		<div class="clear"></div>\
		</div>';
		var talkhtml = $.format(talkformat,dclass,from_role_image,fromname,toname,time,talkcontent,checkbt,this.id,del);
		$talkhtml = $(talkhtml);
		$talkhtml.find('.u_mor').on('click',function(){
			var id = $(this).attr('uid');
			var rid = $(this).attr('rid');
			var name = $(this).html();
			$menu = uMenu(id,rid,name);
			var offset = $(this).offset();
			var t = offset.top;
			var l = offset.left;
			$menu.css("top",t).css("left",l);
			$menu.show();	
		});
		return $talkhtml;
	};
	this.isICanSee = function(){
		if(this.type=='0'){
			if((this.from_uid == myInfo.id) || (this.to_uid == myInfo.id) ){
				return true;
			}else{
				return false;
			}
		}else if(this.type=='1'){
			if((this.from_uid == myInfo.id) || (this.ischecked=="1") || (this.ischecked=="0" && myRole.purview_check=='1' )){
				return true;
			}else{
				return false;
			}
		}
	}
	
}

function ChatContainer(){
	this.maxNum;
	this.container;
	this.scroolwrap;
	this.tabType; //public member private
	this.dynamicscroll;
	this.create = function(scroolwrap,containerid,max){
		this.privateNum = 0;
		this.publicNum = 0;
		this.maxNum = max;
		this.tabType = 'public';
		this.container = $(containerid);
		this.scroolwrap = $(scroolwrap);
		this.dynamicscroll =true;	

		this.scroolwrap.mCustomScrollbar(scrollconf);
	};
	
	this.push = function(msgItem){		
		/*if(!msgItem.hasClass(this.tabType)){
			msgItem.hide();
		}
		var msgid = msgItem.attr('id');
		var om  = this.container.children('#'+msgid); 
		if(om && om.length>0)return;*/
		this.container.append(msgItem);
		/*
		if(msgItem.hasClass('private')){
			if(this.container.children(".private").size() > this.maxNum){
				this.container.children(".private").first().remove();
		
			}
		}else{
			var msgnum = this.container.children().not(".private").size();
			if((msgnum > this.maxNum && this.dynamicscroll) || msgnum>150){
				for(var i=0 ; i< msgnum - this.maxNum; i++){
					this.container.children().not(".private").first().remove();
				}
			}
		}*/
		// this.scroolwrap.mCustomScrollbar("scrollTo","last",{ scrollInertia:300});
		this.scrollToLast();
	}
	//滚动到底部
	this.scrollToLast = function(){
		this.scroolwrap.mCustomScrollbar("update");
		if(this.dynamicscroll){
			this.scroolwrap.mCustomScrollbar("scrollTo","bottom");
		}	
	}
	//内容切换显示
	this.tabToType = function(type){	
		this.tabType = type;	
		$('#talk_filter a').removeClass();
		$('#talk_filter a[rel='+type+']').addClass('cur');
		this.container.children().hide();	
		this.container.children('.'+type).show();
		this.scrollToLast();

	}
	//清屏
	this.clear = function(){
		this.container.children('.'+this.tabType).remove();
	}
}

function UserList(){
	this.scroolwrap;
	this.container;
	this.tabType;//all manager follow
	this.create = function(scrollwrapid,containerid){
		this.container = $(containerid);
		this.Type = 'all';
		this.scroolwrap = $(scrollwrapid);
		this.scroolwrap.mCustomScrollbar(scrollconf);
	}
	
	//切换显示
	this.tabToType = function(type){
		this.tabType = type;
		if(type=='all'){
			this.container.children().show();
			this.container.children('.manager').hide();
		}else{
			this.container.children().hide();
			this.container.children('.'+type).show();
		}
		this.scroolwrap.mCustomScrollbar('update');
	}
	//清空
	this.clear = function(){
		this.container.empty();
	}
	//搜索
	this.search = function(word){
		this.container.children().hide();
		this.container.children('#'+word).show();
		this.container.children('[name='+word+']').show();
	}
}


//房间投票
function vote(value){
	$.post( vote_post ,{room_id:room_id,vote_id:1,value:value},function(data){
		var alty = data.status ? 'success':'error';
		alertBox(data.msg,alty);
	},'json');
}
//房间投票
function more_vote(value,vote_id){

	$.ajax({
		type: "POST",
		url: '/index.php/vote',
		dataType: "json",
		data: {"vote" : value , "vote_id" : vote_id},
		success: function(d){
			if (d.code == '1')
			{
				layer.msg(d.msg, 2, 1);
				$("#kz"+vote_id).html(d.kz);
				$("#pz"+vote_id).html(d.pz);
				$("#kk"+vote_id).html(d.kk);
			}
			else
				layer.msg(d.msg, 2, 0);
		}
	});

}


function vote_nav_switch(n){
	$('div.mt ul li').attr('class','line');
	$('div.toupiao div').attr('class','hide');
	$('#w_'+n).attr('class','show');
	$('#n_'+n).attr('class','curr');
}

//输入框
function send_image(value){
	$('#sendMsgInput').insertAtCaret('['+value+']');
}

//聊天图片
function talk_pic(img){
		TINY.box.show({image: img});
}
//收藏页面
function AddFavorite(sURL, sTitle)
{
		try
		{
			window.external.addFavorite(sURL, sTitle);
		}
		catch (e)
		{   
			try
			{
				window.sidebar.addPanel(sTitle, sURL, "");
			}
			catch (e)
			{
				alert("加入收藏失败，请使用Ctrl+D进行添加");
			}
		}
}

//[可删]
function initUploadImage(){
	//上传图片
	$('#testFileInput').uploadify({
		'swf': "/Public/Dwz/uploadify/scripts/uploadify.swf",
		fileTypeDesc:'Image file', //选择文件提示文字
		fileTypeExts : '*.jpeg; *.gif; *.jpg; *.png',
		fileTypeExts:'*.jpg;*.jpeg;*.gif;*.png;',
		uploader: image_url + '/index.php/Upload/',
		fileSizeLimit:'500KB',
		width:120,
		height:30,
		isnav:1,
		auto:true,
		multi:true,
		buttonText:'上传图片',
		onUploadSuccess:function(file,data,response){ 
			eval('var data='+data);
			var img_format = '<dd onclick="send_image(\'{1}{2}\')" >\
			<img src="{0}/Uploads/{1}m_{2}" isface="1" style="max-width:100px;max-height:80px">\
			</dd>';
			img_html = $.format(img_format, image_url,data['savepath'],data['savename']);
			$('#myimagelist').prepend(img_html);


			$.post( addmyImage ,{ url:data['pic_path']});
		}
	});	
}

function new_upImage(){
//	if(myRole['is_uploadimg'] != 1){
//		alertBox('抱歉，您的等级无上传图片权限','error');
//		return false;
//	}
	var isIE=document.all && window.external;
	if(!isIE){
		document.getElementById('filedata').click();
	}
}

function lookIP(e){
	var ip = $(e).attr('ip');
	var uid = $(e).attr('uid');

	if(ip =='undefined'){
		ip = $('#u_' + uid).attr('ip');
		if(!ip){
			$.post(ip_url,{uid:uid},function(data){
				if(data.status){
					ip = data.ip;
					window.open('http://www.ip.cn/index.php?ip='+ip,'newwindow','height=500,width=400,top=0,left=0,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no');
				}else{
					alertBox('获取不到IP','error');
				}
			},'json');
		}else{
			window.open('http://www.ip.cn/index.php?ip='+ip,'newwindow','height=500,width=400,top=0,left=0,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no');
		}
	}else{
		window.open('http://www.ip.cn/index.php?ip='+ip,'newwindow','height=500,width=400,top=0,left=0,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no');
	}
		// alertBox(ip,'success');

}


function hoverDel(){
	$('#topicbox > div').hover(
		function(){
			$(this).find('.delete').show();
		},function(){
			$(this).find('.delete').hide();
		}
	);
}



function flyScreen(data){
	var text = data.content;
	var margintop = 200;
	var marginbottom = 200;
	var minwidth = 600;
	var id="marquee"+Date.now()+getRandom(1000);
	var $flyscreen = $('<marquee direction="left"  class="flyscreen flyscreen_'+data.color+'" id="'+id+'" scrollamount="6" behavior="scroll" loop=1></marquee>');
	$flyscreen.text(text);
	var len=0;
	//计算文字长度
	for(i=0;i<text.length;i++)
	{
		if(text.charCodeAt(i)>256)
		{len += 2;}
		else
		{len++;}
	}
	len = len*20;	
	len = Math.max(minwidth,len);
	var scrollamount = $flyscreen.attr('scrollamount');
	var scrolltime = len/6;
	$flyscreen.css("width",len);
	var flytop = margintop + getRandom(  $(window).height()- $flyscreen.height() -margintop - marginbottom);
	$flyscreen.css("top",flytop+"px");
	$("body").append($flyscreen);
	$flyscreen.show();
	//定时清除
	setTimeout("removeElement('"+id+"')", scrolltime*200 );
}
function removeElement(id){
	$("#"+id).remove();
}
function getRandom(n){
        return Math.floor(Math.random()*n+1);
}

active_session = function(){
    $.ajax({
          async: false, 
          url: "/active_session.html?" +new Date().valueOf(),
          success: function(data){
          },
          dataType: "html"
    });
}

//换肤
var bg_img_li_html='<img src="'+ bg_img + '" style="margin-right:5px;cursor:pointer;width:100px;height:55px" onclick="changeBg(\''+ bg_img + '\')">'; 
for(var i=1;i<=24;i++){
    if( i != 6 ){
        bg_img_li_html = bg_img_li_html+'<img src="/themes/v2/static/images/bg/w'+ i + 'x.jpg" style="margin-right:5px;cursor:pointer" onclick="changeBg(\'/themes/v2/static/images/bg/w'+ i + '.jpg\')">'; 
    }
}
function showBgList(){
    TINY.box.show({html:bg_img_li_html,width:630,height:245,openjs:function(){
        $('.alert_title').hide();
        $('.tbox').css('position','absolute');
    }});
}
function changeBg(src){
	$('#zoomWallpaperGrid img').attr('src',src);
	$.cookie('bg_img',src, {expires: 365, path: '/'});
}

var loginform = '<div class="us_mian  clearfix" >\
<form action="" onsubmit="login(); return false;" id="loginform">\
<ul class="us_con" style="width:250px">\
<li style="width:250px"><input type="hidden"  name="url" value="room/7"/></li>\
<li style="width:250px"><input type="text" placeholder="帐号" style="width:220px" name="username" class="text_input us_input"/></li>\
<li style="width:250px"><input type="password" placeholder="密码" style="width:220px" name="passwd" ispwd="1" class="text_input us_input"/></li>\
<li style="width:250px;height:48px;"><input type="submit" style="width:230px" class="btn_input us_input"  value="登 录"/></li>\
</ul>\
</form>\
</div>';
function showLoginForm(){
	TINY.box.show({html:loginform,width:260,height:390,openjs:function(){
		$('.alert_title').hide();
		$('.tbox').css('position','absolute');
	}});
}


function postdata(formid, action, callback)
{
	//layer.load(2);
	$("#" + formid).ajaxSubmit(
	{			
		type:"post",
		url:action,
		success:function(data){	
			eval(callback + '((' + data + '))');
		}
	})
}

var regform='<div id="regForm" style="display: block;" class="layer_pageContent"><div class="cfix regFormHead"><div class="f1 fl">用户注册</div><div class="f2 fl">设置账户及登录密码</div></div><div style="padding:15px;"><form action="javascript:;" id="form1"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tbody><tr><td align="right">账户名：</td><td> <input name="username" type="text" class="input">&nbsp;<span style="color:red">必填</span></td></tr><tr><td align="right">个人昵称：</td><td><input name="name" type="text" class="input">&nbsp;<span style="color:red">必填</span></td></tr><tr><td align="right">设置登录密码：</td><td><input name="passwd" type="password" class="input" value="">&nbsp;<span style="color:red">必填</span></td></tr><tr><td align="right">再输入一遍：</td><td><input name="repasswd" type="password" class="input">&nbsp;<span style="color:red">必填</span></td></tr><tr><td align="right">手机号：</td><td><input name="phone" type="text" class="input">&nbsp;<span style="color:red">必填</span></td><td>&nbsp;</td></tr><tr><td align="right">QQ：</td><td><input name="qq" type="text" class="input">&nbsp;<span style="color:red">选填</span></td><td>&nbsp;</td></tr><tr><td align="right">验证码：</td><td><div class="cfix"><input name="r_code" type="text" class="input" style="width:80px"> <img src="/index.php/code/create_vcode" id="imgyzm" style="width:100px; height:32px"> </div>输入图片中的字符，区分大小写。<a href="javascript:void(0)" onclick="refreshPid()">换一张</a></td></tr><tr><td align="right">&nbsp;</td><td><input type="submit" style="width:230px" onclick="register()" class="btn_input us_input" value="提交"></td></tr></tbody></table></form></div></div>';
function showRegForm(){
	TINY.box.show({html:regform,width:600,height:500,openjs:function(){
		$('.alert_title').hide();
		$('.tbox').css('position','absolute');
	}});
}

function register(){
	postdata('form1',"/index.php/user/reg",'show');
}

function sendCaitiao(e){
	$("#sendMsgInput").val('['+e+']');
	sendMsg();
}

function refreshPid(){
	$("#imgyzm").attr('src', '/index.php/code/create_vcode' + '/' + Math.random());
}