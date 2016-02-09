<?php $html = '';

if( $action != null && $fields != null )
{
  $html .= '<form data-ajax-form data-action="'.$action.'">
              <div data-form-msg></div>
              <ul>
                '.$fields.'
                <button type="submit" class="btn btn-primary">Create '.$type_name.'</button>
              </ul>
            </form>';
}

echo $html;