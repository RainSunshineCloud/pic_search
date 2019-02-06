<?php
namespace RainSunshineCloud\src;
class PHash 
{	
	private static $N = 8;
	/**
	 * @Author   RyanWu
	 * @DateTime 2018-02-28
	 * @param    array     $arr 
	 * @return   [type]          [description]
	 */
	public static function avgHash($arr)
	{
		$total = $count = 0;
		foreach ($arr as $v) {
			$total += array_sum($v);
			$count += count($v);
		}

		$avg = $total / $count;
		$hash = self::getHash($arr,$avg);

		return [$avg,$hash];
	}

	/**
	 * @Author   RyanWu
	 * @DateTime 2018-02-28
	 */
	public static function DCTHash($arr)
	{
		//提取前面八行
		$arr = array_chunk($arr,self::$N)[0];
		$total = $count = 0;
		foreach ($arr as $k => $v) {
			//提取前面八列
			$arr[$k] = $v = array_chunk($v,self::$N)[0];
			$total += array_sum($v);
			$count += count($v);
		}
		$avg = round($total / $count);
		$hash = self::getHash($arr,$avg);
		return [$avg,$hash];
	}

	/**
	 * 获取hash值
	 * @Author   RyanWu
	 * @DateTime 2018-02-28
	 * @param    [type]     $arr [description]
	 * @param    [type]     $avg [description]
	 * @return   [type]          [description]
	 */
	protected static function getHash($arr,$avg)
	{
		$str = '';
		foreach ($arr as $v1) {
			foreach ($v1 as $v2) {
				if ($v2 < $avg) {
					$str .= '0';
				} else {
					$str .= '1';
				}
			}
		}
		$arr = str_split($str,30);
		foreach ($arr as $k => $v) {
			$arr [$k]= base_convert($v, 2, 26);
		}


		return $arr;
	}

}