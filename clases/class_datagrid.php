<?php
class DataGridMySql extends MySQL {
  var $resultamysql, $canregis=0, $fecexc, $pagact, $fontcolor=0, $totales=array(), $inicial='0', $ciudad='0',
      $descripcion, $direccion, $id, $nombre, $codimg, $id_restaurante='0', $id_mesa='0';
  var $dias = array('Dom','Lun','Mar','Mie','Jue','Vie','Sab'),
      $meses = array('','Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic');
	    
  function setSqlTexto($sql_texto) {
    if (!empty($sql_texto)) {
      $this->resultamysql = parent::query($sql_texto,'class_datagrid-1');
    }
    setlocale(LC_CTYPE, 'es');
  }    

  function cargarIniciales() {        
    $sql_texto = "CALL con_restaurantes(2,0,'','','','','','','')";
    $this->consulta = parent::query($sql_texto, $this->pagact."-3"); ?> 
    <select name="inicial" id='inicial' class='browser-default custom-select' onchange = "this.form.submit()" onfocus="document.getElementById('ciudad').value = '0' " >
      <option value="0">Selecciona Una Inicial...</option> <?php
      while( $row = parent::fetch_array($this->consulta) ) {
        echo "<option value=".$row['inicial'];
        if ( $this->inicial != "0" && ($this->inicial === $row["inicial"]) ) { echo " selected "; }
        echo ">".$row['inicial']."</option>";      
      } ?> 
    </select> <?php
    $this->liberar($this->consulta);
  }  

  function cargarCiudades() {        
    $sql_texto = "CALL con_restaurantes(3,0,'','','','','','','')";
    $this->consulta = parent::query($sql_texto, $this->pagact."-3"); ?> 
    <select name="ciudad" id='ciudad' class='browser-default custom-select' onchange = "this.form.submit()" onfocus="document.getElementById('inicial').value = '0' " >
      <option value="0">Selecciona Una Ciudad...</option> <?php
      while( $row = parent::fetch_array($this->consulta) ) {
        echo "<option value=".$row['ciudad'];
        if ( $this->ciudad != "0" && ($this->ciudad === $row["ciudad"]) ) { echo " selected "; }
        echo ">".$row['ciudad']."</option>";      
      } ?> 
    </select> <?php
    $this->liberar($this->consulta);
  }    

  function loadRestaurante() {
	  $sql_texto = "CALL con_restaurantes(4,'$this->id','','','','','','','')";
    $this->consulta = parent::query($sql_texto, $this->pagact.'-1');
    $row = parent::fetch_array($this->consulta);
    $this->nombre = $row['nombre'];
    $this->descripcion = $row['descripcion'];
    $this->direccion = $row['direccion'];
    $this->ciudad = $row['ciudad'];
    $this->codimg = $row['codimg'];
    $this->liberar($this->consulta);
  }	  

  function cargarRestaurantes($onsubmit) {        
    $sql_texto = "CALL con_restaurantes(10,0,'','','','','','','')";
    $this->consulta = parent::query($sql_texto, $this->pagact."-cargarRestaurantes"); ?> 
    <select name="id_restaurante" id='id_restaurante' class='browser-default custom-select' 
      <?php if ($onsubmit==1) { echo 'onchange = "this.form.submit()"'; } ?> >
      <option value="0">Selecciona Un Restaurante...</option> <?php
      while( $row = parent::fetch_array($this->consulta) ) {
        echo "<option value=".$row['id_restaurante'];
        if ( $this->id_restaurante != "0" && ($this->id_restaurante === $row["id_restaurante"]) ) { echo " selected "; }
        echo ">".$row['nombre_restaurante']."</option>";      
      } ?> 
    </select> <?php
    $this->liberar($this->consulta);
  }    

  function cargarMesas() {        
    $sql_texto = "CALL con_reservas(3,0,'',0,'')";
    $this->consulta = parent::query($sql_texto, $this->pagact."-cargarMesas"); ?> 
    <select name="id_mesa" id='id_mesa' class='browser-default custom-select'>
      <option value="0">Selecciona Una Mesa...</option> <?php
      while( $row = parent::fetch_array($this->consulta) ) {
        echo "<option value=".$row['id'];
        if ( $this->id_mesa != "0" && ($this->id_mesa === $row["id"]) ) { echo " selected "; }
        echo ">".$row['nombre_mesa']."</option>";      
      } ?> 
    </select> <?php
    $this->liberar($this->consulta);
  }    

  function vistadatos_bt($columnas,$colcheck,$cabeceras,$codigo,$per_usu,$checkreadonly,$colnumericas,$pagimg,$tamano) {
    if (!is_null($cabeceras)) {
      echo '<tr>';
      foreach ($cabeceras as $valor) { ?>
        <td class='text-center bg-primary text-white font-weight-bold'> <?php echo $valor; ?> </td> <?php
      }
      echo '</tr>';
    }
    $i=0; $num_fila=0; 
    while($resultados = parent::fetch_array($this->resultamysql)) {
      $this->canregis++; 
      if ( ($this->fontcolor == 1) && ($resultados['diftxt'] == 1) ) { ?>
        <tr class='trtextrojo'> <?php
      } else { ?>
        <tr> <?php      
      } 
      echo "<input type='hidden' name='opcion[$i][opmenu]' value='$resultados[$codigo]'>";
        foreach ($columnas as $valor) {
          if ( strpos($colnumericas,$valor) === false ) { ?>
            <td>
              <?php echo $resultados[$valor]; ?>
            </td> <?php
          } else {
            $numdec = ( $resultados[$valor]==(int)$resultados[$valor] ) ? 0 : 2;
            echo '<td align="right">'.number_format($resultados[$valor],$numdec,',','.').'</td>';
            if (!isset($this->totales[$valor])) { $this->totales[$valor] = 0; }
            $this->totales[$valor] += $resultados[$valor];
          }
        }
        if($per_usu != '') { // Para una sola columna (como en insumos)
          if($per_usu === 'PU') { // Asignar Permisos a Perfiles de Usuarios
            foreach ($colcheck as $valor) { // Para varias columnas (como en permisos aplicaciones)
              $nomper = ucfirst($valor);
              if ($valor==='acceso') { 
                $classbtn='custom-control custom-checkbox btn btn-outline-info btn-sm'; 
              } elseif ($valor==='grabar') { 
                $classbtn='custom-control custom-checkbox btn btn-outline-success btn-sm'; 
              } elseif ($valor==='modificar') { 
                $classbtn='custom-control custom-checkbox btn btn-outline-dark btn-sm'; 
              } else { $classbtn='custom-control custom-checkbox btn btn-outline-danger btn-sm'; 
              }              
              echo "<td align='center'> "."<div class='$classbtn'>";
              echo "<input type='checkbox' class='custom-control-input' name='opcion[$i][$valor]' id='opcion[$i][$valor]'";
              if($resultados[$valor]==1) { echo "' checked=checked '"; }
              if ( ($checkreadonly==1) || ( ($checkreadonly==2) && ($resultados[$tamano]==1) ) ) { echo "' disabled '"; }
              echo " value=1>";
              echo "<label class='custom-control-label' for='opcion[$i][$valor]' style='cursor: pointer;'>  $nomper </label>";
              echo "</div></td>";
            }            
          } else {
            foreach($colcheck as $coditeatro) {
              echo "<td align='center'><div class='custom-control custom-checkbox'>";
              echo "<input type='checkbox' class='custom-control-input' name='cajachequeo[$i]' id='cajachequeo[$i]'";
              if($resultados[$per_usu]!=NULL) {
                echo "' checked=checked '";
              }
              echo " value='$resultados[$coditeatro]'>";
              echo "<label class='custom-control-label' for='cajachequeo[$i]' style='cursor: pointer;'></label></div></td>";
            }
          }
        } else {
          if ($colcheck[1] != '') {
            foreach ($colcheck as $valor) { // Para varias columnas (como en permisos aplicaciones)
              echo "<td align='center'><div class='custom-control custom-checkbox'>";
              echo "<input type='checkbox' class='custom-control-input' name='opcion[$i][$valor]' id='opcion[$i][$valor]'";
              if($resultados[$valor]==1) { echo "' checked=checked '"; }
              if ( ($checkreadonly==1) || ( ($checkreadonly==2) && ($resultados[$tamano]==1) ) ) { echo "' disabled '"; }
              echo " value=1>";
              echo "<label class='custom-control-label' for='opcion[$i][$valor]' style='cursor: pointer;'></label></div></td>";
            }
          }
        }            
        $i++;          
        /* (pag1)Editar, (pag2)Borrar, (pag3)Imprimir */
        if ( (!empty($pagimg)) && (count($pagimg)>0) ) {
          if (isset($pagimg['codimg'])) { ?>
            <td valign='middle' align='center'> <?php
              if ( (isset($pagimg['codimg'])) && (!empty($resultados['codimg'])) ) { ?>
                  <img width='45' height='45' src="<?php echo 'fotos/'.$resultados['codimg']; ?>" title=''/> <?php
              } ?>
            </td> <?php
          }
          
          if (!empty($pagimg)) { ?>
            <td valign='middle' align='center'> <?php
              if (isset($pagimg['pag1'])) { ?>
                <button class='btn btn-outline-success btn-sm' onclick="nuevaventana(<?php echo "'".$pagimg['pag1']."?codigo=".$resultados[$codigo]."'"; ?>,<?php echo $tamano ?>)" >
                  <i class='fa fa-pencil-square-o' aria-hidden='true'></i>
                </button> <?php
              }                  
              if (isset($pagimg['pag2'])) { ?>
                <button class='btn btn-outline-danger btn-sm' onclick="newventanaconfirm(<?php echo "'".$pagimg['pag2']."?codigo=".$resultados[$codigo]."'"; ?>,<?php echo $tamano ?>,<?php echo "'"."DESEA ELIMINAR: \\n".$resultados['nomelimina']."'"; ?>)" >
                  <i class='fa fa-trash-o' aria-hidden='true'></i>
                </button> <?php
              }              
              if (isset($pagimg['pag3'])) { ?>
                <a href="javascript:nuevaventana(<?php echo "'".$pagimg['pag3']."?codigo=".$resultados[$codigo]."'"; ?>,<?php echo $tamano ?>);"> <?php
                  echo "<button type='button' class='btn btn-outline-info btn-sm'><i class='fa fa-print' aria-hidden='true'></i></button>"; ?>
                </a> <?php
              }                  
              if (isset($pagimg['pag4'])) { ?>
                <a href="javascript:nuevaventana(<?php echo "'".$pagimg['pag4']."?codigo=".$resultados[$codigo]."'"; ?>,<?php echo $tamano ?>);"> <?php
                  echo "<button type='button' class='btn btn-outline-primary btn-sm'><i class='fa fa-eye' aria-hidden='true'></i></button>"; ?>
                </a> <?php
              } ?>
            </td> <?php
          }
        } 
        $num_fila++; ?>
      </tr> <?php
    } 
    parent::liberar($this->resultamysql);
  }  // endfunction

} /*End Class*/ ?>