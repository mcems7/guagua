<?php
require_once 'funciones.php';
require_once 'config.php';
$tamaño_maximo = tamaño_maximo();
$formatos = formatos();
$carpeta_destino = "../red/banco_red/"; 
if (isset($_POST) and $_POST['adjunto']=="si" and $_POST['nivel_eductivo']<>""){
$total = count($_FILES['enlace']['name']);
for($i=0; $i<$total; $i++) {// Recorremos cada archivo
$extensión_archivo = (pathinfo($_FILES['enlace']['name'][$i],PATHINFO_EXTENSION)); //obtenemos la extensión del archivo mediante la función PATHINFO_EXTENSION

$nombre_archivo=$_FILES['enlace']['name'][$i];  
$ruta_tmp_archivo = $_FILES['enlace']['tmp_name'][$i];
if ($ruta_tmp_archivo != ""){ 
$extensión_archivo = (pathinfo($nombre_archivo,PATHINFO_EXTENSION));
if (in_array($extensión_archivo, $formatos)){echo "El formato no es valido"; exit(); } 
if(filesize($_FILES['enlace']['tmp_name'][$i]) > $tamaño_maximo ) {
echo "No se puede subir archivos con tamaño mayor a ".$tamaño_maximo; 
exit(); 
}
}
#inicio
 $ruta_destino = $carpeta_destino.$_FILES['enlace']['name'][$i]; 
if ($_POST['scorm']=="si"){
    @session_start();
 if (!file_exists )
{
	    mkdir($carpeta_destino.$_SESSION['id_usuario'].$_POST['titulo_red']);

} 
   # descomprimir_zip($ruta_tmp_archivo,$_POST['titulo_red']);
    $zip = new ZipArchive;
$zip->open($ruta_tmp_archivo);
$zip->extractTo($carpeta_destino.'/'.$_SESSION['id_usuario'].$_POST['titulo_red']);
$zip->close();

$ruta_destino2 = $carpeta_destino.'/'.$_SESSION['id_usuario'].$_POST['titulo_red'].'.'.$extensión_archivo; 
echo insertar_red($ruta_destino2,$extensión_archivo);

}

else{
    @session_start();
$ruta_destino = $carpeta_destino.'/'.$_SESSION['id_usuario'].$_POST['titulo_red'].'.'.$extensión_archivo; 
      if(copy($ruta_tmp_archivo,$ruta_destino)) { 
		#echo 'va a mover';
        $destino = 'banco_red/'.$_SESSION['id_usuario'].$_POST['titulo_red'].'.'.$extensión_archivo; 
echo insertar_red($destino,$extensión_archivo);
            
                }   
}
}
}
#fin
?>

