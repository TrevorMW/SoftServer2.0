<?php

class Product
{
  public $id;
  public $type;
  public $price;
  public $sale_price;
  public $has_discount;
  public $sku;

  public function __construct( $id )
  {
    global $ssdb;

    if( $ssdb instanceOf PDO && is_int( $id ) )
    {
      $sql = '';

      $ssdb->exec( $sql );
    }
  }
}