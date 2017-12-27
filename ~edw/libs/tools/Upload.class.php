<?php
/**
 * 文件上传管理
 * @category    Edw
 * @package     Edw
 * @subpackage  Util.Upload
 * @author      Xujinzhang<xjz1688@163.com>
 * @version     1.2
 */

class Upload
{
	//不充许上传的文件
	private $notype = array("c","cpp","cgi","py","sh","exe","ini","cmd","bat","php","php3","php4","php5","jsp","java","asp","aspx");
	//文件资源
	private $file = "";
	//旧文件名
	public $oldname = "";
	//新的文件名
	private $newname = "";
	//文件大小 单位 B
	public $tfilesize = 0;
	//文件后缀名
	private $ext = "";
	//上传错误提示
	public $error = array();
	/**
	 * 构造函数
	 */
	public function Upload($tag)
	{
		$this->file = $_FILES[$tag];
		$this->simpleCheck($this->file['name'], $this->file['tmp_name']);
		$this->oldname = $this->file['name'];
		$this->tfilesize = $this->file['size'];
		$this->newname = "UP_". date('Ymdhis').mt_rand(0,30).".". $this->ext;
	}
	/**
	 * 文件检查
	 * @param string $name
	 * @param string $tmp_name
	 * @return 后缀
	 */
	private function simpleCheck($name,$tmp_name)
	{
		$pathinfo = pathinfo($name);
		$this->ext = strtolower($pathinfo['extension']);
		if(empty($this->ext)) array_push($this->error,'文件"'.$name.'"后缀名不能为空!');
		//检查文件格式是否正确
		if(in_array($this->ext, $this->notype)) array_push($this->error,'文件"'.$name.'"为不安全文件!');
		//检查文件是否非法提交
		if(!is_uploaded_file($tmp_name)) array_push($this->error,'不正确的上传文件'.$name.',请检查该文件是否已超过'.WEB_MAX_UPFILE.'.');
	}
	/**
	 * 上传文件
	 * @param string $dir //保存到asset那个文件夹 
	 */
	public function save($dir = '')
	{
		$dir = empty($dir)?'asset/default/':'asset/'.$dir.'/';
		mk_dir(WEB_ROOT.'/'.$dir);
		if(!empty($this->newname)){
			$newpath = $dir.$this->newname;
			if(!move_uploaded_file($this->file['tmp_name'], WEB_ROOT .'/'. $newpath))
				array_push($this->error,'无法上传'.$this->file['name'].',请检查该文件是否已超过'.WEB_MAX_UPFILE.'.');
			return array(
				'name'	=>	$newpath,
				'ext'	=>	$this->ext,
				'size'	=>	$this->tfilesize,
				'oldname'	=> $this->oldname
			);
		}else {
			return array();
		}
	}
	/**
	 * 返回错误信息
	 */
	public function geterror()
	{
		return join(",",$this->error);
	}
}

?>