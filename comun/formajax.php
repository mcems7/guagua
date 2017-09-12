<?php 
@session_start();
ob_start();
if (isset($_GET['envio'])){
    echo "0";
    exit();
}
?>
<form id="fo3" class="form_ajax" resp_1="Exito" resp_0="Error" action="?envio" method="post" name="fo3" callback_1="alert('prueba1')" callback_0="alert('prueba0')" callback="alert('prueba_todos')">
<fieldset><legend>Perfil</legend>
<ol>
    <li><label>Nombres:</label><input name="fnombres" size="30" type="text" /></li>
    <li><label>Apellidos:</label><input name="fapellidos" size="30" type="text" /></li>
    <li><label>Correo:</label><input name="fcorreo" size="30" type="text" /></li>
</ol>
<input name="mysubmit" type="submit" value="Enviar" /></fieldset>
</form>
<div id="result"></div>
<?php $contenido = ob_get_contents();
ob_clean();
include ("plantilla.php");
 ?>
