<?php
/**
 * 字段导入信息
 */
class FieldSql extends Model
{
	public function FieldSql()
	{
		$this->Model();
	}
	//文本
	public function textfield($dbname,$d)
	{
		$this->query('ALTER TABLE `'.$dbname.'` ADD `'.$d['name'].'` VARCHAR( 255 ) NOT NULL ;');
	}
	//整数文本
	public function integralfield($dbname,$d)
	{
		$this->query('ALTER TABLE `'.$dbname.'` ADD `'.$d['name'].'` INT NOT NULL;');
	}
	//文本域
	public function textarea($dbname,$d)
	{
		$this->query('ALTER TABLE `'.$dbname.'` ADD `'.$d['name'].'` TEXT NOT NULL ;');
	}
	//时间
	public function datefield($dbname,$d)
	{
		$this->query('ALTER TABLE `'.$dbname.'` ADD `'.$d['name'].'` VARCHAR( 20 ) NOT NULL ;');
	}
	//单选
	public function radiogroup($dbname,$d)
	{
		$array = array(
			'ALTER TABLE `'.$dbname.'` ADD `'.$d['name'].'` VARCHAR( 255 ) NOT NULL ;',
			'ALTER TABLE `'.$dbname.'` ADD `'.$d['name'].'_key` VARCHAR( 255 ) NOT NULL ;'
		);
		for($i=0;$i<count($array);$i++) $this->query($array[$i]);
	}
	//多选
	public function checkboxgroup($dbname,$d)
	{
		$array = array(
			'ALTER TABLE `'.$dbname.'` ADD `'.$d['name'].'` VARCHAR( 255 ) NOT NULL ;',
			'ALTER TABLE `'.$dbname.'` ADD `'.$d['name'].'_key` VARCHAR( 255 ) NOT NULL ;'
		);
		for($i=0;$i<count($array);$i++) $this->query($array[$i]);
	}
	//下拉菜单
	public function combo($dbname,$d)
	{
		$array = array(
			'ALTER TABLE `'.$dbname.'` ADD `'.$d['name'].'` VARCHAR( 255 ) NOT NULL ;',
			'ALTER TABLE `'.$dbname.'` ADD `'.$d['name'].'_key` VARCHAR( 255 ) NOT NULL ;'
		);
		for($i=0;$i<count($array);$i++) $this->query($array[$i]);
	}
	//单文件上传
	public function simpleupload($dbname,$d)
	{
		$array = array(
			'ALTER TABLE `'.$dbname.'` ADD `'.$d['name'].'` VARCHAR( 255 ) NOT NULL ;',
			'ALTER TABLE `'.$dbname.'` ADD `'.$d['name'].'_path` VARCHAR( 255 ) NOT NULL ;'
		);
		for($i=0;$i<count($array);$i++) $this->query($array[$i]);
	}
	//多文件上传
	public function fileupload($dbname,$d)
	{
		$array = array(
			'ALTER TABLE `'.$dbname.'` ADD `'.$d['name'].'` VARCHAR( 255 ) NOT NULL ;',
			'ALTER TABLE `'.$dbname.'` ADD `'.$d['name'].'_ids` VARCHAR( 255 ) NOT NULL ;'
		);
		for($i=0;$i<count($array);$i++) $this->query($array[$i]);
	}
	//ewebeditor编辑器
	public function ewebeditor($dbname,$d)
	{
		$this->query('ALTER TABLE `'.$dbname.'` ADD `'.$d['name'].'` TEXT NOT NULL ;');
	}
	//ck编辑器
	public function ckeditor($dbname,$d)
	{
		$this->query('ALTER TABLE `'.$dbname.'` ADD `'.$d['name'].'` TEXT NOT NULL ;');
	}
	//标识
	public function markfield($dbname,$d)
	{
		$array = array(
			'ALTER TABLE `'.$dbname.'` ADD `'.$d['name'].'` VARCHAR( 255 ) NOT NULL ;',
			'ALTER TABLE `'.$dbname.'` ADD `'.$d['name'].'_key` TINYINT NOT NULL ;'
		);
		for($i=0;$i<count($array);$i++) $this->query($array[$i]);
	}
	//关联字段
	public function relationfield($dbname,$d)
	{
		$array = array(
			'ALTER TABLE `'.$dbname.'` ADD `'.$d['name'].'` VARCHAR( 255 ) NOT NULL ;',
			'ALTER TABLE `'.$dbname.'` ADD `'.$d['name'].'_key` VARCHAR( 255 ) NOT NULL ;'
		);
		for($i=0;$i<count($array);$i++) $this->query($array[$i]);
	}
}
?>