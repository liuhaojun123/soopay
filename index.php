<?php
 require_once('ApiUtil.php');
 
 $userId = 1;
 $bankCode = 'CMB';
 $paymentNo = '6214830297315292';
 $identityNo = '612501198603248992';
 $name = '刘号军';
 $mob = '15029489160';
 $amount = '0.01';
 
 $url = "http://api.ctigood.com/api/mall/recharge?userId=$userId&bankCode=$bankCode&paymentNo=$paymentNo&identityNo=$identityNo&name=$name&mob=$mob&amount=$amount";
 
 $res = ApiUtil::http_get($url);
 
 $res = ApiUtil::httpGetBody($res);
 
 $redirect_url = $res->data->redirect;
 
 header('location: '.$redirect_url);
 
 die();
 
?>