<?php
/**
 * Created by PhpStorm.
 * User: Yeyuhang
 * Date: 2016/11/25
 * Time: 15:48
 */
require "GoogleAuthenticator.php";
require_once("config.php");
require_once("httpUtil.php");
if($_POST["login"]){
	$ga = new PHPGangsta_GoogleAuthenticator();
	$account = $_POST["account"];
	$password = $_POST["password"];
	{
		$db = mysqli_connect('**数据库地址**'.':'.'***数据库端口***','***account***','****account key*****','**数据库名称**');
		if ($db) {
			$sql="select * from user where user_name = '".$account."' and password = '".$password."'";
			$result = mysqli_query($db,$sql);
			$rows = mysqli_num_rows($result);
			$row = $result->fetch_assoc();
			if($rows) {
				if ($row[ 'secert' ] == '') {
					$secert = $ga->createSecret();
					$sql = "update user set secert = '$secert' where user_name = '$account'";
					mysqli_real_query($db,$sql);
				}
				else{
					$secert = $row['secert'];
					$oneCode = $ga->getCode($secret);
					/**
					 * url中{function}/{operation}?部分
					 */
					$funAndOperate = "industrySMS/sendSMS";
					$body = createBasicAuthData();
					$one = 1;
					$content = "【计143信息安全】您的二次认证的验证码为".$oneCode."，验证码".$one."分钟内有效";
					$body['smsContent'] = $content;
					$phone = $row['phone'];
					$body['to'] = $phone;
					$result = post($funAndOperate, $body);
//					echo("<br/>result:<br/><br/>");
//					var_dump($result);
					echo "监测到用户开启了二次验证，请输入手机收到的短信验证码：";
					echo "<form action='login2.php' method='post' enctype='multipart/form-data'>";
					echo "<input type='text' name='confirm' value='请输入手机验证码' required='required'>";
					echo "<input type='submit' name='sure' value='确定'>";
					echo "<input type='reset' name='can' value='取消'>";
					echo "</form>";
		}
			}
			else{
				echo "<script>";
				echo "alert('用户名或密码错误,请重新输入')";
				echo "</script>";
			}
		}
		//寻找到此账号下的Secret，若不存在则创建
		//通过时间戳及算法获取6位数字
	}
	$password2 = $_POST["password"];
}

?>