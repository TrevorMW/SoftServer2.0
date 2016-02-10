<?php error_reporting(0); ini_set( 'display_errors', 'Off' ); session_start();

/** SoftServer
 *  version 0.0.1
 *
 *
 */
require_once( 'functions.php' );

global $product_type, $cart;

$user         = new User( $_SESSION['current_user'] );
$current_user = User::load_current_user() ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf8" />
    <!--[if IE 8 ]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
    <title>SoftServer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" href="../assets/media/favicon.ico?v=123432">
    <link href='http://fonts.googleapis.com/css?family=Pacifico|Frijole|Lato:400,300,700,900' rel='stylesheet' type='text/css'>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet" media="screen" />

    <script>
      var ajax_url = '/assets/scripts/';
    </script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="assets/js/general.js" type="text/javascript"></script>
  </head>

  <body>

    <?php if( $current_user instanceOf User ) { ?>

      <div class="wrap main-body">
        <a href="#" data-flyout-trigger data-async-content="load_cart_count"><i class="fa fa-fw fa-shopping-cart"></i><?php $cart->cart_item_count_string(); ?></a>
        <div class="table" data-loader><div class="table-cell"><i class="fa fa-spin fa-cog"></i></div></div>
        <div class="wrapper table">
          <div class="table-cell">
            <header><h1>SoftServer</h1></header>
            <div class="active fadein" data-main-content data-updateable-content="order-form">
              <form data-ajax-form data-action="choose_product_type" data-target="order-form">
                <select data-ajax-select name="product_type">
                  <?php echo Form_Helper::build_select_options( $product_type->types, 'What can I get ya?' ) ?>
                </select>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="wrap cart" data-flyout >
        <div class="wrapper cart-header">
          <h3>Your Cart</h3>
          <a href="#" data-destroy-flyout><i class="fa fa-fw fa-times"></i></a>
        </div>
        <div class="wrapper cart-body" data-async-content="load_cart_data" data-load-when="deferred" data-target="cart-contents">
          <?php echo $cart->get_cart_contents(); ?>
          <?php echo $cart->checkout_button(); ?>
        </div>
      </div>

    <?php } else { ?>

      <div class="wrap main-body">
        <div class="table" data-loader><div class="table-cell"><i class="fa fa-spin fa-cog"></i></div></div>
        <div class="wrapper table">
          <div class="table-cell">
            <header><h1>SoftServer</h1></header>
            <div class="login-forms">
              <nav data-tab-triggers>
                <ul>
                  <li><a href="#" class="active" data-tab-trigger="login">Login</a></li>
                  <li><a href="#" data-tab-trigger="register">Register</a></li>
                </ul>
              </nav>
              <div data-tabs>
                <div class="active" data-tab="login">
                  <?php echo Application::build_login_form(); ?>
                </div>
                <div data-tab="register">
                  <?php echo Application::build_register_form(); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


    <?php } ?>

    <div class="table popup-parent" data-popup="checkout">
      <div class="table-cell popup-background">
        <div class="popup">
          <header>
            <h1>Checkout</h1>
            <a href="#" data-destroy-popup><i class="fa fa-fw fa-times"></i></a>
          </header>
          <section>
            <?php echo $cart->get_checkout();?>
          </section>
        </div>
      </div>
    </div>

  </body>
</html>