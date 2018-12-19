<?php
/*
 * Plugin Name: Skip Payment Screen
 * Version: 1.0
 * Plugin URI: http://www.grupo-sgd.com/
 * Author: Grupo Sgd
 * Description: Permite redireccionar de manera inmediata a la primera opcion de pago.
 * Author URI: http://www.grupo-sgd.com/
 */
if ( ! defined( 'ABSPATH' ) ) exit;


class SkipPaymentScreen{

	function add_script(){
		return wp_enqueue_script('SkipPaymentScreen', plugins_url('skip-payment-screen/assets/script.js'), array('jquery'));
	}

	function add_loading_css(){
		return wp_enqueue_style('loading-css', plugins_url('skip-payment-screen/assets/jquery-loading-master/loading.css'));
	}
	function add_loading_script(){
		return wp_enqueue_script('loading-script', plugins_url('skip-payment-screen/assets/jquery-loading-master/loading.js'), array('jquery'));

	}

}

$skip = new SkipPaymentScreen();
add_action('woocommerce_receipt_transbank', array($skip, 'add_loading_script'));
add_action('woocommerce_receipt_transbank', array($skip, 'add_loading_css'));
add_action('woocommerce_receipt_transbank', array($skip, 'add_script'));
