<?php
$reserva = array (
   'restaurante' => 1,
   'mesa' => 14,
   'cliente' => 'Catalina Garcia'
);

$data = array('reserva' => $reserva);
$url = 'http://localhost:81/restaurante/restaurantes_reservar_api.php';
$ch = curl_init($url);
$payload = json_encode($data);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
$header = array('Content-type: application/json');
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
if ( curl_errno($ch) ) {
  $msg = '1-Ocurrio Un Error '; $err = curl_error($ch); require('restaurantes_error.php'); exit;
} else {
  curl_close($ch);
  print_r($result);
  echo '<br> Finalizado ';
} ?>