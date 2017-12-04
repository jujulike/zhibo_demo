<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* ��½��־ģ��
*
*/

class Login_log_model extends MY_Model {

	function __construct()
    {
        parent::__construct();
		$this->tbl		= 'live_login_log';
		$this->tbl_key	= 'log_id';
    }


	function addLog($userid,$username,$ip)
	{
		$curdate = date("Y-m-d",time());
		$c = $this->C(array('userid'=>$userid,'cdate'=>$curdate));
		$region = $this->ipCity($ip);
		if ($c > 0)
		{
			$this->M(array('ctime'=>time(),'region'=>$region,'ip'=>$ip),array('userid'=>$userid,'cdate'=>$curdate));
		}
		else
		{
			$this->A(array('userid'=>$userid,'username'=>$username,'region'=>$region,'ip'=>$ip,'cdate'=>$curdate,'ctime'=>time()));
		}
	}



	/*
	�������ƣ�ipCity
	����˵����$userip�����û�IP��ַ
	�������ܣ�PHPͨ��IP��ַ�ж��û����ڳ���
	author:lee
	contact:xpsem2010@gmail.com
	*/
	function ipCity($ip) {

		$userip = $ip;
		//IP���ݿ�·���������õ���QQ IP���ݿ� 20110405 �����
		$dat_path = APPPATH . 'third_party/ipaddress/qqwry.dat';

		//�ж�IP��ַ�Ƿ���Ч
		if(!ereg("^([0-9]{1,3}.){3}[0-9]{1,3}$", $userip)){
			return 'IP Address Invalid';
		}

		//��IP���ݿ�
		if(!$fd = @fopen($dat_path, 'rb')){
			return 'IP data file not exists or access denied';
		}

		//explode�����ֽ�IP��ַ������ó������ν��
		$userip = explode('.', $userip);
		$useripNum = $userip[0] * 16777216 + $userip[1] * 65536 + $userip[2] * 256 + $userip[3];

		//��ȡIP��ַ������ʼ�ͽ���λ��
		$DataBegin = fread($fd, 4);
		$DataEnd = fread($fd, 4);
		$useripbegin = implode('', unpack('L', $DataBegin));
		if($useripbegin < 0) $useripbegin += pow(2, 32);
		$useripend = implode('', unpack('L', $DataEnd));
		if($useripend < 0) $useripend += pow(2, 32);
		$useripAllNum = ($useripend - $useripbegin) / 7 + 1;

		$BeginNum = 0;
		$EndNum = $useripAllNum;
		$useripAddr2 = '';
		$useripAddr1 = '';
		//ʹ�ö��ֲ��ҷ���������¼������ƥ���IP��ַ��¼
		while(@$userip1num>@$useripNum || @$userip2num<@$useripNum) {
			$Middle= intval(($EndNum + $BeginNum) / 2);

			//ƫ��ָ�뵽����λ�ö�ȡ4���ֽ�
			fseek($fd, $useripbegin + 7 * $Middle);
			$useripData1 = fread($fd, 4);
			if(strlen($useripData1) < 4) {
				fclose($fd);
				return 'File Error';
			}
			//��ȡ����������ת���ɳ����Σ���������Ǹ��������2��32����
			$userip1num = implode('', unpack('L', $useripData1));
			if($userip1num < 0) $userip1num += pow(2, 32);

			//��ȡ�ĳ���������������IP��ַ���޸Ľ���λ�ý�����һ��ѭ��
			if($userip1num > $useripNum) {
				$EndNum = $Middle;
				continue;
			}

			//ȡ����һ��������ȡ��һ������
			$DataSeek = fread($fd, 3);
			if(strlen($DataSeek) < 3) {
				fclose($fd);
				return 'File Error';
			}
			$DataSeek = implode('', unpack('L', $DataSeek.chr(0)));
			fseek($fd, $DataSeek);
			$useripData2 = fread($fd, 4);
			if(strlen($useripData2) < 4) {
				fclose($fd);
				return 'File Error';
			}
			$userip2num = implode('', unpack('L', $useripData2));
			if($userip2num < 0) $userip2num += pow(2, 32);

			//�Ҳ���IP��ַ��Ӧ����
			if($userip2num < $useripNum) {
				if($Middle == $BeginNum) {
					fclose($fd);
					return 'No Data';
				}
				$BeginNum = $Middle;
			}
		}

		$useripFlag = fread($fd, 1);
		if($useripFlag == chr(1)) {
			$useripSeek = fread($fd, 3);
			if(strlen($useripSeek) < 3) {
				fclose($fd);
				return 'System Error';
			}
			$useripSeek = implode('', unpack('L', $useripSeek.chr(0)));
			fseek($fd, $useripSeek);
			$useripFlag = fread($fd, 1);
		}

		if($useripFlag == chr(2)) {
			$AddrSeek = fread($fd, 3);
			if(strlen($AddrSeek) < 3) {
				fclose($fd);
				return 'System Error';
			}
			$useripFlag = fread($fd, 1);
			if($useripFlag == chr(2)) {
				$AddrSeek2 = fread($fd, 3);
				if(strlen($AddrSeek2) < 3) {
					fclose($fd);
					return 'System Error';
				}
				$AddrSeek2 = implode('', unpack('L', $AddrSeek2.chr(0)));
				fseek($fd, $AddrSeek2);
			} else {
				fseek($fd, -1, SEEK_CUR);
			}

			while(($char = fread($fd, 1)) != chr(0))
				@$useripAddr2 .= $char;

			$AddrSeek = implode('', unpack('L', $AddrSeek.chr(0)));
			fseek($fd, $AddrSeek);

			while(($char = fread($fd, 1)) != chr(0))
				@$useripAddr1 .= $char;
		} else {
			fseek($fd, -1, SEEK_CUR);
			while(($char = fread($fd, 1)) != chr(0))
				$useripAddr1 .= $char;

			$useripFlag = fread($fd, 1);
			if($useripFlag == chr(2)) {
				$AddrSeek2 = fread($fd, 3);
				if(strlen($AddrSeek2) < 3) {
					fclose($fd);
					return 'System Error';
				}
				$AddrSeek2 = implode('', unpack('L', $AddrSeek2.chr(0)));
				fseek($fd, $AddrSeek2);
			} else {
				fseek($fd, -1, SEEK_CUR);
			}
			while(($char = fread($fd, 1)) != chr(0)){
				@$useripAddr2 .= $char;
			}
		}
		fclose($fd);

		//����IP��ַ��Ӧ�ĳ��н��
		if(preg_match('/http/i', $useripAddr2)) {
			$useripAddr2 = '';
		}
		$useripaddr = "$useripAddr1 $useripAddr2";
		$useripaddr = preg_replace('/CZ88.Net/is', '', $useripaddr);
		$useripaddr = preg_replace('/^s*/is', '', $useripaddr);
		$useripaddr = preg_replace('/s*$/is', '', $useripaddr);
		if(preg_match('/http/i', $useripaddr) || $useripaddr == '') {
			$useripaddr = 'No Data';
		}
		$address = iconv('GB2312','UTF-8',$useripaddr);
		return $address;

	}

}
?>