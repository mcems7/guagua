<?php
#Configuración para conexion a Base de datos
define ('SERVIDORBD','localhost');
define ('USUARIOBD','root');
define ('CLAVEBD','');
define ('BASEDEDATOS','guagua');
#
#Configuración de Zona Horaria
define ('TIME_ZONE','America/Bogota');
define ('TIME_ZONE_OFFSET','-5:00');
#
#Configuración para ruta de carpetas comunes y modulos
define ("SGA_COMUN_SERVER",dirname(__FILE__));
$url_comun = str_replace("\\","/",dirname(__FILE__)); $url_comun = str_replace($_SERVER['DOCUMENT_ROOT'],"",$url_comun); $url_comun = "//".$_SERVER['SERVER_NAME']."/".$url_comun;
$url =  str_replace("/comun","",$url_comun);                                    
$url_server =  str_replace("/comun","",SGA_COMUN_SERVER);
define ("SGA_COMUN_URL","//".$url_comun);
define ("SGA_SERVER",$url_server);
define ("SGA_URL","//".$url);
define ("SGA_COMUN_IMAGES","//".$url."/comun/img");
define ("SGA_COMUN_IMAGES_URL","//".$url."/comun/img");
define ("SGA_CURSOS_URL","//".$url."/cursos");
define ("SGA_DATOS_URL","//".$url."/datos");
define ("SGA_REPORTES_URL","//".$url."/reportes");
define ("SGA_FOROS_URL","//".$url."/foros");
define ("SGA_USUARIO_URL","//".$url."/usuario");
define ("SGA_MENSAJE_URL","//".$url."/mensajes");
define ("SGA_CUESTIONARIO_URL","//".$url."/cuestionario");
define ("SGA_RED_URL","//".$url."/red");
define ("SGA",$_SERVER['DOCUMENT_ROOT']);//cuidado es la raiz, no la ruta del sw
$ruta_sga_data = "/datos/";
if (!file_exists(SGA_SERVER.$ruta_sga_data))
@mkdir (SGA_SERVER.$ruta_sga_data);
define ("READFILE_SERVER",SGA_SERVER.$ruta_sga_data);
#define ("READFILE_URL",SGA_RED_URL."/readfile.php?file=");
define ("READFILE_URL","//".$url.$ruta_sga_data);
#
$array_roles = array("admin"=>"Administrador","docente"=>"Docente","estudiante"=>"Estudiante","acudiente"=>"Acudiente");
?>