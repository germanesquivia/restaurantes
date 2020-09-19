<?php
class MySQL {
  var $conexion, $transaccion=false, $meses='0', $captcha, $valselect=1, $rutaimg, $codimg;  
	
  public function __construct($seldb) {
    if(!isset($this->conexion)) {
      $seldb = 'restaurantes'; 
      $this->conexion = (mysqli_connect('localhost','root','Indeed20200919',$seldb,'3306')); 
      if (!$this->conexion) {
        die ('Fallo la conexion a la BD: '.mysqli_connect_error());
      }      
      $zona_horaria = "'-05:00'"; // Zona Horaria Colombia
      $this->query('SET NAMES utf8',' Estableciendo utf8 ');
      $this->query('SET time_zone = '.$zona_horaria, ' Estableciendo Zona Horaria ');
    }    
  }  
            
  function query($texto_query, $texto_error) {    
    $resultados = mysqli_query($this->conexion, $texto_query);
    if (!$resultados) {			
      $error = mysqli_error($this->conexion);
      if ( $this->transaccion ) {				
        $this->rollback();
      }
      die("Problema con Query :: ".$error." :: ".$texto_error);
    }		
    return $resultados; 
  }
    
  function fetch_array($resultados) {
    return mysqli_fetch_array($resultados);
  }

  function num_rows($resultados) {
    return mysqli_num_rows($resultados);
  }

  function fetch_row($consulta) { 
    return mysqli_fetch_row($consulta);
  }

  function fetch_assoc($resultados) { 
    return mysqli_fetch_assoc($resultados);
  } 	
	
  function transaction() {
    mysqli_query($this->conexion, "BEGIN");
    $this->transaccion = true;
  }
    
  function selectdb($db) {
    mysqli_select_db($this->conexion, $db );
  }
    
  function commit() {
    mysqli_query($this->conexion, "COMMIT");
  }

  function rollback() {
    mysqli_query($this->conexion, "ROLLBACK");
  }
	
  function liberar($cursor_resultados) {
    mysqli_next_result($this->conexion); 
    mysqli_free_result($cursor_resultados);
  }
    
  function liberados($cursor_resultados) {
    mysqli_next_result($this->conexion); 
    mysqli_free_result($cursor_resultados);
  }    
    	   
  function cerrar() {
    mysqli_close($this->conexion);
  }
	
  function __destruct() {
		
  }	    

  function validpg() {       
    $texto = func_get_args();
    $i = 0;
    $retorno = TRUE;
    while ( ($i<func_num_args()) && ($retorno===TRUE) ) {   
      if ( !empty($texto[$i]) ) { 
        if ( (stripos($texto[$i], ' SELECT ')===FALSE) && (stripos($texto[$i], ' INSERT ')===FALSE)
          && (stripos($texto[$i], ' UPDATE ')===FALSE) && (stripos($texto[$i], ' DELETE ')===FALSE) 
          && (stripos($texto[$i], ' ALTER ')===FALSE) && (stripos($texto[$i], ' DROP ')===FALSE) 
          && (stripos($texto[$i], ' LIKE ')===FALSE) && (stripos($texto[$i], ' AND ')===FALSE) 
          && (stripos($texto[$i], ' CREATE ')===FALSE) && (stripos($texto[$i], 'GRANT ')===FALSE)
          && (stripos($texto[$i], ' USER ')===FALSE) && (stripos($texto[$i], ' ALL ')===FALSE)
          && (stripos($texto[$i], ' FROM ')===FALSE) && (stripos($texto[$i], ' REVOKE ')===FALSE)
          && (stripos($texto[$i], ' WHERE ')===FALSE) ) {
          if (!preg_match('/[a-zA-Z0-9]|-|.|_|:|@/', $texto[$i])) {
            $retorno = FALSE;
          }         
        } else {
          $retorno = FALSE;
        }
      }
      ++$i;
    }
    return $retorno;
  }
  
  function barraTitulo($titulo, $url, $deshabilitado) { ?>  
    <table class='table-sm'>
      <tr> <?php
        if (!empty($url)) { ?>
          <td class='col-auto'> <?php
            if ($deshabilitado) { ?>
              <button type='button' class='btn btn-outline-secondary btn-sm' data-toggle='tooltip' data-placement='top' title='Alt +' disabled>
                <i class='fa fa-plus-square fa-lg' aria-hidden='true'></i> Nuevo
              </button> <?php
            } else { ?>
              <a href="javascript:nuevaventana('<?php echo $url; ?>','1');">
                <button type='button' class='btn btn-outline-primary btn-sm' data-toggle='tooltip' data-placement='top' title='Alt +' accesskey='+'>
                  <i class='fa fa-plus-square fa-lg' aria-hidden='true'></i> Nuevo
                </button>
              </a> <?php
            } ?>
          </td> <?php
        } ?>
        <td class='col-10 text-center'> <h5><u><?php echo $titulo; ?></u></h5> </td>
      </tr>
    </table> <?php
  }

}