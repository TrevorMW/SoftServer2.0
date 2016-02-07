<?php require_once( 'config.php' );

/**
 * Define AWL the things.
 *
 * @access public
 * @return void
 *
 */
function start_up_ice_cream_machine()
{
  $db              = new DB();
  $GLOBALS['ssdb'] = $db->instance;

  $GLOBALS['cart'] = new Cart();
  $GLOBALS['type'] = new ProductType();

  build_application_tables( $db->instance );
}

/**
 * Poor man's magikul autoloader.
 *
 * @access public
 * @param mixed $classname
 * @return void
 *
 */
function __autoload( $classname )
{
  $filename = __CLASSES_PATH__ . 'class-'. strtolower( $classname ) .".php";

  include_once( $filename );
}



/**
 * Build all necessary tables
 *
 * @access public
 * @return void
 */
function build_application_tables( PDO $conn )
{
  if( $conn instanceof PDO )
  {
    $tables = array( 'product_type'        => 'type_id         INT (11)      AUTO_INCREMENT PRIMARY KEY,
                                               type_name       VARCHAR (125) NOT NULL',

                     'product_ingredients' => 'product_id      INT (11)      AUTO_INCREMENT PRIMARY KEY,
                                               type_name       VARCHAR (125) NOT NULL',

                     'ingredients'         => 'ingredient_id   INT (11)      AUTO_INCREMENT PRIMARY KEY,
                                               ingredient_name VARCHAR (125) NOT NULL,
                                               ingredient_type INT (11)      NOT NULL',

                     'ingredient_type'    => 'type_id         INT(11)       AUTO_INCREMENT PRIMARY KEY,
                                              type_name       VARCHAR (125) NOT NULL',

                     'users'              => 'user_id         INT (11)      AUTO_INCREMENT PRIMARY KEY,
                                              user_name       VARCHAR (125) NOT NULL,
                                              user_pass       VARCHAR (150) NOT NULL',

                     'coupons'            => 'coupon_id       INT (11)      AUTO_INCREMENT PRIMARY KEY,
                                              user_id         INT (11)      NOT NULL,
                                              coupon_code     VARCHAR (50)  NOT NULL,
                                              coupon_discount INT (11)      NOT NULL ',

                     'cart'               => 'cart_id         INT (11)      AUTO_INCREMENT PRIMARY KEY,
                                              product_type    INT (11)      NOT NULL',

                     'orders'             => 'order_id        INT (11)      AUTO_INCREMENT PRIMARY KEY,
                                              order_user_id   INT (11)      NOT NULL',

                     'order_products'     => 'order_id        INT (11)      AUTO_INCREMENT PRIMARY KEY,
                                              product_id      INT (11)      NOT NULL',
                   );

    foreach( $tables as $table_name => $fields )
    {
      $sql = "CREATE TABLE IF NOT EXISTS `".TABLE_PREFIX."$table_name` ( $fields ); ";

      try
      {
        $conn->exec( $sql );
      }
      catch( PDOException $e )
      {
        echo $e->getMessage();//Remove or change message in production code
      }
    }


  }
}