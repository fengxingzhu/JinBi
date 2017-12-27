<?php
/**
 * 版块管理
 */
class BlockManMod extends Model
{
	public function BlockManMod()
	{
		$this->Model();
	}
	/**
	 * 读取对应专题风格版块
	 */
	public function getblocks($pid)
	{
		$tp = $this->get_row('SELECT sname_key FROM '.DB_MX_PRE.'mod_topic WHERE id="'.$pid.'"');
		return $this->get_all('SELECT * FROM '.DB_MX_PRE.'mod_blocks WHERE stid="'.$tp['sname_key'].'" ORDER BY sort ASC');
	}
	/**
	 * 读取版块详情
	 * @param int $id
	 */
	public function getblockinfo($id)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'mod_blocks WHERE id="'.$id.'"');
	}
	/**
	 * 读取专题信息
	 * @param int $id
	 */
	public function gettopic($id)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'mod_topic WHERE id="'.$id.'"');
	}
	/**
	 * 修改专题结果集
	 * @param int $id
	 * @param array $data
	 */
	public function edittopicdata($id,$data)
	{
		$_POST['data'] = serialize($data);
		$this->update(DB_MX_PRE.'mod_topic',array('data'),'id="'.$id.'"');
	}
}
?>