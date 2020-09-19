<?php session_start(); ?>
<!DOCTYPE html>
<html> <?php
  $_SESSION['nomempresa'] = 'INDEED';
  $_SESSION['empresaweb'] = 'INDEED';
  $_SESSION['usuario_login'] = 'GERMAN NIETO';
  $head_array = array('titulo'=>'RESERVAS - RESTAURANTES','alerta'=>1,'nueva_ventana'=>1,'ventana_confirm'=>1); 
  require ('head_base.php'); ?>
  <body> 
    <div class='container-fluid'> <?php 
      date_default_timezone_set('America/Bogota');
      if (isset($_GET['error'])) { ?>  
        <script language="javascript"> mensajealerta(<?php echo '$_GET[error]'; ?>); </script> <?php
      } 
      $pagact = 'restaurantes.php'; $_SESSION['pagact'] = $pagact;
      require('clases/class_mysql.php');
      require('clases/class_datagrid.php'); 
      $obj = new datagridmysql(''); 
      if (isset($_POST['id_restaurante'])) { 
        $obj->id_restaurante = $_POST['id_restaurante'];
      } ?>
      <header><?php require('caja_titulo_bt.php'); ?></header>
      
      <section>
        <div class='container' align='center'>
          <?php $obj->barraTitulo($head_array['titulo'], 'reservas_nuevo.php?codigo=0&&nuevo=1', false); ?>
          <form id='form1' name='form1' method='POST' action='reservas.php'>
            <table class='table-sm'>
              <tr>
                <td align='center'>
                  <table class='table-sm'>
                    <tr>
                      <td class='text-right font-weight-bold'>Filtro Por Restaurante:</td>
                      <td>      
                        <table>
                          <tr>
                            <td>
                              <div class='custom-control custom-radio'>
                                <?php $obj->cargarRestaurantes(1); ?>
                              </div>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>                    
              </tr>
            </table>
          </form>

          <table class='table-sm table-striped'> <?php
            $cabeceras = array('Codigo Reserva','Cliente','Mesa','Nombre Restaurante','Hora Reserva','Acciones');
            $columnas = array('id_reserva','nombre_cliente','nombre_mesa','nombre_restaurante','hora_reserva');
            $colcheck[1] = '';
            $pagimg = array('pag2'=>'reservas_eliminar.php');
            $colnumericas = '';
            $sql_texto = "CALL con_reservas(1,0,'',0,'$obj->id_restaurante')";
            $obj->setSqlTexto($sql_texto);
            $obj->vistadatos_bt($columnas,$colcheck,$cabeceras,'id_reserva','',1,$colnumericas,$pagimg,1); ?>
          </table>
        </div>
      </section>
    </div>
  </body>
</html>