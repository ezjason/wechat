# wechat
微信开发图灵机器人
注册一个新浪云服务器
「新浪云福利」1000云豆免费领！低成本，免运维，灵活，安全稳定，轻松应对业务爆发式增长，一起来用吧！
注册地址：http://t.cn/RiszfOK

1,在新浪云控制台云应用SAE中的应用管理的+创建应用
    选择PHP 
    运行环境 ：标准环境
    语言版本：^5.6
    代码管理 SVN（GIT）
    应用信息-》二级域名：（填写后）-》创建
    
2， 下载一个 TortoisesSVN  64位或32位的管理工具   安装
3，创建一个PHP文件wx_sample0.php
  内容：
        <?php
/**
  * wechat php test
  */

//define your token
define("TOKEN", "weixin");
$wechatObj = new wechatCallbackapiTest();
//$wechatObj->valid();
if (isset($_GET['echostr'])) {
    $wechatObj -> valid();
} else {
    $wechatObj -> responseMsg();
}

class wechatCallbackapiTest
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
            header('content-type:text');
        	echo $echoStr;
        	exit;
        }
    }

    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
                libxml_disable_entity_loader(true);
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $time = time();
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";             
				if(!empty( $keyword ))
                {
              		$msgType = "text";
                    
                    if($keyword=="老肥"){
                    	$contentStr = "不能因为我好看就欺负我，你个丑八怪。江东第一少在此";
                		$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                		echo $resultStr;
                    }else{
                    		$apiKey = "dfe064f3a5af4fd1a9ec31cc597e3b84";
                        $apiURL = "http://www.tuling123.com/openapi/api?key=KEY&info=INFO";
                        $reqInfo = $keyword;
                        $url = str_replace("INFO", $reqInfo, str_replace("KEY", $apiKey, $apiURL));
                        $res = file_get_contents($url);
                        $contentStr = json_decode($res)->text;
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                        echo $resultStr;
                    }
                }else{
                	echo "Input something...";
                }

        }else {
        	echo "";
        	exit;
        }
    }
		
	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}

?>
然后远程SVN checkout到你的新浪云地址https://svn.sinacloud.com/jason53406    也就是在你创建的仓库那里的
应用选项--》代码管理    -》SVN仓库地址
4，註冊一個微信公众号
  1，选择开发 -》基本配置
      URL   http://1.jason53406.applinzi.com/wx_sample.php
      Token  weixin
      EncodingAESKey （可以自动生成）
      明文模式
   2，开启服务配置
   
   
   搞定！！！
