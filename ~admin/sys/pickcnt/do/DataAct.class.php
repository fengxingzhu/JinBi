<?php
/**
 * 采集内容管理
 */
require_once(WEB_ROOT.SYS_LIBS.'/tools/simple_html_dom.php');
class DataAct extends Action
{
	private $mod = '';
	public function DataAct()
	{
		$this->mod = $this->M('Data');
	}
	//列表
	public function glist()
	{		
		$_GET['page'] = $_POST['page'];
		//得到搜索条件
		$searchdata = Cache::session_get("SYS_PICKCNT_SEARCH");
		$page = $this->mod->getconlist($_POST['rp'],$searchdata);
		$data = $this->mod->get_all();
		foreach ($data as $k=>$v){
			$data[$k]['view'] = '<a href="sys/pickcnt/?view/id/'.$v['id'].'.html" target="_blank">查看</a>';
			$picked = $v['pstatus']==1?'FF0000':'004080';
			$data[$k]['title'] = '<a href="'.$v['links'].'" target="_blank" class="pickcntlinks" style="text-decoration:underline; color:#'.$picked.';">'.$v['title'].'</a>';
		}
		echo json_encode(array('rows'=>$data,'page'=>$_GET['page'],'total'=>$page['total']));
	}
	//读取结点
	public function getnodelist()
	{
		$d = $this->mod->getnodelist();
		$this->assign('NODELIST',$d);
	}
	//读取对应的分类标识
	public function getypeinfo()
	{
		$data = $this->gettypeoptions($_POST['nodeid']);
		echo json_encode($data);
	}
	private function gettypeoptions($nodeid)
	{
		$d = $this->mod->getypeinfo($nodeid);
		$ed = explode('|',$d);
		$edlen = count($ed);
		$data = array();
		for($i=0;$i<$edlen;$i++){
			$typeid = $ed[$i];
			if(!empty($typeid)){
				$title = $this->mod->gettagname($typeid);
				array_push($data, array(
					'tid'		=>	$typeid,
					'title'	=>	$title.'['.$typeid.']'
				));
			}
		}
		return $data;
	}
	//搜索
	public function search()
	{
		//保存搜索条件
		Cache::session_set(array('SYS_PICKCNT_SEARCH'=>array(
			'keyword'		=>	$_POST['keyword'], //关键词
			'nodeid'		=>	$_POST['nodeid'], //结点
			'typeid'		=>	$_POST['typeid'] //分类标识
		)));
		echo json_encode(array('type'=>'ajaxcontent','url'=>'sys/pickcnt/?app.html'));
	}
	//得到搜索信息
	public function getsearchinfo()
	{
		//得到搜索条件
		$searchdata = Cache::session_get("SYS_PICKCNT_SEARCH");
		$this->assign('searchdata',json_encode($searchdata));
		$this->assign('searchinfo',$$searchdata);
		//读取分类标识
		$tydata = $this->gettypeoptions($searchdata['nodeid']);
		$this->assign('TYPETAGS',$tydata);
	}
	//清空搜索条件
	public function clearsearch()
	{
		Cache::session_set(array('SYS_PICKCNT_SEARCH'=>array()));
		echo json_encode(array('type'=>'ajaxcontent','url'=>'sys/pickcnt/?app.html'));
	}
	//删除选中
	public function delcontent()
	{
		$this->mod->delcons($_POST['ids']);
	}
	//已导入删除
	public function delimported()
	{
		$this->mod->delimported();
	}
	//清空缓存文章
	public function clearempty()
	{
		$this->mod->clearemptys();
	}
	//选择导入
	public function imports()
	{
		set_time_limit(0); //防止超时
		$this->importany($_REQUEST['ids']);
	}
	//导入全部
	public function importall()
	{
		//导入
		if(!empty($_POST['ids'])){//导入
			$this->importany($_POST['ids']);
		}
		//返回数据
		$ids = $this->mod->getlastids($_POST['lastid']);
		echo json_encode($ids);
	}
	//同时导入多个
	private function importany($anyids)
	{
		//得到搜索条件
		$searchdata = Cache::session_get("SYS_PICKCNT_SEARCH");
		$temps = $this->mod->tempinfo($anyids,$searchdata);
		foreach($temps as $list){
			$data = $this->oneparseinfo($list);//解析输出一条信息
			//全站搜索字段
			$sitefds = $this->mod->getsitesearchfields($data['livid']);
			foreach($data['data'] as $k=>$p)
				$_POST[$k] = $p;
			
			if(!empty($searchdata['typeid'])){//导入这一类分类中
				$_POST['__typeid'] = $searchdata['typeid'];
				$this->mod->dbimports($data['tbname'],$data['field'],$list['id'],$sitefds);
			}else{//多个分类标识
				$etype = explode('|',$_POST['__typeid']);
				$etypelen = count($etype);
				for($ii=0;$ii<$etypelen;$ii++){
					$_POST['__typeid'] = $etype[$ii];//分类标识
					$this->mod->dbimports($data['tbname'],$data['field'],$list['id'],$sitefds);
				}
			}
		}
	}
	/**
	 * 查看解析的内容
	 */
	public function viewinfo()
	{
		$tempinfo = $this->mod->readtempinfo($_GET['id']);
		$data = $this->oneparseinfo($tempinfo);
		$fieldname = $this->mod->getfieldnames($data['livid']);
		$res = array(); //内容信息
		foreach($data['field'] as $v){
			if($v!='__typeid'){
				$res[] = array('fname'=>$fieldname[$v],'fval'=>$data['data'][$v]);
			}
		}
		$info = array();
		$info['title'] = $this->mod->getmenulistinfo($data['data']['__typeid']);
		$info['links'] = $tempinfo['links'];
		$this->assign('info',$info);
		$this->assign('data',$res);
	}
	/**
	 * 解析一个结点的单条数据
	 * @param array $list 缓存列表信息
	 */
	private function oneparseinfo($list)
	{
		//结点信息
		$nodes = $this->mod->nodesummary($list['nodeid']);
		//读取要导入的表名
		$tbname = $this->mod->get_talname($nodes['livid']);
		//导入设置
		$imports = $this->mod->getsetinfo($list['nodeid']);
		//图片存储路径
		$emspickimg = 'asset/emspick/'.date("Y_m_d").'/';
		//抓紧文章
		$list['links'] = str_replace("\r\n", "", $list['links']); //过滤转换符
		$fg = http_get_contents($list['links'],$nodes['timeout']);//抓取页面
		$returndata = array(
			'livid'	=>	$nodes['livid'],//实例ID
			'tbname'=>	$tbname, //表名信息
			'field'	=>	array(),//字段信息
			'data'	=>	array()	//列表信息
		);//返回的数据
		if($fg && !empty($tbname))
		{
			$fg = $nodes['codetype']!='UTF8'?mb_convert_encoding($fg,"UTF-8",$nodes['codetype']):$fg; //如果不是utf8编码，则进行转换
			foreach($imports as $v){
				$returndata['field'][] = $v['fieldname'];//字段信息
				if($v['fieldname']=='__typeid'){//如果是分类，则存入该字段
					$returndata['data']['__typeid'] = $v['start_tag'];
				}else{//其他字段
					if($v['fdpickype']=='0'){//DOM读取结点
						$html = str_get_html($fg);
						$data = $html->find($v['fddomfind'],0);
						$returndata['data'][$v['fieldname']] = $data->innertext;//获取读取文本信息
						$html->clear();//清除内存
					}else{//match匹配
						preg_match("/".preg_quote($v['start_tag'],"/")."(.*)".preg_quote($v['end_tag'],"/")."/isU", $fg, $res);
						$returndata['data'][$v['fieldname']] = $v['cuttrim']==1?trim($res[1]):$res[1];
						$returndata['data'][$v['fieldname']] = $v['cuthtml']==1?strip_tags($returndata['data'][$v['fieldname']]):$returndata['data'][$v['fieldname']];
						//替换规则
						if(!empty($v['replace_oldstr']) && !empty($v['replace_newstr'])){
							$oldstr = explode(',',$v['replace_oldstr']);
							$newstr = explode(',',$v['replace_newstr']);
							$returndata['data'][$v['fieldname']] = str_replace($oldstr,$newstr,$returndata['data'][$v['fieldname']]);
						}
					}
					preg_match_all("/<img(.*)src=(.*)(\s+)(.*)(\/?)>/isU", $returndata['data'][$v['fieldname']], $imgarr);
					//图片拷贝
					$imgarrlen = count($imgarr[2]);
					for($j=0;$j<$imgarrlen;$j++){
						$imgarr[2][$j] = str_replace("'","",$imgarr[2][$j]); //去掉单引号
						$imgarr[2][$j] = str_replace("\"","",$imgarr[2][$j]); //去掉双引号
						if(strtolower(substr($imgarr[2][$j],0,7)) == "http://"){ //目标连接为绝对连接
							$linkstr = $imgarr[2][$j];
						}else if(substr($imgarr[2][$j],0,1) == "/"){ //目标连接为相对网站绝对连接
							$urlarr = parse_url($list['links']);
							$linkstr = "http://".$urlarr['host'].$imgarr[2][$j];
						}else{ //目标连接为相对网站相对连接
							$urlparse = parse_url($list['links']);
							$dirsnum = substr_count($imgarr[2][$j],"../");
							$padirs = $urlparse['path'];
							for($i=0;$i<=$dirsnum;$i++) $padirs = dirname($padirs);
							$imagestr = str_replace("../","",$imgarr[2][$j]); //去除相对路径
							$linkstr = $urlparse['scheme'].'://'.$urlparse['host'].$padirs.'/'.$imagestr;
						}
						$imags = http_get_contents($linkstr,$nodes['timeout']);
						mk_dir(WEB_ROOT.'/'.$emspickimg);
						$filetemps = basename($linkstr);
						file_put_contents(WEB_ROOT.'/'.$emspickimg.$filetemps,$imags);
						$returndata['data'][$v['fieldname']] = str_replace($imgarr[2][$j],WEB_APP.$emspickimg.$filetemps,$returndata['data'][$v['fieldname']]); //替换原路径
					}
				}
			}
		}
		return $returndata;
	}
}
?>