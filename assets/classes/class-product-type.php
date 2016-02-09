<?php

class Product_Type
{
  public $product_type_id;
  public $product_type_name;
  public $product_type_slug;
  public $product_type_base_price;

  public $types;
  public $fields;
  public $allowed_ingredient_types;

  /**
   * __construct function.
   *
   * @access public
   * @param mixed $identifier (default: null)
   * @return void
   */
  public function __construct( $identifier = null)
  {
    $this->load_product_type( $identifier );
    $this->load_all_types();
    $this->load_allowed_ingredient_types();
  }

  /**
   * load_product_type function.
   *
   * @access public
   * @param mixed $identifier (default: null)
   * @return void
   */
  public function load_product_type( $identifier = null )
  {
    global $ssdb;

    if( is_int( $identifier ) )
    {
      $stmt = $ssdb->prepare( 'SELECT * FROM '.TABLE_PREFIX.'product_type WHERE 1=1 AND product_type_id = ?' );
      $stmt->bindValue( 1, "$identifier", PDO::PARAM_INT );
    }
    else
    {
      $stmt = $ssdb->prepare( 'SELECT * FROM '.TABLE_PREFIX.'product_type WHERE 1=1 AND product_type_slug = ?' );
      $stmt->bindValue( 1, "$identifier", PDO::PARAM_STR );
    }

    $stmt->execute();
    $result = $stmt->fetchAll( PDO::FETCH_OBJ );

    if( is_array( $result ) && !empty( $result ) )
    {
      foreach( $result[0] as $k => $val )
      {
        $this->$k = $val;
      }
    }
  }

   /**
   * load_all_types function.
   *
   * @access public
   * @return void
   */
  public function load_all_types()
  {
    global $ssdb;

    $types = array();

    if( $ssdb instanceOf PDO )
    {
      $stmt = $ssdb->prepare( 'SELECT * FROM '.TABLE_PREFIX.'product_type' );
      $stmt->execute();

      $result = $stmt->fetchAll( PDO::FETCH_OBJ );

      if( is_array( $result ) && !empty( $result ) )
      {
        foreach( $result as $k => $val )
        {
          $types[ $val->product_type_slug ] = $val->product_type_name;
        }
      }
    }

    $this->types = $types;
  }

  /**
   * load_allowed_ingredient_types function.
   *
   * @access public
   * @return void
   */
  public function load_allowed_ingredient_types()
  {
    $allowed = '';

    if( $this->product_type_slug != null )
    {
      switch( $this->product_type_slug )
      {
        case 'cone' :

          $allowed = array( 'ice_cream' => '3',
                            'container' => '1' );

        break;

        case 'milkshake' :

          $allowed = array( 'ice_cream' => '3',
                            'container' => array( 'default' => 'glass' )
                          );

        break;

        case 'float' :

          $allowed = array( 'ice_cream' => '3',
                            'container' => array( 'default' => 'glass' )
                          );

        break;

      }
    }

    $this->allowed_ingredient_types = $allowed;
  }


  /**
   * get_product_form_fields function.
   *
   * @access public
   * @param Product_Type $product_type
   * @return void
   */
  public function get_product_form_fields( Product_Type $product_type )
  {
    $fields = '';

    $ingredient = new Ingredient();

    if( $product_type->product_type_slug != null )
    {
      $ingredient->get_ingredients_by_type( 1 );

      switch( $product_type->product_type_slug )
      {
        case 'cone' :

        /*
          $fields = array(
                        array( 'type'    => 'select',
                               'name'    => 'ingredients[container]',
                               'options' =>  FormHelper::build_select_options( $ingredient->filter_ingredients_by_type( 'container' ) ) ),

                        array( 'type'     => 'select',
                               'name'     => 'ingredients[ice_cream][]',
                               'options'  => FormHelper::build_select_options( $ingredient->filter_ingredients_by_type( 'ice cream' ) ) )
                      );
        */

          $fields .= '<input type="hidden" name="product_type" value="'.$product_type->product_type_id.'" />
                      <li>
                        <select name="ingredients[container]">
                        '.Form_Helper::build_select_options( $ingredient->get_ingredients_by_type( 4 ), 'Select a Container'  ).'
                        </select>
                      </li>
                      <li>
                        <select name="ingredients[ice_cream][]">
                        '.Form_Helper::build_select_options( $ingredient->get_ingredients_by_type( 1 ), 'Select a Flavor' ).'
                        </select>
                      </li>
                      <li class="submit"><a href="#" data-ajax-get data-action="add_field" data-extra-data="ice_cream">Add Another Flavor!</a></li>';


        break;

        /*
        case 'milkshake' :

          $fields = array(
                        array( 'type'   => 'hidden',
                               'name'   => 'ingredients[container]',
                               'value'  => '9' ),

                        array( 'type'   => 'select',
                               'name'   => 'ingredients[milk]',
                               'values' => Form_Helper::build_select_options( $ingredient->filter_ingredients_by_type( 'milk' ) ) ),

                        array( 'type'   => 'select',
                               'name'   => 'ingredients[ice_cream][]',
                               'values' => Form_Helper::build_select_options( $ingredient->filter_ingredients_by_type( 'ice cream' ) ) )
                      );
        break;


        case 'float' :

          $fields = array(
                        array( 'type'   => 'hidden',
                               'name'   => 'ingredients[container]',
                               'values' => '9' ),

                        array( 'type'   => 'select',
                               'name'   => 'ingredients[soda]',
                               'values' => Form_Helper::build_select_options( $ingredient->filter_ingredients_by_type( 'soda' ) ) ),

                        array( 'type'   => 'select',
                               'name'   => 'ingredients[ice_cream][]',
                               'values' => Form_Helper::build_select_options( $ingredient->filter_ingredients_by_type( 'ice cream' ) ) )
                      );
        break;

        */
      }
    }

    return $fields;
  }
}