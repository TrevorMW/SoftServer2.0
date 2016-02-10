<?php require_once( 'config.php' ); error_reporting(0); ini_set( 'display_errors', 'Off' ); session_start();

$app = new Application();
$app->start_up_ice_cream_machine();

/**
 * Poor man's magikul autoloader. Loads classes in a JIT manner.
 *
 * @access public
 * @param mixed $classname
 * @return void
 *
 */
function __autoload( $classname )
{
  $filename = __CLASSES_PATH__ . 'class-'. strtolower( str_replace( '_', '-', $classname ) ) .".php";

  if( !file_exists( $filename ) )
    $filename = __HELPERS_PATH__ . 'class-'. strtolower( str_replace( '_', '-', $classname ) ) .".php";

  include_once( $filename );
}




