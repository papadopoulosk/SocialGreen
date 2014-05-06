$( function()
  {
    //styleselector
    $( '#styleselector-toggle' ).bind( 'click', 
      function()
      {
        target = $( '#styleselector' );
        
        if( target.css( 'right' ) == '0px' )
        {
          target.animate( {
            right: '-175px'
          } );
        }
        else
        {
          target.animate( {
            right: '0px'
          } );
        }
      } );
      
    $( '#colors li' ).bind( 'click', 
      function()
      {
      	alert(1);
        $( '#colors li' ).removeClass( 'color-active' );
        $( this ).addClass( 'color-active' );
        
        color = $( this ).attr( 'id' );
        
        if( color == 'violet' )
        {
          $( '#styleselector_css' ).attr( 'href', '' );
        } else {
          $( '#styleselector_css' ).attr('href', 'stylesheets/' + color + '.css');
        }
      } );
