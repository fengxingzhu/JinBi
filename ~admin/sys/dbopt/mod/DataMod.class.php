<?php
/**
 * 数据库备份还原
 */
class DataMod extends Model
{
	public function DataMod()
	{
		$this->Model();
	}
	//获得所有表单
	public function gettableall()
	{
		return $this->get_tables();
	}
	//显示创建表单结构
	public function gettablecreate($tn)
	{
		$d = $this->get_row('SHOW CREATE TABLE '.$tn.'');
		return $d['Create Table'];
	}
	//得到表单数据
	public function getdatas($tn)
	{
		return $this->get_all('SELECT * FROM '.$tn.'');
	}
	//得到含ID字段列表
	public function getfieldids($tn)
	{
		$fields = mysql_list_fields(Model::$dbname, $tn, Model::$db_link);
		$columns = mysql_num_fields($fields);
		$temp = array();
		for ($i=0;$i<$columns; $i++) {
			$fns = mysql_field_name($fields,$i);
			array_push($temp,"`".$fns."`");
		}
		return $temp;
	}
	//运行SQL语句
	public function dosqlinfo($sql)
	{
		$esql = explode(";",$sql);
		for($i=0;$i<count($esql);$i++){
			$sqltemp = str_replace("\r","",$esql[$i]);
			$sqltemp = str_replace("\n","",$sqltemp);
			if(!empty($sqltemp)) $this->query($sqltemp);
		}
	}
}
?>