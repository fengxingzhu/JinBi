<?php
/**
 * 标签管理
 */
class DataAct extends Action
{
	private $tagfile = 'tagdata';
	/**
	 * 获得标签列表
	 */
	public function getlist()
	{
		$data = read_cache_data($this->tagfile);//读取标签信息
		$this->assign('data',$data);
	}
	/**
	 * 新增
	 */
	public function add()
	{
		$data = read_cache_data('tagdata');//读取标签信息
		if($this->exits($_POST['tagname'], $data)){
			$data[] = array('tagname'=>$_POST['tagname'],'tagcontent'=>$_POST['tagcontent']);
			write_cache_data($data,$this->tagfile);
			echo json_encode(array('type'=>'ajaxcontent','url'=>'sys/tagman/?app.html'));
		}else{
			echo json_encode(array('type'=>'msg','msg'=>'标签名有重名,请重新填写'));
		}
	}
	/**
	 * 判断用户名是否重名
	 * @param string $tagname 标签名
	 * @param array $data 标签数组
	 * @param string $n 排除在外的标签名
	 */
	private function exits($tagname,$data,$n='')
	{
		foreach($data as $v){
			if($v['tagname']==$tagname && $v['tagname']!=$n){
				return false;
			}
		}
		return true;
	}
	/**
	 * 获得标签内容
	 */
	public function getdata()
	{
		$data = read_cache_data('tagdata');//读取标签信息
		foreach($data as $v){
			if($v['tagname']==$_GET['tagname']){
				$this->assign('info',$v);
				$this->assign('data',json_encode($v));
				return true;
			}
		}
	}
	/**
	 * 修改标签
	 */
	public function edit()
	{
		$data = read_cache_data('tagdata');//读取标签信息
		if($this->exits($_POST['tagname'], $data,$_POST['tagname'])){
			foreach($data as $k=>$v){
				if($v['tagname']==$_GET['tagname']){
					$data[$k] = array('tagname'=>$_POST['tagname'],'tagcontent'=>$_POST['tagcontent']);
				}
			}
			write_cache_data($data, $this->tagfile);
			echo json_encode(array('type'=>'ajaxcontent','url'=>'sys/tagman/?app.html'));
		}else{
			echo json_encode(array('type'=>'msg','msg'=>'标签名有重名,请重新填写'));
		}
	}
	/**
	 * 删除标签
	 */
	public function del()
	{
		$data = read_cache_data('tagdata');//读取标签信息
		$ndata = array();
		foreach($data as $k=>$v){
			if($v['tagname']!=$_GET['id']){//过滤掉相同的
				$ndata[] = $v;
			}
		}
		write_cache_data($ndata, $this->tagfile);
		echo json_encode(array('type'=>'ajaxcontent','url'=>'sys/tagman/?app.html'));
	}
}
?>