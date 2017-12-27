<?php
/**
 * 微信公用函数
 */
/**
 * 验证URL的有效性
 * @return boolean
 */
function wx_checksignature()
{
	$signature = $_GET ["signature"];
	$timestamp = $_GET ["timestamp"];
	$nonce = $_GET ["nonce"];
	//读取微信配置信息
	$configs = read_cache_data('wx_configs');
	$token = $configs['token'];
	$tmpArr = array (
			$token,
			$timestamp,
			$nonce 
	);
	sort ( $tmpArr, SORT_STRING );
	$tmpStr = implode ( $tmpArr );
	$tmpStr = sha1 ( $tmpStr );
	
	if ($tmpStr == $signature) {
		return true;
	} else {
		return false;
	}
}
/**
 * 返回给微信的文本消息
 * @param object $postObj
 * @param text $msg
 */
function wx_reply_text($postObj,$msg)
{
	$fromUsername = $postObj->FromUserName;
	$toUsername = $postObj->ToUserName;
	$time = time();
	$textTpl = "<xml>
	<ToUserName><![CDATA[%s]]></ToUserName>
	<FromUserName><![CDATA[%s]]></FromUserName>
	<CreateTime>%s</CreateTime>
	<MsgType><![CDATA[%s]]></MsgType>
	<Content><![CDATA[%s]]></Content>
	</xml>";
	$msgType = "text";//消息类型
	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $msg);
	echo $resultStr;
}
/**
 * 获取access_token
 */
function wx_access_token()
{
	$accesstoken = read_cache_data('wx_access_token'); //读取缓存的access token
	if(empty($accesstoken) || time()-$accesstoken['time']>=$accesstoken['expires_in']){//微信的授权token值有效期为7200秒 超时重新申请
		//读取微信配置信息
		$configs = read_cache_data('wx_configs');
		$data = http_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$configs['appid'].'&secret='.$configs['appsecret']);
		$data = json_decode($data,true);//转换为数组
		write_cache_data(array(
			'access_token'=>$data['access_token'],//授权token
			'expires_in'=>$data['expires_in'], //有效时间
			'time'=>time() //当前存储时间
		),'wx_access_token');
		$accesstoken = read_cache_data('wx_access_token');
	}
	return $accesstoken['access_token'];
}
/**
 * 将数组进行urlencode编码
 * @param array $str
 * @return string
 */
function url_encode($str)
{
	if(is_array($str)){
		foreach($str as $k=>$v)
			$str[urlencode($k)] = url_encode($v);
	}else{
		$str = urlencode($str);
	}
	return $str;
}
/**
 * 将数组进行url编码后再解码 防止中文被编码
 * @param array $arr
 * @return string
 */
function encode_json($arr)
{
	return urldecode(json_encode(url_encode($arr)));
}
/**
 * 推送信息
 * @param string $url 网站地址
 * @param array $data 提交数据
 */
function wx_post_contents($url,$data)
{
	$data = encode_json($data);
	if(function_exists("curl_init")){
		$https = curl_init();
		curl_setopt($https, CURLOPT_URL, $url);
		curl_setopt($https, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($https, CURLOPT_POSTFIELDS, $data);
		$file_contents = curl_exec($https);
		curl_close($https);
		return $file_contents;
	}else{
		$opts = array(
		  'http'=>array(
		    'method'	=>	"POST",
		  		'content' 	=> 	$data,
		  )
		);
		$context = stream_context_create($opts);
		return file_get_contents($url,false,$context);
	}
}
/**
 * 微信端口测试
 * @param mixed $msg
 */
function wx_debug($msg)
{
	$data = is_array($msg)?var_export($msg,TRUE):$msg;
	$data = 'WX DEBUG -- start --'.PHP_EOL.$data.PHP_EOL.'-- end --'.PHP_EOL;
	file_put_contents(WEB_ROOT.'data/wx_debug.txt',$data,FILE_APPEND);
}
?>