<?php
/**
 * 图片消息
 */
class WxVoice
{
	//微信提交的数据对象
	private $_msg = null;
	/**
	 * 初始化处理
	 * @param object $msg
	 */
	public function __construct($msg)
	{
		$this->_msg = $msg;
	}
	/**
	 * 写入消息
	 */
	private function _writemsg()
	{
		$mod = new Model();
		//写入消息
		$mod = new Model();
		$_POST['dev_openid'] = $this->_msg->ToUserName;
		$_POST['openid'] = $this->_msg->FromUserName;
		$_POST['createtime'] = $this->_msg->CreateTime;
		$_POST['msgtype'] = $this->_msg->MsgType;
		$_POST['content'] = $this->_msg->Content;
		$_POST['format'] = $this->_msg->Format;
		$_POST['mediaid'] = $this->_msg->MediaId;
		$_POST['msgid'] = $this->_msg->MsgId;
		$fields = $mod->get_fields(DB_MX_PRE.'wx_msgs');
		$mod->insert(DB_MX_PRE.'wx_msgs',$fields);
	}
	/**
	 * 消息处理
	 */
	public function deal()
	{
		$this->_writemsg();
	}
}
?>