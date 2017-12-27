<?php
/**
 * 相关处理
 */
class FunMod extends Model
{
	public function FunMod()
	{
		$this->Model();
	}

	// 我要投资提交
	public function addition()
	{
		if (isset($_POST['submit'])) {
			// 判断产品年限
			if (empty($_POST['nian'])) {
	  	  	  echo '<script>alert("必须选择年限")</script>';
	  	  	  echo "<script>history.go(-1);</script>";
	  	      exit();
			}
			// 判断产品项目
			if (empty($_POST['project'])) {
				echo '<script>alert("必须选择项目");</script>';
				echo "<script>history.go(-1);</script>";
				exit();
			}
			// 判断产品名称
			if (empty($_POST['title'])) {
				echo '<script>alert("必须选择名称");</script>';
				echo "<script>history.go(-1);</script>";
				exit();
			}
			// 判断产品数量
			if (empty($_POST['num'])) {
				echo '<script>alert("数量不能为空");</script>';
				echo "<script>history.go(-1);</script>";
				exit();
			}
			// 判断产品单价
			if (empty($_POST['price'])) {
				echo '<script>alert("单价不能为空");</script>';
				echo "<script>history.go(-1);</script>";
				exit();
			}
			// 判断联系人
			if (empty($_POST['name'])) {
				echo '<script>alert("联系人不能为空");</script>';
				echo "<script>history.go(-1);</script>";
				exit();
			}
			// 判断联系电话
			if (!isset($_POST['tel']) || !is_numeric($_POST['tel']) || mb_strlen($_POST['tel']) > 11 || empty($_POST['tel'])) {
	  	  	  echo '<script>alert("电话不合法")</script>';
	  	  	  echo "<script>history.go(-1);</script>";
	  	      exit();
			}
			// 判断备注说明
			if (empty($_POST['instructions'])) {
	  	  	  echo '<script>alert("备注说明不能为空")</script>';
	  	  	  echo "<script>history.go(-1);</script>";
	  	      exit();
			}
			

		// 过滤
		$items['nian']=htmlspecialchars($_POST['nian']);
		$items['project']=htmlspecialchars($_POST['project']);
		$items['title']=htmlspecialchars($_POST['title']);
		$items['num']=htmlspecialchars($_POST['num']);
		$items['price']=htmlspecialchars($_POST['price']);
		$items['name']=htmlspecialchars($_POST['name']);
		$items['tel']=htmlspecialchars($_POST['tel']);
		
		$items['instructions']=htmlspecialchars($_POST['instructions']);
		$items['user']=htmlspecialchars($_POST['user']);
		$items['pubdate']=htmlspecialchars($_POST['pubdate']);
		$_POST['__typeid']='226';
		$items['__typeid']=htmlspecialchars($_POST['__typeid']);
		$items = $this->get_fields('cn_yqtj');

		$this->insert('cn_yqtj',$items);
		}
	}

}