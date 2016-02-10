<?php session_start();

class Application
{
  /**
   * Define AWL the things.
   *
   * @access public
   * @return void
   *
   */
  public function start_up_ice_cream_machine()
  {
    $db                      = new DB();
    $GLOBALS['ssdb']         = $db->instance;
    $current_user            = new User( $_SESSION['current_user'] );

    $GLOBALS['cart']         = new Cart( $current_user->user_id );
    $GLOBALS['product_type'] = new Product_Type();

    self::build_application_tables( $db->instance );
  }

  /**
   * Build all necessary tables
   *
   * @access public
   * @return void
   */
  public static function build_application_tables( $db )
  {
    if( $db instanceof PDO )
    {
      $tables = array( 'product_type'        => 'product_type_id            INT (11)      AUTO_INCREMENT PRIMARY KEY,
                                                 product_type_name          VARCHAR (125) NOT NULL,
                                                 product_type_slug          VARCHAR (125) NOT NULL,
                                                 product_type_base_price    FLOAT   (11)  NOT NULL',

                       'product'             => 'product_id                 INT (11)      AUTO_INCREMENT PRIMARY KEY,
                                                 product_base_price         FLOAT (11)    NOT NULL,
                                                 product_type               INT (11)      NOT NULL',

                       'ingredients'         => 'ingredient_id              INT (11)      AUTO_INCREMENT PRIMARY KEY,
                                                 ingredient_name            VARCHAR (125) NOT NULL,
                                                 ingredient_slug            VARCHAR (125) NOT NULL,
                                                 ingredient_type            INT (11)      NOT NULL,
                                                 ingredient_price           FLOAT (11)    NOT NULL',

                       'ingredient_type'     => 'ingredient_type_id         INT(11)       AUTO_INCREMENT PRIMARY KEY,
                                                 ingredient_type_name       VARCHAR (125) NOT NULL,
                                                 ingredient_type_slug       VARCHAR (125) NOT NULL',

                       'users'               => 'user_id                    INT (11)      AUTO_INCREMENT PRIMARY KEY,
                                                 user_name                  VARCHAR (125) NOT NULL,
                                                 user_pass                  VARCHAR (255) NOT NULL',

                       'coupons'             => 'coupon_id                  INT (11)      AUTO_INCREMENT PRIMARY KEY,
                                                 coupon_code                VARCHAR (50)  NOT NULL,
                                                 coupon_discount            INT (11)      NOT NULL ',

                       'orders'              => 'order_id                   INT (11)      AUTO_INCREMENT PRIMARY KEY,
                                                 order_user_id              INT (11)      NOT NULL,
                                                 order_status               VARCHAR (100) NOT NULL,
                                                 order_total                FLOAT (11)    NOT NULL',

                       'order_items'          => 'order_id                  INT (11)      AUTO_INCREMENT PRIMARY KEY,
                                                  product_id                INT (11)      NOT NULL',

                       'product_ingredients'  => 'product_id                INT (11)      NOT NULL,
                                                  ingredient_id             INT (11)      NOT NULL',

                       'cart'                 => 'cart_user_id              INT (11)      NOT NULL,
                                                  cart_product_id           INT (11)      NOT NULL',
                     );

      foreach( $tables as $table_name => $fields )
      {
        $sql = "CREATE TABLE IF NOT EXISTS `".TABLE_PREFIX."$table_name` ( $fields ); ";

        try
        {
          $db->exec( $sql );
        }
        catch( PDOException $e )
        {
          echo $e->getMessage();
        }
      }

    }
  }

  /**
   * build_login_form function.
   *
   * @access public
   * @static
   * @return void
   */
  public static function build_login_form()
  {
    $html = '';

    $data['login']['mode']   = 'login';
    $data['login']['btn']    = 'Login';
    $data['login']['action'] = 'user_login';

    $html .= Template_Helper::render_template( __TEMPLATE_PATH__, 'login-form', $data );

    return $html;
  }

  /**
   * build_register_form function.
   *
   * @access public
   * @static
   * @return void
   */
  public static function build_register_form()
  {
    $html = '';

    $data['login']['mode']   = 'register';
    $data['login']['btn']    = 'Register';
    $data['login']['action'] = 'user_register';

    $html .= Template_Helper::render_template( __TEMPLATE_PATH__, 'login-form', $data );

    return $html;
  }
}