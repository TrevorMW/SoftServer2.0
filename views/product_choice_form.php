<?php $html = '';

if( true )
{
  $html .= '<form data-ajax-form data-action="'.$action.'">
              <ul>
                '.$fields.'
                <button type="submit" class="btn btn-primary">Create '.$type_name.'</button>
              </ul>
            </form>';
}

echo $html;