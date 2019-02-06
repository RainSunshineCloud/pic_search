<?php
namespace RainSunshineCloud;

use RainSunshineCloud\src\CompareImg;
use RainSunshineCloud\src\DCT;
use RainSunshineCloud\src\PHash;

class PicSearch
{
	protected $pic_arr_hash = [];

	public function __construct($pic_path,$compress_size = ['x'=>'32','y'=>'32'])
	{
		$this->compress_size = $compress_size;
		$arr = CompareImg::getCompareImg($pic_path,$this->compress_size)->getGray();
		$arr = DCT::getDCT($arr);
		$this->pic_arr_hash = PHash::DCTHash($arr);
	}

	/**
	 * 判断在哪
	 * @param  array  $file_path_arr [description]
	 * @return [type]                [description]
	 */
	public function in(array $file_path_arr,float $avg_limit = 1)
	{
		$sort = [];
		foreach ($file_path_arr as $file) {
			$arr = CompareImg::getCompareImg($file,$this->compress_size)->getGray();
			$arr = DCT::getDCT($arr);
			$arr = PHash::DCTHash($arr);
			if ( abs($arr[0] - $this->pic_arr_hash[0]) < $avg_limit) {
				$tmp = [
					'distance' => getDistance($this->pic_arr_hash[1],$arr[1]),
					'file' => $file
				];
				$sort[] = $tmp;
			} 
		}

		return $sort;
	}
}
