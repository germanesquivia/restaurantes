<div class='container-fluid' align='center' style='padding: 5px;'>
  <table class='table-borderless' align='center'>
    <tr>
      <td>
        <table class='table-borderless'>
          <tr>
            <td><?php
              if (isset($wingrabar)) { ?>
                <button type='button' class='btn btn-outline-primary' onclick='document.form1.submit()'><i class='fa fa-reply-all' aria-hidden='true'></i></button><?php
              } elseif (isset($winpopup)) { ?>
                <form id='form_return' name='form_return' method='POST' action="<?php echo $pagact; ?>">
                  <input type='hidden' name='id_category' value="<?php if (isset($_POST['id_category'])) { echo $_POST['id_category']; } ?>" >
                  <button class='btn btn-outline-primary'><i class='fa fa-reply-all' aria-hidden='true'></i></button>
                </form><?php                
              } else { ?>
                <a href='menu.php'>
                  <button class='btn btn-outline-primary'><i class='fa fa-reply-all' aria-hidden='true'></i></button>
                </a><?php
              } ?>
            </td>
                      
            <td class='col-auto bg-primary text-light text-center'>
              <b><?php echo trim($_SESSION['nomempresa']).' - '.trim($_SESSION['empresaweb']); ?></b>
            </td>
                                          
            <td class='col-auto bg-primary text-light'>
              <table border='0' cellspacing='0' id='mr'>
                <tr>                              
                  <td class='col-auto bg-primary text-light'><b><?php echo trim($_SESSION['usuario_login']); ?></b></td>
                  <td class='col-auto bg-primary text-light'><b><?php echo date('Y-m-d', time()); ?></b></td>
                  <td class='col-auto bg-primary text-light'><b><?php echo date('g:i:s a', time()); ?></b></td>
                  <td class='col-auto bg-primary text-light'><b>INDEED</b></td>                    
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>        
  </table>
</div>
<script language='javascript'> funresolucion() </script>