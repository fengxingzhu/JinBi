<?php
/**
 * 操作日志
 */
class DataAct extends Action
{
	private $mod = '';
	public function DataAct()
	{
		$this->mod = $this->M('Data');
	}
	//读取日志
	public function glist()
	{
		$_GET['page'] = $_POST['page'];
		$page = $this->mod->getlist($_POST['rp']);
		$data = $this->mod->get_all();
		foreach($data as $k=>$v){
			$data[$k]['details'] = '<a class="mx-list-edit" brurl="sys/optlogs/?detail/id/'.$v['id'].'/date/'.date('ym',strtotime($v['optdate'])).'.html" href="javascript:;">详情</a>';
		}
		echo json_encode(array('rows'=>$data,'page'=>$_GET['page'],'total'=>$page['total']));
	}
	//获取数据
	public function getdata()
	{
		$data = $this->mod->getsim($_GET['id'],$_GET['date']);
		$d = unserialize($data['optlogs']);
		$str = array();
		$dlen = count($d);
		for($i=0;$i<$dlen;$i++){
			$str[] = '
				<tr>
					<td width="500" style="text-decoration:underline;">
						第'.($i+1).'条操作信息
					</td>
				</tr>
			';
			foreach($d[$i] as $k=>$v)
			$str[] = '
				<tr>
		          <td width="500">
				    <b>'.$k.':</b>
					<div>　　'.$v.'</div>
				  </td>
		        </tr>
			';
		}
		$_GET['deitaldata'] = join('', $str);
	}
}
?>