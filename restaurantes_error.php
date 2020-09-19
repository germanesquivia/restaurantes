<form id='form_err' name='form_err' method='POST' action='_blank'>
    <div class='container' align='center'>
        <table class='table'>
            <tr>
                <td> 
                    <div class='alert alert-success text-center font-weight-bold' role='alert'> 
                        <?php echo $msg; ?> &nbsp;&nbsp;&nbsp; <i class='fa fa-spinner fa-spin fa-3x fa-fw' aria-hidden='true'></i> 
                    </div>
                </td> 
            </tr> <?php

            if ( (isset($err)) && (!empty($err)) ) { ?>
                <tr>
                    <td> 
                        <div class='alert alert-warning text-center font-weight-bold' role='alert'> 
                            <?php echo $err; ?>
                        </div>
                    </td> 
                </tr> <?php
            } ?>

            <tr>
                <td align='center'>
                    <button type='submit' name='button_aceptar' id='button_aceptar' class='btn btn-primary'>
                        <i class='fa fa-sign-out fa-lg' aria-hidden='true'></i> Aceptar
                    </button>
                </td>
            </tr>
        </table>
    </div>
</form>