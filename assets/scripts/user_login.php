<?php require_once( '../../functions.php' );

$data = $_POST;
$resp = new Ajax_Response( $data['action'], true );

global $ssdb;

if( is_array( $data ) && !empty( $data ) )
{
  if( $data['honey_pot'] == null )
  {
    $user_name = htmlspecialchars( trim( $data['user_name'] ) );
    $password  = htmlspecialchars( trim( $data['password'] ) );

    if( $user_name != null )
    {
      $user = new User( $user_name );

      $passwords_match = password_verify( $password, $user->user_pass );

      if( $passwords_match )
      {
        session_start();
        $_SESSION['current_user'] = $user->user_name;

        $resp->set_status( true );
        $resp->set_message( 'Successfully logged in! Redirecting you now...' );

      }
      else
      {
        $resp->set_message( 'Could not log you in with these credentials. Try again.' );
      }
    }
    else
    {
      $resp->set_message( 'Please enter a valid username.' );
    }
  }
  else
  {
    $resp->set_message( 'NO BOTS!!!' );
  }
}
else
{
  $resp->set_message();
}

echo $resp->encode_response();
die();
