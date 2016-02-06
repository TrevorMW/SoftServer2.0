<?php

class ProductType
{
  public $types;
  public $type_options;

  public function __construct()
  {
    global $ssdb;

    if( $ssdb instanceOf PDO )
    {
      $table  = TABLE_PREFIX.'_product_types';

      $ssdb->prepare( "SELECT * FROM $table" );
      $ssdb->execute();

      $result = $sth->fetch( PDO::FETCH_ASSOC );

      if( $result )
      {
        $this->types        = $result;
        $this->type_options = $this->get_product_type_select_options( $result );
      }
    }
  }

  public function get_product_type_select_options( $data )
  {

  }

  public function get_product_type()
  {

  }
}