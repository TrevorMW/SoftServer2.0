<?php require_once( '../../functions.php' ); error_reporting(0); ini_set( 'display_errors', 'Off' ); session_start();

$data = $_POST;
$resp = new Ajax_Response( $data['action'], true );

if( is_array( $data ) && !empty( $data ) )
{
  $user = new User( $_SESSION['current_user'] );
  $cart = new Cart();

  if( is_int( $user->user_id ) )
  {
    $product_type   = new Product_Type( (int) $data['product_type'] );
    $product        = new Product();
    $new_product_id = $product->create_product_record( $product_type );

    if( is_int( $new_product_id ) )
    {
      // CREATE CONNECTIONS BETWEEN INGREDIENTS AND PRODUCT
      $product->create_product_ingredient_records( $new_product_id, $data['ingredients'] );

      $result = $cart->create_cart_product_record( $user->user_id, $new_product_id );

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
