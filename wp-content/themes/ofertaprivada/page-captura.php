<?php
error_reporting(E_ALL);
require_once('inc/webpay/libwebpay/webpay.php');
if ($_GET && $_GET["blog_id"]) {
	switch_to_blog($_GET["blog_id"]);

	$asd =  new WC_Gateway_Transbank;
	var_dump($asd->settings["webpay_test_mode"],get_current_blog_id());

	
	echo "Hola";


	$configuration = new configuration();
	$configuration->setEnvironment($asd->settings["webpay_test_mode"]);
	$configuration->setCommerceCode($asd->settings["webpay_commerce_code"]);
	$configuration->setPrivateKey($asd->settings["webpay_private_key"]);
	$configuration->setPublicCert($asd->settings["webpay_public_cert"]);
	$configuration->setWebpayCert($asd->settings["webpay_webpay_cert"]);
	echo "Hola2";
	$webpay = new Webpay($configuration);
	echo "Hola3";
	if ($_GET["authorizationCode"] && $_GET["captureAmount"] && $_GET["buyOrder"]) {
		$authorizationCode = $_GET["authorizationCode"];
		$captureAmount = $_GET["captureAmount"];
		$buyOrder = $_GET["buyOrder"];
		$result = $webpay->getCaptureTransaction()->capture($authorizationCode, $captureAmount, $buyOrder); 
		echo json_encode($result);
	}

	restore_current_blog();
}