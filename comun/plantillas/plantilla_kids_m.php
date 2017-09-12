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
    <script src="<?php echo SGA_COMUN_URL ?>/js/modernizr-inputtypes.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo SGA_COMUN_URL ?>/lib/emojionearea/dist/emojionearea.min.css" media="screen">
      <script type="text/javascript" src="<?php echo SGA_COMUN_URL ?>/lib/emojionearea/dist/emojionearea.js"></script>
    <script src="<?php echo SGA_COMUN_URL ?>/js/jquery.steps.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo SGA_COMUN_URL ?>/img/png/icon-sga.php">
	<link href="<?php echo SGA_COMUN_URL ?>/css/jquery.contextMenu.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo SGA_COMUN_URL ?>/js/jquery.contextMenu.js" type="text/javascript"></script>
    <link href="<?php echo SGA_COMUN_URL ?>/css/checkbox_animado.css" rel="stylesheet" type="text/css" /><link href="<?php echo SGA_COMUN_URL ?>/css/colores.css.php" rel="stylesheet" type="text/css" />
</head>
<body contextmenu="menu_body" class="menu_body">
<?php if (isset($_GET['guia']) and $_GET['guia'] == "SI") require("guia.php") ?>
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
    <div class="container">
         <div class="page-header">
            <?php #require(dirname(__FILE__)."/header.php"); ?>
            <?php if (!isset($_GET['embebido'])) require(SGA_COMUN_SERVER."/menu.php"); ?>
            <!--ol id="ruta_de_migas" class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Library</a></li>
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Library</a></li>
              <li class="breadcrumb-item active">Data</li>
            </ol-->
           	<main style="
    padding-top: 30px;
">
           	    <section>
                <?php if (isset($contenido)) echo $contenido; ?>
                </section>
            </main>
        </div>
    </div>
    <span id="txt_alertas"></span>
    <br><br>
     <?php if (!isset($_GET['embebido'])) require(SGA_COMUN_SERVER."/footer.php"); ?>
</body>
</html>