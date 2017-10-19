<?php
/***************************************************************************
 * 
 * Copyright (c) 2015 365qian.com, Inc. All Rights Reserved
 * 
 **************************************************************************/
 
 
 
/**
 * @file ApiUtil.php
 * @author zhanglong(zhanglong@365qian.com)
 * @date 2015/11/09 19:24:31
 *  
 **/
class ApiUtil{
    /*
     * http post 发送接口
     *
     */
    static public function http_post($url, $header="", $data , $cookie="",$s=60,$ms="",&$code="",$cerPath="",$keyPath="",$pwd="",$gzip=0) {
        $curl = curl_init($url);
        $out = curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
		if(empty($cerPath)){
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
		}else{
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 只信任CA颁布的证书 
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); //  检查证书中是否设置域名，并且是否与提供的主机名匹配   
			curl_setopt($curl, CURLOPT_SSLCERT, $cerPath);
			curl_setopt($curl, CURLOPT_SSLKEY, $keyPath); //client.crt文件路径
			curl_setopt($curl, CURLOPT_SSLCERTPASSWD, $pwd); //client证书密码
			//curl_setopt($curl, CURLOPT_CAINFO, $cerPath);// CA根证书（用来验证的网站证书是否是CA颁布）  
		}
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
		if(!empty($ms)){
			curl_setopt($curl, CURLOPT_TIMEOUT_MS, $ms); // 连接建立后服务器接收缓冲完成前需要等待的毫秒数，设置超时限制防止死循环
			curl_setopt($curl, CURLOPT_CONNECTTIMEOUT_MS, $ms);//连接建立前等待的毫秒数
			curl_setopt($curl,  CURLOPT_NOSIGNAL,true );//支持毫秒级别超时设置
		}else{
			curl_setopt($curl, CURLOPT_TIMEOUT, $s); // 连接建立后服务器接收缓冲完成前需要等待的秒数，设置超时限制防止死循环
			curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $s);//连接建立前等待的秒数
		}
        if(!empty($header)){
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        }
        if(!empty($cookie)){
            curl_setopt($curl, CURLOPT_COOKIE , $cookie);
            //curl_setopt($curl, CURLOPT_COOKIEFILE , $cookie);
        }
	    if($gzip) curl_setopt($curl, CURLOPT_ENCODING, "gzip"); // 关键在这里
        curl_setopt($curl, CURLOPT_HEADER, 1); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回 -->
		//curl_setopt($curl, CURLOPT_HTTPHEADER,array("Expect:"));
        $res = curl_exec($curl); // 执行操作
		$code = curl_getinfo($curl,CURLINFO_HTTP_CODE);
        if (curl_errno($curl)) {//出错则显示错误信息
            if (curl_getinfo($curl, CURLINFO_HTTP_CODE) == 0) {
                Yii::log("发送超时", "error");
            }
            Yii::log(print_r(curl_getinfo($curl, CURLINFO_HTTP_CODE), true), "error");
            throw new Exception (print_r(curl_error($curl), true));
        }
        curl_close($curl);
        //$res=json_decode($res);
        return $res;
    }

    /*
     * http get发送接口
     *
     */
    static public function http_get($url, $header="" , $cookie="",$s=60,$ms="",&$code="",$cerPath="",$keyPath="",$pwd="",$gzip=0) {
        $curl = curl_init($url);
        $out = curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
		if(empty($cerPath)){
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
		}else{
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 只信任CA颁布的证书 
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); //  检查证书中是否设置域名，并且是否与提供的主机名匹配   
			curl_setopt($curl, CURLOPT_SSLCERT, $cerPath);
			curl_setopt($curl, CURLOPT_SSLKEY, $keyPath); //client.crt文件路径
			curl_setopt($curl, CURLOPT_SSLCERTPASSWD, $pwd); //client证书密码
			//curl_setopt($curl, CURLOPT_CAINFO, $cerPath);// CA根证书（用来验证的网站证书是否是CA颁布）  
		}
		if(!empty($ms)){
			curl_setopt($curl, CURLOPT_TIMEOUT_MS, $ms); // 连接建立后服务器接收缓冲完成前需要等待的毫秒数，设置超时限制防止死循环
			curl_setopt($curl, CURLOPT_CONNECTTIMEOUT_MS, $ms);//连接建立前等待的毫秒数
			curl_setopt($curl,  CURLOPT_NOSIGNAL,true );//支持毫秒级别超时设置
		}else{
			curl_setopt($curl, CURLOPT_TIMEOUT, $s); // 连接建立后服务器接收缓冲完成前需要等待的秒数，设置超时限制防止死循环
			curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $s);//连接建立前等待的秒数
		}
		if($gzip) curl_setopt($curl, CURLOPT_ENCODING, "gzip"); // 关键在这里
        if(!empty($header)){
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        }
        if(!empty($cookie)){
            curl_setopt($curl, CURLOPT_COOKIE , $cookie);
            //curl_setopt($curl, CURLOPT_COOKIEFILE , $cookie);
        }
        curl_setopt($curl, CURLOPT_HEADER, 1); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回 -->
		//curl_setopt($curl, CURLOPT_HTTPHEADER,array("Expect:"));
        $res = curl_exec($curl); // 执行操作
		$code = curl_getinfo($curl,CURLINFO_HTTP_CODE);
        if (curl_errno($curl)) {//出错则显示错误信息
            if (curl_getinfo($curl, CURLINFO_HTTP_CODE) == 0) {
                Yii::log("发送超时", "error");
            }
            Yii::log(print_r(curl_getinfo($curl, CURLINFO_HTTP_CODE), true), "error");
            throw new Exception (print_r(curl_error($curl), true));
        }
        curl_close($curl);
        //$res=json_decode($res);
        return $res;
    }
    /*
     * https get
     *
     *
     */
    public function https_get($url,$header)
    {
        $options = array(
            'https' => array(
                'method' => "GET",//or GET
                'header' => $header,
                'timeout' => 15 * 60 // 超时时间（单位:s）
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return $result;
    }
    /*
     * 根据curl返回结果，去除头部，获取最后一部分body
     *
     */
    static public function httpGetBody($curlRes){
        $dataArr = explode("\n", $curlRes);
        $data = (json_decode($dataArr[count($dataArr)-1]));
        if(empty($data)){
            $dataJsom = substr($dataArr[count($dataArr)-1],strpos($dataArr[count($dataArr)-1],'{'),strrpos($dataArr[count($dataArr)-1],'}')-strlen($dataArr[count($dataArr)-1])+1);
            $data = (json_decode($dataJsom));
        }
        return $data;
    }
    /*
     * 根据curl返回结果，去除头部，获取最后一部分body
     *
     */
    public function httpBody($curlRes){
        $dataArr = explode("\n", $curlRes);
        $data = $dataArr[count($dataArr)-1];
        return $data;
    }
    public function httpArr($curlRes){
        $dataArr = explode("\n", $curlRes);
        return $dataArr;
    }
}
