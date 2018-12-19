<?php

function register_status() {
    register_post_status( 'wc-espera-respuesta', array(
		'label'                     => _x( 'Espera respuesta', 'Order status', 'woocommerce' ),
        'public'                    => false,
        'exclude_from_search'       => false,
		'_builtin' 					=> true,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Espera respuesta <span class="count">(%s)</span>', 'Espera respuesta <span class="count">(%s)</span>' )
    ) );
	register_post_status( 'wc-aceptada', array(
        'label'                     => 'Aceptada',
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Aceptada <span class="count">(%s)</span>', 'Aceptada <span class="count">(%s)</span>' )
    ) );
	register_post_status( 'wc-aceptada-n', array(
        'label'                     => 'Aceptada notificada',
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Aceptada notificada <span class="count">(%s)</span>', 'Aceptada notificada <span class="count">(%s)</span>' )
    ) );
	register_post_status( 'wc-rechazada', array(
        'label'                     => 'Rechazada',
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Rechazada <span class="count">(%s)</span>', 'Rechazada <span class="count">(%s)</span>' )
    ) );
	register_post_status( 'wc-rechazada-n', array(
        'label'                     => 'Rechazada notificada',
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Rechazada notificada <span class="count">(%s)</span>', 'Rechazada notificada <span class="count">(%s)</span>' )
    ) );
}
add_action( 'init', 'register_status' );

// Add to list of WC Order statuses
function add_status( $order_statuses ) {
    $new_order_statuses = array();
    foreach ( $order_statuses as $key => $status ) {
        $new_order_statuses[ $key ] = $status;
        if ( 'wc-processing' === $key ) {
            $new_order_statuses['wc-espera-respuesta'] = 'Espera respuesta';
            $new_order_statuses['wc-aceptada'] = 'Aceptada';
            $new_order_statuses['wc-aceptada-n'] = 'Aceptada notificada';
            $new_order_statuses['wc-rechazada'] = 'Rechazada';
            $new_order_statuses['wc-rechazada-n'] = 'Rechazada notificada';
        }
    }
    return $new_order_statuses;
}
add_filter( 'wc_order_statuses', 'add_status' );
?>