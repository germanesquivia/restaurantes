<?php session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <link rel='stylesheet' type='text/css' href='estilos.css'>
    <meta name='viewport' content='width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0'>
    <meta name='mobile-web-app-capable' content='yes'>
    <link rel='shortcut icon' href='graficos/icono_cinesoft.png'>
    <title>RESTAURANTES - NUEVO - CARGAR IMAGEN</title>
  </head>  
  <body> <?php date_default_timezone_set('America/Bogota');
    $pagact = $pagact = 'restaurantes.php';; $_SESSION['pagact'] = $pagact;
    $filetemporal = tempnam('fotos/','t');
    $nomarch = basename($filetemporal,'.tmp');
    $archivo = $_FILES['imagenupload']['name'];
    $extension = explode('.', $archivo); 
    $extension = strtolower(end($extension));
    $nombre_archivo = 'fotos/'.$nomarch.'.'.$extension;
    $nomfile = $nomarch.'.'.$extension;
    $tipo_archivo = $_FILES['imagenupload']['type'];
    $tamano_archivo = $_FILES['imagenupload']['size'];
    $msg = '';
    if ( ($tamano_archivo > 3072000) || ( ($extension!='jpg') && ($extension!='gif') && ($extension!='jpeg') && ($extension!='png') ) ) {
      if ($tamano_archivo > 3072000) { 
        $msg = 'Error: Tamaño Maximo = 3 MB,  Imagen='.$tamano_archivo; 
      } else {
        $msg = 'Error: Solo se Permiten JPG, PNG, GIF  Extension='.strtolower($extension);
      }
    } elseif ( !(move_uploaded_file($_FILES['imagenupload']['tmp_name'], $nombre_archivo)) ) {
      $msg = 'Ocurrio algun error al subir el Archivo. No pudo guardarse';
    } 
    if (file_exists ( $filetemporal )) { unlink($filetemporal); } ?>
      
    <form id='form1' name='form1' method='POST' action="<?php echo $_POST['pagsubmit']; ?>">
      <?php require('valirdarform.php'); ?>
      <input type='hidden' name='imagen' value="<?php echo $nomfile; ?>"> 
      <input type='hidden' name='update_imagen' value="1"> <?php
      if (!empty($msg)) { ?>
        <input type='hidden' name='errgrabar' value="<?php echo $msg; ?>"> <?php
      } ?>
    </form>
    <script>document.form1.submit()</script>
  </body>  
</html>
