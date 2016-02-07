<?php

class ProductType extends Product
{
  public $types;

  public function __construct()
  {
    $db = new DB();

    if( $db->instance instanceOf PDO )
    {
      $stmt   = $db->instance->prepare( 'SELECT * FROM '.TABLE_PREFIX.'product_type' );
      $stmt->execute();
      $result = $stmt->fetchAll( PDO::FETCH_OBJ );

      if( is_array( $result ) )
        $this->types = $this->build_type_array( $result );
    }
  }

  public function build_type_array( $options )
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

  public function load_type_information( $type_id = null, $type_name )
  {
    $fields = '';

    $ingredient = new Ingredient();

    if( $type_name != null )
    {
      switch( $type_name )
      {
        case 'cone' :

          $fields = array(
                        array( 'type'    => 'select',
                               'name'    => 'ingredients[container]',
                               'options' =>  FormHelper::build_select_options( $ingredient->filter_ingredients_by_type( 'container' ) ) ),

                        array( 'type'     => 'select',
                               'name'     => 'ingredients[ice_cream][]',
                               'options'  => FormHelper::build_select_options( $ingredient->filter_ingredients_by_type( 'ice cream' ) ) )
                      );


        break;


        case 'milkshake' :

          $fields = array(
                        array( 'type'   => 'hidden',
                               'name'   => 'ingredients[container]',
                               'value'  => '9' ),

                        array( 'type'   => 'select',
                               'name'   => 'ingredients[milk]',
                               'values' => FormHelper::build_select_options( $ingredient->filter_ingredients_by_type( 'milk' ) ) ),

                        array( 'type'   => 'select',
                               'name'   => 'ingredients[ice_cream][]',
                               'values' => FormHelper::build_select_options( $ingredient->filter_ingredients_by_type( 'ice cream' ) ) )
                      );

        break;


        case 'float' :

          $fields = array(
                        array( 'type'   => 'hidden',
                               'name'   => 'ingredients[container]',
                               'values' => '9' ),

                        array( 'type'   => 'select',
                               'name'   => 'ingredients[soda]',
                               'values' => FormHelper::build_select_options( $ingredient->filter_ingredients_by_type( 'soda' ) ) ),

                        array( 'type'   => 'select',
                               'name'   => 'ingredients[ice_cream][]',
                               'values' => FormHelper::build_select_options( $ingredient->filter_ingredients_by_type( 'ice cream' ) ) )
                      );


        break;
      }
    }

    return $fields;
  }
}