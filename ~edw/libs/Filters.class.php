<?php
/**
 * 默认充许上传的文件后缀
 */
class Filters
{
	public static function data()
	{
		return array(
			array('ftype'=>'Image files','exts'=>'jpg,gif,png,bmp','sort'=>0),
			array('ftype'=>'Zip files','exts'=>'zip','sort'=>1),
			array('ftype'=>'RAR files','exts'=>'rar','sort'=>2),
			array('ftype'=>'OFFICE files','exts'=>'doc,docx,xls,xlsx,ppt,pptx','sort'=>3)
		);
	}
}
?>