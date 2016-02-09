<?php require_once( '../../functions.php' );

$data = $_POST;
$resp = new Ajax_Response( $data['action'], true );

if( is_array( $data ) && !empty( $data ) )
{
  $cart    = new Cart();
  $cart_id = $cart->create_new_cart_record( $data );

  if( is_int( $cart_id ) )
  {
    $product_type   = new Product_Type( (int) $data['product_type'] );
    $product        = new Product();
    $new_product_id = $product->create_product_record( $product_type );

    if( is_int( $new_product_id ) )
    {
      // ADD REFERNCE TO NEW PRODUCT IN CART
      $product->create_cart_product_record( $new_product_id );

      // CREATE CONNECTIONS BETWEEN INGREDIENTS AND PRODUCT
      $product->create_product_ingredient_records( $new_product_id, $data['ingredients'] );

      $result = $cart->create_cart_product_record( $cart_id, $new_product_id );

      if( is_int( $result ) )
      {
        $resp->set_status( true );
        $resp->set_message( 'You successfully ordered a '.$product_type->product_type_name.'!' );
      }
      else
      {
        $resp->set_message( 'Could Not Save '.$product_type->product_type_name.'. Please Try Again.' );
      }
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
