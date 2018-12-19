<?php

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
        wp_enqueue_style('bootstrap-style', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css', array(), '3.3.7');
        wp_enqueue_script('bootstrap-popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js', array(), '1.12.9');
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



/**
 * --------------------------------------------------------------
 * SGD Media Group Development
 * --------------------------------------------------------------
 */
 
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
}

//require_once( __DIR__ . '/inc/custom-fields.php');


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
	</style>
<?php }
add_action( 'login_enqueue_scripts', 'wpexplorer_login_logo' );

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
?>