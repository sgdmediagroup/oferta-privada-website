<?php
get_header();

global $blog_id;
switch_to_blog(1);
$fields = array('titulo','subtitulo','pie','btn1','btn2','pie_checkout');
foreach($fields as $field) {
	${$field} = get_field($field,'options');
}
restore_current_blog();

if(isset($_GET['iframe']) && $_GET['iframe'] == TRUE) {
	$iframe = '&iframe=TRUE';
} else {
	$iframe = '';
}

if(isset($_POST['nombre'])) {
	get_template_part('send');
}

// VARIABLES POR TIPO DE PRODUCTO

$p_id = get_the_ID();
$_product = wc_get_product($p_id);

//print_r( get_product($p_id) );

if($_product->is_type( 'variable' )) {
	if(isset($_GET['var_id']) && $_var_product = wc_get_product($_GET['var_id'])) {
		$var_id = $_GET['var_id'];
		if ( $_var_product->stock ) {
			$stock = $_var_product->stock;
		}
		if(!empty($_var_product->sale_price)) {
			$price = $_var_product->sale_price;
		} else {
			$price = $_var_product->price;
		}
		$product_image = get_the_post_thumbnail_url($var_id,'thumbnail');
		if(!$product_image) {
			$product_image = get_the_post_thumbnail_url($p_id,'thumbnail');
		}
	} else {
		$args = array(
			'post_type'     => 'product_variation',
			'post_status'   => array( 'private', 'publish' ),
			'numberposts'   => 1,
			'orderby'       => 'menu_order',
			'order'         => 'asc',
			'post_parent'   => $p_id
		);
		$variations = get_posts( $args ); 
		foreach($variations as $variation) {
			echo '<script>window.location.replace("'.get_the_permalink().'?var_id='.$variation->ID.$iframe.'");</script>';
		}
	}
} else {
	$var_id = $p_id;
	if ( $_product->stock ) {
		$stock = $_product->stock;
	}
	if(!empty($_product->sale_price)) {
		$price = $_product->sale_price;
	} else {
		$price = $_product->price;
	}
	$product_image = get_the_post_thumbnail_url($p_id,'thumbnail');
}

$stock_inicial = get_field('si');
$acumuladas = ofertas_acumuladas($var_id);

if($acumuladas < ($stock_inicial / 2)) {
	$acumuladas = $stock_inicial / 2;
}

if($stock_inicial != 0) {
	$acumuladas_porc = ($acumuladas*100)/$stock_inicial;
	$stock_porc = ($stock*100)/$stock_inicial;
} else {
	$acumuladas_porc = 0;
	$stock_porc = 0;
}

$acumuladas_porc_grafico = 100 - $acumuladas_porc;
$stock_porc_grafico = 100 - $stock_porc;

?>
<script type="text/javascript">
    var pvp='<?php echo $price;?>';
	var DO='<?php the_field('do'); ?>';
	var acumuladas_porc = '<?php echo $acumuladas_porc_grafico; ?>%';
	var stock_porc = '<?php echo $stock_porc_grafico; ?>%';
</script>
<main role="main" class="inner cover cover-container-2 bg-light">
  <div class="inner container pb-5 pt-4">
  	<div class="heading pb-3 text-center">
    	<h1 class="sr-only"><?php the_title(); ?></h1>
        <h3><?php echo $titulo; ?></h3>
        <p class="lead font-light"><?php echo $subtitulo; ?></p>
    </div>
    
    <form id="ofertaprivada" action="" method="POST" class="col-md-12" target="_top">
	<div class="row bg-white rounded-top">
        <div class="col-lg-5 col-md-6 pt-4 pl-4">
            <div class="row mb-2">
            <label class="col-12mb-2"><span class="h4">1. Ingresa tu oferta</span></label>
                <?php
                /*
            <div class="col-sm-3 col-4">
                <div class="a2a_kit a2a_kit_size_32 a2a_default_style btn-group" role="group" aria-label="Compartir">
                	<button type="button" class="btn btn-sm btn-default" data-toggle="modal" data-target="#modal-codigo"><i data-toggle="tooltip" data-placement="top" title="Incrustar código" class="fa fa-code"></i></button>
                    <a class="btn btn-sm btn-default a2a_dd" data-toggle="tooltip" data-placement="top" title="Compartir" href="https://www.addtoany.com/share"><i class="fa fa-share"></i></a>
                </div>
             </div>
                */
                ?>
            </div>
        	<div class="row mb-3">
            	<div class="col-3 pr-0">
                	<img src="<?php echo $product_image ?>" />
                </div>
                <div class="col-9 pl-0">
                	<label for="producto" class="sr-only">Producto</label>
					 <?php
					if($_product->is_type( 'variable' )) {
						echo '<select id="producto" name="producto" class="h6 col-md-12 bg-gray py-1 px-3 py-2 mt-1 border-0 rounded-right" onchange="javascript:location.href = this.value;" required>';
						$args = array(
							'post_type'     => 'product_variation',
							'post_status'   => array( 'private', 'publish' ),
							'numberposts'   => -1,
							'orderby'       => 'menu_order',
							'order'         => 'asc',
							'post_parent'   => $p_id
						);
						$variations = get_posts( $args ); 
						foreach($variations as $variation) {
							echo '<option';
							if(isset($_GET['var_id']) && $_GET['var_id']==$variation->ID) {
								echo ' selected="selected" value="'.$variation->ID.'"';
							} else {
								echo ' value="?var_id='.$variation->ID.$iframe.'"';
							}
							echo '>'.$variation->post_title.'</option>';
						}
						echo '</select>';
					} else {
						echo '<select id="producto" name="producto" class="h6 col-md-12 bg-gray py-1 px-3 py-2 mt-1 border-0 rounded-right" disabled="disabled" required>';
						echo '<option value="'.$p_id.'">'.get_the_title($p_id).'</option>';
						echo '</select>';
					}
					?>
					</select>
                    <p class="lead border-light bg-gray py-1 px-3 rounded-right">Precio normal: <?php echo dinero($price); ?></p>
                </div>
            </div>
            <div class="row mb-2">
            	<?php if(!isset($stock)) { ?>
                	<div class="alert alert-danger">No hay stock disponible para este producto</div>
                <?php } else { ?>
            	<div class="col-md-3 mb-2 row-sm">
                	<label class="col-4 col-md-12 px-0" for="qty">Cantidad</label>
                	<input class="col-8 col-md-12 form-control" id="qty" type="number" name="qty" value="1" <?php if(isset($stock)) { echo 'min="1" max="'.$stock.'"'; } else { echo 'min="0" max="0"'; } ?>  required="required">
                </div>
                <div class="col-md-9 pl-md-0 mb-2 row-sm">
                    <label class="mb-2 col-4 col-md-12 px-0">Tu oferta <small>(precio unitario)</small></label>
                    <div class="input-group mb-2 col-8 col-md-12 px-0">
                      <div class="input-group-prepend rounded-left">
                        <span class="input-group-text" id="basic-addon1">$</span>
                      </div>
                       <input class="form-control precio_oferta" id="precio_oferta" name="precio_oferta" type="number" min="1" max="<?php echo $price; ?>"  placeholder="Ingresar oferta" required="required" autocomplete="off">
                       <!--<input class="form-control precio_oferta" id="precio_oferta2" name="precio_oferta2" type="range" min="0" max="<?php // echo $price; ?>" value="1" required="required">-->
                    </div>
                <p class="text-right">Sub-total a pagar (<small>IVA incluido)</small>:<strong>$<span id="subtotal">0</span></strong></p>               
                </div>  
                <?php } ?>
            </div>
        </div>
        <div class="col-lg-1 col-6 d-sm-none d-lg-block pt-5 mb-5 pr-0">
        	<div class="bar bg-warning mb-2 mx-auto rounded">
            	<div class="bar-body bar-body-desktop bg-gray bar-ofertas bar-ofertas-desktop transition"></div>
              <div class="bar-body bar-body-mobile bg-gray bar-ofertas bar-ofertas-mobile transition"></div>
            </div>
        	<small class="text-center d-block"><span class="h1 incremental-counter" data-value="<?php echo $acumuladas; ?>"></span><br />Ofertas acumuladas</small>
        </div>
        <div class="col-lg-1 col-6 d-sm-none d-lg-block pt-5 mb-4 pr-0">
        	<div class="bar bg-success mb-2 mx-auto mx-auto rounded">
            	<div class="bar-body bar-body-desktop bar-stock bar-stock-desktop bg-gray transition"></div>
              <div class="bar-body bar-body-mobile bar-stock bar-stock-mobile bg-gray transition"></div>
            </div>
        	<small class="text-center d-block"><span class="h1 incremental-counter" data-value="<?php echo $stock; ?>"></span><br />Stock disponible</small>
        </div>
        <div class="col-lg-5 col-md-6 pl-0">
            <div class="chart">
            <div class="porcentaje justify-content-center rounded-circle"><span class="cover-heading porcentaje_probable">0</span><span class="cover-heading">%</span><br /><p class="font-light">Probabilidad que tu oferta sea aceptada</p></div>
            <canvas id="myChart" class="rounded-circle bg-gray"></canvas>
        </div>
	</div>

	</div>
	<div id="step2" class="row bg-white border-top justify-content-center pt-5 pb-5 pl-2 pr-2 rounded-bottom sr-only transition">
    	<h4 class="mb-3">2. Completa tu información</h4>
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="nombre">Nombre<span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="nombre" id="nombre" placeholder="" required="required">
              <div class="invalid-feedback">El nombre es requerido.</div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="apellido">Apellido<span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="apellido" id="apellido" placeholder="" required="required">
              <div class="invalid-feedback">El apellido es requerido.</div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
                <label for="email">Email<span class="text-danger">*</span></label>
                <div class="input-group">
                  <div class="input-group-prepend"><span class="input-group-text">@</span></div>
                  <input type="email" class="form-control" name="email" id="email" placeholder="tu@correo.com" required="required">
                  <div class="invalid-feedback">Tu correo es requerido.</div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="fono">Teléfono<span class="text-danger">*</span></label>
                  <input type="text" class="form-control" name="fono" id="fono" placeholder="" value="" required="required">
            </div>
          </div>
		  <?php
		  $envio_domicilio = FALSE;
          if(get_field('envio_personalizado')) {
              $envio_domicilio = TRUE;
			  $regiones = get_field('tarifa_por_region');
			  $tipo_cobro = get_field('tipo_cobro');
          } else {
			  if(get_field('activar_envios','options')) {
				  if(get_field('activar_envios','options')) {
					  $envio_domicilio = TRUE;
					  $regiones = get_field('tarifa_por_region','options');
					  $tipo_cobro = get_field('tipo_cobro','options');
				  }
			  }
		  }
		  if($envio_domicilio || get_field('retiro_en_local')) {
		  ?>
          <div class="row">
            <div class="col-md-12"><label>Método de envío<span class="text-danger">*</span></label></div>
          </div>  
          <div class="row">
            <?php if($envio_domicilio) { ?>
            <div class="radio col-md-6 mb-3">
            	<label class="border p-2 d-block rounded"><input id="envio-domicilio" type="radio" name="envio" value="Envío a domicilio" class="mr-2 radio-evio"><i class="fa fa-truck"></i> Envío a domicilio </label>
            	<div class="invalid-feedback">Debes sleccionar un método</div>
            </div>
            <?php } if(get_field('retiro_en_local')) { ?>
            <div class="radio col-md-6 mb-3">
            	<label class="border p-2 d-block rounded"><input id="envio-local" type="radio" name="envio" value="Retiro en local" class="mr-2 radio-evio"><i class="fa fa-home"></i> Retiro en local </label>
            	<div class="invalid-feedback">Debes sleccionar un método</div>
            </div>
            <?php } ?>
          </div>
          <?php } ?>
          <div class="row row-envio sr-only">
            <div class="col-md-5 mb-3">
              <label for="direccion">Dirección <?php if(get_field('activar_envios','options')) { echo 'de envío'; } ?><span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="direccion" id="direccion" placeholder="" value="">
              <div class="invalid-feedback">Debes ingresar tu dirección</div>
            </div>
            <div class="col-md-3 mb-3">
              <label for="comuna">Comuna<span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="comuna" id="comuna" placeholder="" value="">
              <div class="invalid-feedback">La comuna es requerida</div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="region">Región (envios disponibles)<span class="text-danger">*</span></label>
              <select class="custom-select d-block w-100" name="region" id="region">
                <?php
				foreach($regiones as $region) {
					echo '<option value="'.$region['region'].'">'.$region['region'].' ($'.$region['valor_envio'];
					if($tipo_cobro) {
						echo ' c/u';
					}
					echo ')</option>';
				}
				?>
              </select>
              <div class="invalid-feedback">Por favor seleccione la región</div>
            </div>
          </div>
          <?php if(get_field('retiro_en_local') && $sucursales = wp_get_post_terms($post->ID, 'sucursales', array("fields" => "all")) ) { ?>
          <div class="row row-local sr-only">
            <div class="col-md-12 mb-3">
              <label for="local">Sucursal para retiro<span class="text-danger">*</span></label>
              <select class="custom-select d-block w-100" name="local" id="local" required="required">
                <?php
				foreach($sucursales as $sucursal) {
					echo '<option value="'.$sucursal->name.'">'.$sucursal->name;
					if($sucursal->description) {
						echo ' ('.$sucursal->description.')';
					}
					echo '</option>';
				}				
				?>
              </select>
              <div class="invalid-feedback">Por favor seleccione el local</div>
            </div>
          </div>
          <?php } ?>
          <div class="row">
            <div class="col-md-12 mb-3">
            	<label for="comentarios">Comentarios</label>
            	<textarea id="comentarios" name="comentarios" class="form-control"></textarea>
            </div>
			<?php if(isset($pie_checkout)) { ?>
            <p class=" mt-4 text-center font-light d-block w-100"><?php echo $pie_checkout; ?></p>
            <?php } ?>
            <div class="col-md-12">
            <span class="p-2 d-block text-center"><input id="terminos" type="checkbox" name="terminos" class="mr-2" required="required"> Acepto los <button type="button" class="text-primary btn-link border-0" data-toggle="modal" data-target="#modal-terminos">términos y condiciones de compra</a></button>
            </div>
          </div>
    </div>
	</div>
    <?php if(isset($stock)) { ?>
    <div class="text-center submit-oferta">
    	<button class="btn btn-primary next-step" type="button"><?php echo $btn1; ?></button>
    	<button id="submitOferta" type="submit" class="btn btn-primary final-step sr-only"><?php echo $btn2; ?></button>
    </div>
    <?php } ?>
    </form> 
    <small class=" mt-5 text-center font-light d-block"><?php echo $pie; ?></small>
</main>
<div class="modal fade" id="modal-terminos">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    
      <div class="modal-header">
        <h4 class="modal-title">Términos y condiciones</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body"><?php the_field('terminos_y_condiciones','options'); ?></div>
      <div class="modal-footer"><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button></div>

    </div>
  </div>
</div>
<div class="modal fade" id="modal-codigo" <?php if(isset($_GET['codigo'])) { echo 'style="display: block;
    z-index: 9999;
    opacity: 1;
    background: rgba(0,0,0,0.5);"'; } ?>>
  <div class="modal-dialog">
    <div class="modal-content">
    
      <div class="modal-header">
        <h4 class="modal-title">Incrustar botón</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
      <p>Copia y pega el siguiente código en el lugar de tu sitio donde deseas insertar el botón de oferta privada:</p>
      <?php
	  $site_slug = str_replace('https://ofertaprivada.cl/','',get_home_url());
	  $boton = '<div style="display:inline-block;width:170px;"><div title="Oferta privada" id="btn-oferta-privada" class="btn-oferta-privada" data-negocio="'.$site_slug.'" data-producto="'.get_the_ID().'" style="background-image: url(https://ofertaprivada.cl/wp-content/themes/ofertaprivada/img/btn.gif);background-position:top center;background-size:100% auto;background-repeat: no-repeat;width: 170px;height: 70px;display: inline-block;cursor: pointer;-webkit-transition: all 600ms ease;-moz-transition: all 600ms ease;-o-transition: all 600ms ease;-ms-transition: all 600ms ease;transition: all 600ms ease;"></div><a style="background-image: url(https://ofertaprivada.cl/wp-content/themes/ofertaprivada/img/btn.gif);background-position: bottom center;background-size: 100% auto;background-repeat: no-repeat;width: 170px;height: 17px;display: block;cursor: pointer;-webkit-transition: all 600ms ease;-moz-transition: all 600ms ease;-o-transition: all 600ms ease;-ms-transition: all 600ms ease;transition: all 600ms ease;"  id="btn-faq-oferta-privada" class="btn-faq-oferta-privada"></a></div>';
	  $codigo = '<div id="lightbox-oferta-privada" style="background-color: rgba(0, 0, 0, 0.8); position: fixed; top: 0px; left: 0px; width: 100%; height: 100%; overflow: auto; display: none;  z-index:2147483647;overflow-y: scroll;-webkit-overflow-scrolling: touch; box-sizing:border-box; max-width:100%;"><span class="cerrar-oferta-privada" style=" color: #fff; cursor: pointer; font-family: -apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;,&quot;Segoe UI Symbol&quot;; position: absolute; right: 0; top: 0; margin: 30px; font-weight: bold; font-size: 30px; background-color: #ff5b00; padding: 0; width: 60px; height: 60px; text-align: center; line-height: 60px; border-radius: 100%;" z-index:2147483648">X</span><iframe frameborder="0" width="1050" height="676" src="" style=" background-color: #fff; margin: 50px auto; display: block; overflow: auto; max-width: 90%; width: 1050px; max-height: 90%; height: 676px;"></iframe></div><div id="lightbox-faq-oferta-privada" style="background-color: rgba(0, 0, 0, 0.8);position: fixed;top: 0px;left: 0px;width: 100%;height: 100%;overflow: auto;display: none;z-index:2147483647;overflow-y: scroll;-webkit-overflow-scrolling: touch;box-sizing:border-box;max-width:100%;"><span class="cerrar-faq-oferta-privada" style=" color: #fff; cursor: pointer; font-family: -apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;,&quot;Segoe UI Symbol&quot;; position: absolute; right: 0; top: 0; margin: 30px; font-weight: bold; font-size: 30px; background-color: #ff5b00; padding: 0; width: 60px; height: 60px; text-align: center; line-height: 60px; border-radius: 100%;" z-index:2147483648"="">X</span><iframe frameborder="0" width="1050" height="676" src="https://ofertaprivada.cl/about/?iframe=TRUE" style=" background-color: #fff; margin: 50px auto; display: block; overflow: auto; max-width: 90%; width: 1050px; max-height: 90%; height: 676px;"></iframe></div><script>jQuery(".btn-faq-oferta-privada").click(function(){jQuery("#lightbox-faq-oferta-privada").css({display:"block"})});jQuery(".cerrar-faq-oferta-privada").click(function(){jQuery("#lightbox-faq-oferta-privada").css({display:"none"})});jQuery(".btn-oferta-privada").click(function(){var negocio=jQuery(this).data("negocio");var producto=jQuery(this).data("producto"); jQuery("#lightbox-oferta-privada").css({"display": "block"});jQuery("#lightbox-oferta-privada iframe").attr("src","https://ofertaprivada.cl/"+negocio+"/?p="+producto+"&iframe=TRUE");});setInterval(function(){var sample=jQuery(".btn-oferta-privada"); if(sample.is(":hover")){sample.css("background-image", "url(https://ofertaprivada.cl/wp-content/themes/ofertaprivada/img/btn-hover.gif)");}else{sample.css("background-image", "url(https://ofertaprivada.cl/wp-content/themes/ofertaprivada/img/btn.gif)");}}, 200);jQuery(".cerrar-oferta-privada").click(function(){jQuery("#lightbox-oferta-privada").css({"display": "none"});});</script>';
	  ?>
      <div class="input-group">
        <input id="embed-code" class="form-control" type="text" value="<?php echo htmlentities($boton); ?>" />
        <div class="input-group-prepend">
          <button class="input-group-text" onclick="copyToClipboard('#embed-code')" data-toggle="tooltip" data-placement="top" title="Copiar código"><i class="fa fa-copy mr-2"></i></button>
        </div>
      </div>    
      <br />  
      <p>Luego, copia y pega el siguiente código en todas las páginas donde utilices el botón de oferta privada justo antes del cierre de la etiqueta <?php echo htmlentities('</body>'); ?>:</p>
      <div class="input-group">
        <input id="embed-main-code" class="form-control" type="text" value="<?php echo htmlentities($codigo); ?>" />
        <div class="input-group-prepend">
          <button class="input-group-text" onclick="copyToClipboard('#embed-main-code')" data-toggle="tooltip" data-placement="top" title="Copiar código"><i class="fa fa-copy mr-2"></i></button>
        </div>
      </div>    
      <br />  
      <p><strong>Importante:</strong> Para utilizar el botón de oferta privada en tu sitio web, debes tener integrada la librería <a href="https://jquery.com/" target="_blank">jQuery</a>.</p>
      </div>

    </div>
  </div>
</div>
<?php get_footer(); ?> 