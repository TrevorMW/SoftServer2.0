<?php require_once( '../../functions.php' ); session_start();

$data = $_POST;
$resp = new Ajax_Response( $data['action'], true );

if( is_array( $data ) && !empty( $data ) )
{

}
else
{
  $resp->set_message('No Coupon code received. Try Again.');
}

echo $resp->encode_response();
die();