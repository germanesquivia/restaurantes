<?php
date_default_timezone_set('America/Bogota');
$rutaweb = str_replace('/','&#47;','http://localhost:81/restaurante/fotos/');
require('clases/class_mysql.php');
$mysql = new MySQL('');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $input = json_decode(file_get_contents('php://input'));
  $status = 1;  
  $header = "HTTP/1.1 200 OK";
} else {
  $status = 0;
  $header = "HTTP/1.1 400 Bad Request";  
}

if ($status > 0) {
  $sql_texto = "CALL con_restaurantes(11,0,'','','','','0','0','')";
  $consulta = $mysql->query($sql_texto, ' grabar-1');
  $nodo = array();  
  while( $row = $mysql->fetch_array($consulta) ) {	
    $nodo[] = array('id'          => $row['id'],
                    'nombre'      => $row['nombre'],
                    'descripcion' => $row['descripcion'],
                    'ciudad'      => $row['ciudad'],
                    'direccion'   => $row['direccion'],
                    'foto'        => $rutaweb.$row['foto']);
  }

  $mysql->liberar($consulta);
  header($header);
  echo json_encode($nodo);
} else {
  header($header);
}
exit;