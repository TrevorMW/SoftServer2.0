<?php $html = '';

if( is_array( $checkout ) && !empty( $checkout ) )
{
  $html .= '<div class="checkout" data-checkout-forms>
              <div data-checkout-total><h1>'.Text_Helper::format_string_as_price( $checkout['cart_total'] ).'</h1></div>
              <form data-ajax-form data-action="submit_coupon">
                <div data-form-msg></div>
                '.implode( '', $checkout['types'] ).'
                <ul class="inline">
                  <li><input type="text" name="coupon_code" value="" /></li>
                  <li class="submit"><button type="submit"  class="btn btn-primary">Add Coupon</button></li>
                </ul>
              </form>

              <form data-ajax-form data-action="submit_order">

                <label>Credit Card #:</label>
                <ul>
                  <div data-form-msg></div>
                  <li><input type="text" name="fake_cc" value="" /></li>
                  <input type="hidden" name="order_total" data-order-total value="'.$checkout['cart_total'].'" />
                  <li class="submit"><button type="submit" class="btn btn-primary btn-huge">Submit Order!</button></li>
                </ul>
                '.implode( '', $checkout['products'] ).'
              </form>
            </div>';
}

echo $html;