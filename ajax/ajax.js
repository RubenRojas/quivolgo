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
					$("#origen_genetico").html(data.cod_mat_gen);
					$("#tipo_propagacion").html(data.tipo_propagacion);
					$("#campo_origen").html(data.campo_origen);
					$("#fecha_plantacion").html(data.fecha_plantacion);
					$("#cod_madre").val(data.cod_desc);
					$("#cod_madre_2").val(data.id_madre);
					
					$("#especie").val(data.especie);
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
