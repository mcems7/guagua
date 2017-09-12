<?php
@session_start();
require_once ("../comun/funciones.php");
require_once ("../comun/config.php");
require ("../comun/conexion.php");
ob_clean();
ob_start();
$_SESSION['login']='login'; $intentos =2;
if (isset($_GET['logout'])){  cerrar_session(true); } cerrar_session(false);//pendiente comprobar funcionamiento
if(isset($_COOKIE['repetidas']) and $_COOKIE['repetidas']>=$intentos){ ?>
    <script type="text/javascript" >
validar_intentos_fallidos(tiempo_en_segundos='60',tiempo_redireccionamiento='4000');
    </script>
<?php }

if (isset($_POST['usuario'])){

$usuario = $mysqli->real_escape_string($_POST['usuario']);
$clave = encriptar($mysqli->real_escape_string($_POST['clave']));
    $sql = "SELECT * from usuario WHERE `clave` = '$clave' and `usuario` = '$usuario' and estado='activo'  ";
   $consulta = $mysqli->query($sql);
   if ($row=$consulta->fetch_assoc()){
$ultima_sesion_fecha = date("Y-m-d",strtotime($row['ultima_sesion']));//formato
$hoy = date("Y-m-d");
#echo $ultima_sesion_f;
#echo $hoy;
#echo $sql;
#exit();
if ($ultima_sesion_fecha != $hoy){
$sql_visitas = "UPDATE `usuario` SET `num_visitas`=`num_visitas`+1 , `puntos`=`puntos`+1 WHERE `id_usuario` = '".$row['id_usuario']."'";
$consulta_visitas = $mysqli->query($sql_visitas); if($mysqli -> affected_rows>0) $row['puntos']++;}
       registrar_visita_usuario($hoy,$row['usuario']);
       $misroles = explode(",",$row['rol']);
        if(in_array($_POST['rol'],$misroles)) $_SESSION['rol'] = $mysqli->real_escape_string($_POST['rol']);
        else $_SESSION['rol'] = $misroles[0];
        $_SESSION['id_usuario'] = $row['id_usuario'];
        $_SESSION['usuario'] = $row['usuario'];
        $_SESSION['nombre_usu'] = $row['nombre']." ".$row['apellido'];
        $_SESSION['nombre'] = $row['nombre'];
        $_SESSION['apellido'] = $row['apellido'];
        $_SESSION['foto'] = $row['foto'];
        $_SESSION['roles'] = $row['rol'];
        $ruta = READFILE_SERVER."//foto/".$row['foto'];
//recordarme
if (isset($_POST['recordarme']) and $_POST['recordarme']=="SI"){
$cookie_name = "usuarios[".$row['id_usuario']."]";
$cookie_value = $row['usuario'];
setcookie($cookie_name, $cookie_value, time() + (86400 * 365), "/"); // 86400 = 1 dia
}
//fin recordarme
       $ext1 = explode(".",$ruta);
       $ext = end($ext1);
       if (file_exists($ruta)){
       $ruta_tmp = "login.$ext";
       copy ($ruta,$ruta_tmp);
       }
       @session_start();
       $_SESSION['num_visitas'] = $row['num_visitas'];//+1;
       $_SESSION['puntos'] = $row['puntos'];
#if($_POST['rol']=='Docente'){ $_SESSION['rol']="docente" ; }  
#if($_POST['rol']=='Administrador'){ $_SESSION['rol']="admin" ; }  
#if($_POST['rol']=='Estudiante'){ $_SESSION['rol']="estudiante" ; }  
#if($_POST['rol']=='Acudiente'){ $_SESSION['rol']="acudiente" ; } 
if ($_SESSION['rol']=="estudiante"){
$sql_estudiante = "SELECT * from inscripcion,asignacion_academica
 WHERE id_estudiante = '".$_SESSION['id_usuario']."' and
      asignacion_academica.id_asignacion=inscripcion.id_asignacion 
      order by id_inscripcion desc limit 1  ";
 $consulta_estudiante = $mysqli->query($sql_estudiante);
    if ($row_estudiante= $consulta_estudiante->fetch_assoc()){
       $_SESSION['id_categoria_curso'] = $row_estudiante['id_categoria_curso'];
       
    }
}
 
       if ($_SESSION['rol']=="acudiente"){
      
       header("Location: ../usuario/elegir_hijo.php");
       }else{
       header("Location: ../index.php");
           
       }
 
   }
   $numrow = $consulta->num_rows;
   if ($numrow==0){
       ?>
       <script>alert2('El Usuario y/o contraseña no son correctos, Por favor verifique su información e intente de nuevo','error')</script>
       <?php
   }
}
?>
<div class="container-fluid bg-3 text-center" style="background-image: url('../comun/img/fondo_login.jpg');">    
 <div class="row">
		<form id="form_login" action="" style="width:50%;align:center;margin-left:25%;" method = "POST" >
<div align="center" style="margin:0 auto">
<div id="usuarios_recordados">
<?php
$arrayusuarios = array();
if(isset($_COOKIE['usuarios']))
$arrayusuarios = $_COOKIE['usuarios'];
if (count($arrayusuarios)>0)
foreach ($arrayusuarios as $id=>$nombre){
if($nombre!=""){
$datos = consultar_datos_usuario($nombre);
?>
<span>
  
<div class="estilos_fotos" onclick="elegir_cuenta();document.getElementById('imgusuario').src=document.getElementById('foto_<?php echo $id ?>').src;document.getElementById('usuario').value='<?php echo $nombre;?>';document.getElementById('clave').focus();">
<button title="Dejar de recordarme" type="button" style="margin-bottom: -25px;z-index: 1;" class="close" onclick="olvidar_usuario('<?php echo $id ?>')">&times;</button>
<img onmouseout="datosparalogin(this.value);" id="foto_<?php echo $id ?>" height="120px" src="<?php echo $datos['foto']; ?>">
<div><label style="margin-top:15px;font-size: 17px;"><?php echo puntos_suspensivos($datos['nombre']." ".$datos['apellido'],10); ?></label></div>
</div>
</span>
<?php } } ?>
</div></div>
    <span id="imgs_login" style="display:none">
	<p><h1 class="Abckids" id="nombre_usuario">Usuario</h1></p>
	    <input id="btn_submit" height="90px" type="submit" hidden>
<label for="btn_submit"><div class="estilos_fotos">
<img  height="120px"  id="imgusuario"  src="<?php echo READFILE_URL ?>/foto/user-icon.png">
</div>
</label>
</span>



<a style="display:none" id="btn_cambiar_cuenta" class="btn btn-info" onclick="cambiar_cuenta();">Cambiar de Cuenta</a>
<br/>
<label id="ingresare">Ingresaré como&nbsp;</label><label id="un_rol" style="display:none"></label>

<select style="display:none" name="rol" id="rol"></select>
<br/>

<label id="user"  for="">Usuario</label>
	<input  onclick="datosparalogin(this.value);" autofocus onblur="datosparalogin(this.value);" onfocus="datosparalogin(this.value);"  onkeyup="elegir_cuenta();datosparalogin(this.value);"  onchange="datosparalogin(this.value);" placeholder="Ingresa Usuario"  type = "text" name ="usuario" value="" id ="usuario"/><br/>
	
<div id="mascotas" style="width:650px;margin-left:0px;">

</div>


	<label id="labelclave" for="">Contraseña</label>

	<input  onkeyup="elegir_cuenta();" required placeholder="Ingresa Clave" type = "password" name="clave" id="clave"/>
    <br>
    <input type="hidden" name="fn_login_guagua"/>
    <label><input checked type="checkbox" value="SI" name="recordarme">Recordarme</label>
<a href="recuperar/recuperar_cuenta.php"><img onclick="" style="position:absolute;margin-top:-39%;margin-left:-48%;display:none;" width="120px" height="120px" id="regresar" src="">Recuperar Contraseña</img></a>
    <br><button id="ingresar" type="submit" class="btn btn-success btn-md">Ingresar</button>
    <?php 
#Autorregistro si lo hay
$arreglo = autorregistro();
if (count($arreglo)>0){
echo "<br><br><div><input title='Si usted no tiene una cuenta en este sistema, puede registrarse' style='color:#fff' type='button' class='btn btn-info' onclick='location.href=\"".SGA_USUARIO_URL."/registrarse.php\"' value='Registrarse'></div>";
}
#Fin Autorregistro si lo hay
?>

<a href="login.php"><img onclick="" style="position:absolute;margin-top:-39%;margin-left:-48%;display:none;" width="120px" height="120px" id="regresar" src=""></img></a>
</form>
</div>
</div><br>
</center>
<?php $contenido = ob_get_contents();
ob_clean();
require ("../comun/plantilla.php");

 ?>
