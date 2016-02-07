;(function( $, window, undefined )
{
  $.fn.extend({
    ajax_form:{
      el:'',
      action:'',
      target:'',
      init:function( el )
      {
        if( el[0] != undefined )
        {
          this.el           = el;
          this.action       = this.el.data('action');
          this.target       = this.el.data('target');
        }
      },
      init_listeners:function()
      {
        $(document).on( 'register_ajax_forms', function( e )
        {
          $('[data-ajax-form]').each( function()
          {
            $.fn.ajax_form.init( $(this) )

            var selects = $(this).find('[data-ajax-select]');

            if( selects.length )
            {
              selects.each( function()
              {
                $.fn.ajax_select.init( $(this) )
              })
            }
          })
        })

        $(document).on( 'submit', this, function( e )
        {
          e.preventDefault();
          e.data.make_request( e.data );
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

    },
    ajax_select:{
      el:'',
      init:function( el )
      {
        this.el = el;

        this.el.on( 'change', function()
        {
          $(this).closest('[data-ajax-form]').trigger('submit')
        })
      }
    },
    callback_bank:{
      choose_product_type:function( resp, instance )
      {
        var target = $('[data-updateable-content="' + instance.target + '"]');

        resp.status ? target.html( resp.data.new_form ) : '' ;

        $(document).trigger( 'register_ajax_forms' );
        $(document).trigger( 'hide_loader' );
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
  })


  $(document).ready(function()
  {
    if( $('[data-loader]')[0] != undefined )
      $.fn.loader.init( $('[data-loader]') );

    if( $('[data-flyout-trigger]')[0] != undefined )
      $.fn.flyout.init( $('[data-flyout]'), $('[data-flyout-trigger]') );

    $.fn.flyout.init_listeners();

    $.fn.ajax_form.init_listeners();
    $(document).trigger('register_ajax_forms' );

  })

})( jQuery, window )