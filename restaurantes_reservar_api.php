<?php
date_default_timezone_set('America/Bogota');
$status = 0;
require('clases/class_mysql.php');
$obj = new MySQL('');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $input = json_decode(file_get_contents('php://input'));
  $array_r = array();
  
  foreach($input as $param => $value) {
    if ($param=='reserva') {
      foreach($value as $key => $valor) {
        $array_r[$key] = $valor;
      }
    }
  }

  if ( (!empty($array_r)) && (isset($array_r['restaurante'])) && (isset($array_r['mesa'])) && (isset($array_r['cliente']))) {
    if ( $obj->validpg($array_r['restaurante'], $array_r['mesa'], $array_r['cliente']) === FALSE ) { 
      $header = "HTTP/1.1 406 Bad Data";
    } else {         
      $obj->transaction();         
      $sql_texto = "CALL con_reservas(4,0,'','$array_r[mesa]','$array_r[restaurante]')";
      $consulta = $obj->query($sql_texto, ' consultar-1');
      $row = $obj->fetch_array($consulta);      
      $cantidad = $row['cantidad'];
      $obj->liberar($consulta);

      if ( $cantidad > 0 ) {
        $header = "HTTP/1.1 204 Ya Existe Una Reserva Para Esta Mesa";
      } else {
        $sql_texto = "CALL con_reservas(6,0,'','$array_r[mesa]','$array_r[restaurante]')";
        $consulta = $obj->query($sql_texto, ' consultar-2');
        $row = $obj->fetch_array($consulta);      
        $cantidad = $row['cantidad'];
        $obj->liberar($consulta); 

        if ( ($cantidad == 0) || (empty($array_r['cliente'])) ) {
          $header = "HTTP/1.1 205 No Existe Restaurante, Mesa o Cliente";
        } else {  
          $header = "HTTP/1.1 200 OK";
          $status = 1;
        }
      }      
    }
  } else {
    $header = "HTTP/1.1 201 Error Faltan Datos Para Reservar";
  }
} else {
  $header = "HTTP/1.1 400 Bad Request";
}

if ($status > 0) {
  $nombre_cliente  = ucwords(htmlspecialchars(trim(strip_tags(strtolower($array_r['cliente']))), ENT_QUOTES, 'UTF-8'));  
  $sql_texto = "CALL con_reservas(5,0,'$nombre_cliente','$array_r[mesa]','$array_r[restaurante]')";
  $consulta = $obj->query($sql_texto, ' grabar-2');    
  $nodo = array();  
  while( $row = $obj->fetch_array($consulta) ) {	
    $nodo[] = array('numero_reserva' => $row['last_insert_id']);
  }
  $obj->liberar($consulta);
  $obj->commit(); 
  header($header);
  echo json_encode($nodo);
} else {
  header($header);
}
exit;