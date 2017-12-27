<?php
/**
 * 表单处理
 */
class FormAct extends Action
{
	private $mod = '';
	private $conf = array();
	private $tp = '';
	private $livsallarray = array();
	private $rexlivid = ''; //关联实例ID
	private $rexpid = ''; //关联信息ID，即父ID
	private $rexurlsuf = ''; //关联信息URL
	public function FormAct()
	{
		$this->mod = $this->M('Form');
		$this->conf = $this->mod->getlivs($_GET['ag']);
		$this->assign('CONFINI',$this->conf);
		$this->tp = $_GET['tp'];
		$this->assign('TP',$this->tp);
		$this->rexlivid = $_GET['rexlivid'];
		$this->assign('REXLIVID',$this->rexlivid);
		$this->rexpid = $_GET['rexpid'];
		$this->assign('REXPID',$this->rexpid);
		if(!empty($this->rexlivid) && !empty($this->rexpid)){//连接后缀
			$this->rexurlsuf = '/rexlivid/'.$this->rexlivid.'/rexpid/'.$this->rexpid;
			$this->assign('TP',$this->tp.$this->rexurlsuf);
			//关联实例信息
			$rexname = $this->mod->get_rexlivfdname($this->conf['id'],$this->rexlivid,$this->rexpid);
			$this->assign('REXTITLE',' > '.$rexname);
		}
	}
	//得到form属性
	public function getformattr()
	{
		$formattr = $this->mod->getformattr($this->conf['id']);
		$formattr['rownum'] = empty($formattr['rownum'])?10:$formattr['rownum'];
		$this->assign('formattr',$formattr);
	}
	//获取fieldplusjs
	public function fieldplusjs()
	{
		$formjs = $this->mod->fieldplusjs($this->conf['id']);
		$d = array();
		foreach($formjs as $l){
			array_push($d, '<script type="text/javascript" src="fieldplus/'.$l['fdplusfn'].'.js"></script>');
		}
		$this->assign('FORMJS',join('',$d));
	}
	//得到表单
	public function getform()
	{
		$fields = $this->mod->getfdlist($this->conf['id'],1);
		$formattr = $this->mod->getformattr($this->conf['id']);
		$fstr = '';
		$colwidth = floor($formattr['width']/$formattr['colspan']);
		$colnum = 0;
		$dir = dirname(dirname(dirname(dirname(__FILE__))));
		$dir = str_replace('\\','/',$dir);
		require_once $dir.'/sys/fields/do/FieldFormTpl.class.php';
		$tpl = new FieldFormTpl();
		//如果tp为all时表现显示左侧分类
		if($this->tp=='all'){
			$fstr .= '<tr>
			<td width="'.$formattr['width'].'" colspan="'.$formattr['colspan'].'">
			<label text="栏目分类">栏目分类</label>
			<div class="datalist" name="__alltnames[]" col="3" dataType="Group"  itip="请选择栏目分类">';
			$menus = $this->getlivemens($this->conf['id']);
			foreach($menus as $tk){
				if($tk['id']!=$_GET['__mid']) //过滤自已
					$fstr .= '<span><input class="groupdata" name="__alltnames[]" type="checkbox" value="'.$tk['title'].'" keyid="'.$tk['id'].'"/><em>'.$this->mod->getmenuname($tk['path']).'</em></span>';
			}
			$fstr .= '</div>
			<input name="__alltname" type="hidden" value="" />
			<input name="__alltname_key" type="hidden" value="" />
			<input name="__allapp_ids" type="hidden" value="" />
			</td>
			</tr>';
		}
		$isedit = isset($_GET['id'])?true:false; //是否是修改表单
		foreach ($fields as $kfd){
			//读取关联实例字段
			$rexlivfds = $this->mod->getrexlivfds($kfd,$this->rexlivid);
			if($rexlivfds){
				//读取该关联字段的关联信息
				$rexdata = $this->mod->getrexdata($kfd,$this->rexpid);
				$fstr .= $colnum%$formattr['colspan']==0?'</tr><tr>':'';
				$fstr .= '<td width="'.($colwidth*$kfd['colspan']).'" colspan="'.$kfd['colspan'].'" rowspan="'.$kfd['rowspan'].'" style="display:none;">';
				$fstr .= '<input type="hidden" name="'.$kfd['name'].'" value="'.$rexdata.'" />';
				$fstr .= '<input type="hidden" name="'.$kfd['name'].'_key" value="'.$this->rexpid.'" />';
				$fstr .= '</td>';
			}else{
				//如果存在条件隐藏
				$display = '';
				if($kfd['eqtypeval']!=''){
					$aeqval = explode(',',$kfd['eqtypeval']);
					$display = in_array($this->tp,$aeqval)?' style="display:none;"':'';
				}
				$fstr .= $colnum%$formattr['colspan']==0?'</tr><tr>':'';
				$fstr .= '<td width="'.($colwidth*$kfd['colspan']).'" colspan="'.$kfd['colspan'].'" rowspan="'.$kfd['rowspan'].'"'.$display.'>';
				$fstr .= $tpl->{$kfd['xtype']}($kfd,$isedit);
				$fstr .= '</td>';
			}
			$colnum += $kfd['colspan'];
		}
		//得到隐藏表单
		$fieldisplayno = $this->mod->getfdlist($this->conf['id'],0);
		$nodisplayarr = array();
		foreach ($fieldisplayno as $nolist){
			if($nolist['xtype']=='datefield'){
				$ptype = array('yyyy','MM','dd','HH','mm','ss');
				$ctype = array('Y','m','d','H','i','s');
				$format = str_replace($ptype,$ctype,$nolist['datefmt']);
				$val = $nolist['defval']=='NOW'?date($format):'';
				array_push($nodisplayarr,'<input type="hidden" name="'.$nolist['name'].'" value="'.$val.'" />');
			}else{
				array_push($nodisplayarr,'<input type="hidden" name="'.$nolist['name'].'" value="'.$nolist['defval'].'" />');
			}
		}
		$this->assign('FIELDPANEL',$fstr);
		$this->assign('FIELDSETWIDTH',$formattr['width']);
		$this->assign('FIELDCOLSPAN',$formattr['colspan']);
		$this->assign('FIELDNODISPLAY',join("",$nodisplayarr));
	}
	//获取对应实例的菜单
	private function getlivemens($livsid)
	{
		$allmenus = $this->mod->getallmenu();//所有菜单
		$liveids = $this->mod->getalltypesids($livsid); //所有的一级分类
		$liveidslen = count($liveids);
		for($i=0;$i<$liveidslen;$i++){
			$this->recursionmenu($allmenus,$liveids[$i],$livsid);
		}
		return $this->livsallarray;
	}
	//递归读取实例菜单
	private function recursionmenu($m,$pid = 0,$livsid)
	{
		foreach ($m as $key=>$val){
			if($val['parent_id'] == $pid){
				if($val['livsid']==$livsid){
					array_push($this->livsallarray,array('id'=>$val['id'],'title'=>$val['title'],'path'=>$val['path']));
				}
				unset($m[$key]);
				$this->recursionmenu($m, $val['id'],$livsid);
			}
		}
	}
	//得到搜索表单
	public function getsearchform()
	{
		$fields = $this->mod->getsearchfdlist($this->conf['id']);
		$formattr = $this->mod->getformattr($this->conf['id']);
		$fstr = '';
		$dir = dirname(dirname(dirname(dirname(__FILE__))));
		$dir = str_replace('\\','/',$dir);
		require_once $dir.'/sys/fields/do/FieldSearchTpl.class.php';
		$tpl = new FieldFormTpl();
		foreach ($fields as $kfd){
			//读取关联实例字段
			$rexlivfds = $this->mod->getrexlivfds($kfd,$this->rexlivid);
			if($rexlivfds){
				//读取该关联字段的关联信息
				$rexdata = $this->mod->getrexdata($kfd,$this->rexpid);
				$fstr .= '</tr><tr>';
				$fstr .= '<td width="'.$formattr['width'].'" colspan="'.$kfd['colspan'].'" rowspan="'.$kfd['rowspan'].'" style="display:none;">';
				$fstr .= '<input type="hidden" name="'.$kfd['name'].'" value="'.$rexdata.'" />';
				$fstr .= '<input type="hidden" name="'.$kfd['name'].'_key" value="'.$this->rexpid.'" />';
				$fstr .= '</td>';
			}else{
				//如果存在条件隐藏
				$flag = true;
				if($kfd['eqtypeval']!=''){
					$aeqval = explode(',',$kfd['eqtypeval']);
					$flag = in_array($this->tp,$aeqval)?false:true;
				}
				if($flag){
					$fstr .= '</tr><tr>';
					$fstr .= '<td  width="'.$formattr['width'].'" colspan="'.$kfd['colspan'].'" rowspan="'.$kfd['rowspan'].'">';
					$fstr .= $tpl->{$kfd['xtype']}($kfd);
					$fstr .= '</td>';
				}
			}
		}
		//得到隐藏表单
		$fieldisplayno = $this->mod->getfdlist($this->conf['id'],0);
		$nodisplayarr = array();
		foreach ($fieldisplayno as $nolist){
			if($nolist['xtype']=='datefield'){
				$ptype = array('yyyy','MM','dd','HH','mm','ss');
				$ctype = array('Y','m','d','H','i','s');
				$format = str_replace($ptype,$ctype,$nolist['datefmt']);
				$val = $nolist['defval']=='NOW'?date($format):'';
				array_push($nodisplayarr,'<input type="hidden" name="'.$nolist['name'].'" value="'.$val.'" />');
			}else{
				array_push($nodisplayarr,'<input type="hidden" name="'.$nolist['name'].'" value="'.$nolist['defval'].'" />');
			}
		}
		$this->assign('FIELDPANEL',$fstr);
		$this->assign('FIELDSETWIDTH',$formattr['width']);
		$this->assign('FIELDNODISPLAY',join("",$nodisplayarr));
	}
	//搜索
	public function search()
	{
		$fields = $this->mod->getsearchfdlist($this->conf['id']);
		$searcharr = array();
		foreach ($fields as $kfd){
			if($kfd['xtype']=='datefield'){
				if(!empty($_POST[$kfd['name']])){
					$searcharr[] = array(//开始时间结束时间
						'xtype'=>$kfd['xtype'],
						'fieldlabel'=>$kfd['fieldlabel'],
						'name'	=> $kfd['name'],
						'value'=>array('start'=>$_POST[$kfd['name']][0],'end'=>$_POST[$kfd['name']][1])
					);
				}
			}else{
				if(!empty($_POST[$kfd['name']])){//存储当前值
					$searcharr[] = array(
						'xtype'=>$kfd['xtype'],
						'fieldlabel'=>$kfd['fieldlabel'],
						'name'	=> $kfd['name'],
						'value' => $_POST[$kfd['name']]
					);
				}
			}
		}
		Cache::session_set(array('SEARCH_'.$_GET['ag'].'_'.$this->tp=>$searcharr));//设置搜索session
		echo json_encode(array('type'=>'ajaxcontent','url'=>'util/grid/?app/ag/'.$_GET['ag'].'/tp/'.$this->tp.$this->rexurlsuf.'.html'));
	}
	//清空搜索条件
	public function clearsearch()
	{
		Cache::session_set(array('SEARCH_'.$_GET['ag'].'_'.$this->tp=>''));
	}
	//获取审核权限
	public function getsyngrade()
	{
		$syngrade = 0;
		if($this->conf['syngrade']>0){//是否有审核权限
			$pgy = Cache::session_get("MX_SYNARRAY");
			$syngrade = $pgy[$_GET['__mid']];
		}
		$this->assign('syngradeinfo',$syngrade);
	}
	//保存数据
	public function add()
	{
		//读取唯一字段
		$onlyone = $this->mod->getonlyone($this->conf['id']);
		foreach($onlyone as $list){
			$s = $this->mod->isextisval($this->conf['dbtname'],$list['name'],$this->tp);
			if($s>0){
				echo json_encode(array('type'=>'msg','msg'=>'【'.$list['fieldlabel'].'】只能输入唯一值,请更换!'));
				exit();
			}
		}
		$user = Cache::session_get("MXUSER_INFO");
		$res = $this->mod->add($this->conf['dbtname'],$this->tp,$user['name']);
		//全站搜索字段
		$sitefds = $this->mod->getsitesearchfields($this->conf['id']);
		$ids = array();
		foreach ($res as $lt){
			$d = $this->createhtml($lt['tid'],$lt['id']); //生成html
			$this->mod->upinfourl($this->conf['dbtname'],$lt['id'],$d['aurl'],$d['hurl']);
			//全站搜索
			$this->mod->esitedata($this->conf['dbtname'],$sitefds,$lt['tid'],$lt['id'],$d['aurl'],$d['hurl']);
			//更新缓存文件
			$this->upcache($lt['id'],$lt['tid']);
			$ids[] = $lt['id'];
		}
		$this->writelogs(join(',',$ids),'新增');
		echo json_encode(array('type'=>'ajaxcontent','url'=>'util/grid/?app/ag/'.$_GET['ag'].'/tp/'.$this->tp.$this->rexurlsuf.'.html'));
	}
	//得到数据
	public function getinfo()
	{
		$info = $this->mod->getinfo($this->conf['dbtname'],$_GET['id']);
		$this->assign('info',$info);
		//读取ckeditor字段
		$fckfd = $this->mod->getckeditorfield($this->conf['id']);
		foreach ($fckfd as $fk) $info[$fk['name']] = ""; //将FCK的字段置为空
		$this->assign('data',json_encode($info));
	}
	//修改数据
	public function edit()
	{
		//读取唯一字段
		$onlyone = $this->mod->getonlyone($this->conf['id']);
		foreach($onlyone as $list){
			$s = $this->mod->isextisval($this->conf['dbtname'],$list['name'],$this->tp,$_GET['id']);
			if($s>0){
				echo json_encode(array('type'=>'msg','msg'=>'【'.$list['fieldlabel'].'】只能输入唯一值,请更换!'));
				exit();
			}
		}
		$user = Cache::session_get("MXUSER_INFO");
		$res = $this->mod->edit($this->conf['dbtname'],$_GET['id'],$this->tp,$user['name']);
		//全站搜索字段
		$sitefds = $this->mod->getsitesearchfields($this->conf['id']);
		$ids = array();
		foreach ($res as $lt){
			$d = $this->createhtml($lt['tid'],$lt['id']);
			$this->mod->upinfourl($this->conf['dbtname'],$lt['id'],$d['aurl'],$d['hurl']);
			//全站搜索
			$this->mod->esitedata($this->conf['dbtname'],$sitefds,$lt['tid'],$lt['id'],$d['aurl'],$d['hurl']);
			//更新缓存文件
			$this->upcache($lt['id'],$lt['tid']);
			$ids[] = $lt['id'];
		}
		$this->writelogs(join(',',$ids),'修改');
		echo json_encode(array('type'=>'ajaxcontent','url'=>'util/grid/?app/ag/'.$_GET['ag'].'/tp/'.$this->tp.$this->rexurlsuf.'.html'));
	}
	/**
	 * 写入一条或者多条记录日志
	 * @param string $ids 数据IDS
	 * @param string $tp  操作类型
	 */
	private function writelogs($ids,$tp)
	{
		$logdt = array();
		$data = array();
		$eids = explode(',',$ids);
		$eidlen = count($eids);
		$fields = $this->mod->getfdlist($this->conf['id']);//字段信息
		for($i=0;$i<$eidlen;$i++){
			if(!empty($eids[$i])){//数据不为空时
				$sdata = $this->mod->getinfo($this->conf['dbtname'],$eids[$i]);
				$data[] = $sdata;
				$temp = array();
				foreach($fields as $list){
					$temp[$list['fieldlabel']] = $sdata[$list['name']];
				}
				$logdt[] = $temp;
			}
		}
		$user = Cache::session_get("MXUSER_INFO");
		//栏目信息
		$menu = $this->mod->getmenuinfo($this->tp);
		$menuinfo = $this->mod->getmenuallname($menu['path']);
		$obj = new OptLogs();
		$obj->node($tp,$user,$logdt,$data,array('id'=>$menu['id'],'name'=>$menuinfo));
	}
	//更新生成的HTML
	public function createhtml($tp,$id)
	{
		//生成相应的静态页面
		$menus = $this->mod->getmenuinfo($tp);
		if($menus['frturl']!=''){
			//目标动态页面
			$acturl = $menus['frturl'];
			$acturl = str_replace(array('(tid)','(id)'),array($tp,$id), $acturl);
			//生成静态页面
			if($menus['crturl']!=''){
				$htmlurl = $menus['crturl'];
				$htmlurl = str_replace(array('(tid)','(id)','(Y)','(M)','(D)'),array($tp,$id,date('Y'),date('m'),date('d')), $htmlurl);
				mk_dir(dirname(WEB_ROOT.$htmlurl)); //写入目录
				$data = file_get_contents('http://'.LOCAL_IP.WEB_APP.$acturl);
				file_put_contents(WEB_ROOT.$htmlurl, $data);
			}else{
				$htmlurl = '';
			}
		}
		return array('aurl'=>$acturl,'hurl'=>$htmlurl);
	}
	//更新标识状态
	public function toggleinfo()
	{
		$this->mod->toggleinfo($this->conf['dbtname'],$_POST['key'],$_POST['v'],$_GET['tagid']);
		$this->upcache($_GET['tagid'],$this->tp);
	}
	//更新缓存文件
	public function upcache($id,$tp)
	{
		$calist = $this->mod->getcalist($this->conf['id']);
		foreach($calist as $list){
			$bakurl = str_replace(array('(id)','(tid)'),array($id,$tp),$list['bakurl']);
			$createurl = str_replace(array('(id)','(tid)'),array($id,$tp),$list['creaturl']);
			$data = file_get_contents('http://'.LOCAL_IP.WEB_APP.$bakurl);
			file_put_contents(WEB_ROOT.$createurl,$data);
		}
	}
}
?>