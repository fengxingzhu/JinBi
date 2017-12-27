<?php
/**
 * 数据补丁 __UGrid_为类名前缀mx_demo为表名
 */
class __UGrid_mx_demo
{
	/**
	 * 
	 * @param object $mod 数据层对象
	 * @param string $dbname 表名
	 * @param int $tp 分类ID
	 * @param string $ids 多个ID以,分隔
	 * @param string $etp 方法分类 add为添加 edit为修改
	 */
	public function run($mod,$dbname,$tp,$ids,$etp)
	{
		$eids = explode(',',$ids);//分割多信息ID
		$elen = count($eids);//个数
		for($i=0;$i<$elen;$i++){
			$id = $eids[$i]; //信息id
			//处理部分
		}
	}
}
?>