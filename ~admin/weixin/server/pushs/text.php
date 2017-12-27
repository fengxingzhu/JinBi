<?php
/**
 * 推送普通文本消息
 */
class WxText
{
	/**
	 * 初始化处理
	 */
	public function __construct()
	{
	}
	/**
	 * 消息写入到数据库
	 */
	private function _writedb()
	{
		$mod = new Model();
		//保存到数据库
		$mod = new Model();
		$_POST['msgtype'] = 'text';
		$mod->insert(DB_MX_PRE.'wx_pushmsgs',array('openid','msgtype','content'));
	}
	/**
	 * 发送给指定的粉丝
	 * @param string $openid 粉丝的openid
	 * @param string $content 发送的内容
	 */
	private function _pushfans($openid,$content)
	{
		$res = wx_post_contents('https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.wx_access_token(), 
			array(
				'touser'=>$openid,
				'msgtype'=>'text',
				'text'	=>	array(
							'content'	=>	$content
						)
			)
		);
		wx_debug($res);
	}
	/**
	 * 消息处理
	 */
	public function deal()
	{
		$this->_writedb();
		$mod = new Model();
		if(empty($_POST['openid'])){//推送给全部粉丝
			$fans = $mod->get_all('SELECT * FROM '.DB_MX_PRE.'wx_user ORDER BY createtime DESC');
			foreach($fans as $v){
				$this->_pushfans($v['openid'],$_POST['content']);//发送给指定粉丝
			}
		}else{
			$this->_pushfans($_POST['openid'],$_POST['content']);//发送给指定粉丝
		}
		echo json_encode(array('type'=>'ajaxcontent','url'=>'weixin/?pushmsgs.html'));
	}
}
?>