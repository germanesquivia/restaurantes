<?php session_start(); ?>
<!DOCTYPE html>
<html> <?php
  $head_array = array('titulo'=>'RESTAURANTES','alerta'=>1,'refresh_parent'=>1,'abrir_ventana'=>1); 
  require ('head_base.php'); ?>
  <body onload="document.getElementById('nombre').focus()";>
    <div class='container-fluid'> <?php 
      date_default_timezone_set('America/Bogota');
      $pagact = 'restaurantes.php'; $_SESSION['pagact'] = $pagact;
      require('clases/class_mysql.php');
      require('clases/class_datagrid.php');      
      if (isset($_POST['errgrabar']) ) { ?>
        <script language='javascript'> mensajealerta("<?php echo $_POST['errgrabar']; ?> "); </script> <?php
      }
      $obj = new datagridmysql(''); 
      if (isset($_GET['nuevo'])) { 
        $_POST['nuevo'] = 1; 
      } elseif (isset($_GET['codigo'])) {
        $codvalid = $_GET['codigo']; $len=10; require('validarcodigoget.php');
        $_POST['id'] = $_GET['codigo']; 
      }

      if ( (!isset($_POST['nuevo'])) || ($_POST['nuevo']==0) ) {
        $obj->id = $_POST['id']; 
        $obj->nuevo = 0; $_POST['nuevo'] = 0;
        $obj->loadRestaurante();
        $_POST['nombre'] = $obj->nombre;
        $_POST['descripcion'] = $obj->descripcion;
        $_POST['direccion'] = $obj->direccion;
        $_POST['ciudad'] = $obj->ciudad;
        $_POST['codimg'] = $obj->codimg;
      } else {
        $obj->nuevo = 1; $_POST['nuevo'] = 1;
      } ?>
      <header><?php $winpopup=true; require('caja_titulo_bt.php'); ?></header>

      <section>
        <div class='container-fluid' align='center'>
          <h5><u><?php echo $head_array['titulo']; ?></u></h5>
          <form id='form1' name='form1' method='POST' action='restaurantes_nuevo_grabar.php' autocomplete='off'>
            <input type='hidden' name='id' value="<?php echo (isset($_POST['id'])) ? $_POST['id'] : 0; ?>" >
            <input type='hidden' name='nuevo' value="<?php echo $_POST['nuevo']; ?>" > 
            <input type='hidden' name='update_imagen' value="<?php echo ($_POST['update_imagen']) ? $_POST['update_imagen'] : 0 ; ?>" > <?php
            if ( (isset($_POST['imagen'])) && (file_exists('fotos/'.$_POST['imagen'])) ) { ?>
              <input type='hidden' name='imagen' value="<?php echo $_POST['imagen']; ?>"> <?php
            } elseif( (isset($_POST['codimg'])) && (file_exists('fotos/'.$_POST['codimg'])) ) { ?>
              <input type='hidden' name='imagen' value="<?php echo 'fotos/'.$_POST['codimg']; ?>"> <?php
            } else { ?>
              <input type='hidden' name='imagen' value=""> <?php
            } ?>
            <table class='table-sm small'>
              <tr>
                <td class='text-right font-weight-bold'>Codigo:</td>
                <td>
                  <table>
                    <tr>           
                      <td>
                        <input type='text' class='form-control' name='id_product' id='id' 
                          value="<?php echo (isset($_POST['id'])) ? $_POST['id'] : 0; ?>" 
                          size='8' maxlength='8' readonly>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td class='text-right font-weight-bold'>Nombre Restaurante:</td>
                <td>                
                  <table class='table-sm'>
                    <tr>
                      <td>
                        <input type='text' class='form-control' name='nombre' id='nombre' value="<?php 
                          if ( isset($_POST['nombre']) ) { echo $_POST['nombre']; } ?>" size='50' maxlength='50' required>
                      </td> 
                    </tr>                  
                  </table>
                </td>            
              </tr>
              <tr>
                <td class='text-right font-weight-bold'>Descripcion:</td>
                <td>
                  <input type='text' class='form-control' name='descripcion' id='descripcion' 
                    value="<?php if ( isset($_POST['descripcion']) ) { echo $_POST['descripcion']; } ?>" 
                    size='50' maxlength='50'>
                </td> 
              </tr>
              <tr>
                <td class='text-right font-weight-bold'>Direccion:</td>
                <td>                
                  <table class='table-sm'>
                    <tr>
                        <td>
                        <input type='text' class='form-control' name='direccion' id='direccion' 
                          value="<?php if ( isset($_POST['direccion']) ) { echo $_POST['direccion']; } ?>" 
                          size='50' maxlength='50'>
                        </td>
                    </tr>                  
                  </table>
                </td>            
              </tr>

              <tr>
                <td class='text-right font-weight-bold'>Ciudad:</td>
                <td>                
                  <table class='table-sm'>
                    <tr>
                        <td>
                        <input type='text' class='form-control' name='ciudad' id='ciudad' 
                          value="<?php if ( isset($_POST['ciudad']) ) { echo $_POST['ciudad']; } ?>" 
                          size='50' maxlength='50'>
                        </td>
                    </tr>                  
                  </table>
                </td>            
              </tr>

              <tr>
                <td></td>                
                <td align='left'> 
                  <table border='0'>
                    <tr>
                      <td> <?php
                        if ( (isset($_POST['imagen'])) && (file_exists('fotos/'.$_POST['imagen'])) ) { ?>
                          <button type='image' name='button_loadfile' id='button_loadfile'>
                            <img width='110' height='140' src="<?php echo 'fotos/'.$_POST['imagen']; ?>" title='Imagen'/>
                          </button> <?php
                        } elseif ( (isset($_POST['codimg'])) && (file_exists('fotos/'.$_POST['codimg'])) ) { ?>
                          <button type='image' name='button_loadfile' id='button_loadfile'>
                            <img width='110' height='140' src="<?php echo 'fotos/'.$_POST['codimg']; ?>" title='Imagen'/>
                          </button> <?php
                        } else { ?>
                          <button type='submit' name='button_loadfile' id='button_loadfile' class='btn btn-success btn-2x'><i class='fa fa-upload' aria-hidden='true'></i> Cargar Imagen </button> <?php
                        } ?>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td colspan='2' align='center'>
                  <button type='submit' name='boton_grabar' id='boton_grabar' class='btn btn-primary btn-block'><i class='fa fa-floppy-o' aria-hidden='true'></i> Grabar </button>
                </td>
              </tr>
            </table>
          </form>
        </div>
      </section>
    </div>
  </body>
</html>