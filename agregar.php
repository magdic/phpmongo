<?php 

		include('conn.php');

		$estudiante = $database->selectCollection('users'); // Selecciono la coleccion (tabla), y la asigno a un objeto


		if(isset($_POST['submit'])) //Si hace post de agregar
			{		
				$estu = array(
				'nombre'=>$_POST['nombre'],
				'apellido'=>$_POST['apellido'],
				'edad'=>$_POST['edad']
				);  //Se debe guardar los datos en forma de array indicando nombre de "campo" => "valor"
				$estudiante->insert($estu); //Luego insertar registro, puede ser simplificado creando el array dentro del insert
				echo"<script language='javascript'>window.location='index.php'</script>"; //Redireccion al index
			}
			else //Si no ha hecho el post de enviar muestro el formulario de ingreso de datos
			{
	 ?>
	 <form method="post" action="agregar.php" > <!-- con redireccion a la accion  -->
	 	<div style="width:220px;background-color:#C90">
	 		<table>
	 			<tr>
	 				<td width="80px">Nombre:</td>
	 				<td><input type="text" id="nombre" name="nombre" /></td>
	 			</tr>
	 			<tr>
	 				<td width="80px">Apellido:</td>
	 				<td><input type="text" id="apellido" name="apellido" /></td>
	 			</tr>
	 			<tr>
	 				<td width="80px">Edad:</td>
	 				<td><input type="text" id="edad" name="edad" /></td>
	 			</tr>
	 		</table>
	 		<br />
	 		<center><input  type="submit" id="submit" name="submit" value="Guardar" /></center>
	 	</div>
	 	<br />
	 </form>
<?
	}