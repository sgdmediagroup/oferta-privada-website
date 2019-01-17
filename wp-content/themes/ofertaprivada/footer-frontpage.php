<?php if($llamado = get_field('llamado',2)) { ?>
<div class="call-action" style="background-image:url(<?php echo $llamado['fondo']; ?>);">
  <div class="inner container pt-5 pb-5 text-center">
        <p class="h1 mt-2"><?php echo $llamado['titulo']; ?></p>
    	<p class="lead"><?php echo $llamado['subtitulo']; ?></p>
        <?php
		if($llamado['botones']): 
			$botones = $llamado['botones'];
			foreach( $botones as $boton) {
			   if($boton['enlace']) {
				   $tag = 'a';
			   } else {
				   $tag = 'button';
			   }
				echo '<'.$tag.' class="'.$boton['clases_css'].' mr-2 ml-2 mb-2" ';
				if($boton['enlace']) { echo 'href="'.$boton['enlace'].'"'; }
				echo '>'.$boton['titulo'].'</'.$tag.'>';
			}
		endif;
		?>
  </div>
</div>
<section id="contacto" class="d-none">
  <div class="inner container pt-5 pb-5 text-center">
    <div class="heading text-center mb-4">
        <span class="h2 d-block"><?php echo $llamado['titulo_contacto']; ?></span>
        <p class="h4 font-light"><?php echo $llamado['subtitulo_contacto']; ?></p>
    </div>
  	<div class="row">
        <div class="col-md-8 mx-md-auto">
            <?php echo do_shortcode($llamado['shortcode_contacto']); ?>
        </div>
    </div>
  </div>
</section>
<?php } ?>
<footer id="site-footer" role="contentinfo">
  <div class="inner container pt-5 pb-5">
  	<div id="footer-row" class="pt-2 pb-2 row site-footer">
        <div class="col-md-6 col-sm-12 pr-4">
            <?php 
			$col_1 = get_field('sobre',2);
			  if(get_field('logo','options')) {
				  $logo = get_field('logo','options');
				  $logo = $logo['url'];
			  } else {
				  $logo = get_template_directory_uri().'/img/logo_footer.png';
			  }
			echo '<img class="mb-4" alt="'.esc_attr(get_bloginfo('name', 'display')).'" src="'.$logo.'" height="50" />';
			echo $col_1['nosotros'];
            ?> 
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <?php 
			$col_2 = get_field('menu',2);
			echo '<span class="h3 mb-4 d-block">'.$col_2['titulo'].'</span>';
			wp_nav_menu( array('menu' => 'principal' ));
            ?> 
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <?php 
			$col_3 = get_field('contacto',2);
			echo '<span class="h3 mb-4 d-block">'.$col_3['titulo'].'</span>';
			if($col_3['datos_de_contacto']): 
				$datos_contacto = $col_3['datos_de_contacto'];
				echo '<ul class="footer-menu">';
				foreach( $datos_contacto as $dato_contacto) {
					echo '<li><a class="'.$dato_contacto['css'].'" ';
					if($dato_contacto['enlace']) { echo 'href="'.$dato_contacto['enlace'].'"'; }
					echo '>'.$dato_contacto['icono'].' '.$dato_contacto['texto'].'</a></li>';
				}
				echo '</ul>';
			endif;
			if($col_3['redes_sociales']): 
				$redes_sociales = $col_3['redes_sociales'];
				echo '<div class="social">';
				foreach( $redes_sociales as $social) {
					echo '<a class="fa mr-4 '.$social['icono'].'" href="'.$social['url'].'"></a>';
				}
				echo '</div>';
			endif;
            ?> 
        </div>

    </div>
  </div>
</footer>
<div class="credits">
  <a onclick="topFunction()" class="btn btn-circle mr-3 d-flex justify-content-center align-items-center fa fa-angle-up btn-primary text-light"></a>
  <div class="inner container pt-5 pb-3 text-center">
	<p><?php the_field('copyright',2); ?><br />Desarrollado por <a href="https://grupo-sgd.com" class="text-primary" target="_blank">SGD Media Group</a></p>
  </div>
</div>
<?php wp_footer(); ?> 
</body>
</html>