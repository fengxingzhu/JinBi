<?php
/**
 * 站点管理
 */
class DataMod extends Model
{
	public function DataMod()
	{
		$this->Model();
	}
	//判断用户名是否重复
	public function getuseris($user)
	{
		return $this->get_num('SELECT * FROM '.DB_MX_PRE.'user WHERE username="'.$user.'"');
	}
	//写入超管账号
	public function addspuer()
	{
		$_POST['pwgrade'] = 1;//超管账号
		$_POST['password'] = md5('123456'); //密码
		$_POST['name'] = $_POST['webname'].'管理员';
		$_POST['langtp'] = $_POST['tag'];
		$items = $this->get_fields(DB_MX_PRE.'user',array('cdate'));
		$this->insert(DB_MX_PRE.'user',$items);
	}
	//删除超管账号
	public function deluser($tag)
	{
		$this->delete(DB_MX_PRE.'user','langtp="'.$tag.'"');
	}
	//写入新的菜单
	public function menuadd($user)
	{
		$_POST['langtp'] = $_POST['tag'];
		$data = $this->get_all('SELECT * FROM '.DB_MX_PRE.'menu WHERE typeid=0 AND langtp="'.$user['langtp'].'"');
		//查找当前数据库最后的ID
		$maxid = $this->get_row('SELECT MAX(id) AS maxid FROM '.DB_MX_PRE.'menu');
		$distanid = $maxid['maxid']+10;
		foreach($data as $list){
			$_POST['id'] = $list['id']+$distanid; //新的ID
			$_POST['title'] = $list['title']; //名称
			$_POST['parent_id'] = empty($list['parent_id'])?$list['parent_id']:($list['parent_id']+$distanid); //父级ID
			$_POST['grade'] = $list['grade'];
			//path 
			$epath = explode(',',$list['path']);
			$tempids = array();
			for($k=0;$k<count($epath);$k++){
				$val = empty($epath[$k])?$epath[$k]:($epath[$k]+$distanid);
				array_push($tempids,$val);
			}
			$_POST['path'] = join(',',$tempids);
			//idser 
			$eidser = explode(',',$list['idser']);
			$tempidstr = array();
			for($k=0;$k<count($eidser);$k++){
				$val = empty($eidser[$k])?$eidser[$k]:($eidser[$k]+$distanid);
				array_push($tempidstr,$val);
			}
			$_POST['idser'] = join(',',$tempidstr);
			$_POST['sort'] = $list['sort'];
			$_POST['typeid'] = $list['typeid'];
			$_POST['livsid'] = $list['livsid'];
			$_POST['admurl'] = $list['admurl'];
			$_POST['sonum'] = $list['sonum'];
			$_POST['mtypeone'] = $list['mtypeone'];
			$this->insert(DB_MX_PRE.'menu',array('id','title','parent_id','grade','path','idser','sort','typeid','livsid','admurl','sonum','langtp','mtypeone'));
		}
	}
	//删除菜单
	public function delmenus($tag)
	{
		$this->delete(DB_MX_PRE.'menu','langtp="'.$tag.'"');
	}
}
?>