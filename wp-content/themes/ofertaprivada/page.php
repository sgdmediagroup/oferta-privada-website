<?php
if(isset($_GET['pay_for_order']) && $_GET['pay_for_order']==TRUE) {
	$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$actual_link = str_replace('pay_for_order=true&','',$actual_link);
	header("Location: ".$actual_link);
}
if(isset($_GET['key'])) {
	$order_id = wc_get_order_id_by_order_key($_GET['key']);
	$site = get_bloginfo( 'name' );
	$order = new WC_Order( $order_id );
	$customer = get_field('_shipping_first_name',$order->id);
	switch_to_blog(1);
	$asunto = convert_shortcode(get_field('asunto_notificacion','options'),$site,$order_id,$customer);
	$pie = get_field('pie_checkout','options');
	restore_current_blog();
	$to = $order->get_billing_email();
	$headers[] = 'From: '.$site.' <'.get_option( 'woocommerce_email_from_address' ).'>';
	$headers[] = 'Content-Type: text/html; charset=UTF-8';
	$body = op_mail_template('notificacion',$site,$order->id,$customer,get_field('site_logo','options'));
	if($order->status == 'espera-respuesta') {
		if(get_field('notificacion_enviada',$order_id)!='TRUE' || !get_field('notificacion_enviada',$order_id)) {
			wp_mail( $to, $asunto, $body, $headers );
			update_field('notificacion_enviada', 'TRUE', $order_id);
		}
	}
	$title = $asunto;
	$subtitle = '';
} else {
	$title = '3. '.get_the_title();
	$subtitle = '<p class="lead">Para que tu oferta sea ingresada debes primero realizar el pago</p>';
	$pie = '';
}
get_header();
?>
<main role="main" class="inner cover cover-container-2 bg-light">
  <div class="inner container pb-5 pt-4">
  	<div class="heading pb-3 text-center">
        <h3><?php echo $title; ?></h3>
        <?php echo $subtitle; ?>
    </div>
	<div class="row bg-white rounded-top pb-3">
        <div class="col-md-12 pt-4 pl-4">
        <?php echo do_shortcode('[woocommerce_checkout] ');?>
        </div>
  	</div>
    <?php if(isset($pie)) { ?>
    <p class=" mt-4 text-center font-light d-block"><?php echo $pie; ?></p>
    <?php } ?>
  </div>
</main>
<?php get_footer(); ?> 