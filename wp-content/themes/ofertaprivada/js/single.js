var ofertas_acumuladas;
var var1 = 1;
var var2 = 5;
var var3 = 12;
var pvp = Number(pvp);
var porcentaje = Number(DO);
var porcentaje = Number(porcentaje/100);
var pm = (NORMDIST(var3,var2,var1,1))*(pvp*(1-porcentaje));
var pm = parseInt(pm);

jQuery("form#ofertaprivada").submit( function(eventObj) {
      jQuery('<input />').attr('type', 'hidden')
          .attr('name', "pm")
          .attr('value', pm)
          .appendTo('form#ofertaprivada');
      return true;
  })

var chart = document.getElementById('myChart').getContext('2d');
var data = {
  datasets: [{
	data: [
	  0,1	
	],
	backgroundColor: [
	  "#2cc76a",
	  "#eee"
	],
	hoverBackgroundColor: [
	  "#2cc76a",
	  "#eee"
	]
  }]
};
var grafico = new Chart(chart, {
  type: 'doughnut',
  data: data,
  options: {
   responsive: true,
   legend: {
	  display: false
   },
   tooltips: {
	  enabled: false
   }
  }
});

jQuery(function () {
  jQuery('[data-toggle="tooltip"]').tooltip()
})

jQuery(".incremental-counter").incrementalCounter({digits:'2'});

jQuery(document).ready(function () {
	jQuery(".bar-ofertas-desktop").css({height:acumuladas_porc})
	jQuery(".bar-stock-desktop").css({height:stock_porc})
	jQuery(".bar-ofertas-mobile").css({width:acumuladas_porc})
	jQuery(".bar-stock-mobile").css({width:stock_porc})
});

function formatNumber(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + '.' + '$2');
    }
    return x1 + x2;
}

function resetCanvas(chart, data) {
	var actual = jQuery("span.porcentaje_probable").text();
	var cantidad = jQuery('input#qty').val();
	var po = parseInt(jQuery('#precio_oferta').val());
	var t = pvp*(1-porcentaje);
	var digit = pvp.toString().length;
	var u = t/pvp;
	var prealfa = 100;
	var prebeta = ((1/u)-1)*prealfa;
	var alfa = 10/((prebeta/100)+1);
	var beta = alfa*((prebeta/100));
	var u3 = parseInt(po)/pvp;
	var respuesta = jStat.beta.cdf(u3,parseInt(alfa),parseInt(beta))*100;
	var output = Math.round(respuesta);
	if(isNaN(output)) { output=0; }
	if(output > 100) { output=100;	}
	if(output < 0) { output = 0; }
	if(output > 49 && output < 69) {
		color1="#ef8f29";
	} else if(output > 69) {
		color1="#2cc76a";
	} else {
		color1="#dc3545";
	}
	if(po > 0) {
		if(output==0)  {
			output = 1;
		}
	}
	color2="#eee";
	output2=100-output;
	jQuery("span.porcentaje_probable").html(output);
	if(actual!=output) {
		grafico.data.datasets.pop();
		grafico.data.datasets.push({
			  data: [
				output,output2
			  ],
			  backgroundColor: [
				color1,
				color2
			  ],
			  hoverBackgroundColor: [
				color1,
				color2
			  ]
		})
    	grafico.update();
	}
	var subtotal = po*cantidad;
	if(isNaN(subtotal)) { var subtotal = 0; }
	jQuery("span#subtotal").text(formatNumber(subtotal));
}

function subTotal() {
	var precio = jQuery('input#precio_oferta').val();
	var cantidad = jQuery('input#qty').val();
	var subtotal = precio*cantidad;
	if(isNaN(subtotal)) { var subtotal = 0; }
	jQuery("span#subtotal").text(formatNumber(subtotal));
}

jQuery("input#precio_oferta").keyup(function() { resetCanvas(); });
jQuery("input#precio_oferta").change(function() { resetCanvas(); });
jQuery("input#qty").keyup(function() { subTotal(); });
jQuery("input#qty").change(function() { subTotal(); });


jQuery("input#envio-local").click(function() {
	jQuery('input#direccion').prop('required',false);
	jQuery('input#comuna').prop('required',false);
	jQuery('input#region').prop('required',false);
	jQuery('.row-envio').addClass('sr-only');
	jQuery('input#local').prop('required',true);
	jQuery('.row-local').removeClass('sr-only');
});
jQuery("input#envio-domicilio").click(function() {
	jQuery('input#direccion').prop('required',true);
	jQuery('input#comuna').prop('required',true);
	jQuery('input#region').prop('required',true);
	jQuery('.row-envio').removeClass('sr-only');
	jQuery('input#local').prop('required',false);
	jQuery('.row-local').addClass('sr-only');
});
jQuery(".btn.next-step").click(function() {
    jQuery('#step2').removeClass('sr-only')
	jQuery(this).addClass('sr-only')
	jQuery('.btn.final-step').removeClass('sr-only')
	jQuery('html,body').animate({scrollTop: jQuery("#step2").offset().top},'slow');
});
function copyToClipboard(element) {
  var tempvar = jQuery("<input>");
  jQuery("body").append(tempvar);
  tempvar.val(jQuery(element).val()).select();
  document.execCommand("copy");
  tempvar.remove();
  alert('Código copiado con éxito');
}
function NORMDIST(x, mean, sd, cumulative) {
  // Check parameters
  if (isNaN(x) || isNaN(mean) || isNaN(sd)) return '#VALUE!';
  if (sd <= 0) return '#NUM!';

  // Return normal distribution computed by jStat [http://jstat.org]
  return (cumulative) ? jStat.normal.cdf(x, mean, sd) : jStat.normal.pdf(x, mean, sd);
}
