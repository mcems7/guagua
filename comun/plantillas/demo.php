<?php
require_once (dirname(__FILE__)."/../config.php");
require_once (dirname(__FILE__)."/../funciones.php");
?>
<!DOCTYPE html>
<html lang="es">
    <meta charset="UTF-8">
    <meta name="" content="">
    <meta name="description" content="Sistema de Gestión de Aprendizaje">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>Guagua<?php if (NOMBRE_INSTITUCION) echo " - ".NOMBRE_INSTITUCION ?></title>
		<?php
	#importarjscss();
	
    ?>
    
	<!--link rel="stylesheet" href="<?php echo SGA_COMUN_URL ?>/css/jquery.mobile-1.4.5.min.css"--> <!-- Pendite revisar utilidad sino borrar -->
	<link rel="shortcut icon" href="<?php echo SGA_COMUN_URL ?>/img/favicon.png" type="image/x-icon" /><!--Logo de la IEM-->
	<link rel="stylesheet" href="<?php echo SGA_COMUN_URL ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo SGA_COMUN_URL ?>/css/estilos_guagua.css">
	<script src="<?php echo SGA_COMUN_URL ?>/js/jquery-2.2.4.min.js"></script>
	<script src="<?php echo SGA_COMUN_URL ?>/js/bootstrap.min.js"></script>
	<script src="<?php echo SGA_COMUN_URL ?>/js/funciones.js"></script>
	<script src="<?php echo SGA_COMUN_URL ?>/js/sweetalert.min.js"></script>
	<link rel="stylesheet" href="<?php echo SGA_COMUN_URL ?>/css/sweetalert.css"!>
	<!--script src="<?php echo SGA_COMUN_URL ?>/lib/sweetalert2/dist/sweetalert2.min.js"></script-->
	<!--link rel="stylesheet" href="<?php echo SGA_COMUN_URL ?>/lib/sweetalert2/dist/sweetalert2.css"-->
    <link href="<?php echo SGA_COMUN_URL ?>/css/jquery-ui.css" rel="stylesheet">
    <script src="<?php echo SGA_COMUN_URL ?>/js/jquery.js"></script>
    <script src="<?php echo SGA_COMUN_URL ?>/js/jquery-ui.js"></script>
    <script src="<?php echo SGA_COMUN_URL ?>/js/i18n/datepicker-es.js"></script>
	<script src="<?php echo SGA_COMUN_URL ?>/js/sweetalert.multi.js"></script>
    <script src="<?php echo SGA_COMUN_URL ?>/js/svgcheckbx.js" type="text/javascript"></script>
    <script src="<?php echo SGA_COMUN_URL ?>/js/jquery.steps.js" type="text/javascript"></script>
    <script src="<?php echo SGA_COMUN_URL ?>/js/jquery.steps.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo SGA_COMUN_URL ?>/img/png/icon-sga.php">
	<link href="<?php echo SGA_COMUN_URL ?>/css/jquery.contextMenu.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo SGA_COMUN_URL ?>/js/jquery.contextMenu.js" type="text/javascript"></script>
    <link href="<?php echo SGA_COMUN_URL ?>/css/checkbox_animado.css" rel="stylesheet" type="text/css" /><link href="<?php echo SGA_COMUN_URL ?>/css/colores.css.php" rel="stylesheet" type="text/css" />
</head>
<body contextmenu="menu_body" class="menu_body" style="overflow-x:hidden">
<a contextmenu="menu_body" class="menu_body"></a>
<menu id="menu_body" style="display:none;" class="showcase">
<command label="Guagua" onclick="document.location.href='<?php echo SGA_URL?>'">
<hr>
<command label="Cursos" onclick="document.location.href='<?php echo SGA_URL?>/cursos'">
<command label="Cuestionarios"  onclick="document.location.href='<?php echo SGA_URL?>/cuestionario'">
<command label="Foros" onclick="document.location.href='<?php echo SGA_URL?>/foros'">
<command label="Mensajes" onclick="document.location.href='<?php echo SGA_URL?>/mensajes'">
<command label="Red" onclick="document.location.href='<?php echo SGA_URL?>/red'">

</menu>
<?php if (!isset($_GET['embebido'])) echo '<br><br>'; ?>
<style>
    .colores div:nth-child(2n-1){
        background-color:yellow;
    }
    .colores div:nth-child(2n){
        background-color:orange;
    }
</style>
<div class="wrapper" align="center" style="margin:0 auto">
<div class="row" style="z-index:100;width:100%;position:fixed;top:0;float:left;height:624px;margin-bottom:-624px;background-color:#EEE">
<div class="row" style="width:62%;float:left;border:2px solid red;margin-bottom: -100%;
    z-index: 100;
    position: relative;height:624px;">
    A
</div>
<div class="row" style="width:38%;float:right;margin-right:14px;border:2px solid red;    margin-bottom: -100%;
    z-index: 100;
    position: relative;height:624px;">
    <div class="row" style="
    height:38%;
    border:2px solid red;
    z-index: 100;
    position: relative;
    width:100%;
    ">
    B1
</div>
    <div class="row" style="
    height:62%;
    border:2px solid red;
    z-index: 100;
    position: relative;
    width:100%;
    ">
    B2
</div>
</div>

<!--div class="row colores">
        <div class="col-md-1">
            1
        </div>
        <div class="col-md-1">
            2
        </div>
        <div class="col-md-1">
            3
        </div>
        <div class="col-md-1">
            4
        </div>
        <div class="col-md-1">
            5
        </div>
        <div class="col-md-1">
            6
        </div>
        <div class="col-md-1">
            7
        </div>
        <div class="col-md-1">
            8
        </div>
        <div class="col-md-1">
            9
        </div>
        <div class="col-md-1">
            10
        </div>
        <div class="col-md-1">
            11
        </div>
        <div class="col-md-1">
            12
        </div>
    </div-->
<div class="row">
    <div class="col-md-12">
        <h1>Foros</h1>
    </div>
</div>
<div class="row colores">
        <div class="col-md-2">Prioridad 3<br><h2>Mis Foros</h2></div>
        <div class="col-md-5">Prioridad 2<br><h2>Entrada y Comentarios</h2></div>
        <div class="col-md-3">Prioridad 1<br><h2>Comparativas<br><span style="float:left;margin-left:5%">o</span></h2></div>
        <div class="col-md-2">Prioridad 3<br><h2>Destacados</h2></div>
</div>
</div>
    <span id="txt_alertas"></span>
</body>
</html>