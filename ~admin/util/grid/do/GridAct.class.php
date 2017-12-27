<?php
/**
 * 表格处理
 */
class GridAct extends Action
{
	private $mod = '';
	private $conf = array();
	private $tp = '';
	private $userinfo = '';
	private $rexlivid = ''; //关联实例ID
	private $rexpid = ''; //关联信息ID，即父ID
	private $rexurlsuf = ''; //关联信息URL
	private $rexfield = ''; //关联字段
	public function GridAct()
	{
		$this->mod = $this->M('Grid');
		$this->conf = $this->mod->getlivs($_GET['ag']);
		$this->tp = $_GET['tp'];
		$this->rexlivid = $_GET['rexlivid'];
		$this->rexpid = $_GET['rexpid'];
		$this->userinfo = Cache::session_get("MXUSER_INFO");
		//操作权限
		$this->getoptpower();
		$this->assign('CONFINI',$this->conf);
		$this->assign('TP',$this->tp);
		if(!empty($this->rexlivid) && !empty($this->rexpid)){//连接后缀
			$this->rexurlsuf = '/rexlivid/'.$this->rexlivid.'/rexpid/'.$this->rexpid;
			$this->assign('TP',$this->tp.$this->rexurlsuf);
			//关联实例信息
			$rexname = $this->mod->get_rexlivfdname($this->conf['id'],$this->rexlivid,$this->rexpid);
			$this->rexfield = $rexname['name'];
			$this->assign('REXTITLE',' > '.$rexname['rexname']);
		}
		$this->assign('REXLIVID',$this->rexlivid);
		$this->assign('REXPID',$this->rexpid);
		$this->assign('USERINFO',$this->userinfo);
	}
	/**
	 * 获取可控操作权限
	 */
	public function getoptpower()
	{
		//可控操作权限列表
		$optarray = array('add','edit','del','excelin','excelout');
		//角色权限
		if($this->userinfo['pwgrade']==1){//超级管理员
			for($oi=0;$oi<5;$oi++)
				$this->conf['cfg_'.$optarray[$oi].'_key'] = 1;
		}else{//非超管
			if(empty($this->rexlivid) && empty($this->rexpid)){//如果不是子列表，则采用角色权限，如果是，则采用模块权限
				//先将操作权限这块置为0
				for($oi=0;$oi<5;$oi++)
					$this->conf['cfg_'.$optarray[$oi].'_key'] = 0;
				//读取角色权限
				$optrole = $this->mod->getoptpower($this->userinfo['gid']);
				if($optrole['optools']!=''){
					//按角色来分配置操作权限
					$optpw = json_decode($optrole['optools'],true);
					if($this->tp=='all'){//如果是全部栏目,将全部权限打开
						for($oi=0;$oi<5;$oi++)
							$this->conf['cfg_'.$optarray[$oi].'_key'] = 1;
					}else{
						$stroptchk = isset($optpw[$this->tp])?$optpw[$this->tp]:'';
						$arroptchk = explode(',',$stroptchk);
						$numoptchk = count($arroptchk);
						for($i=0;$i<$numoptchk;$i++){
							$this->conf['cfg_'.$arroptchk[$i].'_key'] = 1;
						}
					}
				}
			}
		}
	}
	/**
	 * 数据列表
	 */
	public function glist()
	{
		$_GET['page'] = $_POST['page'];
		$pgy = Cache::session_get("MX_SYNARRAY");
		$page = $this->mod->getstore($this->conf['dbtname'],$_POST['rp'],$this->tp,$this->rexfield,$this->rexpid,$pgy);
		$data = $this->mod->get_all();
		$row = array();
		//查找标识字段
		$marktag = $this->mod->getmarklist($this->conf['id']);
		//多文件上传字段
		$fileups = $this->mod->getpuloadlist($this->conf['id']);
		//单文件上传字段
		$simfileups = $this->mod->getsimuplist($this->conf['id']);
		//多选项关联
		$downredxlivs = $this->mod->getdownrexfd($this->conf['id']);
		//单字段关联
		$rexfields = $this->mod->getrexfields($this->conf['id']);
		foreach($data as $k=>$v){
			//与是所有分类，则显示菜单信息
			if($this->tp == 'all')
				$data[$k]['__alltname'] = $this->mod->getmenuname($v['__typeid']);
			//手动排序
			if($this->conf['cfg_handsort_key']==1)
				$data[$k]['__handsort'] = '<input name="handsortpt" type="text" style="width:55px;" did="'.$v['id'].'" value="'.$v['__handsort'].'" />';
			//下拉字段与其他实例相关联
			if(!empty($downredxlivs)){
				foreach ($downredxlivs as $rexfd){
					//数据相关的
					$fieldata = $this->mod->getfieldowndata($rexfd['id']);
					foreach($fieldata as $fddata){
						if($fddata['livid']>0 && $fddata['keyinfo']==$v[$rexfd['name'].'_key']){
							//读取实例API
							$livapi = $this->mod->getlivapi($fddata['livid']);
							$livapi = substr($livapi,0,-5);
							$livapi = str_replace('分类标识',$this->tp, $livapi);
							$livapi = $livapi.'/rexlivid/'.$this->conf['id'].'/rexpid/'.$v['id'].'.html';
							$data[$k][$rexfd['name']] = '<a href="javascript:;" brurl="'.$livapi.'" style="color:#FF0000; text-decoration:underline;">'.$data[$k][$rexfd['name']].'</a>';
						}
					}
				}
			}
			//单字段关联
			if(!empty($rexfields)){
				foreach($rexfields as $rsfd){
					//读取实例API
					$livapi = $this->mod->getlivapi($rsfd['rexlivid']);
					$livapi = substr($livapi,0,-5);
					$livapi = str_replace('分类标识',$this->tp, $livapi);
					$livapi = $livapi.'/rexlivid/'.$this->conf['id'].'/rexpid/'.$v['id'].'.html';
					$rsfdname = $data[$k][$rsfd['name']];
					$data[$k][$rsfd['name']] = '<a href="javascript:;" brurl="'.$livapi.'" style="color:#FF0000; text-decoration:underline;">'.(empty($rsfdname)?$rsfd['fieldlabel']:$rsfdname).'</a>';
				}
			}
			$marktaglen = count($marktag);
			for($i=0;$i<$marktaglen;$i++)//处理标识字段
				$data[$k][$marktag[$i]] = '<a href="javascript:;" itip="点击“是,否”<br>可更换状态" hotagid="'.$v['id'].'" key="'.$marktag[$i].'" val="'.($v[$marktag[$i]]=="是"?0:1).'">'.$v[$marktag[$i]].'</a>';
			$fileupslen = count($fileups);
			for($i=0;$i<$fileupslen;$i++)//多文件上传字段
				$data[$k][$fileups[$i]] = '<a href="javascript:;" fileids="'.$v[$fileups[$i].'_ids'].'" filedname="'.$fileups[$i].'" fieldnid="'.$v['id'].'">'.$v[$fileups[$i]].'</a>';
			foreach($simfileups as $lt)//单文件上传字段
				$data[$k][$lt['name']] = '<a href="javascript:;" simplepath="'.WEB_APP.$v[$lt['name'].'_path'].'"><img src="'.WEB_APP.$v[$lt['name'].'_path'].'" width="'.$lt['width'].'" height="'.$lt['height'].'" border="0" /></a>';
			if($v['__syninfo']>0){//如果有审核信息
				$syngw = array(1=>'一级审核',2=>'二级审核',3=>'三级审核',4=>'四级审核');
				//读取审核信息
				$syninfoist = $this->mod->getsyninfolist($this->conf['dbtname'],$v['id']);
				$data[$k]['__syninfo'] = '<a href="javascript:;" class="syninfolist" itip="'.$syninfoist.'">'.$syngw[$v['__syninfo']].'</a>';
			}else{
				$data[$k]['__syninfo'] = '未审核';
			}
			//是否置顶
			$data[$k]['__systop'] = $v['__systop']==1?'是':'否';
			//是否发布
			$data[$k]['__syspub'] = $v['__syspub']==1?'是':'否';
			$optstr = '';
			if($this->conf['cfg_brower_key']==1) $optstr .= '<a href="'.WEB_APP.$v['__aurl'].'" target="_blank" class="mx-list-test">预览</a>';
			if($this->conf['cfg_edit_key']==1) $optstr .= '<a href="javascript:;" brurl="util/grid/?edit/ag/'.$this->conf['proname'].'/tp/'.$this->tp.$this->rexurlsuf.'/id/'.$v['id'].'.html" class="mx-list-edit">修改</a>';
			if($this->conf['cfg_del_key']==1) $optstr .= '<a href="javascript:;" class="mx-list-remove" delid="'.$v['id'].'" delname="ID为'.$v['id'].'信息" delurl="util/grid/do/?Grid-del/ag/'.$this->conf['proname'].'/tp/'.$this->tp.$this->rexurlsuf.'" backurl="util/grid/?app/ag/'.$this->conf['proname'].'/tp/'.$this->tp.$this->rexurlsuf.'.html">删除</a>';
			$data[$k]['__optlist'] = $optstr;
		}
		echo json_encode(array('rows'=>$data,'page'=>$_GET['page'],'total'=>$page['total']));
	}
	//导出设置
	public function getoutputs()
	{
		$data = $this->mod->getoutputs($this->conf['id']);
		$this->assign('OUTPUTTAG',empty($data)?0:1);
		$this->assign('OUTPUTDATA',$data);
	}
	//是否有多项搜索字段
	public function issearchfd()
	{
		$n = $this->mod->getsearchfdlist($this->conf['id']);
		$this->assign('ISSEARCHFDN',$n>0?1:0);
	}
	//得到当前搜索的内容
	public function getsearch()
	{
		$s = Cache::session_get('SEARCH_'.$this->conf['proname'].'_'.$this->tp);
		$str = array();
		if(!empty($s)){
			foreach($s as $v){
					if($v['xtype']=='datefield'){
						if(!empty($v['value']['start']) || !empty($v['value']['end'])) array_push($str, '<span class="label">'.$v['fieldlabel'].'</span>:<span class="content">'.$v['value']['start'].'--'.$v['value']['end'].'</span>');
					}else{
						if(!empty($v['value'])) array_push($str, '<span class="label">'.$v['fieldlabel'].'</span>:<span class="content">'.$v['value'].'</span>');
					}
			}
		}
		if(!empty($str))
			$this->assign('searchcondion','<span class="mx_grid_search"><img src="images/del.gif" border="0" align="absmiddle" style="cursor:pointer" onclick="basegridclearsearch()" />当前搜索条件:'.join('', $str).'</span>');
	}
	/**
	 * 获得列信息
	 */
	public function getheader()
	{
		$fields = $this->mod->getfdlist($this->conf['id']);
		$fdheader = array(
		'{
			display :"ID",
			name:"id",
			width:40,
			sortable:true,
			align:"center"
		}');
		if($this->conf['cfg_handsort_key']==1){//手动排序
			array_push($fdheader,'
			{
			display :"手动排序",
			name:"__handsort",
			width:60,
			sortable:true,
			align:"center"
			}');
		}
		if($this->conf['cfg_top_key']==1){//是否置顶
			array_push($fdheader,'
			{
			display :"置顶",
			name:"__systop",
			width:40,
			sortable:true,
			align:"center"
			}');
		}
		if($this->conf['cfg_pub_key']==1){//是否发布
			array_push($fdheader,'
			{
			display :"发布",
			name:"__syspub",
			width:40,
			sortable:true,
			align:"center"
			}');
		}
		if($this->tp == 'all'){
			array_push($fdheader,'
			{
			display:"分类名称",
			name:"__alltname",
			width:160,
			sortable:true,
			align:"left"
			}');
		}
		if($this->conf['syngrade']>0){
			array_push($fdheader,'
			{
				display:"审核情况",
				name:"__syninfo",
				width:80,
				sortable:true,
				align:"left"
			}');
		}
		$searchitems = array('
			{
				display:"全部内容", 
				name:"__allkeyword"
			}
		');
		foreach ($fields as $kfd){
			//如果存在条件隐藏
			$flag = true;
			if($kfd['eqtypeval']!=''){
				$aeqval = explode(',',$kfd['eqtypeval']);
				$flag = !in_array($this->tp,$aeqval);
			}
			if($kfd['listwidth']>0 && $flag){
				array_push($fdheader,'
				{
					display:"'.$kfd['fieldlabel'].'",
					name:"'.$kfd['name'].'",
					width:'.$kfd['listwidth'].',
					sortable:true,
					align:"left"
				}');
			}
			if($flag){
				array_push($searchitems,'
				{
					display:"'.$kfd['fieldlabel'].'", 
					name:"'.$kfd['name'].'"
				}
				');
			}
		}
		array_push($fdheader,'
		{
			display:"操作",
			name:"__optlist",
			width:160,
			sortable:false,
			align:"left"
		}');
		$this->assign('FIELD_HEADER',join(',',$fdheader));
		//查找默认排序 
		if($this->conf['cfg_handsort_key']==1){//开启手动排序
			$sortarr = array('name'=>'__handsort','sort'=>'desc');
		}else{
			$defsort = $this->mod->getdefsort($this->conf['id']);
			$sortarr = array('name'=>'id','sort'=>'desc');
			if(!empty($defsort)){//指定排序
				$osdes = array('','asc','desc');
				$sortarr = array('name'=>$defsort['name'],'sort'=>$osdes[$defsort['defsort']]);
			}
		}
		$this->assign('DEFSORT',$sortarr);
		$this->assign('SEARCHITEM',join(',',$searchitems));
	}
	//保存字段宽度
	public function fieldwidth()
	{
		if($this->userinfo['id']==1)
			$this->mod->savewdfd($this->conf['id']);
	}
	//保存列表字段排序
	public function headersort()
	{
		if($this->userinfo['id']==1)
			$this->mod->headersort($this->conf['id']);
	}
	//删除
	public function del()
	{
		$ids = !empty($_GET['id'])?$_GET['id']:$_POST['ids'];
		$this->writelogs($ids,'删除');
		$this->mod->del($this->conf['dbtname'],$ids);
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
	//获取文件名
	public function getfiles()
	{
		$data = $this->mod->getfiles($_GET['fid']);
		foreach($data as $k=>$list){
			//换算文件大小
			if($list['size']<1024){
				$data[$k]['size'] = $list['size'].' B';
			}elseif($list['size']>=1024 && $list['size']<1024*1024){
				$data[$k]['size'] = ceil($list['size']/1024).' KB';
			}else{
				$data[$k]['size'] = ceil($list['size']/(1024*1024)).' MB';
			}
			//将文件的后缀和文件名分开
			$oldfiles = pathinfo($list['oldname']);
			$oldbasename = $oldfiles['basename'];
			$oldbapos = strrpos($oldbasename,'.'.$oldfiles['extension']);
			$data[$k]['oldname'] = substr($oldbasename,0,$oldbapos);
			$data[$k]['oldext']	= '.'.$oldfiles['extension'];
			$data[$k]['lid'] = $_GET['lid'];
			$data[$k]['file_path'] = ($list['ext']=='jpg' || $list['ext']=='gif' || $list['ext']=='png')?'../'.$list['file']:'images/defptinfo.png';
		}
		return $data;
	}
	//删除文件
	public function delappends()
	{
		$data = $this->mod->getfiles($_POST['ids']);
		foreach ($data as $list){
			$file = WEB_ROOT.$list['file'];
			if(file_exists($file)) unlink($file);
		}
		$this->mod->delappends($_POST['ids']);
		$d = $this->mod->uplistappend($_POST['oldids'],$this->conf['dbtname'],$_POST['filedname'],$_POST['fieldnid']);
		echo $d;
	}
	//修改图片信息
	public function sortappends()
	{
		$this->mod->sortappends($_POST['upids'],$_POST['upoldnamearr'],$_POST['upsortarr'],$_POST['lid'],$_POST['filedname'],$this->conf['dbtname']);
		$d = $this->mod->uplistappend($_POST['upids'],$this->conf['dbtname'],$_POST['filedname'],$_POST['lid']);
		echo $d;
	}
	//删除单文件
	public function delsimplefile()
	{
		$this->mod->delsimplefile($this->conf['dbtname'],$this->tp,$_POST['id'],$_POST['filedname']);
	}
	//导入测试数据
	public function filldatatest()
	{
		$tables = $this->mod->get_tables();
		if(in_array($this->conf['dbtname'],$tables)){
			//数据目录
			$path = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
			$path = str_replace('\\','/',$path);
			$datapath = $path.'/fieldatas';
			//导入测试数据
			$this->mod->importdatatest($this->conf,$datapath,$this->tp);
			echo "测试数据导入成功!";
		}else{
			echo "未创建数据表,请先更新数据表,再导入测试数据!";
		}
	}
	//导出数据
	public function outputdata()
	{
		set_time_limit(0);
		$outdatas = $this->mod->getsimpleout($_POST['outype']);
		$str = '';
		$eids = explode(',',$_POST['outids']);
		$eidslen = count($eids);
		for($i=0;$i<$eidslen;$i++){
			$urls = str_replace(array('(id)','(tid)'),array($eids[$i],$this->tp),$outdatas['url']);
			$str .= file_get_contents('http://'.LOCAL_IP.WEB_APP.$urls);
		}
		$filename = $outdatas['title'].$_POST['outids'];
		$filename = mb_convert_encoding($filename,"GBK","UTF-8");
		$data = array(
			'doc'	=>	array(
				"Content-Type: application/msword;charset=utf-8",
				"Content-Disposition:   attachment; filename=".$filename.".doc",
				"Pragma:   no-cache"
			),
			'xls'	=>	array(
				"Content-type:application/vnd.ms-excel;charset=utf-8",        
				"Content-Disposition:   attachment; filename=".$filename.".xls",
				"Pragma:   no-cache"
			),
			'ppt'	=>	array(
				"Content-type:application/vnd.ms-powerpoint;charset=utf-8",        
				"Content-Disposition:   attachment; filename=".$filename.".ppt",
				"Pragma:   no-cache"
			)
		);
		$outda = $data[$outdatas['outype']];
		$dlen = count($outda);
		for($k=0;$k<$dlen;$k++)
			header($outda[$k]);
		echo $str;
	}
	//审核通过
	public function syngrade()
	{
		$pgy = Cache::session_get("MX_SYNARRAY");
		$pwgr = $pgy[$_POST['__mid']]; //读取我的审核级别
		$this->mod->syngrade($pwgr,$this->userinfo['name'],$this->conf['dbtname'],$_POST['ids']);
		echo '批量审核通过!';
	}
	//获取审核权限
	public function getsynpower()
	{
		$pgy = Cache::session_get("MX_SYNARRAY");
		$this->assign('PYGPWOER',json_encode($pgy));
	}
	//手动排序
	public function handsort()
	{
		$ep = explode(',',$_POST['pval']);
		$eplen = count($ep);
		for($i=0;$i<$eplen;$i++){
			$eidp = explode(':',$ep[$i]);
			$this->mod->uphandsort($this->conf['dbtname'],$eidp[0],$eidp[1]);
		}
	}
	//自动排序
	public function autosort()
	{
		$this->mod->upstepsort($this->conf['dbtname'],$this->tp);
	}
	//导出excel模板/数据
	public function excelout()
	{
		set_time_limit(0);
		require_once WEB_ROOT.SYS_LIBS.'/tools/phpexcel/PHPExcel.php';
		//文件名
		$fnutf8 = $_POST['title'].'-'.($_POST['type']==1?'数据':'模板');
		//创建phpexcel实例
		$objPHPExcel = new PHPExcel();
		//设置文档属性
		$user = Cache::session_get("MXUSER_INFO");
		$objPHPExcel->getProperties()->setCreator($user['name'])
			->setLastModifiedBy($user['name'])
			->setTitle($_POST['title'])
			->setSubject($fnutf8)
			->setDescription($fnutf8)
			->setKeywords($_POST['title'])
			->setCategory($_POST['title']);
		//工作表对象
		$sheets = $objPHPExcel->setActiveSheetIndex(0);
		//设置表头
		$fields = $this->mod->excfields($_GET['appid']);
		foreach($fields as $k=>$fd){
			$sheets->setCellValue($this->getexcelheader($k).'1',$fd['fieldlabel']);
		}
		//数据导出
		if($_POST['type']==1){
			$data = $this->mod->getexclastdata($_POST['db_name'],$_POST['__typeid'],$_POST['outids']);
			$datai = 2; //第二行开始写入数据
			foreach ($data as $dv){
				foreach($fields as $k=>$fd){
					$sheets->setCellValue($this->getexcelheader($k).$datai,$dv[$fd['name']]);
				}
				$datai++;
			}
		}
		//工作表标题
		$objPHPExcel->getActiveSheet()->setTitle($_POST['title']);
		//将第一个工作表设置为工作状态
		$objPHPExcel->setActiveSheetIndex(0);
		//输出excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.mb_convert_encoding($fnutf8,"GBK","UTF-8").'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit();
	}
	//导入excel数据
	public function excelin()
	{
		if($_POST['excel_path']==''){
			die(json_encode(array('type'=>'msg','msg'=>'请先上传excel文件!')));
		}
		set_time_limit(0);
		require_once WEB_ROOT.SYS_LIBS.'/tools/phpexcel/PHPExcel.php';
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$objPHPExcel = $objReader->load(WEB_ROOT.$_POST['excel_path']);
		//字段信息
		$fields = $this->mod->excfields($_GET['appid']);
		$fdata = array();
		foreach($fields as $k=>$fv){
			$fdata[$k] = $fv['name'];//字段名称
		}
		foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {//循环工作表
			foreach ($worksheet->getRowIterator() as $row) {//循环行
				if($row->getRowIndex()>1){
					$cellIterator = $row->getCellIterator();
					$cellIterator->setIterateOnlyExistingCells(true); // Loop all cells, even if it is not set
					$fi = 0;//字段序号
					$isempty = 0; //默认为空
					foreach ($cellIterator as $cell) {
						$celldata = $cell->getCalculatedValue();
						if (!is_null($cell) && trim($celldata)!='') {
							$_POST[$fdata[$fi]] = $celldata;
							$isempty++;
						}
						$fi++;
					}
					//写入数据库 去掉空行
					if($isempty>0){
						$this->mod->inexceldata($_POST['__db_name']);
					}
				}
			}
		}
		exit('');
	}
	/**
	 * 返回excel的横坐标
	 * @param int $i
	 */
	private function getexcelheader($i)
	{
		$hd = array(
			'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
			'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ',
			'BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ',
			'CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ',
			'DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP','DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ',
			'EA','EB','EC','ED','EE','EF','EG','EH','EI','EJ','EK','EL','EM','EN','EO','EP','EQ','ER','ES','ET','EU','EV','EW','EX','EY','EZ'
		);
		return $hd[$i];
	}
}
?>