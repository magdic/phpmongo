<?php 

	$mongo = new Mongo('mongodb://luisc:leidgam17@ds061258.mongolab.com:61258/peoplelbees'); // Inicializo la clase de Mongo
	$database = $mongo->selectDB("peoplelbees"); //Selecciono la Base de Datos, si no existe la crea
?>