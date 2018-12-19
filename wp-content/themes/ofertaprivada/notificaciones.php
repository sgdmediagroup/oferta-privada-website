<?php
define('TIMEZONE', 'America/Santiago');
date_default_timezone_set(TIMEZONE);
$current_client = get_current_blog_id();
switch_to_blog(1);
$hora_notificaciones = get_field('hora_notificaciones','options');
$hora_cierre = get_field('hora_cierre','options');
$emails = array('notificacion','aceptacion','rechazo');
restore_current_blog();
// FECHAS

// TABLE CONSTRUCTOR
function table_start() {
	echo '<table id="table-pedidos" class="table wp-list-table widefat fixed striped posts"><thead><th width="30">ID</th><th>Producto</th><th align="right" width="75">Oferta</th><th align="right" width="75">Mínimo</th><th align="right" width="75">Diferencia</th><th align="center" width="130">Estado</th></thead><tbody>';
}
function table_rows($order) {
	echo '<tr>';
	echo '<td>'.$order->id.'</td>';	
	$items = $order->get_items();
	foreach ( $items as $item ) {
		echo '<td>'.$item->get_name().' (ID: '.$item->get_product_id().')</td>';
		echo '<td align="right">'.dinero($item->get_subtotal()/$item->get_quantity()).'</td>';
	}
	echo '<td align="right">'.dinero(get_field('op_pm',$order->id)).'</td>';
	echo '<td align="right">'.dinero(get_field('op_dif',$order->id)).'</td>';
	echo '<td align="center">'.wc_get_order_status_name($order->status).'</td></tr>';
}
function table_end() {
	echo '</tbody></table><br>';
}

$args = array('status'=>array('aceptada'));		
$orders = wc_get_orders( $args );
if($orders) {
	if(current_user_can('manage_options')) { table_start(); }
	foreach($orders as $order) {
		if(isset($_GET['send'])) {
			$items = $order->get_items();
			foreach($items as $i) {
				$item = $i;
			}
			$to = $order->get_billing_email();
			$headers[] = 'From: '.get_bloginfo( 'name' ).' <'.get_option( 'woocommerce_email_from_address' ).'>';
			$headers[] = 'Content-Type: text/html; charset=UTF-8';
			$site = get_bloginfo( 'name' );
			$order_id = $order->id;
			$customer = get_field('_shipping_first_name',$order->id);
			captura($order);
			$order->update_status('aceptada-n', 'Se ha notificado al cliente de la aceptación');
			$current_stock = get_post_meta($item->get_product_id(), '_stock', true);
			update_post_meta($item->get_product_id(), '_stock', $current_stock-1);
			$order->update_status('aceptada-n', 'Se ha notificado al cliente de la aceptación');
			$headers[] = 'Cc: '.get_bloginfo( 'name' ).' <'.get_option( 'woocommerce_email_from_address' ).'>';
			switch_to_blog(1);
			$asunto_aceptacion = convert_shortcode(get_field('asunto_aceptacion','options'),$site,$order_id,$customer);
			restore_current_blog();						
			$body = op_mail_template('aceptacion',$site,$order_id,$customer,get_field('site_logo','options'));
			wp_mail( $to, $asunto_aceptacion, $body, $headers );

		}
		if(current_user_can('manage_options')) { table_rows($order); }
	}
	if(current_user_can('manage_options')) { table_end(); }
}

function captura($order,$blog_id = 1){
	$buyOrder = $order->id;
	$captureAmount = $order->total;
	$authorizationCode = get_field('authorizationCode',$order->id);
	$order->add_order_note('Captura Diferida realizada');
	$url = "http://ofertaprivada.cl/assets/captura.php?buyOrder=".$buyOrder."&captureAmount=".$captureAmount."&authorizationCode=".$authorizationCode."&blog_id=".$blog_id;
	$json = file_get_contents($url);
	$json =  json_decode($json);
	if ($json->error) {
		$order->add_order_note("Error tbk: ".$json->detail);
		return false;
	}
	$order->update_meta_data('codigo_tbk', $json->token);
	$order->add_order_note('codigo_tbk: '.$json->token);
	return true;
}

