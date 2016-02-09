<?php error_reporting(0); session_start();

/** SoftServer
 *  version 0.0.1
 *
 *
 */
require_once( 'functions.php' );

global $product_type, $cart, $user, $app;

$cart_items = $cart->get_cart_count(); ?>

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
  </head>

  <body>

    <?php if( isset( $_SESSION['current_user'] ) ) { ?>

      <div class="wrap main-body">
        <a href="#" data-flyout-trigger data-async-content="load_cart_count"><i class="fa fa-fw fa-shopping-cart"></i>( <?php echo $cart->get_cart_count() ?> )</a>
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
      <div class="wrap cart" data-flyout data-async-content="load_cart_data" data-load-when="deferred">
        <a href="#" data-destroy-flyout><i class="fa fa-fw fa-times"></i></a>
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

    <script>
      var ajax_url = '/assets/scripts/';
    </script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="assets/js/general.js" type="text/javascript"></script>
  </body>
</html>