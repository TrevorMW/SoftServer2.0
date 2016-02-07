<?php

class Ingredient
{
  public $all_ingredients;

  public function __construct()
  {
    $db = new DB();

    if( $db->instance instanceOf PDO )
    {
      $stmt   = $db->instance->prepare( 'SELECT * FROM '.TABLE_PREFIX.'ingredients' );
      $stmt->execute();
      $result = $stmt->fetchAll( PDO::FETCH_OBJ );

      if( is_array( $result ) )
        $this->all_ingredients = $this->build_ingredient_array( $result );
    }
  }

  public function build_ingredient_array( $options )
  {
    $select_options = array();

    if( is_array( $options ) && !empty( $options ) )
    {
      foreach( $options as $option )
      {
        $select_options[ $option->type_id ] = $option->type_name;
      }
    }

    return $select_options;
  }

  public function filter_ingredients_by_type( $type_id )
  {
    $db = new DB();

    if( $db->instance instanceOf PDO )
    {
      $filtered_options = array();

      $stmt   = $db->instance->prepare( "SELECT * FROM ".TABLE_PREFIX."ingredients WHERE 1=1 AND ingredient_type = ?" );
      $stmt->bindValue( 1, "$type_id", PDO::PARAM_STR );
      $stmt->execute();
      $result = $stmt->fetchAll( PDO::FETCH_OBJ );

      if( is_array( $result ) )
        $filtered_options = $this->build_ingredient_array( $result );
    }

    return $filtered_options;
  }
}