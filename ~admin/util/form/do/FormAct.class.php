<?php
/**
 * 表单处理
 */
class FormAct extends Action
{
	private $mod = '';
	private $conf = array();
	private $tp = '';
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
		foreach ($fields as $kfd){
			//读取关联实例字段
			$rexlivfds = $this->mod->getrexlivfds($kfd,$this->rexlivid);
			if($rexlivfds){
				//读取该关联字段的关联信息
				$rexdata = $this->mod->getrexdata($kfd,$this->rexpid);
				$fstr .= $colnum%$formattr['colspan']==0?'</tr><tr>':'';
				$fstr .= '<td width="'.($colwidth*$kfd['colspan']).'" colspan="'.$kfd['colspan'].'" rowspan="'.$kfd['rowspan'].'" style="display:none;">';
				$fstr .= '<input type="hidden" name="'.$kfd['name'].'" class="noload" value="'.$rexdata.'" />';
				$fstr .= '<input type="hidden" name="'.$kfd['name'].'_key" class="noload" value="'.$this->rexpid.'" />';
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
				$fstr .= $tpl->{$kfd['xtype']}($kfd);
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
	//得到数据
	public function getinfo()
	{
		$info = $this->mod->getinfo($this->conf['dbtname'],$this->tp);
		$this->assign('info',$info);
		//读取ckeditor字段
		$fckfd = $this->mod->getckeditorfield($this->conf['id']);
		foreach ($fckfd as $fk) $info[$fk['name']] = ""; //将FCK的字段置为空
		$this->assign('data',json_encode($info));
	}
	//修改数据
	public function edit()
	{
		$this->mod->edit($this->conf['dbtname'],$this->tp);
		//生成相应的静态页面
		$menus = $this->mod->getmenuinfo($this->tp);
		//目标动态页面
		$acturl = $menus['frturl'];
		$acturl = str_replace(array('(tid)'),array($this->tp), $acturl);
		//生成静态页面
		if($menus['crturl']!=''){
			$htmlurl = $menus['crturl'];
			$htmlurl = str_replace(array('(tid)','(Y)','(M)','(D)'),array($this->tp,date('Y'),date('m'),date('d')), $htmlurl);
			mk_dir(dirname(WEB_ROOT.$htmlurl)); //写入目录
			$data = file_get_contents('http://'.LOCAL_IP.WEB_APP.$acturl);
			file_put_contents(WEB_ROOT.$htmlurl, $data);
		}else{
			$htmlurl = '';
		}
		$this->mod->upinfourl($this->conf['dbtname'],$this->tp,$acturl,$htmlurl);
		//全站搜索字段
		$sitefds = $this->mod->getsitesearchfields($this->conf['id']);
		$this->mod->esitedata($this->conf['dbtname'],$sitefds,$this->tp,$acturl,$htmlurl);
		$this->upcache($this->tp);//更新缓存文件
		$this->writelogs('单页编辑');
		echo json_encode(array('type'=>'ajaxcontent','url'=>'util/form/?app/ag/'.$_GET['ag'].'/tp/'.$this->tp.$this->rexurlsuf.'.html'));
	}
	/**
	 * 写入一条或者多条记录日志
	 * @param string $tid 单页数据
	 * @param string $tp  操作类型
	 */
	private function writelogs($tp)
	{
		$logdt = array();
		$data = array();
		$fields = $this->mod->getfdlist($this->conf['id']);//字段信息
		$info = $this->mod->getinfo($this->conf['dbtname'],$this->tp);
		if(!empty($info)){//数据不为空时
			$data[] = $info;
			$temp = array();
			foreach($fields as $list)
				$temp[$list['fieldlabel']] = $info[$list['name']];
			$logdt[] = $temp;
		}
		$user = Cache::session_get("MXUSER_INFO");
		//栏目信息
		$menu = $this->mod->getmenuinfo($this->tp);
		$menuinfo = $this->mod->getmenuallname($menu['path']);
		$obj = new OptLogs();
		$obj->node($tp,$user,$logdt,$data,array('id'=>$menu['id'],'name'=>$menuinfo));
	}
	//更新缓存文件
	public function upcache($tp)
	{
		$calist = $this->mod->getcalist($this->conf['id']);
		foreach($calist as $list){
			$bakurl = str_replace('(tid)',$tp,$list['bakurl']);
			$createurl = str_replace('(tid)',$tp,$list['creaturl']);
			$data = file_get_contents('http://'.LOCAL_IP.WEB_APP.$bakurl);
			file_put_contents(WEB_ROOT.$createurl,$data);
		}
	}
}
?>