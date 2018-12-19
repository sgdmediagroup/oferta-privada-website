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
$dia = 0;
$ano_mes=date('Y-n');
$ano=date('Y');
$mes=date('n');
$ultimodia_mes_ant = date("d",(mktime(0,0,0,($mes-1)+1,1,$ano)-1));
$fin_mes_ant = 
$hoy = date('j');
$hoydia=date('Y-n-j');

$acumulado_mensual = get_option('acumulado_'.$ano.'-'.($mes-1).'-'.$ultimodia_mes_ant);

if(!$acumulado_mensual) {
	$acumulado_mensual=0;
	add_option('acumulado_'.$ano.'-'.($mes-1).'-'.$ultimodia_mes_ant,$acumulado_mensual);
}
$sum_acumulados=$acumulado_mensual;

// TABLE CONSTRUCTOR
function table_start() {
	echo '<table id="table-pedidos" class="table wp-list-table widefat fixed striped posts"><thead><th width="30">ID</th><th>Producto</th><th align="right" width="75">Oferta</th><th align="right" width="75">Mínimo</th><th align="right" width="75">Diferencia</th><th align="right" width="75">Acumulado</th><th align="center" width="75">Respuesta</th><th align="center" width="130">Estado</th></thead><tbody>';
}
function table_rows_start($order,$acumulado) {
	echo '<tr>';
	echo '<td>'.$order->id.'</td>';	
	$items = $order->get_items();
		foreach ( $items as $item ) {
		echo '<td>'.$item->get_name().' (ID: '.$item->get_product_id().')</td>';
		echo '<td align="right">'.dinero($item->get_subtotal()/$item->get_quantity()).'</td>';
	}
	echo '<td align="right">'.dinero(get_field('op_pm',$order->id)).'</td>';
	echo '<td align="right">'.dinero(get_field('op_dif',$order->id)).'</td>';
	echo '<td align="right">'.dinero($acumulado).'</td>';
	echo '<td align="center">';
}
function table_rows_end($order) {
	echo '</td><td align="center">'.wc_get_order_status_name($order->status).'</td></tr>';
}
function table_end($current_day,$sum_acumulados) {
	echo '</tbody><tfoot><tr><th colspan="8"><i class="dashicons-before dashicons-calendar"></i> '.$current_day.' - Acumulado: '.dinero($sum_acumulados).'</th></tr></tfoot></table><br>';
}

while($dia <= $hoy) {
	$acumulado_dia=0;
	if($dia==0) {
		$current_day = $ano.'-'.($mes-1).'-'.$ultimodia_mes_ant;
	} else {
		$current_day = $ano_mes.'-'.$dia;
	}
	$args = array(
		'status' 			=> array('espera-respuesta','aceptada-n','aceptada','rechazada','rechazada-n'),
		'meta_key'			=> 'op_dif',
		'orderby'			=> 'meta_value_num',
		'order'				=> 'DESC',
		'date_created'		=> $current_day
	);		
	$orders = wc_get_orders( $args );
	$count=0;
	if($orders) {
	if(current_user_can('manage_options')) { table_start(); }
		foreach($orders as $order) {
			$count++;
			if($count==1) {
				$acumulado_dia+=$sum_acumulados;
			}
			$acumulado_dia+=get_field('op_dif',$order->id);
			$to = $order->get_billing_email();
			$headers[] = 'From: '.get_bloginfo( 'name' ).' <'.get_option( 'woocommerce_email_from_address' ).'>';
			$headers[] = 'Content-Type: text/html; charset=UTF-8';
			$site = get_bloginfo( 'name' );
			$order_id = $order->id;
			$customer = get_field('_shipping_first_name',$order->id);
			if(current_user_can('manage_options')) { table_rows_start($order,$acumulado_dia); }
			if($acumulado_dia > 0) {
				if(current_user_can('manage_options')) { echo 'SI'; }
				$sum_acumulados=$acumulado_dia;
				if($dia==$hoy-1) {
					$proximo_acumulado=$acumulado_dia;
					if($order->status=='espera-respuesta' && time() >= strtotime($hora_cierre)) {
						if($current_client!=7) {
							captura($order);
							$order->update_status('aceptada', 'La orden ha sido aceptada - Se ha realizado la captura mediante transbank');
						}
						$current_stock = get_post_meta($item->get_product_id(), '_stock', true);
						update_post_meta($item->get_product_id(), '_stock', $current_stock-1);
						$cambiar_ciclo = TRUE;
					} elseif( $order->status == 'aceptada' && time() >= strtotime($hora_notificaciones)) {
						if($current_client!=7) {
							$order->update_status('aceptada-n', 'Se ha notificado al cliente de la aceptación');
							$headers[] = 'Cc: '.get_bloginfo( 'name' ).' <'.get_option( 'woocommerce_email_from_address' ).'>';
							switch_to_blog(1);
							$asunto_aceptacion = convert_shortcode(get_field('asunto_aceptacion','options'),$site,$order_id,$customer);
							restore_current_blog();						
							$body = op_mail_template('aceptacion',$site,$order_id,$customer,get_field('site_logo','options'));
							wp_mail( $to, $asunto_aceptacion, $body, $headers );
						}
					}				
				}
			} else {
				if(current_user_can('manage_options')) { echo 'NO'; }
				if($dia==$hoy-1) {
					if($order->status=='espera-respuesta' && time() >= strtotime($hora_cierre)) {
						if($current_client!=7) {
							$order->update_status('rechazada', 'La orden ha sido rechazada - Se realizará la devolución mediante transbank');
						}
						$cambiar_ciclo = TRUE;
					} elseif( $order->status == 'rechazada' && time() >= strtotime($hora_notificaciones)) {
						if($current_client!=7) {
							$order->update_status('rechazada-n', 'Se ha notificado al cliente del rechazo');
							switch_to_blog(1);
							$asunto_rechazo = convert_shortcode(get_field('asunto_rechazo','options'),$site,$order_id,$customer);
							restore_current_blog();			
							$body = op_mail_template('rechazo',$site,$order_id,$customer,get_field('site_logo','options'));
							wp_mail( $to, $asunto_rechazo, $body, $headers );
						}
					}				
				}
			}
			if(current_user_can('manage_options')) { table_rows_end($order); }
		}
		if(current_user_can('manage_options')) { table_end($current_day,$sum_acumulados); }
	}
	$dia++;
}

// ACTUALIZAR ACUMULADOS
if(isset($cambiar_ciclo)) {
	if(get_option('acumulado_'.$hoydia)) {
		update_option('acumulado_'.$hoydia,$proximo_acumulado,'no');
	} else {
		add_option('acumulado_'.$hoydia,$proximo_acumulado,'','no');
	}
	header("Refresh:0");
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

