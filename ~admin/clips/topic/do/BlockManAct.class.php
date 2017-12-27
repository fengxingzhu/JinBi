<?php
/**
 * 版块管理
 */
class BlockManAct extends Action
{
	/**
	 * 数据库对象
	 * @var res
	 */
	private $mod = '';
	/**
	 * 构造函数
	 */
	public function BlockManAct()
	{
		$this->mod = $this->M('BlockMan');
	}
	/**
	 * 获取对应的版块信息
	 */
	public function getatmods()
	{
		$data = $this->mod->getblocks($_GET['pid']);
		return $data;
	}
	/**
	 * 获取表单的版块信息
	 */
	public function getbfinfo()
	{
		//专题信息
		$info = $this->mod->gettopic($_GET['pid']);
		$this->assign('info',$info);
		//版块信息
		$block = $this->mod->getblockinfo($_GET['id']);
		$this->assign('block',$block);
		//版块模板信息
		$efkey = explode(',',$block['field_key']); //查看需要的字段
		$ds = array();
		for($i=0;$i<6;$i++){
			$ds[$i] = in_array((string)$i, $efkey)?'block':'none';
		}
		//字段是否显示信息
		$this->assign('fieldsv',$ds);
		//数据处理
		$data = empty($info['data'])?array():unserialize($info['data']);
		$tagdata = isset($data[$block['id']])?$data[$block['id']]:array();
		if(empty($tagdata)){//无数据
			$block_nums = $block['editnum']==0?1:$block['editnum'];
		}else{//有数据
			$block_nums = $block['editnum']==0?count($tagdata):$block['editnum'];
		}
		$block['picimg'] = empty($block['picimg'])?'0,0,0':$block['picimg'];//如果没有设置宽和高时，则不限制宽和高
		$wh = preg_split('/\r\n/',$block['picimg']);
		//计算第一行的  通用的
		$firstwh = explode(',',$wh[0]);
		$whlen = count($wh);
		$whdata = array();
		for($i=0;$i<$block_nums;$i++){
			//判断图片大小
			if($block['editnum']==0){//如果不限制个数，则只取第一个宽和高,并且所有的宽和高都是一样的
				$whdata[] = array('width'=>$firstwh[1],'height'=>$firstwh[2]);
			}else{
				for($h=0;$h<$whlen;$h++){
					$owh = explode(',',$wh[$h]);
					if($i==$owh[0]){//设置的行与当前行一致，输出当前设置的图片的宽和高
						$whdata[] = array('width'=>$owh[1],'height'=>$owh[2]);
					}else{//否则都以相同的宽和高处理
						$whdata[] = array('width'=>$firstwh[1],'height'=>$firstwh[2]);
					}
				}
			}
		}
		$this->assign('block_nums',$block_nums);
		$this->assign('data',$tagdata);
		$this->assign('whinfo',$whdata);
	}
	/**
	 * 保存版块信息
	 */
	public function edit()
	{
		//结果集
		$res = array();
		//保存数据组装
		$delarr = explode(',',$_POST['editdel']);
		for($i=0;$i<$_POST['editnum'];$i++){
			if(!in_array((string)$i, $delarr)){
				$res[] = array(
					'title'		=>	$_POST['title_'.$i.''],
					'link'		=>	$_POST['link_'.$i.''],
					'pic'		=>	$_POST['pic_'.$i.''],
					'pic_path'	=>	$_POST['pic_path_'.$i.''],
					'intro'		=>	$_POST['intro_'.$i.''],
					'author'	=>	$_POST['author_'.$i.''],
					'date'		=>	$_POST['date_'.$i.'']
				);
			}
		}
		//读取对应专题的data
		$info = $this->mod->gettopic($_GET['pid']);
		$data = $info['data'];
		$data = empty($data)?array():unserialize($data);
		//读取版块信息
		$block = $this->mod->getblockinfo($_GET['id']);
		$data[$block['id']] = $res;
		//写入结果集中
		$this->mod->edittopicdata($_GET['pid'],$data);
		echo json_encode(array('type'=>'ajaxcontent','url'=>'clips/topic/?frtview/pid/'.$_GET['pid'].'.html'));
	}
}
?>