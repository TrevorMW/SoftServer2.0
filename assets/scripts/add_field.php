<?php require_once( '../../functions.php' );

$data = $_POST;
$resp = new Ajax_Response( $data['action'], true );

if( !empty( $data ) && is_array( $data ) )
{
  // $data['product_type']

  $ingredient_type = new Ingredient_Type( $data['type'] );
  $ingredient      = new Ingredient();
  $options         = $ingredient->get_ingredients_by_type( $ingredient_type->ingredient_type_id );

  if( is_array( $options ) && !empty( $options ) )
  {
    $data['type']        = 'select';
    $data['name']        = 'ingredients['.$ingredient_type->ingredient_type_slug.']';
    $data['val']         = $options;
    $data['data_attr']   = '' ;
    $data['placeholder'] = 'Select an Ice Cream Flavor' ;

    $resp->set_status( true );
    $resp->set_data( array( 'field' => Form_Helper::build_field( $data ) ) );
  }
  else
  {
    $resp->set_message('Could not load field. Sorry, <a href="#" data-ajax-get data-action="add_field" data-extra-data="ice_cream">try again</a>?' );
  }
}

echo $resp->encode_response();
die();

