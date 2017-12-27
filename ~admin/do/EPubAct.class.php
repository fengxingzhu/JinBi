<?php
/**
 * 公共应用
 */
class EPubAct extends Action
{
	private $userinfo = '';
	private $startmstr = '';
	private $menuid = 0;
	public function EPubAct()
	{
		$this->userinfo = Cache::session_get("MXUSER_INFO");
	}
	/**
	 * top tabs
	 */
	public function tabs()
	{
		$m = $this->M('EPub');
		$tabs = $m->getabs($this->userinfo);
		$this->assign('TABS',$tabs);
	}
	//读取当前站点信息
	public function getwebsite()
	{
		$website = read_cache_data('mx_website');
		if(empty($website)){
			$this->assign('WEBSITENAME','默认站点(用户 :'.$this->userinfo['username'].')');
		}else{
			$website = read_cache_data('mx_website');
			foreach ($website as $list){
				if($list['tag'] == $this->userinfo['langtp']){
					$this->assign('WEBSITENAME',$list['webname'].'(用户 :'.$this->userinfo['username'].')');
				}
			}
		}
		$d = read_cache_data('mx_admin_headfoot');
		$this->assign('webinfo',$d);
	}
	/**
	 * left tree
	 */
	public function leftree()
	{
		$pid = $_GET['PARENT_pid'];
		$m = $this->M('EPub');
		$pname = $m->getabsname($pid);
		$this->assign('__TABNAME',$pname);
		$this->tabtreemenu($pid);
		$this->assign('__TREELIST',$this->startmstr);
	}
	/**
	 * 递归读取下级菜单
	 */
	private function tabtreemenu($pid)
	{
		$m = $this->M('EPub');
		$allmenu = $m->getallmenu($this->userinfo);
		$this->recursionmenu($allmenu,$pid);
	}
	//递归读取菜单
	private function recursionmenu($m,$pid = 0)
	{
		$this->menuid++;
		foreach ($m as $key=>$val){
			if($val['parent_id'] == $pid){
				$url = empty($val['admurl'])?'':'url="'.$val['admurl'].'"';
				//生成树
				if($val['sonum'] == 0){ //无子节点
					$this->startmstr .= '<li><span class="file"><a href="javascript:;" '.$url.' treeid="'.$this->menuid.'" mid="'.$val['id'].'">'.$val['title'].'</a></span></li>';
					unset($m[$key]);
					$this->recursionmenu($m, $val['id']);
				}else { //有子节点
					$this->startmstr .= '
					<li class="open">
						<span class="folder"><a href="javascript:;" '.$url.' treeid="'.$this->menuid.'" mid="'.$val['id'].'">'.$val['title'].'</a></span>
						<ul>';
					unset($m[$key]);
					$this->recursionmenu($m, $val['id']);
					$this->startmstr .= '
						</ul>
					</li>';
				}
			}
		}
	}
	//读取登录日志
	public function loglogins()
	{
		$m = $this->M('EPub');
		$d = $m->logsdata($this->userinfo['id']);
		$this->assign('logdata',$d);
	}
	//最大文件大小
	public function upfileinfo()
	{
		$data = read_cache_data('mx-filesizemax');
		if(empty($data)){
			$data['size'] = UPLOAD_MAXSIZE;
		}
		$m = $this->M('EPub');
		$filters = $m->readfilters();
		$filtarr = array();
		foreach($filters as $list){
			array_push($filtarr,array('title'=>$list['ftype'],'extensions'=>$list['exts']));
		}
		$this->assign('maxsizeinfo',intval($data['size']));
		$this->assign('filtersjson',json_encode($filtarr));
		$this->assign('filters',$filters);
	}
	//全局
	public function globalinfo()
	{
		$m = $this->M('EPub');
		$this->assign('OS',PHP_OS);
		$this->assign('php',phpversion());
		$this->assign('mysql',$m->getmysqlversion());
		$version = function_exists("apache_get_version")?apache_get_version():'未知';
		$this->assign('apache',$version);
		//MX版本号
		$this->assign('version',MX_VERSION);
	}
	//得到后台头和尾信息 以及主题信息
	public function gethfinfo()
	{
		$d = read_cache_data('mx_admin_headfoot');
		if(empty($d)){
			$d = array(
				'head'	=>	'MX '.MX_VERSION,
				'foot'	=>	SYS_FOOTER_URL==''?'MX '.MX_VERSION:'<iframe src="'.SYS_FOOTER_URL.'" scrolling="no" frameborder="0" height="30px;" width="100%"></iframe>'
			);
			write_cache_data($d,'mx_admin_headfoot');
		}
		$this->assign('webinfo',$d);
		//主题
		$theme = $this->userinfo['theme'];
		$theme = empty($theme)?'green':$theme;
		$this->assign('THEME',$theme);
	}
}
?>