<?php
global $blog_id;
if($blog_id!=1) {
	header("Location: ".get_site_url(1)."?update=TRUE&blog_id=".$blog_id);
}
if(isset($_GET['get_sites']) && $_GET['get_sites']==TRUE) {
	if ( function_exists( 'get_sites' ) && class_exists( 'WP_Site_Query' ) ) {
		$sites = get_sites();
		$array = array();
		foreach ( $sites as $site ) {
			switch_to_blog($site->blog_id);
			array_push($array,$site->blog_id);
			echo $site->blog_id."<br>";
			restore_current_blog();
		}
		return 0;
	}
} else {
	get_header('frontpage');
	global $blog_id;
	if(isset($_GET['update']) && $_GET['update']==TRUE) {
		if(isset($_GET['blog_id'])) {
			switch_to_blog($_GET['blog_id']);
			if(current_user_can('manage_options')) { echo '<div class="lightbox-respuesta">'; }
			include('cron-respuestas.php');
			restore_current_blog();
			if(current_user_can('manage_options')) { echo '</div>'; }
		} else {
			if ( function_exists( 'get_sites' ) && class_exists( 'WP_Site_Query' ) ) {
				$sites = get_sites();
				if(current_user_can('manage_options')) { echo '<div class="lightbox-respuesta">'; }
				foreach ( $sites as $site ) {
					switch_to_blog($site->blog_id);
					if(current_user_can('manage_options')) { echo '<h2 class="text-light text center mb-1">'.$site->blogname.'</h2>'; }
					include('cron-respuestas.php');
					restore_current_blog();
				}
				if(current_user_can('manage_options')) { echo '</div>'; }
			}
		}
	}
	while ( have_posts() ) : the_post();
	echo '<main role="main" class="inner cover cover-container-2 mt-auto">';
	  // SLIDER
	  $gallery = get_field('slider');
	  gallery_slider('main-slider',$gallery);
	  if( have_rows('destacados') ):
		  echo '<section id="destacados" class="inner container top-offset">';
			  echo '<div class="row text-center">';
			  while ( have_rows('destacados') ) : the_row();
				  echo '<div class="col-md-4 col-sm-12 pt-4 pb-4 border-all bg-light">';
					  echo '<i class="fa fa-x4 mb-2 '.get_sub_field('icono').'" style="color:'.get_sub_field('color').'"></i>';
					  echo '<h3 class="h5">'.get_sub_field('titulo').'</h3>';
					  echo '<p>'.get_sub_field('texto').'</p>';
				  echo '</div>';
			  endwhile;
			  echo '</div>';
		  echo '</section>';
	  endif;
	  // DESTACADOS
	  if($destacados = get_field('caracteristicas')) :
		  echo '<section id="caracteristicas" class="inner container pt-5 pb-5">';
			  echo '<div class="heading text-center mb-5">';
				  echo '<span class="h2 d-block">'.$destacados['titulo'].'</span>';
				  echo '<p class="h4 font-light">'.$destacados['subtitulo'].'</p>';
			  echo '</div>';
			  if($destacados['caracteristicas']): 
				  $caracteristicas = $destacados['caracteristicas'];
				  echo '<div class="row">';
				  foreach( $caracteristicas as $caracteristica) {
					  echo '<div class="col-md-6 col-sm-12 row">';
						  echo '<p class="fa fa-x3 col-md-2 text-center '.$caracteristica['icono'].'"></p>';
						  echo '<div class="col-md-10 text-center text-md-left">';
							  echo '<h4>'.$caracteristica['titulo'].'</h4>';
							  echo '<p>'.$caracteristica['texto'].'</p>';
						  echo '</div>';
					  echo '</div>';
				  }
				  echo '</div>';
			  endif;
		  echo '</section>';
	  endif;
	  // TARIFAS
	  if($tarifas = get_field('tarifas')) :
		  echo '<section id="tarifas" class="pt-5 pb-5 bg-light">';
			echo '<div class="inner container">';
			  echo '<div class="heading text-center mb-4">';
				  echo '<span class="h2 d-block">'.$tarifas['titulo'].'</span>';
				  echo '<p class="h4 font-light">'.$tarifas['subtitulo'].'</p>';
				  echo '<div class="btn-group btns-planes mt-2">';
						echo '<button class="btn btn-default btn-sm transition">Mensual</button>';
						echo '<button class="btn btn-sm transition">Anual</button>';
				  echo '</div>';
			  echo '</div>';
			  if($tarifas['tarifas']): 
				  $planes = $tarifas['tarifas'];
				  echo '<div class="row justify-content-center">';
				  foreach( $planes as $plan) {
					  echo '<div class="plan bg-primary col-12 text-center bg-white pt-4 pb-5 ml-1 mr-1 mt-1 mb-1 rounded">';
						  echo '<p class="h3">'.$plan['titulo'].'</p>';
						  echo '<p class="h4 text-primary mensual-only">'.$plan['precio_mensual'].'<br><small class="text-secondary">Valor Mensual</small></p>';
						  echo '<p class="h4 text-primary anual-only">'.$plan['precio_anual'].'<br><small class="text-secondary">Valor Anual</small></p>';
						  echo '<p>'.$plan['texto'].'</p><hr>';
						  $caracteristicas = $plan['caracteristicas'];
						  foreach( $caracteristicas as $caracteristica) {
								echo '<p class="">'.$caracteristica['caracteristica'].'</p>';
						  }
						  echo '<button class="btn btn-primary btn-sm toggle-element contact-plan" data-plan="Plan '.$plan['titulo'].'">Comienza ahora</button>';
					  echo '</div>';
				  }
				  echo '</div>';
			  endif;
			echo '</div>';
		  echo '</section>';
	  endif;
	  // CLIENTES
	  if($testimonios = get_field('testimonios')) :
		  echo '<section id="clientes" class="inner container pt-5 pb-5">';
			  echo '<div class="heading text-center mb-5">';
				  echo '<span class="h2 d-block">'.$testimonios['titulo'].'</span>';
				  echo '<p class="h4 font-light">'.$testimonios['subtitulo'].'</p>';
			  echo '</div>';
			  if($testimonios['testimonios']): 
				  $clientes = $testimonios['testimonios'];
				  echo '<div id="marcas" class="row justify-content-center">';
				  foreach( $clientes as $cliente) {
					  echo '<div class="col-md-4 col-sm-12 text-center mt-3">';
						  echo '<img width="95" alt="'.$cliente['titulo'].'" class="d-inline-block rounded-circle grayscale transition mb-3" src="'.$cliente['imagen']['sizes']['thumbnail'].'" />';
						  echo '<p>'.$cliente['texto'].'</p>';
						  echo '<p class="mb-2 h5">'.$cliente['titulo'].'</p>';
					  echo '</div>';
				  }
				  echo '</div>';
			  endif;
			  $marcas = get_field('clientes');
			  if( $marcas ):
				  echo '<div id="marcas" class="row justify-content-center">';
					  foreach( $marcas as $marca ):
						  echo '<a class="mr-4 ml-4 mb-1 mt-1 grayscale transition" target="_blank" href="'.get_field('website',$marca['ID']).'"><img src="'.$marca['sizes']['thumbnail'].'" alt="'.$marca['alt'].'" /></a>';
					  endforeach;
				  echo '<div>';
			  endif;
		  echo '</section>';
	  endif;
	echo '</main>';
	endwhile; 
	get_footer('frontpage');
}
?>
<script>
(function () {
 var ldk = document.createElement('script');
 ldk.type = 'text/javascript';
 ldk.async = true;
 ldk.src = 'https://s.cliengo.com/weboptimizer/5aea1a1de4b01311dd144807/5aea1a1fe4b01311dd14480a.js';
 var s = document.getElementsByTagName('script')[0];
 s.parentNode.insertBefore(ldk, s);
 })();
 </script> 