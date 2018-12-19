<div>
<?php
error_reporting(E_ERROR | E_PARSE);
date_default_timezone_set('America/Santiago');

function woo_add_cart_fee() {
  global $woocommerce;
  $woocommerce->cart->add_fee( __('Custom', 'woocommerce'), 5 );
}
add_action( 'woocommerce_cart_calculate_fees', 'woo_add_cart_fee' );

if(isset($_POST['envio'])) {
	if($_POST['envio'] == 'Envío a domicilio') {
		$metodo_envio = $_POST['region'];
		if(get_field('envio_personalizado')) {
			$regiones = get_field('tarifa_por_region');
			$tipo_cobro = get_field('tipo_cobro');
		
		} else {
			if(get_field('activar_envios','options')) {
				$regiones = get_field('tarifa_por_region','options');
				$tipo_cobro = get_field('tipo_cobro','options');
			}
		}
		foreach($regiones as $region) {
		  if($region['region'] == $_POST['region']) {
			  $costo_envio = $region['valor_envio'];
		  }
		}
		if($tipo_cobro) {
			$costo_envio = $costo_envio*$_POST['qty'];
		}
	} elseif($_POST['envio'] == 'Retiro en local') {
		$metodo_envio = $_POST['local'];
		$costo_envio = 0;
	}
}
if($_POST['producto']) {
	$producto = $_POST['producto'];
} else {
	$producto = get_the_ID();
}
$precio = $_POST['precio_oferta'];
$qty = $_POST['qty'];
$product_object = get_product($producto);
$proporcion = $precio/$product_object->price;
$descuento = $product_object->price - $precio;
//$costo = $_POST['costo'];
//$costo = 100;
//$probabilidad = $_POST['probabilidad'];
//$probabilidad = 50;

$address = array(
	'first_name' => $_POST['nombre'],
	'last_name'  => $_POST['apellido'],
	'company'    => '',
	'email'      => $_POST['email'],
	'phone'      => $_POST['fono'],
	'address_1'  => $_POST['direccion'],
	'address_2'  => '',
	'city'       => $_POST['comuna'],
	'state'      => $_POST['region'],
	'postcode'   => '',
	'country'    => 'CL'
);

$nota_cliente = $_POST['comentarios'];

// Now we create the order
$order = wc_create_order();

//$order->add_product( get_product($producto), $qty*$proporcion);
$wc_product = get_product($producto);
$wc_product->set_price($precio);
$order->add_product( $wc_product, $qty); 
$order->set_address( $address, 'billing' );
$order->set_address( $address, 'shipping' );
if( !empty($nota_cliente)) {
	$order->set_customer_note($nota_cliente);
}
$order->add_order_note( 'Oferta Privada');
$order->set_created_via( 'Oferta Privada');

$payment_gateways = WC()->payment_gateways->payment_gateways();
$order->set_payment_method($payment_gateways['transbank']);

//$order->add_option( 'discount_amount', $descuento, '', false);

$shipping_tax = array(); 
$shipping_rate = new WC_Shipping_Rate( '',$_POST['envio'].': '.$metodo_envio,$costo_envio, $shipping_tax,'custom_shipping_method' );
$order->add_shipping($shipping_rate);
$order->calculate_totals();
//$order->update_meta_data( 'costo', $costo );
$order->update_meta_data( 'tipo_envio', $_POST['envio'] );
$order->update_meta_data( 'metodo_envio', $metodo_envio );
$order->update_meta_data( 'op_pm', $_POST['pm'] );
$order->update_meta_data( 'op_dif', $precio-$_POST['pm'] );
$order->update_meta_data( 'comision', get_field('comision','options') );
$order->update_status("Completed", "Oferta Privada", TRUE); 
$current_stock = get_post_meta($producto, '_stock', true);
update_post_meta($producto, '_stock', $current_stock+1);

$values_final .= $order->id.$values;

echo '<script>window.location.replace("'.site_url().'/finalizar-compra/order-pay/'.$order->id.'/?pay_for_order=true&key='.$order->order_key.'");</script>';
?>