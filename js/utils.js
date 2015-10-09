/*!
 * Start Bootstrap - Agency Bootstrap Theme (http://startbootstrap.com)
 * Code licensed under the Apache License v2.0.
 * For details, see http://www.apache.org/licenses/LICENSE-2.0.
 */

// jQuery for page scrolling feature - requires jQuery Easing plugin
$( function () {
  $( 'a.page-scroll' ).bind( 'click', function ( event ) {
    var $anchor = $( this );
    $( 'html, body' ).stop().animate( {
      scrollTop: $( $anchor.attr( 'href' ) ).offset().top
    }, 1500, 'easeInOutExpo' );
    event.preventDefault();
  } );
} );

// Highlight the top nav as scrolling occurs
$( 'body' ).scrollspy( {
  target: '.navbar-fixed-top'
} )

// Closes the Responsive Menu on Menu Item Click
$( '.navbar-collapse ul li a' ).click( function () {
  $( '.navbar-toggle:visible' ).click();
} );

$( function () {
  $( "#envioEmail" ).click( function () {
    $( this ).val()
    $.ajax( {
      url: '/encuesta-intermed/codigo/dataPostCorreo',
      type: "POST",
      dataType: 'JSON',
      async: true,
      success: function () {
        $( "#doctor" ).load( '/encuesta-intermed/porValidar/index' )
      },
      error: function () {
        console.log( "Error: AJax dead :(" );
      }
    } );
  } );
} );

//radio on change hide div
$( function () {
  $( '#medicoRadio' ).click( function () {
    if ( $( this ).prop( "checked", true ) ) {
      $( "#medicoSolicitud" ).removeClass( "hidden" );
      $( "#usuarioSolicitud" ).addClass( "hidden" );
    }
  } );
  $( '#usuarioRadio' ).click( function () {
    if ( $( this ).prop( "checked", true ) ) {
      $( "#medicoSolicitud" ).addClass( "hidden" );
      $( "#usuarioSolicitud" ).removeClass( "hidden" );
    }
  } );
} );


/*Funciones encuesta*/

$( '#progress-bar-current' ).popover( {
  animation: false
} );
$( '#progress-bar-current' ).popover( 'show' );
$( '.popover.top.in' ).each( function ( index, element ) {
  $( element ).css( 'left', ( parseInt( $( element ).css( 'left' ) ) - 25 + parseInt( $( '#progress-bar-current' ).css( 'width' ) ) / 2 ) );
} );

$( window ).resize( function () {
  $( '#progress-bar-current' ).popover( 'show' );
  $( '.popover.top.in' ).each( function ( index, element ) {
    $( element ).css( 'left', ( parseInt( $( element ).css( 'left' ) ) - 25 + parseInt( $( '#progress-bar-current' ).css( 'width' ) ) / 2 ) );
  } );
} );

$( document ).ready( function () {
  validarFormulario();
} );

$( function () {
  $( "·sortable" ).sortable( {
    placeholder: "ui-state-highlight"
  } );
  $( ".sortable" ).disableSelection();
} );

$( ".sortable" ).sortable( {
  stop: function ( event, ui ) {
    var count = 1;
    var opciones = $( ".sortable" ).find( "input[type=hidden]" ).each( function ( index, element ) {
      $( element ).val( count++ );
    } );
  }
} );

function guardarysal() {
  if (!($( '#btnguardarysalir' ).hasClass( 'notEnabled' ))){
    $( '#continuar' ).val( '0' );
    $( "#formEnc" ).submit();
  } else {
    $('#encError').html('<div class="alert alert-danger" role="alert" id="danger-alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><span class="sr-only">Error:</span> Por favor contesta las preguntas faltantes.</div>');
    marcarFaltantes();
    $("#danger-alert").fadeTo(2000, 500).slideUp(500, function(){
        $("#danger-alert").alert('close');
        $('#encError').html('');
    });
  }
}

function guardarycont() {
  if (!($( '#btnguardarycontinuar' ).hasClass( 'notEnabled' ))){
    $( '#continuar' ).val( '1' );
    $( "#formEnc" ).submit();
  } else {
    $('#encError').html('<div class="alert alert-danger" role="alert" id="danger-alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><span class="sr-only">Error:</span> Por favor contesta las preguntas faltantes.</div>');
    marcarFaltantes();
    $("#danger-alert").fadeTo(2000, 500).slideUp(500, function(){
        $("#danger-alert").alert('close');
        $('#encError').html('');
    });
  }
}

function regresar() {
  $etapa = $( '#etapaResp' ).val();
  $( '#irEtapa' ).val( --$etapa );
  $( '#contenido' ).html( '' );
  $( "#formEnc" ).submit();
}

function siguiente() {
  $etapa = $( '#etapaResp' ).val();
  $( '#irEtapa' ).val( ++$etapa );
  $( '#contenido' ).html( '' );
  $( "#formEnc" ).submit();
}

function marcarFaltantes(){
  var formulario = $( 'form#formEnc' ).serializeArray();
  $( 'input' ).each( function () {
    var field = $( this );
    if ( field.prop( 'name' ).substring( 0, 9 ) == "respuesta" ) {
      if ( field.prop( 'type' ) == "radio" ) {
        //Buscar por lo menos uno
        var encontrado = false;
        formulario.forEach( function ( form ) {
          if ( form[ 'name' ] == field.prop( 'name' ) ) {
            encontrado = true;
          }
        } );
        if ( encontrado == false ) {
          field.parent().parent().addClass("has-error");
          field.parent().parent().focusin(function(){
              $( this ).removeClass("has-error");
              $( this ).find('label').removeClass("has-error");
          });
        }
      }
      else {
        if ( field.prop( 'required' ) && field.prop( 'value' ) == "" ) {
          field.parent().parent().addClass("has-error");
          field.parent().parent().focusin(function(){
              $( this ).removeClass("has-error");
              $( this ).find('label').removeClass("has-error");
          });
        }
      }
    }
    else if ( field.prop( 'name' ).substring( 0, 11 ) == "complemento" ) {
      if ( field.prop( 'required' ) && field.prop( 'value' ) == "" ) {
        field.parent().addClass("has-error");
        field.parent().focusin(function(){
            $( this ).removeClass("has-error");
            $( this ).find('label').removeClass("has-error");
        });
      }
    }
  } );
}

function comprobar() {
  var arrText = $( 'input' ).map( function () {
    if ( !this.value ) {
      this.name = '';
    }
  } ).get();
}

$( 'input' ).change( function ( event ) {
  validarFormulario();
} );

function validarFormulario() {
  var continuar = true;
  var formulario = $( 'form#formEnc' ).serializeArray();
  $( 'input' ).each( function () {
    var field = $( this );
    if ( field.prop( 'name' ).substring( 0, 9 ) == "respuesta" ) {
      if ( field.prop( 'type' ) == "radio" ) {
        //Buscar por lo menos uno
        var encontrado = false;
        formulario.forEach( function ( form ) {
          if ( form[ 'name' ] == field.prop( 'name' ) ) {
            encontrado = true;
          }
        } );
        if ( encontrado == false ) {
          continuar = false;
        }
      }
      else {
        if ( field.prop( 'required' ) && field.prop( 'value' ) == "" ) {
          continuar = false;
        }
      }
    }
    else if ( field.prop( 'name' ).substring( 0, 11 ) == "complemento" ) {
      if ( field.prop( 'required' ) && field.prop( 'value' ) == "" ) {
        continuar = false;
      }
    }
  } );
  if ( continuar ) {
    $( '#btnguardarycontinuar' ).removeClass( 'notEnabled' );
    $( '#btnguardarysalir' ).removeClass( 'btn-default' );
    $( '#btnguardarycontinuar' ).removeClass( 'btn-default' );
    $( '#btnguardarysalir' ).addClass( 'btn-warning' );
    $( '#btnguardarycontinuar' ).addClass( 'btn-success' );
    //$( '#btnguardarysalir' ).attr( "disabled", false );
    //$( '#btnguardarycontinuar' ).attr( "disabled", false );
  }
  else {
    $( '#btnguardarysalir' ).removeClass( 'btn-warning' );
    $( '#btnguardarycontinuar' ).removeClass( 'btn-success' );
    $( '#btnguardarysalir' ).addClass( 'btn-default' );
    $( '#btnguardarycontinuar' ).addClass( 'btn-default' );
    $( '#btnguardarycontinuar' ).addClass( 'notEnabled' );
    //$( '#btnguardarysalir' ).attr( "disabled", true );
    //$( '#btnguardarycontinuar' ).attr( "disabled", true );
  }
}

function salir() {
  window.location.href = "/encuesta-intermed";
}

function LimpiarComplementos( id, comp ) {
  $( "input[name='complemento_" + id + "']" ).each( function () {
    $( this ).val( '' );
    $( this ).prop( 'required', false );
    $( this ).prop( 'disabled', true );
  } );
  if ( $( '#complemento_' + id + '_' + comp ) ) {
    $( '#complemento_' + id + '_' + comp ).prop( 'required', true );
    $( '#complemento_' + id + '_' + comp ).prop( 'disabled', false );
    $( '#complemento_' + id + '_' + comp ).focus();
  }
}

function HabilitarComplementos( id, comp ) {
  if($('#respuesta_' + id + '_' + comp).is(':checked')){
    $( '#complemento_' + id + '_' + comp ).prop( 'required', true );
    $( '#complemento_' + id + '_' + comp ).prop( 'disabled', false );
  } else {
    $( '#complemento_' + id + '_' + comp ).val('');
    $( '#complemento_' + id + '_' + comp ).prop( 'required', false );
    $( '#complemento_' + id + '_' + comp ).prop( 'disabled', true );
  }
}

function aceptarPromocion() {
  var value = $( '#promo' ).prop( 'checked' );
  if ( value == true ) {
    var contenido = '<form method="POST" action="newsletter">' +
      '<div class="form-group">' +
      '<label for="nombre">Nombre:</label>' +
      '<input type="text" class="form-control" id="nombre" name="nombre" required>' +
      '</div>' +
      '<div class="form-group">' +
      '<label for="email">Correo:</label>' +
      '<input type="email" name="email" class="form-control" id="email" required>' +
      '</div>' +
      '<input type="submit" value="Enviar" class="btn btn-success btn-lg btn-block"></form>' +
      '</div>';
    $( '#contenido' ).html( contenido );
  }
  else {
    $( '#contenido' ).html( '' );
  }
}

function validarMoneda( e, item ) {
  var aceptarPunto = false;
  if ( parseInt( $( item ).val().indexOf( "." ) ) == -1 && $( item ).val().length > 0 ) aceptarPunto = true;
  var key = window.Event ? e.which : e.keyCode;
  return ( ( key >= 48 && key <= 57 ) || ( key == 8 ) || ( key == 46 && aceptarPunto ) )
}

function formatoMoneda( item ) {
  if ( $( item ).val().length > 0 )
    $( item ).val( parseFloat( $( item ).val(), 10 ).toFixed( 2 ) );
}

/*Fin funciones encuesta*/

/*Resultados*/

function MorrisDonut(element, data){
  if(document.getElementById(element) !== null){
    new Morris.Donut({
      // ID of the element in which to draw the chart.
      element: element,
      // Chart data records -- each entry in this array corresponds to a point on
      // the chart.
      data: data,
      // The name of the data record attribute that contains x-values.
      hideHover: 'auto',
      resize: true
    });
  }
}

function MorrisBar(element, data, ykeys){
  if(document.getElementById(element) !== null){
    new Morris.Bar({
    // ID of the element in which to draw the chart.
    element: element,
      data: [{
          label: '2006',
          value: 100
      }, {
          label: '2007',
          value: 75
      }, {
          label: '2008',
          value: 50
      }, {
          label: '2009',
          value: 75
      }, {
          label: '2010',
          value: 50
      }, {
          label: '2011',
          value: 75
      }, {
          label: '2012',
          value: 100
      }],
      xkey: 'label',
      ykeys: ['value'],
      hideHover: 'auto',
      resize: true
  });
  }
}


function ChartBar(data){
  var element = data.element;
  var labels = [];
  var values = [];
  var height = 100;
  var largo = 0;
  var count = 0;
  var long = 0;
  data.data.forEach(function (result){
    if (result.label.length > 15) largo++;
    if (result.value > 20) long = 100;
    labels.push(result.label);
    values.push(result.value);
    count++;
  });

  height = (150+(30*largo) +50 + long);

  var r = (Math.floor(Math.random() * 256));
  var g = (Math.floor(Math.random() * 256));
  var b = (Math.floor(Math.random() * 256));

  var barChartData = {
    labels : labels,
    datasets : [
      {
        fillColor : "rgba("+r+","+g+","+b+",0.5)",
        strokeColor : "rgba("+r+","+g+","+b+",0.8)",
        highlightFill : "rgba("+r+","+g+","+b+",0.75)",
        highlightStroke : "rgba("+r+","+g+","+b+",1)",
        data : values
      }
    ]
  }
  $('#'+element).html('<canvas id="canvas_'+element+'" class="col-lg-12 col-md-12"></canvas>');
  var canvas = document.getElementById('canvas_'+element);
  var ctx = canvas.getContext("2d");
  var MyChart = new Chart(ctx).Bar(barChartData, {
    responsive : true,
    tooltipTemplate: "<%if (label){%><%=label%> [ <%}%><%= value %> ]"
  });

  canvas.onclick = function(evt){
      var activePoints = MyChart.getBarsAtEvent(evt);
      var closePopovers = true;
      data.data.forEach(function (result){
        if (activePoints[0]){
          if (result.label == activePoints[0]['label']){
            if (result.complemento){
              closePopovers = false;

              console.log('COMPLEMENTO: ' + JSON.stringify(result.complemento));
              var valuescomp = [];
              var labelscomp = [];
              result.complemento.forEach(function (complemento){
                //$('#'+element+'_complemento').attr('data-content',$('#'+element+'_complemento').attr('data-content')+'<li> [' + complemento.total + '] '+complemento.comp + '</li>');
                labelscomp.push(complemento.comp);
                valuescomp.push(complemento.total);
              });
              var r = (Math.floor(Math.random() * 256));
              var g = (Math.floor(Math.random() * 256));
              var b = (Math.floor(Math.random() * 256));
              var barChartData = {
                labels : labelscomp,
                datasets : [
                  {
                    fillColor : "rgba("+r+","+g+","+b+",0.5)",
                    strokeColor : "rgba("+r+","+g+","+b+",0.8)",
                    highlightFill : "rgba("+r+","+g+","+b+",0.75)",
                    highlightStroke : "rgba("+r+","+g+","+b+",1)",
                    data : valuescomp
                  }
                ]
              }
              $('#'+element+'_complemento').attr('data-original-title',result.label + '<button type="button" class="close" aria-label="Close" onclick="cerrarPopovers()"><span aria-hidden="true">&times;</span></button>');
              $('#'+element+'_complemento').attr('data-content','<canvas id="canvas_complemento_'+element+'" class="col-lg-12 col-md-12" style="width:380px;margin-bottom:30px;"></canvas>');
              //var testPopover = $('#canvas_'+element).parent();

              $('[data-toggle="popover"]').not($('#'+element+'_complemento')).popover('hide');
              $('#'+element+'_complemento').popover('show');

              var canvas2 = document.getElementById('canvas_complemento_'+element);
              var ctx2 = canvas2.getContext("2d");
              var MyChart = new Chart(ctx2).Bar(barChartData, {
                responsive : true,
                tooltipTemplate: "<%if (label){%><%=label%> [ <%}%><%= value %> ]"
              });
            }
          }
        }
      });
      if (closePopovers){
        $('[data-toggle="popover"]').popover('hide');
      }
  };
}

function ChartRadar(data){
  var element = data['element'];
  var labels = [];
  var values = [];
  data.data.forEach(function (result){
    labels.push(result.label);
    values.push(result.value);
  });

  var r = (Math.floor(Math.random() * 256));
  var g = (Math.floor(Math.random() * 256));
  var b = (Math.floor(Math.random() * 256));

  var barChartData = {
    labels : labels,
    datasets : [
      {
        fillColor : "rgba("+r+","+g+","+b+",0.5)",
        strokeColor : "rgba("+r+","+g+","+b+",0.8)",
        highlightFill : "rgba("+r+","+g+","+b+",0.75)",
        highlightStroke : "rgba("+r+","+g+","+b+",1)",
        data : values
      }
    ]
  }

  $('#'+element).html('<canvas id="canvas_'+element+'" class="col-lg-12 col-md-12"></canvas>');
  var canvas = document.getElementById('canvas_'+element);
  var ctx = canvas.getContext("2d");
  var MyChart = new Chart(ctx).Radar(barChartData, {
    responsive : true,
    tooltipTemplate: "<%if (label){%><%=label%> [ <%}%><%= value %> ]"
  });

  canvas.onclick = function(evt){
      var activePoints = MyChart.getPointsAtEvent(evt);
      var closePopovers = true;
      data.data.forEach(function (result){
        if (activePoints[0]){
          if (result.label == activePoints[0]['label']){
            if (result.complemento){
              closePopovers = false;

              console.log('COMPLEMENTO: ' + JSON.stringify(result.complemento));
              var valuescomp = [];
              var labelscomp = [];
              result.complemento.forEach(function (complemento){
                //$('#'+element+'_complemento').attr('data-content',$('#'+element+'_complemento').attr('data-content')+'<li> [' + complemento.total + '] '+complemento.comp + '</li>');
                labelscomp.push(complemento.comp);
                valuescomp.push(complemento.total);
              });
              var r = (Math.floor(Math.random() * 256));
              var g = (Math.floor(Math.random() * 256));
              var b = (Math.floor(Math.random() * 256));
              var barChartData = {
                labels : labelscomp,
                datasets : [
                  {
                    fillColor : "rgba("+r+","+g+","+b+",0.5)",
                    strokeColor : "rgba("+r+","+g+","+b+",0.8)",
                    highlightFill : "rgba("+r+","+g+","+b+",0.75)",
                    highlightStroke : "rgba("+r+","+g+","+b+",1)",
                    data : valuescomp
                  }
                ]
              }
              $('#'+element+'_complemento').attr('data-original-title',result.label + '<button type="button" class="close" aria-label="Close" onclick="cerrarPopovers()"><span aria-hidden="true">&times;</span></button>');
              $('#'+element+'_complemento').attr('data-content','<canvas id="canvas_complemento_'+element+'" class="col-lg-12 col-md-12" style="width:380px;margin-bottom:30px;"></canvas>');
              //var testPopover = $('#canvas_'+element).parent();

              $('[data-toggle="popover"]').not($('#'+element+'_complemento')).popover('hide');
              $('#'+element+'_complemento').popover('show');

              var canvas2 = document.getElementById('canvas_complemento_'+element);
              var ctx2 = canvas2.getContext("2d");
              var MyChart = new Chart(ctx2).Radar(barChartData, {
                responsive : true,
                tooltipTemplate: "<%if (label){%><%=label%> [ <%}%><%= value %> ]"
              });
            }
          }
        }
      });
      if (closePopovers){
        $('[data-toggle="popover"]').popover('hide');
      }
  };
}

function ChartPie(data){
  var element = data['element'];
  var values = [];

  var b = (Math.floor(Math.random() * 256));
  var g = (Math.floor(Math.random() * 256));
  data.data.forEach(function (result){
    var r = (Math.floor(Math.random() * 256));
    values.push({
      value: result.value,
      color: "rgba("+r+","+g+","+b+",0.7)",
      highlight: "rgba("+r+","+g+","+b+",0.5)",
      label: result.label
    });
  });

  $('#'+element).html('<canvas id="canvas_'+element+'" class="col-lg-12 col-md-12"></canvas>');
  var canvas = document.getElementById('canvas_'+element);
  var ctx = canvas.getContext("2d");
  var MyChart =  new Chart(ctx).Pie(values, {
    responsive : true,
    tooltipTemplate: "<%if (label){%><%=label%> [ <%}%><%= value %> ]"
  });

  canvas.onclick = function(evt){
      var activePoints = MyChart.getSegmentsAtEvent(evt);
      var closePopovers = true;
      data.data.forEach(function (result){
        if (activePoints[0]){
          if (result.label == activePoints[0]['label']){
            if (result.complemento){
              closePopovers = false;

              var valuescomp = [];
              var labelscomp = [];
              result.complemento.forEach(function (complemento){
                var r = (Math.floor(Math.random() * 256));
                valuescomp.push({
                  value: complemento.total,
                  color: "rgba("+r+","+g+","+b+",0.7)",
                  highlight: "rgba("+r+","+g+","+b+",0.5)",
                  label: complemento.comp
                });
              });
              $('#'+element+'_complemento').attr('data-original-title',result.label + '<button type="button" class="close" aria-label="Close" onclick="cerrarPopovers()"><span aria-hidden="true">&times;</span></button>');
              $('#'+element+'_complemento').attr('data-content','<canvas id="canvas_complemento_'+element+'" class="col-lg-12 col-md-12" style="width:380px;margin-bottom:30px;"></canvas>');
              //var testPopover = $('#canvas_'+element).parent();

              $('[data-toggle="popover"]').not($('#'+element+'_complemento')).popover('hide');
              $('#'+element+'_complemento').popover('show');

              var canvas2 = document.getElementById('canvas_complemento_'+element);
              var ctx2 = canvas2.getContext("2d");
              var MyChart = new Chart(ctx2).Pie(valuescomp, {
                responsive : true,
                tooltipTemplate: "<%if (label){%><%=label%> [ <%}%><%= value %> ]"
              });
            }
          }
        }
      });
      if (closePopovers){
        $('[data-toggle="popover"]').popover('hide');
      }
  };
}

function ChartDoughnut(data){
  var element = data['element'];
  var values = [];

  var b = (Math.floor(Math.random() * 256));
  var g = (Math.floor(Math.random() * 256));
  data.data.forEach(function (result){
    var r = (Math.floor(Math.random() * 256));
    values.push({
      value: result.value,
      color: "rgba("+r+","+g+","+b+",0.7)",
      highlight: "rgba("+r+","+g+","+b+",0.5)",
      label: result.label
    });
  });

  $('#'+element).html('<canvas id="canvas_'+element+'" class="col-lg-12 col-md-12"></canvas>');
  var canvas = document.getElementById('canvas_'+element);
  var ctx = canvas.getContext("2d");
  var MyChart = new Chart(ctx).Doughnut(values, {
    responsive : true,
    tooltipTemplate: "<%if (label){%><%=label%> [ <%}%><%= value %> ]"
  });

  canvas.onclick = function(evt){
      var activePoints = MyChart.getSegmentsAtEvent(evt);
      var closePopovers = true;
      data.data.forEach(function (result){
        if (activePoints[0]){
          if (result.label == activePoints[0]['label']){
            if (result.complemento){
              closePopovers = false;

              var valuescomp = [];
              var labelscomp = [];
              result.complemento.forEach(function (complemento){
                var r = (Math.floor(Math.random() * 256));
                valuescomp.push({
                  value: complemento.total,
                  color: "rgba("+r+","+g+","+b+",0.7)",
                  highlight: "rgba("+r+","+g+","+b+",0.5)",
                  label: complemento.comp
                });
              });
              $('#'+element+'_complemento').attr('data-original-title',result.label + '<button type="button" class="close" aria-label="Close" onclick="cerrarPopovers()"><span aria-hidden="true">&times;</span></button>');
              $('#'+element+'_complemento').attr('data-content','<canvas id="canvas_complemento_'+element+'" class="col-lg-12 col-md-12" style="width:380px;margin-bottom:30px;"></canvas>');
              //var testPopover = $('#canvas_'+element).parent();

              $('[data-toggle="popover"]').not($('#'+element+'_complemento')).popover('hide');
              $('#'+element+'_complemento').popover('show');

              var canvas2 = document.getElementById('canvas_complemento_'+element);
              var ctx2 = canvas2.getContext("2d");
              var MyChart = new Chart(ctx2).Doughnut(valuescomp, {
                responsive : true,
                tooltipTemplate: "<%if (label){%><%=label%> [ <%}%><%= value %> ]"
              });
            }
          }
        }
      });
      if (closePopovers){
        $('[data-toggle="popover"]').popover('hide');
      }
  };
}

function ChartPolar(data){
  var element = data['element'];
  var values = [];

  var b = (Math.floor(Math.random() * 256));
  var g = (Math.floor(Math.random() * 256));
  data.data.forEach(function (result){
    var r = (Math.floor(Math.random() * 256));
    values.push({
      value: result.value,
      color: "rgba("+r+","+g+","+b+",0.7)",
      highlight: "rgba("+r+","+g+","+b+",0.5)",
      label: result.label
    });
  });
  $('#'+element).html('<canvas id="canvas_'+element+'" class="col-lg-12 col-md-12"></canvas>');
  var canvas = document.getElementById('canvas_'+element);
  var ctx = canvas.getContext("2d");
  var MyChart = new Chart(ctx).PolarArea(values, {
    responsive : true,
    tooltipTemplate: "<%if (label){%><%=label%> [ <%}%><%= value %> ]"
  });

  canvas.onclick = function(evt){
      var activePoints = MyChart.getSegmentsAtEvent(evt);
      var closePopovers = true;
      data.data.forEach(function (result){
        if (activePoints[0]){
          if (result.label == activePoints[0]['label']){
            if (result.complemento){
              closePopovers = false;

              var valuescomp = [];
              var labelscomp = [];
              result.complemento.forEach(function (complemento){
                var r = (Math.floor(Math.random() * 256));
                valuescomp.push({
                  value: complemento.total,
                  color: "rgba("+r+","+g+","+b+",0.7)",
                  highlight: "rgba("+r+","+g+","+b+",0.5)",
                  label: complemento.comp
                });
              });
              $('#'+element+'_complemento').attr('data-original-title',result.label + '<button type="button" class="close" aria-label="Close" onclick="cerrarPopovers()"><span aria-hidden="true">&times;</span></button>');
              $('#'+element+'_complemento').attr('data-content','<canvas id="canvas_complemento_'+element+'" class="col-lg-12 col-md-12" style="width:380px;margin-bottom:30px;"></canvas>');
              //var testPopover = $('#canvas_'+element).parent();

              $('[data-toggle="popover"]').not($('#'+element+'_complemento')).popover('hide');
              $('#'+element+'_complemento').popover('show');

              var canvas2 = document.getElementById('canvas_complemento_'+element);
              var ctx2 = canvas2.getContext("2d");
              var MyChart = new Chart(ctx2).PolarArea(valuescomp, {
                responsive : true,
                tooltipTemplate: "<%if (label){%><%=label%> [ <%}%><%= value %> ]"
              });
            }
          }
        }
      });
      if (closePopovers){
        $('[data-toggle="popover"]').popover('hide');
      }
  };
}

function ChartLine(data){
  var element = data['element'];
  var labels = [];
  var values = [];
  var height = 100;
  var largo = false;
  var count = 0;
  data.data.forEach(function (result){
    if (result.label.length > 10) largo = true;
    labels.push(result.label);
    values.push(result.value);
    count++;
  });

  if (count>3 && largo){
    height = 50*count;
  }

  var r = (Math.floor(Math.random() * 256));
  var g = (Math.floor(Math.random() * 256));
  var b = (Math.floor(Math.random() * 256));
  var data2 = {
    labels: labels,
    datasets: [
        {
            fillColor : "rgba("+r+","+g+","+b+",0.5)",
            strokeColor : "rgba("+r+","+g+","+b+",0.8)",
            pointColor: "rgba(151,187,205,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(151,187,205,1)",
            data: values
        }
    ]
  };

  $('#'+element).html('<canvas id="canvas_'+element+'"  class="col-lg-12 col-md-12"></canvas>');
  var canvas = document.getElementById('canvas_'+element);
  var ctx = canvas.getContext("2d");
  var MyChart =  new Chart(ctx).Line(data2, {
    responsive : true,
    tooltipTemplate: "<%if (label){%><%=label%> [ <%}%><%= value %> ]"
  });

  canvas.onclick = function(evt){
      var activePoints = MyChart.getPointsAtEvent(evt);
      var closePopovers = true;
      data.data.forEach(function (result){
        if (activePoints[0]){
          if (result.label == activePoints[0]['label']){
            if (result.complemento){
              closePopovers = false;

              console.log('COMPLEMENTO: ' + JSON.stringify(result.complemento));
              var valuescomp = [];
              var labelscomp = [];
              result.complemento.forEach(function (complemento){
                //$('#'+element+'_complemento').attr('data-content',$('#'+element+'_complemento').attr('data-content')+'<li> [' + complemento.total + '] '+complemento.comp + '</li>');
                labelscomp.push(complemento.comp);
                valuescomp.push(complemento.total);
              });
              var r = (Math.floor(Math.random() * 256));
              var g = (Math.floor(Math.random() * 256));
              var b = (Math.floor(Math.random() * 256));
              var barChartData = {
                labels : labelscomp,
                datasets : [
                  {
                    fillColor : "rgba("+r+","+g+","+b+",0.5)",
                    strokeColor : "rgba("+r+","+g+","+b+",0.8)",
                    pointColor: "rgba(151,187,205,1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(151,187,205,1)",
                    data : valuescomp
                  }
                ]
              }
              $('#'+element+'_complemento').attr('data-original-title',result.label + '<button type="button" class="close" aria-label="Close" onclick="cerrarPopovers()"><span aria-hidden="true">&times;</span></button>');
              $('#'+element+'_complemento').attr('data-content','<canvas id="canvas_complemento_'+element+'" class="col-lg-12 col-md-12" style="width:380px;margin-bottom:30px;"></canvas>');
              //var testPopover = $('#canvas_'+element).parent();

              $('[data-toggle="popover"]').not($('#'+element+'_complemento')).popover('hide');
              $('#'+element+'_complemento').popover('show');

              var canvas2 = document.getElementById('canvas_complemento_'+element);
              var ctx2 = canvas2.getContext("2d");
              var MyChart = new Chart(ctx2).Line(barChartData, {
                responsive : true,
                tooltipTemplate: "<%if (label){%><%=label%> [ <%}%><%= value %> ]"
              });
            }
          }
        }
      });
      if (closePopovers){
        $('[data-toggle="popover"]').popover('hide');
      }
  };
}

$(document).ready(function(){
    $('[data-toggle="popover"]').popover();
});

$('#resultTabs a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
})

function cerrarPopovers(){
  $('[data-toggle="popover"]').popover('hide');
}
/*Fin funciones resultados*/
