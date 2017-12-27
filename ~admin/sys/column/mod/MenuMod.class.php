<?php
/**
 * 栏目管理
 */
class MenuMod extends Model
{
	public function MenuMod()
	{
		$this->Model();
	}
	public function getlist($pid,$user)
	{
		return $this->get_all('SELECT * FROM '.DB_MX_PRE.'menu WHERE parent_id="'.$pid.'" AND langtp="'.$user['langtp'].'" AND typeid IN(1,2) ORDER BY sort ASC');
	}
	public function getpmenu($pid)
	{
		$d = $this->get_row('SELECT path FROM '.DB_MX_PRE.'menu WHERE id="'.$pid.'"');
		if(empty($d['path'])){
			return '<a href="javascript:;" brurl="sys/column/?app.html" class="mx_ahref">栏目频道</a>';
		}else{
			$dd = $this->get_all('SELECT title,id FROM '.DB_MX_PRE.'menu WHERE id IN('.$d['path'].') ORDER BY grade ASC');
			$res = array('<a href="javascript:;" brurl="sys/column/?app.html" class="mx_ahref">栏目频道</a>');
			foreach($dd as $list){
				array_push($res,'<a href="javascript:;" brurl="sys/column/?app/pid/'.$list['id'].'.html" class="mx_ahref">'.$list['title'].'</a>');
			}
			return join(' > ',$res);
		}
	}
	/**
	 * 新增栏目
	 */
	public function add($user)
	{
		$_POST['langtp'] = $user['langtp']; //多站点
		if(empty($_POST['parent_id'])){
			$_POST['grade'] = 1;
		}else{
			$parent = $this->get_row('SELECT * FROM '.DB_MX_PRE.'menu WHERE id="'.$_POST['parent_id'].'"');
			$_POST['grade'] = $parent['grade']+1;
			$path = $parent['path'];
		}
		$items = $this->get_fields(DB_MX_PRE.'menu');
		$this->insert(DB_MX_PRE.'menu',$items);
		$insertid = $this->get_insert_id();
		//当组件实例存在时
		if(!empty($_POST['livsid'])){
			$livs = $this->get_row('SELECT apiurl FROM '.DB_MX_PRE.'applivs WHERE id="'.$_POST['livsid'].'"');
			$tytag = empty($_POST['livtyid'])?$insertid:$_POST['livtyid'];
			$_POST['admurl'] = str_replace('分类标识',$tytag,$livs['apiurl']);
			$_POST['path'] = empty($_POST['parent_id'])?'0,'.$insertid:$path.','.$insertid;
			$_POST['idser'] = ','.$_POST['path'].',';
			$this->update(DB_MX_PRE.'menu',array('path','idser','admurl'),'id="'.$insertid.'"');
		}else{
			$_POST['path'] = empty($_POST['parent_id'])?'0,'.$insertid:$path.','.$insertid;
			$_POST['idser'] = ','.$_POST['path'].',';
			$this->update(DB_MX_PRE.'menu',array('path','idser'),'id="'.$insertid.'"');
		}
		//更新结点数
		if(!empty($parent['id']))
			$this->update('UPDATE '.DB_MX_PRE.'menu SET sonum="'.($parent['sonum']+1).'" WHERE id="'.$parent['id'].'"');
	}
	/**
	 * 修改栏目信息
	 */
	public function edit($id)
	{
		//当组件实例存在时
		if($_POST['livsid']>0){
			$livs = $this->get_row('SELECT apiurl FROM '.DB_MX_PRE.'applivs WHERE id="'.$_POST['livsid'].'"');
			$tytag = empty($_POST['livtyid'])?$id:$_POST['livtyid'];
			$_POST['admurl'] = str_replace('分类标识',$tytag,$livs['apiurl']);
		}
		$this->update(DB_MX_PRE.'menu',array('title','sort','typeid','admurl','livsid','livtyid','frturl','crturl'),'id="'.$id.'"');
	}
	//删除目录
	public function menudel($path,$pid)
	{
		$this->delete(DB_MX_PRE.'menu','path LIKE "'.$path.'%"');
		//更新下级栏目个数
		$sonum = $this->get_num('SELECT id FROM '.DB_MX_PRE.'menu WHERE parent_id="'.$pid.'"');
		$sonum = $sonum<1?0:$sonum;
		$this->update('UPDATE '.DB_MX_PRE.'menu SET sonum="'.$sonum.'" WHERE id="'.$pid.'"');
	}
	/**
	 * 获取信息
	 */
	public function getmenuinfo($id)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'menu WHERE id="'.$id.'"');
	}
	/**
	 * 读取实例
	 */
	public function getapplivs($user)
	{
		return $this->get_all('SELECT * FROM '.DB_MX_PRE.'applivs WHERE langtp="'.$user['langtp'].'" ORDER BY id DESC');
	}
}
?>