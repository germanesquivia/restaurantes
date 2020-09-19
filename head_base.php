<head>
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
  <meta name='viewport' content='width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0'>
  <meta name='mobile-web-app-capable' content='yes'>
  <link rel='shortcut icon' href='graficos/icono_cinesoft.png'>
  <title><?php echo $head_array['titulo']; ?></title>
  <!-- Bootstrap CSS 4.4.1 FontAwesome 4.7.0 -->
  <link rel='stylesheet' href='bootstrap/css/bootstrap.min.css'>
  <link rel='stylesheet' href='font-awesome/css/font-awesome.min.css'>
     
  <script lenguage='javaScript'>
    function funresolucion() { 
      if (screen.width < 1024) {
        document.getElementById('mr').style.display = 'none';
        $_SESSION['version_movil'] = true;
      }            
    }
  </script> <?php
      
  if (isset($head_array['alerta'])) { ?>
    <script lenguage='javaScript'>
      function mensajealerta(txtmensaje) { alert(txtmensaje); }
    </script> <?php
  }

  if (isset($head_array['nueva_ventana'])) { ?>
    <script lenguage='javaScript'>
      function nuevaventana(url,tamano) {
        if (tamano==1) {
          emergente=window.open(url,'_self');
        } else {
          emergente=window.open(url,'_self');
        }
        newpop.focus();
        newpop.moveTo(10, 10);
      }
    </script> <?php
  }
   
  if (isset($head_array['ventana_confirm'])) { ?>
    <script lenguage='javaScript'>
      function newventanaconfirm(url,tamano,teatro) {
        if(!confirm(teatro)) {
          return false;
        } else {
          emergente=window.open(url,'_self');
          emergente.focus();
          emergente.moveTo(10, 10);
          return false;
        }
      }
    </script> <?php
  } 

  if (isset($head_array['refresh_parent'])) { ?>
    <script lenguage='javascript'>
      function refreshParent() { window.opener.document.location.reload(); }
    </script> <?php
  } 

  if (isset($head_array['abrir_ventana'])) { ?>
    <script lenguage='javaScript'>
      function abrirVentana(url) { window.open(url, "winformula", "directories=no, location=no, menubar=no, scrollbars=yes, statusbar=no, tittlebar=no, width=800, height=600"); }
    </script> <?php
  } ?>
</head>