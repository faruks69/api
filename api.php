<!DOCTYPE html>
<html lang="en">

<?php 
session_start();
$name= $_POST['name'];
$phone = $_POST['phone'];
$offer_id = '30965'; //ID of offer*
$api_key = 'b74f2569d5168980e7442fea8deefd07'; //API key*
$country_code = 'MX'; //GEO*
$base_url = 'https://cod.incasolic.one/'; //url of your landing page
$price = '780'; //Price of product (it can be found on landing page in AdCombo)*
$referrer = 'google.com'; //Link from where visitor came to your landing page
$ip = $_SERVER['REMOTE_ADDR'];  //IP address of visitor of the landing page
$subacc = $_POST['subacc']; /*value from subaccount fileds - 
if you want to add something there --> add a hidden field to your form*/


const API_URL = "https://api.adcombo.com/api/v2/order/create/";
const API_KEY = "";
$isCurlEnabled = function(){
    return function_exists('curl_version');
};
if (!$isCurlEnabled) {
    echo "<pre>";
    echo "pls install curl\n";
    echo "For *unix open terminal and type this:\n";
    echo 'sudo apt-get install curl && apt-get install php-curl';
    die;
}




$args = [
    'api_key' =>$api_key,
    'name' => $name,
    'phone' => $phone,
    'offer_id' => $offer_id,
    'country_code' => $country_code,
    'price' => $price,
    'base_url' => $base_url,
    'ip' => $ip,
    'referrer' => $referrer ,
    'subacc' => $subacc,
    
    ];
$url = API_URL.'?'.http_build_query($args);
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true
));
$res = curl_exec($curl);
curl_close($curl);
$res = json_decode($res, true);
if ($res['code'] == 'ok') {
    

   $_SESSION['printname']= $name;
   $_SESSION['printphone']=$phone;
    
    header ("Location: thanks.html"); /*to show success page - if you remove this line, ID of order will be shown.*/
    echo $res['msg'] . ": " . $res['order_id'];
    echo $url;
} else {
    echo $res['error'];
}

