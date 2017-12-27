<?php
/**
 * 文件上传
 */
class FileUploadMod extends Model
{
	public function FileUploadMod()
	{
		$this->Model();
	}
	//读取图片处理信息
	public function getpicinfo($id)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'fieldupload WHERE id="'.$id.'"');
	}
}
?>