<?php
/**
 * 用户组
 */
class UgroupAct extends Action
{
	private $mod = '';
	private $startmstr = '';
	private $UID = '';
	private $userinfo = '';
	public function UgroupAct()
	{
		$this->UID = Cache::session_get("IMUSER_UID");
		$this->mod = $this->M('Ugroup');
		$this->userinfo = Cache::session_get("MXUSER_INFO");
	}
	//获得分组信息
	public function getglist()
	{
		$d = $this->mod->getgroups($this->userinfo);
		$this->assign('data',$d);
	}
	//添加分组
	public function add()
	{
		if(empty($_POST['powids'])){
			echo json_encode(array('type'=>'msg','msg'=>'请选择栏目列表!'));
			die();
		}
		$this->mod->add($this->UID);
		echo json_encode(array('type'=>'ajaxcontent','url'=>'sys/ugroup/?app.html'));
	}
	//获得单条信息
	public function getinfo()
	{
		$d = $this->mod->getinfo($_GET['id']);
		$this->assign('info',$d);
		$this->assign('data',json_encode($d));
	}
	//修改分组信息
	public function edit()
	{
		if(empty($_POST['powids'])){
			echo json_encode(array('type'=>'msg','msg'=>'请选择栏目列表!'));
			die();
		}
		$this->mod->edit($_GET['id']);
		echo json_encode(array('type'=>'ajaxcontent','url'=>'sys/ugroup/?app.html'));
	}
	//删除分组
	public function del()
	{
		$this->mod->del($_GET['id']);
	}
	//获取栏目信息
	public function getcol()
	{
		$ids = array(); $optpw = array();
		if(!empty($_GET['id'])){
			$d = $this->mod->getinfo($_GET['id']);
			$ids = explode(',',$d['powids']);
			$optpw = json_decode($d['optools'],true);
		}
		$startm = $this->mod->getallcol($this->userinfo);
		$this->recursionmenu($startm,0,$ids,$optpw);
		$this->assign('__TREELIST',$this->startmstr);
	}
	//递归读取菜单
	public function recursionmenu($m,$pid = 0,$ids,$optpw)
	{
		foreach ($m as $key=>$val){
			if($val['parent_id'] == $pid){
				if(!empty($ids)) $checked = in_array($val['id'],$ids)?' checked':'';
				$synstr = '';
				if($val['typeid']!=0){
					//读取审核级别
					$g = $this->mod->getsyngrade($val['livsid']);
					if($g>0){
						$d = $this->mod->getinfo($_GET['id']);
						$optvar = explode(',',$d['syninfo']);
						$syngw = array(0=>'信息提交',1=>'一级审核',2=>'二级审核',3=>'三级审核',4=>'四级审核');
						$synstr = '<select name="syngrade" class="noauto">';
						for($k=0;$k<=$g;$k++){
							$selopt = $val['id'].':'.$k;
							$synstr .= in_array($selopt,$optvar)?'<option value="'.$k.'" selected="selected">'.$syngw[$k].'</option>':'<option value="'.$k.'">'.$syngw[$k].'</option>';
						}
						$synstr .= '</select>';
					}
				}
				//判断该发布信息是不是列表
				$optpwstr = '';
				if($val['livsid']>0){
					$dirtype = $this->mod->getpubtypes($val['livsid']);
					//操作权限
					$optarray = array();
					if($dirtype['cfg_add_key']==1)
						$optarray['add'] = '新增';
					if($dirtype['cfg_edit_key']==1)
						$optarray['edit'] = '修改';
					if($dirtype['cfg_del_key']==1)
						$optarray['del'] = '删除';
					if($dirtype['cfg_excelin_key']==1)
						$optarray['excelin'] = 'excel导入';
					if($dirtype['cfg_excelout_key']==1)
						$optarray['excelout'] = 'excel导出';
					
					if($dirtype['dir']=='grid'){//属于列表
						$optstrarray = array();
						$stroptchk = isset($optpw[$val['id']])?$optpw[$val['id']]:'';
						$arroptchk = explode(',',$stroptchk);
						foreach($optarray as $k=>$v){
							if(empty($_GET['id'])){
								$optvval = '√';
							}else{
								$optvval = in_array($k, $arroptchk)?'√':'';
							}
							$optstrarray[] = '<span class="optools"><span class="icon" mkey="'.$k.'">'.$optvval.'</span>'.$v.'</span>';
						}
						$optpwstr .= '<span menuid="'.$val['id'].'">【'.join('', $optstrarray).'】</span>';
					}
				}
				//生成树
				if($val['sonum'] == 0){ //无子节点
					$this->startmstr .= '<li><input type="checkbox" name="ggroups" value="'.$val['id'].'" align="absmiddle"'.$checked.' /><span class="file"><a href="javascript:;">'.$val['title'].'</a>'.$synstr.$optpwstr.'</span></li>';
					unset($m[$key]);
					$this->recursionmenu($m, $val['id'],$ids,$optpw);
				}else { //有子节点
					$this->startmstr .= '
					<li class="open">
						<input type="checkbox" name="ggroups" value="'.$val['id'].'" align="absmiddle"'.$checked.' />
						<span class="folder"><a href="javascript:;">'.$val['title'].'</a>'.$synstr.$optpwstr.'</span>
						<ul>';
					unset($m[$key]);
					$this->recursionmenu($m, $val['id'],$ids,$optpw);
					$this->startmstr .= '
						</ul>
					</li>';
				}
			}
		}
	}
}
?>