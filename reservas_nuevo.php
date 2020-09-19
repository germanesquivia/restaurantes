<?php session_start(); ?>
<!DOCTYPE html>
<html> <?php
  $head_array = array('titulo'=>'RESERVAS','alerta'=>1,'refresh_parent'=>1,'abrir_ventana'=>1); 
  require ('head_base.php'); ?>
  <body onload="document.getElementById('nombre').focus()";>
    <div class='container-fluid'> <?php 
      date_default_timezone_set('America/Bogota');
      $pagact = 'reservas.php'; $_SESSION['pagact'] = $pagact;
      require('clases/class_mysql.php');
      require('clases/class_datagrid.php');      
      if (isset($_POST['errgrabar']) ) { ?>
        <script language='javascript'> mensajealerta("<?php echo $_POST['errgrabar']; ?> "); </script> <?php
      }
      $obj = new datagridmysql(''); ?>
      <header><?php $winpopup=true; require('caja_titulo_bt.php'); ?></header>

      <section>
        <div class='container-fluid' align='center'>
          <h5><u><?php echo $head_array['titulo']; ?></u></h5>
          <form id='form1' name='form1' method='POST' action='reservas_nuevo_grabar.php' autocomplete='off'>
            <input type='hidden' name='id' value="<?php echo (isset($_POST['id'])) ? $_POST['id'] : 0; ?>" >
            <table class='table-sm small'>
              <tr>
                <td class='text-right font-weight-bold'>Restaurante:</td>
                <td>                
                  <table class='table-sm'>
                    <tr>
                      <td>
                        <?php $obj->cargarRestaurantes(0); ?>
                      </td> 
                    </tr>                  
                  </table>
                </td>            
              </tr>

              <tr>
                <td class='text-right font-weight-bold'>Mesa:</td>
                <td>                
                  <table class='table-sm'>
                    <tr>
                      <td>
                        <?php $obj->cargarMesas(); ?>
                      </td> 
                    </tr>                  
                  </table>
                </td>            
              </tr>

              <tr>
                <td class='text-right font-weight-bold'>Cliente:</td>
                <td>
                  <input type='text' class='form-control' name='nombre_cliente' id='nombre_cliente' 
                    value="<?php if ( isset($_POST['nombre_cliente']) ) { echo $_POST['nombre_cliente']; } ?>" 
                    size='50' maxlength='50'>
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