<?php
require_once (dirname(__FILE__)."/../config.php");
?>
<!DOCTYPE html>
<html lang="es">
    <meta charset="UTF-8">
    <meta name="" content="">
    <meta name="description" content="Sistema de Gestión de Aprendizaje">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>SGA</title>
	<!--link rel="stylesheet" href="<?php echo SGA_COMUN_URL ?>/css/jquery.mobile-1.4.5.min.css"--> <!-- Pendite revisar utilidad sino borrar -->
	<link rel="shortcut icon" href="<?php echo SGA_COMUN_URL ?>/img/logo.png" type="image/x-icon" /><!--Logo de la IEM-->
	<link rel="stylesheet" href="<?php echo SGA_COMUN_URL ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo SGA_COMUN_URL ?>/css/estilossga.css">
	<script src="<?php echo SGA_COMUN_URL ?>/js/jquery-2.2.4.min.js"></script>
	<script src="<?php echo SGA_COMUN_URL ?>/js/bootstrap.min.js"></script>
	<script src="<?php echo SGA_COMUN_URL ?>/js/funciones.js"></script>
	<script src="<?php echo SGA_COMUN_URL ?>/lib/sweetalert2/dist/sweetalert2.min.js"></script>
	<link rel="stylesheet" href="<?php echo SGA_COMUN_URL ?>/lib/sweetalert2/dist/sweetalert2.css">
</head>
<body>
  <div class="container">
           <div class="row "style="padding-top:40px;">
                <div class="col-md-4 col-sm-4 col-xs-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                             <h4>DEFAULT PANEL</h4> 
                            </div>
                            <div class="panel-body">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                </p>
                              <p>
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                </p>
                            </div>
                            <div class="panel-footer">
                                <a href="#" class="btn btn-default ">DEFAULT</a>
                            </div>
                        </div>
                    </div>
                <div class="col-md-4 col-sm-4 col-xs-6">
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                             <h4>WARNING PANEL</h4> 
                            </div>
                            <div class="panel-body">

                               <p>
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                </p>
                              <p>
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                </p>
                            </div>
                            <div class="panel-footer">
                                <a href="#" class="btn btn-warning ">WARNING</a>
                            </div>
                        </div>
                    </div>
                <div class="col-md-4 col-sm-4 col-xs-6">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                             <h4>INFO PANEL</h4> 
                            </div>
                            <div class="panel-body">
                                 <p>
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                </p>
                              <p>
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                </p>
                              
                            </div>
                            <div class="panel-footer">
                                <a href="#" class="btn btn-danger ">DANGER</a>
                            </div>
                        </div>
                    </div>
               <div class="col-md-4 col-sm-4 col-xs-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                             <h4>PRIMARY PANEL</h4> 
                            </div>
                            <div class="panel-body">
                                 <p>
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                </p>
                              <p>
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                </p>
                              
                            </div>
                            <div class="panel-footer">
                                <a href="#" class="btn btn-primary ">PRIMARY</a>
                            </div>
                        </div>
                    </div>
                <div class="col-md-4 col-sm-4 col-xs-6">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                             <h4>SUCCESS PANEL</h4> 
                            </div>
                            <div class="panel-body">
                                 <p>
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                </p>
                              <p>
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                </p>
                              
                            </div>
                            <div class="panel-footer">
                                <a href="#" class="btn btn-success ">SUCCESS</a>
                            </div>
                        </div>
                    </div>
                <div class="col-md-4 col-sm-4 col-xs-6">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                             <h4>INFO PANEL</h4> 
                            </div>
                            <div class="panel-body">
 <p>
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                </p>
                              <p>
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                </p>
                              
                            </div>
                            <div class="panel-footer">
                                <a href="#" class="btn btn-info ">INFO</a>
                            </div>
                        </div>
                    </div>
                
        </div>
        </div>
    </div>

</body>
</html>