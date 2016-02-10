<?php $html = $ingredients = '';

if( is_array( $cart_item ) && !empty( $cart_item ) )
{
  if( is_array( $cart_item['product_ingredients'] ) && !empty( $cart_item['product_ingredients'] ) )
  {
    foreach( $cart_item['product_ingredients'] as $ingredient )
    {
      $type = new Ingredient_Type( $ingredient->ingredient_type );

      $ingredients .= '<li>'.$type->ingredient_type_name.' - '.$ingredient->ingredient_name.'</li>';
    }
  }

  $html .= '<li class="cart-item">
              <span>'.$cart_item['product_price_total'].'</span>
              <h2>'.$cart_item['product_type'].'</h2>
              <ul>'.$ingredients.'</ul>
            </li>';
}

echo $html;