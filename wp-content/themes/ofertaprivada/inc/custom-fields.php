<?php
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5aad7e1817041',
	'title' => 'Configuración',
	'fields' => array(
		array(
			'key' => 'field_5aad7e1d804be',
			'label' => 'Logo del comercio',
			'name' => 'site_logo',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'array',
			'preview_size' => 'medium',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5ace08ba0a70d',
			'label' => 'Website',
			'name' => 'website',
			'type' => 'url',
			'instructions' => 'Ingresa el link a tu sitio web',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
		),
		array(
			'key' => 'field_5aadd0f262068',
			'label' => 'Términos y condiciones',
			'name' => 'terminos_y_condiciones',
			'type' => 'wysiwyg',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'tabs' => 'all',
			'toolbar' => 'full',
			'media_upload' => 0,
			'delay' => 0,
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'configuracion',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5aad7427e1a34',
	'title' => 'Envío por producto',
	'fields' => array(
		array(
			'key' => 'field_5aad7427ee93f',
			'label' => 'Retiro en local',
			'name' => 'retiro_en_local',
			'type' => 'true_false',
			'instructions' => 'Permite a tus clientes retirar este producto en tu(s) local(es)',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '33.3333',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 1,
			'ui_on_text' => 'Activado',
			'ui_off_text' => 'Desactivado',
		),
		array(
			'key' => 'field_5aad7427ef10f',
			'label' => 'Envío personalizado',
			'name' => 'envio_personalizado',
			'type' => 'true_false',
			'instructions' => 'Activa esta opción en caso de tener costos de envío específicos para este producto',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '33.3333',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 1,
			'ui_on_text' => 'Activado',
			'ui_off_text' => 'Desactivado',
		),
		array(
			'key' => 'field_5aad7567dd65f',
			'label' => 'Tipo de cobro',
			'name' => 'tipo_cobro',
			'type' => 'true_false',
			'instructions' => 'Selecciona si el cobro de envío será realizado por cada oferta o por cada unidad ofertada',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5aad7427ef10f',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array(
				'width' => '33.3333',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 1,
			'ui_on_text' => 'Por unidad',
			'ui_off_text' => 'Por oferta',
		),
		array(
			'key' => 'field_5aad7427efcc7',
			'label' => 'Tarifa por región',
			'name' => 'tarifa_por_region',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5aad7427ef10f',
						'operator' => '==',
						'value' => '1',

					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 1,
			'max' => 15,
			'layout' => 'table',
			'button_label' => 'Agregar tarifa',
			'sub_fields' => array(
				array(
					'key' => 'field_5aad74283314c',
					'label' => 'Región',
					'name' => 'region',
					'type' => 'select',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'XV de Arica y Parinacota' => 'XV de Arica y Parinacota',
						'V de Valparaíso' => 'V de Valparaíso',
						'XIV de los Ríos' => 'XIV de los Ríos',
						'I de Tarapacá' => 'I de Tarapacá',
						'VI del Libertador General Bernardo O\'Higgins' => 'VI del Libertador General Bernardo O\'Higgins',
						'X de los Lagos' => 'X de los Lagos',
						'II de Antofagasta' => 'II de Antofagasta',
						'VII del Maule' => 'VII del Maule',
						'XI Aisén del General Carlos Ibáñez del Campo' => 'XI Aisén del General Carlos Ibáñez del Campo',
						'III de Atacama' => 'III de Atacama',
						'VIII del Bío Bío' => 'VIII del Bío Bío',
						'XII de Magallanes y Antártica Chilena' => 'XII de Magallanes y Antártica Chilena',
						'IV de Coquimbo' => 'IV de Coquimbo',
						'IX de la Araucanía' => 'IX de la Araucanía',
						'Metropolitana de Santiago' => 'Metropolitana de Santiago',
					),
					'default_value' => array(
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'ajax' => 0,
					'return_format' => 'value',
					'placeholder' => '',
				),
				array(
					'key' => 'field_5aad742833534',
					'label' => 'Valor envío',
					'name' => 'valor_envio',
					'type' => 'number',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'min' => '',
					'max' => '',
					'step' => '',
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'product',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => array(
		0 => 'the_content',
		1 => 'excerpt',
		2 => 'custom_fields',
		3 => 'discussion',
		4 => 'comments',
		5 => 'format',
		6 => 'page_attributes',
		7 => 'categories',
		8 => 'tags',
		9 => 'send-trackbacks',
	),
	'active' => 1,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5aad27ad2c660',
	'title' => 'Envíos a domicilio',
	'fields' => array(
		array(
			'key' => 'field_5aad2b6bceffd',
			'label' => 'Activar envíos',
			'name' => 'activar_envios',
			'type' => 'true_false',
			'instructions' => 'Activar envíos a domicilio',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 1,
			'ui_on_text' => 'Activado',
			'ui_off_text' => 'Desactivado',
		),
		array(
			'key' => 'field_5aad74f0d2918',
			'label' => 'Tipo de cobro (predeterminado)',
			'name' => 'tipo_cobro',
			'type' => 'true_false',
			'instructions' => 'Selecciona si el cobro de envío será realizado por cada oferta o por cada unidad ofertada',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5aad2b6bceffd',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array(
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 1,
			'ui_on_text' => 'Por unidad',
			'ui_off_text' => 'Por oferta',
		),
		array(
			'key' => 'field_5aad281353a15',
			'label' => 'Tarifa por región (predeterminada)',
			'name' => 'tarifa_por_region',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5aad2b6bceffd',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 1,
			'max' => 15,
			'layout' => 'table',
			'button_label' => 'Agregar tarifa',
			'sub_fields' => array(
				array(
					'key' => 'field_5aad282753a16',
					'label' => 'Región',
					'name' => 'region',
					'type' => 'select',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'XV de Arica y Parinacota' => 'XV de Arica y Parinacota',
						'V de Valparaíso' => 'V de Valparaíso',
						'XIV de los Ríos' => 'XIV de los Ríos',
						'I de Tarapacá' => 'I de Tarapacá',
						'VI del Libertador General Bernardo O\'Higgins' => 'VI del Libertador General Bernardo O\'Higgins',
						'X de los Lagos' => 'X de los Lagos',
						'II de Antofagasta' => 'II de Antofagasta',
						'VII del Maule' => 'VII del Maule',
						'XI Aisén del General Carlos Ibáñez del Campo' => 'XI Aisén del General Carlos Ibáñez del Campo',
						'III de Atacama' => 'III de Atacama',
						'VIII del Bío Bío' => 'VIII del Bío Bío',
						'XII de Magallanes y Antártica Chilena' => 'XII de Magallanes y Antártica Chilena',
						'IV de Coquimbo' => 'IV de Coquimbo',
						'IX de la Araucanía' => 'IX de la Araucanía',
						'Metropolitana de Santiago' => 'Metropolitana de Santiago',
					),
					'default_value' => array(
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'ajax' => 0,
					'return_format' => 'value',
					'placeholder' => '',
				),
				array(
					'key' => 'field_5aad288053a18',
					'label' => 'Valor envío',
					'name' => 'valor_envio',
					'type' => 'number',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'min' => '',
					'max' => '',
					'step' => '',
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'envios',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5aad7896c4eb1',
	'title' => 'Información para ofertas',
	'fields' => array(
		array(
			'key' => 'field_5aad79dc5b0d2',
			'label' => 'Descuento Objetivo',
			'name' => 'do',
			'type' => 'number',
			'instructions' => 'Descuento máximo en porcentaje que el comercio está dispuesto a realizar',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '33.333',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 1,
			'max' => 99,
			'step' => '',
		),
		array(
			'key' => 'field_5aad7a175b0d3',
			'label' => 'Stock inicial',
			'name' => 'si',
			'type' => 'number',
			'instructions' => 'Stock incial con el que empezará a venderse un producto',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '33.333',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 1,
			'max' => '',
			'step' => '',
		),
		array(
			'key' => 'field_5ace085869cc3',
			'label' => 'Link producto (opcional)',
			'name' => 'url_web',
			'type' => 'url',
			'instructions' => 'Link del producto donde estará inscrustado el botón de Oferta Privada',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '33.333',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'product',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => array(
		0 => 'the_content',
		1 => 'excerpt',
		2 => 'custom_fields',
		3 => 'discussion',
		4 => 'comments',
		5 => 'format',
		6 => 'page_attributes',
		7 => 'categories',
		8 => 'tags',
		9 => 'send-trackbacks',
	),
	'active' => 1,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5acebdbe71e16',
	'title' => 'Modalidad de trabajo',
	'fields' => array(
		array(
			'key' => 'field_5acebdc1557f7',
			'label' => 'Modalidad de trabajo',
			'name' => 'modalidad_de_trabajo',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 0,
			'max' => 0,
			'layout' => 'table',
			'button_label' => 'Agregar Mes',
			'sub_fields' => array(
				array(
					'key' => 'field_5acebdd0557f8',
					'label' => 'Mes',
					'name' => 'mes',
					'type' => 'select',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'Enero' => 'Enero',
						'Febrero' => 'Febrero',
						'Marzo' => 'Marzo',
						'Abril' => 'Abril',
						'Mayo' => 'Mayo',
						'Junio' => 'Junio',
						'Julio' => 'Julio',
						'Agosto' => 'Agosto',
						'Septiembre' => 'Septiembre',
						'Octubre' => 'Octubre',
						'Noviembre' => 'Noviembre',
						'Diciembre' => 'Diciembre',
					),
					'default_value' => array(
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'ajax' => 0,
					'return_format' => 'value',
					'placeholder' => '',
				),
				array(
					'key' => 'field_5acebe00557f9',
					'label' => 'Año',
					'name' => 'ano',
					'type' => 'number',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'min' => '',
					'max' => '',
					'step' => '',
				),
				array(
					'key' => 'field_5acebe07557fa',
					'label' => 'Opción',
					'name' => 'opcion',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'Margen objetivo' => 'Margen objetivo',
						'Multidescuento' => 'Multidescuento',
						'Descuento' => 'Descuento',
					),
					'default_value' => array(
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'ajax' => 0,
					'return_format' => 'value',
					'placeholder' => '',
				),
				array(
					'key' => 'field_5acebe30557fb',
					'label' => 'Valor (%)',
					'name' => 'valor',
					'type' => 'number',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'min' => '',
					'max' => '',
					'step' => '',
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'modos',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5ad55f976cfde',
	'title' => 'Configuración privada',
	'fields' => array(
		array(
			'key' => 'field_5ad55fb6b52d9',
			'label' => 'Categoría Comercio',
			'name' => 'categoria',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5ad55fc3b52da',
			'label' => 'Plan',
			'name' => 'plan',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'Pro',
				'Select',
				'Infinity',
			),
			'default_value' => array(
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'ajax' => 0,
			'return_format' => 'value',
			'placeholder' => '',
		),
		array(
			'key' => 'field_5ad55ffcb52db',
			'label' => 'Comisión',
			'name' => 'comision',
			'type' => 'number',
			'instructions' => 'Ingresar en números decimales (Ejemplo: 10% = 0.1)',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => '',
			'max' => '',
			'step' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'configuracion',
			),
			array(
				'param' => 'current_user_role',
				'operator' => '!=',
				'value' => 'shop_manager',
			)
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

endif;
?>