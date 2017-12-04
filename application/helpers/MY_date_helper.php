<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 格式化时间
* @param string $from 起始时间
* @param string $now 终止时间
* @return string
*/
if ( ! function_exists('dateFormat')){
	function dateFormat($from, $now)
	{
		//fix issue 3#6 by saturn, solution by zycbob

		/** 如果不是同一年 */
		if (idate('Y', $now) != idate('Y', $from)) 
		{
			return date('Y年m月d日', $from);
		}

		/** 以下操作同一年的日期 */
		$seconds = $now - $from;
		$days = idate('z', $now) - idate('z', $from);

		/** 如果是同一天 */
		if ($days == 0) 
		{
			/** 如果是一小时内 */
			if ($seconds < 3600) 
			{
				/** 如果是一分钟内 */
				if ($seconds < 60)
				{
					if (3 > $seconds) 
					{
						return '刚刚';
					} 
					else 
					{
						return sprintf('%d秒前', $seconds);
					}
				}

				return sprintf('%d分钟前', intval($seconds / 60));
			}

			return sprintf('%d小时前', idate('H', $now) - idate('H', $from));
		}

		/** 如果是昨天 */
		if ($days == 1) 
		{
			return sprintf('昨天 %s', date('H:i', $from));
		}

		/** 如果是前天 */
		if ($days == 2) 
		{
			return sprintf('前天 %s', date('H:i', $from));
		}

		/** 如果是7天内 */
		if ($days < 7) 
		{
			return sprintf('%d天前', $days);
		}

		/** 超过一周 */
		return date('n月j日', $from);
	}
}


if ( ! function_exists('getAge')){
	function getAge($birthday)
	{
		if ($birthday == '') return '';
	
		$year = substr($birthday, 0, 4);
		return (int)(date('Y') - $year + 1);		
	}
}

if ( ! function_exists('getArray')){
	function getArray($start,$end)
	{
		$year = array();
		$j = 0;
		for ($i = $start;$i<=$end;$i++)
		{

			$year[$j]['id'] = $i;
			$year[$j]['name'] = $i;

			$j++;
		}
		return $year;		
	}
}


//根据某年的第几周星期几返回具体日期
if ( ! function_exists('getd')){
	function getd($year,$weeknum,$week,$format){
	  $yearstr=$year.'-1-1';
	  $weeknumstr=$weeknum-1;
	  $weekw=date('W',strtotime($yearstr));
	  $weekx=date('w',strtotime($yearstr));
	  $dnum=0;
	  if($weekw!='01'){
		$dnum=7-$weekx;
	  }else{
		$dnum=-$weekx;
	  }
	  $weekstr=$week+$dnum;
	  $nowdate=date($format,strtotime($yearstr."+$weeknumstr week $weekstr days"));
	  return $nowdate;
	}
}