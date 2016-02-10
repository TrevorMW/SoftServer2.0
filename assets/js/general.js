;(function( $, window, undefined )
{
  $.fn.extend({
    ajax_form:{
      el:'',
      action:'',
      target:'',
      form_msg:'',
      init:function( el )
      {
        if( el[0] != undefined )
        {
          this.el           = el;
          this.action       = this.el.data('action');
          this.target       = this.el.data('target');
          this.form_msg     = this.el.find('[data-form-msg]');
        }
      },
      init_listeners:function()
      {
        $(document).on( 'register_form', function( e, data )
        {
          $.fn.ajax_form.init( $(data) )
        })

        $(document).on( 'submit', this, function( e )
        {
          e.preventDefault();
          e.data.make_request( e.data )
        })
      },
      make_request: function( instance )
      {
        $(document).trigger( 'show_loader' );

        var formData = this.el.serializeArray(),
            data     = {}

        $.each( formData, function()
        {
          if( data[this.name] !== undefined )
          {
            if( !data[this.name].push )
              data[this.name] = [ data[this.name] ];

            data[this.name].push( this.value || '' );
          }
          else
            data[this.name] = this.value || '';
        });

        data.action = this.action;

        $.post( ajax_url + this.action + '.php' , data, function( response )
        {
          var new_data = $.parseJSON( response );

          setTimeout( function( data, instance )
          {
            if( $.fn.callback_bank.hasOwnProperty( data.callback ) )
              $.fn.callback_bank[new_data.callback]( data, instance );

          }, 500, new_data, instance )

          typeof after_request == 'function' ? after_request( data, new_data, instance ) : '' ;
        });
      }
    },
    ajax_get:{
      el:'',
      action:'',
      target:'',
      data:'',
      init:function( el )
      {
        this.el     = el;
        this.action = this.el.data('action');
        this.target = this.el.data('target');
        this.data   = this.el.data('extra-data');

        this.el.on( 'click', this, function( e )
        {
          e.preventDefault();
          e.data.make_request( e.data );
        })
      },
      init_listeners:function()
      {
        $(document).on( 'register_form', function()
        {
          $('[data-ajax-get]').each( function()
          {
            $.fn.ajax_get.init( $(this) )
          })
        })
      },
      make_request:function( instance )
      {
        var form_data = {};

        $(document).trigger( 'show_loader' );

        form_data.type   = this.data,
        form_data.action = this.action;

        $.post( ajax_url + this.action + '.php' , form_data, function( response )
        {
          var new_data = $.parseJSON( response );

          setTimeout( function( data, instance )
          {
            if( $.fn.callback_bank.hasOwnProperty( data.callback ) )
              $.fn.callback_bank[new_data.callback]( data, instance );

          }, 500, new_data, instance )

        });
      }
    },
    callback_bank:{
      choose_product_type:function( resp, instance )
      {
        var target = $('[data-updateable-content="' + instance.target + '"]');

        target.hide();

        resp.status ? target.html( resp.data.new_form ) : target.html( resp.message ) ;

        target.fadeIn();

        $(document).trigger( 'register_form', target.find('form') );
        $(document).trigger( 'hide_loader' );
      },
      add_field:function( resp, instance )
      {
        resp.status ? instance.el.before( '<li>' + resp.data.field + '</li>' ) : '' ;

        $(document).trigger( 'hide_loader' );
      },
      user_register:function( resp, instance )
      {
        $(document).trigger( 'hide_loader' );

        $.fn.form_msg.init( instance.form_msg );
        $.fn.form_msg.remove_msg();

        resp.status ? klass = 'success' : klass = 'error' ;

        $.fn.form_msg.add_msg( resp.message, klass );
      },
      user_login:function( resp, instance )
      {
        $(document).trigger( 'hide_loader' );

        $.fn.form_msg.init( instance.form_msg );
        $.fn.form_msg.remove_msg();

        resp.status ? klass = 'success' : klass = 'error' ;
        $.fn.form_msg.add_msg( resp.message, klass );

        if( resp.status )
        {
          setTimeout(function()
          {
            location.reload();
          }, 1000 )
        }
      },
      add_to_cart:function( resp, instance )
      {
        $(document).trigger( 'hide_loader' );

        resp.status ? klass = 'success' : klass = 'error' ;
        $.fn.form_msg.init( instance.form_msg );
        $.fn.form_msg.remove_msg();
        $.fn.form_msg.add_msg( resp.message, klass );

        setTimeout(function()
        {
          location.reload();
        }, 1000 )
      },
      submit_coupon:function( resp, instance )
      {
        $(document).trigger( 'hide_loader' );

        $.fn.form_msg.init( instance.form_msg );
        $.fn.form_msg.remove_msg();

        var total      = $('[data-checkout-total]'),
            order_total = $('[data-order-total]')

        if( resp.status )
        {
          total.html( resp.data.discount_html )
          order_total.val( resp.data.discount_total );
        }
        else
        {
          $.fn.form_msg.add_msg( resp.message, 'error' )
        }
      },
      submit_order:function( resp, instance )
      {
        $.fn.form_msg.init( instance.form_msg );
        $.fn.form_msg.remove_msg();

        var checkout_forms = $('[data-checkout-forms]');

        resp.status ? checkout_forms.html( resp.message ) : $.fn.form_msg.add_msg( resp.message, 'error' ) ;
      }
    },
    flyout:{
      el:'',
      trigger:'',
      destroy:null,
      init:function( el, trigger )
      {
        this.el      = el;
        this.trigger = trigger;
      },
      init_listeners:function()
      {
        this.trigger.click( function( e )
        {
          e.preventDefault();
          $(document).trigger( 'toggle_flyout' );
        })

        $(document).on( 'toggle_flyout',  this, function( e ){ e.data.toggle_flyout( e.data )  })
      },
      toggle_flyout:function( instance )
      {
        this.destroy = instance.el.find('[data-destroy-flyout]');

        if( this.destroy[0] != undefined )
        {
          this.destroy.click( function( e )
          {
            e.preventDefault();
            $(document).trigger( 'toggle_flyout' );
          })
        }

        $('body').toggleClass('flyout-open')

        instance.trigger.toggleClass('active');
        instance.el.toggleClass('active');

        $(document).trigger( 'load_async_content' );
      }
    },
    loader:{
      el:'',
      init:function( el )
      {
        this.el = el;

        $(document).on( 'show_loader',  this, function( e ){ e.data.show_loader() })
        $(document).on( 'hide_loader',  this, function( e ){ e.data.hide_loader() })
      },
      show_loader:function()
      {
        this.el.addClass('active');
        this.el.addClass('fadein');
      },
      hide_loader:function()
      {
        this.el.removeClass('fadein');

        setTimeout( function( inst )
        {
          inst.el.removeClass('active');
        }, 300, this )
      }
    },
    form_msg:{
      el:'',
      init:function( el )
      {
        this.el = el;
        this.el.html('');
      },
      add_msg:function( msg, status )
      {
        status ? klass = 'success' : klass = 'error' ;
        this.el.html( msg ).addClass( 'active ' + klass );
      },
      remove_msg:function()
      {
        this.el.html('').removeClass();
      }
    },
    tabs:{
      tabs:'',
      triggers:'',
      init:function( tabs, triggers )
      {
        this.tabs     = tabs;
        this.triggers = triggers;

        this.triggers.on( 'click', 'a', this, function( e )
        {
          e.data.show_tab( $(this) )
        })
      },
      show_tab:function( el )
      {
        this.hide_all();

        el.addClass('active');

        var id = el.data('tab-trigger');

        this.tabs.find('[data-tab="' + id + '"]').addClass('active');
      },
      hide_all:function()
      {
        this.triggers.find('[data-tab-trigger]').each(function()
        {
          $(this).removeClass('active');
        })

        this.tabs.find('[data-tab]').each(function()
        {
          $(this).removeClass('active');
        })

      }
    },
    async_content:{
      el:'',
      init:function( el )
      {
        this.el = el;
      },
      init_listeners:function()
      {
        $(document).on( 'load_async_content', this, function( e, data )
        {

        })
      },
      load_content:function()
      {

      }
    },
    popup:{
      el:'',
      trigger:'',
      init:function( trigger )
      {
        this.trigger = trigger
        this.el      = $('[data-popup="'+ this.trigger.data('trigger-popup') + '"]');
        this.destroy = this.el.find('[data-destroy-popup]');

        this.trigger.click( this, function( e )
        {
          e.preventDefault();
          $(document).trigger( 'toggle_flyout' );

          e.data.show_popup();
        })

        this.destroy.click( this, function( e )
        {
          e.preventDefault();
          e.data.hide_popup();
        })
      },
      show_popup:function()
      {
        $('body').addClass('lock');
        this.el.addClass('active');
      },
      hide_popup:function()
      {
        $('body').removeClass('lock');
        this.el.removeClass('active');
      }
    }
  })


  $(document).ready(function()
  {
    if( $('[data-loader]')[0] != undefined )
      $.fn.loader.init( $('[data-loader]') );

    if( $('[data-tabs]')[0] != undefined && $('[data-tab-triggers]')[0] != undefined )
      $.fn.tabs.init( $('[data-tabs]'), $('[data-tab-triggers]') );

    if( $('[data-popup]')[0] != undefined && $('[data-trigger-popup]')[0] != undefined )
      $.fn.popup.init( $('[data-trigger-popup]') );

    if( $('[data-flyout-trigger]')[0] != undefined && $('[data-flyout]')[0] != undefined )
    {
      $.fn.flyout.init( $('[data-flyout]'), $('[data-flyout-trigger]') );
      $.fn.flyout.init_listeners();
    }


    $.fn.ajax_get.init_listeners();
    $.fn.ajax_form.init_listeners();

    if( $('[data-ajax-form]')[0] != undefined )
    {
      $('[data-ajax-form] button[type="submit"]').click( function( e )
      {
        e.preventDefault();
        var form = $(this).closest('[data-ajax-form]')
        form.trigger( 'register_form', form ).trigger('submit');
      })

      $('[data-ajax-select]').change( function()
      {
        var form = $(this).closest('[data-ajax-form]')

        form.trigger( 'register_form', form ).trigger( 'submit' );
      })
    }
  })

})( jQuery, window )