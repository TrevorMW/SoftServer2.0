<?php require_once( '../../functions.php' );

$data = $_POST;
$resp = new Ajax_Response( $data['action'], true );

if( is_array( $data ) && !empty( $data ) )
{
  $cart         = new Cart();
  $cart_session = $cart->create_new_cart_record( $data );

  if( $cart_session != false )
  {
    $product        = new Product();
    $product_type   = new Product_Type( $data['product_type'] );
    $new_product_id = $product->create_product_record( $product_type );

    if( is_int( $new_product_id ) )
    {
      $product->add_product_ingredients( $new_product_id, $data['ingredients'] );
      $cart->create_item_record( $cart_session, $new_product_id );
    }
  }
  else
  {
    $resp->set_message( 'Could not create cart session. Please try again.' );
  }
}
else
{
  $resp->set_message( 'Couldn\'t find any data! <a href="/">Go back?</a>' );
}

echo $resp->encode_response();
die();
