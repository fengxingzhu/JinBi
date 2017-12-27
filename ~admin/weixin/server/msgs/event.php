<?php
/**
 * 事件消息处理
 */
class WxEvent
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
	 * 关注微信时 可以做欢迎，或者目录说明
	 */
	private function _subscribe()
	{
		$configs = read_cache_data('wx_configs');
		//加入到关注列表
		$mod = new Model();
		$_POST['dev_openid'] = $this->_msg->ToUserName;
		$_POST['openid'] = $this->_msg->FromUserName;
		$userinfo = $this->_getuserinfo($_POST['openid']);
		$_POST['nickname'] = $userinfo['nickname'];
		$_POST['sex'] = $userinfo['sex'];
		$_POST['province'] = $userinfo['province'];
		$_POST['city'] = $userinfo['city'];
		$_POST['country'] = $userinfo['country'];
		$_POST['headimgurl'] = $userinfo['headimgurl'];
		$fields = $mod->get_fields(DB_MX_PRE.'wx_user',array('createtime'));
		$mod->insert(DB_MX_PRE.'wx_user',$fields);
		wx_reply_text($this->_msg,$configs['subscribe']);
	}
	/**
	 * 获取用户信息
	 * @param string $openid 用户的openid
	 */
	private function _getuserinfo($openid)
	{
		$data = http_get_contents('https://api.weixin.qq.com/cgi-bin/user/info?access_token='.wx_access_token().'&openid='.$openid.'&lang=zh_CN');
		return json_decode($data,true);
	}
	/**
	 * 取消订阅时 作解除绑定操作
	 */
	private function _unsubscribe()
	{
		$mod = new Model();
		$tousername = $this->_msg->ToUserName; //微信开发者信息
		$fromusername = $this->_msg->FromUserName; //发送者OpenID
		$mod->delete(DB_MX_PRE.'wx_user','dev_openid="'.$tousername.'" AND openid="'.$fromusername.'"');//解除绑定
	}
	/**
	 * 上报地理位置事件
	 */
	private function _LOCATION()
	{
		
	}
	/**
	 * 消息处理
	 */
	public function deal()
	{
		$method = '_'.$this->_msg->Event;
		if(method_exists('WxEvent', $method))//查看类方法是否存在
			$this->$method();
	}
}
?>