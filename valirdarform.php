<?php
foreach($_POST as $n_campo => $n_valor) {    
  if ( !is_array($n_campo) ) { 
     $valorinput = $n_valor;
     if (substr($n_campo,0,5) === 'check') { 
        $valorinput = 1; 
     } ?>
     <input type='hidden' name="<?php echo $n_campo; ?>" value="<?php echo $valorinput; ?>"/> <?php
  }
} ?>
