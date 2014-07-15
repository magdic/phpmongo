<?
$mongo = new Mongo('mongodb://luisc:leidgam17@ds061258.mongolab.com:61258/peoplelbees'); // Inicializo la clase de Mongo
$database = $mongo->selectDB("peoplelbees"); //Selecciono la Base de Datos, si no existe la crea
$estudiante = $database->selectCollection('users'); // Selecciono la coleccion (tabla), y la asigno a un objeto

$accion = $_GET['accion'] ? $_GET['accion'] : 'index' ;
$id= $_GET['id'] ? $_GET['id'] : '';


if($accion == 'index') //Si la accion es index muestro listado de estudiantes
{
	$registros = $estudiante->find(); //Realizo una busqueda general de todos los registros y lo guardo en una variable
?>
<table>
<tr><td><a href="second.php?accion=agregar">Nuevo</a></td></tr>
</table>
<br />
<table border="1">
<tr>
    <td width="200px">Nombre</td><td width="200px">Apellido</td><td width="200px">Edad</td><td width="200px">Opciones</td>
</tr>
</table>
<table border="1">
<? foreach($registros as $row): //Itero para mostrar registros ?> 
<tr>
<td width="200px"><?php echo $row['nombre']; ?></td><td width="200px"><?php echo $row['apellido']; ?></td><td width="200px"><?php echo $row['edad']; ?></td>
<td width="97px"><a href="second.php?accion=editar&id=<?php echo $row['_id'] ?>">Editar</a></td>
<td width="97px"><a href="second.php?accion=eliminar&id=<?php echo $row['_id'] ?>">Eliminar</a></td>
</tr>
<?
endforeach;
?>
</table>
<?php

}
if($accion == 'agregar') // Si la accion es agregar
{
	if(isset($_POST['submit'])) //Si hace post de agregar
	{		
		$estu = array(
		'nombre'=>$_POST['nombre'],
		'apellido'=>$_POST['apellido'],
		'edad'=>$_POST['edad']
		);  //Se debe guardar los datos en forma de array indicando nombre de "campo" => "valor"
		$estudiante->insert($estu); //Luego insertar registro, puede ser simplificado creando el array dentro del insert
		echo"<script language='javascript'>window.location='second.php'</script>"; //Redireccion al index
	}
	else //Si no ha hecho el post de enviar muestro el formulario de ingreso de datos
	{
	 ?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'].'?accion=agregar' ?>" > <?php //con redireccion a la accion ?>
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
}
if($accion == 'editar') // Si la accion es editar
{
	if(isset($_POST['submit']))
	{
		$estudiante_id = new MongoId($_POST['_id']); //transformo el id del hidden en objecto id de mongo
		$filter = array('_id'=>$estudiante_id); //lo convierto en array "campo" => "id" para poder ejecutar
		$estu = array(
		'nombre'=>$_POST['nombre'],
		'apellido'=>$_POST['apellido'],
		'edad'=>$_POST['edad']
		); //creo el array con los nuevos valores en caso de que hallan cambiado
		$estudiante->update($filter,$estu); //actualizo con ambos arreglos

		echo"<script language='javascript'>window.location='second.php'</script>"; //redirecciono
	}
	else //Mientras no presione guardar muestro el formulario con los datos de la entidad
	{

	$estudiante_id = new MongoId($id); //el id que recibo para editar se debe convertir en un objecto id para mongo
	$registro = $estudiante->findone(array('_id'=>$estudiante_id)); //hago la busqueda para retornar un solo registro
	$nombre= $registro['nombre']; //Asigno los valores del registro a variables para mostrarlos luego en campos
	$apellido= $registro['apellido'];
	$edad= $registro['edad']; ?>
	
	<form method="post" action="<?php echo $_SERVER['PHP_SELF'].'?accion=editar' ?>" > <?php //si presiono editar redirecciono con accion editar para que entre en submit ?>
<div style="width:220px;background-color:#C90">
<table>
<tr>
    <td width="80px">Nombre:</td>
    <td><input type="text" id="nombre" name="nombre" value="<?php echo $nombre ?>" />
    <input type="hidden" id="_id" name="_id" value="<?php echo $estudiante_id ?>" /></td>
</tr>
<tr>
    <td width="80px">Apellido:</td>
    <td><input type="text" id="apellido" name="apellido"  value="<?php echo $apellido ?>" /></td>
</tr>
<tr>
    <td width="80px">Edad:</td>
    <td><input type="text" id="edad" name="edad" value="<?php echo $edad ?>"/></td>
</tr>
</table>
<br />
<center><input  type="submit" id="submit" name="submit" value="Guardar" /></center>
</div>
<br />
</form>
<?
	}
}
if($accion == 'eliminar')
{
	$estudiante_id = new MongoId($id); //transformo el id en objeto id de mongo
	$estudiante->remove(array('_id'=>$estudiante_id)); //mando a eliminar con el id de una vez

	echo"<script language='javascript'>window.location='second.php'</script>";

}