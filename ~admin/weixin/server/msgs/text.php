<?php
/**
 * 普通文本消息
 */
class WxText
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
	 * 自动回复
	 * @param string $keyword 关键字
	 */
	private function _autorelpy($keyword)
	{
		$mod = new Model();
		$this->_writemsg();
		$info = $mod->get_row('SELECT * FROM '.DB_MX_PRE.'wx_autoreply WHERE keyword="'.$keyword.'"');
		if(!empty($info)){
			wx_reply_text($this->_msg,$info['reply']);//自动回复内容
		}
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
		$_POST['msgid'] = $this->_msg->MsgId;
		$fields = $mod->get_fields(DB_MX_PRE.'wx_msgs');
		$mod->insert(DB_MX_PRE.'wx_msgs',$fields);
	}
	/**
	 * 消息处理
	 */
	public function deal()
	{
		$this->_autorelpy($this->_msg->Content);
	}
}
?>