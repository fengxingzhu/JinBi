<?php
/**
 * 验证码
 */
class Verify
{
	/**
	 * 输出验证码
	 * @param int $width 宽
	 * @param int $height 高
	 * @param string $n sesseion名称
	 * @param int $m 验证码类型
	 */
	public function out($width,$height,$n,$m = 1)
	{
		session_start();
		ob_clean();
		header("Content-Type:image/png");
		$rands = '';
		$rands = mt_rand(1000,9999);
		$_SESSION[$n] = $rands;
		if($m == 1) $this->firstver($width,$height,$rands);
		if($m == 2) $this->secondver($width,$height,$rands);
	}
	/**
	 * 第一种验证码
	 *
	 * @param int $width
	 * @param int $height
	 * @param string $rands
	 */
	private function firstver($width,$height,$rands)
	{
		$im = imagecreate($width,$height); 
		$black = ImageColorAllocate($im, 0,0,0); 
		$white = ImageColorAllocate($im, 255,255,255); 
		$gray = ImageColorAllocate($im, 200,200,200); 
		imagefill($im,$width,$height,$gray); 
		imagestring($im, 5, 10, 3, $rands, $white); 
		$randcolor = '';
		for($i=0;$i<200;$i++) //加入干扰象素 
		{ 
			$randcolor = ImageColorallocate($im,rand(0,255),rand(0,255),rand(0,255));
			imagesetpixel($im, rand()%70 , rand()%30 , $randcolor); 
		} 
		ImagePNG($im); 
		ImageDestroy($im);
	}
	/**
	 * 第二种验证码
	 *
	 * @param int $width
	 * @param int $height
	 * @param string $rands
	 */
	private function secondver($width,$height,$rands)
	{
		$im=imagecreate($width,$height); 
		//背景色 
		$back=imagecolorallocate($im,0xFF,0xFF,0xFF); 
		//模糊点颜色 
		$pix=imagecolorallocate($im,187,230,247); 
		//字体色 
		$font=imagecolorallocate($im,41,163,238); 
		//绘模糊作用的点 
		for($i=0;$i <1000;$i++) imagesetpixel($im,mt_rand(0,$width),mt_rand(0,$height),$pix); 
		imagestring($im, 5, 7, 5,$rands, $font); 
		imagerectangle($im,0,0,$width-1,$height-1,$font); 
		imagepng($im); 
		imagedestroy($im);
	}
}
?>