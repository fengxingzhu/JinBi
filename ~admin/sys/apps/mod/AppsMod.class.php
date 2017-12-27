<?php
/**
 * 应用列表
 */
class AppsMod extends Model
{
	public function AppsMod()
	{
		$this->Model();
	}
	//检查程序名是否存在
	public function isproname($n)
	{
		return $this->get_num('SELECT id FROM '.DB_MX_PRE.'applivs WHERE proname="'.$n.'"');
	}
	//读取分组分类信息
	public function getgroups($gid)
	{
		if($_POST['mtype']=='user'){
			return array(
				'id'	=>	0,
				'name'	=>	'系统分类',
				'typeid'=>	0,
				'gname'	=>	'系统分类',
				'gdir'	=>	'mx'
			);
		}else{
			return $this->get_row('SELECT * FROM '.DB_MX_PRE.'appgroups WHERE id="'.$gid.'"');
		}
	}
	//创建实例
	public function add($user)
	{
		$_POST['uid'] = $user['id'];
		$_POST['name'] = $user['name'];
		$_POST['langtp'] = $user['langtp'];//多语言
		//数据库表名
		$_POST['dbtname'] = $_POST['gdir'].'_'.$_POST['proname'];
		$items = $this->get_fields(DB_MX_PRE.'applivs');
		$this->insert(DB_MX_PRE.'applivs',$items);
		return $this->get_insert_id();
	}
	//表单属性
	public function formatr($appid,$data)
	{
		$_POST['appid'] = $appid;
		$_POST['colspan'] = $data['colspan'];
		$_POST['width'] = $data['width'];
		$this->insert(DB_MX_PRE.'forms',array('appid','colspan','width'));
	}
	//填充字段信息
	public function fielddata($appid,$data)
	{
		$_POST['appid'] = $appid;
		$items = $this->get_fields(DB_MX_PRE.'fields');
		foreach ($data as $list){
			$oldfid = $list['id'];
			for($i=0;$i<count($items);$i++){
				$key = $items[$i];
				if($key!='id' && $key!='appid')
					$_POST[$key] = $list[$key];
			}
			$this->insert(DB_MX_PRE.'fields',$items);
			$_POST['fieldid'] = $this->get_insert_id();//字段ID
			//如果是单选 多选 下拉 类型时同时复制对应的数据选项
			if(in_array($_POST['xtype'], array('radiogroup','checkboxgroup','combo'))){
				$fdata = $this->get_all('SELECT * FROM '.DB_MX_PRE.'fieldatas WHERE fieldid="'.$oldfid.'"');
				$fitem = $this->get_fields(DB_MX_PRE.'fieldatas');
				foreach ($fdata as $fv){
					for($kv=0;$kv<count($fitem);$kv++){
						$fkey = $fitem[$kv];
						if($fkey!='fieldid')
							$_POST[$fkey] = $fv[$fkey];
					}
					$this->insert(DB_MX_PRE.'fieldatas',$fitem);
				}
			}
		}
	}
}
?>