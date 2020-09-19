<?php session_start(); ?>
<!DOCTYPE html>
<html> <?php
  $head_array = array('titulo'=>'RESTAURANTES NUEVO GRABAR','alerta'=>1);
  require ('head_base.php'); ?>
  <body>
    <div class='container-fluid'> <?php 
      date_default_timezone_set('America/Bogota');
      $pagact = 'restaurantes.php'; $hacercaja = false; $_SESSION['pagact'] = $pagact;
      require('clases/class_mysql.php');
      require('clases/class_datagrid.php'); 
      $obj = new datagridmysql(''); 
      if ( !$obj->validpg( $_POST['id'], $_POST['nombre'], $_POST['descripcion'], $_POST['direccion'],$_POST['ciudad'] ) ) { die ('ERROR: INGRESO DE DATOS NO VALIDOS...'); } 
      $nombre  = ucwords(htmlspecialchars(trim(strip_tags($_POST['nombre'])), ENT_QUOTES, 'UTF-8'));  
      $descripcion = ucwords(htmlspecialchars(trim(strip_tags($_POST['descripcion'])), ENT_QUOTES, 'UTF-8'));
      $direccion = ucwords(htmlspecialchars(trim(strip_tags($_POST['direccion'])), ENT_QUOTES, 'UTF-8'));
      $ciudad = strtoupper(htmlspecialchars(trim(strip_tags($_POST['ciudad'])), ENT_QUOTES, 'UTF-8'));
      $nuevo = ( (isset($_POST['nuevo'])) && ($_POST['nuevo']==1) ) ? 1 : 0;
      if ( isset($_POST['button_loadfile']) ) { ?>          
        <div class='container' align='center'>
          <header><?php $winpopup=true; require('caja_titulo_bt.php'); ?></header>
          <h5><u> SUBIR IMAGEN PARA:  </u></h5>
          <h5> <?php echo $nombre; ?> </h5>
          <form id='form1' name='form1' method='POST' action='restaurantes_cargue_imagenes_upload_subir.php' enctype='multipart/form-data'> <?php
            require('valirdarform.php'); ?>
            <input type='hidden' name='pagsubmit' value='restaurantes_nuevo.php'>
            <input type='hidden' name='nuevo' value="<?php echo $nuevo; ?>">
            <table class='table-sm'>
              <tr>
                <td><input type='file' class='btn btn-success btn-sm' name='imagenupload'></td>
              </tr>
              <tr>
                <td><button type='submit' name='button1' id='button1' class='btn btn-primary btn-block'><i class='fa fa-check-square-o' aria-hidden='true'></i> Enviar </button></td>
              </tr>
            </table>
          </form>
        </div> <?php
        exit;
      } elseif ( ($nuevo==1) && 
          ( (!isset($_POST['imagen'])) || (empty($_POST['imagen'])) || 
          ( !file_exists('fotos/'.$_POST['imagen'])) ) ) { ?>
        <form id='form_err' name='form_err' method='POST' action='restaurantes_nuevo.php'> <?php
          require('valirdarform.php'); ?>
          <input type='hidden' name='errgrabar' value='FALTA IMAGEN DEL RESTAURANTE...'/>
          <script>document.form_err.submit()</script>
        </form> <?php
        exit;
      }
      require('espere_uno.php'); ?>
      <form id='form_grabar' name='form_grabar' method='POST' action='restaurantes_nuevo.php'> <?php
        if ( (empty($nombre)) || (empty($_POST['descripcion'])) || (empty($_POST['direccion'])) || (empty($_POST['ciudad'])) ) {
          require('valirdarform.php'); ?>
          <input type='hidden' name='errgrabar' value='FALTAN DATOS...'/>
          <script>document.form_grabar.submit()</script><?php
          exit;      
        }
        $obj->transaction();
        $sql_texto = "CALL con_restaurantes(5,0,'$nombre','','','','','','')";
        $consulta = $obj->query($sql_texto, $pagact.' grabar-1');
        $row = $obj->fetch_array($consulta);
        $num_rows = $obj->num_rows($consulta);
        $obj->liberar($consulta);
        if ( ( ($nuevo==1) && ($num_rows>0)) || ( ($nuevo==0) && ($num_rows>0) && ($row['id']<>$_POST['id']) ) ) {
          $obj->rollback(); 
          require('valirdarform.php'); ?>
          <input type='hidden' name='errgrabar' value='NOMBRE DE RESTAURANTE YA EXISTE...'/>
          <script>document.form_grabar.submit()</script><?php
          exit;      
        }
        if ($nuevo ==1) {
          $sql_texto = "CALL con_restaurantes(6,0,'$nombre','$descripcion','$direccion','$ciudad','','','')";
          $consulta = $obj->query($sql_texto, $pagact.' grabar-2');
          $row = $obj->fetch_array($consulta);
          $last_insert_id = $row['last_insert_id'];
          $obj->liberar($consulta);

          $extension = explode('.', $_POST['imagen']); 
          $extension = strtolower(end($extension));      
          $nomfile = 'foto' . trim((string)$last_insert_id) . '.' . $extension;
          rename ('fotos/'.$_POST['imagen'], 'fotos/'.$nomfile);

          $sql_texto = "CALL con_restaurantes(8,'$last_insert_id','','','','','','','$nomfile')";
          $obj->query($sql_texto, $pagact.' grabar-3');
        } else {
          $sql_texto = "CALL con_restaurantes(7,'$_POST[id]','$nombre','$descripcion','$direccion','$ciudad','','','')";
          $consulta = $obj->query($sql_texto, $pagact.' grabar-4');
          $row = $obj->fetch_array($consulta);
          $codimg = $row['codimg'];
          $obj->liberar($consulta);

          if ( ($_POST['update_imagen'] == 1) && ( file_exists('fotos/'.$_POST['imagen']) ) ) {
            $extension = explode('.', $_POST['imagen']); 
            $extension = strtolower(end($extension));      
            $nomfile = 'foto' . trim(((string)$_POST['id'])) . '.' . $extension;

            if (file_exists ( 'fotos/'.$codimg ) ) { 
              unlink('fotos/'.$codimg); 
            }

            if (file_exists ( 'fotos/'.$nomfile )) { 
                unlink('fotos/'.$nomfile);
            }

            rename ('fotos/'.$_POST['imagen'], 'fotos/'.$nomfile);            
            
            $sql_texto = "CALL con_restaurantes(8,'$_POST[id]','','','','','','','$nomfile')";
            $obj->query($sql_texto, $pagact.' grabar-5');  
          }
        }

        $obj->commit(); ?>
       </form>
       <form id='form_return' name='form_return' method='POST' action='restaurantes.php'>
       </form>
       <script>document.form_return.submit()</script>
    </div>
  </body>
</html>