<?php require_once( '../../functions.php' );

$data = $_POST;
$resp = new Ajax_Response( $data['action'], true );

if( is_array( $data ) && !empty( $data ) )
{
  $order_total = $data['order_total'];
  $user        = new User( $_SESSION['current_user'] );
  $cart        = new Cart( $user->user_id );
  $order       = new Order();

  $order_id = $order->create_order_record( $user, $order_total );

  if( is_int( $order_id ) )
  {
    $result = $order->create_order_product_records( $order_id, $data['cart_product'] );

    if( $result )
    {
      //$cart->destroy_cart( $user );

      $resp->set_status( true );
      $resp->set_message('Thanks for buying '.count( $data['cart_product'] ).' items for '.Text_Helper::format_string_as_price( $data['order_total'] ).' ' );
    }
    else
    {
      $resp->set_message('Could not create order product records. Whoops');
    }
  }
  else
  {
    $resp->set_message('Could not create order record. Try again.');
  }
}
else
{
  $resp->set_message('Could not process Order. Sorry.');
}

echo $resp->encode_response();
die();