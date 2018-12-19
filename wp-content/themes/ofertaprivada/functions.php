<?php
//SUPERADMIN
grant_super_admin(1);

function youtube($url) {
	return preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i","<iframe width=\"420\" height=\"315\" src=\"//www.youtube.com/embed/$1?rel=0&amp;showinfo=0\" frameborder=\"0\" allowfullscreen></iframe>",$url);
}
function youtube_id($url) {
	parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
	return $my_array_of_vars['v'];   
}
// WooCommerce
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);
function my_theme_wrapper_start() {
  echo '<section id="main">';
}
function my_theme_wrapper_end() {
  echo '</section>';
}
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}


function my_woocommerce_add_error( $error ) {
    if( 'El estado de este pedido es "Espera respuesta". No se ha podido pagar. Por favor, ponte en contacto con nosotros si necesitas ayuda.' == $error ) {
        $error = 'El estado de este pedido es "Espera respuesta". Dentro de las próximas 24 horas recibirás una respuesta por tu oferta.';
    }
    return $error;
}
add_filter( 'woocommerce_add_error', 'my_woocommerce_add_error' );

/**
 * Bootstrap Basic theme
 * 
 * @package bootstrap-basic
 */
/**
 * Required WordPress variable.
 */
if (!isset($content_width)) {
    $content_width = 1170;
}
if (!function_exists('bootstrapBasicSetup')) {
    function bootstrapBasicSetup() {
        load_theme_textdomain('bootstrap-basic', get_template_directory() . '/languages');
        add_theme_support('title-tag');
        add_theme_support('automatic-feed-links');
        add_theme_support('post-thumbnails');
        add_theme_support('html5', array('caption', 'comment-form', 'comment-list', 'gallery', 'search-form'));
        register_nav_menus(array(
            'primary' => __('Primary Menu', 'bootstrap-basic'),
        ));
        add_theme_support('post-formats', array('aside', 'image', 'video', 'quote', 'link'));
        add_theme_support(
            'custom-background', 
            apply_filters(
                'bootstrap_basic_custom_background_args', 
                array(
                    'default-color' => 'ffffff', 
                    'default-image' => ''
                )
            )
        );
    }
}
add_action('after_setup_theme', 'bootstrapBasicSetup');

if (!function_exists('bootstrapBasicEnqueueScripts')) {
    function bootstrapBasicEnqueueScripts() {
        global $wp_scripts;
		if(is_singular('product')) {
			wp_enqueue_script('charts-js', 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js', array(), '2.4.0', false);
			wp_enqueue_script('incremental-counter', 'https://cdn.rawgit.com/MikhaelGerbet/jquery-incremental-counter/master/jquery.incremental-counter.js', array(), false, false);
        	wp_enqueue_script('op-script', get_template_directory_uri() . '/js/single.js', array(), time(), true);
        	wp_enqueue_script('addtoany', 'https://static.addtoany.com/menu/page.js', array(), false, true);
        	wp_enqueue_script('jstat', '//cdn.jsdelivr.net/npm/jstat@1.7.1/dist/jstat.min.js', array(), false, false);
		}
		
        //wp_enqueue_style('bootstrap-style', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.3.7');
        wp_enqueue_style('bootstrap-style', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css', array(), '3.3.7');
        wp_enqueue_script('bootstrap-popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js', array(), '1.12.9');
        //wp_enqueue_style('bootstrap-style', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css', array(), '3.3.7');
        wp_enqueue_style('bootstrap-theme-style', get_template_directory_uri() . '/css/bootstrap-theme.min.css', array(), '3.3.7');
        wp_enqueue_style('fontawesome-style', 'https://cdn.jsdelivr.net/fontawesome/4.7.0/css/font-awesome.min.css?ver=4.9.4', array(), '4.9.4');
        wp_enqueue_style('main-style', get_template_directory_uri() . '/css/main.css', array(), filemtime( get_stylesheet_directory() . '/css/main.css' ));
        wp_enqueue_script('modernizr-script', get_template_directory_uri() . '/js/vendor/modernizr.min.js', array(), '3.3.1');
        wp_register_script('respond-script', get_template_directory_uri() . '/js/vendor/respond.min.js', array(), '1.4.2');
        $wp_scripts->add_data('respond-script', 'conditional', 'lt IE 9');
        wp_enqueue_script('respond-script');
        wp_register_script('html5-shiv-script', get_template_directory_uri() . '/js/vendor/html5shiv.min.js', array(), '3.7.3');
        $wp_scripts->add_data('html5-shiv-script', 'conditional', 'lte IE 9');
        wp_enqueue_script('html5-shiv-script');
        wp_enqueue_script('jquery');
       // wp_enqueue_script('bootstrap-script', get_template_directory_uri() . '/js/vendor/bootstrap.min.js', array(), '3.3.7', true);
        wp_enqueue_script('bootstrap-script', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js', array(), '3.3.7', true);
        wp_enqueue_script('main-script', get_template_directory_uri() . '/js/main.js', array(), false, true);
		if(is_home() || is_front_page()) {
			wp_enqueue_script('frontpage-script', get_template_directory_uri() . '/js/frontpage.js', array(), false, true);
		}
		if(is_page('faq')) {
			wp_enqueue_script('faqs-script', get_template_directory_uri() . '/js/faqs.js', array(), false, true);
		}
        wp_enqueue_style('bootstrap-basic-style', get_stylesheet_uri());
		wp_enqueue_style( 'wpb-google-fonts', 'https://fonts.googleapis.com/css?family=Nunito:300,400,700,800', false );
		
    }
	// bootstrapBasicEnqueueScripts
}
add_action('wp_enqueue_scripts', 'bootstrapBasicEnqueueScripts');

show_admin_bar(false);
add_filter('show_admin_bar', '__return_false');

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';


/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';


/**
 * Custom dropdown menu and navbar in walker class
 */
require get_template_directory() . '/inc/BootstrapBasicMyWalkerNavMenu.php';


/**
 * Template functions
 */
require get_template_directory() . '/inc/template-functions.php';


/**
 * --------------------------------------------------------------
 * Theme widget & widget hooks
 * --------------------------------------------------------------
 */
require get_template_directory() . '/inc/widgets/BootstrapBasicSearchWidget.php';
require get_template_directory() . '/inc/template-widgets-hook.php';


/**
 * --------------------------------------------------------------
 * SGD Media Group Development
 * --------------------------------------------------------------
 */
 
  // Crear Taxonomías

$labels = array(
	'name'              => 'Sucursales',
	'singular_name'     => 'Sucursal',
	'search_items'      => 'Buscar en todas las sucursales',
	'all_items'         => 'Todas las sucursales',
	'edit_item'         => 'Editar sucursal',
	'update_item'       => 'Actualizar sucursal',
	'add_new_item'      => 'Agregar sucursal',
	'new_item_name'     => 'Nueva sucursal',
	'menu_name'         => 'Sucursales'
);
register_taxonomy( 'sucursales', 'product', array(
	'hierarchical' => true,
	'labels' => $labels,
	'query_var' => false,
	'show_admin_column' => false
) );

add_action( 'init', 'unregister_tags' );

function unregister_tags() {
    unregister_taxonomy_for_object_type( 'product_cat', 'product' );
	unregister_taxonomy_for_object_type( 'product_tag', 'product' );
	unregister_taxonomy_for_object_type( 'category', 'post' );
	unregister_taxonomy_for_object_type( 'post_tag', 'post' );
}

function delete_post_type(){
    unregister_post_type( 'shop_coupon' );
}
add_action('init','delete_post_type');


if( function_exists('acf_add_options_page') ) {
	global $blog_id;
	if($blog_id==1) {
		acf_add_options_page(array(
			'page_title' 	=> 'BlackBox',
			'menu_title'	=> 'BlackBox',
			'menu_slug' 	=> 'blackbox',
			'capability'	=> 'edit_posts',
			'redirect'		=> false,
			'icon_url' => 'dashicons-filter'
		));
	}
	acf_add_options_page(array(
		'page_title' 	=> 'Configuración de envíos',
		'menu_title'	=> 'Envíos',
		'menu_slug' 	=> 'envios',
		'capability'	=> 'manage_woocommerce',
		'redirect'		=> false,
		'icon_url' => 'dashicons-location-alt'
	));
	acf_add_options_page(array(
		'page_title' 	=> 'Configuración general',
		'menu_title'	=> 'Configuración',
		'menu_slug' 	=> 'configuracion',
		'capability'	=> 'manage_woocommerce',
		'redirect'		=> false
	));
	acf_add_options_page(array(
		'page_title' 	=> 'Modalidad trabajo',
		'menu_title'	=> 'Modalidad trabajo',
		'menu_slug' 	=> 'modos',
		'capability'	=> 'manage_woocommerce',
		'redirect'		=> false,
		'icon_url' => 'dashicons-backup'
	));
	/*
	acf_add_options_page(array(
		'page_title' 	=> 'Repositorio de archivos',
		'menu_title'	=> 'Archivos',
		'menu_slug' 	=> 'theme-files',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	acf_add_options_page(array(
		'page_title' 	=> 'Ajustes de Cabecera',
		'menu_title'	=> 'Header',
		'parent_slug'	=> 'theme-general-settings',
	));	
	*/
}

require_once( __DIR__ . '/inc/custom-fields.php');

require_once( __DIR__ . '/inc/order-status.php');

require_once( __DIR__ . '/inc/resumen.php');

add_filter( 'woocommerce_is_purchasable', false );


function remove_menus(){
  //remove_menu_page( 'index.php' );                  //Dashboard
  remove_menu_page( 'jetpack' );                    //Jetpack* 
  remove_menu_page( 'edit.php' );                   //Posts
  remove_menu_page( 'upload.php' );                 //Media
  remove_menu_page( 'edit-comments.php' );          //Comments
  //remove_menu_page( 'plugins.php' );                //Plugins
  //remove_menu_page( 'users.php' );                  //Users
  remove_menu_page( 'tools.php' );                  //Tools
  //remove_menu_page( 'edit.php?post_type=acf-field-group' );        //ACF
  
  if( !current_user_can('manage_options') ) {
  	remove_menu_page( 'options-general.php' );        
  	remove_menu_page( 'users.php' );                  
	remove_menu_page( 'profile.php' );  
	remove_menu_page( 'index.php' );  
	remove_menu_page( 'admin.php?page=wc-settings' );  
	remove_menu_page( 'edit.php?post_type=page' );    //Pages
  }
  global $blog_id;
  if($blog_id!=1) {
	remove_menu_page( 'edit.php?post_type=acf-field-group' );    //ACF Pro
  }
}
add_action( 'admin_menu', 'remove_menus', 999 );


function wpexplorer_adjust_the_wp_menu() {
	$page = remove_submenu_page( 'admin.php?page=wc-status', 'widgets.php' );
}
add_action( 'admin_menu', 'wpexplorer_adjust_the_wp_menu', 999 );

// Custom Admin footer
function wpexplorer_remove_footer_admin () {
	echo '<span id="footer-thankyou">Un producto de <a href="http://www.ofertaprivada.cl/" target="_blank">Oferta Privada</a></span>';
}
add_filter( 'admin_footer_text', 'wpexplorer_remove_footer_admin' );




// Remove dashboard widgets
function remove_dashboard_meta() {
	if ( ! current_user_can( 'manage_options' ) ) {
		remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');
	}
}
add_action( 'admin_init', 'remove_dashboard_meta' ); 



/**
 * Add a widget to the dashboard.
 *
 * This function is hooked into the 'wp_dashboard_setup' action below.
function wpexplorer_add_dashboard_widgets() {
	wp_add_dashboard_widget(
		'wpexplorer_dashboard_widget', // Widget slug.
		'My Custom Dashboard Widget', // Title.
		'wpexplorer_dashboard_widget_function' // Display function.
	);
}
add_action( 'wp_dashboard_setup', 'wpexplorer_add_dashboard_widgets' );

/**
 * Create the function to output the contents of your Dashboard Widget.
 
function wpexplorer_dashboard_widget_function() {
	echo "Hello there, I'm a great Dashboard Widget. Edit me!";
}
*/


function wpexplorer_login_logo() { ?>
	<style type="text/css">
		body.login div#login h1 a {
			background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/img/logo.png );
			width: 100%;
			background-size: 100% auto;
			height: 100px;
			background-position: center;
		}
		.wp-core-ui .button-primary {
			background-color: #ff5b00 !important;
			border: none !important;
			text-shadow: none !important;
			box-shadow: none !important;
			font-size: 15px !important;
			padding: 10px 15px !important;
			height: auto !important;
			width: 100%;
		}
		body.login {
			background-color: #f8f9fa !important;
		}
		#toplevel_page_woocommerce {
			display: none;
		}
		.login form label[for="user_login"] input[type=text] {
			border: none;
			background: transparent;
			box-shadow: none;
			pointer-events: none;
			cursor: text;
			font-size: 18px;
			font-weight: bold;
		}
		.login form label[for="user_login"] span {
			display: none;
		}
		.login form label[for="user_login"] {
			border: none;
			background: transparent;
			box-shadow: none;
			pointer-events: none;
			cursor: text;
			font-size: 0;
		}
		.login form label[for="user_login"]:before {
			content: "Dirección de correo:";
			font-size: 13.5px;
		}
	</style>
<?php }
add_action( 'login_enqueue_scripts', 'wpexplorer_login_logo' );

if( !current_user_can('administrator') ) { add_action('admin_head', 'admin_css'); }

function admin_css() { ?>
	<style type="text/css">
		#toplevel_page_woocommerce {
			display: none;
		}
	</style>
<?php }

function wpdocs_after_setup_theme() {
    add_theme_support( 'html5', array( 'search-form' ) );
}
add_action( 'after_setup_theme', 'wpdocs_after_setup_theme' );

function gallery_slider($id,$gallery) {
	if( $gallery ):
		$i=0;
		echo '<div id="'.$id.'" class="carousel slide" data-ride="carousel">';
		if( count( $gallery ) > 1) {
			echo '<ul class="carousel-indicators">';
			foreach( $gallery as $image ):
				if($i==0) { $class = 'class="active"'; } else { $class = ''; }
				echo '<li data-target="#'.$id.'" data-slide-to="'.$i.'" '.$class.'></li>';
				$i++;
			endforeach;
			echo '</ul>';
		}
		echo '<div class="carousel-inner">';
		$i=0;
		foreach( $gallery as $image ):
			if($i==0) { $class = 'active'; } else { $class = ''; }
			echo '
			<div class="carousel-item py-2 py-md-4 py-lg-5 '.$class.'" style="background-image:url('.$image['url'].');">
			  <div class="inner container">
				  <div class="carousel-caption col-md-8 col-sm-12">
					<h1 class="cover-heading">'.$image['title'].'</h1>
					<h2 class="lead mb-3">'.$image['description'].'</h2>';
					if( have_rows('botones', $image['ID']) ):
					echo '<p class="lead">';
					while ( have_rows('botones', $image['ID']) ) : the_row();
						echo '<a ';
						if(get_sub_field('enlace')) { echo 'href="'.get_sub_field('enlace').'"'; }
						if(get_sub_field('rel')) { echo 'rel="'.get_sub_field('rel').'"'; }
						if(get_sub_field('video')) { echo 'data-lightbox="'.youtube_id(get_sub_field('video')).'"'; }
						echo ' class="btn '.get_sub_field('css').' mr-3 mb-3 active-lightbox">'.get_sub_field('texto').'</a>';
					endwhile;
					echo '</p>';
					endif;
					echo '
				  </div>
			  </div>
			</div>';
			while ( have_rows('botones', $image['ID']) ) : the_row();
				if(get_sub_field('video')) { echo '<div id="lightbox-video" class="d-none video-'.youtube_id(get_sub_field('video')).'" data-video="'.get_sub_field('video').'"><div class="inner container">'.youtube(get_sub_field('video')).'<button class="fa fa-times" onClick="window.location.reload()"></button></div></div>'; }
			endwhile;
			$i++;
		endforeach;
		echo '</div>';
		if( count( $gallery ) > 1) {
			echo '<a class="carousel-control-prev" href="#'.$id.'" data-slide="prev"><span class="carousel-control-prev-icon"></span></a>';
			echo '<a class="carousel-control-next" href="#'.$id.'" data-slide="next"><span class="carousel-control-next-icon"></span></a>';
		}
		echo '</div>';
	endif;
}
/*
function wpdocs_unregister_tags_for_posts() {
    unregister_taxonomy_for_object_type( 'post_tag', 'post' );
}
add_action( 'init', 'wpdocs_unregister_tags_for_posts' );
*/

/**
 * Adds 'Profit' column header to 'Orders' page immediately after 'Total' column.
 *
 * @param string[] $columns
 * @return string[] $new_columns
 */
function sv_wc_cogs_add_order_profit_column_header( $columns ) {

    $new_columns = array();

    foreach ( $columns as $column_name => $column_info ) {

        $new_columns[ $column_name ] = $column_info;

        if ( 'order_total' === $column_name ) {
            $new_columns['order_profit'] = __( 'Oferta Privada', 'my-textdomain' );
        }
    }

    return $new_columns;
}
add_filter( 'manage_edit-shop_order_columns', 'sv_wc_cogs_add_order_profit_column_header', 20 );


if ( ! function_exists( 'sv_helper_get_order_meta' ) ) :
    function sv_helper_get_order_meta( $order, $key = '', $single = true, $context = 'edit' ) {
        if ( defined( 'WC_VERSION' ) && WC_VERSION && version_compare( WC_VERSION, '3.0', '>=' ) ) {
            $value = $order->get_meta( $key, $single, $context );
        } else {
            $order_id = is_callable( array( $order, 'get_id' ) ) ? $order->get_id() : $order->id;
            $value    = get_post_meta( $order_id, $key, $single );
        }
        return $value;
    }
endif;

function sv_wc_cogs_add_order_profit_column_content( $column ) {
    global $post;
    if ( 'order_profit' === $column ) {
		$order    = wc_get_order( $post->ID );
		if ($order->created_via == 'Oferta Privada') {
			$currency = is_callable( array( $order, 'get_currency' ) ) ? $order->get_currency() : $order->order_currency;
			$op_pm     = sv_helper_get_order_meta( $order, 'op_pm' );
			$op_dif     = sv_helper_get_order_meta( $order, 'op_dif' );
			$items = $order->get_items();
			foreach ( $items as $item ) {
				$product_name = $item->get_name();
				$product_id = $item->get_product_id();
				$total = $item->get_subtotal();
				$product_variation_id = $item->get_variation_id();
				echo '<strong>'.$product_name.' x'.$item['qty'].'</strong><br>Oferta (c/u):  '.dinero($total/$item['qty']).'<br>Precio mínimo: '.dinero($op_pm);
			}
		}
		
    }
}
add_action( 'manage_shop_order_posts_custom_column', 'sv_wc_cogs_add_order_profit_column_content' );

add_action('init','possibly_redirect');

function possibly_redirect(){
 global $pagenow;
 if( 'wp-login.php' == $pagenow ) {
	 if($_GET['action']!='logout' && !isset($_GET['log']) && !isset( $_POST['wp-submit'] ) ) {
	  wp_redirect(get_home_url(1).'/login/');
	  exit();
	 }
 }
}



function ofertas_acumuladas($p_id) {
	global $woocommerce, $wpdb, $product;
    include_once($woocommerce->plugin_path() . '/includes/admin/reports/class-wc-admin-report.php');
	
	// WooCommerce Admin Report
    $wc_report = new WC_Admin_Report();
	$comienzo_ciclo = '00';
    
    // Set date parameters for the current month
    $start_date = strtotime(date('Y-m-d', current_time('timestamp')) . '-'.$comienzo_ciclo.' midnight');
    $end_date = strtotime(date('Y-m-d', current_time('timestamp')) . '-'.$comienzo_ciclo.' midnight +1 day');
	//echo date('Y-m-d  H:i:s',$start_date);
	
    // Test data
    //$start_date = strtotime(date('Y-m', current_time('timestamp')) . '-01 midnight');
    //$end_date = strtotime('+1year', $start_date) - 86400;
	
	if(date("Y-m-d H:i:s", $start_date) > date("Y-m-d H:i:s", current_time('timestamp'))) {
		$start_date = strtotime(date('Y-m-d', current_time('timestamp')) . '-'.$comienzo_ciclo.' midnight -1 day');
    	$end_date = strtotime(date('Y-m-d', current_time('timestamp')) . '-'.$comienzo_ciclo.' midnight');
	}
	
    $wc_report->start_date = $start_date;
    $wc_report->end_date = $end_date;
	
	//echo date("Y-m-d H:i:s", current_time('timestamp'));
	//echo date("Y-m-d H:i:s", $start_date);
	//echo date("Y-m-d H:i:s", $end_date);
    
    // Avoid max join size error
    $wpdb->query('SET SQL_BIG_SELECTS=1');
    
    // Get data for current month sold products
    $sold_products = $wc_report->get_order_report_data(array(
        'data' => array(
            '_product_id' => array(
                'type' => 'order_item_meta',
                'order_item_type' => 'line_item',
                'function' => '',
                'name' => 'product_id'
            ),
            '_qty' => array(
                'type' => 'order_item_meta',
                'order_item_type' => 'line_item',
                'function' => 'SUM',
                'name' => 'quantity'
            )
        ),
        'query_type' => 'get_results',
        'group_by' => 'product_id',
        'where_meta' => '',
        'order_by' => 'quantity DESC',
        'order_types' => wc_get_order_types('order_count'),
        'filter_range' => TRUE,
        //'order_status' => array('completed'),
    ));
    
    // List Sales Items
    if (!empty($sold_products)) {
		foreach ($sold_products as $product) {
			if(intval($product->product_id) == $p_id) {
				$ofertas_acumuladas = intval($product->quantity);
			} else {
				$ofertas_acumuladas = 0;
			}
		}
    } else {
		$ofertas_acumuladas = 0;
    }
	return $ofertas_acumuladas;
}

function dinero($monto=FALSE) {
	if(isset($monto)) {
		return '$'.number_format ($monto ,$decimals = 0 ,$dec_point = "," ,$thousands_sep = "." );
	}
}

add_action( 'admin_menu', 'my_admin_menu' );

function my_admin_menu() {
	add_menu_page( 'Ofertas Privadas', 'Ofertas Privadas', 'manage_woocommerce', 'ventas.php', 'mis_ventas', 'dashicons-cart', 6  );
	add_menu_page( 'Respuestas', 'Respuestas', 'manage_options', 'respuestas.php', 'panel_respuestas', 'dashicons-editor-spellcheck', 5 );
	add_menu_page( 'Notificaciones', 'Notificaciones', 'manage_options', 'notificaciones.php', 'panel_notificaciones', 'dashicons-editor-spellcheck', 5 );
	add_menu_page( 'Resumen', 'Resumen', 'manage_options', 'resumen.php', 'resumen', 'dashicons-chart-pie', 5 );
}


function mis_ventas(){
	?>
	<div class="wrap">
		<h2>Mis ofertas privadas</h2>
        <?php
         if(isset($_POST['starter_date']) && isset($_POST['end_date'])) {
			$_starter_date = $_POST['starter_date'];
			$_end_date = $_POST['end_date'];
			$starter_date = strtotime($_starter_date);
			$end_date = strtotime($_end_date. '-0 midnight +1 day');
		} else {
			$starter_date = strtotime(date('Y-m-d', current_time('timestamp')).' -1 year');
			$end_date = strtotime(date('Y-m-d', current_time('timestamp')).' -0 midnight +1 day');
			$_starter_date = date("Y-m-d", $starter_date);
			$_end_date = date("Y-m-d", $end_date);
		}
		if(isset($_POST['search'])) {
			$search = $_POST['search'];
		} else {
			$search = '';
		}
		$query_vals = $_POST['query_var'];
		if(!$query_vals) {
			$query_vals = 'billing_first_name';
		}
		if($_GET['m']) {
			echo '<div class="notice notice-success is-dismissible"><p>';
			_e( $_GET['m'], 'ofertaprivada' );
			echo '</p></div>';
			
		}
		?>
        <form method="post">
        	<input type="text" name="search" value="<?php echo $search; ?>" placeholder="Buscar" />
            <select name="query_var">
            	<?php /*<option <?php $value = 'post__in'; if($query_vals == $value) { echo 'selected'; } ?> value="<?php echo $value; ?>">ID Compra</option> */?>
            	<option <?php $value = 'billing_first_name'; if($query_vals == $value) { echo 'selected'; } ?> value="<?php echo $value; ?>">Nombre cliente</option>
            	<option <?php $value = 'billing_last_name'; if($query_vals == $value) { echo 'selected'; } ?> value="<?php echo $value; ?>">Apellido cliente</option>
            </select>
        	<input type="date" name="starter_date" value="<?php echo $_starter_date; ?>" required="required" />
        	<input type="date" name="end_date" value="<?php echo $_end_date; ?>" required="required" />
            <button type="submit">Filtrar</button>
            <button type="button" class="excelexport">Exportar a excel</button>
        </form>
        <table id="table-pedidos" class="wp-list-table widefat fixed striped posts">
        <thead>
            <th width="25">ID</th>
            <th class="noExl">Cliente</th>
            <th class="hidden">Nombre</th>
            <th class="hidden">Apellido</th>
            <th class="hidden">E-mail</th>
            <th class="hidden">Teléfono</th>
            <th>Método de envío</th>
            <th class="hidden">Dirección</th>
            <th class="hidden">Comuna</th>
            <th class="hidden">Región</th>
            <th>Nota cliente</th>
            <th class="hidden">ID Producto</th>
            <th>Producto</th>
            <th class="hidden">SKU</th>
            <th class="hidden">Cantidad</th>
            <th class="hidden">Precio unitario</th>
            <th class="hidden">Subtotal</th>
            <th class="hidden">Costo de envío</th>
            <th class="hidden">Total</th>
            <th>Estado</th>
            <th width="100">Fecha</th>
            <th class="noExl">Acciones</th>
        </thead>
        <tbody>
        <?php
		$args = array(
    		'date_created' => $starter_date.'...'.$end_date
		);
		if(!current_user_can('manage_options')) {
    		$args['status'] = array('aceptada-n','aceptada','completed');
		} else {
    		$args['status'] = array('aceptada-n','aceptada','completed','rechazada','rechazada-n','espera-respuesta');
		}
		if(!empty($search)) {
			if($_POST['query_var'] != 'post__in') {
				$args[$_POST['query_var']]=$search;
			}
		}
		//print_r($args);
		$orders = wc_get_orders( $args );
		foreach($orders as $order) {
				if(isset($_GET['change']) && $_GET['change']=='completed' && isset($_GET['id']) && $_GET['id']==$order->id) {
					$mensaje = 'El pedido '.$order->id.' ha sido marcado como despachado';
					$order->update_status('completed', $mensaje);
					header("Location: admin.php?page=ventas.php&m=".$mensaje);
				}
				echo '<tr>';
				echo '<td>'.$order->id.'</td>';	
				echo '<td class="noExl"><a title="Ver detalles" href="#TB_inline?width=600&height=450&inlineId=modal-'.$order->id.'" class="thickbox">'.get_field('_shipping_first_name',$order->id).' '.get_field('_shipping_last_name',$order->id).'</a></td>';
				echo '<td class="hidden">'.get_field('_shipping_first_name',$order->id).'</td>';
				echo '<td class="hidden">'.get_field('_shipping_last_name',$order->id).'</td>';
				echo '<td class="hidden">'.$order->get_billing_email().'</td>';
				echo '<td class="hidden">'.$order->get_billing_phone().'</td>';
				echo '<td>'.get_field('tipo_envio',$order->id).'</td>';
				echo '<td class="hidden">';
					if(get_field('tipo_envio',$order->id)=='Retiro en local') {
						echo get_field('metodo_envio',$order->id);
					} else {
						echo get_field('_shipping_address_1',$order->id);
					}
				echo '</td>';
				echo '<td class="hidden">'; if(get_field('tipo_envio',$order->id)!='Retiro en local') { echo get_field('_shipping_city',$order->id); } echo '</td>';
				echo '<td class="hidden">'; if(get_field('tipo_envio',$order->id)!='Retiro en local') { echo get_field('_shipping_state',$order->id); } echo '</td>';
				echo '<td>'.$order->customer_note.'</td>';	
				$items = $order->get_items();
				foreach ( $items as $item ) {
					$product = $order->get_product_from_item( $item );
					$sku = $product->get_sku();
					echo '<td class="hidden">'.$item->get_product_id().'</td>';
					echo '<td>'.$item->get_name().'</td>';
					echo '<td class="hidden">'.$sku.'</td>';
					echo '<td class="hidden">'.$item->get_quantity().'</td>';
					echo '<td class="hidden">'.$item->get_subtotal() / $item->get_quantity().'</td>';
					echo '<td class="hidden">'.$item->get_subtotal().'</td>';
				}
				echo '<td class="hidden">'.$order->shipping_total.'</td>';
				echo '<td class="hidden">'.$order->total.'</td>';
				echo '<td>'.wc_get_order_status_name($order->status).'</td>';
				echo '<td>'.get_the_date( 'd/m/Y', $order->id ).'</td>';
				echo '<td>';
					if($order->status == 'aceptada-n') {
						echo '<span class="noExl"><a href="?page=ventas.php&change=completed&id='.$order->id.'">Marcar como entregada</a></span>';
					}
				echo '</td>';
				echo '</tr>';
		}
		?>
        </tbody>
    	</table>
		<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.table2excel.min.js"></script>
        <script>
			jQuery("button.excelexport").click(function(){
				jQuery("#table-pedidos").table2excel({
					exclude: ".noExl",
					name: "Ofertas Privadas",
					filename: "ofertas_privadas",
					fileext: ".xls",
					exclude_img: true,
					exclude_links: true,
					exclude_inputs: true
				});
			});
		</script>
        <?php // print_r($orders); ?>
	</div>
	<?php
	foreach($orders as $order) {
		include('modal-oferta.php');
	}
}


function panel_respuestas(){
	echo '<div class="wrap"><h2>Respuestas temporales</h2>';
	include('cron-respuestas.php');
	echo '</div>';
}


function panel_notificaciones(){
	echo '<div class="wrap"><h2>Notificaciones por enviar</h2> <a href="?page=notificaciones.php&send">Notificar todas</a>';
	include('notificaciones.php');
	echo '</div>';
}


function convert_shortcode($text,$site,$order,$customer) {
	return str_replace(array('{site_title}','{order_number}','{order_billing_name}'),array($site,$order,$customer),$text);
}

function op_mail_template($template,$site,$order,$customer,$logo=NULL) {
	if(empty($logo)) {
		$logo = 'https://ofertaprivada.cl/wp-content/themes/ofertaprivada/img/logo.png';
	} else {
		$logo = $logo['url'];
	}
	$order_data = new WC_Order( $order );
	ob_start();
	?>
    <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
    <tbody>
        <tr>
            <td align="center" valign="top">
            <div id="template_header_image">
            <p style="margin-top: 0;"><img src="<?php echo $logo; ?>" alt="Oferta Privada CL" style="border: none; display: inline; font-size: 14px; font-weight: bold; height: auto; line-height: 100%; outline: none; text-decoration: none; text-transform: capitalize; height:100px; width:auto;"></p>
            </div>
            <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_container" style="box-shadow: 0 1px 4px rgba(0,0,0,0.1) !important; background-color: #ffffff; border: 1px solid #dedede; border-radius: 3px !important;">
            <tbody>
        <tr>
            <td align="center" valign="top">
                <!-- Body -->
                <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_body"><tbody><tr>
                <td valign="top" id="body_content" style="background-color: #ffffff;">
                <!-- Content -->
                <table border="0" cellpadding="20" cellspacing="0" width="100%">
                <tbody>
                <tr>
                <td valign="top" style="padding: 48px 48px 0;">
                <div id="body_content_inner" style="color: #636363; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; font-size: 14px; line-height: 150%; text-align: left;">
                <?php
                switch_to_blog(1);
				echo convert_shortcode(get_field('parrafo_inicial_'.$template,'options'),$site,$order,$customer);
				restore_current_blog();
				?>
                <div class="wc-order-preview-addresses" style="margin:10px 0;">
                    <table width="100%">
                    <tr>
                    <td width="50%" valign="top">
                    <div class="wc-order-preview-address">
                        <h2>Tu informacion:</h2>
                        <strong>Nombre</strong><br />
                        <?php echo get_field('_shipping_first_name',$order_data->id); ?> <?php echo get_field('_shipping_last_name',$order_data->id); ?><br />
                        <strong>Correo electrónico</strong><br />
                        <a href="mailto:<?php echo $order_data->get_billing_email(); ?>"><?php echo $order_data->get_billing_email(); ?></a><br />
                        <strong>Telefono</strong><br />
                        <a href="tel:<?php echo $order_data->get_billing_phone(); ?>"><?php echo $order_data->get_billing_phone(); ?></a>
                    </div>
                    </td>
                    <td width="50%" valign="top">
                    <div class="wc-order-preview-address">
                        <h2>Metodo de envio</h2>
                            <?php
                            if(get_field('tipo_envio',$order_data->id)=='Retiro en local') {
                                echo get_field('tipo_envio',$order_data->id).': '.get_field('metodo_envio',$order_data->id);
                            } else {
                                echo get_field('_shipping_address_1',$order_data->id).'<br>'.get_field('_shipping_city',$order_data->id).'<br>'.get_field('_shipping_state',$order_data->id);
                            }								
                            ?>
                    </div>
                    <div class="wc-order-preview-note">
                        <p>
                        <strong>Nota</strong><br />
                        <?php echo $order_data->customer_note; ?>
                        </p>
                    </div>
                    </td>
                    </tr>
                    </table>
                </div>
                <div class="wc-order-preview-table-wrapper" style="margin:10px 0;">
                    <table width="100%" style="border:1px solid #ddd;" border="1" bordercolor="#ddd" bordercolordark="#ddd" bordercolorlight="#ddd" class="wp-list-table widefat fixed striped posts">
                        <thead>
                            <tr>
                            <th class="wc-order-preview-table__column--product">Producto</th>
                            <th width="90" align="center" class="wc-order-preview-table__column--quantity">Cantidad</th>
                            <th width="100" align="center" class="wc-order-preview-table__column--total">Unitario</th>
                            <th width="100" align="center" class="wc-order-preview-table__column--total">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $items = $order_data->get_items();
                        foreach ( $items as $item ) {
                            $product = $order_data->get_product_from_item( $item );
                            $sku = $product->get_sku();
                            echo '<tr class="wc-order-preview-table__item wc-order-preview-table__item--158"><td class="wc-order-preview-table__column--product">';
                            echo $item->get_name().'<div class="wc-order-item-sku">SKU: '.$sku.'- ID:'.$item->get_product_id().'</div></td>';
                            echo '<td align="right" width="100" class="wc-order-preview-table__column--quantity">'.$item->get_quantity().'</td>';
                            echo '<td align="right" width="100" class="wc-order-preview-table__column--total"><span class="woocommerce-Price-amount amount">'.dinero($item->get_subtotal() / $item->get_quantity() ).'</span></td>';
                            echo '<td align="right" width="100" class="wc-order-preview-table__column--total"><span class="woocommerce-Price-amount amount">'.dinero($item->get_subtotal() ).'</span></td></tr>';
                        }
                        ?>
                        </tbody>
                        <tfoot>
                        <tr><td colspan="3" align="right">Envío</td><td align="right"><?php echo dinero($order_data->shipping_total); ?></td></tr>
                        <tr><td colspan="3" align="right">Total</td><td align="right"><?php echo dinero($order_data->total); ?></td></tr>
                        </tfoot>
                    </table>
                </div>                
                <?php
				switch_to_blog(1);
				echo convert_shortcode(get_field('parrafo_final_'.$template,'options'),$site,$order,$customer);
				restore_current_blog();
                ?>
                </div>
                </td>
                </tr></tbody></table>
                <!-- End Content -->
            </td>
        </tr>
    </tbody>
    </table>
    <!-- End Body -->
    </td>
    </tr>
    <tr>
        <td align="center" valign="top">
        <!-- Footer -->
        <table border="0" cellpadding="10" cellspacing="0" width="600" id="template_footer"><tbody><tr>
        <td valign="top" style="padding: 0; -webkit-border-radius: 6px;">
        <table border="0" cellpadding="10" cellspacing="0" width="100%"><tbody><tr>
        <td colspan="2" valign="middle" id="credit" style="padding: 0 48px 48px 48px; -webkit-border-radius: 6px; border: 0; color: #ccc; font-family: Arial; font-size: 12px; line-height: 125%; text-align: center;">
        <p><?php echo $site; ?></p>
        </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    <!-- End Footer -->
    </td>
    </tr>
    </tbody></table>
    </td>
    </tr></tbody></table>
    <?php
    $body = ob_get_clean();
    return $body;
}

function login_form_username() {
	if(isset($_GET['log'])) {
		global $user_login;
		return $user_login = $_GET['log'];
	}
}
add_action( 'login_head', 'login_form_username' );
?>
