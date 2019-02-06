<?php

/**
 * 相似度
 * @param  [array]  $arr1    [数组1]
 * @param  [array]  $arr2    [数组2]
 * @param  [int] 	$convert [转换进制]
 * @return [int]           	[转置]
 */
function getDistance (array $arr1,array $arr2,int $convert = 26)
{
	$res = 0;
	foreach ($arr1 as $k=>$v) {
		$v = (int) base_convert($v,$convert,10);
		$str = (int) base_convert($arr2[$k],$convert,10);
		$str = $v ^ $str;
		$str = base_convert($str,10,2);
		$res += substr_count($str,1);
	}

	return $res;
}