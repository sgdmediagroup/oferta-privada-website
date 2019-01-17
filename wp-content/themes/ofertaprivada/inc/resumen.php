<?php
function custom_admin_scripts() {
    wp_register_style( 'select2css', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css', false, '4.0.6', 'all' );
    wp_register_script( 'select2', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js', array( 'jquery' ), '4.0.6', true );
    wp_enqueue_style( 'select2css' );
    wp_enqueue_script( 'select2' );
    wp_enqueue_script( 'jquery-ui-datepicker' );
    wp_register_style( 'jquery-ui', '//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css' );
    wp_enqueue_style( 'jquery-ui' );  
}
add_action( 'admin_enqueue_scripts', 'custom_admin_scripts' );

function resumen(){
	if ( function_exists( 'get_sites' ) && class_exists( 'WP_Site_Query' ) ) {
		$sites = get_sites();
	}
	if(isset($_GET['clientes'])) {
		$clientes = $_GET['clientes'];
	} else {
		$clientes = array();
		foreach ( $sites as $site ) {
			switch_to_blog($site->blog_id);
			array_push($clientes,$site->blog_id);
			restore_current_blog();
		}
	}
	$states = array('espera-respuesta','aceptada-n','aceptada','rechazada','rechazada-n','completed');
	if(isset($_GET['states'])) {
		$estados = $_GET['states'];
	} else {
		$estados = $states;
	}
	?>
	<div class="wrap">
		<h2>Resumen</h2>
        <?php
         if(isset($_GET['starter_date']) && isset($_GET['end_date'])) {
			$_starter_date = $_GET['starter_date'];
			$_end_date = $_GET['end_date'];
			$starter_date = strtotime($_starter_date);
			$end_date = strtotime($_end_date. '-0 midnight +1 day');
		} else {
			$starter_date = strtotime(date('Y-n-d', current_time('timestamp')).' -1 month');
			$end_date = strtotime(date('Y-n-d', current_time('timestamp')).' -0 midnight +1 day');
			$_starter_date = date("Y-n-d", $starter_date);
			$_end_date = date("Y-n-d", $end_date);
		}
		?>
        <form method="GET">
        	<input type="hidden" name="page" value="resumen.php" />
            <select class="select2-multiple" name="states[]" multiple="multiple" data-placeholder="Todos los estados">
            	<?php
                foreach ($states as $state) {
					echo '<option value="'.$state.'"';
					if(isset($_GET['states']) && in_array($state,$estados)) {
						echo ' selected="selected"';
					}
					echo '>'.wc_get_order_status_name($state).'</option>';
				}
				?>
            </select>
            <select class="select2-multiple" name="clientes[]" multiple="multiple" data-placeholder="Todos los clientes">
                <?php
					foreach ( $sites as $site ) {
						$current_blog_details = get_blog_details( array( 'blog_id' => $site->blog_id ) );
						echo '<option value="'.$site->blog_id.'"';
						if(isset($_GET['clientes']) && in_array($site->blog_id,$clientes)) {
							echo ' selected="selected"';
						}
						echo '>'.$current_blog_details->blogname.'</option>';
					}
			?>
            </select>
        	<input class="datepicker" name="starter_date" value="<?php echo $_starter_date; ?>" required="required" />
        	<input class="datepicker" name="end_date" value="<?php echo $_end_date; ?>" required="required" />
            <button type="submit">Filtrar</button>
            <button type="button" class="excelexport">Exportar a excel</button>
        </form>
        <br />
        <?php
		define('TIMEZONE', 'America/Santiago');
		date_default_timezone_set(TIMEZONE);
		
		// TABLE CONSTRUCTOR
		function table_rows($order,$hoydia) {
			$col_width=75;
			echo '<tr>';
			echo '<td>'.$order->id.'</td>';	
			echo '<td>'.get_bloginfo('name').'</td>';
			$items = $order->get_items();
			foreach ( $items as $item ) {
				$_product = wc_get_product($item->get_product_id());
				if(!empty($_product->sale_price)) {
					$price = $_product->sale_price;
				} else {
					$price = $_product->price;
				}
				echo '<td>'.$item->get_name().' x'.$item->get_quantity().'</td>';
				echo '<td>'.get_field('categoria','options').'</td>';
				echo '<td width="'.$col_width.'">'.dinero($price).'</td>';
				echo '<td width="'.$col_width.'" align="right">'.dinero($item->get_subtotal()/$item->get_quantity()).'</td>';
			}
			echo '<td width="'.$col_width.'" align="right">'.dinero(get_field('op_pm',$order->id)).'</td>';
			echo '<td width="'.$col_width.'" align="right">'.dinero(get_field('op_dif',$order->id)).'</td>';
			echo '<td width="'.$col_width.'" align="right">'.dinero($item->get_subtotal()).'</td>';
			$comision = get_field('comision',$order->id);
			if(!$comision) {
				$comision = get_field('comision','options');
			}
			echo '<td width="'.$col_width.'">'.dinero($item->get_subtotal()*$comision).'</td>';
			echo '<td width="'.$col_width.'">'.$order->order_date.'</td>';
			echo '<td width="'.$col_width.'" align="center">'.wc_get_order_status_name($order->status).'</td></tr>';
		}
		$col_width=70;
		echo '<table id="table-pedidos" class="table wp-list-table widefat fixed striped posts"><thead>
			<th width="25">ID</th>
			<th>Cliente</th>
			<th>Producto</th>
			<th>Categoría</th>
			<th align="right" width="'.$col_width.'">PVP</th>
			<th align="right" width="'.$col_width.'">Oferta</th>
			<th align="right" width="'.$col_width.'">P Min</th>
			<th align="right" width="'.$col_width.'">Dif</th>
			<th align="right" width="'.$col_width.'">Pagado</th>
			<th align="right" width="'.$col_width.'">Comisión</th>
			<th align="right" width="70">Fecha</th>
			<th align="center" width="70">Estado</th>
			</thead><tbody>';
			$c_ofertas=0;
			$c_aceptadas=0;
			$c_rechazadas=0;
			
			$totales = array("pvp","of","pmin","dif","pagado","comision");
			foreach($totales as $total) {
				$p_totales[$total]= 0;
			}
			foreach($totales as $total) {
				$a_totales[$total]= 0;
			}
			foreach($totales as $total) {
				$r_totales[$total]= 0;
			}
			
			foreach($clientes as $cliente) {
				$hoy = $_starter_date;				
				switch_to_blog($cliente);
				while(strtotime($hoy) <= strtotime($_end_date)) {
					$args = array(
						'status' 			=> $estados,
						'meta_key'			=> 'op_dif',
						'orderby'			=> 'meta_value_num',
						'order'				=> 'DESC',
						'date_created'		=> $hoy
					);		
					$orders = wc_get_orders( $args );
					if($orders) {
						foreach($orders as $order) {
							$c_ofertas++;
							$comision = get_field('comision',$order->id);
							if(!$comision) {
								$comision = get_field('comision','options');
							}
							$items = $order->get_items();
							foreach($totales as $total) {
								foreach ( $items as $item ) {
									$_product = wc_get_product($item->get_product_id());
									if(!empty($_product->sale_price)) {
										$price = $_product->sale_price;
									} else {
										$price = $_product->price;
									}
									if($total=='pvp') { $p_totales[$total] += $price; }
									if($total=='of') { $p_totales[$total] += $item->get_subtotal()/$item->get_quantity(); }
									if( in_array($order->status,array('completed','aceptada','aceptada-n')) ) {
										if($total=='pvp') { $a_totales[$total] += $price; }
										if($total=='of') { $a_totales[$total] += $item->get_subtotal()/$item->get_quantity(); }
									} elseif( in_array($order->status,array('rechazada','rechazada-n')) ) {
										if($total=='pvp') { $r_totales[$total] += $price; }
										if($total=='of') { $r_totales[$total] += $item->get_subtotal()/$item->get_quantity(); }
									}
								}
								if($total=='pmin') { $p_totales[$total] += get_field('op_pm',$order->id); }
								if($total=='dif') { $p_totales[$total] += get_field('op_dif',$order->id); }
								if($total=='pagado') { $p_totales[$total] += $item->get_subtotal(); }
								if($total=='comision') { $p_totales[$total] += $item->get_subtotal()*$comision; }
							}
							if( in_array($order->status,array('completed','aceptada','aceptada-n')) ) {
								foreach($totales as $total) {
									if($total=='pmin') { $a_totales[$total] += get_field('op_pm',$order->id); }
									if($total=='dif') { $a_totales[$total] += get_field('op_dif',$order->id); }
									if($total=='pagado') { $a_totales[$total] += $item->get_subtotal(); }
									if($total=='comision') { $a_totales[$total] += $item->get_subtotal()*$comision; }
								}
								$c_aceptadas++;
							} elseif( in_array($order->status,array('rechazada','rechazada-n')) ) {
								foreach($totales as $total) {
									if($total=='pmin') { $r_totales[$total] += get_field('op_pm',$order->id); }
									if($total=='dif') { $r_totales[$total] += get_field('op_dif',$order->id); }
									if($total=='pagado') { $r_totales[$total] += $item->get_subtotal(); }
									if($total=='comision') { $r_totales[$total] += $item->get_subtotal()*$comision; }
								}
								$c_rechazadas++;
							}
							table_rows($order,$_starter_date);
						}
					}
					$hoy = date ("Y-m-d", strtotime("+1 day", strtotime($hoy)));
				}
				restore_current_blog();
			}
		echo '</tbody><tfoot>
		<tr><td colspan="4">Totales: '.$c_ofertas.'</td>
		<td>'.dinero($p_totales['pvp']).'</td>
		<td>'.dinero($p_totales['of']).'</td>
		<td>'.dinero($p_totales['pmin']).'</td>
		<td>'.dinero($p_totales['dif']).'</td>
		<td>'.dinero($p_totales['pagado']).'</td>
		<td>'.dinero($p_totales['comision']).'</td>
		<td colspan="2"></td></tr>
		<tr><td colspan="4">Aceptadas: '.$c_aceptadas.'</td>
		<td>'.dinero($a_totales['pvp']).'</td>
		<td>'.dinero($a_totales['of']).'</td>
		<td>'.dinero($a_totales['pmin']).'</td>
		<td>'.dinero($a_totales['dif']).'</td>
		<td>'.dinero($a_totales['pagado']).'</td>
		<td>'.dinero($a_totales['comision']).'</td>
		<td colspan="2"></td></tr>
		<tr><td colspan="4">Rechazadas: '.$c_rechazadas.'</td>
		<td>'.dinero($r_totales['pvp']).'</td>
		<td>'.dinero($r_totales['of']).'</td>
		<td>'.dinero($r_totales['pmin']).'</td>
		<td>'.dinero($r_totales['dif']).'</td>
		<td>'.dinero($r_totales['pagado']).'</td>
		<td>'.dinero($r_totales['comision']).'</td>
		<td colspan="2"></td></tr>
		</tfoot></table>';
		?>
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
			jQuery(document).ready(function() {
				jQuery('.select2-multiple').select2({
					templateSelection: function (data) {
						if (data.id === '') { // adjust for custom placeholder values
						  return 'Custom styled placeholder text';
						}
					
						return data.text;
  }				});
			});
			jQuery(document).ready(function($) {
				jQuery(".datepicker").datepicker({ dateFormat: 'yy-m-dd' });
			});

		
		</script>
	</div>
	<?php
}
?>