<?php require_once( '../../functions.php' );

$data = $_POST;
$resp = new AjaxResponse( $data['action'], true );

if( !empty( $data ) && is_array( $data ) )
{
  $type      = new ProductType();
  $type_name = $type->types[ (int) $data['product_type'] ];

  $type_fields = $type->load_type_information( (int) $data['product_type'], $type_name );

  $data['type_name'] = $type_name;
  $data['action']    = 'add_to_cart';
  $data['fields']    = FormHelper::parse_fields( $type_fields );

  $resp->set_status( true );
  $resp->set_data( array( 'new_form' => TemplateHelper::render_template( __TEMPLATE_PATH__, 'product_choice_form', $data ) ) );
}

echo $resp->encode_response();
die();