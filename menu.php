<?php session_start(); ?>
<!DOCTYPE html>
<html> <?php
  $head_array = array('titulo'=>'INDEED'); 
  require ('head_base.php'); ?>
  <body> 
    <div class='container-fluid'> <?php date_default_timezone_set('America/Bogota'); ?>
      <section> 
        <div class='container' align='center'>          
            <table class='table-sm' width='55%'>
                <tr>
                  <td class='text-center font-weight-bold'>
                    <h2> -MENU RESTAURANTES- </h2>
                  </td>
                </tr>

                <tr>
                  <td> 
                    <form id='form1' name='form1' method='POST' action='restaurantes.php'>
                      <button type='submit' name='restaurantes' id='restaurantes' class='btn btn-outline-primary btn-block'>
                        <i class='text-danger fa fa-cutlery fa-3x' aria-hidden='true'></i> <br><span class='text-right font-weight-bold'>CRUD Restaurantes</span>
                      </button>
                    </form>
                  </td>
                </tr>

                <tr>
                  <td> 
                    <form id='form1' name='form1' method='POST' action='reservas.php'>
                      <button type='submit' name='reservas' id='reservas' class='btn btn-outline-primary btn-block'>
                        <i class='text-success fa fa-calendar fa-3x' aria-hidden='true'></i> <br><span class='text-right font-weight-bold'>CRUD Reservas</span>
                      </button>
                    </form>
                  </td>
                </tr>            

                <tr>
                  <td> 
                    <form id='form1' name='form1' method='POST' action='restaurantes_cliente_consultar_restaurantes_api.php'>
                      <button type='submit' name='api_restaurantes' id='api_restaurantes' class='btn btn-outline-primary btn-block'>
                        <i class='text-secondary fa fa-cloud-download fa-3x' aria-hidden='true'></i> <br><span class='text-right font-weight-bold'>API - Cliente Para Consultar Restaurantes</span>
                      </button>
                    </form>
                  </td>
                </tr>            

                <tr>
                  <td> 
                    <form id='form1' name='form1' method='POST' action='restaurantes_cliente_hacer_reserva_api.php'>
                      <button type='submit' name='api_reservas' id='api_reservas' class='btn btn-outline-primary btn-block'>
                        <i class='text-secondary fa fa-cloud-upload fa-3x' aria-hidden='true'></i> <br><span class='text-right font-weight-bold'>API - Cliente Para Hacer Una Reserva</span>
                      </button>
                    </form>
                  </td>
                </tr>            
            </table>
          </form>
        </div>
      </section>
    </div>
  </body>
</html>
