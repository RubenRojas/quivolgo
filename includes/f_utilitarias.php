<?php
function udate($format = 'u', $utimestamp = null) {
    if (is_null($utimestamp))
        $utimestamp = microtime(true);

    $timestamp = floor($utimestamp);
    $milliseconds = round(($utimestamp - $timestamp) * 1000000);

    return date(preg_replace('`(?<!\\\\)u`', $milliseconds, $format), $timestamp);
}

function getRealIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
        return $_SERVER['HTTP_CLIENT_IP'];
       
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
   
    return $_SERVER['REMOTE_ADDR'];
}
function microtime_float(){
    list($usec, $sec) = explode(" ", microtime());
    $num =  ((float)$usec + (float)$sec);
    $num = str_replace('.', '', $num);
    return $num;
}
function quitarPuntos($cadena){
  $cadena = str_replace(".", "", $cadena);
  return $cadena;
}
function quitarComas($cadena){
  $cadena = str_replace(",", "", $cadena);
  return $cadena;
}
function aplica_espacio($nombre){
  $nombre = str_replace("_", " ", $nombre);
  return $nombre;
}
function reemplaza_espacio($nombre){
  $nombre = str_replace(" ", "_", $nombre);
  return $nombre;
}
function cambiarFormatoFecha($fecha){ 
    list($anio,$mes,$dia)=explode("-",$fecha); 
    return $dia."-".$mes."-".$anio; 
}

function resize_img($rutaImagenOriginal,$destino,$max_ancho,$max_alto){
  $arr = array();
  $arr = explode(".", $destino);
  $ext = $arr[(count($arr)-1)];

  if($ext == 'jpg' || $ext =='jpeg'){
    $img_original = imagecreatefromjpeg($rutaImagenOriginal);
  }
  else{
    $img_original = imagecreatefrompng($rutaImagenOriginal);
  }
  list($ancho,$alto)=getimagesize($rutaImagenOriginal);
  $x_ratio = $max_ancho / $ancho;
  $y_ratio = $max_alto / $alto;
  if( ($ancho <= $max_ancho) && ($alto <= $max_alto) ){//Si ancho 
    $ancho_final = $ancho;
    $alto_final = $alto;
  }
  elseif (($x_ratio * $alto) < $max_alto){
    $alto_final = ceil($x_ratio * $alto);
    $ancho_final = $max_ancho;
  }
  else{
    $ancho_final = ceil($y_ratio * $ancho);
    $alto_final = $max_alto;
  }
  
  $tmp=imagecreatetruecolor($ancho_final,$alto_final);    
  imagecopyresampled($tmp,$img_original,0,0,0,0,$ancho_final, $alto_final,$ancho,$alto);  
  imagedestroy($img_original);
  $calidad=80;
  
  if(!imagejpeg($tmp,$destino,$calidad)){
    return 0;
  }
  else{
    return 1;
  }
}
function isBisiesto($anio){
    return (($anio % 4 == 0) && (($anio % 100 != 0) || ($anio % 400 == 0))) ? true : false;
}
function codificar_fecha($mes, $anio){
  $MESES = array("01"=>"Enero", "02"=>"Febrero", "03"=>"Marzo", "04"=>"Abril", "05"=>"Mayo", "06"=>"Junio", "07"=>"Julio", "08"=>"Agosto", "09"=>"Septiembre", "10"=>"Octubre", "11"=>"Noviembre", "12"=>"Diciembre");
  if($mes==''){
    $mes = $MESES[date("m")];
    $anio = date("Y");
  }
  if($mes=='Enero'){
    $inicio=$anio.'-01-01';
    $fin=$anio.'-01-31';
  }
  if($mes=='Febrero'){
    if(isBisiesto($anio)){
      $inicio=$anio.'-02-01';
      $fin=$anio.'-02-29';
    }
    else{
      $inicio=$anio.'-02-01';
      $fin=$anio.'-02-28';
    }
  }
  if($mes=='Marzo'){
    $inicio=$anio.'-03-01';
    $fin=$anio.'-03-31';
  }
  if($mes=='Abril'){
    $inicio=$anio.'-04-01';
    $fin=$anio.'-04-30';
  }
  if($mes=='Mayo'){
    $inicio=$anio.'-05-01';
    $fin=$anio.'-05-31';
  }
  if($mes=='Junio'){
    $inicio=$anio.'-06-01';
    $fin=$anio.'-06-30';
  }
  if($mes=='Julio'){
    $inicio=$anio.'-07-01';
    $fin=$anio.'-07-31';
  }
  if($mes=='Agosto'){
    $inicio=$anio.'-08-01';
    $fin=$anio.'-08-31';
  }
  if($mes=='Septiembre'){
    $inicio=$anio.'-09-01';
    $fin=$anio.'-09-30';
  }
  if($mes=='Octubre'){
    $inicio=$anio.'-10-01';
    $fin=$anio.'-10-31';
  }
  if($mes=='Noviembre'){
    $inicio=$anio.'-11-01';
    $fin=$anio.'-11-30';
  }
  if($mes=='Diciembre'){
    $inicio=$anio.'-12-01';
    $fin=$anio.'-12-31';
  }

    
  $periodo=array('inicio'=>$inicio,'fin'=>$fin);

  return $periodo; //entrega el principio y el fin del mes correspondiente, en formato SQL 
}
function eliminarDir($carpeta){
  foreach(glob($carpeta . "/*") as $archivos_carpeta){
    if (is_dir($archivos_carpeta))
      eliminarDir($archivos_carpeta);
    else//si es un archivo lo eliminamos
      unlink($archivos_carpeta);
  } 
  rmdir($carpeta);
}
function detecta_media(){
  $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
  

  if(stripos($ua,'android') !== false) { // && stripos($ua,'mobile') !== false) {
    return "phone";
  }
  else if(strpos($_SERVER['HTTP_USER_AGENT'],'iPad')){
    return "phone";
  }
  else if(strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'],'iPod'))  {
    return "phone";
  }  
  else{
    return "pc";
  }
}

?>
