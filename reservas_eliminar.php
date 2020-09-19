<?php session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <script lenguage="javaScript">
      function mensajealerta(mensaje) { alert(mensaje); }
    </script>
  </head>
  <body><?php date_default_timezone_set('America/Bogota');
    $pagact = 'reservas.php'; $_SESSION['pagact'] = $pagact;

    if ( !isset($_GET['codigo']) ) { 
      die('FALTAN DATOS...'); 
    }
    $codvalid = $_GET['codigo']; $len=10; require('validarcodigoget.php');
    $id = $_GET['codigo'];

    require('clases/class_mysql.php');
    $mysql = new MySQL('');  
    $mysql->transaction();     
    $sql_texto = "CALL con_reservas(2,'$id','',0,'')";
    $mysql->query($sql_texto, $pagact.' grabar-1');
    $mysql->commit(); ?>
    <form id='form_return' name='form_return' method='POST' action='reservas.php'>
    </form>
    <script>document.form_return.submit()</script>
  </body>
</html>