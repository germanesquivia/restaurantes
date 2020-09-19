<?php session_start(); ?>
<!DOCTYPE html>
<html> <?php
  $head_array = array('titulo'=>'RESERVAS NUEVO GRABAR','alerta'=>1);
  require ('head_base.php'); ?>
  <body>
    <div class='container-fluid'> <?php 
      date_default_timezone_set('America/Bogota');
      $pagact = 'reservas.php'; $hacercaja = false; $_SESSION['pagact'] = $pagact;
      require('clases/class_mysql.php');
      require('clases/class_datagrid.php'); 
      $obj = new datagridmysql(''); 
      if ( !$obj->validpg( $_POST['id_restaurante'], $_POST['nombre_cliente'] ) ) { die ('ERROR: INGRESO DE DATOS NO VALIDOS...'); } 
      $nombre_cliente  = ucwords(htmlspecialchars(trim(strip_tags(strtolower($_POST['nombre_cliente']))), ENT_QUOTES, 'UTF-8'));  
      require('espere_uno.php'); ?>
      <form id='form_grabar' name='form_grabar' method='POST' action='reservas_nuevo.php'> <?php
        if ( (empty($nombre_cliente)) || (empty($_POST['id_restaurante'])) || (empty($_POST['id_mesa'])) ) {
          require('valirdarform.php'); ?>
          <input type='hidden' name='errgrabar' value='FALTAN DATOS...'/>
          <script>document.form_grabar.submit()</script><?php
          exit;      
        }
        $obj->transaction();
        $sql_texto = "CALL con_reservas(4,0,'','$_POST[id_mesa]','$_POST[id_restaurante]')";
        $consulta = $obj->query($sql_texto, $pagact.' grabar-1');
        $row = $obj->fetch_array($consulta);
        $obj->liberar($consulta);
        if ( $row['cantidad'] > 0 ) {
          $obj->rollback(); 
          require('valirdarform.php'); ?>
          <input type='hidden' name='errgrabar' value='YA EXISTE UNA RESERVA PARA ESTA MESA...'/>
          <script>document.form_grabar.submit()</script><?php
          exit;      
        }

        $sql_texto = "CALL con_reservas(5,0,'$nombre_cliente','$_POST[id_mesa]','$_POST[id_restaurante]')";
        $consulta = $obj->query($sql_texto, $pagact.' grabar-1');
        $row = $obj->fetch_array($consulta);
        $obj->liberar($consulta);
        $obj->commit(); ?>
       </form>
       <form id='form_return' name='form_return' method='POST' action='reservas.php'>
       </form>
       <script>document.form_return.submit()</script>
    </div>
  </body>
</html>