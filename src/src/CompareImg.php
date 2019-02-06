<?php
namespace RainSunshineCloud\src;

/**
 * 获取压缩大小的图片
 */
class CompareImg
{
	const DIRNAME = './';
	protected static $errs = [];
	protected static $size = [];
	protected static $new_sizes = [];
	protected static $res_des = null;
	protected static $obj = null;
	
	/**
	 * 获取尺寸
	 * @param  [type] $path [description]
	 * @return [type]       [description]
	 */
	protected static function getSize($path)
	{
		
		if ($arr = getimagesize ($path)) {
			return self::$size = ['x'=>$arr[0],'y'=>$arr[1],'type'=>$arr['mime']];
		} else {
			return self::$errs = [
				'msg'=>'无法获取尺寸',
				'code'=>1
			];
		}
	}

	/**
	 * 压缩图片
	 * @Author   RyanWu
	 * @DateTime 2018-02-27
	 * @param    str        $path   要压缩的图片路径
	 * @param    mix    $new_size 压缩比例(float)，或压缩尺寸(array)
	 * @param    boolean    $isBrow 是否在浏览器中显示
	 */
	public static  function getCompareImg($path,$new_size=['x'=>50,'y'=>50])
	{
		//获取尺寸
		self::getSize($path);
		//判断压缩方式
		if (is_float($new_size)) {
			self::$new_sizes['x'] = $new_size * self::$size['x'];
			self::$new_sizes['y'] = $new_size * self::$size['y'];
		} else {
			self::$new_sizes = $new_size;
		}
		//创建画布
		self::$res_des = imagecreatetruecolor($new_size['x'], $new_size['y']);
		//获取资源
		$res_ori = self::getImg($path);

		imagecopyresampled(self::$res_des,$res_ori,0,0,0,0,self::$new_sizes['x'],self::$new_sizes['y'],self::$size['x'],self::$size['y']);
		
		return self::$obj = new self();
	}

	/**
	 * 获取灰度值
	 * @Author   RyanWu
	 * @DateTime 2018-02-27
	 */
	public function GetGray ()
	{
		for ( $x = 0;$x < self::$new_sizes['x'];$x++ ) {//循环x轴
			for ( $y = 0;$y < self::$new_sizes['y'];$y++ ) {//循环y轴
				$rgb = imagecolorat (self::$res_des,$x,$y);
				$r = ($rgb >> 16) & 0xFF;
				$g = ($rgb >> 8) & 0xFF;
				$b = $rgb & 0xFF;
				$gray[$x][$y] = round(($r + $g + $b)/3,0);

			}
		}
		return $gray;
	}

	/**
	 * @Author   RyanWu
	 * @DateTime 2018-02-27
	 * @return   [type]     [description]
	 */
	public  function export ($path=null)
	{
		if ($path == null) {
			header('Content-type: image/jpg');
			imagejpeg(self::$res_des);
		} else {
			imagejpeg(self::$res_des,self::DIRNAME.uniqid().'.jpg');
		}
	}
	
	/**
	 * @Author   RyanWu
	 * @DateTime 2018-02-27
	 * @param    str     $path 获取路径
	 * @return   resource 图片资源
	 */
	protected static function getImg($path)
	{
		switch (self::$size['type']) {
			case 'image/gif':
				return imagecreatefromgif($path);
			case 'image/png':
				return imagecreatefrompng($path);
			case 'image/jpeg':
				return imagecreatefromjpeg($path);
			default: 
				return self::$errs = [
					'msg'=>'无法获取该类型的图片',
					'code'=>1
				];
		}
	}
}
