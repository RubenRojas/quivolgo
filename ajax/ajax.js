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
