<?php session_start(); ?>
<!DOCTYPE html>
<html> <?php
  $_SESSION['nomempresa'] = 'INDEED';
  $_SESSION['empresaweb'] = 'INDEED';
  $_SESSION['usuario_login'] = 'GERMAN NIETO';
  $head_array = array('titulo'=>'RESTAURANTES','alerta'=>1,'nueva_ventana'=>1,'ventana_confirm'=>1); 
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
      if (isset($_POST['inicial'])) { 
        $obj->inicial = $_POST['inicial'];         
      }
      if (isset($_POST['ciudad'])) { 
        $obj->ciudad = $_POST['ciudad'];         
      } ?>
      <header><?php require('caja_titulo_bt.php'); ?></header>
      
      <section>
        <div class='container' align='center'>
          <?php $obj->barraTitulo($head_array['titulo'], 'restaurantes_nuevo.php?codigo=0&&nuevo=1', false); ?>
          <form id='form1' name='form1' method='POST' action='restaurantes.php'>
            <table class='table-sm'>
              <tr>
                <td align='center'>
                  <table class='table-sm'>
                    <tr>
                      <td class='text-right font-weight-bold'>Filtro Por Inicial:</td>
                      <td>      
                        <table>
                          <tr>
                            <td>
                              <div class='custom-control custom-radio'>
                                <?php $obj->cargarIniciales(); ?>
                              </div>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>

                    <tr>
                      <td class='text-right font-weight-bold'>Filtro Por Ciudades:</td>
                      <td>      
                        <table>
                          <tr>
                            <td>
                              <div class='custom-control custom-radio'>
                                <?php $obj->cargarCiudades(); ?>
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
            $cabeceras = array('Codigo','Nombre Restaurante','Descripcion','Direccion','Ciudad','Foto','Acciones');
            $columnas = array('id','nombre','descripcion','direccion','ciudad');
            $colcheck[1] = '';
            $pagimg = array('pag1'=>'restaurantes_nuevo.php', 'pag2'=>'restaurantes_eliminar.php','codimg'=>'codimg');
            $colnumericas = '';
            $sql_texto = "CALL con_restaurantes(1,0,'','','','','$obj->inicial','$obj->ciudad','')";
            $obj->setSqlTexto($sql_texto);
            $obj->vistadatos_bt($columnas,$colcheck,$cabeceras,'id','',1,$colnumericas,$pagimg,1); ?>
          </table>
        </div>
      </section>
    </div>
  </body>
</html>