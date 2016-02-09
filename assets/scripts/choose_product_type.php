<?php require_once( '../../functions.php' );

$data = $_POST;
$resp = new Ajax_Response( $data['action'], true );

if( !empty( $data ) && is_array( $data ) )
{
  $type = new Product_Type( $data['product_type'] );

  if( $type instanceOf Product_Type )
  {
    $data['type_name'] = $type->product_type_slug;
    $data['action']    = 'add_to_cart';
    $data['fields']    = $type->get_product_form_fields( $type );

    $resp->set_status( true );
    $resp->set_data( array( 'new_form' => Template_Helper::render_template( __TEMPLATE_PATH__, 'product_choice_form', $data ) ) );
  }
  else
  {
    $resp->set_message( 'Could not load fields for '.ucfirst( $type_name ).'. Please try again.' );
  }
}

echo $resp->encode_response();
die();