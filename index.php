<?php
/** SoftServer
 *  version 0.0.1
 *
 *
 */

require_once( 'functions.php' );

start_up_ice_cream_machine(); ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf8" />
    <!--[if IE 8 ]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
    <title>SoftServer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" href="../assets/media/favicon.ico?v=123432">
    <link href='http://fonts.googleapis.com/css?family=Pacifico|Raleway:600,800,400' rel='stylesheet' type='text/css'>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet" media="screen" />
  </head>

  <body>
    <div class="wrap main-body">
      <div class="wrapper table">
        <div class="table-cell">
          <div class="order-form" data-updateable-content="order-form">
            <form data-ajax-form data-action="choose-product-type" data-target="order-form">
              <select data-ajax-select name="product_type">
                <option value="">What can I get ya?</option>
                <option value="0">Ice Cream Cone</option>
                <option value="1">Milkshake</option>
                <option value="2">Ice Cream Float</option>
              </select>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="wrap cart" data-flyout data-async-content></div>

    <script>
      var ajax_url = '/assets/scripts/';
    </script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="assets/js/general.js" type="text/javascript"></script>
  </body>
</html>