<?php
$config = array(
	 'user/reg' => array(
		array(
				'field' => 'username',
				'label' => '账户名',
				'rules' => 'trim|required|callback_checkUsername|min_length[3]|max_length[30]|xss_clean'
			 ),
		array(
				'field' => 'name',
				'label' => '个人昵称',
				'rules' => 'trim|required|min_length[2]|max_length[30]'
			 ),
		array(
				'field' => 'passwd',
				'label' => '密码',
				'rules' => 'trim|required|matches[repasswd]|min_length[6]|max_length[30]|md5'
			 ),
		array(
				'field' => 'repasswd',
				'label' => '确认密码',
				'rules' => 'trim|required|min_length[6]|max_length[30]'
			 ),
		array(
				'field' => 'phone',
				'label' => '手机号',
				'rules' => 'trim|required|callback_phone_Check|xss_clean'
			 ),
		/*array(
				'field' => 'email',
				'label' => '邮箱',
				'rules' => 'trim|required|valid_email|xss_clean'
			 ),
		array(
				'field' => 'qq',
				'label' => 'QQ号码',
				'rules' => 'trim|required|numeric|xss_clean'
			 )*/
		),

	 /*'user/login' => array(
		array(
				'field' => 'username',
				'label' => '用户名',
				'rules' => 'trim|required|min_length[3]|max_length[30]|xss_clean'
			 ),
		array(
				'field' => 'passwd',
				'label' => '密码',
				'rules' => 'trim|required|min_length[6]|max_length[30]'
			 )
		),*/
	'user/login' => array(
		array(
				'field' => 'username',
				'label' => '用户名',
				'rules' => 'trim|required|min_length[3]|max_length[30]|xss_clean'
			 ),
		array(
				'field' => 'passwd',
				'label' => '密码',
				'rules' => 'trim|required|min_length[6]|max_length[30]'
			 )
		),
	'user/getpasswd'=>array(
		array(
				'field' => 'username',
				'label' => 'QQ号码',
				'rules' => 'trim|required|min_length[3]|max_length[30]|xss_clean'
			 )
		),
	
	'apply/add'=>array(
		array(
				'field' => 'real_name',
				'label' => '真实姓名',
				'rules' => 'trim|required'
			 ),
		
		array(
				'field' => 'note',
				'label' => '颁发的奖品',
				'rules' => 'trim|required'
			 )
		),


/** 后台操作 */
	'admin_user/add' => array(
		array(
				'field' => 'user_name',
				'label' => '用户名',
				'rules' => 'trim|required'
			 ),
		array(
				'field' => 'email',
				'label' => 'Email地址',
				'rules' => 'trim|required|valid_email'
			 ),
		array(
				'field' => 'password',
				'label' => '密码',
				'rules' => 'trim|required|min_length[6]|md5'
			 ),
		array(
				'field' => 'repassword',
				'label' => '确认密码',
				'rules' => 'trim|required|matches[password]|min_length[6]|md5'
			 )
		),
	
	'admin_user/edit' => array(
		array(
				'field' => 'user_name',
				'label' => '用户名',
				'rules' => 'trim|required'
			 ),
		array(
				'field' => 'email',
				'label' => 'Email地址',
				'rules' => 'trim|required|valid_email'
			 ),
		array(
				'field' => 'oldpassword',
				'label' => '旧密码',
				'rules' => 'trim|callback_checkOldpasswd|md5'
			 ),
		array(
				'field' => 'newpassword',
				'label' => '新密码',
				'rules' => 'trim|min_length[6]|md5'
			 ),
		array(
				'field' => 'renewpassword',
				'label' => '确认新密码',
				'rules' => 'trim|callback_checkrepasswd|matches[newpassword]|min_length[6]|md5'
			 ),
		),
	
	'role/add' => array(
		array(
				'field' => 'role_name',
				'label' => '角色名',
				'rules' => 'trim|required'
			 )
		),

	'admin/modi' => array(
		array(
				'field' => 'newpasswd',
				'label' => '新密码',
				'rules' => 'trim|required|min_length[6]|max_length[30]'
			 ),
		array(
				'field' => 'repasswd',
				'label' => '确认密码',
				'rules' => 'trim|required|matches[newpasswd]|min_length[6]|max_length[30]'
			 ),
		array(
				'field' => 'oldpasswd',
				'label' => '旧密码',
				'rules' => 'trim|required|callback_checkOldpasswd|min_length[6]|max_length[30]'
			 )
		),
	'login/index' => array(
		array(
				'field' => 'username',
				'label' => '用户名',
				'rules' => 'trim|required|min_length[3]|max_length[30]|xss_clean'
			 ),
		array(
				'field' => 'passwd',
				'label' => '密码',
				'rules' => 'trim|required|min_length[6]|max_length[30]'
			),
		),
    'user/add' => array(
        array(
            'field' => 'username',
            'label' => '用户名',
            'rules' => 'trim|requried|min_length[3]|max_length[30]'
        ),
        array(
            'field' => 'newpasswd',
            'label' => '密码',
            'rules' => 'trim|requried|matches[repasswd]|min_length[6]|max_length[30]|md5'
        ),
        array(
            'field' => 'repasswd',
            'label' => '确认密码',
            'rules' => 'trim|requried|min_length[6]|max_length[30]|md5'
        ),
    ),
    'user/muladd' => array(
        array(
            'field' => 'users',
            'label' => '用户名',
            'rules' => 'trim|requried|min_length[3]|max_length[30]'
        ),
    ),
	'user/modi' => array(
		array(
				'field' => 'newpasswd',
				'label' => '密码',
				'rules' => 'trim|matches[repasswd]|min_length[6]|max_length[30]|md5'
			 ),
		array(
				'field' => 'repasswd',
				'label' => '确认密码',
				'rules' => 'trim|min_length[6]|max_length[30]|md5'
			 ),

		),

	'passwdmodi' => array(
		 array(
				 'field' => 'passwd',
				 'label' => '密码',
				 'rules' => 'trim|required|min_length[6]|max_length[30]|md5'
			  ),
		 array(
				 'field' => 'repasswd',
				 'label' => '密码确认',
				 'rules' => 'trim|required|matches[passwd]|md5'
			  )		
		),
	

	 'live/roomapp' => array(
		array(
				'field' => 'userid',
				'label' => '用户编号',
				'rules' => 'trim|required'
			 ),

		array(
				'field' => 'roomname',
				'label' => '直播室名称',
				'rules' => 'trim|required|min_length[3]|max_length[30]|xss_clean'
			 ),
		array(
				'field' => 'cateid',
				'label' => '所属栏目',
				'rules' => 'trim|required'
			 ),
		array(
				'field' => 'roompass',
				'label' => '直播室密码',
				'rules' => 'trim|min_length[6]|max_length[30]'
			 )
		),

	 'live/setMaster' => array(
		array(
				'field' => 'userid',
				'label' => '用户编号',
				'rules' => 'trim|required'
			 ),
		array(
				'field' => 'roomid',
				'label' => '直播室编号',
				'rules' => 'trim|required'
			 ),

		array(
				'field' => 'mastertitle',
				'label' => '直播主题',
				'rules' => 'trim|required|min_length[3]|max_length[100]|xss_clean'
			 ),
		array(
				'field' => 'masterinfo',
				'label' => '直播简介',
				'rules' => 'trim|required|min_length[3]|max_length[800]'
			 )
		),

	 'live/setQuestion' => array(
		array(
				'field' => 'userid',
				'label' => '用户编号',
				'rules' => 'trim|required'
			 ),
		array(
				'field' => 'questionname',
				'label' => '姓名',
				'rules' => 'trim|required｜min_length[2]|max_length[30]'
			 ),

		array(
				'field' => 'content',
				'label' => '问题',
				'rules' => 'trim|required|min_length[6]|max_length[300]'
			 )
		),


	 'category/add' => array(
		array(
				'field' => 'catename',
				'label' => '类别名称',
				'rules' => 'trim|required|min_length[2]|max_length[30]'
			 ),
		array(
				'field' => 'parentid',
				'label' => '所属父类',
				'rules' => 'callback_check_cateid'
			 ),

		array(
				'field' => 'func',
				'label' => '所属应用',
				'rules' => 'trim|required|min_length[3]|max_length[30]'
			 )
		),

	 'article/edit' => array(
		array(
				'field' => 'title',
				'label' => '标题',
				'rules' => 'trim|required|min_length[1]|max_length[100]|xss_clean'
			 )
		),
	
	'advertisement/edit' => array(
		array(
				'field' => 'title',
				'label' => '广告名称',
				'rules' => 'trim|required|min_length[2]|max_length[50]'
			 )
		),

	'home/add' => array(
		array(
				'field' => 'title',
				'label' => '标题',
				'rules' => 'trim|required|min_length[3]|max_length[100]|xss_clean'
			 )
		),

	'contentsubmit' => array(
		array(
				'field' => 'content',
				'label' => '内容',
				'rules' => 'trim|required'
			 )
		),

	'chat/setContent' => array(
		array(
				'field' => 'chatuserid',
				'label' => '用户编号',
				'rules' => 'trim|required|min_length[1]|max_length[8]'
			 ),
		array(
				'field' => 'chatname',
				'label' => '姓名',
				'rules' => 'trim|required|min_length[2]|max_length[30]'
			 )

		),

	'live/appVip' => array(
		array(
				'field' => 'userid',
				'label' => '用户编号',
				'rules' => 'trim|required'
			),
		array(
				'field' => 'approomvip',
				'label' => '申请VIP的直播室编号',
				'rules' => 'trim|required'
			)
		),

	'user/setLevel' => array(
		array(
				'field' => 'userid',
				'label' => '用户编号',
				'rules' => 'trim|required'
			)
		),
	'zt/add' => array(
		array(
				'field' => 'title',
				'label' => '专题名称',
				'rules' => 'trim|required'
			 ),
		array(
				'field' => 'btime',
				'label' => '专题活动开始时间',
				'rules' => 'trim|required'
			 ),
		array(
				'field' => 'etime',
				'label' => '专题活动结束时间',
				'rules' => 'trim|required'
			 )
		),
	'notice/add' => array(
		array(
				'field' => 'title',
				'label' => '公告标题',
				'rules' => 'trim|required|xss_clean'
			 ),
		array(
				'field' => 'content',
				'label' => '详细内容',
				'rules' => 'trim|required|xss_clean'
			 )
		),
	
	'home/reg' => array(
		array(
				'field' => 'r_name',
				'label' => '昵称',
				'rules' => 'trim|required|callback_hasName|min_length[3]|max_length[30]|xss_clean'
			),
		/*array(
				'field' => 'r_phone',
				'label' => '手机号码',
				'rules' => 'trim|required|callback_isMobile|callback_hasRegisted'
			),*/
		array(
				'field' => 'r_qq',
				'label' => 'QQ号码',
				'rules' => 'trim|required|numeric|callback_hasRegisted'
			),
		array(
				'field' => 'r_password',
				'label' => '用户密码',
				'rules' => 'trim|required|min_length[6]'
			)/*,
		array(
				'field' => 'r_email',
				'label' => '邮箱',
				'rules' => 'trim|required|valid_email'
			)*/
		),
    'say_manage/modi' => array(
        array(
            'field' => 'content',
            'label' => '发言内容',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'status',
            'label' => '状态',
            'rules' => 'trim|required'
        )
    ),
    'say_manage/say' => array(
        array(
            'field' => 'userid',
            'label' => '用户ID',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'gap',
            'label' => '时间间隔',
            'rules' => 'trim|required'
        )
    )

);