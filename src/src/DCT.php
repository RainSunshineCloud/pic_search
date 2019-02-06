<?php
namespace RainSunshineCloud\src;

/**
 * DCT算法
 */
class DCT
{
	private static $N = null;

	/**
	 * @Author   RyanWu
	 * @DateTime 2018-02-28
	 * @param    [type]     $arr [description]
	 */
	public static function getDCT ($arr)
	{
		self::$N = count($arr);//获取数组的行
		$a = self::A();
		$at = self::AT();
		//A * f
		for ($i = 0;$i < self::$N; $i++ ) {
			for($j = 0;$j < self::$N;$j++ ) {
				$af[$i][$j] = 0;
				foreach ($a[$i] as $q => $v) {
					$af[$i][$j] += $v * $arr[$q][$j];

				}
			}

	
			//A * f * AT
			for($j = 0;$j < self::$N;$j++ ) {
				$res[$i][$j] = 0;
				foreach ($af[$i] as $qt => $vt) {
					$res[$i][$j] += $vt * $at[$qt][$j];
				}
			}
		}

		
		return $res;
	}

	/**
	 * 返回矩阵的A
	 * @Author   RyanWu
	 * @DateTime 2018-02-28
	 * @param    int     $i 矩阵的行
	 * @param    int     $j 矩阵的列
	 */
	private static function A()
	{
		for ($i = 0;$i < self::$N; $i++ ) {
			$c = self::c($i);
			for($j = 0;$j < self::$N;$j++ ) {
				$cos = ($j + 0.5) * M_PI * $i/ self::$N;
				$res[$i][$j] = $c * cos($cos);	
			}
		}
		return $res;
	}

	/**
	 * 转置矩阵AT
	 * @Author   RyanWu
	 * @DateTime 2018-02-28
	 * @param    int     $i 矩阵的行
	 * @param    int     $j 矩阵的列
	 */
	private static function AT()
	{
		for ($i = 0;$i < self::$N; $i++ ) {
			$c = self::c($i);
			for($j = 0;$j < self::$N;$j++ ) {
				$cos = ($j + 0.5) * M_PI * $i/ self::$N;
				$res[$j][$i] = $c * cos($cos);	
			}
		}
		return $res;
	}

	/**
	 * 求出矩阵的系数c;
	 * @Author   RyanWu
	 * @DateTime 2018-02-28
	 * @param    int     $i 矩阵的行
	 * 
	 */
	private static function c($i)
	{
		if ($i == 0 ) {
			return sqrt(1/self::$N);
		} else {
			return sqrt(2/self::$N);
		}
	}
}