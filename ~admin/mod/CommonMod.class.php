<?php
/**
 * 公共处理
 */
class CommonMod extends Model
{
	public function CommonMod()
	{
		$this->Model();
	}
	//手动排序
	public function handsort($ids,$vals,$dbname,$sortfd)
	{
		$eids = explode(',',$ids);
		$evals = explode(',',$vals);
		for($i=0;$i<count($eids);$i++){
			if(!empty($eids[$i])){
				$this->update('UPDATE '.$dbname.' SET '.$sortfd.'="'.intval($evals[$i]).'" WHERE id="'.$eids[$i].'"');
			}
		}
	}
	//批量删除
	public function moredelete($ids,$dbname)
	{
		$this->delete($dbname,'id IN('.$ids.')');
	}
}
?>