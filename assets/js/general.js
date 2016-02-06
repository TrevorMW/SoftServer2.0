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
        var formData = this.el.serializeArray(),
            data = {}

        $.each( formData, function()
        {
          if( data[this.name] !== undefined )
          {
            if( !data[this.name].push )
            {
              data[this.name] = [ data[this.name] ];
            }
            data[this.name].push( this.value || '' );
          }
          else
          {
            data[this.name] = this.value || '';
          }
        });

        $.post( ajax_url + this.action + '.php' , data, function( response )
        {
          var new_data = $.parseJSON( response );

          if( $.fn.callback_bank.callbacks.hasOwnProperty( new_data.callback ) )
            $.fn.callback_bank.callbacks[new_data.callback]( new_data, instance );

          typeof after_request == 'function' ? after_request( data, new_data, instance ) : '' ;
        });
      }
    },
    loader:{
      el:'',
      init:function()
      {

      },
      init_listeners:function()
      {

      },
      show_loader:function()
      {

      },
      hide_loader:function()
      {

      }
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
    }
    flyout:{
      el:'',
      trigger:'',
      destroy:'',
      init:function()
      {

      },
      init_events:function()
      {
        $(document).on( 'open_flyout',  this, function( e ){ e.data.open_flyout() })

        $(document).on( 'close_flyout', this, function( e ){ e.data.close_flyout() })
      },
      open_flyout:function()
      {

      },
      close_flyout:function()
      {

      }
    }
  })


  $(document).ready(function()
  {
    $.fn.ajax_form.init_listeners();
    $(document).trigger('register_ajax_forms' );

  })

})( jQuery, window )