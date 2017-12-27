<?php
/**
 * 结点设置
 */
require_once(WEB_ROOT.SYS_LIBS.'/tools/simple_html_dom.php');
class DataAct extends Action
{
	private $mod = '';
	public function DataAct()
	{
		$this->mod = $this->M('Data');
	}
	//结点列表
	public function getlist()
	{
		$nodelist = $this->mod->getnodelist();
		$this->assign('data',$nodelist);
	}
	//新增结点
	public function add()
	{
		$this->mod->nodeadd();
		echo json_encode(array('type'=>'ajaxcontent','url'=>'sys/picknode/?app.html'));
	}
	//读取结点
	public function getnode()
	{
		$d = $this->mod->nodesummary($_GET['id']);
		$this->assign('info',$d);
		$this->assign('data',json_encode($d));
	}
	//修改结点
	public function edit()
	{
		$this->mod->nodeedit($_GET['id']);
		echo json_encode(array('type'=>'ajaxcontent','url'=>'sys/picknode/?app.html'));
	}
	//删除结点
	public function del()
	{
		$ids = !empty($_GET['id'])?$_GET['id']:$_POST['ids'];
		$this->mod->nodedel($ids);
	}
	//测试结点
	public function testpnode()
	{
		$info = $this->mod->nodesummary($_GET['id']);
		$url = str_replace("(*)",$info['page_start'],$info['website']);
		$fg = http_get_contents($url,$info['timeout']);
		if($fg){
			$fg = mb_convert_encoding($fg,"UTF-8",$info['codetype']);
			if($info['picktype']=='0'){//DOM
				$html = str_get_html($fg);
				$data = $html->find($info['domfind']);
				$nodeinfo = array();
				foreach($data as $e)
					$nodeinfo[] = $e->innertext.'['.$e->href.']';
				$resinfo = join("\n",$nodeinfo);
				$html->clear();//清除内存
			}else{//字符匹配
				$fg = preg_replace("/".preg_quote($info['area_start'],"/")."/im","<%Search_body_start%>",$fg);
				$fg = preg_replace("/".preg_quote($info['area_end'],"/")."/im","<%Search_body_end%>",$fg);
				preg_match("/<%Search_body_start%>(.*)<%Search_body_end%>/isU", trim($fg), $res);
				$resinfo = htmlspecialchars($res[1]);
			}
			$this->assign('nodeareainfo',$resinfo);
			$this->assign('nodeinfo','测试正常');
		}else{
			$this->assign('nodeinfo','连接无效');
		}
	}
	//选择组件实例
	public function getlivs()
	{
		$d = $this->mod->getcomplivs();
		$this->assign('livs',$d);
	}
	//读取对应的分类标识
	public function getlivtypes()
	{
		$d = $this->mod->getlivtypes($_GET['id']);
		$this->assign('typeidarr',$d);
	}
	//读取设置信息
	public function getsetoutinfo()
	{
		$d = $this->mod->nodesummary($_GET['id']);
		$this->assign('info',$d);
		$fd = $this->mod->getfields($d['livid']);
		foreach($fd as $k=>$v){
			$fd[$k]['fdpickype'] = $this->mod->getfdpicks($_GET['id'],$v['name']);
		}
		$this->assign('fieldlist',$fd);
		$data = $this->mod->getoutdata($_GET['id']);
		$this->assign('datainfo',json_encode($data));
	}
	//保存导出设置
	public function outsave()
	{
		$this->mod->savesetinfo($_GET['nodeid'],$_GET['fieldname']);
		echo json_encode(array('type'=>'msg','msg'=>($_POST['istype']==1?'导入栏目保存':'['.$_POST['fdsucname'].']').'设置保存成功!'));
	}
	//删除保存设置
	public function outsetdel()
	{
		$this->mod->delsetinfo($_GET['nodeid'],$_GET['fieldname']);
	}
	//采集数据
	public function pickdata()
	{
		$info = $this->mod->nodesummary($_GET['id']);
		if(strpos($info['website'],'(*)') && $info['page_start'] > 0 && $info['page_end']>0){//多个列表页面
			echo $info['page_start'];
		}else{ //单个
			$this->pickpagesim($info);
		}
	}
	//采集多页
	public function pickmore()
	{
		$nextpi = $_POST['curpn']+1;
		if($nextpi<=$_POST['page_end']){
			$info = $this->mod->nodesummary($_GET['id']);
			$info['website'] = str_replace("(*)",$_POST['curpn'],$info['website']);
			$this->pickpagesim($info);
			echo $nextpi;
		}
	}
	//解析单页
	private function pickpagesim($info)
	{
		$url = $info['website'];
		$fg = http_get_contents($url,$info['timeout']);
		if($fg){
			$fg = $info['codetype']!='UTF8'?mb_convert_encoding($fg,"UTF-8",$info['codetype']):$fg;
			if($info['picktype']=='0'){//DOM
				$html = str_get_html($fg);
				$data = $html->find($info['domfind']);
				$nodeinfo = array();
				foreach($data as $e){
					if($e->innertext!='' && $e->href!=''){
						$this->mod->nodecache($_GET['id'],array('title'=>strip_tags($e->innertext),'links'=>$e->href));
					}
				}
			}else{//字符匹配
				$fg = preg_replace("/".preg_quote($info['area_start'],"/")."/im","<%Search_body_start%>",$fg);
				$fg = preg_replace("/".preg_quote($info['area_end'],"/")."/im","<%Search_body_end%>",$fg);
				preg_match("/<%Search_body_start%>(.*)<%Search_body_end%>/isU", trim($fg), $res);
				//读取该结点下的连接的地址和标题
				preg_match_all("/<a(.+)href=\"(.*)\"(.*)>(.*)<\/a>/isU", $res[1], $listarr); //正规连接有引号的
				$links = $listarr[2]; $titles = $listarr[4];
				if(empty($links)){//匹配 不规则的网站，连接无引号
					preg_match_all("/<a(.+)href=(.*)(\s+)(.*)>(.*)<\/a>/isU", $res[1], $listarr);
					$links = $listarr[2]; $titles = $listarr[5];
				}
				$links = array_unique($links); //过滤相同的连接
				for($i=0;$i<count($links);$i++){
					$title = strip_tags($titles[$i]);
					$links[$i] = str_replace("'","",$links[$i]); //去掉单引号
					$links[$i] = str_replace("\"","",$links[$i]); //去掉双引号
					if(!empty($title) && !empty($links[$i])){
						if(strtolower(substr($links[$i],0,7)) == "http://"){ //目标连接为绝对连接
							$linkstr = $links[$i];
						}else if(substr($links[$i],0,1) == "/"){ //目标连接为相对网站绝对连接
							$urlarr = parse_url($url);
							$linkstr = "http://".$urlarr['host'].$links[$i];
						}else{ //目标连接为相对网站相对连接
							$urlarr = pathinfo($url);
							$linkstr = $urlarr["dirname"].'/'.$links[$i];
						}
						$this->mod->nodecache($_GET['id'],array('title'=>strip_tags($titles[$i]),'links'=>$linkstr));
					}
				}
			}
		}
	}
}
?>