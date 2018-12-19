<?php add_thickbox(); ?>
<div id="modal-<?php echo $order->id; ?>" class="noExl" style="display:none;">
    <div id="wc-backbone-modal-dialog">
        <div class="wc-backbone-modal wc-order-preview">
            <div class="wc-backbone-modal-content" tabindex="0">
                <section class="wc-backbone-modal-main" role="main">
                    <header class="wc-backbone-modal-header">
                        <h1>Pedido #<?php echo $order->id; ?> - <mark class="order-status status-espera-respuesta"><span><?php echo wc_get_order_status_name($order->status); ?></span></mark></h1>
                    </header>
                    <article style="max-height: 477.75px;">
                        <div class="wc-order-preview-addresses">
                            <table width="100%">
                            <tr>
                            <td width="50%" valign="top">
                            <div class="wc-order-preview-address">
                                <h2><?php echo get_field('_shipping_first_name',$order->id); ?> <?php echo get_field('_shipping_last_name',$order->id); ?></h2>
                                    <strong>Correo electrónico</strong><br />
                                    <a href="mailto:<?php echo $order->get_billing_email(); ?>"><?php echo $order->get_billing_email(); ?></a><br />
                                    <p>
                                    <strong>Teléfono</strong><br />
                                    <a href="tel:<?php echo $order->get_billing_phone(); ?>"><?php echo $order->get_billing_phone(); ?></a>
                                    </p>
                            </div>
                            </td>
                            <td width="50%" valign="top">
                            <div class="wc-order-preview-address">
                                <h2>Método de envío</h2>
                                    <?php
                                    if(get_field('tipo_envio',$order->id)=='Retiro en local') {
                                        echo get_field('tipo_envio',$order->id).': '.get_field('metodo_envio',$order->id);
                                    } else {
                                        echo get_field('_shipping_address_1',$order->id).'<br>'.get_field('_shipping_city',$order->id).'<br>'.get_field('_shipping_state',$order->id);
                                    }								
                                    ?>
                            </div>
                            <div class="wc-order-preview-note">
                                <p>
                                <strong>Nota</strong><br />
                                <?php echo $order->customer_note; ?>
                                </p>
                            </div>
                            </td>
                            </tr>
                            </table>
                        </div>
                        <div class="wc-order-preview-table-wrapper">
                            <table cellspacing="0" class="wp-list-table widefat fixed striped posts">
                                <thead>
                                    <tr>
                                    <th class="wc-order-preview-table__column--product">Producto</th>
                                    <th width="100" class="wc-order-preview-table__column--quantity">Cantidad</th>
                                    <th width="100" class="wc-order-preview-table__column--total">Unitario</th>
                                    <th width="100" class="wc-order-preview-table__column--total">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $items = $order->get_items();
                                foreach ( $items as $item ) {
									$product = $order->get_product_from_item( $item );
									$sku = $product->get_sku();
                                    echo '<tr class="wc-order-preview-table__item wc-order-preview-table__item--158"><td class="wc-order-preview-table__column--product">';
                                    echo $item->get_name().'<div class="wc-order-item-sku">SKU: '.$sku.'- ID:'.$item->get_product_id().'</div></td>';
                                    echo '<td width="100" class="wc-order-preview-table__column--quantity">'.$item->get_quantity().'</td>';
                                    echo '<td width="100" class="wc-order-preview-table__column--total"><span class="woocommerce-Price-amount amount">'.dinero($item->get_subtotal() / $item->get_quantity() ).'</span></td>';
                                    echo '<td width="100" class="wc-order-preview-table__column--total"><span class="woocommerce-Price-amount amount">'.dinero($item->get_subtotal() ).'</span></td></tr>';
								}
                                ?>
                                </tbody>
                                <tfoot>
                                <tr><td colspan="3" align="right">Envío</td><td><?php echo dinero($order->shipping_total); ?></td></tr>
                                <tr><td colspan="3" align="right">Total</td><td><?php echo dinero($order->total); ?></td></tr>
                                </tfoot>
                            </table>
                        </div>
                    </article>
                </section>
            </div>
        </div>
    </div>
</div>
