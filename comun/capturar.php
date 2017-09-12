<?php
require_once(dirname(__FILE__)."/config.php");
if(isset($_POST['nombre'],$_POST['imagen'])){
	@mkdir(dirname(__FILE__)."/capturas/");
	$imagen = str_replace("data:image/png;base64,","",$_POST['imagen']);
	$archivo = dirname(__FILE__)."/capturas/".$_POST['nombre'].".png";
	$archivo_url = SGA_COMUN_URL."/capturas/".$_POST['nombre'].".png";
	file_put_contents($archivo,base64_decode($imagen));
	?>
	<script language="javascript">
	window.open("<?php echo $archivo_url ?>");
	window.close();
	</script>
	<?php
	exit();
}
?>
<div style="display:none">
<form id="formdata" method="post" target="_blank" action="<?php echo SGA_COMUN_URL ?>/capturar.php">
	<input name="nombre" id="nombre">
	<input name="imagen" id="imagen">
</form>
<input id="print" type="button" value="Capturar"><br>
</div>
<script type="text/javascript" src="<?php echo SGA_COMUN_URL ?>/js/html2canvas.js"></script>
<script language="javascript">

$(document).bind('keypress', function(e) {
    if( e.which === 62 && e.shiftKey) {
capturar_pantalla(e);
}
});
function capturar_pantalla(e){
	e.preventDefault();
	html2canvas($("html"), {
		onrendered: function (canvas) {
			var myImage = canvas.toDataURL("image/png");
			document.getElementById('imagen').value=myImage;
			var nombre = "";
			nombre = prompt("Por favor ingrese un nombre", "modulo");
			document.getElementById('nombre').value=nombre;
			document.getElementById('formdata').submit();
			//window.open(myImage);
			//window.document.close(); // necessary for IE >= 10
			//window.focus(); // necessary for IE >= 10
			//window.print();
			//window.close();
			}
		});
}
</script>