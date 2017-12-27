<?php
/**
 * 菜单管理
 */
class MancolsMod extends Model
{
	public function MancolsMod()
	{
		$this->Model();
	}
	public function getlist($pid,$user)
	{
		return $this->get_all('SELECT * FROM '.DB_MX_PRE.'menu WHERE parent_id="'.$pid.'" AND typeid=1 AND langtp="'.$user['langtp'].'" ORDER BY sort ASC');
	}
	public function getpmenu($pid)
	{
		$d = $this->get_row('SELECT path FROM '.DB_MX_PRE.'menu WHERE id="'.$pid.'"');
		if(empty($d['path'])){
			return '<a class="mx_ahref" href="javascript:;" brurl="sys/mancols/?app.html">/</a>';
		}else{
			$dd = $this->get_all('SELECT title,id FROM '.DB_MX_PRE.'menu WHERE id IN('.$d['path'].') AND typeid=1 ORDER BY grade ASC');
			$res = array('<a class="mx_ahref" href="javascript:;" brurl="sys/mancols/?app.html">/</a>');
			foreach($dd as $list){
				array_push($res,'<a class="mx_ahref" href="javascript:;" brurl="sys/mancols/?app/pid/'.$list['id'].'.html">'.$list['title'].'</a>');
			}
			return join(' > ',$res);
		}
	}
	/**
	 * 读取使用同一组件的相关菜单
	 * @param int $mid
	 */
	public function getmenutplurl($mid)
	{
		return $this->get_all('SELECT id,title FROM '.DB_MX_PRE.'menu WHERE livsid="'.$mid.'"');
	}
	/**
	 * 新增频道
	 */
	public function add($user)
	{
		$_POST['langtp'] = $user['langtp'];
		if(empty($_POST['parent_id'])){
			$_POST['grade'] = 1;
		}else{
			$parent = $this->get_row('SELECT * FROM '.DB_MX_PRE.'menu WHERE id="'.$_POST['parent_id'].'"');
			$_POST['grade'] = $parent['grade']+1;
			$path = $parent['path'];
		}
		//如果相关模板规则存在，则直接读取写入到当前菜单
		if(!empty($_POST['rexmid'])){
			$orexmid = $this->get_row('SELECT frturl,crturl FROM '.DB_MX_PRE.'menu WHERE id="'.$_POST['rexmid'].'"');
			$_POST['frturl'] = $orexmid['frturl'];
			$_POST['crturl'] = $orexmid['crturl'];
		}
		$items = $this->get_fields(DB_MX_PRE.'menu');
		$this->insert(DB_MX_PRE.'menu',$items);
		$insertid = $this->get_insert_id();
		$_POST['path'] = empty($_POST['parent_id'])?'0,'.$insertid:$path.','.$insertid;
		$_POST['idser'] = ','.$_POST['path'].',';
		//根据组件生成连接
		$livs = $this->get_row('SELECT apiurl FROM '.DB_MX_PRE.'applivs WHERE id="'.$_POST['livsid'].'"');
		$_POST['admurl'] = str_replace('分类标识',$insertid,$livs['apiurl']);
		$this->update(DB_MX_PRE.'menu',array('path','idser','admurl'),'id="'.$insertid.'"');
		//更新结点数
		if(!empty($parent['id']))
			$this->update('UPDATE '.DB_MX_PRE.'menu SET sonum="'.($parent['sonum']+1).'" WHERE id="'.$parent['id'].'"');
		//给当前用户添加权限
		$users = $this->get_row('SELECT id,powids FROM '.DB_MX_PRE.'mgroup WHERE id="'.$user['gid'].'"');
		$oldpw = explode(',',$users['powids'],$parent['id']);
		array_push($oldpw,$insertid);
		$newoldpw = array_unique($oldpw);
		$_POST['powids'] = join(',',$newoldpw);
		$this->update(DB_MX_PRE.'mgroup',array('powids'),'id="'.$users['id'].'"');
	}
	/**
	 * 修改菜单信息
	 */
	public function edit($id)
	{
		//如果相关模板规则存在，则直接读取写入到当前菜单
		if(!empty($_POST['rexmid'])){
			$orexmid = $this->get_row('SELECT frturl,crturl FROM '.DB_MX_PRE.'menu WHERE id="'.$_POST['rexmid'].'"');
			$_POST['frturl'] = $orexmid['frturl'];
			$_POST['crturl'] = $orexmid['crturl'];
		}
		//根据组件生成连接
		$livs = $this->get_row('SELECT apiurl FROM '.DB_MX_PRE.'applivs WHERE id="'.$_POST['livsid'].'"');
		$_POST['admurl'] = str_replace('分类标识',$id,$livs['apiurl']);
		$this->update(DB_MX_PRE.'menu',array('title','sort','livsid','admurl','frturl','crturl'),'id="'.$id.'"');
	}
	//删除目录
	public function menudel($path,$pid)
	{
		$this->delete(DB_MX_PRE.'menu','path LIKE "'.$path.'%"');
		//更新下级菜单个数
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
	public function getueditadd($user)
	{
		return $this->get_all('SELECT * FROM '.DB_MX_PRE.'applivs WHERE uaddedit=1 AND langtp="'.$user['langtp'].'"');
	}
}
?>