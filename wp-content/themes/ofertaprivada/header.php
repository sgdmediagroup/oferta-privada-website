<!DOCTYPE html>
<!--[if lt IE 7]>  <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>     <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>     <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<!-- Hotjar Tracking Code for www.ofertaprivada.cl -->
	<script>
	    (function(h,o,t,j,a,r){
	        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
	        h._hjSettings={hjid:1005476,hjsv:6};
	        a=o.getElementsByTagName('head')[0];
	        r=o.createElement('script');r.async=1;
	        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
	        a.appendChild(r);
	    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
	</script>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <meta name="google-site-verification" content="LHW-tecoBjz7_sN4Cin8hhsAXPrsyMYnBnufZtUbHsM" />
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-120243835-1"></script>
	<script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'UA-120243835-1');
    </script>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php if(!isset($_GET['iframe']) || $_GET['iframe'] != TRUE) { ?>
<header class="masthead">
  <div class="inner container">
    <h3 class="masthead-brand float-left">
      <a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">   
      	  <?php
		  if(get_field('logo','options')) {
			  $logo = get_field('logo','options');
			  $logo = $logo['url'];
		  }
		  if(empty($logo)) {
			  $logo = get_template_directory_uri().'/img/logo.png';
		  }
		  ?>
			<img alt="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" src="<?php echo $logo; ?>" height="40" />
    	</a>
    </h3>
    <nav class="nav nav-masthead justify-content-center d-md-block d-none float-right">
    <a class="btn btn-outline-info" href="<?php echo $link; ?>">Volver al sitio</a>
    </nav>
  </div>
</header>
<?php } ?>
