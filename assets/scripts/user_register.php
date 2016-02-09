<?php require_once( '../../functions.php' );

$data = $_POST;
$resp = new Ajax_Response( $data['action'], true );
$flag = true;

global $ssdb;

if( is_array( $data ) && !empty( $data ) )
{
  if( $data['honey_pot'] == null )
  {
    $user_name  = htmlspecialchars( trim( $data['user_name']  ) );
    $password   = htmlspecialchars( trim( $data['password']   ) );
    $pass_again = htmlspecialchars( trim( $data['pass_again'] ) );

    $user = new User( $user_name );

    if( $user instanceOf User )
    {
      $flag == false;
      $resp->set_message( 'User is already registered. <a href="/">Login?</a>' );
    }

    if( $password == $pass_again && $flag )
    {
      $hashed_pass = password_hash( $password, PASSWORD_BCRYPT );

      $stmt = $ssdb->prepare( 'INSERT INTO '.TABLE_PREFIX.'users ( user_name, user_pass ) VALUES ( :user_name, :user_password )' );
      $stmt->bindParam( ':user_name',     $user_name,   PDO::PARAM_STR );
      $stmt->bindParam( ':user_password', $hashed_pass, PDO::PARAM_STR );

      if( $stmt->execute() )
      {
        $resp->set_status(true);
        $resp->set_message( 'You have successfully registered! <a href="/">Login?</a>' );
      }
      else
      {
        $resp->set_message( 'Could not create user account. Try Again.' );
      }
    }
    else
    {
      $resp->set_message( 'Passwords don\'t match. Try again.' );
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
