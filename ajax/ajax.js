var baseDir = "/quivolgo/ajax/php/";
//***************************************
// UPDATE
//***************************************
/*
function show_notificaciones_central(){
	console.info("function: show_notificaciones_central");
	var url= baseDir+"/varias/get_notificaciones_chofer.php";
	var datos=crearXMLHttpRequest();
	datos.onreadystatechange = function(){
		if(datos.readyState==1){
		}
		else if(datos.readyState==4){
			if(datos.status==200){
				if(datos.responseText != "null"){
					var data = $.parseJSON(datos.responseText);
					$("#notificacion_chofer_id").val(data.id);
					$("#mensaje_notificacion").html(data.mensaje);

					show_notif_app_chofer(data.origen, data.carrera);	
				}
			}
		}  
	};
	datos.open("GET", url, true);
	datos.send(null);
}

function turno(id, accion){	
	console.info("function: turno");
	$.ajax({
	      type: 'POST',
	      url: baseDir+'/movil/update_turno.php?accion='+accion+'&id='+id,
	      data: $("#inicia_turno").serialize(),
	      dataType: "html",
	      success: function () {	
	      	console.info("function: ()");
	      	update_fila_tabla_moviles(id);
	      	//location.reload();
	      },
	      error: function(){
	      }
	});
}
*/
var CAPACIDAD_CONTENEDOR = 0;
function get_data_madre(id){
	var url= baseDir+"/instalacion/get_data_madre.php?id="+id;
	var datos=crearXMLHttpRequest();
	datos.onreadystatechange = function(){
		if(datos.readyState==1){
		}
		else if(datos.readyState==4){
			if(datos.status==200){
				if(datos.responseText != "null"){
					var data = $.parseJSON(datos.responseText);
					console.log(data);
					$("#origen_genetico").html(data.origen_genetico);
					$("#tipo_propagacion").html(data.tipo_propagacion);
					$("#campo_origen").html(data.campo_origen);
					$("#fecha_plantacion").html(data.fecha_plantacion);
					$("#cod_mat_gen").val(data.cod_mat_gen);
					$("#cod_mat_gen_2").val(data.id_cod_mat_gen);
					
					$("#especie").val(data.especie);

					set_codigo_instalacion();
				}
			}
		}  
	};
	datos.open("GET", url, true);
	datos.send(null);
}

function set_capacidad_contendor(id){
	var url= baseDir+"/instalacion/get_data_contenedor.php?id="+id;
	var datos=crearXMLHttpRequest();
	datos.onreadystatechange = function(){
		if(datos.readyState==1){
		}
		else if(datos.readyState==4){
			if(datos.status==200){
				if(datos.responseText != "null"){
					var data = $.parseJSON(datos.responseText);
					console.log(data);
					$("#cap_contenedor").val(data.capacidad);
					$("#cap_contenedor_2").val(data.capacidad);
					CAPACIDAD_CONTENEDOR = data.capacidad;
					setNipla();
				}
			}
		}  
	};
	datos.open("GET", url, true);
	datos.send(null);
}

function setSelectProducto(value){
	var url= baseDir+"/aplicacion/getProductosCategoria.php?categoria="+value;
	var datos=crearXMLHttpRequest();
	datos.onreadystatechange = function(){
		if(datos.readyState==1){
		}
		else if(datos.readyState==4){
			if(datos.status==200){
				if(datos.responseText != "null"){
					
					$("#producto").html(datos.responseText);
					$("#componentes").html("");
					
				}
			}
			$('select').material_select();
		}  
	};
	datos.open("GET", url, true);
	datos.send(null);
}

function setComponentes(value){
	var url= baseDir+"/aplicacion/getComponentes.php?producto="+value;
	var datos=crearXMLHttpRequest();
	datos.onreadystatechange = function(){
		if(datos.readyState==1){
		}
		else if(datos.readyState==4){
			if(datos.status==200){
				if(datos.responseText != "null"){
					
					$("#componentes").html(datos.responseText);
					
				}
			}
			
		}  
	};
	datos.open("GET", url, true);
	datos.send(null);
}

function showMesones(){
	var sector 	= $("#sector").val();

	var nave	= $("#nave").val();
	var sel = $("#nave");
	
	var data_nave = $("option:selected",sel).text(); 
	var url= baseDir+"/aplicacion/getMesones.php?sector="+sector+"&nave="+nave+"&data_nave="+data_nave;
	var datos=crearXMLHttpRequest();
	datos.onreadystatechange = function(){
		if(datos.readyState==1){
		}
		else if(datos.readyState==4){
			if(datos.status==200){
				if(datos.responseText != "null"){
					
					$("#mesones").html(datos.responseText);
					
				}
			}
			
		}  
	};
	datos.open("GET", url, true);
	datos.send(null);
}

function show_datos_instalacion(id_parcela){
	
	var url= baseDir+"/inventario/get_data_instalacion.php?id_parcela="+id_parcela;
	var datos=crearXMLHttpRequest();
	datos.onreadystatechange = function(){
		if(datos.readyState==1){
		}
		else if(datos.readyState==4){
			if(datos.status==200){
				if(datos.responseText != "null"){					
					var data = $.parseJSON(datos.responseText);
					console.log(data);
					$("#cod_instalacion").html(data.cod_instalacion);
					$("#cod_mat_gen").html("<b>"+data.cod_mat_gen+"</b>");
					$("#contenedor").html(data.contenedor);
					$("#tipo_propagacion").html(data.tipo_propagacion);
					$("#especie").html(data.especie);
					$("#sector").html(data.sector);
					$("#nave").html(data.nave);
					$("#meson").html(data.meson);
					$("#nipla").val(data.nipla);
					$("#temporada").html(data.temporada);
					$("#tipo_bandeja").html(data.tipo_bandeja);
				}
			}
			
		}  
	};
	datos.open("GET", url, true);
	datos.send(null);
}


function setDatosInstalacion(id_instalacion){
	var url= baseDir+"/instalacion/get_data_instalacion.php?id_parcela="+id_instalacion;
	var datos=crearXMLHttpRequest();
	datos.onreadystatechange = function(){
		if(datos.readyState==1){
		}
		else if(datos.readyState==4){
			if(datos.status==200){
				if(datos.responseText != "null"){					
					var data = $.parseJSON(datos.responseText);
					console.log(data);
					$("#cod_madre").html(data.cod_madre);
					$("#cod_mat_gen").html("<b>"+data.cod_mat_gen+"</b>");
					$("#contenedor").html(data.contenedor);
					$("#tipo_propagacion").html(data.tipo_propagacion);
					$("#especie").html(data.especie);
					$("#sector").html(data.sector);
					$("#nave").html(data.nave);
					$("#meson").html(data.meson);
					$("#nipla").val(data.nipla);
					$("#origen_genetico").html(data.origen_genetico);
					$("#temporada").html(data.temporada);
					$("#tipo_bandeja").html(data.tipo_bandeja);
					cap_contenedor = parseInt(data.capacidad);
					$("#cant_contenedores").attr({
						min: '1',
						max: parseInt(data.n_contenedores - 1)
					});
				}
			}
			
		}  
	};
	datos.open("GET", url, true);
	datos.send(null);
}


function setCodMatGenFiltro(){
	var params = {};
	var i = 1;
	$('#especie :selected').each(function(i, selected){ 
	  params["p"+i] = $(selected).val();
	  i++;
	});
	var parametros = jQuery.param( params )
	var url= baseDir+"/inventario/get_cod_mat_gen_filtro.php?"+parametros;
	var datos=crearXMLHttpRequest();
	datos.onreadystatechange = function(){
		if(datos.readyState==1){
		}
		else if(datos.readyState==4){
			if(datos.status==200){
				if(datos.responseText != "null"){					
					/*var data = $.parseJSON(datos.responseText);
					console.log(data);*/
					console.log(datos.responseText);
					$("#cod_mat_gen").html(datos.responseText);
					$('select').material_select();
					
				}
			}
			
		}  
	};
	datos.open("GET", url, true);
	datos.send(null);
}


function setNavesFiltro(){
	var params = {};
	var i = 1;
	$('#app_sector :selected').each(function(i, selected){ 
	  params["p"+i] = $(selected).val();
	  i++;
	});
	var parametros = jQuery.param( params )
	var url= baseDir+"/inventario/get_naves_filtro.php?"+parametros;
	var datos=crearXMLHttpRequest();
	datos.onreadystatechange = function(){
		if(datos.readyState==1){
		}
		else if(datos.readyState==4){
			if(datos.status==200){
				if(datos.responseText != "null"){					
					/*var data = $.parseJSON(datos.responseText);
					console.log(data);*/
					console.log(datos.responseText);
					$("#app_nave").html(datos.responseText);
					$('select').material_select();
					
				}
			}
			
		}  
	};
	datos.open("GET", url, true);
	datos.send(null);
}

function setMesonesFiltro(){
	var params_nave = {};
	var params_sector = {};
	var i = 1;
	$('#app_nave :selected').each(function(i, selected){ 
	  params_nave["n"+i] = $(selected).val();
	  i++;
	});
	$('#app_sector :selected').each(function(i, selected){ 
	  params_sector["s"+i] = $(selected).val();
	  i++;
	});
	var parametros_nave = jQuery.param( params_nave );
	var parametros_sector = jQuery.param( params_sector );
	var url= baseDir+"/inventario/get_mesones_filtro.php?"+parametros_nave+"&"+parametros_sector;
	var datos=crearXMLHttpRequest();
	datos.onreadystatechange = function(){
		if(datos.readyState==1){
		}
		else if(datos.readyState==4){
			if(datos.status==200){
				if(datos.responseText != "null"){					
					/*var data = $.parseJSON(datos.responseText);
					console.log(data);*/
					console.log(datos.responseText);
					$("#meson").html(datos.responseText);
					$('select').material_select();
					
				}
			}
			
		}  
	};
	datos.open("GET", url, true);
	datos.send(null);
}



//***************************************
//Funciones comunes a todos los problemas
//***************************************
var preloader = "<div class='text-center Preloader'></div>";
var preloader_mini = "Cargando ...";
function crearXMLHttpRequest(){	
  var xmlHttp=null;
  if (window.ActiveXObject){
    xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  else{ 
    if (window.XMLHttpRequest){
      xmlHttp = new XMLHttpRequest();
    }
  }
  return xmlHttp;
  console.info("function: crearXMLHttpRequest");
}
