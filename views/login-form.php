<?php $html = '';

if( is_array( $login ) )
{
  $html .= '<form data-ajax-form data-action="'.$login['action'].'" validate autocomplete="off"><div data-form-msg></div>';

    $html .= '<ul>';

      if( $login['mode'] == 'register' )
      {
        $html .= '<li class="two-third">';
          $html .= '<label>User Name:</label>';
          $html .= '<input type="text" name="user_name" value="" required />';
        $html .= '</li>';
      }
      else
      {
        $html .= '<li class="full">';
          $html .= '<label>User Name:</label>';
          $html .= '<input type="text" name="user_name" value="" required />';
        $html .= '</li>';
      }

      if( $login['mode'] == 'register' )
      {
        $html .= '<li class="half">';
          $html .= '<label>Password:</label>';
          $html .= '<input type="password" name="password" value="" required />';
        $html .= '</li>';

        $html .= '<li class="half right">';
          $html .= '<label>Retype Password:</label>';
          $html .= '<input type="password" name="pass_again" value="" required/>';
        $html .= '</li>';
      }
      else
      {
        $html .= '<li class="full">';
          $html .= '<label>Password:</label>';
          $html .= '<input type="password" name="password" value="" required />';
        $html .= '</li>';
      }

      if( $login['mode'] == 'register' )
      {
        $html .= '<li class="submit">';
          $html .= '<button type="submit" class="btn btn-primary">'.$login['btn'].'</button>';
        $html .= '</li>';
      }
      else
      {
        $html .= '<li class="submit">';
          $html .= '<button type="submit" class="btn btn-primary">'.$login['btn'].'</button>';
        $html .= '</li>';
      }

      $html .= '<input type="hidden" name="honey_pot" value="" />';

    $html .= '</ul>';
  $html .= '</form>';
}


echo $html;