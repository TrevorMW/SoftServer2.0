<?php require_once( '../../functions.php' ); session_start();

$data = $_POST;
$resp = new Ajax_Response( $data['action'], true );

if( is_array( $data ) && !empty( $data ) )
{
  $coupon_code = htmlspecialchars( trim( $data['coupon_code']) );

  $user   = new User( $_SESSION['current_user'] );
  $cart   = new Cart( $user->user_id );
  $coupon = new Coupon( $coupon_code );

  if( $coupon->coupon_id != null )
  {
    $total            = $cart->get_cart_total();
    $discounted_total = (float) $total - (float) $coupon->coupon_discount ;

    $resp->set_status( true );
    $resp->set_data( array( 'discount_total' => $discounted_total,
                            'original_total' => $total,
                            'discount_html' => '<h1>'.Text_Helper::format_string_as_price( $discounted_total ).'</h1>
                                                <small>'.Text_Helper::format_string_as_price( $coupon->coupon_discount ).' off</small>' ) );
    $resp->set_message( ucfirst( $coupon_code ). ' successfully applied!' );
  }
  else
  {
    $resp->set_message( ucfirst( $coupon_code ).' is not a valid coupon. Sorry.' );
  }
}
else
{
  $resp->set_message('No Coupon code received. Try Again.');
}

echo $resp->encode_response();
die();